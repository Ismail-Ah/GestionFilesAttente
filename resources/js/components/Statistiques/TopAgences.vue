<template>
  <div class="card">
    <div class="card-header">
      <h5 class="card-title">Top Agences</h5>
      <div class="card-tools">
        <button type="button" class="btn btn-tool" data-card-widget="collapse">
          <i class="fas fa-minus"></i>
        </button>
        <div class="btn-group">
          <button type="button" class="btn btn-tool dropdown-toggle" @click="toggleFilters">
            <i class="fas fa-bars"></i>
          </button>
          <div v-if="showFilters" class="dropdown-menu dropdown-menu-right show">
            <a @click.prevent="getTopAgences('tauxDeServire')" href="#" class="dropdown-item">Taux de Complétion des Tickets</a>
            <a @click.prevent="getTopAgences('nmbClients')" href="#" class="dropdown-item">Nombre de Clients</a>
            <a @click.prevent="getTopAgences('nmbClientsServis')" href="#" class="dropdown-item">Nombre de Clients Servis</a>
            <a @click.prevent="getTopAgences('nmbClientsNonServis')" href="#" class="dropdown-item">Nombre de Clients Non Servis</a>
            <a @click.prevent="getTopAgences('tempsMoyenAttente')" href="#" class="dropdown-item">Temps Moyen d'Attente</a>
          </div>
        </div>
        <button type="button" class="btn btn-tool" data-card-widget="remove">
          <i class="fas fa-times"></i>
        </button>
      </div>
    </div>
    <!-- /.card-header -->
    <div class="card-body">
      <p class="text-center">
        <strong>{{ currentFilterLabel }}</strong>
      </p>

      <div class="progress-group" v-for="(agence, index) in agences" :key="agence.id">
        {{ agence.nom }}
        <span class="float-right">
          <b v-if="data[3]=='h'">{{ formatTime(data[index]) }}</b>
          <b v-else>{{ Number.isInteger(data[index]) ? data[index] : data[index].toFixed(2) }}<b v-if="data[3]=='%'">%</b></b>
        </span>
        <div class="progress progress-sm">
          <div class="progress-bar bg-primary" :style="{ width: (data[index]) + '%' }"></div>
        </div>
      </div>
      <!-- /.progress-group -->
    </div>
    <!-- ./card-body -->
  </div>
  <!-- /.card -->
</template>

<script>
import axios from 'axios';

export default {
  name: 'TopAgences',
  data() {
    return {
      data: [],
      agences: [],
      showFilters: false,
      currentFilterLabel: 'Taux de Complétion des Tickets',
      currentFilterKey: 'tauxDeServire',
      filterLabels: {
        tauxDeServire: 'Taux de Complétion des Tickets',
        nmbClients: 'Nombre de Clients',
        nmbClientsServis: 'Nombre de Clients Servis',
        nmbClientsNonServis: 'Nombre de Clients Non Servis',
        tempsMoyenAttente: 'Temps Moyen d\'Attente'
      },
      updateInterval: null
    };
  },
  methods: {
    toggleFilters() {
      this.showFilters = !this.showFilters;
    },
    async getTopAgences(key) {
      try {
        const response = await axios.get(`/TopAgences/${key}`);
        this.data = response.data.data;
        this.agences = response.data.agences;
        this.currentFilterLabel = this.filterLabels[key];
        this.currentFilterKey = key;
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
        this.getTopAgences(this.currentFilterKey);
      }, 10000);
    },
    stopAutoUpdate() {
      clearInterval(this.updateInterval);
    }
  },
  created() {
    this.getTopAgences(this.currentFilterKey);
    this.startAutoUpdate();
  },
  beforeDestroy() {
    this.stopAutoUpdate();
  }
};
</script>

<style scoped>
</style>
