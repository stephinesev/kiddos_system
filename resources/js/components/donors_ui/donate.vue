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
                        <h3 class="card-title !text-lg m-0 uppercase font-bold text-gray-600">Donate<small></small></h3>
                    </span>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb !mb-0 !text-xs px-2 py-1 !bg-transparent">
                            <li class="breadcrumb-item"><a href="/donor_dashboard">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Donate</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
		<div class="row">
            <div class="col-lg-12 stretch-card">
                <div class="card">
                    <div class="card-body">
						<div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="">What</label>
                                    <input type="text" class="form-control  !text-sm">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="">When</label>
                                    <div class="flex justify-between space-x-3">
                                        <input type="date" class="form-control !text-sm">
                                        <input type="time" class="form-control !text-sm">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="">Barangay</label>
                                    <input type="text" class="form-control !text-sm">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="">Attachment Donation Picture</label>
                                    <input type="file" class="form-control  !text-sm">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-3">
                                <div class="form-group">
                                    <label for="">Type of Donation</label>
                                    <div class="flex justify-start space-x-3 mt-2">
                                        <div class="flex justify-center space-x-1">
                                            <input type="radio" class="">
                                            <span class="text-sm">Dry Goods</span>
                                        </div>
                                        <div class="flex justify-center space-x-1">
                                            <input type="radio" class="">
                                            <span class="text-sm">Wet Goods</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="form-group">
                                    <label for="">Mode of Collection</label>
                                    <div class="flex justify-start space-x-3 mt-2">
                                        <div class="flex justify-center space-x-1">
                                            <input type="radio" class="">
                                            <span class="text-sm">Self Delivery</span>
                                        </div>
                                        <div class="flex justify-center space-x-1">
                                            <input type="radio" class="">
                                            <span class="text-sm">Pick Up</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                        </div>
                        <hr class="border-dashed">
                        <div class="row">
                            <div class="col-lg-12">
                                <center>

                                    <button class="btn btn-primary btn-lg">Donate</button>
                                </center>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
		<!-- ADD BENEFICIARY MODAL -->
        
	</navigation>
</template>