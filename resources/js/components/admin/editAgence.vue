<template>
  <PageContent  activeItem1="Agences" :role="role">
    <Select itemType1="Agence" typeForm="agence" apiEndpoint1="agencies" role="admin" :agenceSelect="agence"/>
  </PageContent>
</template>


<script>
import PageContent from '../layout/PageContent.vue';
import Select from '../select.vue';

export default {
  name:'EditAgence',
  props:{
    role:String,
    agence:[Number,String],
  },
  components:{Select,PageContent}
}
</script>

<style scoped>

</style>