<template>
    <div style="display: flex; flex-direction: column; align-items: center; margin-top: -5%; width: 100%;">

    <div class="home-page">
      <h1 class="title">Bienvenue dans le Système de Gestion de File d'Attente</h1>
      <button   class="btn-solid-lg page-scroll" @click="$router.push({ name: 'ticketDispenserAgences', params: { url: url } })">Suivant</button>
    </div>
    </div>
</template>
  
<script>
  export default {
    name: 'HomePage',
    props:{
      url:String,
    },
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

.title {
  font-family: 'Open Sans', sans-serif;
  font-size: 2.5rem;
  font-weight: 700;
  color: #023047;
  text-align: center;
  margin-bottom: 10px;
  text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.1);
  padding: 20px;
}


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
