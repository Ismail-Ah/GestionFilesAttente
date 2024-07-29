<template>
  <div class="statistics">
    <div v-if="loading">
      <LoadingSpinner /> <!-- Display spinner when loading -->
    </div>
    <div v-else>
      <div class="stat">
        <h2>Clients en Attente : {{ clientsEnAttente }}</h2>
      </div>
      <div class="stat">
        <h2>Temps Moyen d'Attente : {{ formatTime(tempsMoyenAttente) }}</h2>
        
      </div>
    </div>
  </div>
</template>

<script>
import axios from 'axios';
import LoadingSpinner from './LoadingSpinner.vue';

export default {
  name: 'Statistiques',
  components: {
    LoadingSpinner,
  },
  data() {
    return {
      clientsEnAttente: '',
      clientsServis: '',
      tempsMoyenAttente: '',
      loading: true,
    };
  },
  props: {
    name_id: String,
    name: String,
  },
  methods: {
    async getStatistics() {
      try {
        if (this.name === "service") {
          const response = await axios.get(`/services/${parseInt(this.name_id)}/statistics`);
          this.updateStatistics(response.data);
        } else if (this.name === "agence") {
          const response = await axios.get(`/agences/${parseInt(this.name_id)}/statistics`);
          this.updateStatistics(response.data);
        } else {
          const response = await axios.get(`/agences/statistics`);
          this.updateStatistics(response.data);
        }
      } catch (error) {
        console.error('Erreur lors de la récupération des statistiques:', error);
      } finally {
        this.loading = false; // Always set loading to false after data is fetched
      }
    },
    updateStatistics(data) {
      this.clientsEnAttente = data.clientsEnAttente;
      this.clientsServis = data.clientsServis;
      this.tempsMoyenAttente = data.tempsMoyenAttente;
    },
    formatTime(minutes) {
      const heures = Math.floor(minutes / 60);
      const remainingMinutes = minutes % 60;
      return `${heures}h ${remainingMinutes.toFixed(0)}m`;
    }
  },
  created() {
    this.getStatistics(); // Fetch data when component is created
  }
};
</script>

<style scoped>
.statistics {
  text-align: center;
  padding: 20px;
}

.stat {
  margin-bottom: 20px;
}

.stat h2 {
  font-size: 1.5em;
  margin-bottom: 10px;
}

.stat p {
  font-size: 1.2em;
  margin: 0;
}
</style>
