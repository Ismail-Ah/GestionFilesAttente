<template>
    
    <div >
      <PageContent :role="role">
        <div v-if="loading">
          <LoadingSpinner></LoadingSpinner>
        </div>
        <div v-else class="wrapper">
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
          <Agences v-if="role==='ADMIN' || role==='ADMINISTRATION'" @deletItem="ItemDeleted"></Agences>
          <Services v-if="role==='ADMIN' || role==='ADMINISTRATION' || role==='AGENT'" @deletItem="ItemDeleted" :role="role" :user_id="user.id" ></Services>
          <Agents v-if="role==='ADMIN' || role==='ADMINISTRATION'" @deletItem="ItemDeleted"></Agents>
          <StatTickets v-if="role==='AGENT'" name='agent' :name_id="user.id"></StatTickets>
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
            role:String,
        }
    },
    props:{
      profile_id:[String,Number]
    },
    methods: {
      editProfile() {
        console.log('Edit profile clicked');
      },
      ItemDeleted(){
        this.getInfos();
      },
      getUserInfo(){
        let url ='/profile/user';
        if (this.profile_id!=0){
          url = `/profile/${parseInt(this.profile_id)}`;
        }
        console.log("profile_id = ",this.profile_id);
        axios.get(url)
        .then(response => {
          this.user = response.data;
          this.role=this.user.role;
        })
        .catch(error => {
          console.error('Error fetching agencies:', error);
        });  
        console.log('role = ',this.user);
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
  watch:{
    profile_id:'getUserInfo',
    role:'',

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
  </style>
  