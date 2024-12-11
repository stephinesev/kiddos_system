<script setup>
	import navigation from '@/layouts/navigation_bene.vue';
	import{ Bars3Icon, PencilIcon, CircleStackIcon, EllipsisVerticalIcon} from '@heroicons/vue/24/solid'
	// import{ ClockIcon } from '@heroicons/vue/24/outlined'
	import{ClockIcon, MapPinIcon} from '@heroicons/vue/24/outline'
    import { reactive, ref, onMounted} from "vue"
    import { useRouter } from "vue-router"
    //Datatable Package
    import DataTable from 'datatables.net-vue3';
    import DataTablesCore from 'datatables.net-bs5';
    
    import FullCalendar from '@fullcalendar/vue3'
	import dayGridPlugin from '@fullcalendar/daygrid'
	import interactionPlugin from '@fullcalendar/interaction'
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
    let credentials=ref([]);
    let events_today=ref([]);
    const modalImage = ref(false)
    const hideModal = ref(true)
    //Fetcher of Data
	onMounted(async () => {
        getEventsToday()
        getDashboard()
	})

    var colors = ['red', 'green', 'blue', 'orange', 'yellow'];
	const calendarOptions = {
		headerToolbar: {
			left: 'prevYear,prev,next,nextYear today',
			center: 'title',
			right: 'dayGridMonth,dayGridWeek,dayGridDay'
		},
		plugins: [ dayGridPlugin, interactionPlugin ],
        initialView: 'dayGridMonth',
		// businessHours: true,
		dayMaxEvents: true, // allow "more" link when too many events
		eventColor: colors[Math.floor(Math.random() * colors.length)],
        eventSources: [
			{
				events: function(fetchInfo, successCallback, failureCallback) {
					axios.get('/api/get_dashboard_events').then(response => {
						successCallback(response.data.eventall)
					});
				},
			}
		],
	}
	const getDashboard = async () => {
		const response = await fetch(`/api/dashboard`);
		credentials.value = await response.json();
	}

    //Fetching Data From Events Table current event for display
	const getEventsToday = async () => {
		let response = await axios.get("/api/today_event");
		events_today.value = response.data.events_today;
	}
</script>
<template>
	<navigation>
        <div class="row">
                    <div class="col-md-12 grid-margin  mb-3">
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
            <div class="col-lg-8">
                <div class="card p-2 !shadow-sm">
                    <div class="tab-content py-0 px-0">
                        <div class="tab-pane fade show active" id="overview" role="tabpanel" aria-labelledby="overview-tab">
                            <FullCalendar :options="calendarOptions">
                                <template v-slot:eventContent='arg'>
                                    <div style="text-align:left;">
                                            <b>Event Name:</b> {{arg.event.title}}<br />
                                        </div>
                                </template>
                            </FullCalendar>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
               
                <div class="row">
                    <div class="col-lg-12">
                        <div class="shadow-sm rounded-t-xl">
                            <div class="bg-blue-500 rounded-t-xl py-2 px-4 text-white">
                                <div class="flex justify-start !space-x-2">
                                    <span class="bg-gray-400 p-1 rounded-xl my-auto"></span>
                                    <span class="m-0 text-sm">{{ moment(date).format('dddd, MMMM DD,YYYY') }} </span>
                                </div>
                            </div>
                            <div class="p-4 bg-white overflow-y-scroll h-[648px]" >
                                <div v-for="(et,index) in events_today">
                                    <div class="card rounded-lg !border !border-l-8 mb-3" :style="(et.event_color!=null) ? 'border-color:'+et.event_color : 'border-color:#3788d8'">
                                        <div class="card-body p-3">
                                            <div class="flex justify-between">
                                                <div>
                                                    <div class="flex justify-start ">
                                                        <span class="mr-2 text-teal-400">
                                                            <ClockIcon fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="menu-icon w-4 h-4 "></ClockIcon>
                                                        </span>
                                                        <p class="text-sm m-0 text-gray-600">{{ moment(et.event_time, "hh:mm:ss").format('hh:mm A') }}</p>
                                                    </div>
                                                    <p class="text-base font-bold text-gray-800 my-1">{{ et.event_name }}</p>
                                                    <p class="text-sm m-0 text-gray-600">
                                                        {{ et.event_description }}
                                                    </p>
                                                    <div class="flex justify-start mt-1">
                                                        <span class="mr-2">
                                                            <MapPinIcon fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="menu-icon w-4 h-4 "></MapPinIcon>
                                                        </span>
                                                        <p class="text-sm m-0 text-gray-600">{{et.event_address}}</p>
                                                    </div>
                                                </div>
                                                <!-- <div>
                                                    <span>
                                                        <EllipsisVerticalIcon fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="menu-icon w-4 h-4 "></EllipsisVerticalIcon>
                                                    </span>
                                                </div> -->
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
	</navigation>
</template>