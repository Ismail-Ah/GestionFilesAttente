<template>
    <div v-if="loading">
      <div class="spinner-wrapper">
        <div class="spinner">
          <div class="bounce1"></div>
          <div class="bounce2"></div>
          <div class="bounce3"></div>
        </div>
      </div>
    </div>
    <div v-else>
      <PageContent :role="role">
        <div class="wrapper">
          <div class="content-header">

            <div style="display: flex;">
                <div style="width: 50%;" class="card card-primary card-outline">
              <div class="card-body box-profile" style="display: flex; position: relative;">
                <div class="edit-icon" @click="edit('profile')">
                  <i class="fas fa-edit"></i>
                      <div v-if="showEditProfile" class="dropdown-menu dropdown-menu-right show" >
                        <a @click.prevent="editItem(user.id, user.nom)" href="#" class="dropdown-item">Edit</a>
                        <a v-if="(role=='ADMIN' || role=='ADMINISTRATION') && user.role=='AGENT'" @click.prevent="deleteItem(user.id, user.nom)" href="#" class="dropdown-item" style="color:red;">Supprimer</a>
                      </div>
                </div>
                <div style="margin: auto 100px auto 10px;">
                  <img class="profile-user-img img-fluid img-circle" src="/img/admin.png" alt="User profile picture">
                </div>
                <div>
                  <h3 class="profile-username text-center" style="color: dodgerblue;">
                    <strong>{{user.nom}}</strong>
                  </h3>
                  <p class="text-muted text-center"><b>{{user.role}}</b></p>
                  <ul class="list-group list-group-unbordered mb-3">
                    <li class="list-group-item">
                      <b>{{user.email}}</b>
                    </li>
                  </ul>
                </div>
              </div>
                </div>
                
            
                <div style="display: block;">
                  <div   style="display: flex;">
                    <div  class="col-md-9 col-sm-6 col-12">
                  
                  <div style="margin: auto;" class="info-box">
                    <div v-if="user.role==='ADMIN' || user.role==='ADMINISTRATION'" class="edit-icon" @click="edit('agence')">
                        <i class="fas fa-edit"></i>
                        <div v-if="showEditAgence" class="dropdown-menu dropdown-menu-right show" >
                        <a @click.prevent="editItem1('agence')" href="#" class="dropdown-item">Editer Agence</a>
                        <a v-if="(role=='ADMIN' || role=='ADMINISTRATION') " @click.prevent="addItem1('agence')" href="#" class="dropdown-item" style="color:blue;">Ajouter Agence</a>
                      </div>
                    </div>
                      <span class="info-box-icon bg-info">
                          <i class="fas fa-building"></i>
                      </span>
                      <div class="info-box-content">
                          <h6 class="info-box-text">Agences</h6>
                          <h4 class="info-box-number">{{nmbAgences}}</h4>
                      </div>
                  </div>
    
                    </div>
                    <div  class="col-md-9 col-sm-6 col-12">
                      <div class="info-box" >
                        <div v-if="user.role==='ADMIN' || user.role==='ADMINISTRATION'" class="edit-icon" @click="edit('service')">
                          <i class="fas fa-edit"></i>
                          <div v-if="showEditService" class="dropdown-menu dropdown-menu-right show" >
                        <a @click.prevent="editItem1('service')" href="#" class="dropdown-item">Editer Service</a>
                        <a v-if="(role=='ADMIN' || role=='ADMINISTRATION') " @click.prevent="addItem1('service')" href="#" class="dropdown-item" style="color:blue;">Ajouter Service</a>
                      </div>
                      </div>
                        <span class="info-box-icon bg-success">
                          <i class="fas fa-cogs"></i>
                        </span>
                        <div class="info-box-content">
                          <h6 class="info-box-text">Services</h6>
                          <h4 class="info-box-number">{{nmbServices}}</h4>
                        </div>
                        <!-- /.info-box-content -->
                      </div>
                      <!-- /.info-box -->
                    </div>
                  </div>
                  <div  class="col-md-9 col-sm-6 col-12" style="margin-top: auto;">
                
                <div class="info-box" >
                  <div v-if="user.role==='ADMIN' || user.role==='ADMINISTRATION'" class="edit-icon" @click="edit('agent')">
                      <i class="fas fa-edit"></i>
                      <div v-if="showEditAgent" class="dropdown-menu dropdown-menu-right show" >
                        <a @click.prevent="editItem1('agent')" href="#" class="dropdown-item">Editer Agent</a>
                        <a v-if="(role=='ADMIN' || role=='ADMINISTRATION')" @click.prevent="addItem1('agent')" href="#" class="dropdown-item" style="color:blue;">Ajouter Agent</a>
                      </div>
                  </div>
                    <span class="info-box-icon bg-warning">
                        <i class="fas fa-user"></i>
                    </span>
                    <div class="info-box-content">
                        <h6 class="info-box-text">Agents</h6>
                        <h4 class="info-box-number">{{nmbAgents}}</h4>
                    </div>
                </div>
  
                  </div>
                </div>
                  
                  
                
                
            </div>
           

          </div>
          <Agences v-if="role=='ADMIN' || role==='ADMINISTRATION'" @deletItem="ItemDeleted"></Agences>
          <Services v-if="role=='ADMIN' || role==='ADMINISTRATION' || role==='AGENT'" @deletItem="ItemDeleted"></Services>
          <Agents v-if="role=='ADMIN' || role==='ADMINISTRATION'" @deletItem="ItemDeleted"></Agents>
          <StatTickets v-if="role==='AGENT'"></StatTickets>
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
  export default {
    name: 'Profile',
    components: {StatTickets,Agents,Services,Agences, PageContent, LoadingSpinner },
    data(){
        return {
            nmbAgences:0,
            nmbServices:0,
            nmbAgents:0,
            user:'',
            loading:true,
            showEditProfile:false,
            showEditAgence:false,
            showEditAgent:false,
            showEditService:false,
        }
    },
    props:{
      role:String
    },
    methods: {
      editProfile() {
        console.log('Edit profile clicked');
      },
      ItemDeleted(){
        this.getInfos();
      },
      getUserInfo(){
        axios.get('/profile/user')
        .then(response => {
          this.user = response.data;
        })
        .catch(error => {
          console.error('Error fetching agencies:', error);
        });  
      },
      edit(item){
        if(item==='profile'){
          this.showEditProfile=!this.showEditProfile;
          this.showEditAgence=false;
          this.showEditService=false;
          this.showEditAgent=false;
        }
        else if(item==='agence'){
          this.showEditAgence=!this.showEditAgence;
          this.showEditProfile=false;
          this.showEditService=false;
          this.showEditAgent=false;
        }
        else if(item==='service'){
          this.showEditService=!this.showEditService;
          this.showEditProfile=false;
          this.showEditAgence=false;
          this.showEditAgent=false;
        }
        else if(item==='agent'){
          this.showEditAgent=!this.showEditAgent;
          this.showEditProfile=false;
          this.showEditAgence=false;
          this.showEditService=false;
        }

      },
      addItem1(item){
        this.$router.push('/ajouter-'+item);
      },
      deleteItem1(item){
        this.$router.push('/editer-'+item);
      },
      getInfos() {
      axios.get('/profile/dataAgenceService')
        .then(response => {
          this.nmbAgences = response.data.nmbAgences;
          this.nmbServices = response.data.nmbServices;
          this.nmbAgents = response.data.nmbAgents;
          this.loading = false;
        })
        .catch(error => {
          console.error('Error fetching agencies:', error);
        });
    },

    
  },
  
  created() {
    this.getUserInfo();
    this.getInfos();
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
  .spinner-wrapper {
  position: fixed;
  z-index: 999999;
  top: 0;
  right: 0;
  bottom: 0;
  left: 0;
  background: #fff;
}

.spinner {
  position: absolute;
  top: 50%; /* centers the loading animation vertically on the screen */
  left: 50%; /* centers the loading animation horizontally on the screen */
  width: 3.75rem;
  height: 1.25rem;
  margin: -0.625rem 0 0 -1.875rem; /* width and height divided by two */
  text-align: center;
}

.spinner > div {
  display: inline-block;
  width: 1rem;
  height: 1rem;
  border-radius: 100%;
  background-color: #5f4dee;
  -webkit-animation: sk-bouncedelay 1.4s infinite ease-in-out both;
  animation: sk-bouncedelay 1.4s infinite ease-in-out both;
}

.spinner .bounce1 {
  -webkit-animation-delay: -0.32s;
  animation-delay: -0.32s;
}

.spinner .bounce2 {
  -webkit-animation-delay: -0.16s;
  animation-delay: -0.16s;
}

@-webkit-keyframes sk-bouncedelay {
  0%, 80%, 100% { -webkit-transform: scale(0); }
  40% { -webkit-transform: scale(1.0); }
}

@keyframes sk-bouncedelay {
  0%, 80%, 100% { 
    -webkit-transform: scale(0);
    -ms-transform: scale(0);
    transform: scale(0);
  } 40% { 
    -webkit-transform: scale(1.0);
    -ms-transform: scale(1.0);
    transform: scale(1.0);
  }
}
.filter-btn-group {
    margin-right: 1rem;
  }
  </style>
  