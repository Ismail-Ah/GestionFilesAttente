<template>
    <PageContent>
      <Select itemType1="Agence" typeForm="agent" apiEndpoint1="agencies"  itemType3="Agent" apiEndpoint3="agents"  role="admin"  itemType2="Service"
  apiEndpoint2="services"/>
    </PageContent>
  </template>
  
  
  <script>
  import PageContent from '../layout/PageContent.vue';
  import Select from '../select.vue';
  
  export default {
    name:'EditAgent',
    components:{Select,PageContent}
  }
  </script>
  
  <style scoped>
  
  </style>