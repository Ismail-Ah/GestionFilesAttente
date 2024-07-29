<template>
  <PageContent>
    <Select itemType1="Agence" typeForm="agence" apiEndpoint1="agencies" role="admin"/>
  </PageContent>
</template>


<script>
import PageContent from '../layout/PageContent.vue';
import Select from '../select.vue';

export default {
  name:'EditAgence',
  components:{Select,PageContent}
}
</script>

<style scoped>

</style>