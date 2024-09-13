<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Requests\DonorsRequest;
use App\Models\Donor;
use Illuminate\Support\Facades\Validator;

class DonorsController extends Controller
{

    public function donor_login_form(){
        $formData = [
            'email'=>null,
            'password'=> null,
        ];
        return response()->json($formData);
    }

   public function donor_login_process(Request $request){
        try {
            //Validated
            $validateUser = Validator::make($request->all(),
            [
                'email' => 'required',
                'password' => 'required'
            ]);
    
            if($validateUser->fails()){
                return response()->json([
                    'status' => false,
                    'message' => 'Email and password must not be empty!',
                    'errors' => $validateUser->errors()
                ], 200);
            }
            if(!Auth::guard('donor')->attempt($request->only(['email', 'password']))){
                return response()->json([
                    'status' => true,
                    'success' => false,
                    'message' => 'Email and password does not exist.',
                ], status: 200);
            }
            $user = Donor::where('email', $request->email)->first();
            $success['name'] = $user->fullname;
            $success['email'] = $user->email;
            return response()->json([
                'status' => true,
                'success' => true,
                'data' => $success,
                'message' => 'Logged In Successfully',
                'token' => $user->createToken("API_TOKEN")->plainTextToken
            ], 200);
        } catch (\Throwable $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }
    public function donor_credentials(){
        if(Auth::guard('donor')->check()){
            $credentials=[
                'donor_id' => Auth::guard('donor')->id(),
                'fullname' =>auth('donor')->user()->fullname,
            ];
        }else{
            $credentials=[
                'donor_id' => '0',
                'fullname' => '',
            ];
        }
        return response()->json($credentials);
    }
    public function create_donor(Request $request){
        $formData=[
            'fullname'=>'',
            'birth_date'=>'',
            'gender'=>'',
            'address'=>'',
            'email'=>'',
            'contact_no'=>'',
        ];
        return response()->json($formData);
    }

    public function add_donor(DonorsRequest $request){
        $validated=$request->validated();
        Donor::create($validated);
    }

    public function get_donor(){
        $donor=Donor::orderBy('fullname','ASC')->get();
        $donorall=array();
        foreach($donor AS $b){
            $donorall[]=[
                'id'=>$b->id,
                date('F d,Y',strtotime($b->created_at)),
                $b->fullname,
                $b->birth_date,
                $b->gender,
                $b->address,
                $b->contact_no,
                $b->email,
                ''
            ];
        }
        return response()->json([
            'donorall'=>$donorall,
        ],200);
    }

    public function edit_donor($id){
        $donor=Donor::where('id',$id)->first();
        return response()->json([
            'donor'=>$donor,
        ],200);
    }
    public function update_donor(DonorsRequest $request, $id){
        $update=Donor::where('id',$id)->first();
        $validated=$request->validated();
        $update->update($validated);
    }
    public function delete_donor($id){
        $deleted = Donor::find($id);
        $deleted->delete();
    }
}
