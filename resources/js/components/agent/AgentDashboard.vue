<template>
    <div class="agent-dashboard">
      <h1>Agent Dashboard</h1>
      <div class="services-section">
        <h2>Your Services</h2>
        <ul>
          <li v-for="service in services" :key="service.id" @click="selectService(service.id)">
            {{ service.nom }}
          </li>
        </ul>
      </div>
      <div v-if="selectedService">
        <h2>Tickets for {{ selectedService.nom }}</h2>
        <div v-if="loadingTickets">
          <LoadingSpinner />
        </div>
        <ul v-else>
          <li v-for="ticket in tickets" :key="ticket.id">
            <p>Ticket ID: {{ ticket.numéro }}</p>
            <p>Status: {{ ticket.statut }}</p>
            <button @click="validateTicket(ticket.id)">Validate</button>
            <button @click="invalidateTicket(ticket.id)">Invalidate</button>
          </li>
        </ul>
      </div>
    </div>
  </template>
  
  <script>
  import axios from 'axios';
  import LoadingSpinner from '../LoadingSpinner.vue';
  
  export default {
    name: 'AgentDashboard',
    components: {
      LoadingSpinner,
    },
    data() {
      return {
        services: [],
        selectedService: null,
        tickets: [],
        loadingTickets: false,
      };
    },
    methods: {
      fetchServices() {
        axios.get('/agent/services')
          .then(response => {
            this.services = response.data;
          })
          .catch(error => {
            console.error('Error fetching services:', error);
          });
      },
      selectService(serviceId) {
        this.selectedService = this.services.find(service => service.id === serviceId);
        this.fetchTickets(serviceId);
      },
      fetchTickets(serviceId) {
        this.loadingTickets = true;
        axios.get(`/${serviceId}/tickets`)
          .then(response => {
            this.tickets = response.data.tickets;
            this.loadingTickets = false;
          })
          .catch(error => {
            console.error('Error fetching tickets:', error);
            this.loadingTickets = false;
          });
      },
      validateTicket(ticketId) {
        axios.put(`/tickets/${ticketId}/validate`)
          .then(response => {
            alert('Ticket validated successfully!');
            this.fetchTickets(this.selectedService.id);
          })
          .catch(error => {
            console.error('Error validating ticket:', error);
          });
      },
      invalidateTicket(ticketId) {
        axios.post(`/tickets/${ticketId}/invalidate`)
          .then(response => {
            alert('Ticket invalidated successfully!');
            this.fetchTickets(this.selectedService.id);
          })
          .catch(error => {
            console.error('Error invalidating ticket:', error);
          });
      }
    },
    created() {
      this.fetchServices();
    }
  };
  </script>
  
  <style scoped>
  .agent-dashboard {
    max-width: 800px;
    margin: auto;
    padding: 20px;
  }
  
  .services-section ul {
    list-style: none;
    padding: 0;
  }
  
  .services-section li {
    cursor: pointer;
    padding: 10px;
    border: 1px solid #ccc;
    margin-bottom: 5px;
  }
  
  .services-section li:hover {
    background-color: #f0f0f0;
  }
  
  .tickets-section ul {
    list-style: none;
    padding: 0;
  }
  
  .tickets-section li {
    border: 1px solid #ccc;
    padding: 10px;
    margin-bottom: 5px;
  }
  </style>
  