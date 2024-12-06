<script setup>
	import navigation from '@/layouts/navigation.vue';
	import{PlusIcon, UserIcon} from '@heroicons/vue/24/solid'
    import { reactive, ref, onMounted } from "vue"
    import { useRouter } from "vue-router"
	import FullCalendar from '@fullcalendar/vue3'
	import dayGridPlugin from '@fullcalendar/daygrid'
	import interactionPlugin from '@fullcalendar/interaction'
	const router = useRouter();
	let event_data = ref([])
	let credentials = ref([])
	const choice =  ref('');
    const counts =  ref([]);
	//Fetcher of Data
	onMounted(async () => {
		getDashboard()
		getBarangayCount()
	})
    const getBarangayCount = async () => {
		let response = await axios.get(`/api/chart_barangay`)
		counts.value = response.data.labels.length
	}
	//Calendar Display of data
	var colors = ['red', 'green', 'blue', 'orange', 'yellow'];
	const calendarOptions = {
		headerToolbar: {
			left: 'prevYear,prev,next,nextYear today',
			center: 'title',
			right: 'dayGridMonth,dayGridWeek,dayGridDay'
		},
		plugins: [ dayGridPlugin, interactionPlugin ],
        initialView: 'dayGridMonth',
		// businessHours: true,
		dayMaxEvents: true, // allow "more" link when too many events
		eventColor: colors[Math.floor(Math.random() * colors.length)],
        eventSources: [
			{
				events: function(fetchInfo, successCallback, failureCallback) {
					axios.get('/api/get_dashboard_events').then(response => {
						successCallback(response.data.eventall)
					});
				},
			}
		],
	}
	const getDashboard = async () => {
		const response = await fetch(`/api/dashboard`);
		credentials.value = await response.json();
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
                    this.data_barangay_obesity2 = data.data_barangay_obesity2;
                    this.data_barangay_obesity3 = data.data_barangay_obesity3;
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
                            borderColor: 'rgba(173, 216, 230, 0.8)',
                            backgroundColor: 'rgba(173, 216, 230, 0.36)',
                            borderWidth: 1,
                        },
                        {
                            label: 'Overweight',
                            data: this.data_barangay_overweight,
							borderColor: 'rgba(247, 222, 26, 0.77)',
                            backgroundColor: 'rgba(247, 222, 26, 0.43)',
                            borderWidth: 1,
                        },
                        {
                            label: 'Obesity Class I',
                            data: this.data_barangay_obesity,
                            borderColor: 'rgba(255, 165, 0, 0.77)',
                            backgroundColor: 'rgba(255, 165, 0, 0.43)',
                            borderWidth: 1,
                        },
                        {
                            label: 'Obesity Class II',
                            data: this.data_barangay_obesity2,
                            borderColor: 'rgba(255, 69, 0, 0.77)',
                            backgroundColor: 'rgba(255, 69, 0, 0.43)',
                            borderWidth: 1,
                        },
                        {
                            label: 'Obesity Class III',
                            data: this.data_barangay_obesity3,
							borderColor: 'rgba(250, 17, 17, 0.77)',
                            backgroundColor: 'rgba(250, 17, 17, 0.34)',
                            borderWidth: 1,
                        }
                    ]
                },
                options: {
                    responsive: true,
					plugins: {
						datalabels: {
							display: false // This will hide the data labels
						}
					},
                    scales: {
                        y: {
                            beginAtZero: true,
                            title: {
                                display: true,
                                text: 'Number of Children'
                            }
                        }
                    }
                }
            });
        },
        fetchDataPie() {
            fetch('/api/chart_barangaypie')
                .then(response => response.json())
                .then(data => {
                    this.labelss = data.labels;
                    this.data_barangay_pie = data.data_barangay_pie;
                    this.data_barangay_underweightpie = data.data_barangay_underweightpie;
                    this.data_barangay_overweightpie = data.data_barangay_overweightpie;
                    this.data_barangay_obesitypie1 = data.data_barangay_obesitypie1;
                    this.data_barangay_obesitypie2 = data.data_barangay_obesitypie2;
                    this.data_barangay_obesitypie3 = data.data_barangay_obesitypie3;
                    this.renderChartPie();
                });
        },
        renderChartPie() {
            const ctx = this.$refs.lineChart2.getContext('2d');
            this.chart2 = new Chart(ctx, {
                type: 'pie',
                data: {
                    labels: this.labelss,
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
                    labels: this.labelss,
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
                    labels: this.labelss,
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
                    labels: this.labelss,
                    datasets: [{
                            label: 'Obesity Class I',
                            data: this.data_barangay_obesitypie1,
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
			const ctx4 = this.$refs.lineChart6.getContext('2d');
            this.chart6 = new Chart(ctx4, {
                type: 'pie',
                data: {
                    labels: this.labelss,
                    datasets: [{
                            label: 'Obesity Class II',
                            data: this.data_barangay_obesitypie2,
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
			const ctx5 = this.$refs.lineChart7.getContext('2d');
            this.chart7 = new Chart(ctx5, {
                type: 'pie',
                data: {
                    labels: this.labelss,
                    datasets: [{
                            label: 'Obesity Class III',
                            data: this.data_barangay_obesitypie3,
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
			var chartExist5 = Chart.getChart(this.chart6); // <canvas> id
            if (chartExist5 != undefined)  
            chartExist5.destroy(); 
			var chartExist6 = Chart.getChart(this.chart7); // <canvas> id
            if (chartExist6 != undefined)  
            chartExist6.destroy(); 
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
<style>
	#calendar {
		max-width: 1100px;
		margin: 0 auto;
	}
  	.fc-daygrid-event {
		white-space: normal !important;
		align-items: normal !important;
		font-family: Arial, Helvetica Neue, Helvetica, sans-serif;
  		font-size: 12px;
	}
</style>
<template>
	<navigation>
		<div class="row">
			<div class="col-md-12 grid-margin">
				<div class="d-flex justify-content-between flex-wrap">
					<div class="d-flex align-items-end flex-wrap">
						<div class="mr-md-3 mr-xl-5">
						<h2>Welcome back,</h2>
						<p class="mb-md-0">Your analytics dashboard template.</p>
						</div>
						<div class="d-flex">
						<i class="mdi mdi-home text-muted hover-cursor"></i>
						<p class="text-muted mb-0 hover-cursor">&nbsp;/&nbsp;Dashboard&nbsp;/&nbsp;</p>
						<p class="text-primary mb-0 hover-cursor">Analytics</p>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-md-7 grid-margin ">
				<div class="card">
					<div class="card-body dashboard-tabs p-0">
						<!-- <ul class="nav nav-tabs px-4" role="tablist">
						<li class="nav-item">
							<a class="nav-link active" id="overview-tab" data-toggle="tab" href="#overview" role="tab" aria-controls="overview" aria-selected="true">Overview</a>
						</li>
						<li class="nav-item">
							<a class="nav-link" id="sales-tab" data-toggle="tab" href="#sales" role="tab" aria-controls="sales" aria-selected="false">Sales</a>
						</li>
						<li class="nav-item">
							<a class="nav-link" id="purchases-tab" data-toggle="tab" href="#purchases" role="tab" aria-controls="purchases" aria-selected="false">Purchases</a>
						</li>
						</ul> -->

						<!-- Calendar Display  -->
						<div class="tab-content py-0 px-0">
							<div class="tab-pane fade show active" id="overview" role="tabpanel" aria-labelledby="overview-tab">
								<!-- <FullCalendar :options="calendarOptions" >
									<template #eventContent="arg">
											<template v-slot:activator="{ on, attrs }">
												<div style="min-height:20px;" v-bind="attrs" v-on="on">
												</div>
											</template>
											<div style="text-align:left;">
												<b>Event Name:</b> {{arg.event.title}}<br />
												<b>Event Time:</b> {{arg.event.extendedProps.time}}<br />
												<b>Event Description:</b> {{arg.event.extendedProps.description}}<br />
												<b>Where:</b> {{arg.event.extendedProps.address}}<br />
											</div>
									</template>
								</FullCalendar> -->
								<FullCalendar :options="calendarOptions">
									<template v-slot:eventContent='arg'>
										<div style="text-align:left;">
												<b>Event Name:</b> {{arg.event.title}}<br />
											</div>
									</template>
								</FullCalendar>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="col-md-5 grid-margin stretch-card">
				<div class="card">
					<div class="card-body dashboard-tabs p-0">
						Children Health Status (BMI) in Barangay Over 6 Months
                        <canvas ref="lineChart"></canvas>
					</div>
					<br>
					<div v-if="choice === 'underweight'">
						<div class="flex justify-start space-x-1">
							<button class="btn btn-sm !bg-blue-300 text-white hover:!bg-blue-400 !rounded-b-none" v-on:click.capture="choice=''" @click="divClick()" style="font-size: 13px;">Normal</button>
							<button class="btn btn-sm !bg-blue-500 text-white !rounded-b-none" v-on:click.capture="choice='underweight'" @click="divClick()" style="font-size: 13px;">Underweight</button>
							<button class="btn btn-sm !bg-blue-300 text-white hover:!bg-blue-400 !rounded-b-none" v-on:click.capture="choice='overweight'" @click="divClick()" style="font-size: 13px;">Overweight</button>
							<button class="btn btn-sm !bg-blue-300 text-white hover:!bg-blue-400 !rounded-b-none" v-on:click.capture="choice='obesity1'" @click="divClick()" style="font-size: 13px;">Obesity Class I</button>
							<button class="btn btn-sm !bg-blue-300 text-white hover:!bg-blue-400 !rounded-b-none" v-on:click.capture="choice='obesity2'" @click="divClick()" style="font-size: 13px;">Obesity Class II</button>
							<button class="btn btn-sm !bg-blue-300 text-white hover:!bg-blue-400 !rounded-b-none" v-on:click.capture="choice='obesity3'" @click="divClick()" style="font-size: 13px;">Obesity Class III</button>
						</div>
						<div class="card" >
							<div class="card-body">
								Silay City Children's Health Status Pie Graph (Underweight)
								<canvas ref="lineChart2" hidden></canvas>
								<canvas ref="lineChart3"></canvas>
								<canvas ref="lineChart4" hidden></canvas>
								<canvas ref="lineChart5" hidden></canvas>
								<canvas ref="lineChart6" hidden></canvas>
								<canvas ref="lineChart7" hidden></canvas>
							</div>
						</div>
					</div>
					<div v-else-if="choice === 'overweight'">
						<div class="flex justify-start space-x-1">
							<button class="btn btn-sm !bg-blue-300 text-white hover:!bg-blue-400 !rounded-b-none" v-on:click.capture="choice=''" @click="divClick()" style="font-size: 13px;">Normal</button>
							<button class="btn btn-sm !bg-blue-300 text-white hover:!bg-blue-400 !rounded-b-none" v-on:click.capture="choice='underweight'" @click="divClick()" style="font-size: 13px;">Underweight</button>
							<button class="btn btn-sm !bg-blue-500 text-white !rounded-b-none" v-on:click.capture="choice='overweight'" @click="divClick()" style="font-size: 13px;">Overweight</button>
							<button class="btn btn-sm !bg-blue-300 text-white hover:!bg-blue-400 !rounded-b-none" v-on:click.capture="choice='obesity1'" @click="divClick()" style="font-size: 13px;">Obesity Class I</button>
							<button class="btn btn-sm !bg-blue-300 text-white hover:!bg-blue-400 !rounded-b-none" v-on:click.capture="choice='obesity2'" @click="divClick()" style="font-size: 13px;">Obesity Class II</button>
							<button class="btn btn-sm !bg-blue-300 text-white hover:!bg-blue-400 !rounded-b-none" v-on:click.capture="choice='obesity3'" @click="divClick()" style="font-size: 13px;">Obesity Class III</button>
						</div>
						<div class="card" >
							<div class="card-body">
								Silay City Children's Health Status Pie Graph (Overweight)
								<canvas ref="lineChart2" hidden></canvas>
								<canvas ref="lineChart3" hidden></canvas>
								<canvas ref="lineChart4" ></canvas>
								<canvas ref="lineChart5" hidden></canvas>
								<canvas ref="lineChart6" hidden></canvas>
								<canvas ref="lineChart7" hidden></canvas>
							</div>
						</div>
					</div>
					<div v-else-if="choice === 'obesity1'">
						<div class="flex justify-start space-x-1">
							<button class="btn btn-sm !bg-blue-300 text-white hover:!bg-blue-400 !rounded-b-none" v-on:click.capture="choice=''" @click="divClick()" style="font-size: 13px;">Normal</button>
							<button class="btn btn-sm !bg-blue-300 text-white hover:!bg-blue-400 !rounded-b-none" v-on:click.capture="choice='underweight'" @click="divClick()" style="font-size: 13px;">Underweight</button>
							<button class="btn btn-sm !bg-blue-300 text-white hover:!bg-blue-400 !rounded-b-none" v-on:click.capture="choice='overweight'" @click="divClick()" style="font-size: 13px;">Overweight</button>
							<button class="btn btn-sm !bg-blue-500 text-white !rounded-b-none" v-on:click.capture="choice='obesity1'" @click="divClick()" style="font-size: 13px;">Obesity Class I</button>
							<button class="btn btn-sm !bg-blue-300 text-white hover:!bg-blue-400 !rounded-b-none" v-on:click.capture="choice='obesity2'" @click="divClick()" style="font-size: 13px;">Obesity Class II</button>
							<button class="btn btn-sm !bg-blue-300 text-white hover:!bg-blue-400 !rounded-b-none" v-on:click.capture="choice='obesity3'" @click="divClick()" style="font-size: 13px;">Obesity Class III</button>
						</div>
						<div class="card" >
							<div class="card-body">
								Silay City Children's Health Status Pie Graph (Obesity Class I)
								<canvas ref="lineChart2" hidden></canvas>
								<canvas ref="lineChart3" hidden></canvas>
								<canvas ref="lineChart4" hidden></canvas>
								<canvas ref="lineChart5"></canvas>
								<canvas ref="lineChart6" hidden></canvas>
								<canvas ref="lineChart7" hidden></canvas>
							</div>
						</div>
					</div>
					<div v-else-if="choice === 'obesity2'">
						<div class="flex justify-start space-x-1">
							<button class="btn btn-sm !bg-blue-300 text-white hover:!bg-blue-400 !rounded-b-none" v-on:click.capture="choice=''" @click="divClick()" style="font-size: 13px;">Normal</button>
							<button class="btn btn-sm !bg-blue-300 text-white hover:!bg-blue-400 !rounded-b-none" v-on:click.capture="choice='underweight'" @click="divClick()" style="font-size: 13px;">Underweight</button>
							<button class="btn btn-sm !bg-blue-300 text-white hover:!bg-blue-400 !rounded-b-none" v-on:click.capture="choice='overweight'" @click="divClick()" style="font-size: 13px;">Overweight</button>
							<button class="btn btn-sm !bg-blue-300 text-white hover:!bg-blue-400 !rounded-b-none" v-on:click.capture="choice='obesity1'" @click="divClick()" style="font-size: 13px;">Obesity Class I</button>
							<button class="btn btn-sm !bg-blue-500 text-white !rounded-b-none" v-on:click.capture="choice='obesity2'" @click="divClick()" style="font-size: 13px;">Obesity Class II</button>
							<button class="btn btn-sm !bg-blue-300 text-white hover:!bg-blue-400 !rounded-b-none" v-on:click.capture="choice='obesity3'" @click="divClick()" style="font-size: 13px;">Obesity Class III</button>
						</div>
						<div class="card" >
							<div class="card-body">
								Silay City Children's Health Status Pie Graph (Obesity Class II)
								<canvas ref="lineChart2" hidden></canvas>
								<canvas ref="lineChart3" hidden></canvas>
								<canvas ref="lineChart4" hidden></canvas>
								<canvas ref="lineChart5"hidden></canvas>
								<canvas ref="lineChart6"></canvas>
								<canvas ref="lineChart7" hidden></canvas>
							</div>
						</div>
					</div>
					<div v-else-if="choice === 'obesity3'">
						<div class="flex justify-start space-x-1">
							<button class="btn btn-sm !bg-blue-300 text-white hover:!bg-blue-400 !rounded-b-none" v-on:click.capture="choice=''" @click="divClick()" style="font-size: 13px;">Normal</button>
							<button class="btn btn-sm !bg-blue-300 text-white hover:!bg-blue-400 !rounded-b-none" v-on:click.capture="choice='underweight'" @click="divClick()" style="font-size: 13px;">Underweight</button>
							<button class="btn btn-sm !bg-blue-300 text-white hover:!bg-blue-400 !rounded-b-none" v-on:click.capture="choice='overweight'" @click="divClick()" style="font-size: 13px;">Overweight</button>
							<button class="btn btn-sm !bg-blue-300 text-white hover:!bg-blue-400 !rounded-b-none" v-on:click.capture="choice='obesity1'" @click="divClick()" style="font-size: 13px;">Obesity Class I</button>
							<button class="btn btn-sm !bg-blue-300 text-white hover:!bg-blue-400 !rounded-b-none" v-on:click.capture="choice='obesity2'" @click="divClick()" style="font-size: 13px;">Obesity Class II</button>
							<button class="btn btn-sm !bg-blue-500 text-white !rounded-b-none" v-on:click.capture="choice='obesity3'" @click="divClick()" style="font-size: 13px;">Obesity Class III</button>
						</div>
						<div class="card" >
							<div class="card-body">
								Silay City Children's Health Status Pie Graph (Obesity Class III)
								<canvas ref="lineChart2" hidden></canvas>
								<canvas ref="lineChart3" hidden></canvas>
								<canvas ref="lineChart4" hidden></canvas>
								<canvas ref="lineChart5" hidden></canvas>
								<canvas ref="lineChart6" hidden></canvas>
								<canvas ref="lineChart7"></canvas>
							</div>
						</div>
					</div>
					<div v-else>
						<div class="flex justify-start space-x-1">
							<button class="btn btn-sm !bg-blue-500 text-white !rounded-b-none" v-on:click.capture="choice=''" @click="divClick()" style="font-size: 13px;">Normal</button>
							<button type="button" class="btn btn-sm !bg-blue-300 text-white hover:!bg-blue-400 !rounded-b-none" v-on:click.capture="choice='underweight'" @click="divClick()" style="font-size: 13px;">Underweight</button>
							<button class="btn btn-sm !bg-blue-300 text-white hover:!bg-blue-400 !rounded-b-none" v-on:click.capture="choice='overweight'" @click="divClick()" style="font-size: 13px;">Overweight</button>
							<button class="btn btn-sm !bg-blue-300 text-white hover:!bg-blue-400 !rounded-b-none" v-on:click.capture="choice='obesity1'" @click="divClick()" style="font-size: 13px;">Obesity Class I</button>
							<button class="btn btn-sm !bg-blue-300 text-white hover:!bg-blue-400 !rounded-b-none" v-on:click.capture="choice='obesity2'" @click="divClick()" style="font-size: 13px;">Obesity Class II</button>
							<button class="btn btn-sm !bg-blue-300 text-white hover:!bg-blue-400 !rounded-b-none" v-on:click.capture="choice='obesity3'" @click="divClick()" style="font-size: 13px;">Obesity Class III</button>
						</div>
						<div class="card" >
							<div class="card-body">
								Silay City Children's Health Status Pie Graph (Normal)
								<canvas ref="lineChart2"></canvas>
								<canvas ref="lineChart3" hidden></canvas>
								<canvas ref="lineChart4" hidden></canvas>
								<canvas ref="lineChart5" hidden></canvas>
								<canvas ref="lineChart6" hidden></canvas>
								<canvas ref="lineChart7" hidden></canvas>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</navigation>
</template>