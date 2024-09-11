<script setup>
	import navigation from '@/layouts/navigation_donor.vue';
	import{ Bars3Icon, PencilIcon, MagnifyingGlassIcon, TrashIcon, EyeIcon} from '@heroicons/vue/24/solid'
	import{ArrowUpOnSquareIcon} from '@heroicons/vue/24/outline'
    import { reactive, ref, onMounted} from "vue"
    import { useRouter } from "vue-router"
</script>
<template>
	<navigation>
        <div class="row">
            <div class="col-lg-12">
                <div class="flex justify-between mb-3 px-2">
                    <span class="">
                        <h3 class="card-title !text-lg m-0 uppercase font-bold text-gray-600">Donation History <small>List</small></h3>
                    </span>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb !mb-0 !text-xs px-2 py-1 !bg-transparent">
                            <li class="breadcrumb-item"><a href="/donor_dashboard">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Donation History</li>
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
                        <!-- <div class="flex justify-between  mt-2 mb-0 absolute z-50 ">
                            <button @click="openNew()" class="btn btn-primary mt-2 mt-xl-0 text-white">
                                <span>Add New Beneficiary </span>
                            </button>
                        </div> -->
                        <div class="flex justify-between  mt-2 mb-0 ">
                            <button @click="openNew()" class="btn btn-primary mt-2 mt-xl-0 text-white">
                                <span>Add New Beneficiary </span>
                            </button>
                        </div>
						<!-- DATATABLE -->
                        <div class="pt-3">
                            <table class="display table table-bordered table-hover !border nowrap">
                                <thead>
                                    <tr>
                                        <th class="!text-xs bg-gray-100 uppercase"> Name</th>
                                        <th class="!text-xs bg-gray-100 uppercase"> Gender</th>
                                        <th class="!text-xs bg-gray-100 uppercase"> Email</th>
                                        <th class="!text-xs bg-gray-100 uppercase"> Role</th>
                                        <th class="!text-xs bg-gray-100 uppercase"> Weight</th>
                                        <th class="!text-xs bg-gray-100 uppercase"> Height</th>
                                        <th class="!text-xs bg-gray-100 uppercase"> BMI</th>
                                        <th class="!text-xs bg-gray-100 uppercase"> Status</th>
                                        <th class="!text-xs bg-gray-100 uppercase" width="1%" align="center"> 
                                            <span class="text-center  px-auto">
                                                <Bars3Icon fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="menu-icon w-5 h-5 "></Bars3Icon>
                                            </span>
                                        </th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
		<!-- ADD BENEFICIARY MODAL -->
        
	</navigation>
</template>