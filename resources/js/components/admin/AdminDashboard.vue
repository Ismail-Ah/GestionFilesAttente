<template>
    <div class="dashboard">
      <h1 class="title">Dashboard</h1>
      <div class="actions">
        <button class="action-button" @click="showAddAgencyForm">Ajouter Agence</button>
        <button class="action-button" @click="addAgent">Create Agent Acount</button>
      </div>
  
      <div class="agencies">
        <div v-for="agence in agencies" :key="agence.id" class="agency-card" @click="clickAgence(agence.id)">
          <h2 class="agency-name">{{ agence.nom }}</h2>
          <p class="agency-details">{{ agence.adress }}</p>
          <p class="agency-details">{{ agence.email }}</p>
          <p class="agency-details">{{ agence.telephone }}</p>
        </div>
      </div>
  
      <statistiques name="agences" name_id=""></statistiques>
  
      <div v-if="successMessage" class="success-message">{{ successMessage }}</div>
      <div v-if="errorMessage" class="error-message">{{ errorMessage }}</div>
    </div>
  </template>
  
  <script>
  import axios from 'axios';
  import Statistiques from '../statistique.vue';
  export default {
    name: 'AdminDashboard',
    components :{Statistiques},
    data() {
      return {
        statistics: {
          waitingClients: 0,
          servedClients: 0,
          averageWaitingTime: 0,
          clientSatisfaction: 0,
        },
        agencies: [],
        successMessage: '',
        errorMessage: '',
      };
    },
    methods: {
      showAddAgencyForm() {
        this.$router.push('/ajouter-agence');
      },
      addAgent() {
        this.$router.push('/create-agent-acount');
      },
      getAgencies() {
        axios.get('/agencies')
          .then(response => {
            this.agencies = response.data;
          })
          .catch(error => {
            console.error('Erreur lors de la récupération des agences:', error);
          });
      },
      clickAgence(id) {
          this.$router.push(`/agence/${id}`);
    },

    },
    created() {
      this.getAgencies();
    },
  };
  </script>
  
  <style scoped>
  .dashboard {
    max-width: 800px;
    margin: auto;
    padding: 1rem;
    font-family: Arial, sans-serif;
  }
  
  .title {
    text-align: center;
    color: #007bff;
  }
  
  .actions {
    display: flex;
    justify-content: center;
    gap: 1rem;
    margin-bottom: 2rem;
  }
  
  .action-button {
    background-color: #007bff;
    color: white;
    padding: 0.5rem 1rem;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    transition: background-color 0.3s ease;
  }
  
  .action-button:hover {
    background-color: #0056b3;
  }
  
  .agencies {
    display: flex;
    flex-wrap: wrap;
    gap: 1rem;
    justify-content: center;
  }
  
  .agency-card {
    background-color: #f8f9fa;
    border: 1px solid #dee2e6;
    border-radius: 4px;
    padding: 1rem;
    width: calc(50% - 1rem);
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
  }
  
  .agency-name {
    margin: 0;
    font-size: 1.25rem;
    color: #333;
  }
  
  .agency-details {
    margin: 0.25rem 0;
    color: #555;
  }
  
  .success-message {
    margin-top: 1rem;
    color: green;
    text-align: center;
  }
  
  .error-message {
    margin-top: 1rem;
    color: red;
    text-align: center;
  }
  </style>
  