<template>
  <PageContent :role="role">
    <div class="wrapper">
      <div class="content-header">
        <div style="margin: auto;width: 50%;">
          <AddItem
            name="Agence"
            :inputs="inputs"
            action="/agencies"
          />
        </div>
      </div>
    </div>
  </PageContent>
</template>

<script>
import AddItem from './AddItem.vue';
import PageContent from '../layout/PageContent.vue';
export default {
  name :'ajouterAgence',
  components: {
    AddItem,
    PageContent
  },
  props:{
    role:String,
  },
  data() {
    return {
      inputs: [
        { tagName:'input', label: 'Nom de l\'agence', id: 'nom', model: '', type: 'text', autocomplete: 'organization', value: '' },
        { tagName:'input',label: 'Email de l\'agence', id: 'email', model: '', type: 'email', autocomplete: 'email', value: '' },
        { tagName:'input',label: 'Emplacement', id: 'adress', model: '', type: 'text', autocomplete: 'address', value: '' },
        { tagName:'input',label: 'Téléphone de l\'agence', id: 'telephone', model: '', type: 'text', autocomplete: 'tel', value: '' }
      ]
    };
  }
};
</script>

<style scoped>
/* Add any additional styles if necessary */
</style>
