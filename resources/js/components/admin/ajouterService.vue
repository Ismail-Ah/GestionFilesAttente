<template>
  <PageContent>
    <div class="wrapper">
      <div class="content-header">
        <div style="margin: auto;width: 50%;">
          <AddItem
            name="Service"
            title="Ajouter un Service"
            :inputs="inputs"
            :action="`/agence/${this.$route.params.id}/ajouter-service`"
          />
          <p class="optional-info">Les champs de traduction (Anglais et Arabe) sont optionnels.</p>
        </div>
      </div>
    </div>
  </PageContent>
</template>

<script>
import AddItem from './AddItem.vue';
import PageContent from '../layout/PageContent.vue';

export default {
  name: 'ajouterService',
  components: {
    AddItem,
    PageContent,
  },
  data() {
    return {
      inputs: [
        {
          tagName: 'input',
          label: 'Nom de Service',
          id: 'nom',
          model: '',
          type: 'text',
          autocomplete: 'organization',
          value: '',
        },
        
        {
          tagName: 'input',
          label: 'Heure de Début',
          id: 'heure_debut',
          model: '',
          type: 'time',
          autocomplete: 'off',
          value: '',
        },
        {
          tagName: 'input',
          label: 'Heure de Fin',
          id: 'heure_fin',
          model: '',
          type: 'time',
          autocomplete: 'off',
          value: '',
        },
        {
          tagName: 'input',
          label: 'Nom de Service (English) (Optionnel)',
          id: 'nom_en',
          model: '',
          type: 'text',
          autocomplete: 'organization',
          value: '',
        },
        {
          tagName: 'input',
          label: 'Nom de Service (Arabic) (Optionnel)',
          id: 'nom_ar',
          model: '',
          type: 'text',
          autocomplete: 'organization',
          value: '',
        },
      ],
    };
  },
};
</script>

<style scoped>
/* Add any additional styles if necessary */
.optional-info {
  text-align: center;
  font-size: 0.875rem;
  color: #6c757d;
  margin-top: 10px;
}
</style>
