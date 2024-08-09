<template>
    <div style="display: flex; flex-direction: column; align-items: center; margin-top: -5%; width: 100%;">

    <div class="service-statistique">
      <h1 class="title">{{$t('StatistiquesService')}}</h1>
      <Statistiques name="service" :name_id="service_id"></Statistiques>
      
      <button class="btn-solid-lg page-scroll quiter"  @click="prendreTicket(false)">{{$t('Quiter')}}</button>
      <BackButton class="back-button"></BackButton>
      <button class="btn-solid-lg page-scroll" style="background-color: #FB8500;border-color: #FB8500;font-size: 1.6rem; /* Slightly larger for emphasis */
  line-height: 1.4;
  font-weight: 700;
  text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.5);"  @click="prendreTicket(true)">{{$t('prendreTicket')}}</button>
    </div>
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

.back-button {
  position: absolute;
  bottom: 10px; /* Adjust this value to position vertically */
  left: 20px;   /* Adjust this value to position horizontally */
}

.quiter {
  position: absolute;
  bottom: 10px; /* Adjust this value to position vertically */
  left: 180px;   /* Adjust this value to position horizontally */
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

  </style>
  