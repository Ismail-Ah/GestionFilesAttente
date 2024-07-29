<template>

    
      <h1>{{$t('SelectService')}}</h1>
      <Services :id="id" action="ticket" ></Services>
      <BackButton></BackButton>

  </template>
  
  <script>
import BackButton from './retour.vue';
import Services from '../admin/services.vue';

  export default {
    name: 'ServiceSelection',
    data(){
      return {
        id:this.$route.params.id,

      };
    },
    components:{BackButton,Services},
    methods: {
      selectService(service) {
        this.$router.push(`/agence/${this.id}/ticket-dispenser/statistique`);
        // Add further logic here, e.g., navigating to a ticket page or saving the selection
      },
    },
  };
  </script>
  
  <style scoped>
  .service-selection {
    text-align: center;
    margin: 20px;
  }
  

  </style>
  






