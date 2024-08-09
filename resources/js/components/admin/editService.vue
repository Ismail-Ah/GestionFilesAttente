<template>
    <PageContent  activeItem1="Services" :role="role">
        <Select
  itemType1="Agence"
  itemType2="Service"
  apiEndpoint1="agencies"
  apiEndpoint2="services"
  typeForm="service"
  role="admin"
  :agenceSelect="agence"
  :serviceSelect="service"
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
    props:{
      role:String,
      agence:[Number,String],
      service:[Number,String]
    },
  };
  </script>

  <style scoped>
  </style>
  