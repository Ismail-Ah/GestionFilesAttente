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
          <h1 class="text-bottom">{{ agence.nom_ar?agence.nom_ar:agence.nom }}</h1>
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
    async getAgencies() {
      try {
        const cachedAgencies = localStorage.getItem(`agence${this.$route.params.id}`);
        if (cachedAgencies) {
          this.agence = JSON.parse(cachedAgencies);
        } else {
          const response = await axios.get(`/agences/${this.$route.params.id}`);
          this.agence = response.data;
          localStorage.setItem(`agence${this.$route.params.id}`, JSON.stringify(this.agence));
        }
      } catch (error) {
        console.error('Erreur lors de la récupération des agences:', error);
        this.agence = ''; // Ensure agencies is cleared on error
      } finally {
        this.loading = false;
      }
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
  border: 2px solid #023047;
  border-radius: 10px;
  background-color: #023047;
  color: #fff;
  font-family: 'Roboto', sans-serif; /* Using a web font for better typography */
  font-weight: 700;
  font-size: 1.2rem;
  text-decoration: none;
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
  display: flex;
  justify-content: center;
  align-items: center;
  transition: all 0.3s ease;
  margin-top: 20px;
  padding: 0; /* Remove default padding */
}

.btn-solid-lg.page-scroll:hover {
  border-color: #FB8500;
}

.text-container {
  display: flex;
  flex-direction: column; /* Stack text elements vertically */
  justify-content: center; /* Center text elements vertically */
  align-items: center; /* Center text elements horizontally */
  height: 100%; /* Make container fill button height */
  width: 100%; /* Make container fill button width */
  text-align: center;
  color: #FB8500;
}

.text-top, .text-bottom {
  margin: 0;
  font-family: 'Roboto', sans-serif; /* Ensure consistent font family */
}

.text-top {
  font-size: 1.6rem; /* Slightly larger for emphasis */
  line-height: 1.4;
  margin-bottom: 0.5rem; /* Space between top and bottom text */
  font-weight: 700;
  text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.5); /* Add text shadow for better readability */
}

.text-bottom {
  color : white;
  font-size: 1.6rem; /* Slightly larger for emphasis */
  line-height: 1.4;
  font-weight: 700;
  text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.5); /* Add text shadow for better readability */
}


</style>
