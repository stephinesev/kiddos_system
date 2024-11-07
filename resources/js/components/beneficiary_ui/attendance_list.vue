<script setup>
	import navigation from '@/layouts/navigation_bene.vue';
	import{ Bars3Icon, PencilIcon, MagnifyingGlassIcon, TrashIcon, EyeIcon, XMarkIcon} from '@heroicons/vue/24/solid'
	import{ArrowUpOnSquareIcon} from '@heroicons/vue/24/outline'
    import { reactive, ref, onMounted} from "vue"
    import { useRouter } from "vue-router"
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
    import moment from 'moment'
    //Variables
    let attendanceall=ref([]);
    let donation_images=ref([]);
    const modalImage = ref(false)
    const hideModal = ref(true)
    //Fetcher of Data
	onMounted(async () => {
        allAttendance()
	})
    //Fetching Data From Attendance Table for display
	const allAttendance = async () => {
		let response = await axios.get("/api/get_attendance");
		attendanceall.value = response.data.attendanceall;
	}
    const closeModal = () => {
		modalImage.value = !hideModal.value
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
				title:'Attendance',
				extend: 'copy',
				exportOptions: {
					columns: [ 0, 1 ],
					orthogonal: null
				}
			},
			{
				title:'Attendance',
				extend: 'excel',
				exportOptions: {
                    columns: [ 0, 1 ],
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
				title:'Attendance',
				extend: 'print',
				exportOptions: {
					columns: [ 0, 1 ],
					orthogonal: null
				}
			},
			{
				extend: 'pageLength'
			}
		]
	};
</script>
<template>
	<navigation>
        <div class="row">
            <div class="col-lg-12">
                <div class="flex justify-between mb-3 px-2">
                    <span class="">
                        <h3 class="card-title !text-lg m-0 uppercase font-bold text-gray-600">Attendance <small>List</small></h3>
                    </span>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb !mb-0 !text-xs px-2 py-1 !bg-transparent">
                            <li class="breadcrumb-item"><a href="/donor_dashboard">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Attendance</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
		<div class="row">
            <div class="col-lg-12 stretch-card">
                <div class="card">
                    <div class="card-body">
						<!-- DATATABLE -->
                        <div class="pt-3">
                            <DataTable :data="attendanceall" :options="options" class="display table table-bordered table-hover !border nowrap">
                                <thead>
                                    <tr>
                                        <th class="!text-xs bg-gray-100 uppercase text-center"> #</th>
                                        <th class="!text-xs bg-gray-100 uppercase text-center">Attendance Date</th>
                                    </tr>
                                </thead>
                            </DataTable>
                        </div>
                    </div>
                </div>
            </div>
        </div>
	</navigation>
</template>