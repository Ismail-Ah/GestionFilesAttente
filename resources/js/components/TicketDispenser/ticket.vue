<template>
  <div class="ticket-container">
    <div v-if="loading" style="margin-top:-10%">
      <LoadingSpinner></LoadingSpinner>
    </div>
    <div v-else class="ticket-print" id="printable-content">
      <h2>{{ lan === 'ar' ? (agence.nom_ar || agence.nom) : agence.nom }}</h2>
      <h2>{{ $t('Bienvenue') }}</h2>
      <hr />
      <h2>AG{{ agence_id }} S{{ Service.id }}</h2>
      <h1>N° {{ numéroTicket }}</h1>
      <hr />
      <h4>
        {{$t('Service')}} : 
        {{ lan === 'fr' ? Service.nom : lan === 'en' ? (Service.nom_en || Service.nom) : (Service.nom_ar || Service.nom) }}
      </h4>
      <p>{{ $t('Instructions') }}</p>
      <h4>&#128197; {{ formatDate() }}</h4>
    </div>
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
      Service: {},
      numéroTicket: '',
      agence: {},
      loading: true,
      lan: this.$i18n.locale,
    };
  },
  methods: {
    async getServiceName() {
      try {
        const response = await axios.get(`/service/${parseInt(this.service_id)}`);
        this.Service = response.data.service;
        this.numéroTicket = response.data.numéroTicket;
        this.agence = response.data.agence;
        this.agence_id = this.agence.id;
      } catch (error) {
        console.error('Erreur lors de la récupération des services:', error);
      } finally {
        this.loading = false;
        // Ensure DOM updates are complete before printing
        this.$nextTick(() => {
          setTimeout(() => {
            this.printTicket();
          }, 2000); // 2000 milliseconds = 2 seconds
        });
      }
    },
    printTicket() {
      const content = document.getElementById('printable-content').innerHTML;
      const printWindow = window.open('', '', 'height=600,width=800');
      printWindow.document.open();
      printWindow.document.write(`
        <html>
          <head>
            <style>
              @import url('https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap');
              body { font-family: 'Roboto', sans-serif; margin: 0; padding: 0; display: flex; justify-content: center; align-items: center; height: 100vh; }
              .ticket-print { width: auto; max-width: 800px; margin: 0; padding: 30px; background-color: #ffffff; border: 1px solid #cccccc; border-radius: 10px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); text-align: center; }
              .ticket-print h1 { font-size: 2.5em; font-weight: 700; color: #333; margin: 10px 0; }
              .ticket-print h2 { font-size: 1.75em; font-weight: 400; color: #666; }
              .ticket-print p { font-size: 1.2em; color: #444; }
              hr { border: 0; border-top: 1px solid #cccccc; margin: 20px 0; }
            </style>
          </head>
          <body>
            <div class="ticket-print">
              ${content}
            </div>
          </body>
        </html>
      `);
      printWindow.document.close();

      // Ensure that the print dialog is triggered after the content is fully written
      setTimeout(() => {
        printWindow.focus(); // Required for IE
        printWindow.print();
        printWindow.close();
        this.$router.push(`/ticket-dispenser/agences/${this.agence_id}`);
      }, 100); // Short delay to ensure the content is fully loaded
    },
    formatDate() {
      const now = new Date();
      const day = String(now.getDate()).padStart(2, '0');
      const month = String(now.getMonth() + 1).padStart(2, '0');
      const year = now.getFullYear();
      return `${day}/${month}/${year}`;
    },
  },
  created() {
    this.getServiceName();
  },
};
</script>

<style scoped>
@import url('https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap');

.ticket-container {
  margin-top: -5%;
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  width: 100%;
  text-align: center;
  font-family: 'Roboto', sans-serif; /* Using Roboto font */
}

.ticket-print {
  max-width:420px;
  background-color: #ffffff;
  border: 1px solid #cccccc;
  border-radius: 10px; /* Rounded corners */
  padding: 30px;
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); /* Shadow effect */
}

.ticket-print h1 {
  font-size: 2.5em;
  font-weight: 700; /* Bold font weight */
  margin: 10px 0;
  color: #333;
}

.ticket-print p {
  font-size: 1.2em;
  margin: 5px 0;
  color: #444;
}

button {
  position: fixed;
  top: 85%;
  background-color: #007bff;
  color: #ffffff;
  border: none;
  padding: 12px 24px;
  cursor: pointer;
  border-radius: 4px;
  font-size: 1.1em;
  font-weight: 700; /* Bold font weight */
}

button:hover {
  background-color: #0056b3;
}
</style>
