<template>
  <PageContent activeItem1="Agents" :role="role">
    <div class="wrapper">
      <div class="content-header">
        <div style="margin: auto; width: 50%;">
          <div class="card card-primary">
            <div class="card-header">
              <h3 class="card-title">Ajouter une nouvelle Utilisateur</h3>
            </div>
            <form @submit.prevent="createAgent" class="form-container">
              <div v-if="loading" class="spinner-wrapper">
                <LoadingSpinner3 />
              </div>
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
                  <label for="password">Password:</label>
                  <input class="form-control" type="password" id="password" v-model="password" required />
                </div>
                <div class="form-group">
                  <label for="role1">Role:</label>
                  <select class="form-control" id="agence" v-model="role1" @change="fetchRole" required>
                    <option value="AGENT">AGENT</option>
                    <option value="ADMINISTRATION">ADMINISTRATEUR</option>
                  </select>
                </div>

                <div v-if="showAgenceService">
                  <div class="form-group">
                  <label for="agence">Agence:</label>
                  <select class="form-control" id="agence" v-model="selectedAgence" @change="fetchServices" >
                    <option v-for="agence in agencies" :key="agence.id" :value="agence.id">
                      {{ agence.nom }} - {{ agence.adress }}
                    </option>
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
                  ></vue-select>
                </div>
                </div>

                
                <div style="display: flex; justify-content: center; align-items: center; width:100%;height: 100%;">
  <p v-if="errorMessage" style="color: red; text-align: center; margin: 0; padding: 10px;" class="alert shadow-sm">{{ errorMessage }}</p>
</div>
              </div>
              <div class="card-footer" style="display: flex; flex-direction: column; align-items: center;">

                <button type="submit" class="btn btn-primary">Submit</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </PageContent>
</template>

<script>
import axios from 'axios';
import PageContent from '../layout/PageContent.vue';
import VueSelect from 'vue-select';
import 'vue-select/dist/vue-select.css'; // Ensure default styles are included
import LoadingSpinner3 from '../LoadingSpinner3.vue'; // Import your spinner component

export default {
  name: 'CreateAgentAcount',
  components: { PageContent, VueSelect, LoadingSpinner3 },
  props:{
    role:String,
  },
  data() {
    return {
      nom: '',
      email: '',
      password: '',
      role1:'AGENT',
      selectedAgence: '',
      selectedServices: [],
      agencies: [],
      services: [],
      loading: false, // Track loading state
      errorMessage: '',
      showAgenceService:true,
    };
  },
  methods: {
    fetchRole(){
      this.showAgenceService=!this.showAgenceService;
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
        axios.get(`/agence/${this.selectedAgence}/services`)
          .then(response => {
            this.services = response.data;
          })
          .catch(error => {
            console.error('Error fetching services:', error);
          });
      } else {
        this.services = [];
      }
    },
    createAgent() {
      this.loading = true; // Show spinner
      const agentData = {
        nom: this.nom,
        email: this.email,
        password: this.password,
        agence_id: this.selectedAgence,
        service_ids: this.selectedServices.map(service => parseInt(service.id, 10)),
        role:this.role1,
      };

      axios.post('/create-agent-acount', agentData)
        .then(response => {
          alert('Compte utilisateur créé avec succès !');
          this.nom = '';
          this.email = '';
          this.password = '';
          this.selectedAgence = '';
          this.selectedServices = [];
          this.$router.push('/dashboard');
        })
        .catch(error => {
          if (error.response && error.response.data && error.response.data.errors) {
            this.errorMessage = Object.values(error.response.data.errors).flat().join(', ');
          } else {
            this.errorMessage = error.message;
          }
        })
        .finally(() => {
          this.loading = false; // Hide spinner
        });
    },
  },
  created() {
    this.fetchAgencies();
  },
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
