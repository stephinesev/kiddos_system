<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Barangay;
use App\Models\BmiHistory;

class GraphController extends Controller
{
    public function chart_barangay(){
        $barangay_loop=Barangay::orderBy('city')->get();
        $barangay=[];
        $data_barangay_normal=[];
        $data_barangay_underweight=[];
        $data_barangay_overweight=[];
        $data_barangay_obesity=[];
        foreach($barangay_loop as $b){
            $barangay[]=$b->barangay_name;
            $data_barangay_normal[]=User::where('role','Beneficiary')->where('status','Active')->where('barangay',$b->id)->where('nutritional_status','Normal weight')->count();
            $data_barangay_underweight[]=User::where('role','Beneficiary')->where('status','Active')->where('barangay',$b->id)->where('nutritional_status','Underweight')->count();
            $data_barangay_overweight[]=User::where('role','Beneficiary')->where('status','Active')->where('barangay',$b->id)->where('nutritional_status','Overweight')->count();
            $data_barangay_obesity[]=User::where('role','Beneficiary')->where('status','Active')->where('barangay',$b->id)->where('nutritional_status','Obesity')->count();
            // $data_barangay_normal[]=BmiHistory::select('beneficiary_id')->distinct()->join('users', 'users.id', '=', 'bmi_history.beneficiary_id')->where('barangay',$b->id)->where('bmi_history.nutritional_status','Normal weight')->orderByDesc('bmi_date')->count();
            // $data_barangay_underweight[]=BmiHistory::select('beneficiary_id')->distinct()->join('users', 'users.id', '=', 'bmi_history.beneficiary_id')->where('barangay',$b->id)->where('bmi_history.nutritional_status','Underweight')->orderByDesc('bmi_date')->count();
            // $data_barangay_overweight[]=BmiHistory::select('beneficiary_id')->distinct()->join('users', 'users.id', '=', 'bmi_history.beneficiary_id')->where('barangay',$b->id)->where('bmi_history.nutritional_status','Overweight')->orderByDesc('bmi_date')->count();
            // $data_barangay_obesity[]=BmiHistory::select('beneficiary_id')->distinct()->join('users', 'users.id', '=', 'bmi_history.beneficiary_id')->where('barangay',$b->id)->where('bmi_history.nutritional_status','Obesity')->orderByDesc('bmi_date')->count();
        }
        $data = [
            // 'labels' => ['January', 'February', 'March', 'April', 'May', 'June', 'July'],
            'labels' => $barangay,
            'data_barangay_normal' => $data_barangay_normal,
            'data_barangay_underweight' => $data_barangay_underweight,
            'data_barangay_overweight' => $data_barangay_overweight,
            'data_barangay_obesity' => $data_barangay_obesity,
        ];
        return response()->json($data);
    }

    public function chart_barangaypie(){
        $barangay_loop=Barangay::orderBy('city')->get();
        $barangay=[];
        $data_barangay_pie=[];
        $data_barangay_underweight=[];
        $data_barangay_overweight=[];
        $data_barangay_obesity=[];
        $dividenormal=0;
        $divideunderweight=0;
        $divideoverweight=0;
        $divideobisiity=0;
        foreach($barangay_loop as $b){
            $barangay[]=$b->barangay_name;
            $dividenormal=User::where('role','Beneficiary')->where('status','Active')->where('barangay','!=','0')->where('nutritional_status','Normal weight')->count();
            $divideunderweight=User::where('role','Beneficiary')->where('status','Active')->where('barangay','!=','0')->where('nutritional_status','Underweight')->count();
            $divideoverweight=User::where('role','Beneficiary')->where('status','Active')->where('barangay','!=','0')->where('nutritional_status','Overweight')->count();
            $divideobisiity=User::where('role','Beneficiary')->where('status','Active')->where('barangay','!=','0')->where('nutritional_status','Obesity')->count();
            // $divide=User::where('role','Beneficiary')->where('status','Active')->orderByDesc('nutritional_status')->count();
            if($dividenormal!==0){
                $data_barangay_pie[]=(User::where('role','Beneficiary')->where('status','Active')->where('barangay',$b->id)->where('nutritional_status','Normal weight')->orderByDesc('nutritional_status')->count() / $dividenormal)  * 100;
            }else{
                $data_barangay_pie[]=0;
            }
            if($divideunderweight!==0){
                $data_barangay_underweight[]=(User::where('role','Beneficiary')->where('status','Active')->where('barangay',$b->id)->where('nutritional_status','Underweight')->count() / $divideunderweight)  * 100;
            }else{
                $data_barangay_underweight[]=0;
            }
            
            if($divideoverweight!==0){
                $data_barangay_overweight[]=(User::where('role','Beneficiary')->where('status','Active')->where('barangay',$b->id)->where('nutritional_status','Overweight')->count() / $divideoverweight)  * 100;
            }else{
                $data_barangay_overweight[]=0;
            }

            if($divideobisiity!==0){
                $data_barangay_obesity[]=(User::where('role','Beneficiary')->where('status','Active')->where('barangay',$b->id)->where('nutritional_status','Obesity')->count() / $divideobisiity)  * 100;
            }else{
                $data_barangay_obesity[]=0;
            }
        }
        $data = [
            'labels' => $barangay,
            'data_barangay_pie' => $data_barangay_pie,
            'data_barangay_underweightpie' => $data_barangay_underweight,
            'data_barangay_overweightpie' => $data_barangay_overweight,
            'data_barangay_obesitypie' => $data_barangay_obesity,
        ];
        return response()->json($data);
    }
}
