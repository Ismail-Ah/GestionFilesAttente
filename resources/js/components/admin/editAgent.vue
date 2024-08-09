<template>
    <PageContent  activeItem1="Agents" :role="role">
      <Select itemType1="Agence" typeForm="agent" apiEndpoint1="agencies"  itemType3="Agent" apiEndpoint3="agents"  :role="role"  itemType2="Service"
  apiEndpoint2="services" :agentSelect="agent" :role2="role2"/>
    </PageContent>
  </template>
  
  
  <script>
  import PageContent from '../layout/PageContent.vue';
  import Select from '../select.vue';
  
  export default {
    name:'EditAgent',
    props:{
      role:String,
      agent:[Number,String],
      role2:String,
    },
    components:{Select,PageContent}
  }
  </script>
  
  <style scoped>
  
  </style>