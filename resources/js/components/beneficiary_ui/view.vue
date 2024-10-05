<script setup>
	import navigation from '@/layouts/navigation_bene.vue';
	import{Bars3Icon, PlusIcon, XMarkIcon,CheckIcon} from '@heroicons/vue/24/solid'
    import { reactive, ref, onMounted } from "vue"
    import { useRouter } from "vue-router"
	import moment from 'moment'
	//Beneficiary ID
	const props = defineProps({
        id:{
            type:String,
            default:''
        }
    })
	let bmi_list=ref([]);
	let beneficiary=ref([]);
	let beneficiary_joinhistoryuser=ref([]);
	let beneficiary_joinhistorybmi=ref([]);
	let item_no=ref();
	let height=ref('');
	let weight=ref('');
	let bmi=ref('');
	let bmi_date=ref('');
	let error = ref([])
	let error_items = ref([]);
	let success = ref('')	
	let nutritional_status=ref('');
	const dangerAlert = ref(false)
	const dangerAlert_item = ref(false)
	const successAlert = ref(false)
	const warningAlert = ref(false)
    const infoAlert = ref(false)
	const hideAlert = ref(true)
	//Datatable Package
    import DataTable from 'datatables.net-vue3';
    import DataTablesCore from 'datatables.net-bs5';
	import 'datatables.net-responsive';
	import 'datatables.net-select';
	import 'datatables.net-buttons';
	import 'datatables.net-buttons/js/buttons.html5';
	import 'datatables.net-buttons/js/buttons.print.js';
	import jszip from 'jszip';
	import $ from 'jquery'
	//Fetcher of Data
	onMounted(async () => {
		getBeneficiary()
	})
	//Get data from database
	const getBeneficiary = async () => {
		let response = await axios.get(`/api/get_bmi`)
		beneficiary.value = response.data.beneficiaryfirst
		// beneficiary_joinhistoryuser.value = response.data.beneficiary_joinhistoryuser
		// beneficiary_joinhistorybmi.value = response.data.beneficiary_joinhistorybmi
	}

	//Datatable Initialization
	DataTablesCore.Buttons.jszip(jszip);
    DataTable.use(DataTablesCore);
	//Buttons of Export excel, copy, and print of data from datatable
    const options = {
		// dom: 'Bftip',
		dom: "<'row'<'col-sm-8 col-lg-8 mb-2 pr-0 flex justify-end'B ><'col-sm-4 col-lg-4 mb-2 pl-1'f>>"+"<'row'<'col-sm-12 mb-2'tr>>"+"<'row'<'col-sm-6 mb-2'i><'col-sm-6 mb-2'p>>",
		select: true,	
		lengthMenu: [
			[10, 25, 50, -1],
			['10 rows', '25 rows', '50 rows', 'Show all']
		],
		buttons: [
			{
				title:'Donations',
				extend: 'copy',
				exportOptions: {
					columns: [ 0, 1, 2, 3, 4, 5 ],
					orthogonal: null
				}
			},
			{
				title:'Donations',
				extend: 'excel',
				exportOptions: {
                    columns: [ 0, 1, 2, 3, 4, 5 ],
					orthogonal: null,
				},
				createEmptyCells: true,
                customize: function(xlsx) {
                    var sheet = xlsx.xl.worksheets['sheet1.xml'];
                    var clRow = $('row', sheet);
                    clRow[0].children[0].remove(); // clear header cell
                    $( 'row c', sheet ).attr( 's', '25' );
                }
			},
			{
				title:'Donations',
				extend: 'print',
				exportOptions: {
					columns: [ 0, 1, 2, 3, 4, 5 ],
					orthogonal: null
				}
			},
			{
				extend: 'pageLength'
			}
		]
	};

	const opendangerAlert = () => {
		dangerAlert.value = !dangerAlert.value
	}
	const opendangerAlert_item = () => {
		dangerAlert_item.value = !dangerAlert_item.value
	}
    const openDangerAlert = () => {
		modalEdit.value = !modalEdit.value
	}
	const closeAlert = () => {
		dangerAlert.value = !hideAlert.value
		dangerAlert_item.value = !hideAlert.value
		successAlert.value = !hideAlert.value
		warningAlert.value = !hideAlert.value
	}
</script>
<template>
	<navigation>
		<div class="row">
            <div class="col-lg-12">
                <div class="flex justify-between mb-3 px-2">
                    <span class="">
                        <h3 class="card-title !text-lg m-0 uppercase font-bold text-gray-600">BMI <small>History</small></h3>
                    </span>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb !mb-0 !text-xs px-2 py-1 !bg-transparent">
                            <li class="breadcrumb-item"><a href="/dashboard">Home</a></li>
                            <li class="breadcrumb-item active"><a href="/pur_req">BMI</a></li>
                            <li class="breadcrumb-item active" aria-current="page">View</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
		<div class="row">
			<div class="col-12 grid-margin stretch-card">
				<div class="card">
					<div class="card-body">
						<hr class="border-dashed mt-0">
						<div class="pt-1">
							<!-- <div class="row">
								<div class="col-lg-6">
									<span class="text-sm text-gray-700 font-bold pr-1">Name: </span>
									<span class="text-sm text-gray-700">{{beneficiary.name}}</span>
								</div>
								<div class="col-lg-6">
									<span class="text-sm text-gray-700 font-bold pr-1">Gender: </span>
									<span class="text-sm text-gray-700">{{beneficiary.gender}}</span>
								</div>
							</div>
							<div class="row">
								<div class="col-lg-6">
									<span class="text-sm text-gray-700 font-bold pr-1">Barangay: </span>
									<span class="text-sm text-gray-700">{{beneficiary.barangay}}</span>
								</div>
								<div class="col-lg-6">
									<span class="text-sm text-gray-700 font-bold pr-1">Address: </span>
									<span class="text-sm text-gray-700">{{beneficiary.address}}</span>
								</div>
							</div>

							<div class="row">
								<div class="col-lg-6">
									<span class="text-sm text-gray-700 font-bold pr-1">Grade Level: </span>
									<span class="text-sm text-gray-700">{{beneficiary.grade_level}}</span>
								</div>
								<div class="col-lg-4">
									<span class="text-sm text-gray-700 font-bold pr-1">Email Address: </span>
									<span class="text-sm text-gray-700">{{beneficiary.email}}</span>
								</div>
							</div> -->
							<div class="row">
								<div class="col-lg-12 pt-3">
									<DataTable :data="beneficiary" :options="options" class="display table table-bordered table-hover !border nowrap">
										<thead>
											<tr class="bg-gray-100">
												<th class="!text-xs bg-gray-100 uppercase text-center" width="15%">Date</th>
												<th class="!text-xs bg-gray-100 uppercase text-center" width="15%">Height</th>
												<th class="!text-xs bg-gray-100 uppercase text-center" width="15%">Weight</th>
												<th class="!text-xs bg-gray-100 uppercase text-center" width="20%">BMI</th>
												<th class="!text-xs bg-gray-100 uppercase text-center" width="">Nutritional Status</th>
											</tr>
										</thead>
									</DataTable>
									<!-- <table class="w-full table-bordered !text-xs mt-3">
										<tr class="bg-gray-100">
											<td class="p-1 uppercase text-center" width="5%">#</td>
											<td class="p-1 uppercase text-center" width="15%">Date</td>
											<td class="p-1 uppercase text-center" width="15%">Height</td>
											<td class="p-1 uppercase text-center" width="15%">Weight</td>
											<td class="p-1 uppercase text-center" width="20%">BMI</td>
											<td class="p-1 uppercase text-center" width="">Nutritional Status</td>
										</tr>
										<tr v-for="(b,indexes) in beneficiary_joinhistoryuser">
											<td class="p-1 text-center">{{ indexes + 1 }}</td>
											<td class="p-1 text-center">{{ moment(b.created_at).format("YYYY-MM-DD") }}</td>
											<td class="p-1 text-center">{{ b.height }}</td>
											<td class="p-1 text-center">{{ b.weight }}</td>
											<td class="p-1 text-center">{{ b.bmi }}</td>
											<td class="p-1 text-center">{{ b.nutritional_status }}</td>
										</tr>
										<tr v-for="(bs,indexesr) in beneficiary_joinhistorybmi">
											<td class="p-1 text-center">{{ indexesr + 1 + beneficiary_joinhistoryuser.length }}</td>
											<td class="p-1 text-center">{{ moment(bs.bmi_date).format("YYYY-MM-DD") }}</td>
											<td class="p-1 text-center">{{ bs.height }}</td>
											<td class="p-1 text-center">{{ bs.weight }}</td>
											<td class="p-1 text-center">{{ bs.bmi }}</td>
											<td class="p-1 text-center">{{ bs.nutritional_status }}</td>
										</tr>
									</table> -->
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!-- SUCCESS ALERT MODAL -->
		<Transition
            enter-active-class="transition ease-out !duration-1000"
            enter-from-class="opacity-0 scale-95"
            enter-to-class="opacity-100 scale-500"
            leave-active-class="transition ease-in duration-75"
            leave-from-class="opacity-100 scale-500"
            leave-to-class="opacity-0 scale-95"
			v-if="success!=''"
        >
			<div class="modal p-0 !bg-transparent" :class="{ show:successAlert }">
				<div @click="closeAlert" class="w-full h-full fixed backdrop-blur-sm bg-white/30"></div>
				<div class="modal__content !shadow-2xl !rounded-3xl !my-44 w-96 p-0">
					<div class="flex justify-center">
						<div class="!border-green-500 border-8 bg-green-500 !h-32 !w-32 -top-16 absolute rounded-full text-center shadow">
							<div class="p-2 text-white">
								<CheckIcon fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-24 h-24 "></CheckIcon>
							</div>
						</div>
					</div>
					<div class="py-5 rounded-t-3xl"></div>
					<div class="modal_s_items pt-0 !px-8 pb-4">
						<div class="row">
							<div class="col-lg-12 col-md-3">
								<div class="text-center">
									<h2 class="mb-2  font-bold text-green-400">Success!</h2>
									<h5 class="leading-tight">{{ success }}</h5>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</Transition>
		<!-- ERROR ALERT MODAL -->
		<Transition
            enter-active-class="transition ease-out !duration-1000"
            enter-from-class="opacity-0 scale-95"
            enter-to-class="opacity-100 scale-500"
            leave-active-class="transition ease-in duration-75"
            leave-from-class="opacity-100 scale-500"
            leave-to-class="opacity-0 scale-95"
			v-if="error!=''"
        >
			<div class="modal p-0 !bg-transparent" :class="{ show:warningAlert }">
				<div @click="closeAlert" class="w-full h-full fixed backdrop-blur-sm bg-white/30"></div>
				<div class="modal__content !shadow-2xl !rounded-3xl !my-44 w-96 p-0">
					<div class="flex justify-center">
						<div class="!border-red-400 border-8 bg-red-400 !h-32 !w-32 -top-16 absolute rounded-full text-center shadow">
							<div class="p-2 text-white">
								<CheckIcon fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-24 h-24 "></CheckIcon>
							</div>
						</div>
					</div>
					<div class="py-5 rounded-t-3xl"></div>
					<div class="modal_s_items pt-0 !px-8 pb-4">
						<div class="row">
							<div class="col-lg-12 col-md-3">
								<div class="text-center">
									<h2 class="mb-2  font-bold text-red-400">Error!</h2>
									<h5 class="leading-tight" v-for="er in error_items">{{ er }}</h5>
								</div>
							</div>
						</div>
						<br>
						<div class="row mt-4"> 
							<div class="col-lg-12 col-md-12">
								<div class="flex justify-center space-x-2">
									<button @click="closeAlert" class="btn !text-white !bg-red-400 btn-sm !rounded-full w-full">Close</button>
								</div>
							</div>
						</div>
					</div> 
				</div>
			</div>
		</Transition>
	</navigation>
</template>