<template>
  <div :class="['hold-transition', 'sidebar-mini', 'layout-fixed', { 'sidebar-collapse': isSidebarCollapsed }]">
    <div class="wrapper">
      <AppLayout />
      <Navbar @toggle-sidebar="toggleSidebar" @search-results="handleSearchResults"/>
      <Sidebar :role="role" :isCollapsed="isSidebarCollapsed" />
      <div class="content-wrapper">
        <section class="content">
          <!-- Conditional rendering based on the presence of search results -->
          <template v-if="isSearching">
            <SearchResult :results="searchData" />
          </template>
          <template v-else>
            <!-- Render default content or slot content -->
            <slot ></slot>
          </template>
        </section>
      </div>
    </div>
  </div>
</template>

<script>
import AppLayout from './AppLayout.vue';
import Footer from './Footer.vue';
import Navbar from './Navbar.vue';
import SearchResult from './SearchResult.vue';
import Sidebar from './Sidebar.vue';

export default {
  components: {
    Navbar,
    Footer,
    Sidebar,
    AppLayout,
    SearchResult
  },
  name: 'PageContent',
  props: {
    role: {
      type: String,
      required: true
    }
  },
  data() {
    return {
      isSidebarCollapsed: false,
      isSearching: false,
      searchData: { agents: [], services: [], agences: [] },
    };
  },
  methods: {
    toggleSidebar() {
      this.isSidebarCollapsed = !this.isSidebarCollapsed;
    },
    handleSearchResults(data) {
      this.isSearching = true;
      this.searchData = data;
    }
  }
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
