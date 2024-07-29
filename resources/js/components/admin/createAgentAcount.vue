<template>
  <PageContent>
    <div class="wrapper">
      <div class="content-header">
        <div style="margin: auto;width: 50%;">
      <div class="card card-primary">
        <div class="card-header">
          <h3 class="card-title">Ajouter une nouvelle Agent</h3>
        </div>
        <form @submit.prevent="createAgent">
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
              <label for="agence">Agence:</label>
              <select class="form-control" id="agence" v-model="selectedAgence" @change="fetchServices" required>
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
          <div class="card-footer">
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

export default {
  name: 'CreateAgentAcount',
  components: { PageContent, VueSelect },
  data() {
    return {
      nom: '',
      email: '',
      password: '',
      selectedAgence: '',
      selectedServices: [],
      agencies: [],
      services: [],
    };
  },
  methods: {
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
      const agentData = {
        nom: this.nom,
        email: this.email,
        password: this.password,
        agence_id: this.selectedAgence,
        service_ids: this.selectedServices.map(service => parseInt(service.id, 10)),
      };

      axios.post('/create-agent-acount', agentData)
        .then(response => {
          alert('Agent account created successfully!');
          this.nom = '';
          this.email = '';
          this.password = '';
          this.selectedAgence = '';
          this.selectedServices = [];
          this.$router.push('/dashboard');
        })
        .catch(error => {
          if (error.response && error.response.data && error.response.data.errors) {
            console.error('Validation errors:', error.response.data.errors);
          } else {
            console.error('Error updating service:', error.message);
          }
        });
    },
  },
  created() {
    this.fetchAgencies();
  },
};
</script>


<style scoped>

</style>
