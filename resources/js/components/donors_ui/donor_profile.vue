<script setup>
	import navigation from '@/layouts/navigation_donor.vue';
	import{ Bars3Icon, PencilIcon, MagnifyingGlassIcon, TrashIcon, EyeIcon, CheckIcon, PlusIcon, XMarkIcon} from '@heroicons/vue/24/solid'
	import{ArrowUpOnSquareIcon} from '@heroicons/vue/24/outline'
    import { reactive, ref, onMounted, watch} from "vue"
    import { useRouter } from "vue-router"
    const menu =  ref()
    let form=ref([]);
    let credentials = ref([])
    let error = ref("")
	let success = ref('')	
    let imageFile=ref("");
    let imageUrl=ref("");
    let error_image = ref('');
	const warningAlert = ref(false)
	const successAlert = ref(false)
	const hideAlert = ref(true)
    //Fetcher of Data
	onMounted(async () => {
        getCredentials()
	})
    //Get fullname and donors ID
    const getCredentials = async () => {
		const response = await fetch(`/api/donor_credentials`);
		credentials.value = await response.json();
        donorsForm(credentials.value.donor_id)
	}
    //Declaration of input values
	const donorsForm = async (id) => {
		let response = await axios.get(`/api/edit_donor/`+id);
		form.value = response.data.donor;
	}

    //Update function
	const onEdit = (id) => {
		const formData=new FormData()
		formData.append('fullname',form.value.fullname)
		formData.append('email',form.value.email)
		formData.append('password',form.value.password)
		formData.append('birth_date',form.value.birth_date)
		formData.append('gender',form.value.gender)
		formData.append('address',form.value.address)
		formData.append('email',form.value.email)
		formData.append('contact_no',form.value.contact_no)
        formData.append('profile_image',imageFile.value)
		axios.post(`/api/update_donor/`+id, formData).then(function () {
			success.value='You have successfully updated your profile!'
			form.value=[]
			error.value=''
			successAlert.value = !successAlert.value
			setTimeout(() => {
				donorsForm(id)
				closeAlert()
			}, 2000);
		}).catch(function(err){
			warningAlert.value = !warningAlert.value
			error.value='Fields cannot be empty!'
		});
	}
    //Modal Popup Variables]
	const hideModal = ref(true)
	const closeAlert = () => {
		warningAlert.value = !hideAlert.value
		successAlert.value= !hideAlert.value
	}
    //Display Image
    const upload_image = (event) => {
        let file = event.target.files[0];
        if(event.target.files.length===0){
            imageFile.value='';
            imageUrl.value='';
            return;
        }else if(file['size'] < 2111775){
            imageFile.value = event.target.files[0];
            error.value=''
        }else{
            warningAlert.value = !warningAlert.value
            error.value='File size cannot be bigger than 2 MB'
        }
    }
    watch(imageFile, (imageFile) => {
        if(!(imageFile instanceof File)){
            return;
        }
        let fileReader1 = new FileReader();
        fileReader1.readAsDataURL(imageFile)
        fileReader1.addEventListener("load", () => {
            imageUrl.value=fileReader1.result
            document.getElementById('img1').src = fileReader1.result;
        })
    })
</script>
<template>
	<navigation>
        <div class="row">
            <div class="col-lg-12">
                <div class="flex justify-between mb-3 px-2">
                    <span class="">
                        <h3 class="card-title !text-lg m-0 uppercase font-bold text-gray-600">Donors Profile<small></small></h3>
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
                        <button class="btn text-white !bg-blue-500 btn-xs !text-xs p-1 px-3 !rounded-b-none"  v-on:click="menu = 'change_picture'">Change Picture</button>
                        <!-- <button class="btn text-white !bg-blue-300 btn-xs !text-xs p-1 px-3 hover:!bg-blue-500 !rounded-b-none"  v-on:click="menu = 'change_password'">Change Password</button> -->
                    </div>
                    <div class="card !border !border-blue-500">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-2">
                                    <img :src="'storage/profile/'+form.profile_image" id="img1" v-if="form.profile_image!=null"/>
                                    <img src="../../../images/default.jpg" id="img1" alt="Profile Picture" class="w-40 h-40 bg-gray-100 border" v-else/>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <div class="flex justify-start space-x-1">
                                            <input type="file" class="form-control !text-sm" accept="image/*" id="image1" @change="upload_image">
                                            <!-- <button class="btn btn-xs btn-danger ">
                                                <XMarkIcon fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="menu-icon w-5 h-5 "></XMarkIcon>
                                            </button> -->
                                        </div>
                                    </div> 
                                </div>
                            </div>
                            <hr class="border-dashed">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="flex justify-center space-x-2">
                                        <!-- <button class="btn btn-sm btn-secondary">Cancel</button> -->
                                        <button class="btn btn-sm btn-success"  type="button" @click="onEdit(form.id)">Save Changes</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- <div id="change_password" v-else-if="menu === 'change_password'">
            <div class="row">
                <div class="col-lg-12">
                    <div class="flex justify-start space-x-1 px-4 ">
                        <button class="btn text-white !bg-blue-300 btn-xs !text-xs p-1 px-3 hover:!bg-blue-500 !rounded-b-none"  v-on:click="menu = ''">Personal Info </button>
                        <button class="btn text-white !bg-blue-300 btn-xs !text-xs p-1 px-3 hover:!bg-blue-500 !rounded-b-none"  v-on:click="menu = 'change_picture'">Change Picture</button>
                        <button class="btn text-white !bg-blue-500 btn-xs !text-xs p-1 px-3 !rounded-b-none"  v-on:click="menu = 'change_password'">Change Password</button>
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
        </div> -->
        <div id="profile" v-else>
            <div class="row">
                <div class="col-lg-12">
                    <div class="flex justify-start space-x-1 px-4 ">
                        <button class="btn text-white !bg-blue-500 btn-xs !text-xs p-1 px-3 !rounded-b-none"  v-on:click="menu = ''">Personal Info</button>
                        <button class="btn text-white !bg-blue-300 btn-xs !text-xs p-1 px-3 hover:!bg-blue-500 !rounded-b-none"  v-on:click="menu = 'change_picture'">Change Picture</button>
                        <!-- <button class="btn text-white !bg-blue-300 btn-xs !text-xs p-1 px-3 hover:!bg-blue-500 !rounded-b-none"  v-on:click="menu = 'change_password'">Change Password</button> -->
                    </div>
                    <div class="card !border !border-blue-500">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="" class="mb-0">Fullname</label>
                                        <input type="text" class="form-control !text-sm" placeholder="Fullname" v-model="form.fullname">
                                    </div> 
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="" class="mb-0">Birthdate</label>
                                        <input type="date" class="form-control !text-sm" placeholder="Birthdate" v-model="form.birth_date">
                                    </div> 
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="" class="mb-0">Gender</label>
                                        <select class="form-control !text-sm"  v-model="form.gender">
                                            <option value="">--Select Gender--</option>
                                            <option value="Male">Male</option>
                                            <option value="Female">Female</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="" class="mb-0">Address</label>
                                        <textarea class="form-control !text-sm" rows="3"  v-model="form.address"></textarea>
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
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="" class="mb-0">Contact Number</label>
                                        <input type="text" class="form-control !text-sm"  v-model="form.contact_no">
                                    </div> 
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="" class="mb-0">Email Address</label>
                                        <input type="email" class="form-control !text-sm" placeholder="Email Address"  v-model="form.email">
                                    </div> 
                                </div>
                            </div>
                            <!-- <div class="row">
                                <div class="col-lg-4">
                                    <img src="../../../images/sampleQR.png" alt="QR" class="w-40 h-40 bg-gray-100 border">
                                </div>
                            </div> -->
                            <!-- <hr class="border-dashed"> -->
                             <br>
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="flex justify-center space-x-2">
                                        <button class="btn btn-sm btn-success" type="button" @click="onEdit(form.id)">Save Changes</button>
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