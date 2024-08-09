<template>
  <div class="container">
    <h1 class="title">{{$t('SelectService')}}</h1>
    <Services :id="id" action="ticket" :langauge="this.$i18n.locale"></Services>
    <BackButton  class="back-button"></BackButton>
  </div>
</template>

<script>
import BackButton from './retour.vue';
import Services from '../admin/services.vue';

export default {
  name: 'ServiceSelection',
  data() {
    return {
      id: this.$route.params.id,
    };
  },
  components: { BackButton, Services },
  methods: {
    selectService(service) {
      this.$router.push(`/agence/${this.id}/ticket-dispenser/statistique`);
      // Add further logic here, e.g., navigating to a ticket page or saving the selection
    },
  },
};
</script>

<style scoped>
.container {
  display: flex;
  flex-direction: column;
  align-items: center;
  margin-top: -8%;
  width: 100%;
 /* Ensure the container takes up the full viewport height */
  position: relative; /* Ensure the BackButton can be positioned absolutely within this container */
}

.title {
  font-family: 'Open Sans', sans-serif;
  font-size: 2.5rem;
  font-weight: 700;
  color: #FB8500;
  text-align: center;
  margin-bottom: 10px;
  text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.1);
  padding: 20px;
}

.back-button {
  position: fixed;
  bottom: 10px; /* Adjust this value to position vertically */
  left: 20px;   /* Adjust this value to position horizontally */
}
</style>
