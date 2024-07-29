<template>
  <ReusableList
    title="Agences"
    fetchUrl="/agences"
    :headers="['Nom', 'Adresse', 'Email', 'Téléphone', 'Date de création']"
    :fields="['nom', 'adress', 'email', 'telephone']"
  />
</template>

<script>
import ReusableList from './tem.vue';

export default {
  name: 'Agences',
  components: {
    ReusableList,
  },
};
</script>
