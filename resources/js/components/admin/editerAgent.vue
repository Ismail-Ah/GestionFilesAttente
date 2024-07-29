<template>
    <div class="card card-warning">
      <div class="card-header">
        <h3 class="card-title">Modifier Agent</h3>
        <div class="card-tools">
          <button type="button" class="btn btn-tool btn-danger bg-danger" data-card-widget="collapse" @click="deleteItem">
            <i class="fas fa-trash"></i> Supprimer Agent
          </button>
        </div>
      </div>
  
      <form @submit.prevent="updateAgent">
        <div class="card-body">
          <div class="form-group">
            <label for="nom">Nom :</label>
            <input class="form-control" type="text" id="nom" v-model="nom" required />
          </div>
  
          <div class="form-group">
            <label for="email">Email:</label>
            <input class="form-control" type="email" id="email" v-model="email" required />
          </div>
  
          <div class="form-group">
            <label for="agence">Agence:</label>
            <select class="form-control" id="agence" v-model="selectedAgence" @change="fetchServices" >
              <option value="">Agence</option>
              <option v-for="agence in agencies" :key="agence.id" :value="agence.id">{{ agence.nom }} - {{ agence.adress }}</option>
            </select>
          </div>
  
          <div class="form-group">
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
        </div>
  
        <div class="card-footer" style="display:flex;justify-content: center;">
          <button type="submit" class="btn btn-primary">Submit</button>
        </div>
      </form>
    </div>
  </template>
  
  <script>
  import axios from 'axios';
  import VueSelect from 'vue-select';
import 'vue-select/dist/vue-select.css'; // Ensure default styles are included
  export default {
    name: 'EditerAgent',
    components:{VueSelect},
    props: {
      agent: {
        type: Object,
        required: true
      }
    },
    data() {
      return {
        nom: '',
        email: '',
        selectedAgence: '',
        selectedServices: [],
        agencies: [],
        services: []
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
          if (agent.agence) {
            this.selectedAgence = agent.agence.id || '';
          } else {
            this.selectedAgence = '';
          }
          if (Array.isArray(agent.services)) {
            this.selectedServices = agent.services.map(service => service.id);
          }
          console.log(agent);
          if (this.selectedAgence) {
            this.fetchServices();
          }
      },

      deleteItem() {
        let id = this.agent.id;
        let choix = confirm(`Tapez ok pour supprimer cette agent?`);
        if (choix) {
          axios.delete(`api/agents/${id}`).then(response => {
            console.log("L'agent a été supprimé");
            this.$router.go(-1);
          }).catch(error => {
            console.error("Erreur");
          });
        }
      },
      fetchAgencies() {
        axios.get('/agencies')
          .then(response => {
            this.agencies = response.data;
          })
          .catch(error => {
            console.error('Error fetching agencies:', error);
          });
      },
      fetchServices() {
        if (this.selectedAgence) {
          axios.get(`/agence/${this.selectedAgence}/services`)
            .then(response => {
              this.services = response.data.map(service => ({
              id: service.id,
              nom: service.nom,
            }));
            })
            .catch(error => {
              console.error('Error fetching services:', error);
            });
        } else {
          this.services = [];
        }
      },

      updateAgent() {
  // Construct data object
  const data = {
    nom: this.nom,
    email: this.email,
    agence_id: this.selectedAgence,
    service_ids: this.selectedServices.map(service => parseInt(service, 10))
  };
  console.log(data);

  axios.post(`/agents/${this.agent.id}/update`, data)
    .then(response => {
      alert(response.data.message);
      this.$router.go(-1);
    })
    .catch(error => {
      // Check if the error response contains validation errors
      if (error.response && error.response.status === 422) {
        const errors = error.response.data.errors;
        // Handle or display validation errors
        console.error('Validation errors:', errors);
      } else {
        console.error('Error updating agent:', error);
      }
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
  /* Add any additional styles if needed */
  </style>
  