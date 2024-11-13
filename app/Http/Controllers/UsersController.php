<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;
use App\Http\Requests\BmiHistoryRequest;
use App\Models\User;
use App\Models\BmiHistory;
use App\Models\Attendance;
use App\Models\Barangay;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
class UsersController extends Controller
{
    public function login_form(){
        $formData = [
            'username'=>null,
            'password'=> null,
        ];
        return response()->json($formData);
    }

   public function login_process(Request $request){
        $credentials = [
            'username' => $request->username,
            'password' => $request->password,
            'status' => 'Active',
            'role' => 'Admin',
        ];
        if(Auth::attempt($credentials)) {
            $user = $request->user();
            $success['token'] = $user->createToken('MyApp')->plainTextToken;
            $success['name'] = $user->username;
            $response = [
                'success' => true,
                'data' => $success,
                'message' => 'Admin login successfully'
            ];
            return response()->json($response, 200);
        } else {
            $response = [
                'success' => false,
                'message' => 'Unauthorized'
            ];
            return response()->json($response,200);     
        }
    }

    public function dashboard(){
        if(Auth::check()){
            $credentials=[
                'user_id' => Auth::id(),
                'picture' => Auth::user()->beneficiary_image,
                'name' => Auth::user()?->name,
            ];
        }else{
            $credentials=[
                'user_id' => '0',
                'picture' => '',
                'name' => '',
            ];
        }
        return response()->json($credentials);
   }

    public function create_beneficiary(Request $request){
        $formData=[
            'username'=>'',
            'password'=>'',
            'name'=>'',
            'email'=>'',
            'birth_date'=>'',
            'gender'=>'',
            'address'=>'',
            'role'=>'',
            'weight'=>'',
            'height'=>'',
            'bmi'=>'',
            'status'=>'',
            'nutritional_status'=>'',
            'barangay'=>0,
            'school_name'=>'',
            'grade_level'=>'',
            'student_id'=>'',
            'guardian_name'=>'',
            'guardian_contact_no'=>'',
            'guardian_relationship'=>'',
        ];
        return response()->json($formData);
    }

    public function add_beneficiary(UserRequest $request){
        $validated=$request->validated();
        $barangay_name=Barangay::where('id',$request->barangay)->value('barangay_name');
        $validated['barangay_name']=$barangay_name;
        $validated['role']='Beneficiary';
        $user=User::create($validated);
        $validated_history['beneficiary_id']=$user->id;
        $validated_history['weight']=$request->weight;
        $validated_history['height']=$request->height;
        $validated_history['bmi']=$request->bmi;
        $validated_history['nutritional_status']=$request->nutritional_status;
        $validated_history['bmi_date']=date('Y-m-d H:i:s');
        BmiHistory::create($validated_history);
        if($user){
            $update_qr=User::where('id',$user->id)->first();
            $qr_name='http://127.0.0.1:8000/beneficiary/view/'.$user->id;
            $qrupdate['qr_code']=$request->name.'.png';
            $update_qr->update($qrupdate);
        }
        QrCode::format('png')->size(200)->generate($qr_name, storage_path('app/public/qr/'.$request->name.".png"));
    }

    public function get_beneficiary(){
        $beneficiary=User::where('role','Beneficiary')->orderBy('name','ASC')->get();
        $beneficiaryall=[];
        foreach($beneficiary AS $b){
            $beneficiaryall[]=[
                'id'=>$b->id,
                $b->name,
                $b->gender,
                $b->email,
                // $b->role,
                $b->weight,
                $b->height,
                $b->bmi,
                $b->status,
                ''
            ];
        }
        return response()->json([
            'beneficiaryall'=>$beneficiaryall,
        ],200);
    }

    public function edit_beneficiary($id){
        $beneficiary=User::where('id',$id)->first();
        $attendance=Attendance::where('beneficiary_id',$id)->get();
        $beneficiary_joinhistoryuser=User::where('id',$id)->where('delete_bmi','0')->get();
        $beneficiary_joinhistorybmi=BmiHistory::where('beneficiary_id',$id)->get();
        return response()->json([
            'attendance'=>$attendance,
            'beneficiary'=>$beneficiary,
            'beneficiary_joinhistoryuser'=>$beneficiary_joinhistoryuser,
            'beneficiary_joinhistorybmi'=>$beneficiary_joinhistorybmi,
        ],200);
    }
    public function update_beneficiary(UserRequest $request, $id){
        $update=User::where('id',$id)->first();
        $validated=$request->validated();
        $barangay_name=Barangay::where('id',$request->barangay)->value('barangay_name');
        $validated['barangay_name']=$barangay_name;
        if($request->file('beneficiary_image')){
            $path = storage_path('app/public/profile');
            if (!file_exists($path)) {
                mkdir($path, 0777, true);
            }
            $file = $request->file('beneficiary_image');
            $name = uniqid() . '_' . trim($file->getClientOriginalName());
            $file->move($path, $name);
            $validated['beneficiary_image']=$name;
        }
        $update->update($validated);
    }
    public function delete_beneficiary($id){
        $deleted = User::find($id);
        $deleted->delete();
    }

    public function create_bmi_history(Request $request){
        $formData=[
            'beneficiary_id'=>'',
            'weight'=>'',
            'height'=>'',
            'bmi'=>'',
            'nutritional_status'=>'',
            'bmi_date'=>''
        ];
        return response()->json($formData);
    }

    public function add_bmi_history(Request $request){
        if(count(json_decode($request->input("bmi_list")))){
            $bmi_list=$request->input("bmi_list");
            foreach(json_decode($bmi_list) AS $v){
                $variantdata['beneficiary_id']=$v->beneficiary_id;
                $variantdata['bmi_date']=$v->bmi_date;
                $variantdata['height']=$v->height;
                $variantdata['weight']=$v->weight;
                $variantdata['bmi']=$v->bmi;
                $variantdata['nutritional_status']=$v->nutritional_status;
                BmiHistory::create($variantdata);

                $update=User::where('id',$v->beneficiary_id)->first();
                $variantdataupdate['weight']=$v->weight;
                $variantdataupdate['height']=$v->height;
                $variantdataupdate['bmi']=$v->bmi;
                $variantdataupdate['nutritional_status']=$v->nutritional_status;
                $update->update($variantdataupdate);
            }
        }
    }

    public function update_beneficiary_delete($id){
        $head=User::where('id',$id)->first();
        $data = [
            'delete_bmi'=>'1'
        ];
        $head->update($data);
    }

    public function history_beneficiary_delete($id){
        $deleted = BmiHistory::find($id);
        $deleted->delete();
    }

    public function beneficiary_login_process(Request $request){
        $credentials = [
            'username' => $request->username,
            'password' => $request->password,
            'status' => 'Active',
            'role' => 'Beneficiary',
        ];
        if(Auth::attempt($credentials)) {
            $user = $request->user();
            $success['token'] = $user->createToken('MyApp')->plainTextToken;
            $success['name'] = $user->username;
            $response = [
                'success' => true,
                'data' => $success,
                'message' => 'Beneficiary login successfully'
            ];
            return response()->json($response, 200);
        } else {
            $response = [
                'success' => false,
                'message' => 'Unauthorized'
            ];
            return response()->json($response,200);     
        }
    }

    public function get_bmi(){
        $beneficiary=User::where('id',Auth::id())->first();
        $beneficiary_joinhistoryuser=User::where('id',Auth::id())->where('delete_bmi','0')->get();
        $beneficiary_joinhistorybmi=BmiHistory::where('beneficiary_id',Auth::id())->get();
        $beneficiaryfirst=[];
        // foreach($beneficiary_joinhistoryuser AS $b){
        //     $beneficiaryfirst[]=[
        //         'id'=>$b->id,
        //         '<center>'.date('F d,Y',strtotime($b->created_at)).'</center>',
        //         '<center>'.$b->height.'</center>',
        //         '<center>'.$b->weight.'</center>',
        //         '<center>'.$b->bmi.'</center>',
        //         '<center>'.$b->nutritional_status.'</center>',
        //     ];
        // }
        foreach($beneficiary_joinhistorybmi AS $be){
            $beneficiaryfirst[]=[
                'id'=>$be->id,
                '<center>'.date('F d,Y',strtotime($be->bmi_date)).'</center>',
                '<center>'.$be->height.'</center>',
                '<center>'.$be->weight.'</center>',
                '<center>'.$be->bmi.'</center>',
                '<center>'.$be->nutritional_status.'</center>',
            ];
        }
        return response()->json([
            'beneficiaryfirst'=>$beneficiaryfirst,
            // 'beneficiary_joinhistoryuser'=>$beneficiary_joinhistoryuser,
            // 'beneficiary_joinhistorybmi'=>$beneficiary_joinhistorybmi,
        ],200);
    }
    
    public function insert_attendance(Request $request){
        $validated['beneficiary_id']=$request->beneficiary_id;
        $validated['attendance_date']=$request->attendance_date;
        Attendance::create($validated);
    }

    public function create_admin(Request $request){
        $formData=[
            'username'=>'',
            'password'=>'',
            'name'=>'',
            'email'=>'',
            'birth_date'=>'',
            'gender'=>'',
            'address'=>'',
            'status'=>'',
            'role'=>''
        ];
        return response()->json($formData);
    }

    public function add_admin(Request $request){
        $validated=$this->validate($request,[
                'username'=>['required','string'],
                'password'=>['required','string'],
                'name'=>['required','string'],
                'email'=>['required','email'],
                'birth_date'=>['required','string'],
                'gender'=>['required','string'],
                'address'=>['required','string'],
                'status'=>['required','string'],
                'role'=>['required','string'],
        ]);
        // $validated['role']='LGU Admin';
        User::create($validated);
    }

    public function get_admin(){
        $admin=User::where('role','Admin')->orWhere('role','Admin LGU')->orderBy('name','ASC')->get();
        $adminall=[];
        foreach($admin AS $b){
            $adminall[]=[
                'id'=>$b->id,
                $b->name,
                $b->gender,
                $b->email,
                $b->address,
                $b->role,
                $b->status,
                ''
            ];
        }
        return response()->json([
            'adminall'=>$adminall,
        ],200);
    }

    public function edit_admin($id){
        $admin=User::where('id',$id)->first();
        return response()->json([
            'admin'=>$admin,
        ],200);
    }
    public function update_admin(Request $request, $id){
        $update=User::where('id',$id)->first();
        $validated=$this->validate($request,[
                'username'=>['required','string'],
                'password'=>['required','string'],
                'name'=>['required','string'],
                'email'=>['required','email'],
                'birth_date'=>['required','string'],
                'gender'=>['required','string'],
                'address'=>['required','string'],
                'status'=>['required','string'],
        ]);
        $update->update($validated);
    }
    public function delete_admin($id){
        $deleted = User::find($id);
        $deleted->delete();
    }

    public function login_process_lgu(Request $request){
        $credentials = [
            'username' => $request->username,
            'password' => $request->password,
            'status' => 'Active',
            'role' => 'Admin LGU',
        ];
        if(Auth::attempt($credentials)) {
            $user = $request->user();
            $success['token'] = $user->createToken('MyApp')->plainTextToken;
            $success['name'] = $user->username;
            $response = [
                'success' => true,
                'data' => $success,
                'message' => 'Admin LGU login successfully'
            ];
            return response()->json($response, 200);
        } else {
            $response = [
                'success' => false,
                'message' => 'Unauthorized'
            ];
            return response()->json($response,200);     
        }
    }

    public function get_attendance(){
        $attendance=Attendance::where('beneficiary_id',Auth::id())->orderBy('created_at','ASC')->get();
        $attendanceall=[];
        $x=1;
        foreach($attendance AS $b){
            $attendanceall[]=[
                'id'=>$b->id,
                "<center>".$x."</center>",
                "<center>".date('F d,Y',strtotime($b->attendance_date))."</center>",
            ];
            $x++;
        }
        return response()->json([
            'attendanceall'=>$attendanceall,
        ],200);
    }

}
