<template>
  <div v-if="loading1">
    <LoadingSpinner></LoadingSpinner>
  </div>
  <div v-else>
    <PageContent :role="role" activeItem1="profile">
      <div v-if="loading">
        <LoadingSpinner></LoadingSpinner>
      </div>
      <div v-else class="wrapper">
        <div class="content-header">
          <div style="display: flex;">
            <div style="width: 50%;" class="card card-primary card-outline">
              <div class="card-body box-profile" style="display: flex; position: relative;">
                <div class="edit-icon" @click="edit('profile')">
                  <i class="fas fa-user-edit"></i>
                  <div v-if="showEditProfile" class="dropdown-menu dropdown-menu-right show">
                    <a v-if="role!='ADMIN' || user.role!='ADMIN'" @click.prevent="editItem(user.id,user.role)" href="#" class="dropdown-item">Editer le Profil</a>
                    <a @click.prevent="changerImageProfile(user.id)" href="#" class="dropdown-item">Changer l'Image du Profil</a>
                    <a v-if="(role=='ADMIN' || role=='ADMINISTRATION') && user.role=='AGENT'" @click.prevent="deleteItem(user.id, user.nom)" href="#" class="dropdown-item" style="color:red;">Supprimer</a>
                  </div>
                </div>
                <div style="margin: auto 100px auto 10px;">
                  <img class="profile-user-img img-fluid img-circle" style="width:100px;height:100px" :src="`/storage/profile_images/${user.profile_image}`" alt="Photo de profil de l'utilisateur">
                </div>
                <div>
                  <h3 class="profile-username text-center" style="color: dodgerblue;">
                    <strong>{{user.nom}}</strong>
                  </h3>
                  <p class="text-muted text-center"><b>{{user.role==='ADMINISTRATION'?'ADMINISTRATEUR':user.role==='ADMIN'?'ADMIN_COMPTES':user.role}}</b></p>
                  <ul class="list-group list-group-unbordered mb-3">
                    <li class="list-group-item">
                      <b>{{user.email}}</b>
                    </li>
                  </ul>
                </div>
              </div>
            </div>
            <div style="display:block">
              <div v-if="role!='ADMIN' || user.role==='AGENT' || user.role==='ADMINISTRATION'" style="display:flex">
                <div class="col-md-8 col-sm-6 col-12" style="margin-bottom: 3%" v-if="user.role!='AGENT' && (role==='ADMIN' || role==='ADMINISTRATION')">
                  <div style="margin: auto;" class="info-box">
                    <div v-if="user.role==='ADMIN' || user.role==='ADMINISTRATION'" class="edit-icon" @click="edit('agence')">
                      <i class="fas fa-edit"></i>
                      <div v-if="showEditAgence" class="dropdown-menu dropdown-menu-right show">
                        <a @click.prevent="editItem1('agence')" href="#" class="dropdown-item">Editer Agence</a>
                        <a v-if="(role=='ADMIN' || role=='ADMINISTRATION')" @click.prevent="addItem1('agence')" href="#" class="dropdown-item" style="color:blue;">Ajouter Agence</a>
                      </div>
                    </div>
                    <span class="info-box-icon bg-info">
                      <i class="fas fa-building"></i>
                    </span>
                    <div class="info-box-content" >
                      <h6 class="info-box-text">Agences</h6>
                      <h4 class="info-box-number">{{nmbAgences}}</h4>
                    </div>
                  </div>
                </div>
                <div class="col-md-8 col-sm-6 col-12">
                  <div style="margin:auto " class="info-box">
                    <div v-if="user.role==='ADMINISTRATION'" class="edit-icon" @click="edit('service')">
                      <i class="fas fa-edit"></i>
                      <div v-if="showEditService" class="dropdown-menu dropdown-menu-right show">
                        <a @click.prevent="editItem1('service')" href="#" class="dropdown-item">Editer Service</a>
                        <a v-if="(role=='ADMIN' || role=='ADMINISTRATION')" @click.prevent="addItem1('service')" href="#" class="dropdown-item" style="color:blue;">Ajouter Service</a>
                      </div>
                    </div>
                    <span class="info-box-icon bg-success">
                      <i class="fas fa-cogs"></i>
                    </span>
                    <div class="info-box-content" >
                      <h6 class="info-box-text">Services</h6>
                      <h4 class="info-box-number">{{nmbServices}}</h4>
                    </div>
                  </div>
                </div>
                <div class="col-md-8 col-sm-6 col-12" v-if="user.role==='AGENT' || role==='AGENT'" style="visibility: hidden">
                  <div style="margin: auto;" class="info-box">
                    <span class="info-box-icon bg-info">
                      <i class="fas fa-building"></i>
                    </span>
                    <div class="info-box-content">
                      <h6 class="info-box-text">Agences</h6>
                      <h4 class="info-box-number"></h4>
                    </div>
                  </div>
                </div>
              </div>

<div style="display: flex;">
  <div class="col-md-8 col-sm-6 col-12" style="margin-bottom: 3%" v-if="role==='ADMIN' && user.role==='ADMIN'">
                  <div style="margin: auto;" class="info-box">
                    <div v-if=" role==='ADMIN'" class="edit-icon" @click="edit('administrateur')">
                      <i class="fas fa-edit"></i>
                      <div v-if="showEditAdministrateur" class="dropdown-menu dropdown-menu-right show">
                        <a @click.prevent="editItem1('agent')" href="#" class="dropdown-item">Editer Administrateur</a>
                        <a v-if="(role=='ADMIN' )" @click.prevent="addItem1('agence')" href="#" class="dropdown-item" style="color:blue;">Ajouter Administrateur</a>
                      </div>
                    </div>
                    <span class="info-box-icon bg-info">
                      <i class="fas fa-user"></i>
                    </span>
                    <div class="info-box-content" >
                      <h6 class="info-box-text">Administr..</h6>
                      <h4 class="info-box-number">{{nmbAdministrateurs}}</h4>
                    </div>
                  </div>
                </div>
  <div class="col-md-8 col-sm-6 col-12"  style="margin-top: auto;" v-if="(role!='AGENT' && role1!='AGENT' && user.role!='AGENT')">
                <div class="info-box">
                  <div v-if="user.role==='ADMIN' || user.role==='ADMINISTRATION'" class="edit-icon" @click="edit('agent')">
                    <i class="fas fa-edit"></i>
                    <div v-if="showEditAgent" class="dropdown-menu dropdown-menu-right show">
                      <a @click.prevent="editItem1('agent')" href="#" class="dropdown-item">Editer Agent</a>
                      <a v-if="(role=='ADMIN' || role=='ADMINISTRATION')" @click.prevent="addItem1('agent')" href="#" class="dropdown-item" style="color:blue;">Ajouter Agent</a>
                    </div>
                  </div>
                  <span class="info-box-icon bg-warning">
                    <i class="fas fa-users"></i>
                  </span>
                  <div class="info-box-content" style="margin-top:auto">
                    <h6 class="info-box-text">Agents</h6>
                    <h4 class="info-box-number">{{nmbAgents}}</h4>
                  </div>
                </div>
              </div>
</div>

             
            </div>
          </div>
        </div>
        <Agences v-if="user.role==='ADMINISTRATION' || role==='ADMINISTRATION' || role1==='ADMINISTRATION'" :role="role" @deletItem="ItemDeleted"></Agences>
        <Services v-if="role==='ADMINISTRATION' || role==='AGENT' || role1==='ADMINISTRATION' || role1==='AGENT' || user.role==='AGENT' " @deletItem="ItemDeleted" :role="role"  :role1="role1"  :user_id="user.id"></Services>
        <Agents v-if="user.role!='AGENT' && (role==='ADMIN' || role==='ADMINISTRATION' || role1==='ADMINISTRATION')" @deletItem="ItemDeleted"  :role="role"></Agents>
        <StatTickets v-if="role==='AGENT'" name='agent' :name_id="user.id"></StatTickets>
        <Administrateurs v-if="user.role!='AGENT' && user.role!='ADMINISTRATION'  && role==='ADMIN'"></Administrateurs>
      </div>
    </PageContent>
  </div>
</template>

<script>
import StatTickets from '../dashboard/StatTickets.vue';
import PageContent from '../layout/PageContent.vue';
import axios from 'axios';
import LoadingSpinner from '../LoadingSpinner.vue';
import Agences from './Agences.vue';
import Services from './Services.vue';
import Agents from './Agents.vue';
import Administrateurs from './Administrateurs.vue';

export default {
  name: 'Profile',
  components: {StatTickets, Agents, Services, Agences, PageContent, LoadingSpinner ,Administrateurs},
  data() {
    return {
      nmbAgences: 0,
      nmbServices: 0,
      nmbAgents: 0,
      nmbAdministrateurs:0,
      user: '',
      loading: true,
      loading1: true,
      showEditProfile: false,
      showEditAgence: false,
      showEditAgent: false,
      showEditService: false,
      showEditAdministrateur:false,
    }
  },
  props: {
    profile_id: [String, Number],
    role: String,
    role1:String,
  },
  methods: {
    editProfile() {
      console.log('Edit profile clicked');
    },
    ItemDeleted() {
      this.getInfos();
    },
    editItem(id,role2){
      this.$router.push({ name: 'edit-agent', params: { agent: id,role2:role2} });
    },
    getUserInfo() {
      const cacheKey = `user_info_${this.profile_id}`;
      console.log("url = ",cacheKey);
      const cachedUser = localStorage.getItem(cacheKey);

      if (cachedUser) {
        this.user = JSON.parse(cachedUser);
        this.role = this.user.role;
        this.loading = false;
      } else {
        let url = '/profile/user';
        if (this.profile_id != 0) {
          url = `/profile/${parseInt(this.profile_id)}`;
        }
        axios.get(url)
          .then(response => {
            this.user = response.data;
            this.role = this.user.role;
            localStorage.setItem(cacheKey, JSON.stringify(this.user));
            this.loading = false;
          })
          .catch(error => {
            console.error('Error fetching user info:', error);
          });
      }
    },
    changerImageProfile(id) {
      this.$router.push(`/user/${id}/update-image-profile`);
    },
    edit(item) {
      if (item === 'profile') {
        this.showEditProfile = !this.showEditProfile;
        this.showEditAgence = false;
        this.showEditService = false;
        this.showEditAgent = false;
                this.showEditAdministrateur=false;

      } else if (item === 'agence') {
        this.showEditAgence = !this.showEditAgence;
        this.showEditProfile = false;
        this.showEditService = false;
        this.showEditAgent = false;
      } else if (item === 'service') {
        this.showEditService = !this.showEditService;
        this.showEditProfile = false;
        this.showEditAgence = false;
        this.showEditAgent = false;
      } else if (item === 'agent') {
        this.showEditAgent = !this.showEditAgent;
        this.showEditProfile = false;
        this.showEditAgence = false;
        this.showEditService = false;
                this.showEditAdministrateur=false;

      }
      else if (item === 'administrateur') {
        this.showEditAdministrateur= !this.showEditAdministrateur;
        this.showEditProfile = false;


                this.showEditAgent=false;

      }
    },
    addItem1(item) {
      this.$router.push('/ajouter-' + item);
    },
    deleteItem() {
  let id = this.user.id;
  let choix = confirm(`Tapez OK pour supprimer le compte de ${this.user.nom} ?`);
  if (choix) {
    axios.delete(`/agents/${id}`)
      .then(response => {
        console.log("Compte supprimé avec succès");
      })
      .catch(error => {
        console.error("Erreur lors de la suppression du compte :", error);
      });
  }
},

    deleteItem1(item) {
      this.$router.push('/editer-' + item);
    },
    getInfos() {
        axios.get(`/profile/${this.profile_id}/dataAgenceService`)
          .then(response => {
            this.nmbAgences = response.data.nmbAgences;
            this.nmbServices = response.data.nmbServices;
            this.nmbAgents = response.data.nmbAgents;
            this.nmbAdministrateurs=response.data.nmbAdministrateurs;
            this.loading = false;
          })
          .catch(error => {
            console.error('Error fetching stats:', error);
          });
    },
    fetchLoading1() {
      this.loading1 = false;
    }
  },
  watch: {
  profile_id(newVal) {
    this.getUserInfo();
    this.getInfos();
  },
  role(newValue) {
    if (newValue) {
      this.fetchLoading1();
    }
  }
},

  created() {

    this.getUserInfo();
    this.getInfos();
    if (this.role) {
      this.fetchLoading1();
    }
  },
}
</script>

<style scoped>
.edit-icon {
  position: absolute;
  top: 10px;
  right: 10px;
  cursor: pointer;
  font-size: 1.5em;
  color: #007bff;
}
</style>
