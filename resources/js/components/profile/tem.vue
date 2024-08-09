<template>
  <div :class="cardClass">
    <div class="card-header border-transparent">
      <h3 class="card-title">{{ title }}</h3>
      <div class="card-tools">
        <button type="button" class="btn btn-tool" data-card-widget="collapse" @click="toggleShowList">
          <i :class="ShowList ? 'fas fa-minus' : 'fas fa-plus'"></i>
        </button>
      </div>
    </div>

    <div v-if="ShowList">
      <div class="card-body p-0">
        <div class="table-responsive">
          <table class="table m-0">
            <thead>
              <tr>
                <th v-for="header in headers" :key="header">{{ header }}</th>
                <th></th>
              </tr>
            </thead>
            <tbody>
              <tr v-if="loading">
                <td colspan="100%">
                  <LoadingSpinner></LoadingSpinner>
                </td>
              </tr>
              <tr v-else v-for="item in paginatedItems" :key="item.id">
                <td v-for="field in fields" :key="field">{{ getItemField(item, field) || '-' }}</td>
                <td>
                  <div class="sparkbar" data-color="#00a65a" data-height="20">
                    {{ formatDate(item.created_at) }}
                  </div>
                </td>
                <td class="project-actions text-right">
                  <select 
                    v-if="title === 'Services'" 
                    :style="{ width: '41%', marginRight: '10px' }"
                    v-model="selectedEtatServices[item.id]" 
                    @change="fetchEtatService(item.id)"
                    class="form-control custom-select">
                    <option value="ACTIF">ACTIF</option>
                    <option value="INACTIF">INACTIF</option>
                  </select>

                  <div class="btn-group filter-btn-group">
                    <a class="btn btn-success btn-sm mr-2" @click="view(item)">
                      <i class="fas fa-eye"></i>
                    </a>
                    <a class="btn btn-info btn-sm mr-2" @click="toggleOptions(item.id)">
                      <i class="fas fa-edit"></i>
                    </a>
                    <div v-if="showOptions[item.id]" style="margin-top: -84%;margin-right: 50%;" class="dropdown-menu dropdown-menu-right show">
                      <a @click.prevent="editItem(item.id,this.title==='Services'? item.agence_id:0)" href="#" class="dropdown-item">Edit</a>
                      <a @click.prevent="deleteItem(item.id, item.nom)" href="#" class="dropdown-item text-danger">Supprimer</a>
                    </div>
                  </div>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
      <div class="card-footer clearfix">
        <button class="btn btn-sm btn-success float-left" @click="prevPage" :disabled="currentPage === 1">Précédent</button>
        <button class="btn btn-sm btn-success float-right" @click="nextPage" :disabled="currentPage >= totalPages">Suivant</button>
      </div>
    </div>
  </div>
</template>

<script>
import axios from 'axios';

export default {
  name: 'ReusableList',
  props: {
    title: {
      type: String,
      required: true,
    },
    fetchUrl: {
      type: String,
      required: true,
    },
    headers: {
      type: Array,
      required: true,
    },
    fields: {
      type: Array,
      required: true,
    },
    cardClass: {
      type: String,
      default: 'card card-primary',
    },
    role: {
      type: String,
      default: '',
    },
    user_id: {
      type: Number,
      default: 0,
    },
    data1: {
      type: Object,
      default: () => ({}),
    },
  },
  data() {
    return {
      ShowList: true,
      items: [],
      currentPage: 1,
      pageSize: 4,
      showOptions: {},
      selectedEtatServices: {},
      loading: true,
    };
  },
  computed: {
    totalPages() {
      return Math.ceil(this.items.length / this.pageSize);
    },
    paginatedItems() {
      const start = (this.currentPage - 1) * this.pageSize;
      return this.items.slice(start, start + this.pageSize);
    },
  },
  methods: {
    toggleShowList() {
      this.ShowList = !this.ShowList;
    },
    async fetchEtatService(serviceId) {
      try {
        const url = `/service/${serviceId}/etat`;
        const response = await axios.get(url);
        this.$set(this.selectedEtatServices, serviceId, response.data.etat || 'ACTIF');
      } catch (error) {
        console.error('Failed to fetch service state:', error);
      }
    },
    async view(item) {
      const { id, agence } = item;
      const id2 = agence ? agence.id : 0;
      const url = this.title === 'Agents' ? 'profile' : 'dashboard';
      const param = this.title === 'Agents' 
        ? { role: 'AGENT', profile_id: id }
        : { agence_id: id, service_id: id2 };

      try {
        await this.$router.push({ name: url, params: param });
      } catch (err) {
        console.error('Navigation error:', err);
      }
    },
    async getItems(req=1) {
      try {
        if (this.title === 'Agences') {
          if (Object.keys(this.data1).length > 0) {
            this.items = Object.values(this.data1);
          } else {
            const cachedAgences = localStorage.getItem('Agences');
            if (cachedAgences) {
              this.items = JSON.parse(cachedAgences);
            } else {
              const response = await axios.get('/agencies', {
                headers: {
                  'Authorization': `Bearer ${localStorage.getItem('token')}`
                }
              });
              this.items = response.data;
              localStorage.setItem('Agences', JSON.stringify(response.data));
              this.initializeShowOptions();
            }
          }
        } else {
          if (Object.keys(this.data1).length > 0) {
            this.items = Object.values(this.data1);
          } else {
            const url = this.isAgentService ? `${this.fetchUrl}/${this.user_id}` : this.fetchUrl;
            const { data } = await axios.get(url);
            if(this.title==='Agents'){
              this.items = data.filter(item=>item.role==='AGENT');  
            }
            else this.items = data;
            this.initializeShowOptions();
          }
        }
      } catch (error) {
        console.error('Failed to fetch items:', error);
      } finally {
        this.loading = false;
        if(req){
          this.currentPage = 1;
        }
      }
    },
    initializeShowOptions() {
      this.showOptions = this.items.reduce((options, item) => {
        options[item.id] = false;
        if (this.title === 'Services') {
          this.selectedEtatServices[item.id] = item.etat || 'ACTIF';
        }
        return options;
      }, {});
    },
    formatDate(date) {
      return new Date(date).toLocaleDateString();
    },
    toggleOptions(id) {
      this.showOptions[id] = !this.showOptions[id];
      Object.keys(this.showOptions).forEach(key => {
        // If the key is different from the id, set it to false
        if (key !== id.toString()) {
          this.showOptions[key] = false;
        }
      });

  // Toggle the option for the selected id
  
}
,

    editItem(id,id2) {
      if(this.title==='Agences'){
        this.$router.push({ name: 'edit-agency', params: { agence: id } });
      }
      if(this.title==='Services'){
        this.$router.push({ name: 'edit-service', params: { service: id,agence:id2 } });
      }
      if(this.title==='Agents'){
        this.$router.push({ name: 'edit-agent', params: { agent: id,role2:'AGENT'} });
      }
    },
    async deleteItem(id, nom) {
      if (confirm(`Type OK to delete item ${nom}?`)) {
        try {
          await axios.delete(`${this.fetchUrl}/${id}`);
          console.log("Item deleted");
          await this.getItems();
          this.$emit('deleteItem');
        } catch (error) {
          console.error("Failed to delete item:", error);
        }
      }
    },
    nextPage() {
      if (this.currentPage < this.totalPages) {
        this.currentPage++;
      }
    },
    prevPage() {
      if (this.currentPage > 1) {
        this.currentPage--;
      }
    },
    getItemField(item, field) {
      return field.split('.').reduce((obj, key) => obj && obj[key], item);
    },
  },
  mounted() {
    this.getItems();
    this.updateInterval = setInterval(this.getItems(0), 10000);
  },
  beforeDestroy() {
    clearInterval(this.updateInterval);
  },
  watch: {
    user_id: 'getItems',
  },
};
</script>

<style scoped>
.card-header {
  background-color: #f8f9fa;
  border-bottom: 1px solid #dee2e6;
}

.custom-select {
  background-color: #ffffff;
  color: #495057;
  border: 1px solid #ced4da;
  border-radius: 0.25rem;
  height: calc(1.5em + 0.75rem + 2px); /* Adjust height to align with other form controls */
  line-height: 1.5;
}

.btn-group {
  margin-right: 0.5rem;
}

.dropdown-menu {
  margin-top: 0;
}

button:disabled {
  background-color: grey;
  cursor: not-allowed;
  border-color: grey;
}
</style>
