<template>
  <button class="btn-solid-lgg" @click="retour">
   {{ $t('Retour')}}
  </button>
</template>

  
  <script>
  export default {
    name: 'BackButton',
    methods: {
      retour() {
        this.$router.go(-1); // Retourne en arrière dans l'historique
      }
    }
  };
  </script>
  
  <style scoped>
  .btn-solid-lgg {
    position: left;
    display: inline-block;
    padding: 1.375rem 2.625rem;
    border: 0.125rem solid #fff;
    border-radius: 2rem;
    background-color: transparent; /* Fond transparent par défaut */
    color: #fff;
    font: 700 0.875rem / 1 "Open Sans", sans-serif;
    text-decoration: none;
    transition: all 0.2s;
    margin-top: 20px; /* Réduit l'espace en haut */
  }
  
  .btn-solid-lgg:hover {
    background-color: #4e3fdd;
    color: #fff;
  }
  </style>
  