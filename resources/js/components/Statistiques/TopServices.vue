<template>

        <div class="card">
          <div class="card-header">
            <h5 class="card-title">Top Services</h5>
            <div class="card-tools">
              <div class="btn-group">
                <button type="button" class="btn btn-tool dropdown-toggle" @click="toggleFilters">
                  <i class="fas fa-bars"></i>
                </button>
                <div v-if="showFilters" class="dropdown-menu dropdown-menu-right show">
                  <a @click.prevent="getTopServices('tauxDeServire')" href="#" class="dropdown-item">Taux de Complétion des Tickets</a>
                  <a @click.prevent="getTopServices('nmbClients')" href="#" class="dropdown-item">Nombre de Clients</a>
                  <a @click.prevent="getTopServices('nmbClientsServis')" href="#" class="dropdown-item">Nombre de Clients Servis</a>
                  <a @click.prevent="getTopServices('nmbClientsNonServis')" href="#" class="dropdown-item">Nombre de Clients Non Servis</a>
                  <a @click.prevent="getTopServices('tempsMoyenAttente')" href="#" class="dropdown-item">Temps Moyen d'Attente</a>
                </div>
              </div>
              <button type="button" class="btn btn-tool" data-card-widget="collapse" @click="toggleShowList">
                <i :class="ShowList ? 'fas fa-minus' : 'fas fa-plus'"></i>
              </button>
              
            </div>
          </div>
          <!-- /.card-header -->
          <div class="card-body" v-if="ShowList">
            <p class="text-center">
              <strong>{{ filterLabels[currentFilterLabel] }}</strong>
            </p>
    
            <div class="progress-group" v-for="(service, index) in service" :key="service.id">
              {{ service.nom }}
              <span class="float-right"><b v-if="data[3]=='h'">{{ formatTime(data[index]) }}</b><b v-else>{{ Number.isInteger(data[index])?data[index]:data[index].toFixed(2) }}<b v-if="data[3]=='%'">%</b></b></span>
              <div class="progress progress-sm">
                <div class="progress-bar bg-primary" :style="{ width: (data[index]) + '%' }"></div>
              </div>
            </div>
            <!-- /.progress-group -->
          </div>
          <!-- ./card-body -->
        </div>

  </template>
  
  <script>
  import axios from 'axios';
  
  export default {
    name: 'TopServices',
    props:{
      name:String,
      name_id:[Number,String],
    },
    data() {
      return {
        ShowList:true,
        data: [],
        service: [],
        showFilters: false,
        currentFilterLabel: 'tauxDeServire',
        filterLabels: {
          tauxDeServire: 'Taux de Complétion des Tickets',
          nmbClients: 'Nombre de Clients',
          nmbClientsServis: 'Nombre de Clients Servis',
          nmbClientsNonServis: 'Nombre de Clients Non Servis',
          tempsMoyenAttente: 'Temps Moyen d\'Attente'
        }
      };
    },
    methods: {
      toggleShowList() {
      this.ShowList = !this.ShowList;
    },
      toggleFilters() {
        this.showFilters = !this.showFilters;
      },
      async getTopServices(name) {
        try {
          let response=null;
          if(this.name=='agence'){
            response = await axios.get(`/TopServices/${parseInt(this.name_id)}/${name}`);
          }
          else {
            response = await axios.get(`/TopServices/${name}`);}
          this.data = response.data.data;
          this.service = response.data.services;
          this.currentFilterLabel = name;
          this.showFilters = false; // Close the menu after selection
        } catch (error) {
          console.error('Erreur lors de la récupération des statistiques:', error);
        }
      },
      formatTime(minutes) {
        const heures = Math.floor(minutes / 60);
        const remainingMinutes = minutes % 60;
        return `${heures}h ${parseInt(remainingMinutes)}m`;
      },
      startAutoUpdate() {
      this.updateInterval = setInterval(() => {
        this.getTopServices(this.currentFilterLabel);
      }, 10000);
    },
    stopAutoUpdate() {
      clearInterval(this.updateInterval);
    }
  },
  created() {
    this.getTopServices('tauxDeServire');
    this.startAutoUpdate();
  },
  beforeDestroy() {
    this.stopAutoUpdate();
  },
    watch: {
    name(newVal) {
      this.getTopServices(this.currentFilterLabel);
    },
    name_id(newVal) {
      this.getTopServices(this.currentFilterLabel);
    }
  },
  };
  </script>
  
  <style scoped>
  </style>
  