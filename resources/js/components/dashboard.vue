<script setup>
	import navigation from '@/layouts/navigation.vue';
	import{PlusIcon, UserIcon} from '@heroicons/vue/24/solid'
    import { reactive, ref, onMounted } from "vue"
    import { useRouter } from "vue-router"
	import FullCalendar from '@fullcalendar/vue3'
	import dayGridPlugin from '@fullcalendar/daygrid'
	import interactionPlugin from '@fullcalendar/interaction'
	const router = useRouter();
	let event_data = ref([])
	let credentials = ref([])
	//Fetcher of Data
	onMounted(async () => {
		getDashboard()
	})
	//Calendar Display of data
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
</script>
<style>
	#calendar {
		max-width: 1100px;
		margin: 0 auto;
	}
  	.fc-daygrid-event {
		white-space: normal !important;
		align-items: normal !important;
		font-family: Arial, Helvetica Neue, Helvetica, sans-serif;
  		font-size: 12px;
	}
</style>
<template>
	<navigation>
		<div class="row">
			<div class="col-md-12 grid-margin">
				<div class="d-flex justify-content-between flex-wrap">
					<div class="d-flex align-items-end flex-wrap">
						<div class="mr-md-3 mr-xl-5">
						<h2>Welcome back,</h2>
						<p class="mb-md-0">Your analytics dashboard template.</p>
						</div>
						<div class="d-flex">
						<i class="mdi mdi-home text-muted hover-cursor"></i>
						<p class="text-muted mb-0 hover-cursor">&nbsp;/&nbsp;Dashboard&nbsp;/&nbsp;</p>
						<p class="text-primary mb-0 hover-cursor">Analytics</p>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-md-8 grid-margin stretch-card">
				<div class="card">
					<div class="card-body dashboard-tabs p-0">
						<!-- <ul class="nav nav-tabs px-4" role="tablist">
						<li class="nav-item">
							<a class="nav-link active" id="overview-tab" data-toggle="tab" href="#overview" role="tab" aria-controls="overview" aria-selected="true">Overview</a>
						</li>
						<li class="nav-item">
							<a class="nav-link" id="sales-tab" data-toggle="tab" href="#sales" role="tab" aria-controls="sales" aria-selected="false">Sales</a>
						</li>
						<li class="nav-item">
							<a class="nav-link" id="purchases-tab" data-toggle="tab" href="#purchases" role="tab" aria-controls="purchases" aria-selected="false">Purchases</a>
						</li>
						</ul> -->

						<!-- Calendar Display  -->
						<div class="tab-content py-0 px-0">
							<div class="tab-pane fade show active" id="overview" role="tabpanel" aria-labelledby="overview-tab">
								<!-- <FullCalendar :options="calendarOptions" >
									<template #eventContent="arg">
											<template v-slot:activator="{ on, attrs }">
												<div style="min-height:20px;" v-bind="attrs" v-on="on">
												</div>
											</template>
											<div style="text-align:left;">
												<b>Event Name:</b> {{arg.event.title}}<br />
												<b>Event Time:</b> {{arg.event.extendedProps.time}}<br />
												<b>Event Description:</b> {{arg.event.extendedProps.description}}<br />
												<b>Where:</b> {{arg.event.extendedProps.address}}<br />
											</div>
									</template>
								</FullCalendar> -->
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
			</div>
		</div>
		<div class="row">
			<div class="col-md-6 grid-margin stretch-card">
				<div class="card">
				<div class="card-body">
					<div class="flex justify-between">
						<p class="card-title">Things To-Do Today</p>
						<span>
							<button class="btn btn-xs btn-primary px-1 py-1">
								<PlusIcon fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class=" w-3 h-3"></PlusIcon>
							</button>
						</span>
					</div>
					<p class="mb-4">To start a blog, think of a topic about and first brainstorm party is ways to write details</p>
					<div id="cash-deposits-chart-legend" class="d-flex justify-content-center pt-3"></div>
					<canvas id="cash-deposits-chart"></canvas>
				</div>
				</div>
			</div>
			<div class="col-md-6 grid-margin stretch-card">
				<div class="card">
					<div class="card-body">
						<div class="flex justify-between">
							<p class="card-title">Reminder</p>
							<span>
								<button class="btn btn-xs btn-primary px-1 py-1">
									<PlusIcon fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class=" w-3 h-3"></PlusIcon>
								</button>
							</span>
						</div>
						<!-- <table class="">
							<tr>
								<td></td>
								<td></td>
								<td></td>
							</tr>
						</table>               -->
					</div>
				</div>
			</div>
		</div>
	</navigation>
</template>