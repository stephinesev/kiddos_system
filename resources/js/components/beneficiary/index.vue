<script setup>
	import navigation from '@/layouts/navigation.vue';
	import{ Bars3Icon, PencilIcon, MagnifyingGlassIcon, TrashIcon, EyeIcon, XMarkIcon, CheckIcon} from '@heroicons/vue/24/solid'
	import{ArrowUpOnSquareIcon} from '@heroicons/vue/24/outline'
    import { reactive, ref, onMounted} from "vue"
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
	let beneficiary=ref([]);
	let beneficiaryall=ref([]);
	let error = ref('')
	// let error = ref([])
	let success = ref('')	
	const warningAlert = ref(false)
	const successAlert = ref(false)
	const hideAlert = ref(true)
	//Fetcher of Data
	onMounted(async () => {
		beneficiaryForm()
		allBeneficiary()
		getBarangay()
	})
	//Fetching Data From Barangay Table for display
	const getBarangay = async () => {
		let response = await axios.get("/api/get_barangay");
		barangay.value = response.data.barangay;
	}
	//Declaration of input values
	const beneficiaryForm = async () => {
		let response = await axios.get("/api/create_beneficiary");
		form.value = response.data;
	}
	//Fetching Data From Users Table for display
	const allBeneficiary = async () => {
		let response = await axios.get("/api/get_beneficiary");
		beneficiaryall.value = response.data.beneficiaryall;
	}
	//Insert Function
	const onSave = () => {
		const formData=new FormData()
		formData.append('username',form.value.username)
		formData.append('name',form.value.name)
		formData.append('email',form.value.email)
		formData.append('password',form.value.password)
		formData.append('birth_date',form.value.birth_date)
		formData.append('gender',form.value.gender)
		formData.append('address',form.value.address)
		// formData.append('role',form.value.role)
		formData.append('weight',form.value.weight)
		formData.append('height',form.value.height)
		formData.append('bmi',form.value.bmi)
		formData.append('status',form.value.status)
		formData.append('barangay',form.value.barangay)
		formData.append('school_name',form.value.school_name)
		formData.append('grade_level',form.value.grade_level)
		formData.append('student_id',form.value.student_id)
		formData.append('guardian_name',form.value.guardian_name)
		formData.append('guardian_contact_no',form.value.guardian_contact_no)
		formData.append('guardian_relationship',form.value.guardian_relationship)
		formData.append('nutritional_status',form.value.nutritional_status)
		axios.post("/api/add_beneficiary",formData).then(function () {
			success.value='You have successfully added new beneficiary!'
			form.value=[]
			error.value=''
			// error.value=[]
			form.value.email='';
			successAlert.value = !successAlert.value
			setTimeout(() => {
				// window.location.reload()
				allBeneficiary()
				closeAlert()
				closeModal()
			}, 2000);
		}).catch(function(err){
			warningAlert.value = !warningAlert.value
			error.value='Fields cannot be empty!'
			// if (err.response.data.errors.username) {
			// 	error.value.push(err.response.data.errors.username[0])
			// }
			// if (err.response.data.errors.name) {
			// 	error.value.push(err.response.data.errors.name[0])
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
			// if (err.response.data.errors.role) {
			// 	error.value.push(err.response.data.errors.role[0])
			// }
			// if (err.response.data.errors.status) {
			// 	error.value.push(err.response.data.errors.status[0])
			// }
			// if (err.response.data.errors.barangay) {
			// 	error.value.push(err.response.data.errors.barangay[0])
			// }
		});
	}
	//Update function
	const onEdit = (id) => {
		const formData=new FormData()
		formData.append('username',beneficiary.value.username)
		formData.append('name',beneficiary.value.name)
		formData.append('email',beneficiary.value.email)
		// formData.append('password',beneficiary.value.password)
		formData.append('birth_date',beneficiary.value.birth_date)
		formData.append('gender',beneficiary.value.gender)
		formData.append('address',beneficiary.value.address)
		// formData.append('role',beneficiary.value.role)
		// formData.append('weight',beneficiary.value.weight)
		// formData.append('height',beneficiary.value.height)
		// formData.append('bmi',beneficiary.value.bmi)
		formData.append('status',beneficiary.value.status)
		formData.append('barangay',beneficiary.value.barangay)
		formData.append('school_name',beneficiary.value.school_name)
		formData.append('grade_level',beneficiary.value.grade_level)
		formData.append('student_id',beneficiary.value.student_id)
		formData.append('guardian_name',beneficiary.value.guardian_name)
		formData.append('guardian_contact_no',beneficiary.value.guardian_contact_no)
		formData.append('guardian_relationship',beneficiary.value.guardian_relationship)
		// formData.append('nutritional_status',beneficiary.value.nutritional_status)
		axios.post(`/api/update_beneficiary/`+id, formData).then(function () {
			success.value='You have successfully updated beneficiary!'
			beneficiary.value=[]
			error.value=''
			beneficiary.value.email='';
			successAlert.value = !successAlert.value
			setTimeout(() => {
				// window.location.reload()
				allBeneficiary()
				closeAlert()
				closeModal()
			}, 2000);
		}).catch(function(err){
			// error.value=[]
			warningAlert.value = !warningAlert.value
			error.value='Fields cannot be empty!'
			// if (err.response.data.errors.username) {
			// 	error.value.push(err.response.data.errors.username[0])
			// }
			// if (err.response.data.errors.name) {
			// 	error.value.push(err.response.data.errors.name[0])
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
			// if (err.response.data.errors.role) {
			// 	error.value.push(err.response.data.errors.role[0])
			// }
			// if (err.response.data.errors.status) {
			// 	error.value.push(err.response.data.errors.status[0])
			// }
			// if (err.response.data.errors.barangay) {
			// 	error.value.push(err.response.data.errors.barangay[0])
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
				title:'Beneficiary',
				extend: 'copy',
				exportOptions: {
					columns: [0,1,2, 3, 4, 5, 6, 7],
					orthogonal: null
				}
			},
			{
				title:'Beneficiary',
				extend: 'excel',
				exportOptions: {
                    columns: [0,1,2, 3, 4, 5, 6, 7],
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
				title:'Beneficiary',
				extend: 'print',
				exportOptions: {
					columns: [0,1,2, 3, 4, 5, 6, 7],
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
		let response =  await axios.get(`/api/edit_beneficiary/`+id);
		beneficiary.value=response.data.beneficiary
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
	const deleteBeneficiary = (id) => {
		var confirmation = confirm("Do you want to delete this beneficiary?");
		if (confirmation == true) {
			axios.get(`/api/delete_beneficiary/`+id).then(function () {
				success.value='Successfully deleted beneficiary!'
				error.value=[]
				allBeneficiary()
				successAlert.value = !successAlert.value
				setTimeout(() => {
					// window.location.reload()
					allBeneficiary()
					closeAlert()
					closeModal()
				}, 2000);
			}).catch(function(err){
				success.value=''
				error.value.push('Error! Try again.')
			});
		}
	}

	const showTransaction = (id) => {
		router.push('/beneficiary/view/'+id)
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
                        <h3 class="card-title !text-lg m-0 uppercase font-bold text-gray-600">Beneficiary <small>List</small></h3>
                    </span>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb !mb-0 !text-xs px-2 py-1 !bg-transparent">
                            <li class="breadcrumb-item"><a href="/dashboard">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Beneficiary List</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
		<div class="row">
            <div class="col-lg-12 stretch-card">
                <div class="card">
                    <div class="card-body">
						<!-- Add Beneficiart Modal Button -->
                        <div class="flex justify-between  mt-2 mb-0 absolute z-50 ">
                            <button @click="openNew()" class="btn btn-primary mt-2 mt-xl-0 text-white">
                                <span>Add New Beneficiary </span>
                            </button>
                        </div>
						<!-- DATATABLE -->
                        <div class="pt-3">
                            <DataTable :data="beneficiaryall" :options="options" class="display table table-bordered table-hover !border nowrap">
                                <thead>
                                    <tr>
                                        <th class="!text-xs bg-gray-100 uppercase"> Name</th>
                                        <th class="!text-xs bg-gray-100 uppercase"> Gender</th>
                                        <th class="!text-xs bg-gray-100 uppercase"> Email</th>
                                        <!-- <th class="!text-xs bg-gray-100 uppercase"> Role</th> -->
                                        <th class="!text-xs bg-gray-100 uppercase"> Weight</th>
                                        <th class="!text-xs bg-gray-100 uppercase"> Height</th>
                                        <th class="!text-xs bg-gray-100 uppercase"> BMI</th>
                                        <th class="!text-xs bg-gray-100 uppercase"> Status</th>
                                        <th class="!text-xs bg-gray-100 uppercase" width="7%" align="center"> 
                                            <span class="text-center  px-auto">
                                                <Bars3Icon fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="menu-icon w-5 h-5 "></Bars3Icon>
                                            </span>
                                        </th>
                                    </tr>
                                </thead>
                                <template #column-7="props">
									<button @click="showTransaction(props.rowData.id)" class="btn btn-xs btn-success text-white p-1">
                                        <EyeIcon fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="menu-icon w-3 h-3 "></EyeIcon>
                                    </button >
                                    <button @click="openEdit(props.rowData.id)" class="btn btn-xs btn-info text-white p-1">
                                        <PencilIcon fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="menu-icon w-3 h-3 "></PencilIcon>
                                    </button >
									<button @click="deleteBeneficiary(props.rowData.id)" class="btn btn-xs btn-danger text-white p-1">
                                        <TrashIcon fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="menu-icon w-3 h-3 "></TrashIcon>
                                    </button >
                                </template>
                            </DataTable>
                        </div>
                    </div>
                </div>
            </div>
        </div>
		<!-- ADD BENEFICIARY MODAL -->
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
							<span class="font-bold ">Add Beneficiary</span>
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
									<label class="text-gray-500 m-0" for="">Username</label>
									<input type="text" class="form-control" placeholder="Username" v-model="form.username">
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
									<label class="text-gray-500 m-0" for="">Fullname</label>
									<input type="text" class="form-control" placeholder="Fullname" v-model="form.name">
								</div>
							</div>
                            <div class="col-lg-6 col-md-6">
								<div class="form-group">
									<label class="text-gray-500 m-0" >Date of Birth</label>
									<input type="date" class="form-control" placeholder="Date of Birth" v-model="form.birth_date">
								</div>
							</div>
						</div>
                        <div class="row">
                            <div class="col-lg-6 col-md-6">
								<div class="form-group">
									<label class="text-gray-500 m-0" for="">Email</label>
									<input type="email" class="form-control" placeholder="Email" v-model="form.email">
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
									<!-- <input type="text" class="form-control" placeholder="Barangay" v-model="form.barangay"> -->
									<select  class="form-control" v-model="form.barangay">
										<option value="0">--Select Barangay--</option>
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
							<div class="col-lg-6 col-md-6">
								<div class="form-group">
									<label class="text-gray-500 m-0" for="">School Name</label>
									<textarea class="form-control" rows="3" v-model="form.school_name"></textarea>
								</div>
							</div>
                            <div class="col-lg-6 col-md-6">
								<div class="form-group">
									<label class="text-gray-500 m-0" >Grade Level</label>
									<input type="text" class="form-control" placeholder="Grade Level" v-model="form.grade_level">
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-lg-6 col-md-6">
								<div class="form-group">
									<label class="text-gray-500 m-0" for="">Student ID</label>
									<input type="text" class="form-control" placeholder="Student ID" v-model="form.student_id">
								</div>
							</div>
                            <!-- <div class="col-lg-6 col-md-6">
								<div class="form-group">
									<label class="text-gray-500 m-0" >Role</label>
									<select class="form-control" v-model="form.role">
                                        <option value="">--Select Role--</option>
                                        <option value="Admin">Admin</option>
                                        <option value="Beneficiary">Beneficiary</option>
                                    </select>
								</div>
							</div> -->
						</div>
						<div class="row">
							<div class="col-lg-12 col-md-12">
								<div class="form-group">
									<label class="text-gray-500 m-0" for=""><b>Guardian/Parent Information</b></label>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-lg-4 col-md-4">
								<div class="form-group">
									<label class="text-gray-500 m-0" for="">Name</label>
									<input type="text" class="form-control" placeholder="Name" v-model="form.guardian_name">
								</div>
							</div>
                            <div class="col-lg-4 col-md-4">
								<div class="form-group">
									<label class="text-gray-500 m-0" >Contact Number</label>
									<input type="text" class="form-control" placeholder="Contact Number" v-model="form.guardian_contact_no">
								</div>
							</div>
							<div class="col-lg-4 col-md-4">
								<div class="form-group">
									<label class="text-gray-500 m-0" >Relationship to Child</label>
									<input type="text" class="form-control" placeholder="Relationship to Child" v-model="form.guardian_relationship">
								</div>
							</div>
						</div>
                        <div class="row">
							<div class="col-lg-6 col-md-6">
								<div class="form-group">
									<label class="text-gray-500 m-0" for="">Weight</label>
									<input type="text" class="form-control" placeholder="Weight" v-model="form.weight">
								</div>
							</div>
                            <div class="col-lg-6 col-md-6">
								<div class="form-group">
									<label class="text-gray-500 m-0" >Height</label>
									<input type="text" class="form-control" placeholder="Height" v-model="form.height">
								</div>
							</div>
						</div>
                        <div class="row">
							<div class="col-lg-6 col-md-6">
								<div class="form-group">
									<label class="text-gray-500 m-0" for="">Nutritional Status</label>
									<select class="form-control text-black-500" v-model="form.nutritional_status">
                                        <option value="">--Select Nutritional Status--</option>
                                        <option value="Underweight">Underweight</option>
                                        <option value="Normal weight">Normal weight</option>
                                        <option value="Overweight">Overweight</option>
                                        <option value="Obesity">Obesity</option>
                                    </select>
								</div>
							</div>
                            <div class="col-lg-6 col-md-6">
								<div class="form-group">
									<label class="text-gray-500 m-0" >BMI</label>
									<input type="text" class="form-control" placeholder="BMI" v-model="form.bmi">
								</div>
							</div>
						</div>
						<div class="row">
                            <div class="col-lg-12 col-md-12">
								<div class="form-group">
									<label class="text-gray-500 m-0" >Status</label>
									<select class="form-control" v-model="form.status">
                                        <option value="">--Select Status--</option>
                                        <option value="Active">Active</option>
                                        <option value="Inactive">Inactive</option>
                                    </select>
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
		<!-- EDIT BENEFICIARY MODAL -->
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
							<span class="font-bold ">Update Beneficiary</span>
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
									<label class="text-gray-500 m-0" for="">Username</label>
									<input type="text" class="form-control" placeholder="Username" v-model="beneficiary.username">
								</div>
							</div>
                            <div class="col-lg-6 col-md-6">
								<div class="form-group">
									<label class="text-gray-500 m-0" >Password</label>
									<input type="password" class="form-control" placeholder="Password" value="*******" readonly disabled>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-lg-6 col-md-6">
								<div class="form-group">
									<label class="text-gray-500 m-0" for="">Fullname</label>
									<input type="text" class="form-control" placeholder="Fullname" v-model="beneficiary.name">
								</div>
							</div>
                            <div class="col-lg-6 col-md-6">
								<div class="form-group">
									<label class="text-gray-500 m-0" >Date of Birth</label>
									<input type="date" class="form-control" placeholder="Date of Birth" v-model="beneficiary.birth_date">
								</div>
							</div>
						</div>
                        <div class="row">
                            <div class="col-lg-6 col-md-6">
								<div class="form-group">
									<label class="text-gray-500 m-0" for="">Email</label>
									<input type="email" class="form-control" placeholder="Email" v-model="beneficiary.email">
								</div>
							</div>
                            <div class="col-lg-6 col-md-6">
								<div class="form-group">
									<label class="text-gray-500 m-0" >Gender</label>
									<select class="form-control" v-model="beneficiary.gender">
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
									<!-- <input type="text" class="form-control" placeholder="Barangay" v-model="beneficiary.barangay"> -->
									<select  class="form-control" v-model="beneficiary.barangay">
										<option value="0">--Select Barangay--</option>
										<option :value="b.id" v-for="b in barangay" :key="b.id">{{ b.barangay_name }} - {{ b.city}}</option>
									</select>
								</div>
							</div>
                            <div class="col-lg-6 col-md-6">
								<div class="form-group">
									<label class="text-gray-500 m-0" for="">Address</label>
									<textarea class="form-control" rows="3" v-model="beneficiary.address"></textarea>
								</div>
							</div>
						</div>
                        <div class="row">
							<div class="col-lg-6 col-md-6">
								<div class="form-group">
									<label class="text-gray-500 m-0" for="">School Name</label>
									<textarea class="form-control" rows="3" v-model="beneficiary.school_name"></textarea>
								</div>
							</div>
                            <div class="col-lg-6 col-md-6">
								<div class="form-group">
									<label class="text-gray-500 m-0" >Grade Level</label>
									<input type="text" class="form-control" placeholder="Grade Level" v-model="beneficiary.grade_level">
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-lg-6 col-md-6">
								<div class="form-group">
									<label class="text-gray-500 m-0" for="">Student ID</label>
									<input type="text" class="form-control" placeholder="Student ID" v-model="beneficiary.student_id">
								</div>
							</div>
                            <!-- <div class="col-lg-6 col-md-6">
								<div class="form-group">
									<label class="text-gray-500 m-0" >Role</label>
									<select class="form-control" v-model="beneficiary.role">
                                        <option value="">--Select Role--</option>
                                        <option value="Admin">Admin</option>
                                        <option value="Beneficiary">Beneficiary</option>
                                    </select>
								</div>
							</div> -->
						</div>
						<div class="row">
							<div class="col-lg-12 col-md-12">
								<div class="form-group">
									<label class="text-gray-500 m-0" for=""><b>Guardian/Parent Information</b></label>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-lg-4 col-md-4">
								<div class="form-group">
									<label class="text-gray-500 m-0" for="">Name</label>
									<input type="text" class="form-control" placeholder="Name" v-model="beneficiary.guardian_name">
								</div>
							</div>
                            <div class="col-lg-4 col-md-4">
								<div class="form-group">
									<label class="text-gray-500 m-0" >Contact Number</label>
									<input type="text" class="form-control" placeholder="Contact Number" v-model="beneficiary.guardian_contact_no">
								</div>
							</div>
							<div class="col-lg-4 col-md-4">
								<div class="form-group">
									<label class="text-gray-500 m-0" >Relationship to Child</label>
									<input type="text" class="form-control" placeholder="Relationship to Child" v-model="beneficiary.guardian_relationship">
								</div>
							</div>
						</div>
                        <!-- <div class="row">
							<div class="col-lg-6 col-md-6">
								<div class="form-group">
									<label class="text-gray-500 m-0" for="">Weight</label>
									<input type="text" class="form-control" placeholder="Weight" v-model="beneficiary.weight">
								</div>
							</div>
                            <div class="col-lg-6 col-md-6">
								<div class="form-group">
									<label class="text-gray-500 m-0" >Height</label>
									<input type="text" class="form-control" placeholder="Height" v-model="beneficiary.height">
								</div>
							</div>
						</div>
                        <div class="row">
							<div class="col-lg-6 col-md-6">
								<div class="form-group">
									<label class="text-gray-500 m-0" for="">Nutritional Status</label>
									<select class="form-control" v-model="beneficiary.nutritional_status">
                                        <option value="">--Select Nutritional Status--</option>
                                        <option value="Underweight">Underweight</option>
                                        <option value="Normal weight">Normal weight</option>
                                        <option value="Overweight">Overweight</option>
                                        <option value="Obesity">Obesity</option>
                                    </select>
								</div>
							</div>
                            <div class="col-lg-6 col-md-6">
								<div class="form-group">
									<label class="text-gray-500 m-0" >BMI</label>
									<input type="text" class="form-control" placeholder="BMI" v-model="beneficiary.bmi">
								</div>
							</div>
						</div> -->
						<div class="row">
                            <div class="col-lg-12 col-md-12">
								<div class="form-group">
									<label class="text-gray-500 m-0" >Status</label>
									<select class="form-control" v-model="beneficiary.status">
                                        <option value="">--Select Status--</option>
                                        <option value="Active">Active</option>
                                        <option value="Inactive">Inactive</option>
                                    </select>
								</div>
							</div>
						</div>
						<div class="row mt-4"> 
							<div class="col-lg-12 col-md-12">
								<div class="flex justify-center space-x-2">
									<button @click="onEdit(beneficiary.id)" class="btn btn-primary mr-2 w-44">Update</button>
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
<style>
    @import 'datatables.net-dt';
    @import 'datatables.net-buttons-dt';
    @import 'datatables.net-select-dt';
</style>