<script setup>
	import navigation from '@/layouts/navigation_donor.vue';
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
		form.value.barangay = response.data.address;
		form.value.when_date = response.data.date;
		form.value.when_time = response.data.time;
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
                                    <!-- <input type="text" class="form-control  !text-sm"> -->
                                     <select class="form-control" @change='getAddress()' v-model="form.event_id">
                                        <option value="">--Select Event--</option>
                                        <option :value="ev.id" v-for="(ev,index) in events" :key="ev.id">{{ ev.event_name }}</option>
                                     </select>
                                </div>
                                <div class="form-group">
                                    <label for="">When</label>
                                    <div class="flex justify-between space-x-3">
                                        <input type="date" class="form-control !text-sm" v-model="form.when_date">
                                        <input type="time" class="form-control !text-sm" v-model="form.when_time">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="">Barangay</label>
                                    <input type="text" class="form-control !text-sm" v-model="form.barangay">
                                </div>
                                <div class="row mt-4">
                                    <div class="col-lg-12">
                                        <div class="form-group border-r">
                                            <div class="flex justify-start space-x-5">
                                                <span class="m-0 text-sm" for="">Type of Donation:</span>
                                                <div class="flex justify-center space-x-1">
                                                    <input type="radio" class="" name="donation_type" v-model="form.donation_type" value="Dry Goods">
                                                    <span class="text-sm">Dry Goods</span>
                                                </div>
                                                <div class="flex justify-center space-x-1 mr-3">
                                                    <input type="radio" class="" name="donation_type" v-model="form.donation_type" value="Wet Goods">
                                                    <span class="text-sm">Wet Goods</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mt-2">
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <div class="flex justify-start space-x-5">
                                                <span class="m-0 text-sm" for="">Mode of Collection:</span>
                                                <div class="flex justify-center space-x-1">
                                                    <input type="radio" @click="untoggleTextbox()" class="" name="mode_of_collection" v-model="form.mode_of_collection"  value="Self Delivery">
                                                    <span class="text-sm">Self Delivery</span>
                                                </div>
                                                <div class="flex justify-center space-x-1">
                                                    <input type="radio" @click="toggleTextbox()" class="" name="mode_of_collection" v-model="form.mode_of_collection"  value="Pick Up">
                                                    <span class="text-sm">Pick Up</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div id="showpickup" class="row mt-2" style="display:none">
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <label for="">Pick-up Address and Contact Number</label>
                                            <textarea class="form-control !text-sm" rows='4' v-model="form.pickup_description"></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="">Attachment Donation Picture</label>
                                    <div class="flex justify-start space-x-3 mt-0">
                                        <div>
                                            <Uploader 
                                                server="/api/upload_image"
                                                :is-invalid="error.media ? true : false"
                                                @change="changeMedia"
                                            />
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6">
                                
                            </div>
                            <div class="col-lg-6">
                            </div>
                        </div>
                        
                        <hr class="border-dashed">
                        <div class="row">
                            <div class="col-lg-12">
                                <center>
                                    <button type="button" @click="onSave()" class="btn btn-primary btn-lg">Donate</button>
                                </center>
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