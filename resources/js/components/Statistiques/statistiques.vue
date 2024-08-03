<template>
  
  <div >
    <PageContent :role="role">
      <div v-if="loading">
      <LoadingSpinner></LoadingSpinner>
    </div>
      <div v-else class="wrapper">
        <div class="content-header d-flex justify-content-end">
          <div class="btn-group filter-btn-group">
            <button type="button" class="btn btn-tool dropdown-toggle" @click="toggleFilters">
              {{ calender }} <i class="fas fa-calendar"></i>
            </button>
            <div v-if="showFilters" class="dropdown-menu dropdown-menu-right show">
              <a @click.prevent="filter(1)" href="#" class="dropdown-item">Aujourd'hui</a>
              <a @click.prevent="filter(7)" href="#" class="dropdown-item">Cette semaine</a>
              <a @click.prevent="filter(30)" href="#" class="dropdown-item">Ce mois</a>
              <a @click.prevent="filter(365)" href="#" class="dropdown-item">Cette année</a>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-sm-6">
            <div class="form-group">
              <label>Select Agence</label>
              <div class="position-relative d-flex align-items-center">
                <select class="form-control" v-model="selectedAgence" @change="fetchServices">
                  <option value="">Agence</option>
                  <option v-for="agence in agencies" :key="agence.id" :value="agence.id">{{ agence.nom }} - {{ agence.adress }}</option>
                </select>
                <div v-if="role !== 'AGENT'" class="btn-group btn-group-sm ml-1 add-agence-indicator">
                  <button type="button" class="btn btn-info" @click="$router.push('ajouter-agence')">
                    <i class="fas fa-plus"></i>
                  </button>                  
                </div>
              </div>
            </div>
          </div>
          <div class="col-sm-6">
            <div class="form-group">
              <label>Select Service</label>
              <div class="position-relative d-flex align-items-center">
                <select class="form-control" :disabled="!selectedAgence" v-model="selectedService">
                  <option value="">Service</option>
                  <option v-for="service in services" :key="service.id" :value="service.id">{{ service.nom }}</option>
                </select>
                <div v-if="role !== 'AGENT'" class="btn-group btn-group-sm ml-1 add-agence-indicator">
                  <button type="button" class="btn btn-info" :disabled="!selectedAgence" @click="$router.push(`/agence/${selectedAgence}/ajouter-service`)">
                    <i class="fas fa-plus"></i>
                  </button>
                </div>
              </div>
            </div>
          </div>
        </div>
        <section class="content">
          <div class="container-fluid">
            
            <LineChartStat :timeFilter="timeFilter" :name="name" :name_id="name_id"></LineChartStat>          
          </div>
        </section>
      </div>
    </PageContent>
  </div>
</template>

<script>
import PageContent from '../layout/PageContent.vue';
import StatBox from '../dashboard/StatBox.vue';
import axios from 'axios';
import LoadingSpinner from '../LoadingSpinner.vue';
import LineChartStat from './LineChartStat.vue';

export default {
  name: 'Statistiques',
  components: {  LineChartStat, PageContent, StatBox, LoadingSpinner },
  props: {
    role: {
      type: String,
      required: true
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
      showFilters: false,
      timeFilter: 30,
      calender:'Dérniere Mois',
    };
  },
  methods: {
    toggleFilters() {
      this.showFilters = !this.showFilters;
    },
    fetchAgencies() {
      axios.get('/agencies')
        .then(response => {
          this.agencies = response.data;
          this.loading = false;
        })
        .catch(error => {
          console.error('Error fetching agencies:', error);
        });
    },
    fetchServices() {
      if (this.selectedAgence) {
        axios.get(`/agence/${this.selectedAgence}`)
          .then(response => {
            this.services = response.data;
            this.selectedService = ''; // Reset selectedService when agence changes
          })
          .catch(error => {
            console.error('Error fetching services:', error);
          });
      } else {
        this.services = [];
      }
    },
    filter(type) {
      this.timeFilter = type;
      this.showFilters =!this.showFilters;
      if (type==1) this.calender="Aujord'hui";
      if (type==7) this.calender="Dérnière Semaine";
      if (type==30) this.calender="Dérnière Mois";
      if (type==365) this.calender="Dérnière Année";
    }
  },
  watch: {
    selectedAgence(newValue) {
      if (newValue) {
        this.name = 'agence';
        this.name_id = newValue;
      } else {
        this.name = 'agencies';
        this.name_id = '';
      }
    },
    selectedService(newValue) {
      if (newValue) {
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
    },
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

.filter-btn-group {
  margin-right: 1rem;
}
</style>
