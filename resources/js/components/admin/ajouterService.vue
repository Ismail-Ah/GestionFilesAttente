<template>
  <PageContent activeItem1="Services" :role="role">
    <div class="wrapper">

    <div v-if="!dashboard">
      <div class="content-header">
      <div class="row">
        <div class='col-sm-6 choix'>
          <div class="form-group">
            <label>Sélectionner Agence</label>
            <div class="position-relative d-flex align-items-center">
              <select class="form-control" v-model="selectedAgence" @change="fetchForm">
                <option value="">Agence</option>
                <option v-for="item in agences" :key="item.id" :value="item.id">
                  Ag{{ item.id }} | {{ item.nom }} - {{ item.adress }}
                </option>
              </select>
            </div>
          </div>
        </div>
      </div>
      <div v-if="showForm" style="margin: auto;width: 50%;">
          
          <AddItem
            name="Service"
            title="Ajouter un Service"
            :inputs="inputs"
            :action="`/agence/${this.selectedAgence}/ajouter-service`"
          />
        </div>
    </div>
        
    </div>
    <div v-else>
      <div class="content-header">
      <div style="margin: auto;width: 50%;">
          <AddItem
            name="Service"
            title="Ajouter un Service"
            :inputs="inputs"
            :action="`/agence/${this.$route.params.id}/ajouter-service`"
          />
        </div>
      </div>
    </div>
    </div>
    
  </PageContent>
</template>

<script>
import AddItem from './AddItem.vue';
import PageContent from '../layout/PageContent.vue';
import axios from 'axios';
export default {
  name: 'ajouterService',
  props:{
    role:String,
    dashboard:Boolean,
  },
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
      selectedAgence:'',
      agences: [],
      showForm:false,
    };
  },
  methods:{
    fetchItem1() {
      const cachedAgences = localStorage.getItem('Agences');
      if (cachedAgences) {
        this.agences = JSON.parse(cachedAgences);
      } else {
      axios.get('/agencies')
        .then(response => {
          this.agences = response.data;
          console.log(response.data);

          localStorage.setItem('Agences', JSON.stringify(response.data));
          this.loading = false;
        })
        .catch(error => {
          console.error('Error fetching agencies:', error);
        });
      }
    },
    fetchForm(){
      this.showForm=true;
      if (this.selectedAgence) {
        localStorage.removeItem(`Agence${this.selectedAgence}Services`);
        localStorage.removeItem(`Agence${this.selectedAgence}ServicesAgent`);

      };
    }
  },
  created(){
    if(!this.dashboard){
      this.fetchItem1();
    }
    else {
      localStorage.removeItem(`Agence${this.$route.params.id}Services`);
      localStorage.removeItem(`Agence${this.$route.params.id}ServicesAgent`);

    }
   
  }
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
