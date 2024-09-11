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
							<h4 class="font-bold">KIDDOS</h4>
							<form class="pt-3" @submit.prevent="login">
								<div class="form-group">
									<label for="exampleInputEmail">Username</label>
									<div class="input-group">
										<div class="input-group-prepend bg-transparent">
											<span class="input-group-text bg-transparent border-right-0">
												<UserIcon fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class=" w-5 h-5"></UserIcon>
											</span>
										</div>
										<input type="text" class="form-control form-control-lg border-left-0 pl-1" id="exampleInputEmail" placeholder="Username">
									</div>
								</div>
								<div class="form-group">
								<label for="exampleInputPassword">Password</label>
									<div class="input-group">
										<div class="input-group-prepend bg-transparent">
											<span class="input-group-text bg-transparent border-right-0">
												<LockClosedIcon fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class=" w-5 h-5"></LockClosedIcon>
											</span>
										</div>
										<input type="password" class="form-control form-control-lg border-left-0 pl-0" id="exampleInputPassword" placeholder="Password">                        
									</div>
								</div>
								
								<div class="my-3">
									<input type="submit" value="Login" class="btn btn-block btn-primary btn-lg font-weight-medium auth-form-btn">
								</div>
								
								<div class="text-center mt-4 font-weight-light text-sm">
									Don't have an account? Please register <a href="/donor_register" class="text-primary">here.</a>
								</div>
							</form>
						</div>
					</div>
					
				</div>
			</div>
		</div>
	</div>
</template>