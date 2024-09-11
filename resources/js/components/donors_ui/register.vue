<script setup>
	import	{LockClosedIcon, UserIcon, ExclamationCircleIcon} from '@heroicons/vue/24/solid'
    import { reactive, ref } from "vue"
    import { useRouter } from "vue-router"
	const router = useRouter() //use if link is used inside the page
	
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
							<!-- <div class="alert alert-danger" >
								<div class="flex justify-start space-x-2">
									<div>
										<ExclamationCircleIcon fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6"></ExclamationCircleIcon>
									</div> 
									<div> asd</div>
								</div>
							</div> -->
							<h4 class="font-bold">Register</h4>
							<form class="pt-3" @submit.prevent="login">
								<div class="form-group">
									<label for="exampleInputEmail">Fullname</label>
                                    <input type="text" class="form-control !text-sm" placeholder="Fullname">
								</div>
								
                                <div class="row">
                                    <div class="col-lg-6 col-md-6 col-sm-6">
                                        <div class="form-group">
                                            <label for="exampleInputEmail">Birthdate</label>
                                            <input type="date" class="form-control !text-sm px-3">
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-6">
                                        <div class="form-group">
                                            <label for="exampleInputEmail">Gender</label>
                                            <select class="form-control !text-sm px-3">
                                                <option value="">Mel</option>
                                                <option value="">FeMel</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
									<label for="exampleInputEmail">Address</label>
                                    <input type="text" class="form-control !text-sm" placeholder="Address">
								</div>
                                <div class="form-group">
									<label for="exampleInputEmail">Contact Number</label>
                                    <input type="text" class="form-control !text-sm" placeholder="Contact Number">
								</div>
                                <div class="form-group">
									<label for="exampleInputEmail">Email Address</label>
                                    <input type="text" class="form-control !text-sm" placeholder="Email Address">
								</div>
                                <div class="form-group">
								    <label for="exampleInputPassword">Password</label>
                                    <input type="password" class="form-control !text-sm" id="exampleInputPassword" placeholder="Password">                        
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