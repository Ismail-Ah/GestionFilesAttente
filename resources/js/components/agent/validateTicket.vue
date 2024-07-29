<template>
    <div class="ticket-list">
      <h2>Ticket Validation</h2>
      <ul>
        <li v-for="ticket in tickets" :key="ticket.id">
          <div class="ticket-info">
            <p><strong>Ticket Number:</strong> {{ ticket.numéro }}</p>
            <p><strong>Status:</strong> {{ ticket.statut }}</p>
          </div>
          <div class="ticket-actions">
            <button v-if="ticket.statut === 'EN_ATTENT'" @click="validateTicket(ticket)">Valider</button>
            <button v-else disabled>Validé</button>
          </div>
        </li>
      </ul>
    </div>
  </template>
  
  <script>
  import axios from 'axios';
  
  export default {
    name: 'TicketValidation',
    data() {
      return {
        tickets: [],
        service_id:1,
        agence_id:1,
      };
    },
    methods: {
      loadTickets() {
        // Replace with your API endpoint to fetch tickets
        axios.get(`/${this.service_id}/tickets`)
          .then(response => {
            this.tickets = response.data.tickets;
          })
          .catch(error => {
            console.error('Error fetching tickets:', error);
          });
      },
      validateTicket(ticket) {
        // API call to mark ticket as validated
        axios.put(`/tickets/${ticket.id}/validate`)
          .then(response => {
            // Update ticket status locally
            ticket.statut = 'TRAITE';
            // Optionally, you can reload tickets after validation
            // this.loadTickets();
          })
          .catch(error => {
            console.error('Error validating ticket:', error);
          });
      }
    },
    created() {
      // Load tickets when component is created
      this.loadTickets();
    }
  };
  </script>
  
  <style scoped>
  .ticket-list {
    max-width: 600px;
    margin: auto;
  }
  
  .ticket-info {
    display: inline-block;
  }
  
  .ticket-actions {
    display: inline-block;
    margin-left: 10px;
  }
  </style>
  