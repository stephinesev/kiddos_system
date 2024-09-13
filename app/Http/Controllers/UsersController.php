<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;
use App\Http\Requests\BmiHistoryRequest;
use App\Models\User;
use App\Models\BmiHistory;
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
        ];
        if(Auth::attempt($credentials)) {
            $user = $request->user();
            $success['token'] = $user->createToken('MyApp')->plainTextToken;
            $success['name'] = $user->username;
            $response = [
                'success' => true,
                'data' => $success,
                'message' => 'User login successfully'
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
                'name' => Auth::user()?->name,
            ];
        }else{
            $credentials=[
                'user_id' => '0',
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
            'barangay'=>'',
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
        User::create($validated);
        QrCode::size(200)->generate($request->username, storage_path('app/public/qr/'.$request->username.".png"));
    }

    public function get_beneficiary(){
        $beneficiary=User::orderBy('name','ASC')->get();
        $beneficiaryall=[];
        foreach($beneficiary AS $b){
            $beneficiaryall[]=[
                'id'=>$b->id,
                $b->name,
                $b->gender,
                $b->email,
                $b->role,
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
        $beneficiary_joinhistoryuser=User::where('id',$id)->where('delete_bmi','0')->get();
        $beneficiary_joinhistorybmi=BmiHistory::where('beneficiary_id',$id)->get();
        return response()->json([
            'beneficiary'=>$beneficiary,
            'beneficiary_joinhistoryuser'=>$beneficiary_joinhistoryuser,
            'beneficiary_joinhistorybmi'=>$beneficiary_joinhistorybmi,
        ],200);
    }
    public function update_beneficiary(UserRequest $request, $id){
        $update=User::where('id',$id)->first();
        $validated=$request->validated();
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
}
