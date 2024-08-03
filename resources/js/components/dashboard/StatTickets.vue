<template>
  
  <div class="card">
    <div class="card-header border-transparent">
      <h3 class="card-title">Derniers Tickets</h3>
      <div class="card-tools">
        <div class="btn-group">
          <button type="button" class="btn btn-tool dropdown-toggle" @click="toggleFilters">
            <i class="fas fa-bars"></i>
          </button>
          <div v-if="showFilters" class="dropdown-menu dropdown-menu-right show">
            <a @click.prevent="getFilterTickets(0)" href="#" class="dropdown-item">Tous les tickets</a>
            <a @click.prevent="getFilterTickets('EN_ATTENT')" href="#" class="dropdown-item">Tickets en attente</a>
            <a @click.prevent="getFilterTickets('TRAITE')" href="#" class="dropdown-item">Tickets traités</a>
          </div>
        </div>
        <button type="button" class="btn btn-tool" data-card-widget="collapse">
          <i class="fas fa-minus"></i>
        </button>
        <button type="button" class="btn btn-tool" data-card-widget="remove">
          <i class="fas fa-times"></i>
        </button>
      </div>
    </div>
    <div v-if="loading">
    <LoadingSpinner2></LoadingSpinner2>
  </div>
    <div v-else class="card-body p-0">
      <div class="table-responsive">
        <table class="table m-0">
          <thead>
            <tr>
              <th>Numéro</th>
              <th>Agence</th>
              <th>Service</th>
              <th>Statut</th>
              <th>Durée d'attente</th>
              <th></th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="ticket in paginatedTickets" :key="ticket.id">
              <td><strong>{{ ticket.numéro }}</strong></td>
              <td>{{ ticket.nom_agence }}</td>
              <td>{{ ticket.service.nom }}</td>
              <td>
                <span :class="['badge', getBadgeClass(ticket.statut)]">{{ ticket.statut }}</span>
              </td>
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
      <button class="btn btn-sm btn-success float-left" @click="prevPage" :disabled="currentPage === 1">Précédent</button>
      <button class="btn btn-sm btn-success float-right" @click="nextPage" :disabled="currentPage >= totalPages">Suivant</button>
    </div>
  </div>
</template>




<script>
import axios from 'axios';
import LoadingSpinner2 from '../LoadingSpinner2.vue';

export default {
  name: 'StatTickets',
  components: { LoadingSpinner2 },
  data() {
    return {
      tickets: [],
      allTickets: [],
      currentPage: 1,
      showFilters: false,
      typeFilter: 0,
      pageSize: 5,
      loading: true,
    };
  },
  props: {
    name: String,
    name_id: [Number, String]
  },
  computed: {
    totalPages() {
      return Math.ceil(this.tickets.length / this.pageSize);
    },
    paginatedTickets() {
      const start = (this.currentPage - 1) * this.pageSize;
      return this.tickets.slice(start, start + this.pageSize);
    },
  },
  methods: {
    toggleFilters() {
      this.showFilters = !this.showFilters;
    },
    async getTickets() {
      try {
        let url;
        if (this.name === 'service') url = `/${parseInt(this.name_id)}/tickets`;
        else if (this.name === 'agence') url = `/agences/${parseInt(this.name_id)}/tickets`;
        else if (this.name === 'agent') url = `/agent/${parseInt(this.name_id)}/tickets`;
        else url = `/tickets`;

        const response = await axios.get(url);
        this.allTickets = response.data;
        if (this.name === "service") {
          this.isActif = this.allTickets[0]?.service.etat === 'ACTIF';
        }
        this.getFilterTickets(this.typeFilter);
        this.loading = false;
      } catch (error) {
        console.error('Erreur lors de la récupération des tickets:', error);
        this.loading = false;
      }
    },
    getFilterTickets(type) {
      this.tickets = type ? this.allTickets.filter(ticket => ticket.statut === type) : this.allTickets;
      this.showFilters = false;
      this.typeFilter = type;
    },
    async validateTicket(id) {
      try {
        this.tickets = this.tickets.map(ticket =>
          ticket.id === id ? { ...ticket, statut: 'TRAITE', updated_at: new Date() } : ticket
        );
        await axios.put(`/tickets/${id}/validate`);
      } catch (error) {
        console.error('Erreur lors de la validation du ticket:', error);
      }
    },
    async deleteTicket(id) {
      try {
        this.tickets = this.tickets.filter(ticket => ticket.id !== id);
        await axios.delete(`/tickets/${id}`);
      } catch (error) {
        console.error('Erreur lors de la suppression du ticket:', error);
      }
    },
    timeDifference(statut, start, end) {
      const startDate = new Date(start);
      const endDate = statut === 'TRAITE' ? new Date(end) : new Date();
      const difference = endDate.getTime() - startDate.getTime();

      const hours = Math.floor(difference / (1000 * 60 * 60));
      const minutes = Math.floor((difference % (1000 * 60 * 60)) / (1000 * 60));

      return `${hours} heures, ${minutes} minutes`;
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
      if (this.currentPage < this.totalPages) {
        this.currentPage++;
      }
    },
    prevPage() {
      if (this.currentPage > 1) {
        this.currentPage--;
      }
    }
  },
  watch: {
    name: 'getTickets',
    name_id: 'getTickets',
  },
  created() {
    this.getTickets();
    this.interval = setInterval(() => this.getTickets(), 10000);
  },
  beforeDestroy() {
    clearInterval(this.interval);
  }
};
</script>



<style scoped>





.project-actions a {
  margin-right: 10px;
}

button:disabled {
  background-color: grey;
  cursor: not-allowed;
  border: grey;
}




</style>
