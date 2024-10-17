<script setup>
	import	{LockClosedIcon, UserIcon, ExclamationCircleIcon} from '@heroicons/vue/24/solid'
    import { reactive, ref, onMounted } from "vue"
    import { useRouter } from "vue-router"
	const router = useRouter() //use if link is used inside the page
	let form=ref([]);
	let barangay=ref([]);
	// let form = reactive({
    //     fullname:'',
	// 	password:'',
	// 	birth_date:'',
	// 	gender:'',
	// 	address:'',
	// 	email:'',
	// 	contact_no:'',
    // })
	let error = ref('')
	let success = ref('')
	const warningAlert = ref(false)
	const successAlert = ref(false)
	const hideAlert = ref(true)
	//Fetcher of Data
	onMounted(async () => {
		registerForm()
		getBarangay()
	})
	//Fetching Data From Barangay Table for display
	const getBarangay = async () => {
		let response = await axios.get("/api/get_barangay");
		barangay.value = response.data.barangay;
	}
	//Declaration of input values
	const registerForm = async () => {
		let response = await axios.get("/api/create_registration");
		form.value = response.data;
	}
	console.log(form.value.fullname)

	//Insert Function
	const onSave = () => {
		const formData=new FormData()
		formData.append('fullname',form.value.fullname)
		formData.append('birth_date',form.value.birth_date)
		formData.append('gender',form.value.gender)
		formData.append('barangay',form.value.barangay)
		formData.append('address',form.value.address)
		formData.append('email',form.value.email)
		formData.append('contact_no',form.value.contact_no)
		formData.append('password',form.value.password)
		axios.post("/api/registration",formData).then(function () {
			success.value='You have successfully registered!'
			error.value=''
			axios.post('/api/donor_login_process', formData)
			.then(response =>{
				if(response.data.success){
					localStorage.setItem('token', response.data.data.token)
					router.push('/donate')
				} else {
					error.value = response.data.message;
				}
			})
		}).catch(function(err){
			error.value='Fields cannot be empty!'
		});
	}
</script>
<template>
    <div class="container-scroller ">
		<div class="container-fluid page-body-wrapper full-page-wrapper">
			<div class="content-wrapper d-flex align-items-stretch auth auth-img-bg !w-screen !h-screen !overflow-x-hidden !overflow-y-hidden">
				<div class="row flex-grow">
                    <div class="col-lg-6 login-half-bg2 d-flex flex-row !bg-gray-300">
					</div>
					<div class="col-lg-6 d-flex align-items-center justify-content-center !bg-white">
						<div class="auth-form-transparent text-left p-3">
							<!-- <div class="brand-logo">
								<img src="../../images/logo_cenpri.png" alt="logo">
								<h4 class="font-bold">ADMINISTRATOR</h4>
							</div> -->
							<div class="alert alert-danger" v-if="error!=''">
								<div class="flex justify-start space-x-2">
									<div>
										<ExclamationCircleIcon fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6"></ExclamationCircleIcon>
									</div> 
									<div> {{ error }}</div>
								</div>
							</div>
							<h4 class="font-bold">Register</h4>
							<form class="pt-3" @submit.prevent="onSave">
								<div class="form-group">
									<label for="exampleInputEmail">Fullname</label>
                                    <input type="text" class="form-control !text-sm" placeholder="Fullname" v-model="form.fullname">
								</div>
								
                                <div class="row">
                                    <div class="col-lg-6 col-md-6 col-sm-6">
                                        <div class="form-group">
                                            <label for="exampleInputEmail">Birthdate</label>
                                            <input type="date" class="form-control !text-sm px-3" v-model="form.birth_date">
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-6">
                                        <div class="form-group">
                                            <label for="exampleInputEmail">Gender</label>
                                            <select class="form-control !text-sm px-3" v-model="form.gender">
												<option value=''>--Select Gender--</option>
                                                <option value="Male">Male</option>
                                                <option value="Female">Female</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
								<div class="form-group">
									<label for="exampleInputEmail">Barangay</label>
                                    <select  class="form-control" v-model="form.barangay">
										<option value="">--Select Barangay--</option>
										<option :value="b.id" v-for="b in barangay" :key="b.id">{{ b.barangay_name }} - {{ b.city}}</option>
									</select>
								</div>
                                <div class="form-group">
									<label for="exampleInputEmail">Address</label>
                                    <input type="text" class="form-control !text-sm" placeholder="Address" v-model="form.address">
								</div>
                                <div class="form-group">
									<label for="exampleInputEmail">Contact Number</label>
                                    <input type="text" class="form-control !text-sm" placeholder="Contact Number" v-model="form.contact_no">
								</div>
                                <div class="form-group">
									<label for="exampleInputEmail">Email Address</label>
                                    <input type="email" class="form-control !text-sm" placeholder="Email Address" v-model="form.email">
								</div>
                                <div class="form-group">
								    <label for="exampleInputPassword">Password</label>
                                    <input type="password" class="form-control !text-sm" id="exampleInputPassword" placeholder="Password" v-model="form.password">                        
								</div>
                                <div class="my-3">
									<input type="submit" value="Register" class="btn btn-block btn-primary btn-lg font-weight-medium auth-form-btn">
								</div>
							</form>
						</div>
					</div>
					
				</div>
			</div>
		</div>
	</div>
</template>