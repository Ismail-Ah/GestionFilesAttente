<template>
  <nav class="mt-2">
    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
      <!-- Dashboard -->
      <li class="nav-item" v-if="role==='AGENT' || role==='ADMINISTRATION'">
        <a @click="setActive('dashboard')" :class="{'nav-link': true, 'active': activeItem === 'dashboard'}">
          <i class="nav-icon fas fa-tachometer-alt"></i>
          <p>Dashboard</p>
        </a>
      </li>
      <!-- Statistiques -->
      <li class="nav-item" v-if="role==='AGENT' || role==='ADMINISTRATION'">
        <a @click="setActive('statistiques')" :class="{'nav-link': true, 'active': activeItem === 'statistiques'}">
          <i class="nav-icon fas fa-chart-pie"></i>
          <p>Statistiques</p>
        </a>
      </li>
      <!-- User Profile -->
      <li class="nav-item">
        <a @click="setActive('profile')" :class="{'nav-link': true, 'active': activeItem === 'profile'}">
          <i class="nav-icon fas fa-user"></i>
          <p>User Profile</p>
        </a>
      </li>
      <!-- Ajouter Agent -->

      <!-- Charts -->
      <li class="nav-item" v-if="role==='ADMIN' || role==='ADMINISTRATION'">
        <a @click="toggleCharts" :class="{'nav-link': true, 'active': activeItem === 'charts'}">
          <i class="nav-icon fas fa-cog"></i>
          <p>
            Settings
            <i class="right fas fa-angle-left"></i>
          </p>
        </a>
        <ul class="nav " v-show="showCharts">
          <!-- Agences -->
          <li v-if="role==='ADMINISTRATION'" class="nav-item">
            <a @click="toggleAgence" :class="{'nav-link': true, 'active': activeItem === 'Agences'}">
              <i class="fas fa-building nav-icon"></i>
              <p>
                Agences
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav " v-show="showAgences">
              <li class="nav-item">
                <a  @click="redirect('ajouter-agence')"  class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Ajouter Agence</p>
                </a>
              </li>
              <li class="nav-item">
                <a @click="redirect('editer-agence')" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Edit Agence</p>
                </a>
              </li>
            </ul>
          </li>
          <li v-if="role==='ADMINISTRATION'" class="nav-item">
            <a @click="toggleService" :class="{'nav-link': true, 'active': activeItem === 'Services'}">
              <i class="fas fa-cogs nav-icon"></i>
              <p>
                Services
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav " v-show="showServices">
              <li class="nav-item">
                <a  @click="redirect('ajouter-service')"  class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Ajouter Service</p>
                </a>
              </li>
              <li class="nav-item">
                <a  @click="redirect('editer-service')" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Edit Service</p>
                </a>
              </li>
            </ul>
          </li>
          <!-- Agents -->
          <li class="nav-item">
            <a @click="toggleAgent" :class="{'nav-link': true, 'active': activeItem === 'Agents'}">
              <i class="fas fa-user nav-icon"></i>
              <p>
                Utilisateurs
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav " v-show="showAgents">
              <li class="nav-item">
                <a @click="redirect('ajouter-agent')" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Ajouter Utilisateur</p>
                </a>
              </li>
              <li class="nav-item">
                <a @click="redirect('editer-agent')" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Edit Utilisateur</p>
                </a>
              </li>
            </ul>
          </li>
        </ul>
      </li>
      <!-- Logout -->
      <li class="nav-item">
        <a @click="logout" :class="{'nav-link': true, 'active': activeItem === 'logout'}">
          <i class="nav-icon fas fa-sign-out-alt"></i>
          <p>Logout</p>
        </a>
      </li>
    </ul>
  </nav>
</template>

<script>
import axios from 'axios';

export default {
  name: 'AppNavigation',
  data() {
    return {
      activeItem: 'dashboard', 
      showCharts: false, 
      showAgences: false, 
      showServices: false, 
      showAgents: false, 
    };
  },
  props:{
    role:String,
    activeItem1:String,
  },
  methods: {
    setActive(item) {
      this.activeItem = item;
      if (item !== 'logout') {
        if (item === 'ajouterAgent') {
          this.$router.push('/create-agent-acount');
        } else {
          if (item!='Agences' && item!='Services' && item!='Agents' && item)
          this.$router.push(`/${item}`);
        }
      }
    },
    redirect(name){
      this.$router.push(`/${name}`);
    },
    toggleCharts() {
      this.showCharts = !this.showCharts;
      this.activeItem = 'charts';
      if(!this.showCharts){
        this.showAgences=false; 
        this.showServices= false;
        this.showAgents= false;
      }
    },
    toggleAgence() {
      this.showAgences = !this.showAgences;
      this.activeItem = 'Agences'; 
      this.showServices= false;
      this.showAgents= false;
    },
    toggleService() {
      this.showServices = !this.showServices;
      this.activeItem = 'Services'; // Set the active item to 'Services'
      this.showAgences=false; 
      this.showAgents= false;
    },
    toggleAgent() {
      this.showAgents = !this.showAgents;
      this.activeItem = 'Agents'; 
      this.showAgences=false; 
      this.showServices= false;
    },
    logout() {
      axios.defaults.headers.common['X-CSRF-TOKEN'] = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

      axios.post('/logout').then(response => {
        console.log('Logged out in the background:', response);
      }).catch(error => {
        console.error('Logout failed:', error);
      });

      window.location.href = '/';
    }
  },
  created(){
    if (this.activeItem){
      this.setActive(this.activeItem1);
    }
  }
}
</script>

<style scoped>

</style>