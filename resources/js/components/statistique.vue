<template>
  <div class="statistics">
    <div v-if="loading">
      <LoadingSpinner /> <!-- Display spinner when loading -->
    </div>
    <div class="stats" v-else>
      <div class="stat btn-solid-lg page-scroll">
        <div class="stat-text">
          <h2>Clients en Attente</h2>
        </div>
        <div class="stat-data">
          <p>{{ clientsEnAttente }}</p>
        </div>
      </div>
      <div class="stat btn-solid-lg page-scroll">
        <div class="stat-text">
          <h2>Temps Moyen d'Attente</h2>
        </div>
        <div class="stat-data">
          <p>{{ formatTime(tempsMoyenAttente) }}</p>
        </div>
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
.stat-text {
  margin-bottom: 10px; /* Space between title and data */
}

.stat-data {
  font-size: 1.2em; /* Adjust the size for data */
}


.stat {
  margin: auto;
  width: 600px; /* Adjust the width to fit your design */
  display: flex;
  flex-wrap: wrap;
  justify-content: space-between; /* Space between items */
  gap: 20px; /* Add gap between items */
}

.stat h2 {
  font-size: 1.5em;
  margin-bottom: 10px;
}

.stat p {
  font-size: 2em;
  margin: 0;
}
.stats{
  margin: auto;
  width: 800px; /* Adjust the width to fit your design */
  display: flex;
  flex-wrap: wrap;
  justify-content: space-between; /* Space between items */
  gap: 20px; /* Add gap between items */
}
.btn-solid-lg {
  flex: 1 1 calc(50% - 10px); /* Two items per row, minus gap */
  box-sizing: border-box; /* Include padding and border in width calculation */
  margin: 10px 0; /* Vertical margin */
  padding: 20px;
  border-radius: 10px;
  width: 30%; /* Full width within the flex item */
  height: 30%; /* Set explicit height */
  display: flex; /* Flex display */
  align-items: center; /* Center text vertically */
  justify-content: center; /* Center text horizontally */
}

.btn-solid-lg {
  display: inline-block;
  padding: 1.375rem 2.625rem;
  border: 0.125rem solid aliceblue;
  border-radius: 3rem;
  background-color: aliceblue;
  color: #023047;
  font: 700 0.875rem / 1 "Open Sans", sans-serif;
  text-decoration: none;
  box-shadow: rgba(0, 0, 0, 0.4) 0px 2px 4px, rgba(0, 0, 0, 0.3) 0px 7px 13px -3px, rgba(0, 0, 0, 0.2) 0px -3px 0px inset;
  transition: all 0.2s;
  text-align: center;
}


</style>
