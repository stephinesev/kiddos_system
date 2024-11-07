<script setup>
	import navigation from '@/layouts/navigation_lgu.vue';
	import{ArrowDownIcon, ArrowUpIcon,} from '@heroicons/vue/24/solid'
	import{CubeIcon, Square3Stack3DIcon, UserGroupIcon} from '@heroicons/vue/24/outline'
	// import{ ClockIcon } from '@heroicons/vue/24/outlined'
	import{ClockIcon, MapPinIcon} from '@heroicons/vue/24/outline'
    import { reactive, ref, onMounted} from "vue"
    import { useRouter } from "vue-router"
    import { Bar } from 'vue-chartjs'
    import { Chart as ChartJS, Title, Tooltip, Legend, BarElement, CategoryScale, LinearScale } from 'chart.js'
    ChartJS.register(Title, Tooltip, Legend, BarElement, CategoryScale, LinearScale)
    const choice =  ref();
    const counts =  ref([]);
    onMounted(async () => {
		getBarangayCount()
	})
    const getBarangayCount = async () => {
		let response = await axios.get(`/api/chart_barangay`)
		counts.value = response.data.labels.length
	}
</script>
<script>
import { Chart, registerables } from 'chart.js';
Chart.register(...registerables);
export default {
    mounted() {
        this.fetchData();
        this.fetchDataPie();
    },
    methods: {
        fetchData() {
            fetch('/api/chart_barangay')
                .then(response => response.json())
                .then(data => {
                    this.labels = data.labels;
                    this.data_barangay_normal = data.data_barangay_normal;
                    this.data_barangay_underweight = data.data_barangay_underweight;
                    this.data_barangay_overweight = data.data_barangay_overweight;
                    this.data_barangay_obesity = data.data_barangay_obesity;
                    this.renderChart();
                });
        },
        renderChart() {
            const ctx = this.$refs.lineChart.getContext('2d');
            this.chart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: this.labels,
                    datasets: [{
                            label: 'Normal',
                            data: this.data_barangay_normal,
                            borderColor: 'rgba(75, 192, 192, 1)',
                            backgroundColor: 'rgba(75, 192, 192, 0.2)',
                            borderWidth: 1,
                        },
                        {
                            label: 'Underweight',
                            data: this.data_barangay_underweight,
                            borderColor: 'rgba(34, 41, 247, 0.8)',
                            backgroundColor: 'rgba(34, 41, 247, 0.36)',
                            borderWidth: 1,
                        },
                        {
                            label: 'Overweight',
                            data: this.data_barangay_overweight,
                            borderColor: 'rgba(250, 17, 17, 0.77)',
                            backgroundColor: 'rgba(250, 17, 17, 0.34)',
                            borderWidth: 1,
                        },
                        {
                            label: 'Obesity',
                            data: this.data_barangay_obesity,
                            borderColor: 'rgba(247, 222, 26, 0.77)',
                            backgroundColor: 'rgba(247, 222, 26, 0.43)',
                            borderWidth: 1,
                        }
                    ]
                },
                options: {
                    responsive: true,
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        },
        fetchDataPie() {
            fetch('/api/chart_barangaypie')
                .then(response => response.json())
                .then(data => {
                    this.labels = data.labels;
                    this.data_barangay_pie = data.data_barangay_pie;
                    // this.data_barangay_underweight = data.data_barangay_underweight;
                    // this.data_barangay_overweight = data.data_barangay_overweight;
                    // this.data_barangay_obesity = data.data_barangay_obesity;
                    this.renderChartPie();
                });
        },
        renderChartPie() {
            const ctx = this.$refs.lineChart2.getContext('2d');
            this.chart = new Chart(ctx, {
                type: 'pie',
                data: {
                    labels: this.labels,
                    datasets: [{
                            label: 'Normal',
                            data: this.data_barangay_pie,
                            borderColor: 'rgba(75, 192, 192, 1)',
                            backgroundColor: ['#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0', '#9966FF'],
                            borderWidth: 1,
                        }
                    ]
                },
                options: {
                    responsive: true,
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        },
    },
    beforeDestroy() {
        if (this.chart) {
            this.chart.destroy();
        }
    }
};
</script>
<template>
	<navigation>
        <div class="row">
            <div class="col-md-12 grid-margin  mb-3">
                <div class="d-flex justify-content-between flex-wrap mx-3 mt-3">
                    <div class="d-flex align-items-end flex-wrap">
                        <div class="mr-md-3 mr-xl-5">
                            <h2>Welcome back, </h2>
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
                            Children Health Status (BMI) Across {{counts}} Barangay
                            <canvas ref="lineChart"></canvas>
                        </div>
                    </div>
                </div>
                <div class="col-lg-5">
                    <div class="card">
                        <div class="card-body">
                            <canvas ref="lineChart2"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
	</navigation>
</template>