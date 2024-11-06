<template>
  <div class="wrapper">
    <div class="content-header">
      <div class="row">

        <div v-if="itemType3==='Agent'" :class="class_val">
          <div class="form-group">
            <label>Sélectionner Role</label>
            <div class="position-relative d-flex align-items-center">
              <select class="form-control" v-model="role1" @change="fetchRole">
                <option value="AGENT">AGENT</option>
                <option value="ADMINISTRATION">ADMINISTRATEUR</option>
              </select>
            </div>
          </div>
        </div>


        <div  v-if="this.role1==='AGENT'"  :class="class_val">
          <div class="form-group">
            <label>Sélectionner {{ itemType1 }}</label>
            <div class="position-relative d-flex align-items-center">
              <select class="form-control" v-model="selectedItemType1" @change="fetchItem2">
                <option value="">{{ itemType1 }}</option>
                <option v-for="item in items1" :key="item.id" :value="item.id">
                  Ag{{ item.id }} | {{ item.nom }} - {{ item.adress }}
                </option>
              </select>
            </div>
          </div>
        </div>
        <div   :class="class_val" v-if="this.role1==='AGENT' && itemType2 === 'Service'">
          <div  class="form-group">
            <label>Sélectionner {{ itemType2 }}</label>
            <div class="position-relative d-flex align-items-center">
              <select class="form-control" :disabled="!selectedItemType1" v-model="selectedItemType2" @change="fetchItem3">
                <option value="">{{ itemType2 }}</option>
                <option v-for="item2 in items2" :key="item2.id" :value="item2.id">
                  S{{ item2.id }} | {{ item2.nom }}
                </option>
              </select>
            </div>
          </div>
        </div>
        <div v-if="itemType3 === 'Agent'" :class="class_val">
          <div class="form-group">
            <label>Sélectionner Utilisateur</label>
            <div class="position-relative d-flex align-items-center">
              <select class="form-control" v-model="selectedItemType3">
                <option value="">Utilisateur</option>
                <option v-for="item3 in items3" :key="item3.id" :value="item3.id">
                  {{ item3.nom }}
                </option>
              </select>
            </div>
          </div>
        </div>
      </div>
    </div>
    <section class="content">
      <div class="container-fluid">
        <div v-if="typeForm === 'agent'">
          <div v-if="selectedItemType3 &&  this.items3.length!=0">
            <div style="margin: auto; width: 50%;">
              <EditerAgent :role="role" style="margin-top: -20px;" :agent="selectedAgent"/>
            </div>
          </div>
        </div>
        <div v-else>
          <div v-if="selectedItemType2">
            <div style="margin: auto; width: 50%;">
              <AddItem
                :title="`Modifier ${itemType2}`"
                :name="`${itemType2}`" 
                :inputs="inputItems2"
                :action="`/${apiEndpoint2}/${selectedItemType2}/update`"
                :id_item="selectedItemType2"
              />
            </div>
          </div>
          <div v-else-if="!itemType2 && selectedItemType1">
            <div style="margin: auto; width: 50%;">
              <AddItem style="margin-top: -20px;"
                :title="`Modifier ${itemType1}`"
                :name="`${itemType1}`" 
                :inputs="inputItems1"
                :action="`/${apiEndpoint1}/${selectedItemType1}/update`"
                :id_item="selectedItemType1"
              />
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>
</template>

<script>
import axios from 'axios';
import AddItem from './admin/AddItem.vue';
import EditerAgent from './admin/editerAgent.vue';

export default {
  name: 'Select',
  components: { AddItem, EditerAgent},
  props: {
    role: {
      type: String,
      required: true
    },
    itemType1: {
      type: String,
      required: true
    },
    itemType2: {
      type: String,
      required: true
    },
    itemType3: {
      type: String,
      required: true
    },
    apiEndpoint1: {
      type: String,
      required: true
    },
    apiEndpoint2: {
      type: String,
      required: true
    },
    apiEndpoint3: {
      type: String,
      required: true
    },
    agenceSelect:[Number,String],
    serviceSelect:[Number,String],
    agentSelect:[Number,String],
    typeForm: String,
    role2:String,
  },
  data() {
    return {
      class_val : this.itemType3?'col-sm-3 choix' : 'col-sm-6 choix',
      selectedItemType1: this.agenceSelect,
      selectedItemType2: '',
      selectedItemType3: '',
      items1: [],
      items2: [],
      items3: [],
      items4: [],
      role1:this.role2||'AGENT',
      associatedAgence: null,
      loading: true
    };
  },
  methods: {
    fetchRole(){
      if(this.role1!='AGENT'){
        this.selectedItemType1= "";
        this.selectedItemType2="";
        this.selectedItemType3="";
        this.items3 = this.items4.filter(item => item.role === this.role1);
      }
      else{
        this.selectedItemType3="";
        if (this.selectedItemType1 || this.selectedItemType2){
          this.items3 = this.items3.filter(item => item.role === this.role1);
        }
        else this.items3 = this.items4.filter(item => item.role === this.role1);
      } 
    },
    fetchItem1() {
      const cachedAgences = localStorage.getItem('Agences');
      if (cachedAgences) {
        this.items1 = JSON.parse(cachedAgences);
      } else {
      axios.get('/agencies', {
        headers: {
          'Authorization': `Bearer ${localStorage.getItem('token')}`
        }
      })
        .then(response => {
          this.items1 = response.data;
          localStorage.setItem('Agences', JSON.stringify(response.data));
          this.loading = false;
        })
        .catch(error => {
          console.error('Error fetching agencies:', error);
        });
      }
      if(this.itemType2){
        this.fetchItem2();
      }
      
    },
    
    async fetchItem2() {
  if (this.selectedItemType1) {
    try {
      const cachedServices = localStorage.getItem(`Agence${this.selectedItemType1}Services`);
      if (cachedServices) {
        try {
          this.items2 = JSON.parse(cachedServices);
        } catch (parseError) {
          console.error('Error parsing cached services:', parseError);
          this.items2 = [];
        }
      } else {
        const response = await axios.get(`/agence/${this.selectedItemType1}/services`);
        this.items2 = response.data;
        localStorage.setItem(`Agence${this.selectedAgence}Services`, JSON.stringify(this.items2)); // Corrected to use this.items2
      }
      this.loading = false;
    } catch (error) {
      console.error('Error fetching services:', error);
      this.items2 = []; 
      this.selectedService = ''; 
      this.loading = false;
    }
    this.fetchItem3();
  }
},

    
    fetchItem3() {
      let url = '/edit/agents';
      if (this.selectedItemType2) {
        let service = this.items2.find(item => item.id === this.selectedItemType2);
        this.items3 = this.items4.filter(item => item.id === service.user_id);
        this.fetchRole();
      } else if (this.selectedItemType1) {
        this.items3 = this.items4.filter(item => item.agence && item.agence.id === this.selectedItemType1);
        this.fetchRole();
      } else {
        axios.get(url)
          .then(response => {
            this.items4 = response.data;

            this.items3 = this.items4;
            this.fetchRole();
            this.loading = false;
          })
          .catch(error => {
            console.error(`Error fetching ${this.itemType3.toLowerCase()}s:`, error);
            this.loading = false;
          });
      }
      
    }
  },
  computed: {
    selectedAgent() {
      let agent = this.items3.find(item => item.id === parseInt(this.selectedItemType3)) || {};
      return agent;
    },
    inputItems1() {
      if (!this.selectedItemType1 || this.items1.length===0) return [];
      const item = this.associatedAgence || this.items1.find(i => i.id == this.selectedItemType1);
      if (this.typeForm === 'agence') {
        return [
          { tagName: 'input', label: 'Nom de l\'agence', id: 'nom', model: item.nom, type: 'text', autocomplete: 'organization', value: '' },
          {
        tagName: 'input',
        label: 'Nom de l\'Agence (Arabe) (Optionnel)',
        id: 'nom_ar',
        model: item.nom_ar,
        type: 'text',
        autocomplete: 'off',
        value: '',
    },
          { tagName: 'input', label: 'Email de l\'agence', id: 'email', model: item.email, type: 'email', autocomplete: 'email', value: '' },
          { tagName: 'input', label: 'Emplacement', id: 'adress', model: item.adress, type: 'text', autocomplete: 'address', value: '' },
          { tagName: 'input', label: 'Téléphone de l\'agence', id: 'telephone', model: item.telephone, type: 'text', autocomplete: 'tel', value: '' }
          
        ];
      } else {
        return [];
      }
    },
    inputItems2() {
  if (!this.selectedItemType2 || this.items2.length===0) return [];
  if (this.typeForm === 'service') {
    const item = this.items2.find(i => i.id == this.selectedItemType2);
    return [
    { 
        tagName: 'input', 
        label: 'Nom de service', 
        id: 'nom', 
        model: item.nom, 
        type: 'text', 
        autocomplete: 'organization', 
        value: '' 
    },
    { 
        tagName: 'input', 
        label: 'Heure de Début', 
        id: 'heure_debut', 
        model: item.heure_debut, 
        type: 'time', 
        autocomplete: 'off', 
        value: '' 
    },
    { 
        tagName: 'input', 
        label: 'Heure de Fin', 
        id: 'heure_fin', 
        model: item.heure_fin, 
        type: 'time', 
        autocomplete: 'off', 
        value: '' 
    },
    {
        tagName: 'input',
        label: 'Nom de Service (English) (Optionnel)',
        id: 'nom_en',
        model: item.nom_en,
        type: 'text',
        autocomplete: 'off',
        value: '',
    },
    {
        tagName: 'input',
        label: 'Nom de Service (Arabe) (Optionnel)',
        id: 'nom_ar',
        model: item.nom_ar,
        type: 'text',
        autocomplete: 'off',
        value: '',
    },
];

  } else {
    return [];
  }
}

    

  },
  created() {
    if (this.itemType3) {
      this.selectedItemType1="";
      this.selectedItemType2="";
      this.fetchItem3();
      this.selectedItemType3=this.agentSelect;

    }
    this.fetchItem1();
    if(this.selectedItemType1){
      this.fetchItem2();
      this.selectedItemType2=this.serviceSelect;
    }
  },
  watch: {
    selectedItemType1(newValue) {
 
        this.fetchItem2();

      if (this.typeForm === 'agent' && !newValue) {
        this.selectedItemType2 = "";
        this.fetchItem3();
      }
    },
    selectedItemType2(newValue) {
      if (this.typeForm === 'agent' && !newValue) {
        this.fetchItem3();
      }
    },
  }
};
</script>
