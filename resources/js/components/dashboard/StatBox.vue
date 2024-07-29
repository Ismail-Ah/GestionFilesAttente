<template>
    <div class="row">
      <div class="col-lg-3 col-6">
        <!-- small box -->
        <div class="small-box bg-info">
          <div class="inner">
            <h3>{{ clientsEnAttente + clientsServis }}</h3>
            <p>Total Clients</p>
          </div>
        </div>
      </div>
      <!-- ./col -->
      <div class="col-lg-3 col-6">
        <!-- small box -->
        <div class="small-box bg-success">
          <div class="inner">
            <h3>{{ clientsServis }}</h3>
            <p>Clients Servis</p>
          </div>

        </div>
      </div>
      <!-- ./col -->
      <div class="col-lg-3 col-6">
        <!-- small box -->
        <div class="small-box bg-warning">
          <div class="inner">
            <h3>{{ formatTime(tempsMoyenAttente) }}</h3>
            <p>Temps Moyen d'Attente</p>
          </div>
          
        </div>
      </div>
      <!-- ./col -->
      <div class="col-lg-3 col-6">
        <!-- small box -->
        <div class="small-box bg-danger">
          <div class="inner">
            <h3>{{ clientsEnAttente }}</h3>
            <p>Clients Non Servis</p>
          </div>
        </div>
      </div>
      <!-- ./col -->
    </div>
  </template>
  
  <script>
  import axios from 'axios';
  
  export default {
    name: 'StatBox',
    data() {
      return {
        clientsEnAttente: 0,
        clientsServis: 0,
        tempsMoyenAttente: 0,
      };
    },
    props: {
      name_id: [Number,String],
      name: String,
    },
    methods: {
      async getStatistics() {
        try {
          let response;
          if (this.name === "service") {
            response = await axios.get(`/services/${parseInt(this.name_id)}/statistics`);
          } else{
            if (this.name === "agence") {
            response = await axios.get(`/agences/${parseInt(this.name_id)}/statistics`);
          } else {
            response = await axios.get(`/agencies/statistics`);
          }
          } 
          this.updateStatistics(response.data);
        } catch (error) {
          console.error('Erreur lors de la récupération des statistiques:', error);
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
        return `${heures}h ${parseInt(remainingMinutes)}m`;
      }
    },
    watch: {
      name: 'getStatistics',
      name_id: 'getStatistics',
    },
    created() {
      this.getStatistics(); // Fetch data when component is created
      this.interval = setInterval(this.getStatistics, 1000); // Set the interval to call getTickets every 10 seconds
  },
  beforeDestroy() {
    clearInterval(this.interval); // Clear the interval when the component is destroyed
  }
  };
  </script>
  