<template>
  <div>
    <PageContent :role="role">
      <div class="wrapper">
        <div class="content-header">
          <div class="row">
            <i class="nav-icon fas fa-cog" style="display:flex;justify-content: flex-end;"></i>
            <div class="col-sm-6 choix">
              <div class="form-group">
                <label>Select Agence</label>
                <div class="position-relative d-flex align-items-center">
                  <select class="form-control" v-model="selectedAgence" @change="fetchServices">
                    <option value="">Agence</option>
                    <option v-for="agence in agencies" :key="agence.id" :value="agence.id">{{ agence.nom }} - {{ agence.adress }}</option>
                  </select>
                  <div v-if="role != 'AGENT'" class="btn-group btn-group-sm ml-1 add-agence-indicator">
                    <button type="button" class="btn btn-info" @click="$router.push('ajouter-agence')">
                      <i class="fas fa-plus"></i>
                    </button>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-sm-6 choix">
              <div class="form-group">
                <label>Select Service</label>
                <div class="position-relative d-flex align-items-center">
                  <select class="form-control" :disabled="!selectedAgence" v-model="selectedService">
                    <option value="">Service</option>
                    <option v-for="service in services" :key="service.id" :value="service.id">{{ service.nom }}</option>
                  </select>
                  <div v-if="role != 'AGENT'" class="btn-group btn-group-sm ml-1 add-agence-indicator">
                    <button type="button" class="btn btn-info" :disabled="!selectedAgence" @click="$router.push(`/agence/${selectedAgence}/ajouter-service`)">
                      <i class="fas fa-plus"></i>
                    </button>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <section class="content">
          <div class="container-fluid">
            <StatBox :name="name" :name_id="name_id"></StatBox>
            <StatTickets :name="name" :name_id="name_id"></StatTickets>
          </div>
        </section>
      </div>
    </PageContent>
  </div>
</template>

<script>
import PageContent from '../layout/PageContent.vue';
import StatBox from './StatBox.vue';
import axios from 'axios';
import StatTickets from './StatTickets.vue';
import LoadingSpinner from '../LoadingSpinner.vue';
import VueSelect from 'vue-select';
import 'vue-select/dist/vue-select.css';

export default {
  name: 'Dashboard',
  components: { PageContent, StatBox, StatTickets, LoadingSpinner, VueSelect },
  props: {
    role: {
      type: String,
      required: true
    },
    agence_id: {
      type: Number,
      default: 0
    },
    service_id: {
      type: Number,
      default: 0
    }
  },
  data() {
    return {
      name: 'agencies',
      name_id: '',
      selectedAgence: '',
      selectedService: '',
      agencies: [],
      services: [],
      loading: true,
    };
  },
  methods: {
    fetchAgencies() {
      axios.get('/agencies', {
        headers: {
          'Authorization': `Bearer ${localStorage.getItem('token')}`
        }
      })
        .then(response => {
          this.agencies = response.data;
          this.loading = false;
          this.initializeSelections();
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
            if (this.service_id) {
              this.selectedService = this.service_id;
            } else {
              this.selectedService = null;
            }
          })
          .catch(error => {
            console.error('Error fetching services:', error);
          });
      } else {
        this.services = [];
      }
    },
    initializeSelections() {
      if (this.agence_id) {
        this.selectedAgence = this.agence_id;
        this.fetchServices(); // Fetch services based on the selected agency
      }
     
    }
  },
  watch: {
    selectedAgence(newValue) {
      if (newValue) {
        this.name = 'agence';
        this.name_id = newValue;
        this.fetchServices();
      } else {
        this.name = 'agencies';
        this.name_id = '';
        this.services = [];
      }
    },
    selectedService(newValue) {
      if (newValue && newValue!='') {
        this.name = 'service';
        this.name_id = newValue;
      } else {
        if (this.selectedAgence) {
          this.name = 'agence';
          this.name_id = this.selectedAgence;
        } else {
          this.name = 'agencies';
          this.name_id = '';
        }
      }
    }
  },
  created() {
    this.fetchAgencies();
  },
};
</script>

<style scoped>
.btn-group-sm .btn {
  height: calc(100% - 2px); /* Adjust as needed */
}

.btn-group-sm .btn i {
  font-size: 1rem; /* Adjust icon size as needed */
}
.add-agence-indicator {
  position: absolute;
  top: 50%;
  right: 10px; /* Adjust as needed */
  transform: translateY(-50%);
  color: #007bff; /* Example color */
  cursor: pointer; /* Optionally show pointer cursor */
}

.spinner-wrapper {
  position: fixed;
  z-index: 999999;
  top: 0;
  right: 0;
  bottom: 0;
  left: 0;
  background: #fff;
}

.spinner {
  position: absolute;
  top: 50%; /* centers the loading animation vertically on the screen */
  left: 50%; /* centers the loading animation horizontally on the screen */
  width: 3.75rem;
  height: 1.25rem;
  margin: -0.625rem 0 0 -1.875rem; /* is width and height divided by two */ 
  text-align: center;
}

.spinner > div {
  display: inline-block;
  width: 1rem;
  height: 1rem;
  border-radius: 100%;
  background-color: #5f4dee;
  -webkit-animation: sk-bouncedelay 1.4s infinite ease-in-out both;
  animation: sk-bouncedelay 1.4s infinite ease-in-out both;
}

.spinner .bounce1 {
  -webkit-animation-delay: -0.32s;
  animation-delay: -0.32s;
}

.spinner .bounce2 {
  -webkit-animation-delay: -0.16s;
  animation-delay: -0.16s;
}

@-webkit-keyframes sk-bouncedelay {
  0%, 80%, 100% { -webkit-transform: scale(0); }
  40% { -webkit-transform: scale(1.0); }
}

@keyframes sk-bouncedelay {
  0%, 80%, 100% { 
    -webkit-transform: scale(0);
    -ms-transform: scale(0);
    transform: scale(0);
  } 40% { 
    -webkit-transform: scale(1.0);
    -ms-transform: scale(1.0);
    transform: scale(1.0);
  }
}
.choix{
  margin-top:-10px;
}
</style>
