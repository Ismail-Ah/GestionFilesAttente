<template>
  <div class="language-selection">
    <h1>Sélectionnez la langue</h1>
    <div class="language-buttons">
      <button @click="selectLanguage('en')" class="btn-solid-lg page-scroll">Anglais</button>
      <button @click="selectLanguage('fr')" class="btn-solid-lg page-scroll">Français</button>
      <button @click="selectLanguage('ar')" class="btn-solid-lg page-scroll">Arabe</button>
    </div>
    <BackButton></BackButton>
  </div>
</template>

<script>
import { ref } from 'vue';
import { useI18n } from 'vue-i18n';
import BackButton from './retour.vue';
import { useRouter, useRoute } from 'vue-router';

export default {
  name: 'LanguageSelection',
  components: { BackButton },
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
  flex-direction: column; /* Align buttons in a column */
  align-items: center; /* Center buttons horizontally */
}

.btn-solid-lg {
  display: block; /* Display buttons as blocks */
  width: 200px; /* Button width */
  padding: 1.375rem 2.625rem;
  border: 0.125rem solid #fff;
  border-radius: 2rem;
  background-color: #fff;
  color: #4e3fdd;
  font: 700 0.875rem / 1 "Open Sans", sans-serif;
  text-decoration: none;
  transition: all 0.2s;
  margin: 0.5rem;
  margin-top: 20px; /* Space between buttons */
}

.btn-solid-lg.page-scroll {
  margin-bottom: 1.125rem;
}

.btn-solid-lg.page-scroll:hover {
  background-color: #4e3fdd;
  border-color: #fff;
  color: #fff;
}
</style>
