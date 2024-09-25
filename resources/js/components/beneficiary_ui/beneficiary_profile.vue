<script setup>
	import navigation from '@/layouts/navigation_bene.vue';
	import{ Bars3Icon, PencilIcon, MagnifyingGlassIcon, TrashIcon, EyeIcon, CheckIcon, PlusIcon, XMarkIcon} from '@heroicons/vue/24/solid'
	import{ArrowUpOnSquareIcon} from '@heroicons/vue/24/outline'
    import { reactive, ref, onMounted} from "vue"
    import { useRouter } from "vue-router"
    const menu =  ref()
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
                        <button class="btn text-white !bg-blue-500 btn-xs !text-xs p-1 px-3 !rounded-b-none"  v-on:click="menu = 'change_picture'">Change Picture</button>
                        <button class="btn text-white !bg-blue-300 btn-xs !text-xs p-1 px-3 hover:!bg-blue-500 !rounded-b-none"  v-on:click="menu = 'change_password'">Change Password</button>
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
        </div>
        <div id="profile" v-else>
            <div class="row">
                <div class="col-lg-12">
                    <div class="flex justify-start space-x-1 px-4 ">
                        <button class="btn text-white !bg-blue-500 btn-xs !text-xs p-1 px-3 !rounded-b-none"  v-on:click="menu = ''">Personal Info</button>
                        <button class="btn text-white !bg-blue-300 btn-xs !text-xs p-1 px-3 hover:!bg-blue-500 !rounded-b-none"  v-on:click="menu = 'change_picture'">Change Picture</button>
                        <button class="btn text-white !bg-blue-300 btn-xs !text-xs p-1 px-3 hover:!bg-blue-500 !rounded-b-none"  v-on:click="menu = 'change_password'">Change Password</button>
                    </div>
                    <div class="card !border !border-blue-500">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="" class="mb-0">First Name</label>
                                        <input type="text" class="form-control !text-sm" placeholder="First Name">
                                    </div> 
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="" class="mb-0">Middle Name</label>
                                        <input type="text" class="form-control !text-sm" placeholder="Middle Name">
                                    </div> 
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="" class="mb-0">Last Name</label>
                                        <input type="text" class="form-control !text-sm" placeholder="Last Name">
                                    </div> 
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="" class="mb-0">Birthdate</label>
                                        <input type="Date" class="form-control !text-sm">
                                    </div> 
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="" class="mb-0">Contact Number</label>
                                        <input type="text" class="form-control !text-sm">
                                    </div> 
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="" class="mb-0">Email Address</label>
                                        <input type="email" class="form-control !text-sm" placeholder="sample.123@gmail.com">
                                    </div> 
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="" class="mb-0">Occupation</label>
                                        <input type="text" class="form-control !text-sm">
                                    </div> 
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="" class="mb-0">Gender</label>
                                        <div class="flex justify-start space-x-4">
                                            <label for="">
                                                <input type="radio" class="mt-2 mr-1">
                                                Male
                                            </label>
                                            <label for="">
                                                <input type="radio" class="mt-2 mr-1">
                                                Female
                                            </label>
                                        </div>
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
                                        <button class="btn btn-sm btn-success">Save Changes</button>
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