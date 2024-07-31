<template>
  <div class="language-selection">
    <div class="language-buttons">
      <button @click="selectLanguage('en')" class="btn-solid-lg page-scroll">
        <div class="text-container">
          <h1 class="text-top">Welcome to</h1>
          <h1 class="text-bottom">{{ agence.nom }}</h1>
        </div>
      </button>
      <button @click="selectLanguage('fr')" class="btn-solid-lg page-scroll">
        <div class="text-container">
          <h1 class="text-top">Bienvenue chez</h1>
          <h1 class="text-bottom">{{ agence.nom }}</h1>
        </div>
      </button>
      <button @click="selectLanguage('ar')" class="btn-solid-lg page-scroll">
        <div class="text-container">
          <h1 class="text-top">مرحبا بكم في</h1>
          <h1 class="text-bottom">{{ agence.nom }}</h1>
        </div>
      </button>
    </div>
  </div>
</template>

<script>
import { useI18n } from 'vue-i18n';
import BackButton from './retour.vue';
import { useRouter, useRoute } from 'vue-router';
import axios from 'axios';

export default {
  name: 'HomeVisitor',
  components: { BackButton },
  data() {
    return {
      agence: '',
      loading: true,
    };
  },
  methods: {
    getAgencies() {
      axios.get(`/agences/${this.$route.params.id}`)
        .then(response => {
          this.agence = response.data;
          this.loading = false;
        })
        .catch(error => {
          console.error('Erreur lors de la récupération des agences:', error);
        });
    },
  },
  created() {
    this.getAgencies();
  },
  setup() {
    const { locale } = useI18n();
    const router = useRouter();
    const route = useRoute();

    const selectLanguage = (language) => {
      locale.value = language;
      router.push({ path: `/agence/${route.params.id}/ticket-dispenser/services` });
    };

    return {
      selectLanguage
    };
  }
};
</script>

<style scoped>
.language-selection {
  text-align: center;
  margin: 20px;
}

.language-buttons {
  display: flex;
  justify-content: center; /* Center buttons horizontally */
  gap: 20px; /* Space between buttons */
}

.btn-solid-lg {
  width: 400px; /* Set explicit width */
  height: 200px; /* Set explicit height */
  border: 0.125rem solid #023047;
  border-radius: 1rem;
  background-color: #023047;
  color: #fff;
  font: 700 1rem / 1 "Open Sans", sans-serif;
  text-decoration: none;
  box-shadow: 0px 0px 5px 1px rgba(2,48,71,1);
  display: flex;
  justify-content: center;
  align-items: center;
  transition: all 0.2s;
  margin-top: 20px;
  padding: 0; /* Remove default padding */
}

.btn-solid-lg.page-scroll:hover {
  background-color: #fff;
  border-color: #023047;
  color: #023047;
}

.text-container {
  display: flex;
  flex-direction: column; /* Stack text elements vertically */
  justify-content: center; /* Center text elements vertically */
  align-items: center; /* Center text elements horizontally */
  height: 100%; /* Make container fill button height */
  width: 100%; /* Make container fill button width */
  text-align: center;
}

.text-top, .text-bottom {
  margin: 0;
  font-size: 1.5rem;
  line-height: 1.2;
}

.text-top {
  margin-bottom: 10px; /* Space between top and bottom text */
}
</style>
