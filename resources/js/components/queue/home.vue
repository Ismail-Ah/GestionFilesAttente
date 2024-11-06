<template>
  <div class="home1">
    <Clock style="margin-top: 25%;"></Clock>
    <Time style="margin: auto;"></Time>
  </div>
  <div class="home2">
    <div class="head">
      <h1 style="color: #fff;font-size: 2rem;">Bienvenue chez {{ agence_nom }}</h1>
    </div>
    <div v-for="service in services" :key="service.id" class="box">
      <div class="box-content">
        <div class="box-part3" style="background-color: #000;">S{{ service.id }}</div>
        <div class="box-part1" style="background-color: #023047;">{{ service.nom }}</div>
        <div class="box-part2" style="background-color: #FB8500;">
          {{ service.currentTicket ? service.currentTicket : '--' }}
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import axios from 'axios';
import Clock from './clock.vue';
import Time from './time.vue';

export default {
  name: 'HomeQueue',
  data() {
    return {
      services: [],
      agence_nom: '',
      intervalId: null, // Store the interval ID for clearing it later
    };
  },
  components: { Clock, Time },
  methods: {
    async getServices() {
      try {
        const response = await axios.get(`/queue/agence/${this.$route.params.id}/services`);
        this.services = response.data.services;
        this.agence_nom = response.data.agence_nom;
      } catch (error) {
        console.error('Erreur lors de la récupération des services:', error);
      }
    },
    startPolling() {
      this.getServices(); // Initial fetch
      this.intervalId = setInterval(this.getServices, 3000); // Poll every 5 seconds
    },
    stopPolling() {
      clearInterval(this.intervalId); // Clear the interval when the component is destroyed
    }
  },
  mounted() {
    this.startPolling(); // Start polling when the component mounts
  },
  beforeDestroy() {
    this.stopPolling(); // Stop polling when the component is destroyed
  }
};
</script>

<style scoped>
.home1 {
  position: fixed;
  top: 0;
  left: 0;
  width: 30%;
  height: 100%;
  display: flex;
  background-color: #023047;
  justify-content: center;
  align-items: center;
  overflow: hidden; /* Prevents overflow issues */
  flex-direction: column;
}

.home2 {
  position: fixed;
  top: 0;
  left: 30%;
  width: 70%;
  height: 100%;
  background-color: #f6f6f2; /* Light background */
  display: flex;
  flex-direction: column; /* Align boxes in a column */
  justify-content: center;
  align-items: center;
  overflow: hidden; /* Prevents overflow issues */
}

.box {
  width: 80%; /* Adjust size as needed */
  height: 10%; /* Adjust size as needed */
  margin: 10px 0; /* Space between boxes */
  display: flex; /* Use Flexbox */
  align-items: center; /* Vertically center content */
  justify-content: center; /* Horizontally center content */
}

.box-content {
  display: flex; /* Use Flexbox */
  width: 100%; /* Full width of the box */
  height: 100%; /* Full height of the box */
}

.box-part3 {
  width: 10%;
  display: flex; /* Use Flexbox */
  align-items: center; /* Vertically center content */
  justify-content: center; /* Horizontally center content */
  color: white; /* Text color */
  font-size: 1.5em; /* Font size */
  padding: 10px; /* Padding inside the box */
}

.box-part1 {
  width: 75%;
  display: flex; /* Use Flexbox */
  align-items: center; /* Vertically center content */
  justify-content: center; /* Horizontally center content */
  color: white; /* Text color */
  font-size: 1.5em; /* Font size */
  padding: 10px; /* Padding inside the box */
}

.box-part2 {
  width: 15%; /* Divide space equally between the parts */
  display: flex; /* Use Flexbox */
  align-items: center; /* Vertically center content */
  justify-content: center; /* Horizontally center content */
  color: white; /* Text color */
  font-size: 2em; /* Font size */
  padding: 10px; /* Padding inside the box */
}

h1, h2 {
  color: white;
}

.head {
  width: 50%;
  height: 10%;
  background-color: #023047;
  border-radius: 0 0 3rem 3rem;
  position: fixed;
  top: 0px;
  display: flex;
  justify-content: center;
  align-items: center;
  font-size: 2rem;
  font-display: inherit;
}
</style>
