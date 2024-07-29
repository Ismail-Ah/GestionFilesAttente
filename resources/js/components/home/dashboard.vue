<template>
    <PageContent>
    <div>
      <AgentDashboard v-if="role === 'AGENT'" />
      <AdminDashboard v-else-if="role === 'ADMIN' || role==='ADMINISTRATION'" />
      <!-- Add more conditional rendering as needed -->
    </div>
  </PageContent>
  </template>
  
  <script>
  import AgentDashboard from '../agent/AgentDashboard.vue';
  import AdminDashboard from '../admin/AdminDashboard.vue';
import PageContent from '../layout/PageContent.vue';
  
  export default {
    name: 'Dashboard',
    props: {
      role: {
        type: String,
        required: true
      }
    },
    components: {
      AgentDashboard,
      AdminDashboard,
      PageContent
    }
  };
  </script>
  
  <style scoped>
  /* Add styles if needed */
  </style>
  