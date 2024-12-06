<script setup>
    import{CalendarIcon, BellIcon, QueueListIcon, HomeIcon, InboxArrowDownIcon, CogIcon, Square3Stack3DIcon, DocumentDuplicateIcon, TruckIcon, UserIcon} from '@heroicons/vue/24/solid'
    import { reactive, ref, onMounted } from "vue"
    import { useRouter } from "vue-router"
    onMounted(async () => {
		getCredentials()
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
		router.push('/bene_login')
	}

    const getCredentials = async () => {
		const response = await fetch(`/api/dashboard`);
		credentials.value = await response.json();
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
                    <!-- <div class="text-2xl uppercase font-bold text-orange-500 w-full text-center">
                        KIDDOS
                    </div> -->
                    <div class="text-2xl uppercase w-full text-center">
                        <a class="navbar-brand brand-logo pb-0 pt-2" href="/bene_dashboard"><img class="!h-[50px]" src="../../images/logo.png" alt="logo"/></a>
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
                <!-- <ul class="navbar-nav mr-lg-4 w-100">
                <li class="nav-item nav-search d-none d-lg-block w-100">
                    <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="search">
                        <i class="mdi mdi-magnify"></i>
                        </span>
                    </div>
                    <input type="text" class="form-control" placeholder="Search now" aria-label="search" aria-describedby="search">
                    </div>
                </li>
                </ul> -->
                <ul class="navbar-nav navbar-nav-right">
                    <li class="nav-item nav-profile dropdown">
                        <a class="nav-link dropdown-toggle !flex" href="#" data-toggle="dropdown" id="profileDropdown" @click="userDrop = !userDrop">
                            <span>
                                <!-- <img :src="'storage/profile/'+credentials.picture" id="img1" v-if="credentials.picture!=null"/> -->
                                <!-- <UserIcon  fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="menu-icon w-5 h-5 "></UserIcon> -->
                                <img :src="'storage/profile/'+credentials.picture" id="img1" style="width:35px!important" v-if="credentials.picture!=null"/>
                                <UserIcon  fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="menu-icon w-5 h-5 " v-else></UserIcon>
                            </span>
                            <span class="nav-profile-name">{{ credentials.name }}</span>
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
                        <a class="nav-link !text-gray-600" href="/bene_dashboard">
                        <i class="mdi mdi-home menu-icon !text-gray-600">
                            <!-- <HomeIcon fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="menu-icon w-4 h-4 "></HomeIcon> -->
                        </i>
                        <span class="menu-title">Dashboard</span>
                        </a>
                    </li>
                    <!-- <li class="nav-item">
                        <a class="nav-link !text-gray-600" href="/donate">
                        <i class="mdi mdi-home menu-icon !text-gray-600">
                            <InboxArrowDownIcon fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="menu-icon w-4 h-4 "></InboxArrowDownIcon>
                        </i>
                        <span class="menu-title">Donate</span>
                        </a>
                    </li> -->
                    <li class="nav-item">
                        <a class="nav-link !text-gray-600" href="/bene_profile">
                        <i class="mdi mdi-account menu-icon !text-gray-600">
                            <!-- <UserIcon fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="menu-icon w-4 h-4 "></UserIcon> -->
                        </i>
                        <span class="menu-title">Profile</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link !text-gray-600" href="/attendance">
                        <i class="mdi mdi-calendar menu-icon !text-gray-600">
                            <!-- <QueueListIcon fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="menu-icon w-4 h-4 "></QueueListIcon> -->
                        </i>
                        <span class="menu-title">Attendance</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link !text-gray-600" href="/bmi_history">
                        <i class="mdi mdi-list-box menu-icon !text-gray-600">
                            <QueueListIcon fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="menu-icon w-4 h-4 "></QueueListIcon>
                        </i>
                        <span class="menu-title">BMI History</span>
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