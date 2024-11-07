import { createRouter, createWebHistory } from "vue-router";



import loginForm from  '../components/login.vue'
import dashboard from '../components/dashboard.vue'
import barangay from '../components/barangay/index.vue'
import qr_scanner from '../components/qr_scanner.vue'
import adminIndex from '../components/admin/index.vue'
import beneficaryIndex from '../components/beneficiary/index.vue'
import beneficaryView from '../components/beneficiary/view.vue'
import DonorIndex from '../components/donors/index.vue'
import eventsIndex from '../components/events/index.vue'

import DonorUI_Index from '../components/donors_ui/index.vue'
import DonorUI_Dashboard from '../components/donors_ui/dashboard.vue'
import DonorUI_Donate from '../components/donors_ui/donate.vue'
import DonorUI_DonorProfile from '../components/donors_ui/donor_profile.vue'
import DonorUI_Register from '../components/donors_ui/register.vue'
import DonorUI_History from '../components/donors_ui/donate_history.vue'
import DonationAdminIndex from '../components/donations/index.vue'
import DonationAdminView from '../components/donations/view.vue'


import BeneUI_Index from '../components/beneficiary_ui/index.vue'
import BeneUI_Dashboard from '../components/beneficiary_ui/dashboard.vue'
import BeneUI_Donate from '../components/beneficiary_ui/donate.vue'
import BeneUI_DonorProfile from '../components/beneficiary_ui/beneficiary_profile.vue'
import BeneUI_Register from '../components/beneficiary_ui/register.vue'
import BeneUI_History from '../components/beneficiary_ui/view.vue'
import BeneUI_Attendance from '../components/beneficiary_ui/attendance_list.vue'

import LguUI_Index from '../components/lgu_ui/index.vue'
import LguUI_Dashboard from '../components/lgu_ui/dashboard.vue'

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
        path:'/barangay',
        component: barangay,
        meta:{
            requiresAuth:true
        }
    },
    {
        path:'/qr_scanner',
        component: qr_scanner,
        meta:{
            requiresAuth:true
        }
    },
    {
        path:'/admin',
        component: adminIndex,
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
        component: DonorUI_Index,
        meta:{
            requiresAuth:false
        }
    },
    {
        path:'/donor_register/',
        component: DonorUI_Register,
        meta:{
            requiresAuth:false
        }
    },
    {
        path:'/donor_dashboard/',
        component: DonorUI_Dashboard,
        meta:{
            requiresAuth:true
        }
    },
    {
        path:'/donate/',
        component: DonorUI_Donate,
        meta:{
            requiresAuth:true
        }
    },
    {
        path:'/donor_profile/',
        component: DonorUI_DonorProfile,
        meta:{
            requiresAuth:true
        }
    },
    {
        path:'/donation_history/',
        component: DonorUI_History,
        meta:{
            requiresAuth:true
        }
    },
    {
        path:'/donation_admin_view/',
        component: DonationAdminIndex,
        meta:{
            requiresAuth:true
        }
    },
    {
        path:'/donation_admin_view/view/:donation_id',
        component: DonationAdminView,
        props:true,
        meta:{
            requiresAuth:true
        }
    },


    {
        path:'/bene_login/',
        component: BeneUI_Index,
        meta:{
            requiresAuth:false
        }
    },
    {
        path:'/bene_register/',
        component: BeneUI_Register,
        meta:{
            requiresAuth:false
        }
    },
    {
        path:'/bene_dashboard/',
        component: BeneUI_Dashboard,
        meta:{
            requiresAuth:true
        }
    },
    {
        path:'/donate/',
        component: BeneUI_Donate,
        meta:{
            requiresAuth:true
        }
    },
    {
        path:'/bene_profile',
        component: BeneUI_DonorProfile,
        meta:{
            requiresAuth:true
        }
    },
    {
        path:'/bmi_history/',
        component: BeneUI_History,
        meta:{
            requiresAuth:true
        }
    },
    {
        path:'/attendance/',
        component: BeneUI_Attendance,
        meta:{
            requiresAuth:true
        }
    },


    {
        path:'/lgu_login/',
        component: LguUI_Index,
        meta:{
            requiresAuth:false
        }
    },
    {
        path:'/lgu_dashboard/',
        component: LguUI_Dashboard,
        meta:{
            requiresAuth:true
        }
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
