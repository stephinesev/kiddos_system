<script setup>
	import navigation from '@/layouts/navigation_donor.vue';
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
    let donationsall=ref([]);
    let donation_images=ref([]);
    const modalImage = ref(false)
    const hideModal = ref(true)
    //Fetcher of Data
	onMounted(async () => {
        allDonations()
	})
    //Fetching Data From Donations Table for display
	const allDonations = async () => {
		let response = await axios.get("/api/get_donations");
		donationsall.value = response.data.donationsall;
	}
    //Image Modal Viewer
    const openImage = async (id) => {
		let response =  await axios.get(`/api/get_images/`+id);
		donation_images.value=response.data.images
        console.log(donation_images.value)
		modalImage.value = !modalImage.value
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
						<!-- DATATABLE -->
                        <div class="pt-3">
                            <DataTable :data="donationsall" :options="options" class="display table table-bordered table-hover !border nowrap">
                                <thead>
                                    <tr>
                                        <th class="!text-xs bg-gray-100 uppercase text-center"> Event Name</th>
                                        <th class="!text-xs bg-gray-100 uppercase text-center"> Date</th>
                                        <th class="!text-xs bg-gray-100 uppercase text-center"> Time</th>
                                        <th class="!text-xs bg-gray-100 uppercase text-center"> Barangay</th>
                                        <th class="!text-xs bg-gray-100 uppercase text-center"> Type of Donation</th>
                                        <th class="!text-xs bg-gray-100 uppercase text-center"> Mode of Collection</th>
                                        <th class="!text-xs bg-gray-100 uppercase" width="7%" align="center"> 
                                            <span class="text-center  px-auto">
                                                <Bars3Icon fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="menu-icon w-5 h-5 "></Bars3Icon>
                                            </span>
                                        </th>
                                    </tr>
                                </thead>
                                <template #column-6="props">
                                    <center>
                                        <button @click="openImage(props.rowData.id)" class="btn btn-xs btn-success text-white p-1">
                                            <EyeIcon fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="menu-icon w-3 h-3 "></EyeIcon>
                                        </button >
                                    </center>
                                </template>
                            </DataTable>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- IMAGE VIEWER MODAL -->
        <Transition
            enter-active-class="transition ease-out duration-200"
            enter-from-class="opacity-0 scale-95"
            enter-to-class="opacity-100 scale-100"
            leave-active-class="transition ease-in duration-75"
            leave-from-class="opacity-100 scale-100"
            leave-to-class="opacity-0 scale-95"
        >
			<div class="modal pt-4 px-3" :class="{ show:modalImage }">
				<div @click="closeModal" class="w-full h-full fixed"></div>
				<div class="modal__content w-8/12">
					<div class="row mb-3">
						<div class="col-lg-12 flex justify-between">
							<span class="font-bold ">Donation Images Viewer</span>
							<a href="#" class="text-gray-600" @click="closeModal">
								<XMarkIcon fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4"></XMarkIcon>
							</a>
						</div>
					</div>
					<hr class="mt-0">
					<div class="modal_s_items ">
						<div class="row">
							<!-- <div class="col-lg-12 col-md-12"  v-for="i in donation_images">
								<div class="form-group">
                                    <img :src="'storage/images/'+i.image_name"/>
								</div>
							</div> -->

							<div class="col-lg-12 col-md-12" >
								<div class="p-1 sm:p-8">
									<div class="columns-1 gap-2 sm:columns-2 sm:gap-2 md:columns-3 lg:columns-4 [&>img:not(:first-child)]:mt-2" v-for="i in donation_images">
										<img :src="'storage/images/'+i.image_name"/>
										<!-- <img src="../../../images/bg-orange_1.jpg"/>
										<img src="../../../images/bg-orange_2.jpg"/>
										<img src="../../../images/bg-orange_3.jpg"/>
										<img src="../../../images/bg-orange_1.jpg"/>
										<img src="../../../images/bg-orange_4.jpg"/>
										<img src="../../../images/bg-orange_5.jpg"/>
										<img src="../../../images/bg-orange_4.jpg"/>
										<img src="../../../images/bg-orange_6.jpg"/>
										<img src="../../../images/bg-orange_1.jpg"/>
										<img src="../../../images/bg-orange_5.jpg"/>
										<img src="../../../images/bg-orange_1.jpg"/>
										<img src="../../../images/bg-orange_2.jpg"/>
										<img src="../../../images/bg-orange_1.jpg"/>
										<img src="../../../images/bg-orange_1.jpg"/>
										<img src="../../../images/bg-orange_1.jpg"/>
										<img src="../../../images/bg-orange_1.jpg"/> -->
									</div>
								</div>
							</div>
						</div>
					</div> 
				</div>
			</div>
		</Transition>
	</navigation>
</template>