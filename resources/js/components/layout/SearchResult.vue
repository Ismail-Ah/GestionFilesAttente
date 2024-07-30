
  <template>
    
    <div >
      
        <div class="wrapper">
          <div class="content-header">
            <Agences  @deletItem="ItemDeleted" :agences="results.agences"></Agences>
            <Services  @deletItem="ItemDeleted" :role="role" :services="results.services" :user_id="user.id" ></Services>
            <Agents  @deletItem="ItemDeleted" :agents="results.agents" ></Agents>
          </div>
          
        </div>
   
    </div>
  </template>
  
  <script>
import Services from '../profile/Services.vue';
import Agences from '../profile/Agences.vue';
import Agents from '../profile/Agents.vue';


  export default {
    name: 'SearchResult',
    props: {
      results: {
        type: Object,
        required: true,
       
      },
      profile_id:[String,Number]
    },
    components: {Agents,Services,Agences},
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
            role:'ADMIN',
        }
    },
    methods: {
        ItemDeleted(){
            //
        },
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
  
  