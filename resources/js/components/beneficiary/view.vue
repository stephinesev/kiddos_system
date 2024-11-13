<script setup>
	import navigation from '@/layouts/navigation.vue';
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
	let attendance=ref([]);
	let bmi_list=ref([]);
	let beneficiary=ref([]);
	let beneficiary_joinhistoryuser=ref([]);
	let beneficiary_joinhistorybmi=ref([]);
	let item_no=ref();
	let height=ref('');
	let weight=ref('');
	let bmis=ref('');
	let bmi_date=ref('');
	let error = ref([])
	let error_items = ref([]);
	let success = ref('')	
	let status_color = ref('')	
	let nutritional_status=ref('');
	const dangerAlert = ref(false)
	const dangerAlert_item = ref(false)
	const successAlert = ref(false)
	const warningAlert = ref(false)
    const infoAlert = ref(false)
	const hideAlert = ref(true)
	//Fetcher of Data
	onMounted(async () => {
		getBeneficiary()
	})
	//Get data from database
	const getBeneficiary = async () => {
		let response = await axios.get(`/api/edit_beneficiary/${props.id}`)
		attendance.value = response.data.attendance
		beneficiary.value = response.data.beneficiary
		beneficiary_joinhistoryuser.value = response.data.beneficiary_joinhistoryuser
		beneficiary_joinhistorybmi.value = response.data.beneficiary_joinhistorybmi
	}

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

	//Insert Function
	const onSave = () => {
		const formData=new FormData()
		formData.append('bmi_list',JSON.stringify(bmi_list.value))
		const no_of_bmi = bmi_list.value.length 
		error_items.value=[]
		for(var y=0;y<no_of_bmi;y++){
			var inc=y+1;
			if(bmi_list.value[y].bmi_date == ''){
				error_items.value.push('Date row '+inc+' must not be empty.')
			}
			if(bmi_list.value[y].height == ''){
				error_items.value.push('Height row '+inc+' must not be empty.')
			}
			if(bmi_list.value[y].weight == ''){
				error_items.value.push('Weight row '+inc+' must not be empty.')
			}
			if(bmi_list.value[y].bmi == ''){
				error_items.value.push('BMI row '+inc+' must not be empty.')
			}
			if(bmi_list.value[y].nutritional_status == ''){
				error_items.value.push('Nutritional status row '+inc+' must not be empty.')
			}
		}
		axios.post("/api/add_bmi_history",formData).then(function () {
			if(error_items.value.length==0){
				success.value='You have successfully added new beneficiary info!'
				error.value=[]
				error_items.value=[]
				bmi_list.value=[]
				successAlert.value = !successAlert.value
				setTimeout(() => {
					getBeneficiary()
					closeAlert()
					document.getElementById("save_btn").style.display="none"
				}, 2000);
			}
		}).catch(function(err){
			error.value=[]
			error_items.value=[]
			bmi_list.value=[]
			warningAlert.value = !warningAlert.value
		});
	}
	//Append Data
	const addBMI= () => {
		if(bmi_date.value == ''){
			document.getElementById('date_check').placeholder="Date must not be empty!"
			document.getElementById('date_check').style.backgroundColor = '#FAA0A0';
		}else if(height.value == ''){
			document.getElementById('height_check').placeholder="Height must not be empty!"
			document.getElementById('height_check').style.backgroundColor = '#FAA0A0';
		}else if(weight.value == ''){
			document.getElementById('weight_check').placeholder="Weight must not be empty!"
			document.getElementById('weight_check').style.backgroundColor = '#FAA0A0';
		}else if(bmis.value == ''){
			document.getElementById('bmi_check').placeholder="BMI must not be empty!"
			document.getElementById('bmi_check').style.backgroundColor = '#FAA0A0';
		}else if(nutritional_status.value == ''){
			document.getElementById('nutritional_status_check').placeholder="Nutritional status must not be empty!"
			document.getElementById('nutritional_status_check').style.backgroundColor = '#FAA0A0';
		}else{
			const bmi_details = {
				item_no:item_no.value,
				beneficiary_id:props.id,
				bmi_date:bmi_date.value,
				height:height.value,
				weight:weight.value,
				bmi:bmis.value,
				nutritional_status:nutritional_status.value
			}
			document.getElementById('date_check').style.backgroundColor = '#FFFFFF';
			document.getElementById('height_check').style.backgroundColor = '#FFFFFF';
			document.getElementById('weight_check').style.backgroundColor = '#FFFFFF';
			document.getElementById('bmi_check').style.backgroundColor = '#FFFFFF';
			document.getElementById('nutritional_status_check').style.backgroundColor = '#FFFFFF';
			document.getElementById("save_btn").style.display="block"
			bmi_list.value.push(bmi_details)
			bmi_date.value='';
			height.value='';
			weight.value='';
			bmis.value='';
			nutritional_status.value='';
			status_color.value='';
		}
	}

	const removeBMI = (index) => {
		bmi_list.value.splice(index,1)
		dangerAlert_item.value = !hideAlert.value
	}

	//Delete Function
	const deleteBMI = (id) => {
		var confirmation = confirm("Do you want to delete this beneficiary info?");
		if (confirmation == true) {
			axios.get(`/api/update_beneficiary_delete/${props.id}`).then(function () {
				success.value='Successfully deleted beneficiary!'
				error.value=[]
				getBeneficiary()
				successAlert.value = !successAlert.value
				setTimeout(() => {
					// window.location.reload()
					getBeneficiary()
					closeAlert()
				}, 2000);
			}).catch(function(err){
				success.value=''
				error.value.push('Error! Try again.')
			});
		}
	}
	const deleteBMIHis = (id) => {
		var confirmation = confirm("Do you want to delete this beneficiary info?");
		if (confirmation == true) {
			axios.get(`/api/history_beneficiary_delete/`+id).then(function () {
				success.value='Successfully deleted beneficiary!'
				error.value=[]
				getBeneficiary()
				successAlert.value = !successAlert.value
				setTimeout(() => {
					// window.location.reload()
					getBeneficiary()
					closeAlert()
				}, 2000);
			}).catch(function(err){
				success.value=''
				error.value.push('Error! Try again.')
			});
		}
	}
	const formatNumber = (number) => {
      return number.toLocaleString('en-US', { minimumFractionDigits: 1, maximumFractionDigits: 1 });
    }
	const calculateBmi = () => {
      // Convert height from cm to meters (1 cm = 0.01 m)
      const heightInMeters = height.value / 100;
      // Calculate BMI
	  if(heightInMeters!=0){
		bmis.value = formatNumber(weight.value / (heightInMeters * heightInMeters));
		// alert(bmi.value)
		var bmi = formatNumber(weight.value / (heightInMeters * heightInMeters));
		// Categorize BMI
		
		nutritional_status.value = getBmiCategory(bmi);
	  }
    }

	const getBmiCategory = (bmi) => {
		if (formatNumber(bmi) < 18.5) {
			status_color.value="#ADD8E6"
            return 'Underweight';
        } else if (formatNumber(bmi) >= 18.5 && formatNumber(bmi) <= 24.9) {
			status_color.value="#90EE90"
            return 'Normal weight';
        } else if (formatNumber(bmi) >= 25 && formatNumber(bmi) <= 29.9) {
			status_color.value="#FFFF00"
            return 'Overweight';
        } else if (formatNumber(bmi) >= 30 && formatNumber(bmi) <= 34.9) {
			status_color.value="#FFA500"
            return 'Obesity Class I';
        } else if (formatNumber(bmi) >= 35 && formatNumber(bmi) <= 39.9) {
			status_color.value="#FF5349"
            return 'Obesity Class II';
        } else if (formatNumber(bmi) > 40) {
			status_color.value="#ff4242"
            return 'Obesity Class III';
        }
    }
</script>
<template>
	<navigation>
		<div class="row">
            <div class="col-lg-12">
                <div class="flex justify-between mb-3 px-2">
                    <span class="">
                        <h3 class="card-title !text-lg m-0 uppercase font-bold text-gray-600">Beneficiary <small>View</small></h3>
                    </span>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb !mb-0 !text-xs px-2 py-1 !bg-transparent">
                            <li class="breadcrumb-item"><a href="/dashboard">Home</a></li>
                            <li class="breadcrumb-item active"><a href="/pur_req">Beneficiary</a></li>
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
						<div class="row">
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
								<span class="text-sm text-gray-700">{{beneficiary.barangay_name}}</span>
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
						</div>
						<div class="row">
								<div class="col-lg-6">
									<table class="w-full table-bordered !text-xs mt-3">
										<tr>
											<td class=""><input placeholder="#" type="text" v-model="item_no" class="w-full p-1 text-center" disabled></td>
											<td class=""><input placeholder="Date" id="date_check" type="date" v-model="bmi_date" class="w-full p-1 text-center"></td>
											<td class=""><input placeholder="Weight" id="weight_check" type="text" v-model="weight" @keyup="calculateBmi()" class="w-full p-1 text-center"></td>
											<td class=""><input placeholder="Height (cm)" id="height_check" type="text" v-model="height" @keyup="calculateBmi()" class="w-full p-1 text-center"></td>
											<td class=""><input placeholder="BMI" id="bmi_check" type="text" v-model="bmis" class="w-full p-1" readonly></td>
											<td class="">
												<select class="w-full p-1 text-black-500" id="nutritional_status_check" v-model="nutritional_status" :style="'pointer-events: none; background-color:'+status_color">
													<option value="">--Select Nutritional Status--</option>
													<option value="Underweight">Underweight</option>
													<option value="Normal weight">Normal weight</option>
													<option value="Overweight">Overweight</option>
													<option value="Obesity Class I">Obesity Class I</option>
													<option value="Obesity Class II">Obesity Class II</option>
													<option value="Obesity Class III">Obesity III</option>
												</select>
											</td>
											<td class="text-center">
												<button class="btn btn-primary p-1" @click="addBMI">
													<PlusIcon fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="menu-icon w-3 h-3 "></PlusIcon>
												</button>
											</td>
										</tr>
										<tr class="bg-gray-100">
											<td class="p-1 uppercase text-center" width="5%">#</td>
											<td class="p-1 uppercase text-center" width="15%">Date</td>
											<td class="p-1 uppercase text-center" width="15%">Weight</td>
											<td class="p-1 uppercase text-center" width="15%">Height</td>
											<td class="p-1 uppercase" width="20%">BMI</td>
											<td class="p-1 uppercase" width="">Nutritional Status</td>
											<td class="p-1 space-x-auto uppercase text-center" align="center" width="1%">
												<Bars3Icon fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="menu-icon w-3 h-3 "></Bars3Icon>
											</td>
										</tr>
										<!-- <tr v-for="(b,indexes) in beneficiary_joinhistoryuser">
											<td class="p-1 text-center">{{ indexes + 1 }}</td>
											<td class="p-1 text-center">{{ moment(b.created_at).format("MMM DD,YYYY") }}</td>
											<td class="p-1 text-center">{{ b.height }}</td>
											<td class="p-1 text-center">{{ b.weight }}</td>
											<td class="p-1">{{ b.bmi }}</td>
											<td class="p-1">{{ b.nutritional_status }}</td>
											<td class="text-center">
												<button class="btn btn-danger p-1" @click="deleteBMI(b.id)">
													<XMarkIcon fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="menu-icon w-3 h-3 "></XMarkIcon>
												</button>
											</td>
										</tr> -->
										<tr v-for="(bs,indexesr) in beneficiary_joinhistorybmi">
											<td class="p-1 text-center">{{ indexesr + 1 + beneficiary_joinhistoryuser.length }}</td>
											<td class="p-1 text-center">{{ moment(bs.bmi_date).format("MMM DD,YYYY") }}</td>
											<td class="p-1 text-center">{{ bs.weight }}</td>
											<td class="p-1 text-center">{{ bs.height }}</td>
											<td class="p-1">{{ bs.bmi }}</td>
											<td class="p-1">{{ bs.nutritional_status }}</td>
											<td class="text-center">
												<button class="btn btn-danger p-1" @click="deleteBMIHis(bs.id)">
													<XMarkIcon fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="menu-icon w-3 h-3 "></XMarkIcon>
												</button>
											</td>
										</tr>
										<tr v-for="(i,index) in bmi_list">
											<td class="p-1 text-center">{{ index + 1 + beneficiary_joinhistoryuser.length }}</td>
											<td class="p-1 text-center">{{ moment(i.bmi_date).format("MMM DD,YYYY") }}</td>
											<td class="p-1 text-center">{{ i.weight }}</td>
											<td class="p-1 text-center">{{ i.height }}</td>
											<td class="p-1">{{ i.bmi }}</td>
											<td class="p-1">{{ i.nutritional_status }}</td>
											<td class="text-center">
												<button class="btn btn-danger p-1" @click="removeBMI(index)">
													<XMarkIcon fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="menu-icon w-3 h-3 "></XMarkIcon>
												</button>
											</td>
										</tr>
									</table>
								</div>
								<div class="col-lg-6">
									<table class="w-full table-bordered !text-xs mt-3">
										<tr class="bg-gray-100">
											<td class="p-1 uppercase text-center" width="5%">#</td>
											<td class="p-1 uppercase text-center" width="15%">Attendance Date</td>
										</tr>
										<tr v-for="(a,indexatt) in attendance">
											<td class="p-1 text-center">{{ indexatt + 1 }}</td>
											<td class="p-1 text-center">{{ moment(a.attendance_date).format("MMM DD,YYYY") }}</td>
										</tr>
									</table>
								</div>
							</div>
						<br>
						<!-- <hr class="border-dashed"> -->
						<div class="row my-2" style="display:none"  id="save_btn"> 
							<div class="col-lg-12 col-md-12">
								<div class="flex justify-center space-x-2">
									<button type="button" class="btn btn-primary mr-2 w-36" @click="onSave()">Save</button>
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