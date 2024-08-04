<template>
  <div class="card card-primary" style="margin-top: 20px">
    <div class="card-header">
      <h3 class="card-title">{{ title }}</h3>
      <div v-if="title !== 'Ajouter un Service' && title !== 'Ajouter un Agence'" class="card-tools">
        <button type="button" class="btn btn-tool btn-danger bg-danger" data-card-widget="collapse" @click="deleteItem">
          <i class="fas fa-trash"></i> Supprimer {{ name }}
        </button>
      </div>
    </div>

    <form @submit.prevent="handleSubmit" class="form-container">
      <div v-if="loading" class="spinner-wrapper">
        <LoadingSpinner3 />
      </div>

      <div class="card-body">
        <div class="form-row">
          <div
            v-for="input in inputs"
            :key="input.id"
            class="form-group"
            :class="{'col-md-6': input.id === 'heure_debut' || input.id === 'heure_fin', 'col-md-12': input.id !== 'heure_debut' && input.id !== 'heure_fin'}"
            :style="(input.id === 'heure_debut' || input.id === 'heure_fin') ? 'display: inline-block;' : ''"
          >
            <label :for="input.id">{{ input.label }}</label>
            <div class="input-group">
              <input
                :class="['form-control', { 'arabic-input': input.id === 'nom_ar' && input.isArabic }]"
                :type="input.type"
                :id="input.id"
                v-model="input.model"
                :placeholder="input.id === 'nom_en' || input.id === 'nom_ar' ? '' : input.id"
                :autocomplete="input.autocomplete"
              />
              <div v-if="input.id === 'nom_ar'" class="input-group-append">
                <button class="btn btn-outline-secondary" type="button" @click="showArabicKeyboard">
                  <i class="fas fa-keyboard"></i>
                </button>
              </div>
            </div>
          </div>
          <div style="display: flex; justify-content: center; align-items: center; width:100%;height: 100%;">
  <p v-if="errorMessage" style="color: red; text-align: center; margin: 0; padding: 10px;" class="alert shadow-sm">{{ errorMessage }}</p>
</div>

        </div>
      </div>

      <div class="card-footer" style="display: flex; justify-content: center;">
          
        <button type="submit" class="btn btn-primary">Submit</button>
      </div>
    </form>

    <div v-if="showKeyboard" id="simple-keyboard" class="simple-keyboard"></div>
  </div>
</template>

<script>
import axios from 'axios';
import Keyboard from 'simple-keyboard';
import 'simple-keyboard/build/css/index.css';
import LoadingSpinner3 from '../LoadingSpinner3.vue'; // Import your spinner component

export default {
  name: 'AddItem',
  components: {
    LoadingSpinner3
  },
  props: {
    title: {
      type: String,
      required: true
    },
    id_item: Number,
    name: {
      type: String,
      required: true
    },
    inputs: {
      type: Array,
      required: true
    },
    action: {
      type: String,
      required: true
    }
  },
  data() {
    return {
      successMessage: '',
      errorMessage: '',
      keyboard: null,
      showKeyboard: false,
      loading: false // Track loading state
    };
  },
  methods: {
    handleSubmit() {
      this.loading = true; // Show spinner
      const data = this.inputs.reduce((obj, input) => {
        obj[input.id] = input.model;
        return obj;
      }, {});
      axios.post(this.action, data)
        .then(response => {
          this.successMessage = response.data.message;
          this.errorMessage = '';
          this.resetForm();
          this.$router.go(-1);
        })
        .catch(error => {
          if (error.response && error.response.data && error.response.data.errors) {
            this.errorMessage = Object.values(error.response.data.errors).flat().join(', ');
          } else {
            this.errorMessage = error.message;
          }
        })
        .finally(() => {
          this.loading = false; // Hide spinner
        });
    },
    deleteItem() {
      let id = this.id_item;
      let choix = confirm(`Tapez ok pour supprimer cette ${this.name} ?`);
      if (choix) {
        let url = 'api/agences';
        if (this.name === 'Service') url = 'api/services';
        axios.delete(`${url}/${id}`).then(response => {
          console.log("L'élément a été supprimé");
          this.$router.go(-1);
        }).catch(error => {
          console.error("Erreur");
        });
      }
    },
    resetForm() {
      this.inputs.forEach(input => {
        input.model = '';
      });
      this.successMessage = '';
      this.errorMessage = '';
    },
    showArabicKeyboard() {
      if (!this.keyboard) {
        this.showKeyboard = true;
        this.keyboard = new Keyboard({
          onChange: input => this.onChange(input),
          onKeyPress: button => this.onKeyPress(button),
          layout: {
            default: [
              "ض ص ث ق ف غ ع ه خ ح ج د",
              "ش س ي ب ل ا ت ن م ك ط",
              "ئ ء ؤ ر لا ى ة و ز ظ",
              "َ ُ ْ ً ٍ ِ ّ ﭐ ﭑ ﻼ ﻵ ﻷ ﻹ ﻯ",
              "{space} {ok} {clear} {quit}"
            ]
          },
          display: {
            '{space}': 'Espace',
            '{ok}': 'OK',
            '{clear}': 'Supprimer Tout',
            '{quit}': 'Quitter'
          }
        });
        this.keyboard.setOptions({
          inputName: "nom_ar",
          input: this.inputs.find(input => input.id === 'nom_ar').model
        });
      } else {
        this.keyboard = null;
        this.showKeyboard = false;
      }
    },
    onChange(input) {
      const inputField = this.inputs.find(input => input.id === 'nom_ar');
      if (inputField) {
        inputField.model = input;
      }
    },
    onKeyPress(button) {
      if (button === '{space}') {
        this.handleSpace();
      } else if (button === '{ok}') {
        this.handleOk();
      } else if (button === '{clear}') {
        this.handleClear();
      } else if (button === '{quit}') {
        this.handleQuit();
      } else {
        console.log("Button pressed", button);
      }
    },
    handleSpace() {
      const inputField = this.inputs.find(input => input.id === 'nom_ar');
      if (inputField) {
        inputField.model += ' ';
      }
    },
    handleOk() {
      this.showKeyboard = false;
      setTimeout(() => {
        this.keyboard = null;
      }, 100);
    },
    handleClear() {
      const inputField = this.inputs.find(input => input.id === 'nom_ar');
      if (inputField) {
        inputField.model = '';
      }
    },
    handleQuit() {
      this.showKeyboard = false;
      setTimeout(() => {
        this.keyboard = null;
      }, 100);
    }
  },
  created() {
    const csrfToken = document.head.querySelector('meta[name="csrf-token"]').content;
    axios.defaults.headers.common['X-CSRF-TOKEN'] = csrfToken;
  }
};
</script>

<style scoped>
.success-message {
  margin-top: 1rem;
  color: green;
}

.error-message {
  margin-top: 1rem;
  color: red;
}

.arabic-input {
  direction: rtl;
  font-family: 'Arial', sans-serif;
}

.simple-keyboard {
  position: fixed;
  top: 0;
  background-color: #219EBC;
  width: 50%;
  max-width: 600px;
  z-index: 9999;
}

.simple-keyboard .hg-button {
  width: 50px;
  height: 40px;
  font-size: 14px;
}

.simple-keyboard .hg-key {
  margin: 2px;
}

.form-container {
  position: relative; /* To position the spinner absolutely within the form */
}

.spinner-wrapper {
  display: flex;
  justify-content: center;
  align-items: center;
  position: absolute;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
  width: 100%;
  height: 100%;
  background-color: rgba(255, 255, 255, 0.8); /* Optional: to give a background overlay */
  z-index: 1000; /* Ensure it appears above other content */
}
</style>
