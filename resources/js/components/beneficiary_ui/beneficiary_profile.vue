<script setup>
	import navigation from '@/layouts/navigation_bene.vue';
	import{ Bars3Icon, PencilIcon, MagnifyingGlassIcon, TrashIcon, EyeIcon, CheckIcon, PlusIcon, XMarkIcon} from '@heroicons/vue/24/solid'
	import{ArrowUpOnSquareIcon} from '@heroicons/vue/24/outline'
    import { reactive, ref, onMounted} from "vue"
    import { useRouter } from "vue-router"
    const menu =  ref()
    const form =  ref([])
    const credentials =  ref([])
    let error = ref('')
	let success = ref('')	
	const warningAlert = ref(false)
	const successAlert = ref(false)
	const hideAlert = ref(true)
    const props = defineProps({
        id:{
            type:String,
            default:''
        }
    })
    //Fetcher of Data
	onMounted(async () => {
		getCredentials()
        beneficiaryForm()
	})
    const closeAlert = () => {
		warningAlert.value = !hideAlert.value
		successAlert.value= !hideAlert.value
	}
	 //Get fullname and donors ID
     const getCredentials = async () => {
		const response = await fetch(`/api/dashboard`);
		credentials.value = await response.json();
        beneficiaryForm(credentials.value.user_id)
	}
    //Declaration of input values
	const beneficiaryForm = async (id) => {
		let response = await axios.get(`/api/edit_beneficiary/`+id);
		form.value = response.data.beneficiary;
	}

    //Update Beneficiary Data
    const onEdit = (id) => {
		const formData=new FormData()
		formData.append('username',form.value.username)
		formData.append('name',form.value.name)
		formData.append('email',form.value.email)
		formData.append('birth_date',form.value.birth_date)
		formData.append('gender',form.value.gender)
		formData.append('address',form.value.address)
		formData.append('status',form.value.status)
		formData.append('barangay',form.value.barangay)
		formData.append('school_name',form.value.school_name)
		formData.append('grade_level',form.value.grade_level)
		formData.append('student_id',form.value.student_id)
		formData.append('guardian_name',form.value.guardian_name)
		formData.append('guardian_contact_no',form.value.guardian_contact_no)
		formData.append('guardian_relationship',form.value.guardian_relationship)
		axios.post(`/api/update_beneficiary/`+id, formData).then(function () {
			success.value='You have successfully updated beneficiary!'
			form.value=[]
			error.value=''
			form.value.email='';
			successAlert.value = !successAlert.value
			setTimeout(() => {
				beneficiaryForm(credentials.value.user_id)
				closeAlert()
			}, 2000);
		}).catch(function(err){
			warningAlert.value = !warningAlert.value
			error.value='Fields cannot be empty!'
		});
	}
</script>
<template>
	<navigation>
        <div class="row">
            <div class="col-lg-12">
                <div class="flex justify-between mb-3 px-2">
                    <span class="">
                        <h3 class="card-title !text-lg m-0 uppercase font-bold text-gray-600">Beneficiary's Profile<small></small></h3>
                    </span>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb !mb-0 !text-xs px-2 py-1 !bg-transparent">
                            <li class="breadcrumb-item"><a href="/donor_dashboard">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Profile</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
        <div id="change_picture" v-if="menu === 'change_picture'">
            <div class="row">
                <div class="col-lg-12">
                    <div class="flex justify-start space-x-1 px-4 ">
                        <button class="btn text-white !bg-blue-300 btn-xs !text-xs p-1 px-3 hover:!bg-blue-500 !rounded-b-none"  v-on:click="menu = ''">Personal Info</button>
                        <!-- <button class="btn text-white !bg-blue-500 btn-xs !text-xs p-1 px-3 !rounded-b-none"  v-on:click="menu = 'change_picture'">Change Picture</button> -->
                        <!-- <button class="btn text-white !bg-blue-300 btn-xs !text-xs p-1 px-3 hover:!bg-blue-500 !rounded-b-none"  v-on:click="menu = 'change_password'">Change Password</button> -->
                    </div>
                    <div class="card !border !border-blue-500">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-2">
                                    <img src="../../../images/default.jpg" alt="QR" class="w-40 h-40 bg-gray-100 border">
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <div class="flex justify-start space-x-1">
                                            <input type="file" class="form-control !text-sm" placeholder="Middle Name">
                                            <button class="btn btn-xs btn-danger ">
                                                <XMarkIcon fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="menu-icon w-5 h-5 "></XMarkIcon>
                                            </button>
                                        </div>
                                        
                                        <label for="" class="mb-0 italic text-blue-400">File_Name.png</label>
                                    </div> 
                                </div>
                            </div>
                            <hr class="border-dashed">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="flex justify-center space-x-2">
                                        <button class="btn btn-sm btn-secondary">Cancel</button>
                                        <button class="btn btn-sm btn-success">Save Changes</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div id="change_password" v-else-if="menu === 'change_password'">
            <div class="row">
                <div class="col-lg-12">
                    <div class="flex justify-start space-x-1 px-4 ">
                        <button class="btn text-white !bg-blue-300 btn-xs !text-xs p-1 px-3 hover:!bg-blue-500 !rounded-b-none"  v-on:click="menu = ''">Personal Info </button>
                        <!-- <button class="btn text-white !bg-blue-300 btn-xs !text-xs p-1 px-3 hover:!bg-blue-500 !rounded-b-none"  v-on:click="menu = 'change_picture'">Change Picture</button> -->
                        <!-- <button class="btn text-white !bg-blue-500 btn-xs !text-xs p-1 px-3 !rounded-b-none"  v-on:click="menu = 'change_password'">Change Password</button> -->
                    </div>
                    <div class="card !border !border-blue-500">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="" class="mb-0">New Password</label>
                                        <input type="password" class="form-control !text-sm" placeholder="***">
                                    </div> 
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="" class="mb-0">Re-type New Password</label>
                                        <input type="password" class="form-control !text-sm" placeholder="***">
                                    </div> 
                                </div>
                            </div>
                            <hr class="border-dashed">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="flex justify-center space-x-2">
                                        <button class="btn btn-sm btn-secondary">Cancel</button>
                                        <button class="btn btn-sm btn-success">Save Changes</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div id="profile" v-else>
            <div class="row">
                <div class="col-lg-12">
                    <div class="flex justify-start space-x-1 px-4 ">
                        <button class="btn text-white !bg-blue-500 btn-xs !text-xs p-1 px-3 !rounded-b-none"  v-on:click="menu = ''">Personal Info</button>
                        <!-- <button class="btn text-white !bg-blue-300 btn-xs !text-xs p-1 px-3 hover:!bg-blue-500 !rounded-b-none"  v-on:click="menu = 'change_picture'">Change Picture</button> -->
                        <!-- <button class="btn text-white !bg-blue-300 btn-xs !text-xs p-1 px-3 hover:!bg-blue-500 !rounded-b-none"  v-on:click="menu = 'change_password'">Change Password</button> -->
                    </div>
                    <div class="card !border !border-blue-500">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="" class="mb-0">Fullname</label>
                                        <input type="text" class="form-control !text-sm" placeholder="Fullname" v-model="form.name">
                                    </div> 
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="" class="mb-0">Date of Birth</label>
                                        <input type="date" class="form-control !text-sm" placeholder="Date of Birth" v-model="form.birth_date">
                                    </div> 
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="" class="mb-0">Email</label>
                                        <input type="email" class="form-control !text-sm" placeholder="Email" v-model="form.email">
                                    </div> 
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="" class="mb-0">Gender</label>
                                        <select class="form-control !text-sm" v-model="form.gender">
                                            <option value="">--Select Gender--</option>
                                            <option value="Male">Male</option>
                                            <option value="Female">Female</option>
                                        </select>
                                    </div> 
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="" class="mb-0">Barangay</label>
                                        <input type="text" class="form-control !text-sm" v-model="form.barangay">
                                    </div> 
                                </div>
                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <label for="" class="mb-0">Student ID</label>
                                        <input type="text" class="form-control !text-sm" placeholder="Student ID" v-model="form.student_id">
                                    </div> 
                                </div>
                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <label for="" class="mb-0">Grade Level</label>
                                        <input type="text" class="form-control !text-sm" placeholder="Grade Level" v-model="form.grade_level">
                                    </div> 
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="" class="mb-0">Address</label>
                                        <textarea class="form-control !text-sm" placeholder="Address" rows="3" v-model="form.address"></textarea>
                                    </div> 
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="" class="mb-0">School Name</label>
                                        <textarea class="form-control !text-sm" placeholder="School Name" rows="3" v-model="form.school_name"></textarea>
                                    </div> 
                                </div>
                            </div>
                            <br>
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
                                <div class="col-lg-4">
                                    <img src="../../../images/sampleQR.png" alt="QR" class="w-40 h-40 bg-gray-100 border">
                                </div>
                            </div>
                            <hr class="border-dashed">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="flex justify-center space-x-2">
                                        <button class="btn btn-sm btn-secondary">Cancel</button>
                                        <button type="button" class="btn btn-sm btn-success" @click="onEdit(form.id)">Save Changes</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
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