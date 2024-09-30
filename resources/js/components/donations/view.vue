<script setup>
	import navigation from '@/layouts/navigation_bene.vue';
	import{ Bars3Icon, PencilIcon, MagnifyingGlassIcon, TrashIcon, EyeIcon, CheckIcon, PlusIcon, XMarkIcon} from '@heroicons/vue/24/solid'
	import{ArrowUpOnSquareIcon} from '@heroicons/vue/24/outline'
    import { reactive, ref, onMounted} from "vue"
    import { useRouter } from "vue-router"
    let form=ref([]);
    let events=ref([]);
	let donations=ref([]);
	let error = ref([])
    let success = ref('')	
    let credentials = ref([])
    let media=ref([]);
    const warningAlert = ref(false)
	const successAlert = ref(false)
	const hideAlert = ref(true)
    //Fetcher of Data
	onMounted(async () => {
		getCredentials()
        donationForm()
        getEvents()
	})

    //Get fullname and donors ID
    const getCredentials = async () => {
		const response = await fetch(`/api/donor_credentials`);
		credentials.value = await response.json();
	}

    //Declaration of input values
	const donationForm = async () => {
		let response = await axios.get("/api/create_donation");
		form.value = response.data;
	}
    //Fetching events data
	const getEvents = async () => {
		let response = await axios.get("/api/get_events_donation");
		events.value = response.data.events;
	}
    //Fetch Image value
    const changeMedia = (event) =>{
        media.value = event
    }
    //Toggle Textbox if pickup is clicked
    const toggleTextbox = () => {
        var targetDiv = document.getElementById("showpickup");
        if (targetDiv.style.display !== "none") {
            targetDiv.style.display = "none";
        } else {
            targetDiv.style.display = "block";
        }
    }
    const untoggleTextbox = () => {
        var targetDiv = document.getElementById("showpickup");
        targetDiv.style.display = "none";
    }
    //Insert Function
	const onSave = () => {
       
		const formData=new FormData()
		formData.append('donor_id',credentials.value.donor_id)
		formData.append('event_id',form.value.event_id)
		formData.append('when_date',form.value.when_date)
		formData.append('when_time',form.value.when_time)
		formData.append('barangay',form.value.barangay)
		formData.append('donation_type',form.value.donation_type)
		formData.append('mode_of_collection',form.value.mode_of_collection)
		formData.append('pickup_description',form.value.pickup_description)
		formData.append('images',JSON.stringify(media.value))
		axios.post("/api/add_donation",formData).then(function (response) {
            // console.log(response.data)
			success.value='Thank you for your Generous DONATION!'
			form.value=[]
			error.value=[]
			successAlert.value = !successAlert.value
			setTimeout(() => {
				window.location.reload()
			}, 2000);
		}).catch(function(err){
			warningAlert.value = !warningAlert.value
			error.value='Fields cannot be empty!'
		});
	}

    //Fetch event address
    const getAddress = async () => {
		let response = await axios.get(`/api/get_event_address/`+form.value.event_id);
		form.value.barangay = response.data;
	}
    //Modal Popup Variables and Function
    const modalNew = ref(false)
    const modalEdit = ref(false)
	const hideModal = ref(true)
	const openNew = () => {
		modalNew.value = !modalNew.value
	}
    const openEdit = async (id) => {
		let response =  await axios.get(`/api/edit_event/`+id);
		events.value=response.data.events
		modalEdit.value = !modalEdit.value
	}
	const closeModal = () => {
		modalNew.value = !hideModal.value
		modalEdit.value = !hideModal.value
	}

	const closeAlert = () => {
		warningAlert.value = !hideAlert.value
		successAlert.value= !hideAlert.value
	}  
    
    //Multiple image append
    let image_list=ref([]);
	let image=ref("");
	const addRowImage= () => {
        const terms = {
            image:image.value,
        }
        image_list.value.push(terms)
        image.value='';
	}
	const removeImage = (index) => {
		image_list.value.splice(index,1)
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
                                    <p class="text-lg font-bold w-full text-gray-700">Donations</p>
                                    <p class="text-sm ">Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source. Lorem Ipsum comes from sections 1.10.32 and 1.10.33 of "de Finibus Bonorum et Malorum" (The Extremes of Good and Evil) by Cicero, written in 45 BC. This book is a treatise on the theory of ethics, very popular during the Renaissance. The first line of Lorem Ipsum, "Lorem ipsum dolor sit amet..", comes from a line in section 1.10.32..</p>
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <p class="text-base font-bold w-full text-gray-600 mb-0.5">What</p>
                                    <p class="text-sm ">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-lg-4">
                                <p class="text-base font-bold w-full text-gray-600 mb-0.5">When</p>
                                <p class="text-sm ">June 20, 2020 | 9:00 am</p>
                            </div>
                            <div class="col-lg-4">
                                <p class="text-base font-bold w-full text-gray-600 mb-0.5">Type of Donation</p>
                                <p class="text-sm ">Dry Goods</p>
                            </div>
                            <div class="col-lg-4">
                                <p class="text-base font-bold w-full text-gray-600 mb-0.5">Mode of Collection</p>
                                <p class="text-sm ">Pickup</p>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <p class="text-base font-bold w-full text-gray-600 mb-0.5">Address</p>
                                    <p class="text-sm ">Purok 2, Barangay Quatro, Bacolod City, Negros Occidental</p>
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <p class="text-base font-bold w-full text-gray-600 mb-0.5">Attachments</p>
                                    <div class="p-1 sm:p-8">
									<div class="columns-1 gap-2 sm:columns-2 sm:gap-2 md:columns-3 lg:columns-4 [&>img:not(:first-child)]:mt-2" >
										<div >
											<img class="mb-2 border border-gray-100" src="../../../images/bg-orange_1.jpg"/>
											<img class="mb-2 border border-gray-100" src="../../../images/bg-orange_2.jpg"/>
											<img class="mb-2 border border-gray-100" src="../../../images/bg-orange_5.jpg"/>
											<img class="mb-2 border border-gray-100" src="../../../images/bg-orange_3.jpg"/>
											<img class="mb-2 border border-gray-100" src="../../../images/bg-orange_4.jpg"/>
										</div>
										
									</div>
								</div>
                                </div>
                            </div>
                        </div>
                        <hr class="border-dashed">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="flex justify-center space-x-2">
                                    <button class="btn btn-danger btn-md w-38">Decline Donation</button>
                                    <button class="btn btn-success btn-md w-38">Accept Donation</button>
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
						<div class="!border-green-500 border-8 bg-green-500 !h-32 !w-32 -top-16 absolute rounded-full  shadow">
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