<template>
  <div class="ticket-btn">
    <div v-if="loading">
      <loading-spinner/>
    </div>
    <div v-else  class="ticket-print">
      <h1>Numéro de Ticket: {{ numéroTicket }}</h1>
      <p>Date: {{ formatDate() }}</p>
      <p>Service: {{ Service.nom }}</p>
      <p>Agence: {{ nomAgence }}</p>
      <p>Instructions : {{$t('Instructions')}}</p>

    </div>
    <center>    <button @click="printTicket">Print Ticket</button>
    </center>
  </div>
</template>

<script>
import axios from 'axios';
import LoadingSpinner from '../LoadingSpinner.vue';

export default {
  name: 'TicketPrint',
  components: { LoadingSpinner },
  data() {
    return {
      service_id: this.$route.params.service_id,
      agence_id: this.$route.params.agence_id,
      Service: '',
      numéroTicket: '',
      nomAgence: '',
      loading: true,
      
    };
  },
  methods: {
    async getServiceName() {
      try {
        const response = await axios.get(`/service/${parseInt(this.service_id)}`);
        this.Service = response.data.service;
        this.numéroTicket = response.data.numéroTicket;
        this.nomAgence = response.data.nomAgence;
      } catch (error) {
        console.error('Erreur lors de la récupération des agences:', error);
      } finally {
        this.loading = false;
      }
    },
    printTicket() {
      window.print();
      this.$router.push(`/agence/${this.agence_id}/ticket-dispenser`);
    },
    formatDate() {
      const now = new Date();
      return now.toLocaleDateString();
    },
  },
  created() {
    this.getServiceName();
  },
};
</script>

<style scoped>
.ticket-btn {
  width: 300px;
  display: inline-block;
  justify-content: center; /* Center horizontally */
  align-items: center; /* Center vertically */
}

.ticket-print {
  background-color: #ffffff;
  border: 1px solid #cccccc;
  padding: 20px;
  margin: 20px;
  width: 300px;
  display: inline-block;
  justify-content: center; /* Center horizontally */
  align-items: center; /* Center vertically */
}

.ticket-print h1 {
  font-size: 1.5em;
  margin-bottom: 10px;
  color: #000;
}

.ticket-print p {
  padding-left: 10px;
  margin-bottom: 5px;
  color: #000;
  text-align: left;
}

button {
  margin-top :auto;
  background-color: #007bff;
  color: #ffffff;
  border: none;
  padding: 10px 20px;
  cursor: pointer;
  border-radius: 4px;
}

button:hover {
  background-color: #0056b3;
}
</style>
