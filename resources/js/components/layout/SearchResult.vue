
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
.filter-btn-group {
    margin-right: 1rem;
  }
  </style>
  
  