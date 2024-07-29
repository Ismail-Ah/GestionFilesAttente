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
                <tr v-for="item in items.data" :key="item.id">
                  <td v-for="field in fields" :key="field">{{ getItemField(item, field) || '-' }}</td>
                  <td>
                    <div class="sparkbar" data-color="#00a65a" data-height="20">
                      {{ formatDate(item.created_at) }}
                    </div>
                  </td>
                  <td class="project-actions text-right">
                    <div class="btn-group filter-btn-group">
                      <a class="btn btn-info btn-sm mr-2" @click="toggleOptions(item.id)">
                        <i class="fas fa-edit"></i>
                      </a>
                      <div v-if="showOptions[item.id]" class="dropdown-menu dropdown-menu-right show" style="margin-top: -70px;margin-right: 40px;">
                        <a @click.prevent="editItem(item.id, item.nom)" href="#" class="dropdown-item">Edit</a>
                        <a @click.prevent="deleteItem(item.id, item.nom)" href="#" class="dropdown-item" style="color:red;">Supprimer</a>
                      </div>
                    </div>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
        <div class="card-footer clearfix">
          <button class="btn btn-sm btn-success float-left" @click="prevPage" :disabled="!items.prev_page_url">Previous</button>
          <button class="btn btn-sm btn-success float-right" @click="nextPage" :disabled="!items.next_page_url">Next</button>
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
        default: 'card card-primary'
      }
    },
    data() {
      return {
        ShowList: true,
        items: {
          data: [],
          current_page: 1,
          prev_page_url: null,
          next_page_url: null,
        },
        showOptions: {},
      };
    },
    methods: {
      toggleShowList() {
        this.ShowList = !this.ShowList;
      },
      async getItems(page = 1) {
        try {
          const response = await axios.get(`${this.fetchUrl}?page=${page}`);
          this.items = response.data;
          this.initializeShowOptions();
        } catch (error) {
          console.error('Erreur lors de la récupération des éléments:', error);
        }
      },
      initializeShowOptions() {
        this.showOptions = this.items.data.reduce((options, item) => {
          options[item.id] = false;
          return options;
        }, {});
      },
      formatDate(date) {
        const date1 = new Date(date);
        return date1.toLocaleDateString();
      },
      toggleOptions(id) {
        this.showOptions[id] = !this.showOptions[id];
      },
      editItem(id) {
        console.log(`Editing item with ID: ${id}`);
      },
      deleteItem(id, nom) {
        this.showOptions[id] = false;
        let choix = confirm(`Tapez ok pour supprimer l'élément ${nom} ?`);
        if (choix) {
          axios.delete(`${this.fetchUrl}/${id}`).then(response => {
            console.log("L'élément a été supprimé");
            this.getItems(this.items.current_page);
            this.$emit('deletItem');
          }).catch(error => {
            console.error("Erreur");
          });
        }
      },
      nextPage() {
        if (this.items.next_page_url) {
          this.getItems(this.items.current_page + 1);
        }
      },
      prevPage() {
        if (this.items.prev_page_url) {
          this.getItems(this.items.current_page - 1);
        }
      },
      getItemField(item, field) {
        return field.split('.').reduce((obj, key) => obj && obj[key], item);
      }
    },
    created() {
      this.getItems();
      this.interval = setInterval(() => this.getItems(), 10000);
    },
    beforeDestroy() {
      clearInterval(this.interval);
    },
  };
  </script>
  
  <style scoped>
  .filter-btn-group {
    margin-right: 1rem;
  }
  </style>
  