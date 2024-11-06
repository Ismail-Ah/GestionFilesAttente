<template>
  <button class="btn-solid-lg page-scroll" @click="retour">
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
.btn-solid-lg {
  display: inline-block;
  padding: 1.375rem 2.625rem;
  border: 0.125rem solid #023047;
  border-radius: 1rem;
  background-color: #023047;
  color: #fff;
  font: 700 0.875rem / 1 "Open Sans", sans-serif;
  text-decoration: none;
  -webkit-box-shadow: 0px 0px 5px 1px rgba(2,48,71,1);
  -moz-box-shadow: 0px 0px 5px 1px rgba(2,48,71,1);
  box-shadow: 0px 0px 5px 1px rgba(2,48,71,1);

  margin: 0.5rem;
  margin-top: 40px;
  text-align: center; /* Center text horizontally */
  vertical-align: middle; /* Center text vertically */
}

.btn-solid-lg.page-scroll {
  margin-bottom: 1.125rem;
}

.btn-solid-lg.page-scroll:hover {
  background-color: #fff;
  border-color: #023047;
  color: #023047;
}

  </style>
  