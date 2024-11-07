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
    const choice =  ref('');
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
import ChartDataLabels from 'chartjs-plugin-datalabels'
Chart.register(...registerables, ChartDataLabels);

const colorPalette = [
  '#FF6384',
  '#36A2EB',
  '#FFCE56',
  '#4BC0C0',
  '#9966FF',
  '#FF9F40',
  '#FF5733',
  '#33FF57',
  '#3357FF',
  '#FF33A6'
];
export default {
    mounted() {
        this.fetchData();
        this.fetchDataPie();
        this.assignColors();
    },
    data() {
        return {
            chartLabels: ['Red', 'Blue', 'Yellow', 'Green', 'Purple'],
            chartColors: [],
        };
    },
    methods: {
        assignColors() {
            // Use the color palette and assign colors based on the number of labels
            this.chartColors = this.chartLabels.map((_, index) => 
                colorPalette[index % colorPalette.length]
            );
        },
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
                    this.data_barangay_underweightpie = data.data_barangay_underweightpie;
                    this.data_barangay_overweightpie = data.data_barangay_overweightpie;
                    this.data_barangay_obesitypie = data.data_barangay_obesitypie;
                    this.renderChartPie();
                });
        },
        renderChartPie() {
            const ctx = this.$refs.lineChart2.getContext('2d');
            this.chart2 = new Chart(ctx, {
                type: 'pie',
                data: {
                    labels: this.labels,
                    datasets: [{
                            label: 'Normal',
                            data: this.data_barangay_pie,
                            borderColor: 'rgba(200, 200, 200, 0.75)',
                            backgroundColor: this.chartColors,
                            // borderColor: 'rgba(75, 192, 192, 1)',
                            // backgroundColor: ['#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0', '#9966FF'],
                            borderWidth: 1,
                        }
                    ]
                },
                options: {
                    responsive: true,
                    plugins: {
                        tooltip: {
                            callbacks: {
                                label: function(tooltipItem) {
                                    return `${tooltipItem.label}: ${tooltipItem.raw.toFixed(0)}%`;
                                }
                            }
                        },
                        datalabels: {
                            formatter: (value, context) => {
                            if (value === 0) {
                                return ''; // Hide label for zero values
                            }
                            let sum = 0;
                            let dataArr = context.chart.data.datasets[0].data;
                            dataArr.forEach(data => {
                                sum += data;
                            });
                            let percentage = (value * 100 / sum).toFixed(0) + "%";
                            return percentage;
                            },
                            color: '#fff',
                            font: {
                            weight: 'bold'
                            }
                        }
                    }
                }
            });
            const ctx1 = this.$refs.lineChart3.getContext('2d');
            this.chart3 = new Chart(ctx1, {
                type: 'pie',
                data: {
                    labels: this.labels,
                    datasets: [{
                            label: 'Normal',
                            data: this.data_barangay_underweightpie,
                            borderColor: 'rgba(200, 200, 200, 0.75)',
                            backgroundColor: this.chartColors,
                            // borderColor: 'rgba(75, 192, 192, 1)',
                            // backgroundColor: ['#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0', '#9966FF'],
                            borderWidth: 1,
                        }
                    ]
                },
                options: {
                    responsive: true,
                    plugins: {
                        tooltip: {
                            callbacks: {
                                label: function(tooltipItem) {
                                    return `${tooltipItem.label}: ${tooltipItem.raw.toFixed(0)}%`;
                                }
                            }
                        },
                        datalabels: {
                            formatter: (value, context) => {
                            if (value === 0) {
                                return ''; // Hide label for zero values
                            }
                            let sum = 0;
                            let dataArr = context.chart.data.datasets[0].data;
                            dataArr.forEach(data => {
                                sum += data;
                            });
                            let percentage = (value * 100 / sum).toFixed(0) + "%";
                            return percentage;
                            },
                            color: '#fff',
                            font: {
                            weight: 'bold'
                            }
                        }
                    }
                }
            });
            const ctx2 = this.$refs.lineChart4.getContext('2d');
            this.chart4 = new Chart(ctx2, {
                type: 'pie',
                data: {
                    labels: this.labels,
                    datasets: [{
                            label: 'Overweight',
                            data: this.data_barangay_overweightpie,
                            borderColor: 'rgba(200, 200, 200, 0.75)',
                            backgroundColor: this.chartColors,
                            // borderColor: 'rgba(75, 192, 192, 1)',
                            // backgroundColor: ['#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0', '#9966FF'],
                            borderWidth: 1,
                        }
                    ]
                },
                options: {
                    responsive: true,
                    plugins: {
                        tooltip: {
                            callbacks: {
                                label: function(tooltipItem) {
                                    return `${tooltipItem.label}: ${tooltipItem.raw.toFixed(0)}%`;
                                }
                            }
                        },
                        datalabels: {
                            formatter: (value, context) => {
                            if (value === 0) {
                                return ''; // Hide label for zero values
                            }
                            let sum = 0;
                            let dataArr = context.chart.data.datasets[0].data;
                            dataArr.forEach(data => {
                                sum += data;
                            });
                            let percentage = (value * 100 / sum).toFixed(0) + "%";
                            return percentage;
                            },
                            color: '#fff',
                            font: {
                            weight: 'bold'
                            }
                        }
                    }
                }
            });
            const ctx3 = this.$refs.lineChart5.getContext('2d');
            this.chart5 = new Chart(ctx3, {
                type: 'pie',
                data: {
                    labels: this.labels,
                    datasets: [{
                            label: 'Obesity',
                            data: this.data_barangay_obesitypie,
                            borderColor: 'rgba(200, 200, 200, 0.75)',
                            backgroundColor: this.chartColors,
                            // borderColor: 'rgba(75, 192, 192, 1)',
                            // backgroundColor: ['#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0', '#9966FF'],
                            borderWidth: 1,
                        }
                    ]
                },
                options: {
                    responsive: true,
                    plugins: {
                        tooltip: {
                            callbacks: {
                                label: function(tooltipItem) {
                                    return `${tooltipItem.label}: ${tooltipItem.raw.toFixed(0)}%`;
                                }
                            }
                        },
                        datalabels: {
                            formatter: (value, context) => {
                            if (value === 0) {
                                return ''; // Hide label for zero values
                            }
                            let sum = 0;
                            let dataArr = context.chart.data.datasets[0].data;
                            dataArr.forEach(data => {
                                sum += data;
                            });
                            let percentage = (value * 100 / sum).toFixed(0) + "%";
                            return percentage;
                            },
                            color: '#fff',
                            font: {
                            weight: 'bold'
                            }
                        }
                    }
                }
            });
        },
        divClick(){
            var chartExist = Chart.getChart(this.chart2); // <canvas> id
            if (chartExist != undefined)  
            chartExist.destroy(); 
            var chartExist2 = Chart.getChart(this.chart3); // <canvas> id
            if (chartExist2 != undefined)  
            chartExist2.destroy(); 
            var chartExist3 = Chart.getChart(this.chart4); // <canvas> id
            if (chartExist3 != undefined)  
            chartExist3.destroy(); 
            var chartExist4 = Chart.getChart(this.chart5); // <canvas> id
            if (chartExist4 != undefined)  
            chartExist4.destroy(); 
            this.renderChartPie()
            
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
        <!-- <div class="px-3" v-if="choice === 'feeding_show'">
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
        </div> -->
        <!-- <div class="px-3" v-else-if="choice === 'bene_show'">
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
        </div> -->
        <div class="px-3">
            <!-- <div class="row">
                <div class="col-lg-12">
                    <div class="flex justify-start space-x-1">
                        <button class="btn btn-sm !bg-blue-500 text-white !rounded-b-none" v-on:click="choice = ''">Donations</button>
                        <button class="btn btn-sm !bg-blue-300 text-white hover:!bg-blue-400 !rounded-b-none" v-on:click="choice = 'feeding_show'">Feeding</button>
                        <button class="btn btn-sm !bg-blue-300 text-white hover:!bg-blue-400 !rounded-b-none" v-on:click="choice = 'bene_show'">Beneficiary</button>
                    </div>
                </div>
            </div>
            <hr class="border-blue-500 mt-0"> -->
            <!-- <div class="row">
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
            </div> -->
            <div class="row ">
                <div class="col-lg-7">
                    <div class="card">
                        <div class="card-body">
                            Children Health Status (BMI) Across {{counts}} Barangay
                            <canvas ref="lineChart"></canvas>
                        </div>
                    </div>
                </div>
                <div class="col-lg-5" v-if="choice === 'underweight'">
                    <div class="flex justify-start space-x-1">
                        <button class="btn btn-sm !bg-blue-300 text-white hover:!bg-blue-400 !rounded-b-none" v-on:click.capture="choice=''" @click="divClick()">Normal</button>
                        <button class="btn btn-sm !bg-blue-500 text-white !rounded-b-none" v-on:click.capture="choice='underweight'" @click="divClick()">Underweight</button>
                        <button class="btn btn-sm !bg-blue-300 text-white hover:!bg-blue-400 !rounded-b-none" v-on:click.capture="choice='overweight'" @click="divClick()">Overweight</button>
                        <button class="btn btn-sm !bg-blue-300 text-white hover:!bg-blue-400 !rounded-b-none" v-on:click.capture="choice='obesity'" @click="divClick()">Obesity</button>
                    </div>
                    <div class="card" >
                        <div class="card-body">
                            Silay City Children's Health Status Pie Graph (Underweight)
                            <canvas ref="lineChart2" hidden></canvas>
                            <canvas ref="lineChart3"></canvas>
                            <canvas ref="lineChart4" hidden></canvas>
                            <canvas ref="lineChart5" hidden></canvas>
                        </div>
                    </div>
                </div>
                <div class="col-lg-5" v-else-if="choice === 'overweight'">
                    <div class="flex justify-start space-x-1">
                        <button class="btn btn-sm !bg-blue-300 text-white hover:!bg-blue-400 !rounded-b-none" v-on:click.capture="choice=''" @click="divClick()">Normal</button>
                        <button class="btn btn-sm !bg-blue-300 text-white hover:!bg-blue-400 !rounded-b-none" v-on:click.capture="choice='underweight'" @click="divClick()">Underweight</button>
                        <button class="btn btn-sm !bg-blue-500 text-white !rounded-b-none" v-on:click.capture="choice='overweight'" @click="divClick()">Overweight</button>
                        <button class="btn btn-sm !bg-blue-300 text-white hover:!bg-blue-400 !rounded-b-none" v-on:click.capture="choice='obesity'" @click="divClick()">Obesity</button>
                    </div>
                    <div class="card" >
                        <div class="card-body">
                            Silay City Children's Health Status Pie Graph (Overweight)
                            <canvas ref="lineChart2" hidden></canvas>
                            <canvas ref="lineChart3" hidden></canvas>
                            <canvas ref="lineChart4" ></canvas>
                            <canvas ref="lineChart5" hidden></canvas>
                        </div>
                    </div>
                </div>
                <div class="col-lg-5" v-else-if="choice === 'obesity'">
                    <div class="flex justify-start space-x-1">
                        <button class="btn btn-sm !bg-blue-300 text-white hover:!bg-blue-400 !rounded-b-none" v-on:click.capture="choice=''" @click="divClick()">Normal</button>
                        <button class="btn btn-sm !bg-blue-300 text-white hover:!bg-blue-400 !rounded-b-none" v-on:click.capture="choice='underweight'" @click="divClick()">Underweight</button>
                        <button class="btn btn-sm !bg-blue-300 text-white hover:!bg-blue-400 !rounded-b-none" v-on:click.capture="choice='overweight'" @click="divClick()">Overweight</button>
                        <button class="btn btn-sm !bg-blue-500 text-white !rounded-b-none" v-on:click.capture="choice='obesity'" @click="divClick()">Obesity</button>
                    </div>
                    <div class="card" >
                        <div class="card-body">
                            Silay City Children's Health Status Pie Graph (Obesity)
                            <canvas ref="lineChart2" hidden></canvas>
                            <canvas ref="lineChart3" hidden></canvas>
                            <canvas ref="lineChart4" hidden></canvas>
                            <canvas ref="lineChart5"></canvas>
                        </div>
                    </div>
                </div>
                <div class="col-lg-5" v-else>
                    <div class="flex justify-start space-x-1">
                        <button class="btn btn-sm !bg-blue-500 text-white !rounded-b-none" v-on:click.capture="choice=''" @click="divClick()">Normal</button>
                        <button type="button" class="btn btn-sm !bg-blue-300 text-white hover:!bg-blue-400 !rounded-b-none" v-on:click.capture="choice='underweight'" @click="divClick()">Underweight</button>
                        <!-- <button class="btn btn-sm !bg-blue-300 text-white hover:!bg-blue-400 !rounded-b-none" v-on:click="choice = 'underweight'">Underweight</button> -->
                        <button class="btn btn-sm !bg-blue-300 text-white hover:!bg-blue-400 !rounded-b-none" v-on:click.capture="choice='overweight'" @click="divClick()">Overweight</button>
                        <button class="btn btn-sm !bg-blue-300 text-white hover:!bg-blue-400 !rounded-b-none" v-on:click.capture="choice='obesity'" @click="divClick()">Obesity</button>
                    </div>
                    <div class="card" >
                        <div class="card-body">
                            Silay City Children's Health Status Pie Graph (Normal)
                            <canvas ref="lineChart2"></canvas>
                            <canvas ref="lineChart3" hidden></canvas>
                            <canvas ref="lineChart4" hidden></canvas>
                            <canvas ref="lineChart5" hidden></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
	</navigation>
</template>