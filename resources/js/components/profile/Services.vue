<template>
  <ReusableList
    title="Services"
    fetchUrl='/services'
    :headers="['Nom', 'Agence', 'Agent', 'Date de création']"
    :fields="['nom', 'agence.nom', 'agent.nom']"
    cardClass="card card-success"
    :role = "role"
    :user_id = "user_id"
    :data1="services"
  />
</template>

<script>
import ReusableList from './tem.vue';

export default {
  name: 'ServicesList',
  components: {
    ReusableList,
  },
  data(){
    return {
      
    }
  },
  props: {
    role: String,
    user_id:Number,
    services:Object,
    
  }
};
</script>
