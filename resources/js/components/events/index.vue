<script setup>
	import navigation from '@/layouts/navigation.vue';
	import{ Bars3Icon, PencilIcon, XMarkIcon, TrashIcon, CheckIcon} from '@heroicons/vue/24/solid'
	import{ArrowUpOnSquareIcon} from '@heroicons/vue/24/outline'
    import { reactive, ref, onMounted } from "vue"
    import { useRouter } from "vue-router"
	import { ColorPicker } from 'vue-color-kit'
	import 'vue-color-kit/dist/vue-color-kit.css'	
	const router = useRouter();
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
	let intervalId;
	let form=ref([]);
	let events=ref([]);
	let eventall=ref([]);
	let error = ref([])
	let color_display = ref([])
	let success = ref('')	
	const warningAlert = ref(false)
	const successAlert = ref(false)
	const hideAlert = ref(true)
	//Fetcher of Data
	onMounted(async () => {
		eventsForm()
		// intervalId = setInterval(() => {
		// 	allEvents();
  		// }, 10000);
		allEvents();
		getRandomHexColor()
	})
	const getRandomHexColor = () => {
		for(var i=0;i<10;i++){
			// Define an array of hexadecimal digits
			// const hexChars = [
			// 	'0',
			// 	'1',
			// 	'2',
			// 	'3',
			// 	'4',
			// 	'5',
			// 	'6',
			// 	'7',
			// 	'8',
			// 	'9',
			// 	'A',
			// 	'B',
			// 	'C',
			// 	'D',
			// 	'E',
			// 	'F',
			// ];
			var hexChars = ['#5E50F9', '#0f1531', '#6a008a', '#686868','#f96868','#f2a654','#f6e84e','#46c35f','#58d8a3','#57c7d4'];
			// Generate an array of six random indices from 0 to 15
			// const hexIndices = Array.from({ length: 6 }, () =>
			// 	Math.floor(Math.random() * 16)
			// );
			// Map each index to its corresponding hex digit and join them into a string
			// const hexCode = hexIndices.map((i) => hexChars[i]).join('');
			const hexCode= hexChars[i]
			// Return the string with a "#" prefix
			// return `#${hexCode}`;
			color_display.value[i] = `${hexCode}`
			// color_display.value[i] = `#${hexCode}`
		}
	};
	

	//Declaration of input values
	const eventsForm = async () => {
		let response = await axios.get("/api/create_event");
		form.value = response.data;
		
	}
	//Fetching Data From Events Table for display
	const allEvents = async () => {
		let response = await axios.get("/api/get_events");
		eventall.value = response.data.eventall;
	}

	//Insert Function
	const onSave = () => {
		const formData=new FormData()
		formData.append('event_name',form.value.event_name)
		formData.append('event_color',form.value.event_color)
		formData.append('event_description',form.value.event_description)
		formData.append('event_address',form.value.event_address)
		formData.append('event_time',form.value.event_time)
		formData.append('start_date',form.value.start_date)
		formData.append('end_date',form.value.end_date)
		axios.post("/api/add_event",formData).then(function () {
			success.value='You have successfully added new event!'
			form.value=[]
			error.value=[]
			successAlert.value = !successAlert.value
			setTimeout(() => {
				// window.location.reload()
				allEvents()
				closeAlert()
				closeModal()
			}, 2000);
		}).catch(function(err){
			// error.value=[]
			warningAlert.value = !warningAlert.value
			error.value='Fields cannot be empty!'
			// if (err.response.data.errors.event_name) {
			// 	error.value.push(err.response.data.errors.event_name[0])
			// }
			// if (err.response.data.errors.event_address) {
			// 	error.value.push(err.response.data.errors.event_address[0])
			// }
			// if (err.response.data.errors.event_time) {
			// 	error.value.push(err.response.data.errors.event_time[0])
			// }
			// if (err.response.data.errors.start_date) {
			// 	error.value.push(err.response.data.errors.start_date[0])
			// }
			// if (err.response.data.errors.end_date) {
			// 	error.value.push(err.response.data.errors.end_date[0])
			// }
		});
	}

	//Update function
	const onEdit = (id) => {
		const formData=new FormData()
		formData.append('event_name',events.value.event_name)
		formData.append('event_color',events.value.event_color)
		formData.append('event_description',events.value.event_description)
		formData.append('event_address',events.value.event_address)
		formData.append('event_time',events.value.event_time)
		formData.append('start_date',events.value.start_date)
		formData.append('end_date',events.value.end_date)
		axios.post(`/api/update_event/`+id, formData).then(function () {
			success.value='You have successfully updated event!'
			events.value=[]
			error.value=''
			successAlert.value = !successAlert.value
			setTimeout(() => {
				// window.location.reload()
				allEvents()
				closeAlert()
				closeModal()
			}, 2000);
		}).catch(function(err){
			// alert(err)
			// error.value=[]
			warningAlert.value = !warningAlert.value
			error.value='Fields cannot be empty!'
			// if (err.response.data.errors.event_name) {
			// 	error.value.push(err.response.data.errors.event_name[0])
			// }
			// if (err.response.data.errors.event_address) {
			// 	error.value.push(err.response.data.errors.event_address[0])
			// }
			// if (err.response.data.errors.event_time) {
			// 	error.value.push(err.response.data.errors.event_time[0])
			// }
			// if (err.response.data.errors.start_date) {
			// 	error.value.push(err.response.data.errors.start_date[0])
			// }
			// if (err.response.data.errors.end_date) {
			// 	error.value.push(err.response.data.errors.end_date[0])
			// }
		});
	}
	//Datatable Initialization
	DataTablesCore.Buttons.jszip(jszip);
    DataTable.use(DataTablesCore);
	//Buttons of Export excel, copy, and print of data from datatable
    const options = {
		// dom: 'Bftip',
		dom: "<'row'<'col-sm-8 col-lg-8 mb-2 pr-0 flex justify-end'B ><'col-sm-4 col-lg-4 mb-2 pl-1'f>>"+"<'row'<'col-sm-12 mb-2'tr>>"+"<'row'<'col-sm-6 mb-2'i><'col-sm-6 mb-2'p>>",
		select: true,	
		lengthMenu: [
			[10, 25, 50, -1],
			['10 rows', '25 rows', '50 rows', 'Show all']
		],
		buttons: [
			{
				title:'Events',
				extend: 'copy',
				exportOptions: {
					columns: [ 0, 1, 2, 3, 4, 5 ],
					orthogonal: null
				}
			},
			{
				title:'Events',
				extend: 'excel',
				exportOptions: {
                    columns: [ 0, 1, 2, 3, 4, 5 ],
					orthogonal: null,
				},
				createEmptyCells: true,
                customize: function(xlsx) {
                    var sheet = xlsx.xl.worksheets['sheet1.xml'];
                    var clRow = $('row', sheet);
                    clRow[0].children[0].remove(); // clear header cell
                    $( 'row c', sheet ).attr( 's', '25' );
                }
			},
			{
				title:'Events',
				extend: 'print',
				exportOptions: {
					columns: [ 0, 1, 2, 3, 4, 5 ],
					orthogonal: null
				}
			},
			{
				extend: 'pageLength'
			}
		]
	};

	//Modal Popup Variables
    const modalNew = ref(false)
    const modalEdit = ref(false)
	const hideModal = ref(true)
	const openNew = () => {
		modalNew.value = !modalNew.value
	}
    const openEdit = async (id) => {
		let response =  await axios.get(`/api/edit_event/`+id);
		events.value=response.data.events
		modalEdit.value = !modalEdit.value
	}
	const closeModal = () => {
		modalNew.value = !hideModal.value
		modalEdit.value = !hideModal.value
	}

	const closeAlert = () => {
		warningAlert.value = !hideAlert.value
		successAlert.value= !hideAlert.value
	}

	//Delete Function
	const deleteEvents = (id) => {
		var confirmation = confirm("Do you want to delete this event?");
		if (confirmation == true) {
			axios.get(`/api/delete_event/`+id).then(function () {
				success.value='Successfully deleted event!'
				error.value=[]
				allEvents()
				successAlert.value = !successAlert.value
				setTimeout(() => {
					// window.location.reload()
					allEvents()
					closeAlert()
					closeModal()
				}, 2000);
			}).catch(function(err){
				success.value=''
				error.value.push('Error! Try again.')
			});
		}
	}
</script>
<style>
	select{
		color:#363030!important
	}
</style>
<template>
	<navigation>
        <div class="row">
            <div class="col-lg-12">
                <div class="flex justify-between mb-3 px-2">
                    <span class="">
                        <h3 class="card-title !text-lg m-0 uppercase font-bold text-gray-600">Events <small>List</small></h3>
                    </span>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb !mb-0 !text-xs px-2 py-1 !bg-transparent">
                            <li class="breadcrumb-item"><a href="/dashboard">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Events List</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
		<div class="row">
            <div class="col-lg-12 stretch-card">
                <div class="card">
                    <div class="card-body">
						<!-- Add Event Modal Button -->
                        <div class="flex justify-between  mt-2 mb-0 absolute z-50 ">
                            <button @click="openNew()" class="btn btn-primary mt-2 mt-xl-0 text-white">
                                <span>Add New Event </span>
                            </button>
                        </div>
						<!-- DATATABLE -->
                        <div class="pt-3">
                            <DataTable :data="eventall" :options="options" class="display table table-bordered table-hover !border nowrap">
                                <thead>
                                    <tr>
                                        <th class="!text-xs bg-gray-100 uppercase"> Event Name</th>
                                        <th class="!text-xs bg-gray-100 uppercase"> Event Description</th>
                                        <th class="!text-xs bg-gray-100 uppercase"> Event Address</th>
                                        <th class="!text-xs bg-gray-100 uppercase"> Event Time</th>
                                        <th class="!text-xs bg-gray-100 uppercase"> Start Date</th>
                                        <th class="!text-xs bg-gray-100 uppercase"> End Date</th>
                                        <th class="!text-xs bg-gray-100 uppercase" width="1%" align="center"> 
                                            <span class="text-center  px-auto">
                                                <Bars3Icon fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="menu-icon w-5 h-5 "></Bars3Icon>
                                            </span>
                                        </th>
                                    </tr>
                                </thead>
                                <template #column-6="props" align="center">
                                    <button @click="openEdit(props.rowData.id)" class="btn btn-xs btn-info text-white p-1">
                                        <PencilIcon fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="menu-icon w-3 h-3 "></PencilIcon>
                                    </button >
									<button @click="deleteEvents(props.rowData.id)" class="btn btn-xs btn-danger text-white p-1">
                                        <TrashIcon fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="menu-icon w-3 h-3 "></TrashIcon>
                                    </button >
                                </template>
                            </DataTable>
                           
                        </div>
                    </div>
                </div>
            </div>
        </div>
		<!-- ADD EVENT MODAL -->
        <Transition
            enter-active-class="transition ease-out duration-200"
            enter-from-class="opacity-0 scale-95"
            enter-to-class="opacity-100 scale-100"
            leave-active-class="transition ease-in duration-75"
            leave-from-class="opacity-100 scale-100"
            leave-to-class="opacity-0 scale-95"
			>
			<div class="modal pt-4 px-3" :class="{ show:modalNew }">
				<div @click="closeModal" class="w-full h-full fixed"></div>
				<div class="modal__content w-6/12">
					<div class="row mb-3">
						<div class="col-lg-12 flex justify-between">
							<span class="font-bold ">Add Event</span>
							<a href="#" class="text-gray-600" @click="closeModal">
								<XMarkIcon fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4"></XMarkIcon>
							</a>
						</div>
					</div>
					<hr class="mt-0">
					<div class="modal_s_items ">
						<div class="row">
							<div class="col-lg-12 col-md-12">
								<label class="text-gray-500 m-0" for="">Event Color</label>
								<select name="color_display" id="color_display" class="form-control" v-model="form.event_color" :style="'background-color:'+form.event_color">
									<option value="">--Select Event Color--</option>
									<option :value="color_display[index]" v-for="(col,index) in color_display" :key="color_display[index]" :style="{background: color_display[index]}">{{ color_display[index] }}</option>
								</select>
							</div>
						</div>
                        <div class="row">
							<div class="col-lg-6 col-md-6">
								<div class="form-group">
									<label class="text-gray-500 m-0" for="">Event Name</label>
									<textarea placeholder="Event Name" class="form-control" rows="3" v-model="form.event_name"></textarea>
								</div>
							</div>
                            <div class="col-lg-6 col-md-6">
								<div class="form-group">
									<label class="text-gray-500 m-0" >Event Description</label>
									<textarea placeholder="Event Description" class="form-control" rows="3" v-model="form.event_description"></textarea>
								</div>
							</div>
						</div>
                        <div class="row">
							<div class="col-lg-6 col-md-6">
								<div class="form-group">
									<label class="text-gray-500 m-0" >Event Address</label>
									<textarea placeholder="Event Address" class="form-control" rows="3" v-model="form.event_address"></textarea>
								</div>
							</div>
                            <div class="col-lg-6 col-md-6">
								<div class="form-group">
									<label class="text-gray-500 m-0" >Event Time</label>
									<input type="time" class="form-control" v-model="form.event_time" placeholder="Event Time">
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-lg-6 col-md-6">
								<div class="form-group">
									<label class="text-gray-500 m-0" for="">Start Date</label>
									<input type="date" class="form-control" rows="3" v-model="form.start_date" placeholder="Start Date">
								</div>
							</div>
							<div class="col-lg-6 col-md-6">
								<div class="form-group">
									<label class="text-gray-500 m-0" for="">End Date</label>
									<input type="date" class="form-control" rows="3" v-model="form.end_date" placeholder="End Date">
								</div>
							</div>
						</div>
						<div class="row mt-4"> 
							<div class="col-lg-12 col-md-12">
								<div class="flex justify-center space-x-2">
									<button @click="onSave()" class="btn btn-primary mr-2 w-44">Submit</button>
									<!-- <a href="" class="btn btn-primary mr-2 w-44">Save</a> -->
								</div>
							</div>
						</div>
					</div> 
				</div>
			</div>
		</Transition>
		<!-- EDIT EVENT MODAL -->
        <Transition
            enter-active-class="transition ease-out duration-200"
            enter-from-class="opacity-0 scale-95"
            enter-to-class="opacity-100 scale-100"
            leave-active-class="transition ease-in duration-75"
            leave-from-class="opacity-100 scale-100"
            leave-to-class="opacity-0 scale-95"
        >
			<div class="modal pt-4 px-3" :class="{ show:modalEdit }">
				<div @click="closeModal" class="w-full h-full fixed"></div>
				<div class="modal__content w-6/12">
					<div class="row mb-3">
						<div class="col-lg-12 flex justify-between">
							<span class="font-bold ">Update Event</span>
							<a href="#" class="text-gray-600" @click="closeModal">
								<XMarkIcon fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4"></XMarkIcon>
							</a>
						</div>
					</div>
					<hr class="mt-0">
					<div class="modal_s_items ">
						<div class="row">
							<div class="col-lg-12 col-md-12">
								<label class="text-gray-500 m-0" for="">Event Color</label>
								<select name="color_display" id="color_display" class="form-control" v-model="events.event_color" :style="'background-color:'+events.event_color">
									<option value="">--Select Event Color--</option>
									<option :value="color_display[index]" v-for="(col,index) in color_display" :key="color_display[index]" :style="{background: color_display[index]}">{{ color_display[index] }}</option>
								</select>
							</div>
						</div>
						<div class="row">
							<div class="col-lg-6 col-md-6">
								<div class="form-group">
									<label class="text-gray-500 m-0" for="">Event Name</label>
									<textarea placeholder="Event Name" class="form-control" rows="3" v-model="events.event_name"></textarea>
								</div>
							</div>
                            <div class="col-lg-6 col-md-6">
								<div class="form-group">
									<label class="text-gray-500 m-0" >Event Description</label>
									<textarea placeholder="Event Description" class="form-control" rows="3" v-model="events.event_description"></textarea>
								</div>
							</div>
						</div>
                        <div class="row">
							<div class="col-lg-6 col-md-6">
								<div class="form-group">
									<label class="text-gray-500 m-0" >Event Address</label>
									<textarea placeholder="Event Address" class="form-control" rows="3" v-model="events.event_address"></textarea>
								</div>
							</div>
                            <div class="col-lg-6 col-md-6">
								<div class="form-group">
									<label class="text-gray-500 m-0" >Event Time</label>
									<input type="time" class="form-control" rows="3" v-model="events.event_time" placeholder="Event Time">
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-lg-6 col-md-6">
								<div class="form-group">
									<label class="text-gray-500 m-0" for="">Start Date</label>
									<input type="date" class="form-control" rows="3" v-model="events.start_date" placeholder="Start Date">
								</div>
							</div>
							<div class="col-lg-6 col-md-6">
								<div class="form-group">
									<label class="text-gray-500 m-0" for="">End Date</label>
									<input type="date" class="form-control" rows="3" v-model="events.end_date" placeholder="End Date">
								</div>
							</div>
						</div>
						<div class="row mt-4"> 
							<div class="col-lg-12 col-md-12">
								<div class="flex justify-center space-x-2">
									<button @click="onEdit(events.id)" class="btn btn-primary mr-2 w-44">Update</button>
								</div>
							</div>
						</div>
					</div> 
				</div>
			</div>
		</Transition>
		<!-- SUCCESS ALERT MODAL -->
		<Transition
            enter-active-class="transition ease-out !duration-1000"
            enter-from-class="opacity-0 scale-95"
            enter-to-class="opacity-100 scale-500"
            leave-active-class="transition ease-in duration-75"
            leave-from-class="opacity-100 scale-500"
            leave-to-class="opacity-0 scale-95"
			v-if="success!=''"
        >
			<div class="modal p-0 !bg-transparent" :class="{ show:successAlert }">
				<div @click="closeAlert" class="w-full h-full fixed backdrop-blur-sm bg-white/30"></div>
				<div class="modal__content !shadow-2xl !rounded-3xl !my-44 w-96 p-0">
					<div class="flex justify-center">
						<div class="!border-green-500 border-8 bg-green-500 !h-32 !w-32 -top-16 absolute rounded-full text-center shadow">
							<div class="p-2 text-white">
								<CheckIcon fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-24 h-24 "></CheckIcon>
							</div>
						</div>
					</div>
					<div class="py-5 rounded-t-3xl"></div>
					<div class="modal_s_items pt-0 !px-8 pb-4">
						<div class="row">
							<div class="col-lg-12 col-md-3">
								<div class="text-center">
									<h2 class="mb-2  font-bold text-green-400">Success!</h2>
									<h5 class="leading-tight">{{ success }}</h5>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</Transition>
		<!-- ERROR ALERT MODAL -->
		<Transition
            enter-active-class="transition ease-out !duration-1000"
            enter-from-class="opacity-0 scale-95"
            enter-to-class="opacity-100 scale-500"
            leave-active-class="transition ease-in duration-75"
            leave-from-class="opacity-100 scale-500"
            leave-to-class="opacity-0 scale-95"
			v-if="error!=''"
        >
			<div class="modal p-0 !bg-transparent" :class="{ show:warningAlert }">
				<div @click="closeAlert" class="w-full h-full fixed backdrop-blur-sm bg-white/30"></div>
				<div class="modal__content !shadow-2xl !rounded-3xl !my-44 w-96 p-0">
					<div class="flex justify-center">
						<div class="!border-red-400 border-8 bg-red-400 !h-32 !w-32 -top-16 absolute rounded-full text-center shadow">
							<div class="p-2 text-white">
								<CheckIcon fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-24 h-24 "></CheckIcon>
							</div>
						</div>
					</div>
					<div class="py-5 rounded-t-3xl"></div>
					<div class="modal_s_items pt-0 !px-8 pb-4">
						<div class="row">
							<div class="col-lg-12 col-md-3">
								<div class="text-center">
									<h2 class="mb-2  font-bold text-red-400">Error!</h2>
									<h5 class="leading-tight">{{ error }}</h5>
									<!-- <h5 class="leading-tight" v-for="er in error">{{ er }}</h5> -->
								</div>
							</div>
						</div>
						<br>
						<div class="row mt-4"> 
							<div class="col-lg-12 col-md-12">
								<div class="flex justify-center space-x-2">
									<button @click="closeAlert" class="btn !text-white !bg-red-400 btn-sm !rounded-full w-full">Close</button>
								</div>
							</div>
						</div>
					</div> 
				</div>
			</div>
		</Transition>
	</navigation>
</template>