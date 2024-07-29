<template>
    <div class="home-page">
      <h1>Bienvenue dans le Système de Gestion de File d'Attente</h1>
      <button   class="btn-solid-lg page-scroll" @click="$router.push(`/ticket-dispenser/agences/`)">Suivant</button>
    </div>
</template>
  
<script>
  export default {
    name: 'HomePage',
  };
</script>
  
<style scoped>
.home-page {
  text-align: center;
  margin: 20px;
}

.btn-solid-lg {
  display: inline-block;
  padding: 1.375rem 2.625rem;
  border: 0.125rem solid #fff;
  border-radius: 2rem;
  background-color: #fff;
  color:   #4e3fdd;
  font: 700 0.875rem / 1 "Open Sans", sans-serif;
  text-decoration: none;
  transition: all 0.2s;
  margin: 0.5rem;
  margin-top: 40px;
}

.btn-solid-lg.page-scroll {
  margin-bottom: 1.125rem;
}

.btn-solid-lg.page-scroll:hover {
  background-color:#4e3fdd;
  border-color: #fff;
  color: #fff;
}


</style>
