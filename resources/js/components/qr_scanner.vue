<script setup>
    import navigation from '@/layouts/navigation.vue';
    import{ Bars3Icon, PencilIcon, MagnifyingGlassIcon, TrashIcon, EyeIcon, CheckIcon, PlusIcon, XMarkIcon, UserIcon} from '@heroicons/vue/24/solid'
	import{ArrowUpOnSquareIcon} from '@heroicons/vue/24/outline'
    import { reactive, ref, onMounted} from "vue"
    import { useRouter } from "vue-router"
    import { QrcodeStream, QrcodeDropZone, QrcodeCapture } from "vue3-qrcode-reader"
    import moment from 'moment'
    let success = ref('')	
    let errors = ref('')	
    const redirection = ref('')	
    const beneficiary = ref([])	
    const beneficiary_id = ref('')	
	const warningAlert = ref(false)
	const successAlert = ref(false)
	const successAlert1 = ref(false)
	const hideAlert = ref(true)
    //Fetcher of Data
	onMounted(async () => {
        getData()
	})
    
    const onError = (error) => {
        if (error.name === 'NotAllowedError') {
            errors.value="user denied camera access permission"
        } else if (error.name === 'NotFoundError') {
            errors.value="no suitable camera device installed"
        } else if (error.name === 'NotSupportedError') {
            errors.value="page is not served over HTTPS (or localhost)"
        } else if (error.name === 'NotReadableError') {
            errors.value="maybe camera is already in use"
        } else if (error.name === 'OverconstrainedError') {
            errors.value="did you request the front camera although there is none?"
        } else if (error.name === 'StreamApiNotSupportedError') {
            errors.value="browser seems to be lacking features"
        }
    }
    const onDecode = async (decodedString) => {
        const myArray = decodedString.split("/");
        let id = myArray[5];
        beneficiary_id.value=id
        getData(id)
        redirection.value=decodedString
        successAlert.value=!successAlert.value
        success.value='Success'
    }

    const closeAlert = () => {
		successAlert.value= !hideAlert.value
        window.location.reload()
	}

    const closeAlert1 = () => {
		successAlert1.value= !hideAlert.value
	}
    
    const checkAttendance = (id) => {
        const formData=new FormData()
		formData.append('beneficiary_id',id)
		formData.append('attendance_date',moment().format("YYYY-MM-DD"))
        axios.post(`/api/insert_attendance/`, formData).then(function () {
			success.value='Attendance successfully saved!'
			successAlert1.value = !successAlert1.value
			setTimeout(() => {
                closeAlert1()
				// window.location.reload()
			}, 2000);
		}).catch(function(err){
			// error.value=[]
			errors.value=err
		});
    }

     //Fetching Data From User Table for display
	const getData = async (id) => {
		let response = await axios.get("/api/edit_beneficiary/"+id);
		beneficiary.value = response.data.beneficiary;
	}
    
</script>
<script>
   

    // export default {
    //     data(){
    //         return{
    //             error:'',
    //             decodedString: '',
    //             successAlert: false,
    //             beneficiary_id: '',
    //         }
    //     },
    //     components:{
    //         QrcodeStream,QrcodeCapture
    //     },
    //     methods: {
    //         onError(error) {
    //             if (error.name === 'NotAllowedError') {
    //                 this.error="user denied camera access permission"
    //             } else if (error.name === 'NotFoundError') {
    //                 this.error="no suitable camera device installed"
    //             } else if (error.name === 'NotSupportedError') {
    //                 this.error="page is not served over HTTPS (or localhost)"
    //             } else if (error.name === 'NotReadableError') {
    //                 this.error="maybe camera is already in use"
    //             } else if (error.name === 'OverconstrainedError') {
    //                 this.error="did you request the front camera although there is none?"
    //             } else if (error.name === 'StreamApiNotSupportedError') {
    //                 this.error="browser seems to be lacking features"
    //             }
    //         },
    //         onDecode(decodedString){
    //             // this.decodedString=decodedString
    //             const myArray = decodedString.split("/");
    //             let id = myArray[5];
    //             this.beneficiary_id=id
    //             this.decodedString=decodedString
    //             this.successAlert=true
    //             // window.location.replace(decodedString)
    //         },
    //         onDetect(detectedCodes){
    //             this.detectedCodes=detectedCodes
    //             // window.location.replace(decodedString)
    //         }
    //     }
    // }
</script>
<template>
	<navigation>
        <div class="row">
            <div class="col-lg-12">
                <div class="flex justify-between mb-3 px-2">
                    <span class="">
                        <h3 class="card-title !text-lg m-0 uppercase font-bold text-gray-600">QR Scanner<small></small></h3>
                    </span>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb !mb-0 !text-xs px-2 py-1 !bg-transparent">
                            <li class="breadcrumb-item"><a href="/donor_dashboard">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">QR Scanner</li>
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
                            <div class="col-lg-4"></div>
                            <div class="col-lg-4 !shadow-sm !rounded-t-xl">
                                <div class="form-group">
                                    <center><label><b>QR Code Scanner/Reader</b></label></center>
                                    <qrcode-stream @error="onError" @decode="onDecode"></qrcode-stream> 
                                </div>
                            </div>
                            <div class="col-lg-4"></div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6">
                                
                            </div>
                            <div class="col-lg-6">
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
				<div class="modal__content !shadow-2xl !rounded-3xl !my-44 w-4/12 p-0">
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
									<!-- <h2 class="mb-2  font-bold text-green-400">QR Successfully Scanned!</h2> -->
                                    <!-- <img class="w-full" src="" > -->
                                     <center>
                                        <!-- <UserIcon fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-40 h-40 "></UserIcon> -->
                                        <img :src="'storage/profile/'+beneficiary.beneficiary_image" id="img1" v-if="beneficiary.beneficiary_image!=null" style="width: 30%;border-radius:20%"/>
                                        <UserIcon fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-40 h-40 " v-else></UserIcon>
                                     </center>
                                     <br>
									<h5 class="leading-tight" style="text-transform: capitalize;">{{ beneficiary.name }}</h5>
								</div>
							</div>
                            <div class="col-lg-12 col-md-3">
								<div class="text-center">
									<h5 class="leading-tight">{{ beneficiary.gender }}</h5>
								</div>
							</div>
                            <div class="col-lg-12 col-md-3">
								<div class="text-center">
									<h5 class="leading-tight">{{ beneficiary.address }}</h5>
								</div>
							</div>
						</div>
                        <br>
						<div class="row mt-4"> 
							<div class="col-lg-12 col-md-12">
								<div class="flex justify-center space-x-2">
									<button type="button" @click="checkAttendance(beneficiary_id)" class="btn !text-white !text-xs !bg-orange-500 btn-sm !rounded-full w-full">Check Attendance</button>
									<a :href="redirection" target="_blank" class="btn !text-white !text-xs !bg-green-500 btn-sm !rounded-full w-full">Update Health Status</a>
                                    <button type="button" @click="closeAlert()" class="btn !text-white !text-xs !bg-red-500 btn-sm !rounded-full w-full">Scan Again</button>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</Transition>

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
			<div class="modal p-0 !bg-transparent" :class="{ show:successAlert1 }">
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
	</navigation>
</template>