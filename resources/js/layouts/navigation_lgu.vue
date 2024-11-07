<script setup>
    import{CalendarIcon, HomeIcon, KeyIcon, UserIcon, DocumentTextIcon, RectangleGroupIcon, Square3Stack3DIcon, DocumentDuplicateIcon, TruckIcon, BanknotesIcon, BellIcon,CogIcon, MagnifyingGlassIcon} from '@heroicons/vue/24/solid'
    import { reactive, ref, onMounted } from "vue"
    import { useRouter } from "vue-router"
    import moment from 'moment'
    let intervalId;
    onMounted(async () => {
		getDashboard()
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
	const closeModal = () => {
		drawer_dr.value = !hideDrop.value
		drawer_rfd.value = !hideDrop.value
		drawer_revise.value = !hideDrop.value
	}
    const logout = () => {
		localStorage.removeItem('token')
		router.push('/')
	}
    //Get Credential Details
    const getDashboard = async () => {
		const response = await fetch(`/api/dashboard`);
		credentials.value = await response.json();
	}
    
    //Function for notification
    const getNotification = async () => {
		const response = await axios.get("/api/get_notification");
		notification.value = response.data.notification;
		notification_count.value = response.data.notification_count;
	}

    //Read Notification function
	const readNotif = (id) => {
        axios.get(`/api/read_notification/`+id).then(function () {
            getNotification()
            router.push('/donation_admin_view/view/'+donation_id)
        }).catch(function(err){
            success.value=''
            error.value.push('Error! Try again.')
        });
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
            <!-- <nav class="sidebar sidebar-offcanvas " id="sidebar">
                <ul class="nav ">
                    <li class="nav-item">
                        <a class="nav-link !text-gray-600" href="/dashboard">
                        <i class="mdi mdi-home menu-icon !text-gray-600">
                            <HomeIcon fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="menu-icon w-4 h-4 "></HomeIcon>
                        </i>
                        <span class="menu-title">Dashboard</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link !text-gray-600 cursor-pointer" @click="openMaster()" >
                            <i class="mdi mdi-circle-outline menu-icon !text-gray-600">
                                <UserIcon fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="menu-icon w-4 h-4 "></UserIcon>
                            </i>
                            <span class="menu-title">Users</span>
                        </a>
                        <Transition
                            enter-active-class="transition ease-out duration-250"
                            enter-from-class="opacity-0 h-1/2"
                            enter-to-class="opacity-100 h-full"
                            leave-active-class="transition ease-in duration-100"
                            leave-from-class="opacity-100 h-full"
                            leave-to-class="opacity-0 h-1/2"
                        >
                            <div class="!hidden"  :class="{ show:masterfileDrop }">
                                <ul class="nav flex-column sub-menu">
                                    <li class="nav-item list-none"> <a class="nav-link" href="/beneficiary">Beneficiaries</a></li>
                                    <li class="nav-item list-none"> <a class="nav-link" href="/donors">Donors</a></li>
                                </ul>
                            </div>
                        </Transition>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link !text-gray-600" href="/donation_admin_view">
                        <i class="mdi mdi-home menu-icon !text-gray-600">
                            <BanknotesIcon fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="menu-icon w-4 h-4 "></BanknotesIcon>
                        </i>
                        <span class="menu-title">Donations</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link !text-gray-600" href="/events">
                        <i class="mdi mdi-home menu-icon !text-gray-600">
                            <CalendarIcon fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="menu-icon w-4 h-4 "></CalendarIcon>
                        </i>
                        <span class="menu-title">Events</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link !text-gray-600" href="/qr_scanner">
                        <i class="mdi mdi-home menu-icon !text-gray-600">
                            <MagnifyingGlassIcon fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="menu-icon w-4 h-4 "></MagnifyingGlassIcon>
                        </i>
                        <span class="menu-title">QR Scan</span>
                        </a>
                    </li>
                </ul>
            </nav> -->
            <!-- partial -->
            <div class="main-panel !w-full">
                <div class="content-wrapper">
                    <slot></slot>
                </div>
            </div>
        </div>
    </div>
</template>