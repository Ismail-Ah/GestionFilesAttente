<template>
  <div v-if="loading" style="margin-top: -10%;">
    <LoadingSpinner></LoadingSpinner>
  </div>
  <div v-else class="home-page">
    <div class="services">
      <button
        v-for="service in paginatedServices"
        :key="service.id"
        :disabled="service.etat0 !== 'ACTIF'"
        class="btn-solid-lg page-scroll"
        @click="clickService(service.id, action)"
        ref="serviceButtons"
      >
        <h4>{{ langauge==='fr'?service.nom:langauge==='en'?(service.nom_en?service.nom_en:service.nom):(service.nom_ar?service.nom_ar:service.nom) }}</h4>
        <p v-if="service.etat0!='ACTIF'" class="agency-details" :style="{ color: service.etat0 === 'ACTIF' ? 'rgb(8, 235, 8)' : 'red' }" :class="{'active': service.etat0 === 'ACTIF'}">
          {{ service.etat0 }}
        </p>
      </button>
      <button
        v-for="placeholder in placeholders"
        :key="'placeholder-' + placeholder"
        class="btn-solid-lg page-scroll placeholder"
        disabled
        ref="serviceButtons"
      >
        Placeholder
      </button>
    </div>
    <div class="pagination">
      <button @click="prevPage" id="previous" :disabled="currentPage === 1">
        <i class="fas fa-arrow-left"></i>
      </button>
      <button @click="nextPage" id="next" :disabled="currentPage === totalPages">
        <i class="fas fa-arrow-right"></i>
      </button>
    </div>
  </div>
</template>

<script>
import axios from 'axios';
import LoadingSpinner from '../LoadingSpinner.vue';

export default {
  name: 'Services',
  components: { LoadingSpinner },
  data() {
    return {
      loading: true,
      successMessage: '',
      errorMessage: '',
      currentPage: 1,
      pageSize: 4,
      services: [],
      action: this.action || '', // Default to empty string if action is not provided
    };
  },
  props: {
    id: String,
    action: String,
    langauge:String,
  },
  computed: {
    totalPages() {
      return Math.ceil(this.services.length / this.pageSize);
    },
    paginatedServices() {
      const start = (this.currentPage - 1) * this.pageSize;
      const end = start + this.pageSize;
      return this.services.slice(start, end);
    },
    placeholders() {
      const numServices = this.paginatedServices.length;
      const placeholdersNeeded = this.pageSize - numServices;
      return Array.from({ length: placeholdersNeeded }, (_, i) => i);
    },
  },
  methods: {
    extractTime(date) {
  const hours = date.getHours().toString().padStart(2, '0');
  const minutes = date.getMinutes().toString().padStart(2, '0');
  const seconds = date.getSeconds().toString().padStart(2, '0');
  return `${hours}:${minutes}:${seconds}`;
},
    getServices() {
  const cachedServices = localStorage.getItem(`Agence${this.id}Services`);

  const formatTime = (timeString) => {
    const [hours, minutes, seconds] = timeString.split(':').map(Number);
    return new Date(0, 0, 0, hours, minutes, seconds);
  };

  const isServiceActive = (currentTime, startTime, endTime) => {
    // If endTime is less than startTime, the service ends the next day
    if (endTime < startTime) {
      return (currentTime >= startTime) || (currentTime <= endTime);
    }
    return (currentTime >= startTime) && (currentTime <= endTime);
  };

  const checkAndUpdateServiceState = (service, currentTime) => {
    const startTime = this.extractTime(formatTime(service.heure_debut));
    const endTime = this.extractTime(formatTime(service.heure_fin));
    currentTime = this.extractTime(currentTime);
    service.etat0 = service.etat;
    console.log("currentTime : ",currentTime);
    console.log("startTime : ",startTime);
    console.log("endTime : ",endTime);
    console.log("-----------------------");
    if (currentTime < startTime && service.etat === 'ACTIF') {
      service.etat0 = `${this.$t('commence')}  ${service.heure_debut}`;
    } else if (!isServiceActive(currentTime, startTime, endTime) && service.etat === 'ACTIF') {
      service.etat0 = `${this.$t('termine')} ${service.heure_fin}`;
    }
    return service;
  };

  if (cachedServices) {
    const currentTime = new Date();
    this.services = JSON.parse(cachedServices);
    this.services.forEach(service => {
      checkAndUpdateServiceState(service, currentTime);
    });
    this.loading = false; // Stop loading if data is fetched from localStorage
    this.$nextTick(() => this.setMaxButtonHeight());
  } else {
    axios.get(`/agence/${this.id}/services2`)
      .then(response => {
        const currentTime = new Date();
        this.services = response.data;
        this.services.forEach(service => {
          checkAndUpdateServiceState(service, currentTime);
        });
        localStorage.setItem(`Agence${this.id}Services`, JSON.stringify(this.services));
        this.loading = false; // Stop loading when data is fetched
        this.$nextTick(() => this.setMaxButtonHeight());
      })
      .catch(error => {
        console.error('Erreur lors de la récupération des services:', error);
      });
  }
},


    clickService(id, action) {
      if (action === 'ticket') {
        this.$router.push(`/agence/${this.$route.params.id}/ticket-dispenser/services/${parseInt(id)}`);
      }
    },
    nextPage() {
      if (this.currentPage < this.totalPages) {
        this.currentPage++;
      }
      this.$nextTick(() => this.setMaxButtonHeight());
    },
    prevPage() {
      if (this.currentPage > 1) {
        this.currentPage--;
      }
      this.$nextTick(() => this.setMaxButtonHeight());
    },
    setMaxButtonHeight() {
      const buttons = this.$refs.serviceButtons;
      if (buttons.length > 0) {
        let maxHeight = 0;
        buttons.forEach(button => {
          const height = button.clientHeight;
          if (height > maxHeight) {
            maxHeight = height;
          }
        });
        buttons.forEach(button => {
          button.style.height = `${maxHeight}px`;
        });
      }
    }
  },
  created() {
    this.getServices();
    if (!this.langauge){
      this.langauge='fr';
    }
  },

};
</script>



<style scoped>
:root {
  --shadow-color: 0deg 0% 45%;
  --shadow-elevation-high:
    0px 0.2px 0.2px hsl(var(--shadow-color) / 0.6),
    0.1px 1.2px 1.3px -0.4px hsl(var(--shadow-color) / 0.58),
    0.2px 2.4px 2.5px -0.8px hsl(var(--shadow-color) / 0.55),
    0.4px 4.1px 4.4px -1.3px hsl(var(--shadow-color) / 0.53),
    0.6px 6.9px 7.3px -1.7px hsl(var(--shadow-color) / 0.51),
    1px 11.2px 11.9px -2.1px hsl(var(--shadow-color) / 0.48),
    1.6px 17.4px 18.5px -2.5px hsl(var(--shadow-color) / 0.46),
    2.4px 26px 27.6px -2.9px hsl(var(--shadow-color) / 0.44);
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

.home-page {
  text-align: center;
  margin: 20px;
}

.services {
  margin: auto;
  width: 600px; /* Adjust the width to fit your design */
  display: flex;
  flex-wrap: wrap;
  justify-content: space-between; /* Space between items */
  gap: 20px; /* Add gap between items */
}

.btn-solid-lg {
  flex: 1 1 calc(50% - 10px); /* Two items per row, minus gap */
  box-sizing: border-box; /* Include padding and border in width calculation */
  margin: 5px 0; /* Vertical margin */
  padding: 20px;
  border-radius: 10px 0 10px 0;
  width: 90%; /* Full width within the flex item */
  height: 25%; /* Set explicit height */
  display: flex; /* Flex display */
  flex-direction: column; /* Arrange children in a column */
  justify-content: space-between; /* Space between elements */
  align-items: center; /* Center text horizontally */
  position: relative;
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
  box-shadow: 0px 0px 5px 1px rgba(2,48,71,1);
  transition: all 0.2s;
  text-align: center;
  
}

.btn-solid-lg.page-scroll:hover {
  border-color: #FB8500;
  color: #FB8500;
}

.pagination {
  top: 85%;
  display: flex;
  justify-content: space-between;
  align-items: center;
  width: 100%;
  max-width: 600px;
  margin-top: 20px;
}
.pagination #next{
  position:fixed;
  top:88%;
  right:28.5%;
}
.pagination #previous{
  position:fixed;
  top:88%;
  left:28.5%;
}

.pagination button {
  box-shadow: rgba(0, 0, 0, 0.1) 0px 0px 5px 0px, rgba(0, 0, 0, 0.1) 0px 0px 1px 0px;
  width: 100px;
  padding: 10px 20px;
  margin: 0 5px;
  border: none;
  border-radius: 5px;
  background-color: #023047;
  color: white;
  cursor: pointer;
}

button:disabled {
  background-color: grey;
  border: grey;
  cursor: not-allowed;
}

/* Override hover styles for disabled buttons */
button:disabled:hover {
  background-color: grey; /* Keep the background color the same */
  border: grey; /* Keep the border color the same */
  
}

.btn-solid-lg.page-scroll:disabled:hover {
  background-color: grey;
  border-color: grey;
  color:white;
}

.placeholder {
  visibility: hidden; /* Hide the placeholder button */
}

.agency-name {
  margin: 0;
  font-size: 1.25rem;
  color: #333;
}

.agency-details {
  margin:auto;
  background-color: #023047;
  color: white;
  padding: 5px;
  width: 100%;
  padding:1%;
  text-align: center;
  position: absolute;
  bottom: 0;
  left: 0;
  border-radius:0 0  1rem 1rem;
}


.services button {
  max-height: 130px;
}
h4{
  font-size: 1.2rem; /* Slightly larger for emphasis */
  line-height: 1.4;
  font-weight: 700;
  text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.5); /* Add text shadow for better readability */
}
</style>
