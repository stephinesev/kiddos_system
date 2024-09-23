<script setup>
	import navigation from '@/layouts/navigation_donor.vue';
	import{ Bars3Icon, PencilIcon, MagnifyingGlassIcon, EllipsisVerticalIcon} from '@heroicons/vue/24/solid'
	// import{ ClockIcon } from '@heroicons/vue/24/outlined'
	import{ClockIcon, MapPinIcon} from '@heroicons/vue/24/outline'
    import { reactive, ref, onMounted} from "vue"
    import { useRouter } from "vue-router"
    //Datatable Package
    import DataTable from 'datatables.net-vue3';
    import DataTablesCore from 'datatables.net-bs5';
	import 'datatables.net-responsive';
	import 'datatables.net-select';
	import 'datatables.net-buttons';
	import 'datatables.net-buttons/js/buttons.html5';
	import 'datatables.net-buttons/js/buttons.print.js';
	import jszip from 'jszip';
	import $ from 'jquery'
    import moment from 'moment'
    //Variables
    let donationsall=ref([]);
    let donation_images=ref([]);
    const modalImage = ref(false)
    const hideModal = ref(true)
    //Fetcher of Data
	onMounted(async () => {
        allDonations()
	})
</script>
<template>
	<navigation>
        <div class="row">
			<div class="col-md-12 grid-margin">
				<div class="d-flex justify-content-between flex-wrap mx-3 mt-3">
					<div class="d-flex align-items-end flex-wrap">
						<div class="mr-md-3 mr-xl-5">
                            <h2>Welcome back,</h2>
                            <p class="mb-md-0">See the following Events below.</p>
						</div>
						<!-- <div class="d-flex">
                            <i class="mdi mdi-home text-muted hover-cursor"></i>
                            <p class="text-muted mb-0 hover-cursor">&nbsp;/&nbsp;Dashboard&nbsp;/&nbsp;</p>
                            <p class="text-primary mb-0 hover-cursor">Analytics</p>
						</div> -->
					</div>
				</div>
			</div>
		</div>
		<div class="row">
            <div class="col-lg-12">
                <div class="card rounded-lg !border !border-teal-400 !border-l-8 mb-3">
                    <div class="card-body p-3">
                        <div class="flex justify-between">
                            <div>
                                <div class="flex justify-start ">
                                    <span class="mr-2 text-teal-400">
                                        <ClockIcon fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="menu-icon w-4 h-4 "></ClockIcon>
                                    </span>
                                    <p class="text-sm m-0 text-gray-600">8:00am - 5:00pm</p>
                                </div>
                                <p class="text-base font-bold text-gray-800 my-1">Feeding Program</p>
                                <p class="text-sm m-0 text-gray-600">
                                    It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using 'Content here, content here', making it look like readable English.
                                </p>
                                <div class="flex justify-start mt-1">
                                    <span class="mr-2">
                                        <MapPinIcon fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="menu-icon w-4 h-4 "></MapPinIcon>
                                    </span>
                                    <p class="text-sm m-0 text-gray-600">Brgy. Mabusilak, Purok 2, Sipalay Marie City</p>
                                </div>
                                
                            </div>
                            <div>
                                <span>
                                    <EllipsisVerticalIcon fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="menu-icon w-4 h-4 "></EllipsisVerticalIcon>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card rounded-lg !border !border-blue-400 !border-l-8 mb-3">
                    <div class="card-body p-3">
                        <div class="flex justify-between">
                            <div>
                                <div class="flex justify-start ">
                                    <span class="mr-2 text-blue-400">
                                        <ClockIcon fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="menu-icon w-4 h-4 "></ClockIcon>
                                    </span>
                                    <p class="text-sm m-0 text-gray-600">8:00am - 5:00pm</p>
                                </div>
                                <p class="text-base font-bold text-gray-800 my-1">Relief Goods</p>
                                <p class="text-sm m-0 text-gray-600">
                                    It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using 'Content here, content here', making it look like readable English.
                                </p>
                                <div class="flex justify-start mt-1">
                                    <span class="mr-2">
                                        <MapPinIcon fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="menu-icon w-4 h-4 "></MapPinIcon>
                                    </span>
                                    <p class="text-sm m-0 text-gray-600">Brgy. Mabusilak, Purok 2, Sipalay Marie City</p>
                                </div>
                                
                            </div>
                            <div>
                                <span>
                                    <EllipsisVerticalIcon fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="menu-icon w-4 h-4 "></EllipsisVerticalIcon>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
	</navigation>
</template>