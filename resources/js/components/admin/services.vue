<template>
  <div v-if="loading">
    <LoadingSpinner></LoadingSpinner>
  </div>
  <div v-else class="home-page">
    <div class="services">
      <button
        v-for="service in paginatedServices"
        :key="service.id"
        :disabled="service.etat !== 'ACTIF'"
        class="btn-solid-lg page-scroll"
        @click="clickService(service.id, action)"
      >
        <h4>{{ service.nom }}</h4>
        <p class="agency-details" :style="{ color: service.etat === 'ACTIF' ? 'rgb(8, 235, 8)' : 'red' }">
          {{ service.etat }}
        </p>
      </button>
      <button
        v-for="placeholder in placeholders"
        :key="'placeholder-' + placeholder"
        class="btn-solid-lg page-scroll placeholder"
        disabled
      >
        Placeholder
      </button>
    </div>
    <div class="pagination">
      <button @click="prevPage" id="previous" :disabled="currentPage === 1">
        <i class="fas fa-arrow-left"></i>
      </button>
      <button @click="nextPage" id="next" :disabled="currentPage === totalPages">
        <i class="fas fa-arrow-right"></i>
      </button>
    </div>
  </div>
</template>

<script>
import axios from 'axios';
import LoadingSpinner from '../LoadingSpinner.vue';

export default {
  name: 'Services',
  components: { LoadingSpinner },
  data() {
    return {
      loading: true,
      successMessage: '',
      errorMessage: '',
      currentPage: 1,
      pageSize: 4,
      services: [],
      action: this.action || '', // Default to empty string if action is not provided
    };
  },
  props: {
    id: String,
    action: String,
  },
  computed: {
    totalPages() {
      return Math.ceil(this.services.length / this.pageSize);
    },
    paginatedServices() {
      const start = (this.currentPage - 1) * this.pageSize;
      const end = start + this.pageSize;
      return this.services.slice(start, end);
    },
    placeholders() {
      const numServices = this.paginatedServices.length;
      const placeholdersNeeded = this.pageSize - numServices;
      return Array.from({ length: placeholdersNeeded }, (_, i) => i);
    },
  },
  methods: {
    getServices() {
      axios.get(`/agence/${this.id}/services`)
        .then(response => {
          this.services = response.data.map(service => {
            const currentTime = new Date().toLocaleTimeString('it-IT');
            if (currentTime < service.heure_debut && service.etat==='ACTIF') {
              service.etat = `Commence à ${service.heure_debut}`;
            } else if (currentTime > service.heure_fin && service.etat==='ACTIF') {
              service.etat = `Terminé à ${service.heure_fin}`;
            }
            return service;
          });
          this.loading = false; // Stop loading when data is fetched
        })
        .catch(error => {
          console.error('Erreur lors de la récupération des services:', error);
        });
    },
    clickService(id, action) {
      if (action === 'ticket') {
        this.$router.push(`/agence/${this.$route.params.id}/ticket-dispenser/services/${parseInt(id)}`);
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
    },
  },
  created() {
    this.getServices();
  },
};
</script>

<style scoped>
:root {
  --shadow-color: 0deg 0% 45%;
  --shadow-elevation-high:
    0px 0.2px 0.2px hsl(var(--shadow-color) / 0.6),
    0.1px 1.2px 1.3px -0.4px hsl(var(--shadow-color) / 0.58),
    0.2px 2.4px 2.5px -0.8px hsl(var(--shadow-color) / 0.55),
    0.4px 4.1px 4.4px -1.3px hsl(var(--shadow-color) / 0.53),
    0.6px 6.9px 7.3px -1.7px hsl(var(--shadow-color) / 0.51),
    1px 11.2px 11.9px -2.1px hsl(var(--shadow-color) / 0.48),
    1.6px 17.4px 18.5px -2.5px hsl(var(--shadow-color) / 0.46),
    2.4px 26px 27.6px -2.9px hsl(var(--shadow-color) / 0.44);
}

.title {
  font-family: 'Open Sans', sans-serif;
  font-size: 2.5rem;
  font-weight: 700;
  color: #023047;
  text-align: center;
  margin-bottom: 10px;
  text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.1);
  padding: 20px;
}

.home-page {
  text-align: center;
  margin: 20px;
}

.services {
  margin: auto;
  width: 600px; /* Adjust the width to fit your design */
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
  border-radius: 10px 0 10px 0;
  width: 90%; /* Full width within the flex item */
  height: 25%; /* Set explicit height */
  display: flex; /* Flex display */
  align-items: center; /* Center text vertically */
  justify-content: center; /* Center text horizontally */
}

.btn-solid-lg {
  display: inline-block;
  padding: 1.375rem 2.625rem;
  border: 0.125rem solid #023047;
  border-radius: 1rem;
  background-color: #023047;
  color: #fff;
  font: 700 0.875rem / 1 "Open Sans", sans-serif;
  text-decoration: none;
  box-shadow: 0px 0px 5px 1px rgba(2,48,71,1);
  transition: all 0.2s;
  text-align: center;
}

.btn-solid-lg.page-scroll:hover {
  background-color: #fff;
  border-color: #023047;
  color: #023047;
}

.pagination {
  display: flex;
  justify-content: space-between;
  align-items: center;
  width: 100%;
  max-width: 600px;
  margin-top: 20px;
}

.pagination button {
  box-shadow: rgba(0, 0, 0, 0.1) 0px 0px 5px 0px, rgba(0, 0, 0, 0.1) 0px 0px 1px 0px;
  width: 100px;
  padding: 10px 20px;
  margin: 0 5px;
  border: none;
  border-radius: 5px;
  background-color: #023047;
  color: white;
  cursor: pointer;
}

button:disabled {
  background-color: grey;
  border: grey;
  cursor: not-allowed;
}

/* Override hover styles for disabled buttons */
button:disabled:hover {
  background-color: grey; /* Keep the background color the same */
  border: grey; /* Keep the border color the same */
}

.btn-solid-lg.page-scroll:disabled:hover {
  background-color: grey;
  border-color: grey;
  color: #fff;
}

.placeholder {
  visibility: hidden; /* Hide the placeholder button */
}

.agency-name {
  margin: 0;
  font-size: 1.25rem;
  color: #333;
}

.agency-details {
  margin: 0.25rem 0;
}
</style>
