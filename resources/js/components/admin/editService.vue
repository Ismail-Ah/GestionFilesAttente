<template>
    <PageContent>
        <Select
  itemType1="Agence"
  itemType2="Service"
  apiEndpoint1="agencies"
  apiEndpoint2="services"
  typeForm="service"
  role="admin"
/>

    </PageContent>
  </template>
  
  <script>
  import Select from '../select.vue';
  import PageContent from '../layout/PageContent.vue';
  import axios from 'axios';
  export default {
    name :'EditService',
    components: {
      Select,
      PageContent
    },
  };
  </script>

  <style scoped>
  </style>
  