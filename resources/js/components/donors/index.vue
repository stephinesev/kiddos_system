<script setup>
	import navigation from '@/layouts/navigation.vue';
	import{ Bars3Icon, PencilIcon, XMarkIcon, TrashIcon} from '@heroicons/vue/24/solid'
	import{ArrowUpOnSquareIcon} from '@heroicons/vue/24/outline'
    import { reactive, ref, onMounted } from "vue"
    import { useRouter } from "vue-router"
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
	let form=ref([]);
	let barangay=ref([]);
	let donors=ref([]);
	let donorsall=ref([]);
	// let error = ref([])
	let error = ref("")
	let success = ref('')	
	const warningAlert = ref(false)
	const successAlert = ref(false)
	const hideAlert = ref(true)
	//Fetcher of Data
	onMounted(async () => {
		donorForm()
		allDonor()
		getBarangay()
	})
	//Fetching Data From Barangay Table for display
	const getBarangay = async () => {
		let response = await axios.get("/api/get_barangay");
		barangay.value = response.data.barangay;
	}
	//Declaration of input values
	const donorForm = async () => {
		let response = await axios.get("/api/create_donor");
		form.value = response.data;
	}
	//Fetching Data From Donors Table for display
	const allDonor = async () => {
		let response = await axios.get("/api/get_donor");
		donorsall.value = response.data.donorall;
	}

	//Insert Function
	const onSave = () => {
		const formData=new FormData()
		formData.append('fullname',form.value.fullname)
		formData.append('email',form.value.email)
		formData.append('password',form.value.password)
		formData.append('birth_date',form.value.birth_date)
		formData.append('gender',form.value.gender)
		formData.append('address',form.value.address)
		formData.append('barangay',form.value.barangay)
		formData.append('email',form.value.email)
		formData.append('contact_no',form.value.contact_no)
		axios.post("/api/add_donor",formData).then(function () {
			success.value='You have successfully added new donor!'
			form.value=[]
			// error.value=[]
			error.value=''
			form.value.email='';
			successAlert.value = !successAlert.value
			setTimeout(() => {
				// window.location.reload()
				allDonor()
				closeAlert()
				closeModal()
			}, 2000);
		}).catch(function(err){
			// error.value=[]
			error.value='Fields cannot be empty!'
			warningAlert.value = !warningAlert.value
			// if (err.response.data.errors.name) {
			// 	error.value.push(err.response.data.errors.fullname[0])
			// }
			// if (err.response.data.errors.password) {
			// 	error.value.push(err.response.data.errors.password[0])
			// }
			// if (err.response.data.errors.email) {
			// 	error.value.push(err.response.data.errors.email[0])
			// }
			// if (err.response.data.errors.birth_date) {
			// 	error.value.push(err.response.data.errors.birth_date[0])
			// }
			// if (err.response.data.errors.gender) {
			// 	error.value.push(err.response.data.errors.gender[0])
			// }
			// if (err.response.data.errors.address) {
			// 	error.value.push(err.response.data.errors.address[0])
			// } 
			// if (err.response.data.errors.contact_no) {
			// 	error.value.push(err.response.data.errors.contact_no[0])
			// }
		});
	}

	//Update function
	const onEdit = (id) => {
		const formData=new FormData()
		formData.append('fullname',donors.value.fullname)
		formData.append('email',donors.value.email)
		formData.append('password',donors.value.password)
		formData.append('birth_date',donors.value.birth_date)
		formData.append('gender',donors.value.gender)
		formData.append('address',donors.value.address)
		formData.append('barangay',donors.value.barangay)
		formData.append('email',donors.value.email)
		formData.append('contact_no',donors.value.contact_no)
		axios.post(`/api/update_donor/`+id, formData).then(function () {
			success.value='You have successfully updated donor!'
			donors.value=[]
			error.value=''
			donors.value.email='';
			successAlert.value = !successAlert.value
			setTimeout(() => {
				// window.location.reload()
				allDonor()
				closeAlert()
				closeModal()
			}, 2000);
		}).catch(function(err){
			warningAlert.value = !warningAlert.value
			error.value='Fields cannot be empty!'
			// if (err.response.data.errors.name) {
			// 	error.value.push(err.response.data.errors.fullname[0])
			// }
			// if (err.response.data.errors.password) {
			// 	error.value.push(err.response.data.errors.password[0])
			// }
			// if (err.response.data.errors.email) {
			// 	error.value.push(err.response.data.errors.email[0])
			// }
			// if (err.response.data.errors.birth_date) {
			// 	error.value.push(err.response.data.errors.birth_date[0])
			// }
			// if (err.response.data.errors.gender) {
			// 	error.value.push(err.response.data.errors.gender[0])
			// }
			// if (err.response.data.errors.address) {
			// 	error.value.push(err.response.data.errors.address[0])
			// } 
			// if (err.response.data.errors.contact_no) {
			// 	error.value.push(err.response.data.errors.contact_no[0])
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
				title:'Donors',
				extend: 'copy',
				exportOptions: {
					columns: [ 0, 1, 2, 3, 4, 5, 6, 7 ],
					orthogonal: null
				}
			},
			{
				title:'Donors',
				extend: 'excel',
				exportOptions: {
                    columns: [ 0, 1, 2, 3, 4, 5, 6, 7 ],
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
				title:'Donors',
				extend: 'print',
				exportOptions: {
					columns: [ 0, 1, 2, 3, 4, 5, 6, 7],
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
		let response =  await axios.get(`/api/edit_donor/`+id);
		donors.value=response.data.donor
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
	const deleteDonor = (id) => {
		var confirmation = confirm("Do you want to delete this donor?");
		if (confirmation == true) {
			axios.get(`/api/delete_donor/`+id).then(function () {
				success.value='Successfully deleted donor!'
				error.value=[]
				allDonor()
				successAlert.value = !successAlert.value
				setTimeout(() => {
					// window.location.reload()
					allDonor()
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
                        <h3 class="card-title !text-lg m-0 uppercase font-bold text-gray-600">Donors <small>List</small></h3>
                    </span>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb !mb-0 !text-xs px-2 py-1 !bg-transparent">
                            <li class="breadcrumb-item"><a href="/dashboard">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Donors List</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
		<div class="row">
            <div class="col-lg-12 stretch-card">
                <div class="card">
                    <div class="card-body">
						<!-- Add Donors Modal Button -->
                        <div class="flex justify-between  mt-2 mb-0 absolute z-50 ">
                            <button @click="openNew()" class="btn btn-primary mt-2 mt-xl-0 text-white">
                                <span>Add New Donor </span>
                            </button>
                        </div>
						<!-- DATATABLE -->
                        <div class="pt-3">
                            <DataTable :data="donorsall" :options="options" class="display table table-bordered table-hover !border nowrap">
                                <thead>
                                    <tr>
                                        <th class="!text-xs bg-gray-100 uppercase"> Registered Date</th>
                                        <th class="!text-xs bg-gray-100 uppercase"> Fullname</th>
                                        <th class="!text-xs bg-gray-100 uppercase"> Date of Birth</th>
                                        <th class="!text-xs bg-gray-100 uppercase"> Gender</th>
                                        <th class="!text-xs bg-gray-100 uppercase"> Barangay</th>
                                        <th class="!text-xs bg-gray-100 uppercase"> Address</th>
                                        <th class="!text-xs bg-gray-100 uppercase"> Phone Number</th>
                                        <th class="!text-xs bg-gray-100 uppercase"> Email Address</th>
                                        <th class="!text-xs bg-gray-100 uppercase" width="1%" align="center"> 
                                            <span class="text-center  px-auto">
                                                <Bars3Icon fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="menu-icon w-5 h-5 "></Bars3Icon>
                                            </span>
                                        </th>
                                    </tr>
                                </thead>
                                <template #column-8="props" align="center">
                                    <button @click="openEdit(props.rowData.id)" class="btn btn-xs btn-info text-white p-1">
                                        <PencilIcon fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="menu-icon w-3 h-3 "></PencilIcon>
                                    </button >
									<button @click="deleteDonor(props.rowData.id)" class="btn btn-xs btn-danger text-white p-1">
                                        <TrashIcon fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="menu-icon w-3 h-3 "></TrashIcon>
                                    </button >
                                </template>
                            </DataTable>
                           
                        </div>
                    </div>
                </div>
            </div>
        </div>
		<!-- ADD DONOR MODAL -->
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
							<span class="font-bold ">Add Donor</span>
							<a href="#" class="text-gray-600" @click="closeModal">
								<XMarkIcon fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4"></XMarkIcon>
							</a>
						</div>
					</div>
					<hr class="mt-0">
					<div class="modal_s_items ">
                        <div class="row">
							<div class="col-lg-6 col-md-6">
								<div class="form-group">
									<label class="text-gray-500 m-0" for="">Fullname</label>
									<input type="text" class="form-control" placeholder="Fullname" v-model="form.fullname">
								</div>
							</div>
                            <div class="col-lg-6 col-md-6">
								<div class="form-group">
									<label class="text-gray-500 m-0" >Password</label>
									<input type="password" class="form-control" placeholder="Password" v-model="form.password">
								</div>
							</div>
						</div>
                        <div class="row">
							<div class="col-lg-6 col-md-6">
								<div class="form-group">
									<label class="text-gray-500 m-0" >Date of Birth</label>
									<input type="date" class="form-control" placeholder="Date of Birth" v-model="form.birth_date">
								</div>
							</div>
                            <div class="col-lg-6 col-md-6">
								<div class="form-group">
									<label class="text-gray-500 m-0" >Gender</label>
									<select class="form-control" v-model="form.gender">
                                        <option value="">--Select Gender--</option>
                                        <option value="Male">Male</option>
                                        <option value="Female">Female</option>
                                    </select>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-lg-6 col-md-6">
								<div class="form-group">
									<label class="text-gray-500 m-0" for="">Barangay</label>
									<select  class="form-control" v-model="form.barangay">
										<option value="">--Select Barangay--</option>
										<option :value="b.id" v-for="b in barangay" :key="b.id">{{ b.barangay_name }} - {{ b.city}}</option>
									</select>
								</div>
							</div>
							<div class="col-lg-6 col-md-6">
								<div class="form-group">
									<label class="text-gray-500 m-0" for="">Address</label>
									<textarea class="form-control" rows="3" v-model="form.address"></textarea>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-lg-12 col-md-12">
								<div class="form-group">
									<label class="text-black-500 m-0" for=""><b>Contact Information</b></label>
								</div>
							</div>
						</div>
                        <div class="row">
							<div class="col-lg-6 col-md-6">
								<div class="form-group">
									<label class="text-gray-500 m-0" for="">Phone Number</label>
									<input type="text" class="form-control" rows="3" v-model="form.contact_no" placeholder="Phone Number">
								</div>
							</div>
							<div class="col-lg-6 col-md-6">
								<div class="form-group">
									<label class="text-gray-500 m-0" for="">Email</label>
									<input type="email" class="form-control" placeholder="Email" v-model="form.email">
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
		<!-- EDIT DONOR MODAL -->
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
							<span class="font-bold ">Update Donor</span>
							<a href="#" class="text-gray-600" @click="closeModal">
								<XMarkIcon fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4"></XMarkIcon>
							</a>
						</div>
					</div>
					<hr class="mt-0">
					<div class="modal_s_items ">
						<div class="row">
							<div class="col-lg-6 col-md-6">
								<div class="form-group">
									<label class="text-gray-500 m-0" for="">Fullname</label>
									<input type="text" class="form-control" placeholder="Fullname" v-model="donors.fullname">
								</div>
							</div>
                            <div class="col-lg-6 col-md-6">
								<div class="form-group">
									<label class="text-gray-500 m-0" >Password</label>
									<input type="password" class="form-control" placeholder="Password" value="*****" readonly disabled>
								</div>
							</div>
						</div>
                        <div class="row">
							<div class="col-lg-6 col-md-6">
								<div class="form-group">
									<label class="text-gray-500 m-0" >Date of Birth</label>
									<input type="date" class="form-control" placeholder="Date of Birth" v-model="donors.birth_date">
								</div>
							</div>
                            <div class="col-lg-6 col-md-6">
								<div class="form-group">
									<label class="text-gray-500 m-0" >Gender</label>
									<select class="form-control" v-model="donors.gender">
                                        <option value="">--Select Gender--</option>
                                        <option value="Male">Male</option>
                                        <option value="Female">Female</option>
                                    </select>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-lg-6 col-md-6">
								<div class="form-group">
									<label class="text-gray-500 m-0" for="">Barangay</label>
									<select  class="form-control" v-model="donors.barangay">
										<option value="">--Select Barangay--</option>
										<option :value="b.id" v-for="b in barangay" :key="b.id">{{ b.barangay_name }} - {{ b.city}}</option>
									</select>
								</div>
							</div>
							<div class="col-lg-6 col-md-6">
								<div class="form-group">
									<label class="text-gray-500 m-0" for="">Address</label>
									<textarea class="form-control" rows="3" v-model="donors.address"></textarea>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-lg-12 col-md-12">
								<div class="form-group">
									<label class="text-black-500 m-0" for=""><b>Contact Information</b></label>
								</div>
							</div>
						</div>
                        <div class="row">
							<div class="col-lg-6 col-md-6">
								<div class="form-group">
									<label class="text-gray-500 m-0" for="">Phone Number</label>
									<input type="text" class="form-control" rows="3" v-model="donors.contact_no" placeholder="Phone Number">
								</div>
							</div>
							<div class="col-lg-6 col-md-6">
								<div class="form-group">
									<label class="text-gray-500 m-0" for="">Email</label>
									<input type="email" class="form-control" placeholder="Email" v-model="donors.email">
								</div>
							</div>
						</div>
						<div class="row mt-4"> 
							<div class="col-lg-12 col-md-12">
								<div class="flex justify-center space-x-2">
									<button @click="onEdit(donors.id)" class="btn btn-primary mr-2 w-44">Update</button>
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