<template>
  <ReusableList
    title="Agents"
    fetchUrl="/agents"
    :headers="['Nom', 'Email', 'Agence']"
    :fields="['nom', 'agence.nom']"
    cardClass="card card-warning"
  />
</template>

<script>
import ReusableList from './tem.vue';

export default {
  name: 'AgentsList',
  components: {
    ReusableList,
  },
};
</script>
