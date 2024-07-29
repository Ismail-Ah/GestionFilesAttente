<template>
    <div class="service-statistique">
      <h1>{{$t('StatistiquesService')}}</h1>
      <Statistiques name="service" :name_id="service_id"></Statistiques>
      
      <button class="btn-solid-lg page-scroll"  @click="prendreTicket(false)">{{$t('Quiter')}}</button>
      <BackButton></BackButton>
      <button class="btn-solid-lg page-scroll" style="background-color: tomato;border-color: tomato;"  @click="prendreTicket(true)">{{$t('prendreTicket')}}</button>
    </div>
 
  </template>
  
  <script>
  import BackButton from './retour.vue';
  import axios from 'axios';
import Statistiques from '../statistique.vue';
  export default {
    name: 'serviceStatistique',
    components:{BackButton,Statistiques},
    data(){
      return {
        agence_id:this.$route.params.agence_id,
        service_id:this.$route.params.service_id,
      };
    },
    methods: {
      prendreTicket(e) {
        if (e){
          axios.post(`/agence/${this.agence_id}/ticket-dispenser/services/${this.service_id}/ticket`)
          .then(response => {
            this.$router.push({path:`/agence/${this.agence_id}/ticket-dispenser/services/${this.service_id}/ticket`});
          this.successMessage = `${this.name} ajoutée avec succès!`;
          this.resetForm();
          this.$router.go(-1);
        })
        .catch(error => {
          this.errorMessage = `Erreur lors de l'ajout de la ${this.name}.`;
          console.error(error);
        });

        }
        else this.$router.push({path:`/ticket-dispenser/agences/${this.agence_id}`});
        
      },
    },
  };
  </script>
  
  <style scoped>
  .service-statistique {
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
  