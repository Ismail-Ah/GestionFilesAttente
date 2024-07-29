<template>
  <h1>Select Agence</h1>
  <div v-if="loading">
      <LoadingSpinner></LoadingSpinner>
  </div>
    <div v-else class="home-page">
      
      <div class="agencies">
        <div v-for="agence in agencies" :key="agence.id" class="btn-solid-lg page-scroll" @click="clickAgence(agence.id)">
          <h2 >{{ agence.nom }}</h2>
        </div>
      </div>
    </div>
</template>
  
<script>
  import axios from 'axios';
  import LoadingSpinner from '../LoadingSpinner.vue';
  export default {
    name: 'SelectAgence',
    components :{LoadingSpinner},
    data() {
      return {
        loading:true,
        agencies: [],
        successMessage: '',
        errorMessage: '',
      };
    },
    methods: {
      getAgencies() {
        axios.get('/agencies')
          .then(response => {
            this.agencies = response.data;
            this.loading=false;
          })
          .catch(error => {
            console.error('Erreur lors de la récupération des agences:', error);
          });
      },
      clickAgence(id) {
          this.$router.push(`/ticket-dispenser/agences/${id}`);
    },

    },
    created() {
      this.getAgencies();
    },
  
  };
</script>
  
<style scoped>
.home-page {
  text-align: center;
  margin: 20px;
}

.btn-solid-lg {
  display: inline-block;
  padding: 1.375rem 2.625rem;
  border: 0.125rem solid #fff;
  border-radius: 2rem;
  background-color: #fff;
  color:   #4e3fdd;
  font: 700 0.875rem / 1 "Open Sans", sans-serif;
  text-decoration: none;
  transition: all 0.2s;
  margin: 0.5rem;
  margin-top: 40px;
}

.btn-solid-lg.page-scroll {
  margin-bottom: 1.125rem;
}

.btn-solid-lg.page-scroll:hover {
  background-color:#4e3fdd;
  border-color: #fff;
  color: #fff;
}
</style>
