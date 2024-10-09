<script setup>
	import navigation from '@/layouts/navigation_lgu.vue';
	import{ArrowDownIcon, ArrowUpIcon,} from '@heroicons/vue/24/solid'
	import{CubeIcon, Square3Stack3DIcon, UserGroupIcon} from '@heroicons/vue/24/outline'
	// import{ ClockIcon } from '@heroicons/vue/24/outlined'
	import{ClockIcon, MapPinIcon} from '@heroicons/vue/24/outline'
    import { reactive, ref, onMounted} from "vue"
    import { useRouter } from "vue-router"
    const choice =  ref();
    // import { Bar } from 'vue-chartjs'
    // import { Chart as ChartJS, Title, Tooltip, Legend, BarElement, CategoryScale, LinearScale } from 'chart.js'

    // ChartJS.register(Title, Tooltip, Legend, BarElement, CategoryScale, LinearScale)

            // export default {
            // name: 'BarChart',
            //     components: { Bar },
            //     data() {
            //         return {
            //         chartData: {
            //             labels: [ 'January', 'February', 'March' ],
            //             datasets: [ { data: [40, 20, 12] } ]
            //         },
            //         chartOptions: {
            //             responsive: true
            //         }
            //         }
            //     }
            // }
    
</script>
<template>
	<navigation>
        <div class="row">
            <div class="col-md-12 grid-margin  mb-3">
                <div class="d-flex justify-content-between flex-wrap mx-3 mt-3">
                    <div class="d-flex align-items-end flex-wrap">
                        <div class="mr-md-3 mr-xl-5">
                            <h2>Welcome back,</h2>
                            <p class="mb-md-0">See the following Events below.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="px-3" v-if="choice === 'feeding_show'">
            <div class="row">
                <div class="col-lg-12">
                    <div class="flex justify-start space-x-1">
                        <button class="btn btn-sm !bg-blue-300 text-white hover:!bg-blue-400 !rounded-b-none" v-on:click="choice = ''">Donations</button>
                        <button class="btn btn-sm !bg-blue-500 text-white !rounded-b-none" v-on:click="choice = 'feeding_show'">Feeding</button>
                        <button class="btn btn-sm !bg-blue-300 text-white hover:!bg-blue-400 !rounded-b-none" v-on:click="choice = 'bene_show'">Beneficiary</button>
                    </div>
                </div>
            </div>
            <hr class="border-blue-500 mt-0">
            <div class="row">
                <div class="col-lg-4 col-md-4 col-sm-12 mb-3">
                    <div class="card rounded-lg" >
                        <div class="card-body dashboard-tabs p">
                            <div class="flex justify-between">
                                <div>
                                    <span class="block w-full text-3xl font-bold text-gray-600 mb-1">2083</span>
                                    <span class="block w-full text-gray-500 text-base">New Feeding</span>
                                    <span classs="">
                                        <div class="flex justify-start text-green-500">
                                            <span class="">05.02%</span> 
                                            <ArrowUpIcon fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4"></ArrowUpIcon>
                                        </div>
                                    </span>
                                </div>
                                <div class="text-gray-400">
                                    <CubeIcon fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-20 h-20"></CubeIcon>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-4 col-sm-12 mb-3">
                    <div class="card rounded-lg" >
                        <div class="card-body dashboard-tabs p">
                            <div class="flex justify-between">
                                <div>
                                    <span class="block w-full text-3xl font-bold text-gray-600 mb-1">2083</span>
                                    <span class="block w-full text-gray-500 text-base">Total Feeding</span>
                                    <span classs="">
                                        <div class="flex justify-start text-green-500">
                                            <span class="">05.02%</span> 
                                            <ArrowUpIcon fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4"></ArrowUpIcon>
                                        </div>
                                    </span>
                                </div>
                                <div class="text-gray-400">
                                    <Square3Stack3DIcon fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-20 h-20"></Square3Stack3DIcon>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-4 col-sm-12 mb-3">
                    <div class="card rounded-lg" >
                        <div class="card-body dashboard-tabs p">
                            <div class="flex justify-between">
                                <div>
                                    <span class="block w-full text-3xl font-bold text-gray-600 mb-1">2083</span>
                                    <span class="block w-full text-gray-500 text-base">New Feeders</span>
                                    <span classs="">
                                        <div class="flex justify-start text-green-500">
                                            <span class="">05.02%</span> 
                                            <ArrowUpIcon fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4"></ArrowUpIcon>
                                        </div>
                                    </span>
                                </div>
                                <div class="text-gray-400">
                                    <UserGroupIcon fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-20 h-20"></UserGroupIcon>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row ">
                <div class="col-lg-7">
                    <div class="card">
                        <div class="card-body">
                            line graph
                            <Bar
                                id="my-chart-id"
                                :options="chartOptions"
                                :data="chartData"
                            />
                        </div>
                    </div>
                </div>
                <div class="col-lg-5">
                    <div class="card">
                        <div class="card-body">
                            Calendar
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="px-3" v-else-if="choice === 'bene_show'">
            <div class="row">
                <div class="col-lg-12">
                    <div class="flex justify-start space-x-1">
                        <button class="btn btn-sm !bg-blue-300 text-white hover:!bg-blue-400 !rounded-b-none" v-on:click="choice = ''">Donations</button>
                        <button class="btn btn-sm !bg-blue-300 text-white hover:!bg-blue-400 !rounded-b-none" v-on:click="choice = 'feeding_show'">Feeding</button>
                        <button class="btn btn-sm !bg-blue-500 text-white !rounded-b-none" v-on:click="choice = 'bene_show'">Beneficiary </button>
                    </div>
                </div>
            </div>
            <hr class="border-blue-500 mt-0">
            <div class="row">
                <div class="col-lg-4 col-md-4 col-sm-12 mb-3">
                    <div class="card rounded-lg" >
                        <div class="card-body dashboard-tabs p">
                            <div class="flex justify-between">
                                <div>
                                    <span class="block w-full text-3xl font-bold text-gray-600 mb-1">2083</span>
                                    <span class="block w-full text-gray-500 text-base">New Bene</span>
                                    <span classs="">
                                        <div class="flex justify-start text-green-500">
                                            <span class="">05.02%</span> 
                                            <ArrowUpIcon fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4"></ArrowUpIcon>
                                        </div>
                                    </span>
                                </div>
                                <div class="text-gray-400">
                                    <CubeIcon fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-20 h-20"></CubeIcon>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-4 col-sm-12 mb-3">
                    <div class="card rounded-lg" >
                        <div class="card-body dashboard-tabs p">
                            <div class="flex justify-between">
                                <div>
                                    <span class="block w-full text-3xl font-bold text-gray-600 mb-1">2083</span>
                                    <span class="block w-full text-gray-500 text-base">Total </span>
                                    <span classs="">
                                        <div class="flex justify-start text-green-500">
                                            <span class="">05.02%</span> 
                                            <ArrowUpIcon fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4"></ArrowUpIcon>
                                        </div>
                                    </span>
                                </div>
                                <div class="text-gray-400">
                                    <Square3Stack3DIcon fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-20 h-20"></Square3Stack3DIcon>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-4 col-sm-12 mb-3">
                    <div class="card rounded-lg" >
                        <div class="card-body dashboard-tabs p">
                            <div class="flex justify-between">
                                <div>
                                    <span class="block w-full text-3xl font-bold text-gray-600 mb-1">2083</span>
                                    <span class="block w-full text-gray-500 text-base">New Bene</span>
                                    <span classs="">
                                        <div class="flex justify-start text-green-500">
                                            <span class="">05.02%</span> 
                                            <ArrowUpIcon fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4"></ArrowUpIcon>
                                        </div>
                                    </span>
                                </div>
                                <div class="text-gray-400">
                                    <UserGroupIcon fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-20 h-20"></UserGroupIcon>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row ">
                <div class="col-lg-7">
                    <div class="card">
                        <div class="card-body">
                            line graph
                            <Bar
                                id="my-chart-id"
                                :options="chartOptions"
                                :data="chartData"
                            />
                        </div>
                    </div>
                </div>
                <div class="col-lg-5">
                    <div class="card">
                        <div class="card-body">
                            Calendar
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="px-3" v-else>
            <div class="row">
                <div class="col-lg-12">
                    <div class="flex justify-start space-x-1">
                        <button class="btn btn-sm !bg-blue-500 text-white !rounded-b-none" v-on:click="choice = ''">Donations</button>
                        <button class="btn btn-sm !bg-blue-300 text-white hover:!bg-blue-400 !rounded-b-none" v-on:click="choice = 'feeding_show'">Feeding</button>
                        <button class="btn btn-sm !bg-blue-300 text-white hover:!bg-blue-400 !rounded-b-none" v-on:click="choice = 'bene_show'">Beneficiary</button>
                    </div>
                </div>
            </div>
            <hr class="border-blue-500 mt-0">
            <div class="row">
                <div class="col-lg-4 col-md-4 col-sm-12 mb-3">
                    <div class="card rounded-lg" >
                        <div class="card-body dashboard-tabs p">
                            <div class="flex justify-between">
                                <div>
                                    <span class="block w-full text-3xl font-bold text-gray-600 mb-1">2083</span>
                                    <span class="block w-full text-gray-500 text-base">New Donations</span>
                                    <span classs="">
                                        <div class="flex justify-start text-green-500">
                                            <span class="">05.02%</span> 
                                            <ArrowUpIcon fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4"></ArrowUpIcon>
                                        </div>
                                    </span>
                                </div>
                                <div class="text-gray-400">
                                    <CubeIcon fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-20 h-20"></CubeIcon>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-4 col-sm-12 mb-3">
                    <div class="card rounded-lg" >
                        <div class="card-body dashboard-tabs p">
                            <div class="flex justify-between">
                                <div>
                                    <span class="block w-full text-3xl font-bold text-gray-600 mb-1">2083</span>
                                    <span class="block w-full text-gray-500 text-base">Total Donations</span>
                                    <span classs="">
                                        <div class="flex justify-start text-red-500">
                                            <span class="">05.02%</span> 
                                            <ArrowDownIcon fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4"></ArrowDownIcon>
                                        </div>
                                    </span>
                                </div>
                                <div class="text-gray-400">
                                    <Square3Stack3DIcon fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-20 h-20"></Square3Stack3DIcon>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-4 col-sm-12 mb-3">
                    <div class="card rounded-lg" >
                        <div class="card-body dashboard-tabs p">
                            <div class="flex justify-between">
                                <div>
                                    <span class="block w-full text-3xl font-bold text-gray-600 mb-1">2083</span>
                                    <span class="block w-full text-gray-500 text-base">New Donors</span>
                                    <span classs="">
                                        <div class="flex justify-start text-green-500">
                                            <span class="">05.02%</span> 
                                            <ArrowUpIcon fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4"></ArrowUpIcon>
                                        </div>
                                    </span>
                                </div>
                                <div class="text-gray-400">
                                    <UserGroupIcon fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-20 h-20"></UserGroupIcon>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row ">
                <div class="col-lg-7">
                    <div class="card">
                        <div class="card-body">
                            line graph
                            <Bar
                                id="my-chart-id"
                                :options="chartOptions"
                                :data="chartData"
                            />
                        </div>
                    </div>
                </div>
                <div class="col-lg-5">
                    <div class="card">
                        <div class="card-body">
                            Calendar
                        </div>
                    </div>
                </div>
            </div>
        </div>
	</navigation>
</template>