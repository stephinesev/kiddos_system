<script setup>
    import{CalendarIcon, BellIcon, QueueListIcon, HomeIcon, InboxArrowDownIcon, CogIcon, Square3Stack3DIcon, DocumentDuplicateIcon, TruckIcon, UserIcon} from '@heroicons/vue/24/solid'
    import { reactive, ref, onMounted } from "vue"
    import { useRouter } from "vue-router"
    import moment from 'moment'
    let intervalId;
    onMounted(async () => {
		getCredentials()
        intervalId = setInterval(() => {
			getNotification();
  		}, 800);
	})
    const router = useRouter() //use if link is used inside the page
    const userDrop = ref(false);
    const notif = ref(false);
    
    const menu = ref(false);
    const masterfileDrop = ref(false);
    const prDrop = ref(false);
    const rfqDrop = ref(false);
    const poDrop = ref(false);
    const drDrop = ref(false);
    const rfdDrop = ref(false);
	const hideDrop = ref(true)
	const credentials = ref([])
    const notification = ref([])
	const notification_count = ref(0)
	const openMaster = () => {
		masterfileDrop.value = !masterfileDrop.value
		prDrop.value = !hideDrop.value
        rfqDrop.value = !hideDrop.value
        poDrop.value = !hideDrop.value
        drDrop.value = !hideDrop.value
        rfdDrop.value = !hideDrop.value
	}
    const openPR = () => {
		prDrop.value = !prDrop.value
        masterfileDrop.value = !hideDrop.value
        rfqDrop.value = !hideDrop.value
        poDrop.value = !hideDrop.value
        drDrop.value = !hideDrop.value
        rfdDrop.value = !hideDrop.value
	}
    const openRFQ = () => {
		rfqDrop.value = !rfqDrop.value
        prDrop.value = !hideDrop.value
        masterfileDrop.value = !hideDrop.value
        poDrop.value = !hideDrop.value
        drDrop.value = !hideDrop.value
        rfdDrop.value = !hideDrop.value
	}
    const openPO = () => {
        poDrop.value = !poDrop.value
		rfqDrop.value = !hideDrop.value
        prDrop.value = !hideDrop.value
        masterfileDrop.value = !hideDrop.value
        drDrop.value = !hideDrop.value
        rfdDrop.value = !hideDrop.value
	}
    const openDR = () => {
        drDrop.value = !drDrop.value
        poDrop.value = !hideDrop.value
		rfqDrop.value = !hideDrop.value
        prDrop.value = !hideDrop.value
        masterfileDrop.value = !hideDrop.value
        rfdDrop.value = !hideDrop.value
	}
    const openRFD = () => {
        rfdDrop.value = !rfdDrop.value
        drDrop.value = !hideDrop.value
        poDrop.value = !hideDrop.value
		rfqDrop.value = !hideDrop.value
        prDrop.value = !hideDrop.value
        masterfileDrop.value = !hideDrop.value
	}
	const closeModal = () => {
		drawer_dr.value = !hideDrop.value
		drawer_rfd.value = !hideDrop.value
		drawer_revise.value = !hideDrop.value
	}
    const logout_donor = () => {
		localStorage.removeItem('token')
		router.push('/donor_login')
	}

    const getCredentials = async () => {
		const response = await fetch(`/api/donor_credentials`);
		credentials.value = await response.json();
	}
    //Function for notification
    const getNotification = async () => {
		const response = await axios.get(`/api/get_notification_donor`);
		notification.value = response.data.notification;
		notification_count.value = response.data.notification_count;
	}

    //Read Notification function
	const readNotif = (id) => {
        axios.get(`/api/read_notification/`+id).then(function () {
            getNotification()
        }).catch(function(err){
            success.value=''
            error.value.push('Error! Try again.')
        });
	}
</script>
<style>
    .navbar .navbar-menu-wrapper .navbar-nav .nav-item.nav-profile .nav-link img {
        width: 60px!important;
    }
</style>
<template>
    
    <div class="container-scroller">
    <!-- partial:partials/_navbar.html -->
        <nav class="navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
            <div class="navbar-brand-wrapper d-flex justify-content-center">
                <div class="navbar-brand-inner-wrapper d-flex justify-content-between align-items-center w-100">  
                <!-- <a class="navbar-brand brand-logo" href="index.html">\PURCHASING</a>
                <a class="navbar-brand brand-logo-mini" href="index.html"><img src="" alt="logo"/>P</a> -->
                    <div class="text-2xl uppercase w-full text-center">
                        <a class="navbar-brand brand-logo pb-0 pt-2" href="index.html"><img class="!h-[50px]" src="../../images/logo.png" alt="logo"/></a>
                    </div>
                    <button class="navbar-toggler navbar-toggler align-self-center"  @click="toggleSidebar" type="button" data-toggle="minimize">
                        <span class="mdi mdi-sort-variant"></span>
                    </button>
                    <!-- <button class="navbar-toggler navbar-toggler align-self-center" type="button" data-toggle="minimize">
                        <span class="mdi mdi-sort-variant"></span>
                    </button> -->
                </div>  
            </div>
            <div class="navbar-menu-wrapper d-flex align-items-center justify-content-end !bg-gradient-to-r !from-blue-500 !to-blue-500">
                <ul class="navbar-nav mr-lg-4 w-100">
                    <li class="nav-item nav-search d-none d-lg-block w-100 ">
                        <div class="input-group bg-white">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="search">
                                    <i class="mdi mdi-home menu-icon !text-gray-600">
                                        <MagnifyingGlassIcon fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="menu-icon w-4 h-4 "></MagnifyingGlassIcon>
                                    </i>
                                </span>
                            </div>
                            <input type="text" class="form-control !bg-white" placeholder="Search now" aria-label="search" aria-describedby="search">
                        </div>
                    </li>
                </ul>
                <ul class="navbar-nav navbar-nav-right">
                    <li class="nav-item dropdown m-0">
                        <a class="!text-white nav-link count-indicator dropdown-toggle d-flex align-items-center justify-content-center notification-dropdown" href="#" data-toggle="dropdown" id="profileDropdown" @click="notif = !notif">
                            <span>
                                <BellIcon  fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="menu-icon w-5 h-5 "></BellIcon>
                            </span>
                            <span class="bg-red-500 absolute z-index-50 rounded-xl p-.5 px-1.5 -top-2 -right-2 text-[10px] text-white">{{ notification_count }}</span>
                            <!-- <span class="nav-profile-name">{{ credentials.fullname }}</span> -->
                        </a>
                        <Transition
                            enter-active-class="transition ease-out duration-200"
                            enter-from-class="opacity-0"
                            enter-to-class="opacity-100 "
                            leave-active-class="transition ease-in duration-200"
                            leave-from-class="opacity-100 "
                            leave-to-class="opacity-0"
                        >
                        <div class="dropdown-menu dropdown-menu-right navbar-dropdown" aria-labelledby="notificationDropdown" v-show="notif">
                            <p class="mb-0 font-weight-normal float-left dropdown-header">Notifications</p>
                            <div v-if="notification!=''">
                                <span v-for="(notif,index) in notification">
                                    <a class="dropdown-item" @click="readNotif(notif.id)">
                                        <div class="item-thumbnail">
                                            <div class="item-icon bg-success">
                                                <span>
                                                    <img :src="'storage/profile/'+notif.donors[0].profile_image" id="img1" v-if="notif.donors[0].profile_image!=null"/>
                                                    <img src="../../images/default.jpg" id="img1" v-else/>
                                                </span>
                                            </div>
                                            </div>
                                            <div class="item-content">
                                            <h6 class="font-weight-normal">{{ notif.notification }}</h6>
                                            <p class="font-weight-light small-text mb-0 text-muted">
                                                <!-- Just now -->
                                                {{ moment(notif.created_at).format("MMMM DD, YYYY [at] h:mm A z") }}
                                            </p>
                                        </div>
                                    </a>
                                </span>
                            </div>
                            <span v-else>
                                <a class="dropdown-item" @click="readNotif(notif.id)">
                                    <div class="item-content">
                                        <center>
                                            <h4 class="font-weight-bold"> 
                                                No Notifications Yet
                                            </h4>
                                            <h6 style="color:grey">
                                                You have no notification right now.
                                            </h6>
                                            <h6  style="color:grey">
                                                Come back later
                                            </h6>
                                        </center>
                                    </div>
                                </a>
                            </span>
                        </div>
                        </Transition>
                    </li>
                    <li class="nav-item nav-profile dropdown">
                        <a class="!text-white  nav-link dropdown-toggle !flex" href="#" data-toggle="dropdown" id="profileDropdown" @click="userDrop = !userDrop">
                            <span>
                                <img :src="'storage/profile/'+credentials.picture" id="img1" style="width:75px!important;" v-if="credentials.picture!=null"/>
                                <UserIcon  fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="menu-icon w-5 h-5 " v-else></UserIcon>
                            </span>
                            <span class="nav-profile-name">{{ credentials.fullname }}</span>
                        </a>
                        <Transition
                            enter-active-class="transition ease-out duration-200"
                            enter-from-class="opacity-0"
                            enter-to-class="opacity-100 "
                            leave-active-class="transition ease-in duration-200"
                            leave-from-class="opacity-100 "
                            leave-to-class="opacity-0"
                        >
                        
                        <div class="dropdown-menu dropdown-menu-right navbar-dropdown" aria-labelledby="profileDropdown"  v-show="userDrop">
                            <a href="#" class="dropdown-item" @click="logout_donor" >
                                <i class="mdi mdi-logout text-primary"></i>
                                Logout
                            </a>
                        </div>
                        </Transition>
                    </li>
                </ul>
                <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button" data-toggle="offcanvas">
                <span class="mdi mdi-menu"></span>
                </button>
            </div>
        </nav>
        <!-- partial -->
        <div class="container-fluid page-body-wrapper">
        <!-- partial:partials/_sidebar.html -->
            <nav class="sidebar sidebar-offcanvas " id="sidebar">
                <ul class="nav ">
                    <li class="nav-item">
                        <a class="nav-link !text-gray-600" href="/donor_dashboard">
                        <i class="mdi mdi-home menu-icon !text-gray-600">
                            <HomeIcon fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="menu-icon w-4 h-4 "></HomeIcon>
                        </i>
                        <span class="menu-title">Dashboard</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link !text-gray-600" href="/donate">
                        <i class="mdi mdi-home menu-icon !text-gray-600">
                            <InboxArrowDownIcon fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="menu-icon w-4 h-4 "></InboxArrowDownIcon>
                        </i>
                        <span class="menu-title">Donate</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link !text-gray-600" href="/donor_profile">
                        <i class="mdi mdi-home menu-icon !text-gray-600">
                            <UserIcon fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="menu-icon w-4 h-4 "></UserIcon>
                        </i>
                        <span class="menu-title">Profile</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link !text-gray-600" href="/donation_history">
                        <i class="mdi mdi-home menu-icon !text-gray-600">
                            <QueueListIcon fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="menu-icon w-4 h-4 "></QueueListIcon>
                        </i>
                        <span class="menu-title">Donation History</span>
                        </a>
                    </li>
                </ul>
            </nav>
            <!-- partial -->
            <div class="main-panel">
                <div class="content-wrapper">
                    <slot></slot>
                </div>
            </div>
        </div>
    </div>
</template>