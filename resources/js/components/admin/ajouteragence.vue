<template>
  <PageContent activeItem1="Agences" :role="role">
    <div class="wrapper">
      <div class="content-header">
        <div style="margin: auto;width: 50%;">
          <AddItem
            name="Agence"
            title="Ajouter un Agence"
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
        {
          tagName: 'input',
          label: 'Nom de l\'Agence (Arabic) (Optionnel)',
          id: 'nom_ar',
          model: '',
          type: 'text',
          autocomplete: 'organization',
          value: '',
        },
        { tagName:'input',label: 'Email de l\'agence', id: 'email', model: '', type: 'email', autocomplete: 'email', value: '' },
        { tagName:'input',label: 'Emplacement', id: 'adress', model: '', type: 'text', autocomplete: 'address', value: '' },
        { tagName:'input',label: 'Téléphone de l\'agence', id: 'telephone', model: '', type: 'text', autocomplete: 'tel', value: '' }
      ]
    };
  },
  created(){
    localStorage.removeItem(`agences`);
    localStorage.removeItem(`Agences`);

    localStorage.removeItem(`Agences1`);

  }
};
</script>

<style scoped>
/* Add any additional styles if necessary */
</style>
