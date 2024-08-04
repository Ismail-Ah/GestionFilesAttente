<template>
  <div v-if="loading1">
         <LoadingSpinner></LoadingSpinner>
       </div>
 <div v-else>
   <PageContent activeItem1="dashboard" :role="role">
     <div class="wrapper">
       <div class="content-header">
         <div class="row">
           <div class="col-sm-6 choix">
             <div class="form-group">
               <label>Sélectionner Agence</label>
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
               <label>Sélectionner Service</label>
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
import VueSelect from 'vue-select';
import 'vue-select/dist/vue-select.css';
import LoadingSpinner from '../LoadingSpinner.vue';

export default {
  name: 'Dashboard',
  components: { PageContent, StatBox, StatTickets, VueSelect,LoadingSpinner },
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
      loading1:true,
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
          this.initializeSelections();
          this.loading = false;
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
     
    },
    fetchLoading1(){
      this.loading1=false;
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
    },
    role(newValue){
      if(newValue){
        this.fetchLoading1();
      }
    }
  },
  created() {
    this.fetchAgencies();
    if (this.role){
      this.fetchLoading1();
    }
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
.choix{
  margin-top:-10px;
}
</style>
