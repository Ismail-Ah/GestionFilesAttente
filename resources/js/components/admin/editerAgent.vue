<template>
  <div class="card card-warning">
    <div class="card-header">
      <h3 class="card-title">Editer Utilisateur</h3>
      <div class="card-tools">
        <button v-if="(role==='ADMINISTRATION' && agent.role!='ADMINISTRATION') || (role==='ADMIN') && (role!='AGENT')"
          type="button"
          class="btn btn-tool btn-danger bg-danger"
          data-card-widget="collapse"
          @click="deleteItem"
        >
          <i class="fas fa-trash"></i> Supprimer Utilistaeur
        </button>
      </div>
    </div>

    <form @submit.prevent="updateAgent" class="form-container">
      <div v-if="loading" class="spinner-wrapper">
        <LoadingSpinner3 />
      </div>
      <div class="card-body">
        <div class="form-group">
          <label for="nom">Nom :</label>
          <input
            class="form-control"
            type="text"
            id="nom"
            v-model="nom"
            required
          />
        </div>

        <div class="form-group">
          <label for="email">Email:</label>
          <input
            class="form-control"
            type="email"
            id="email"
            v-model="email"
            required
          />
        </div>

        <div class="form-group">
          <label for="agence">Role:</label>
          <select
            class="form-control"
            id="agence"
            v-model="role1"

          >
            <option value="AGENT">AGENT</option>
            <option value="ADMINISTRATION">ADMINISTRATEUR</option>
          </select>
        </div>

        <div v-if="role1==='AGENT'" class="form-group">
          <label for="agence">Agence:</label>
          <select
            class="form-control"
            id="agence"
            v-model="selectedAgence"
            @change="fetchServices"
          >
            <option value="">Agence</option>
            <option
              v-for="agence in agencies"
              :key="agence.id"
              :value="agence.id"
            >
              {{ agence.nom }} - {{ agence.adress }}
            </option>
          </select>
        </div>

        <div v-if="role1==='AGENT'" class="form-group">
          <label for="services">Services:</label>
          <vue-select
            :options="services"
            label="nom"
            :multiple="true"
            v-model="selectedServices"
            class="custom-vue-select"
            :reduce="option => option.id"
          ></vue-select>
        </div>

        <div style="display: flex; justify-content: center; align-items: center; width:100%;height: 100%;">
  <p v-if="errorMessage" style="color: red; text-align: center; margin: 0; padding: 10px;" class="alert shadow-sm">{{ errorMessage }}</p>
</div>

      </div>

      <div class="card-footer">
        <button type="submit" class="btn btn-primary">Submit</button>
      </div>
    </form>
  </div>
</template>

<script>
import axios from 'axios';
import VueSelect from 'vue-select';
import 'vue-select/dist/vue-select.css'; // Ensure default styles are included
import LoadingSpinner3 from '../LoadingSpinner3.vue'; // Import your spinner component

export default {
  name: 'EditerAgent',
  components: { VueSelect, LoadingSpinner3 },
  props: {
    role:String,
    agent: {
      type: Object,
      required: true
    }
  },
  data() {
    return {
      nom: '',
      email: '',
      role1:'',
      selectedAgence: '',
      selectedServices: [],
      agencies: [],
      services: [],
      loading: false, // Track loading state
      errorMessage: '' // Error message state
    };
  },
  watch: {
    agent: {
      immediate: true,
      handler(newAgent) {
        this.initializeAgentData(newAgent);
      }
    }
  },
  methods: {
    initializeAgentData(agent) {
      this.nom = agent.nom || '';
      this.email = agent.email || '';
      this.role1 = agent.role || '';
      this.selectedAgence = agent.agence ? agent.agence.id : '';
      this.selectedServices = Array.isArray(agent.services) ? agent.services.map(service => service.id) : [];
      if (this.selectedAgence) {
        this.fetchServices();
      }
    },

    deleteItem() {
      const id = this.agent.id;
      const choix = confirm('Tapez ok pour supprimer cet agent?');
      if (choix) {
        axios.delete(`api/agents/${id}`).then(response => {
          console.log("L'agent a été supprimé");
          this.$router.go(-1);
        }).catch(error => {
          console.error("Erreur lors de la suppression de l'agent:", error);
        });
      }
    },
    fetchAgencies() {
      const cachedAgences = localStorage.getItem('Agences');
      if (cachedAgences) {
        this.agencies = JSON.parse(cachedAgences);
      } else {
        axios.get('/agencies', {
          headers: {
            'Authorization': `Bearer ${localStorage.getItem('token')}`
          }
        })
        .then(response => {
          this.agencies = response.data;
          localStorage.setItem('Agences', JSON.stringify(response.data));
          this.initializeSelections();
          this.loading = false;
        })
        .catch(error => {
          console.error('Error fetching agencies:', error);
        });
      }
    },
    fetchServices() {
      if (this.selectedAgence) {
        const cachedServices = localStorage.getItem(`Agence${this.selectedAgence}Services`);
        if (cachedServices) {
          this.services = JSON.parse(cachedServices).map(service => ({
            id: service.id,
            nom: service.nom
          }));
        } else {
          axios.get(`/agence/${this.selectedAgence}/services`)
            .then(response => {
              this.services = response.data.map(service => ({
                id: service.id,
                nom: service.nom
              }));
              localStorage.setItem(`Agence${this.selectedAgence}Services`, JSON.stringify(response.data));
            })
            .catch(error => {
              console.error('Error fetching services:', error);
            });
        }
      } else {
        this.services = [];
      }
    },

    updateAgent() {
      this.loading = true; // Show spinner
      const data = {
        nom: this.nom,
        email: this.email,
        role:this.role1,
        
        agence_id: this.selectedAgence,
        service_ids: this.selectedServices.map(service => parseInt(service, 10))
      };

      axios.post(`/agents/${this.agent.id}/update`, data)
        .then(response => {
          localStorage.removeItem(`user_info_${this.agent.id}`);
          alert(response.data.message);
          this.$router.go(-1);
        })
        .catch(error => {
          if (error.response && error.response.status === 422) {
            this.errorMessage = Object.values(error.response.data.errors).flat().join(', ');
          } else {
            this.errorMessage = error.message;
          }
        })
        .finally(() => {
          this.loading = false; // Hide spinner
        });
    }
  },
  created() {
    this.initializeAgentData(this.agent);
    this.fetchAgencies();
  }
};
</script>

<style scoped>
.form-container {
  position: relative; /* To position the spinner absolutely within the form */
}

.spinner-wrapper {
  display: flex;
  justify-content: center;
  align-items: center;
  position: absolute;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
  width: 100%;
  height: 100%;
  background-color: rgba(255, 255, 255, 0.8); /* Optional: to give a background overlay */
  z-index: 1000; /* Ensure it appears above other content */
}


</style>
