<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Barangay;
class BarangayController extends Controller
{
    public function create_barangay(Request $request){
        $formData=[
            'barangay_name'=>'',
            'city'=>''
        ];
        return response()->json($formData);
    }

    public function add_barangay(Request $request){
        $validated=$this->validate($request,[
            'barangay_name'=>['required','string'],
            'city'=>['required','string'],
        ]);
        Barangay::create($validated);
    }

    public function get_barangay(){
        $barangay=Barangay::orderBy('barangay_name','ASC')->get();
        $barangayall=array();
        foreach($barangay AS $b){
            $barangayall[]=[
                'id'=>$b->id,
                $b->barangay_name,
                $b->city,
                ''
            ];
        }
        return response()->json([
            'barangay'=>$barangay,
            'barangayall'=>$barangayall,
        ],200);
    }

    public function edit_barangay($id){
        $barangay=Barangay::where('id',$id)->first();
        return response()->json([
            'barangay'=>$barangay,
        ],200);
    }
    public function update_barangay(Request $request, $id){
        $update=Barangay::where('id',$id)->first();
        $validated=$this->validate($request,[
            'barangay_name'=>['required','string'],
            'city'=>['required','string'],
        ]);
        $update->update($validated);
    }
    public function delete_barangay($id){
        $deleted = Barangay::find($id);
        $deleted->delete();
    }
}
