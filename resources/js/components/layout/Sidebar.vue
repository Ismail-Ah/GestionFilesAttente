<template>
  <aside :class="['main-sidebar', 'sidebar-dark-primary', 'elevation-4', 'position-fixed', { 'sidebar-collapse': isCollapsed }]">
    <div class="sidebar">
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img :src="`/storage/profile_images/${profileImage}`" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="#" style="margin-left:5%" class="d-block">{{ nom }}</a>
        </div>
      </div>
      <AppNavigation :role="role" :activeItem1="activeItem1 || ''" />
    </div>
  </aside>
</template>

<script>
import AppNavigation from './AppNavigation.vue';
import axios from 'axios';

export default {
  name: 'Sidebar',
  components: {
    AppNavigation,
  },
  data() {
    return {
      profileImage: 'default_logo.png',
      nom:'',
    };
  },
  methods: {
    fetchLogoUser() {
      // Check if the profile image is already cached
      const cachedProfileImage = localStorage.getItem('profileImage');
      if (cachedProfileImage) {
        this.profileImage = cachedProfileImage;
      } else {
        // Fetch the profile image from the server and cache it
        axios.get('/logo').then(response => {
          this.profileImage = response.data;
          localStorage.setItem('profileImage', response.data);
        }).catch(error => {
          console.error('Error fetching profile image:', error);
        });
      }
    },
    fetchUserNom() {
      // Check if the profile image is already cached

        // Fetch the profile image from the server and cache it
        axios.get('/nom').then(response => {
          this.nom = response.data;
        }).catch(error => {
          console.error('Error fetching profile image:', error);
        });

    },
  },
  created() {
    this.fetchLogoUser();
    this.fetchUserNom();
  },
  props: {
    role: String,
    isCollapsed: Boolean,
    activeItem1: String,
  },
};
</script>

<style scoped>
.sidebar-collapse {
  width: 40px; /* Adjust this value to your desired collapsed width */
  transition: width 2s ease; /* Add transition effect */
}
.main-sidebar {
  transition: width 10s ease; /* Add transition effect */
}
</style>
