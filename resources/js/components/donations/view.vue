<script setup>
	import navigation from '@/layouts/navigation.vue';
	import{ Bars3Icon, PencilIcon, MagnifyingGlassIcon, TrashIcon, EyeIcon, CheckIcon, PlusIcon, XMarkIcon} from '@heroicons/vue/24/solid'
	import{ArrowUpOnSquareIcon} from '@heroicons/vue/24/outline'
    import { reactive, ref, onMounted, shallowReactive} from "vue"
    import { useRouter } from "vue-router"
	const router = useRouter();
	import moment from 'moment'
	import {
		VueFlux,
		FluxCaption,
		FluxControls,
		FluxIndex,
		FluxPagination,
		FluxPreloader,
		Img,
		Book,
		Zip,
	} from 'vue-flux';
	import 'vue-flux/style.css';

	const $vueFlux = ref();

	const vfOptions = shallowReactive({
		autoplay: true,
	});

	const vfRscs = shallowReactive([
		new Img('../../../storage/images/6703ed13122a3_31-316257_sprite-sheet-bird-png.png'),
		new Img('../../../storage/images/6703ee7f04d4a_adult-black-and-white-body-590496.jpg'),
		// new Img('URL2', 'img 2'),
		// new Img('URL3', 'img 3'),
	]);

	const vfTransitions = shallowReactive([Book, Zip]);
    let form=ref([]);
    let events=ref([]);
	let donations=ref([]);
	let error = ref([])
    let success = ref('')	
    let credentials = ref([])
    let media=ref([]);
    let donation_images=ref([]);
    const warningAlert = ref(false)
	const successAlert = ref(false)
	const hideAlert = ref(true)
	//Donation ID
	const props = defineProps({
		donation_id:{
            type:String,
            default:''
        }
    })
    //Fetcher of Data
	onMounted(async () => {
		getCredentials()
        getDonations()
        getImages()
	})

    //Get fullname and donors ID
    const getCredentials = async () => {
		const response = await fetch(`/api/dashboard`);
		credentials.value = await response.json();
	}

    //Fetching Donations data
	const getDonations = async () => {
		let response =  await axios.get(`/api/get_donation_view/${props.donation_id}`);
		donations.value=response.data.donations
		events.value=response.data.donations.events
	}
    //Fetching Donation Images data
	const getImages = async () => {
		let response =  await axios.get(`/api/get_images/${props.donation_id}`);
		donation_images.value=response.data.images
	}
    //Accept function
	const acceptDonation = (id) => {
		var confirmation = confirm("Do you want to accept this donation?");
		if (confirmation == true) {
			axios.get(`/api/accept_donation/`+id).then(function () {
				success.value='Successfully accepted donation!'
				error.value=[]
				// getDonations()
				successAlert.value = !successAlert.value
				setTimeout(() => {
					// getDonations()
					closeAlert()
					router.push('/donation_admin_view')
				}, 2000);
			}).catch(function(err){
				success.value=''
				error.value.push('Error! Try again.')
			});
		}
	}
	//Decline function
	const declineDonation = (id) => {
		var confirmation = confirm("Do you want to decline this donation?");
		if (confirmation == true) {
			axios.get(`/api/decline_donation/`+id).then(function () {
				success.value='Successfully declined donation!'
				error.value=[]
				// getDonations()
				successAlert.value = !successAlert.value
				setTimeout(() => {
					// getDonations()
					closeAlert()
					router.push('/donation_admin_view')
				}, 2000);
			}).catch(function(err){
				success.value=''
				error.value.push('Error! Try again.')
			});
		}
	}
    //Modal Popup Variables and Function
	const hideModal = ref(true)
	const closeModal = () => {
		modalNew.value = !hideModal.value
		modalEdit.value = !hideModal.value
	}

	const closeAlert = () => {
		warningAlert.value = !hideAlert.value
		successAlert.value= !hideAlert.value
	}  
</script>
<template>
	<navigation>
        <div class="row">
            <div class="col-lg-12">
                <div class="flex justify-between mb-3 px-2">
                    <span class="">
                        <h3 class="card-title !text-lg m-0 uppercase font-bold text-gray-600">Donation History <small>View</small></h3>
                    </span>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb !mb-0 !text-xs px-2 py-1 !bg-transparent">
                            <li class="breadcrumb-item"><a href="/donor_dashboard">Home</a></li>
                            <li class="breadcrumb-item active"><a href="/donor_dashboard">Donation History</a></li>
                            <li class="breadcrumb-item active" aria-current="page">View</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
		<div class="row">
            <div class="col-lg-12 stretch-card">
                <div class="card">
                    <div class="card-body !px-20 !py-10">
						<div class="row">
                            <div class="col-lg-12">
                                <div class="">
                                    <p class="text-lg font-bold w-full text-gray-700 mb-0">Event Description</p>
                                    <p class="text-sm ">{{ events.event_description}}</p>
                                </div>
                            </div>
                        </div>
                        <br>
						<div class="row">
							<div class="col-lg-12">
								<table class="w-full">
									<tr>
										<td class="text-sm" width="65%">What</td>
										<td class="text-sm" width="35%">Type of Donation</td>
										
									</tr>
									<tr>
										<td class="!text-gray-700">{{events.event_name}}</td>
										<td class="!text-gray-700">{{donations.donation_type}}</td>
									</tr>
									<tr>
										<td colspan="2" class="pt-2"></td>
									</tr>
									<tr>
										<td class="text-sm">When</td>
										<td class="text-sm">Mode of Collection</td>
									</tr>
									
									<tr>
										<td class="!text-gray-700">{{ moment(events.start_date).format("MMM. DD, YYYY") }} | {{moment(events.start_date+' '+events.event_time).format('h:mm A')}}</td>
										<td class="!text-gray-700">
											{{donations.mode_of_collection}}
											<div class="flex" v-if="donations.mode_of_collection=='Pick Up'">
												<span>Pick-up Location:{{donations.pickup_description}}</span>
												<span>Contact Number:{{donations.pickup_contact_no}}</span>
											</div>
										</td>
									</tr>
									<tr>
										<td colspan="2" class="pt-2"></td>
									</tr>
									<tr>
										<td class="text-sm">Barangay</td>
									</tr>
									<tr>
										<td class="!text-gray-700">{{ events.event_address}}</td>
									</tr>
								</table>
								<br>
								<!-- <table class="w-full">
									<tr>
										<td width="5%">What</td>
										<td width="60%">:{{events.event_name}}</td>
										<td width="15%">Type of Donation</td>
										<td width="20%">:{{donations.donation_type}}</td>
									</tr>
									<tr>
										<td>When</td>
										<td>:{{ moment(events.start_date).format("MMM. DD, YYYY") }} | {{moment(events.start_date+' '+events.event_time).format('h:mm A')}}</td>
										
										<td>Mode of Collection</td>
										<td>
											:{{donations.mode_of_collection}}
											<div class="flex" v-if="donations.mode_of_collection=='Pick Up'">
												<span>Pick-up Location:{{donations.pickup_description}}</span>
												<span>Contact Number:{{donations.pickup_contact_no}}</span>
											</div>
										</td>
									</tr>
								</table> -->
							</div>
						</div>
						<hr class="border-dashed">
                        <!-- <div class="row">
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <p class="text-base font-bold w-full text-gray-600 mb-0.5">What</p>
                                    <p class="text-sm ">{{events.event_name}}</p>
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-lg-4">
                                <p class="text-base font-bold w-full text-gray-600 mb-0.5">When</p>
                                <p class="text-sm ">{{ moment(events.start_date).format("MMM. DD, YYYY") }} | {{moment(events.start_date+' '+events.event_time).format('h:mm A')}}</p>
                            </div>
                            <div class="col-lg-4">
                                <p class="text-base font-bold w-full text-gray-600 mb-0.5">Type of Donation</p>
                                <p class="text-sm ">{{donations.donation_type}}</p>
                            </div>
                            <div class="col-lg-4">
                                <p class="text-base font-bold w-full text-gray-600 mb-0.5">Mode of Collection</p>
                                <p class="text-sm ">{{donations.mode_of_collection}}</p>
                                <div class="row" v-if="donations.mode_of_collection=='Pick Up'">
									<div class="col-lg-6">
										<p class="text-base font-bold w-full text-gray-600">Pick-up Location:</p>
										<p class="text-sm ">{{donations.pickup_description}}</p>
									</div>
									<div class="col-lg-6">
										<p class="text-base font-bold w-full text-gray-600">Contact Number:</p>
										<p class="text-sm ">{{donations.pickup_contact_no}}</p>
									</div>
								</div>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <p class="text-base font-bold w-full text-gray-600 mb-0.5">Barangay</p>
                                    <p class="text-sm ">{{ events.event_address}}</p>
                                </div>
                            </div>
                        </div>
                        <br> -->
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <p class="text-base font-bold w-full text-gray-600 mb-0.5">Attachments</p>
                                    <div class="p-1 sm:p-8">
									<div class="columns-1 gap-2 sm:columns-2 sm:gap-2 md:columns-3 lg:columns-4 [&>img:not(:first-child)]:mt-2" >
										<div v-for="i in donation_images">
											<img class="mb-2 border border-gray-100" :src="'../../../storage/images/'+i.image_name"/>
										</div>
										<!-- <VueFlux
											:options="vfOptions"
											:rscs="vfRscs"
											:transitions="vfTransitions"
											ref="$vueFlux">

											<template #preloader="preloaderProps">
												<FluxPreloader v-bind="preloaderProps" />
											</template>

											<template #caption="captionProps">
												<FluxCaption v-bind="captionProps" />
											</template>

											<template #controls="controlsProps">
												<FluxControls v-bind="controlsProps" />
											</template>

											<template #pagination="paginationProps">
												<FluxPagination v-bind="paginationProps" />
											</template>

											<template #index="indexProps">
												<FluxIndex v-bind="indexProps" />
											</template>
										</VueFlux>
										<button @click="$vueFlux.show('next')">NEXT</button> -->
									</div>
								</div>
                                </div>
                            </div>
                        </div>
                        <div v-if="donations.status==0">
							<hr class="border-dashed">
							<div class="row">
								<div class="col-lg-12">
									<div class="flex justify-center space-x-2">
										<button class="btn btn-danger btn-md w-38" @click="declineDonation(props.donation_id)">Decline Donation</button>
										<button class="btn btn-success btn-md w-38" @click="acceptDonation(props.donation_id)">Accept Donation</button>
									</div>
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
									<h5 class="leading-tight">{{ error }}</h5>
									<!-- <h5 class="leading-tight" v-for="er in error">{{ er }}</h5> -->
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