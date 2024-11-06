<template>
  <ReusableList
    title="Agents"
    fetchUrl="/agents"
    :headers="headers"
    :fields="fields"
    cardClass="card card-warning"
    :data1="agents"
        :canEdit="role!='AGENT'"
  />
</template>

<script>
import ReusableList from './tem.vue';

export default {
  name: 'Agents',
  components: {
    ReusableList,
  },
  props: {
    agents: {
      type: Array,
      required: true
    },
    role: {
      type: String,
      required: true
    }
  },
  computed: {
    headers() {
      console.log(this.role);
      const baseHeaders = ['Nom', 'Email', 'Date de création'];
      if (this.role !== 'ADMIN') {
        baseHeaders.splice(2, 0, 'Agence'); // Insert 'Agence' before 'Date de création'
      }
      return baseHeaders;
    },
    fields() {
      const baseFields = ['nom', 'email', ];
      if (this.role !== 'ADMIN') {
        baseFields.splice(2, 0, 'agence.nom'); // Insert 'agence.nom' before 'date_creation'
      }
      return baseFields;
    }
  }
};
</script>
