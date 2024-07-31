<template>
  <div style="display: flex; flex-direction: column; align-items: center; margin-top: -5%; width: 100%;">
    <h1 class="title">Select Agence</h1>
    <div v-if="loading">
      <LoadingSpinner></LoadingSpinner>
    </div>
    <div v-else class="home-page">
      <div class="agencies">
        <button
          v-for="agence in paginatedAgencies"
          :key="agence.id"
          class="seven btn-solid-lg page-scroll"
          @click="clickAgence(agence.id)"
        >
          {{ agence.nom }}
        </button>
        <button
          v-for="placeholder in placeholders"
          :key="'placeholder-' + placeholder"
          class="seven btn-solid-lg page-scroll placeholder"
          disabled
        >
          Placeholder
        </button>
      </div>
      <div class="pagination">
        <button @click="prevPage" id="previous" :disabled="currentPage === 1"><i class="fas fa-arrow-left"></i></button>
        <button @click="nextPage" id="next" :disabled="currentPage === totalPages"><i class="fas fa-arrow-right"></i></button>
      </div>
    </div>
  </div>
</template>

<script>
import axios from 'axios';
import LoadingSpinner from '../LoadingSpinner.vue';

export default {
  name: 'SelectAgence',
  components: { LoadingSpinner },
  data() {
    return {
      loading: true,
      agencies: [],
      successMessage: '',
      errorMessage: '',
      currentPage: 1,
      pageSize: 4,
    };
  },
  computed: {
    totalPages() {
      return Math.ceil(this.agencies.length / this.pageSize);
    },
    paginatedAgencies() {
      const start = (this.currentPage - 1) * this.pageSize;
      const end = start + this.pageSize;
      return this.agencies.slice(start, end);
    },
    placeholders() {
      const numAgencies = this.paginatedAgencies.length;
      const placeholdersNeeded = this.pageSize - numAgencies;
      return Array.from({ length: placeholdersNeeded }, (_, i) => i);
    },
  },
  methods: {
    getAgencies() {
      axios.get('/agencies')
        .then(response => {
          this.agencies = response.data;
          this.loading = false;
        })
        .catch(error => {
          console.error('Erreur lors de la récupération des agences:', error);
        });
    },
    clickAgence(id) {
      this.$router.push(`/ticket-dispenser/agences/${id}`);
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
    this.getAgencies();
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

.agencies {
  margin: auto;
  height: 200px;
  width: 600px;
  display: flex;
  flex-wrap: wrap;
  justify-content: center;
  align-items: center; /* Ensure buttons are centered vertically */
}

.agencies .seven {
  flex: 1 0 40%; /* Adjust the flex-basis to approximately half width */
  margin: 10px;
  padding: 20px;
  border-radius: 10px;
  width: 130px; /* Set explicit width */
  height: 50px; /* Set explicit height */
  display: flex; /* Add flex display */
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
  -webkit-box-shadow: 0px 0px 5px 1px rgba(2,48,71,1);
  -moz-box-shadow: 0px 0px 5px 1px rgba(2,48,71,1);
  box-shadow: 0px 0px 5px 1px rgba(2,48,71,1);

  margin: 0.5rem;
  margin-top: 40px;
  text-align: center; /* Center text horizontally */
  vertical-align: middle; /* Center text vertically */
}

.btn-solid-lg.page-scroll {
  margin-bottom: 1.125rem;
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
  margin-top: 80px;
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

.pagination button:disabled {
  background-color: grey;
  cursor: not-allowed;
}

.placeholder {
  visibility: hidden; /* Hide the placeholder button */
}
</style>
