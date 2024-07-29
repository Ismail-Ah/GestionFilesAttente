<template>
  <aside :class="['main-sidebar', 'sidebar-dark-primary', 'elevation-4', 'position-fixed', { 'sidebar-collapse': isCollapsed }]">
    <a href="index3.html" class="brand-link">
      <img src="img/redal.png" alt="Redal Logo" class="brand-image elevation-3" style="opacity: .8; margin:auto">
      <span class="brand-text font-weight-light" style="margin-left:10px">Redal</span>
    </a>

    <div class="sidebar">
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="info">
          <a href="#" class="d-block">ISMAIL AHAKAY</a>
        </div>
      </div>
      <AppNavigation :role="role" />
    </div>
  </aside>
</template>

<script>
import AppNavigation from './AppNavigation.vue';

export default {
  name: 'Sidebar',
  components: {
    AppNavigation,
  },
  props: {
    role: String,
    isCollapsed: Boolean,
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
