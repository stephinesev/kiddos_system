<script setup>
    import{CalendarIcon, HomeIcon, KeyIcon, UserIcon, DocumentTextIcon, RectangleGroupIcon, Square3Stack3DIcon, DocumentDuplicateIcon, TruckIcon, BanknotesIcon} from '@heroicons/vue/24/solid'
    import { reactive, ref, onMounted } from "vue"
    import { useRouter } from "vue-router"
    onMounted(async () => {
		getDashboard()
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
    const logout = () => {
		localStorage.removeItem('token')
		router.push('/')
	}

    const getDashboard = async () => {
		const response = await fetch(`/api/dashboard`);
		credentials.value = await response.json();
        // console.log(credentials.value)
	}
</script>
<template>
    
    <div class="container-scroller">
    <!-- partial:partials/_navbar.html -->
        <nav class="navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
            <div class="navbar-brand-wrapper d-flex justify-content-center">
                <div class="navbar-brand-inner-wrapper d-flex justify-content-between align-items-center w-100">  
                <!-- <a class="navbar-brand brand-logo" href="index.html">\PURCHASING</a>
                <a class="navbar-brand brand-logo-mini" href="index.html"><img src="" alt="logo"/>P</a> -->
                    <div class="text-2xl uppercase font-bold text-orange-500 w-full text-center">
                        KIDDOS
                    </div>
                    <button class="navbar-toggler navbar-toggler align-self-center"  @click="toggleSidebar" type="button" data-toggle="minimize">
                        <span class="mdi mdi-sort-variant"></span>
                    </button>
                    <!-- <button class="navbar-toggler navbar-toggler align-self-center" type="button" data-toggle="minimize">
                        <span class="mdi mdi-sort-variant"></span>
                    </button> -->
                </div>  
            </div>
            <div class="navbar-menu-wrapper d-flex align-items-center justify-content-end">
                <ul class="navbar-nav mr-lg-4 w-100">
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
                </ul>
                <ul class="navbar-nav navbar-nav-right">
                <li class="nav-item dropdown mr-1">
                    <a class="nav-link count-indicator dropdown-toggle d-flex justify-content-center align-items-center" id="messageDropdown" href="#" data-toggle="dropdown">
                    <i class="mdi mdi-message-text mx-0"></i>
                    </a>
                </li>
                <li class="nav-item dropdown mr-4">
                    <a class="nav-link count-indicator dropdown-toggle d-flex align-items-center justify-content-center notification-dropdown" id="notificationDropdown" href="#" data-toggle="dropdown">
                    <i class="mdi mdi-bell mx-0"></i>
                    </a>
                </li>
                <li class="nav-item nav-profile dropdown">
                    <a class="nav-link dropdown-toggle !flex" href="#" data-toggle="dropdown" id="profileDropdown" @click="userDrop = !userDrop">
                        <span>
                            <UserIcon  fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="menu-icon w-5 h-5 "></UserIcon>
                        </span>
                        <span class="nav-profile-name"></span>
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
                        <a class="dropdown-item">
                            <i class="mdi mdi-settings text-primary"></i>
                            Settings
                        </a>
                        <a href="#" class="dropdown-item" @click="logout" >
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
                            <CalendarIcon fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="menu-icon w-4 h-4 "></CalendarIcon>
                        </i>
                        <span class="menu-title">Donate</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link !text-gray-600" href="/donate_history">
                        <i class="mdi mdi-home menu-icon !text-gray-600">
                            <CalendarIcon fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="menu-icon w-4 h-4 "></CalendarIcon>
                        </i>
                        <span class="menu-title">Donate History</span>
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