<template>
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" @click="toggleSidebar" role="button"><i class="fas fa-bars"></i></a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="/" class="nav-link">Home</a>
      </li>
    </ul>

    <ul class="navbar-nav ml-auto">
      <li class="nav-item" v-if="!showSearch">
        <a class="nav-link" @click="toggleSearch" role="button">
          <i class="fas fa-search"></i>
        </a>
      </li>
      <li class="nav-item" v-else>
        <div class="navbar-search-block" style="display: flex;">
          <form class="form-inline" @submit.prevent>
            <div class="input-group input-group-sm">
              <input class="form-control form-control-navbar" type="search" v-model="query" placeholder="Search..." aria-label="Search">
              <div class="input-group-append">
                <button class="btn btn-navbar" type="button" @click="clearSearch">
                  <i class="fas fa-times"></i>
                </button>
              </div>
            </div>
          </form>
        </div>
      </li>

      <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#">
          <i class="far fa-bell"></i>
          <span class="badge badge-warning navbar-badge">15</span>
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
          <span class="dropdown-item dropdown-header">15 Notifications</span>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <i class="fas fa-envelope mr-2"></i> 4 new messages
            <span class="float-right text-muted text-sm">3 mins</span>
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <i class="fas fa-users mr-2"></i> 8 friend requests
            <span class="float-right text-muted text-sm">12 hours</span>
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <i class="fas fa-file mr-2"></i> 3 new reports
            <span class="float-right text-muted text-sm">2 days</span>
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item dropdown-footer">See All Notifications</a>
        </div>
      </li>
    </ul>
  </nav>
</template>

<script>
import debounce from 'lodash/debounce';

export default {
  name: 'Navbar',
  data() {
    return {
      showSearch: false,
      query: '',
    };
  },
  watch: {
    query: debounce(function(newQuery) {
      this.liveSearch(newQuery);
    }, 300) // Debounce to limit requests
  },
  methods: {
    toggleSidebar() {
      this.$emit('toggle-sidebar');
    },
    toggleSearch() {
      this.showSearch = !this.showSearch;
    },
    clearSearch() {
      this.query = '';
      this.$emit('search-results', { agents: [], services: [], agencies: [] });
    },
    liveSearch(query) {
      if (query.length > 0) {
        fetch(`/live-search?query=${encodeURIComponent(query)}`)
          .then(response => {
            if (!response.ok) {
              throw new Error('Network response was not ok');
            }
            return response.json();
          })
          .then(data => {
            this.$emit('search-results', data);
          })
          .catch(error => {
            console.error("Search error:", error);
            this.$emit('search-results', { agents: [], services: [], agencies: [] });
          });
      } else {
        this.$emit('search-results', { agents: [], services: [], agencies: [] });
      }
    }
  }
};
</script>

<style scoped>
.navbar-search-block {
  display: none;
}

.navbar-search-block[style*="display: flex;"] {
  display: flex !important;
}
</style>
