import { createApp } from 'vue';
import router from './router.js';
import { createI18n } from 'vue-i18n'
import en from '../json/en.json';
import fr from '../json/fr.json';
import ar from '../json/ar.json';

// Create i18n instance
const i18n = createI18n({
  legacy: false, // Use Composition API
  locale: 'fr', // Default locale
  fallbackLocale: 'fr', // Fallback locale
  messages: {
    en,
    fr,
    ar
  }
});
// Create Vue app instance
const app = createApp({
  // Options
});

// Use router with the Vue app instance
app.use(router);
app.use(i18n);
// Mount the Vue app
app.mount('#app');