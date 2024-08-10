<template>
    <ReusableList
      title="Administrateurs"
      fetchUrl="/agents"
      :headers="headers"
      :fields="fields"

      :data1="administrateurs"
          :canEdit="role!='AGENT'"
    />
  </template>
  
  <script>
  import ReusableList from './tem.vue';
  
  export default {
    name: 'Administrateurs',
    components: {
      ReusableList,
    },
    props: {
        administrateurs: {
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
        return baseHeaders;
      },
      fields() {
        const baseFields = ['nom', 'email', ];
        return baseFields;
      }
    }
  };
  </script>
  