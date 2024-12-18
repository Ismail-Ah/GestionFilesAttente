import { createRouter, createWebHistory } from 'vue-router';
import HomePage from './components/TicketDispenser/home.vue';
import ServiceSelection from './components/TicketDispenser/ServicesSelection.vue';
import serviceStatistique from './components/TicketDispenser/serviceStatistique.vue';
import TicketPrint from './components/TicketDispenser/ticket.vue';
import ajouterAgence from './components/admin/ajouteragence.vue';
import ajouterService from './components/admin/ajouterService.vue';
import CreateAgentAcount from './components/admin/createAgentAcount.vue';
import Dashboard from './components/dashboard/dashboard.vue';
import Statistiques from './components/Statistiques/statistiques.vue';
import SelectAgence from './components/TicketDispenser/SelectAgence.vue';
import HomeVisitor from './components/TicketDispenser/homeVisitor.vue';
import Profile from './components/profile/profile.vue';
import EditAgence from './components/admin/editAgence.vue';
import Select from './components/select.vue';
import EditService from './components/admin/editService.vue';
import EditAgent from './components/admin/editAgent.vue';
import LiveQueue from './components/queue/liveQueue.vue';
import HomeQueue from './components/queue/home.vue';
import UpdateProfileImage from './components/admin/updateImageProfile.vue';

const routesTicketDispenser = [
    {path : '/ticket-dispenser',component:HomePage,props: route => ({ url:route.params.url||'/ticket-dispenser/' })},
    {path : '/ticket-dispenser/agences',name:'ticketDispenserAgences',component:SelectAgence,props: route => ({ url:route.params.url||'/ticket-dispenser/'})},
    { path: '/ticket-dispenser/agences/:id', component: HomeVisitor },
    { path: '/agence/:id/ticket-dispenser/services', component: ServiceSelection },
    { path: '/agence/:agence_id/ticket-dispenser/services/:service_id',component: serviceStatistique},
    { path : '/agence/:agence_id/ticket-dispenser/services/:service_id/ticket',component: TicketPrint},
    { path: '/live-queue/agences/:id', component: HomeQueue },
];

const routesHome=[
    { path: '/dashboard',name:'dashboard', component: Dashboard,props: route => ({ activeItem1:"dashboard",role: route.params.role,agence_id:route.params.agence_id||0,service_id:route.params.service_id||0 })},
    { path: '/statistiques', component: Statistiques,props: route => ({activeItem1:"statistiques", role: route.params.role })},
    {
        path: '/profile',
        name: 'profile',
        component: Profile,
        props: route => ({
            activeItem1:"profile",
          role1: route.params.role1||route.params.role,
          role: route.params.role,
          profile_id: route.params.profile_id || 0 
        })
      },

    {path:'/live-queue',component:LiveQueue},
    ]

const routesAdmin = [
    { path: '/ajouter-agence', component: ajouterAgence,props: route => ({ activeItem1:"Agences",role: route.params.role }) },
    {path :'/agence/:id/ajouter-service',component: ajouterService,props: route => ({activeItem1:"Services", role: route.params.role,dashboard:true })},
    {path :'/ajouter-service',component: ajouterService,props: route => ({activeItem1:"Services", role: route.params.role,dashboard:false })},
    {path :'/agence/:id/ticket-dispenser',component: HomePage,props: route => ({ role: route.params.role })},
    {path :'/ajouter-agent',component: CreateAgentAcount,props: route => ({activeItem1:"Agents", role: route.params.role })},
    {path :'/editer-agence',name: 'edit-agency',component: EditAgence,props: route => ({agence:route.params.agence||'',activeItem1:"Agences", role: route.params.role })},
    {path :'/editer-service',name:'edit-service',component: EditService,props: route => ({service:route.params.service||'',agence:route.params.agence||'',activeItem1:"Services", role: route.params.role })},
    {path :'/editer-agent',name:'edit-agent',component: EditAgent,props: route => ({agent:route.params.agent||'',role2:route.params.role2||'AGENT',activeItem1:"Agents", role: route.params.role })},
    {path :'/user/:id/update-image-profile',component: UpdateProfileImage,props: route => ({role: route.params.role })},
];


const routes = [
    ...routesTicketDispenser,
    ...routesAdmin,
    ...routesHome,
];

// Créer une instance de routeur
const router = createRouter({
    history: createWebHistory(),
    routes,
});

export default router;