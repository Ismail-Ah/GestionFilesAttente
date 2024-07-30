<template>
  <div class="card">
    <div class="card-header border-transparent">
      <h3 class="card-title">Dérniers Tickets</h3>
      <div class="card-tools">
        <button type="button" class="btn btn-tool" data-card-widget="collapse">
          <i class="fas fa-minus"></i>
        </button>
        <button type="button" class="btn btn-tool" data-card-widget="remove">
          <i class="fas fa-times"></i>
        </button>
      </div>
    </div>
    <div class="card-body p-0">
      <div class="table-responsive">
        <table class="table m-0">
          <thead>
            <tr>
              <th>Numéro</th>
              <th>Agence</th>
              <th>Service</th>
              <th>Statut</th>
              <th>Durée d'Attente</th>
              <th></th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="ticket in tickets.data" :key="ticket.id">
              <td><strong>{{ ticket.numéro }}</strong></td>
              <td>{{ ticket.nom_agence }}</td>
              <td>{{ ticket.nom_service }}</td>

              <td><span :class="['badge', getBadgeClass(ticket.statut)]">{{ ticket.statut }}</span></td>
              <td>
                <div class="sparkbar" data-color="#00a65a" data-height="20">
                  {{ timeDifference(ticket.statut, ticket.created_at, ticket.updated_at) }}
                </div>
              </td>
              <td class="project-actions text-right">
                <a v-if="ticket.statut === 'EN_ATTENT'" class="btn btn-success btn-sm mr-2" @click="validateTicket(ticket.id)">
                  <i class="fas fa-check"></i> Valider
                </a>
                <a class="btn btn-danger btn-sm" @click="deleteTicket(ticket.id)">
                  <i class="fas fa-trash"></i> Supprimer
                </a>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
    <div class="card-footer clearfix">
      <button class="btn btn-sm btn-success float-left" @click="prevPage" :disabled="!tickets.prev_page_url">Previous</button>
      <button class="btn btn-sm btn-success float-right" @click="nextPage" :disabled="!tickets.next_page_url">Next</button>
    </div>
  </div>
</template>

<script>
import axios from 'axios';

export default {
  name: 'StatTickets',
  data() {
    return {
      tickets: {
        data: [],
        current_page: 1,
        prev_page_url: null,
        next_page_url: null
      }
    };
  },
  props: {
    name: String,
    name_id: [Number,String]
  },
  methods: {
    async getTickets(page = 1) {
  try {
    let response;
    const url = this.name === "service"
      ? `/${parseInt(this.name_id)}/tickets?page=${page}`
      : this.name === "agence"
      ? `/agences/${parseInt(this.name_id)}/tickets?page=${page}`
      : this.name === "agent"
      ? `/agent/${parseInt(this.name_id)}/tickets?page=${page}`
      : `/tickets?page=${page}`;
    response = await axios.get(url);
    this.tickets = response.data;
  } catch (error) {
    console.error('Erreur lors de la récupération des tickets:', error);

    // Detailed error logging
    if (error.response) {
      console.error('Response data:', error.response.data);
      console.error('Response status:', error.response.status);
      console.error('Response headers:', error.response.headers);
    } else if (error.request) {
      console.error('Request data:', error.request);
    } else {
      console.error('Error message:', error.message);
    }

    // Optional: Add user feedback for error
  }
},

    timeDifference(statut, start, end) {
      const startDate = new Date(start);
      const endDate = statut === 'TRAITE' ? new Date(end) : new Date();
      const difference = endDate.getTime() - startDate.getTime();

      const hours = Math.floor(difference / (1000 * 60 * 60));
      const minutes = Math.floor((difference % (1000 * 60 * 60)) / (1000 * 60));

      return `${hours} hours, ${minutes} minutes`;
    },
    getBadgeClass(statut) {
      switch (statut) {
        case 'EN_ATTENT':
          return 'badge-warning';
        case 'EN_COURS':
          return 'badge-primary';
        case 'TRAITE':
          return 'badge-success';
        default:
          return 'badge-secondary';
      }
    },
    nextPage() {
      if (this.tickets.next_page_url) {
        this.getTickets(this.tickets.current_page + 1);
      }
    },
    prevPage() {
      if (this.tickets.prev_page_url) {
        this.getTickets(this.tickets.current_page - 1);
      }
    },
    validateTicket(id) {
      axios.put(`/tickets/${id}/validate`)
        .then(() => {
          const ticket = this.tickets.data.find(ticket => ticket.id === id);
          if (ticket) {
            ticket.statut = 'TRAITE';
          }
        })
        .catch(error => {
          console.error('Error validating ticket:', error);
        });
    },
    deleteTicket(id) {
      axios.delete(`/tickets/${id}`)
        .then(() => {
          this.tickets.data = this.tickets.data.filter(ticket => ticket.id !== id);
        })
        .catch(error => {
          console.error('Error deleting ticket:', error);
        });
    }
  },
  watch: {
    name: 'getTickets',
    name_id: 'getTickets',
  },
  created() {
    this.getTickets();
    this.interval = setInterval(() => this.getTickets(), 10000); // Fetch tickets every 10 seconds
  },
  beforeDestroy() {
    clearInterval(this.interval); // Clear the interval on component destruction
  }
};
</script>

<style scoped>
.project-actions a {
  margin-right: 10px;
}
</style>
