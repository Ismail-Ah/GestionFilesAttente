<template>
  <ReusableList
    title="Services"
    fetchUrl='/services1'
    :headers="['Nom', 'Agence', 'Agent', 'Date de création']"
    :fields="['nom', 'agence.nom', 'agent.nom']"
    cardClass="card card-success"
    :role = "role"
    :role1="role1"
    :user_id = "user_id"

    :data1="services"
    :canEdit="role!='ADMIN'"
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
    role1:String,
    role: String,
    user_id:Number,
    services:Object,
    
  }
};
</script>
