<template>
  <ReusableList
    title="Services"
    fetchUrl="/services"
    :headers="['Nom', 'Agence', 'Agent', 'Date de création']"
    :fields="['nom', 'agence.nom', 'agent.nom']"
    cardClass="card card-success"
  />
</template>

<script>
import ReusableList from './tem.vue';

export default {
  name: 'ServicesList',
  components: {
    ReusableList,
  },
};
</script>
