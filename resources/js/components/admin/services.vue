<template>
  
      <div class="agencies">
        <div v-for="service in services" :key="service.id" class="agency-card btn-solid-lg page-scroll" @click="clickService(action,service.id,service.nom)">
          <h2 class="agency-name">{{ service.nom }}</h2>
          <p class="agency-details">{{ service.etat }}</p>
        </div>
      </div>
</template>
  
  <script>
  import axios from 'axios';
  
  export default {
    name: 'Services',
    data() {
      return {
        services: [],
      };
    },
    props:{id:String,action:String},
    methods: {
      getServices() {
        axios.get(`/agence/${this.id}/services`)
          .then(response => {
            this.services = response.data;
          })
          .catch(error => {
            console.error('Erreur lors de la récupération des services:', error);
          });
      },
      clickService(action,id,nom){
        if (action=="ticket"){
          this.$router.push(`/agence/${this.$route.params.id}/ticket-dispenser/services/${parseInt(id)}`)
        }
      }
    },
    created() {
      this.getServices();
    },
  };
  </script>
  
  <style scoped>


  
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
    width: 25%;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
  }
  
  .agency-name {
    margin: 0;
    font-size: 1.25rem;
    color: #333;
  }
  
  .agency-details {
    margin: 0.25rem 0;
    color: rgb(8, 235, 8);
  }
  
  
  </style>
  