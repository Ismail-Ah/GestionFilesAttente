<template>
  <div :class="['hold-transition', 'sidebar-mini', 'layout-fixed', { 'sidebar-collapse': isSidebarCollapsed }]">
    <div class="wrapper">
      <AppLayout />
      <Navbar @toggle-sidebar="toggleSidebar" />
      <Sidebar :role="role" :isCollapsed="isSidebarCollapsed" />
      <div class="content-wrapper">
        <section class="content">
          <slot></slot>
        </section>
      </div>
    </div>
  </div>
</template>

<script>
import AppLayout from './AppLayout.vue';
import Footer from './Footer.vue';
import Navbar from './Navbar.vue';
import Sidebar from './Sidebar.vue';

export default {
  components: {
    Navbar,
    Footer,
    Sidebar,
    AppLayout
  },
  name: 'PageContent',
  props: {
    role: String,
  },
  data() {
    return {
      isSidebarCollapsed: false,
    };
  },
  methods: {
    toggleSidebar() {
      this.isSidebarCollapsed = !this.isSidebarCollapsed;
    },
  },
};
</script>

<style scoped>
/* Adjust content wrapper when the sidebar is collapsed */
.sidebar-collapse .content-wrapper {
  margin-left: 80px; /* Adjust this value to match the collapsed sidebar width */
}

/* Optionally, you can add transition effects */
.content-wrapper {
  transition: margin-left 0.3s ease;
  background-color: #f4f6f9;
  min-height: 100vh; /* Ensure the content wrapper covers the full height */
}

.wrapper {
  min-height: 100vh; /* Ensure the wrapper covers the full height */
  background-color: #f4f6f9;
}
</style>
