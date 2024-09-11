<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\DonorsRequest;
use App\Models\Donor;

class DonorsController extends Controller
{
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
