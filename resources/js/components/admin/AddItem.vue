<template>
  <div class="card card-primary">
    <div class="card-header">
      <h3 class="card-title">{{ title }}</h3>
      <div class="card-tools">
        <button type="button" class="btn btn-tool btn-danger bg-danger" data-card-widget="collapse" @click="deleteItem">
          <i class="fas fa-trash"></i> Supprimer {{ name }}
        </button>
      </div>
    </div>

    <form @submit.prevent="handleSubmit">
      <div class="card-body">
        <div v-for="input in inputs" :key="input.id" class="form-group">
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

export default {
  name: 'AddItem',
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
      showKeyboard: false
    };
  },
  methods: {
    handleSubmit() {
      const data = this.inputs.reduce((obj, input) => {
        obj[input.id] = input.model;
        return obj;
      }, {});
      axios.post(this.action, data)
        .then(response => {
          alert(response.data.message);
          this.resetForm();
          this.$router.go(-1);
        })
        .catch(error => {
          if (error.response && error.response.data && error.response.data.errors) {
            console.error('Validation errors:', error.response.data.errors);
          } else {
            console.error('Error updating service:', error.message);
          }
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
        this.showKeyboard=true;
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
      }
      else {this.keyboard=null;this.showKeyboard=false;}

      
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
      // Delay keyboard destruction to allow click to register
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
      // Delay keyboard destruction to allow click to register
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
  font-family: 'Arial', sans-serif; /* You can use a specific Arabic font if needed */
}

.simple-keyboard {
  position: fixed;
  top: 0;
  background-color:#219EBC;
  width: 50%;
  max-width: 600px; /* Adjust the width of the keyboard */
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
</style>
