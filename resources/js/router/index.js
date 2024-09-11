import { createRouter, createWebHistory } from "vue-router";



import loginForm from  '../components/login.vue'
import dashboard from '../components/dashboard.vue'
import beneficaryIndex from '../components/beneficiary/index.vue'
import beneficaryView from '../components/beneficiary/view.vue'
import DonorIndex from '../components/donors/index.vue'
import eventsIndex from '../components/events/index.vue'

import DonorUI_Index from '../components/donors_ui/index.vue'
import DonorUI_Dashboard from '../components/donors_ui/dashboard.vue'
import DonorUI_Donate from '../components/donors_ui/donate.vue'
import DonorUI_Register from '../components/donors_ui/register.vue'
import DonorUI_History from '../components/donors_ui/donate_history.vue'

const routes = [
    {
        path:'/',
        name:'login',
        component: loginForm,
        meta:{
            requiresAuth:false
        }
    },
    {
        path:'/dashboard',
        component: dashboard,
        meta:{
            requiresAuth:true
        }
    },
    

    {
        path:'/beneficiary',
        component: beneficaryIndex,
        meta:{
            requiresAuth:true
        }
    },

    {
        path:'/beneficiary/view/:id',
        props:true, 
        component: beneficaryView,
        meta:{
            requiresAuth:true
        }
    },
    {
        path:'/donors',
        component: DonorIndex,
        meta:{
            requiresAuth:true
        }
    },

    {
        path:'/events',
        component: eventsIndex,
        meta:{
            requiresAuth:true
        }
    },


    {
        path:'/donor_login/',
        component: DonorUI_Index
    },
    {
        path:'/donor_register/',
        component: DonorUI_Register
    },
    {
        path:'/donor_dashboard/',
        component: DonorUI_Dashboard
    },
    {
        path:'/donate/',
        component: DonorUI_Donate
    },
    {
        path:'/donation_history/',
        component: DonorUI_History
    },
    // {
    //     path:'/:pathMatch(.*)*',
    //     name:'notFound',
    //     component: notFound,
    // }
]

const router = createRouter({
    history: createWebHistory(),
    routes
})

router.beforeEach((to,from) => {
    if(to.meta.requiresAuth && !localStorage.getItem('token') ){
        return { name: 'login'}
    } 
})

export default router
