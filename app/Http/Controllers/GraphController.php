<?php

namespace App\Http\Controllers;
use Carbon\Carbon;
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
        $data_barangay_obesity2=[];
        $data_barangay_obesity3=[];
        $endDate = Carbon::now();
        $startDate = Carbon::now()->subMonths(6);
        // foreach($barangay_loop as $b){
        //     $barangay[]=$b->barangay_name;
        //     $data_barangay_normal[]=User::join('bmi_history', 'bmi_history.beneficiary_id', '=', 'users.id')->where('role','Beneficiary')->where('status','Active')->where('barangay',$b->id)->where('bmi_history.nutritional_status','Normal weight')->whereMonth('bmi_history.bmi_date','09')->count();
        //     $data_barangay_underweight[]=User::where('role','Beneficiary')->where('status','Active')->where('barangay',$b->id)->where('nutritional_status','Underweight')->count();
        //     $data_barangay_overweight[]=User::where('role','Beneficiary')->where('status','Active')->where('barangay',$b->id)->where('nutritional_status','Overweight')->count();
        //     $data_barangay_obesity[]=User::where('role','Beneficiary')->where('status','Active')->where('barangay',$b->id)->where('nutritional_status','Obesity Class I')->count();
        //     $data_barangay_obesity2[]=User::where('role','Beneficiary')->where('status','Active')->where('barangay',$b->id)->where('nutritional_status','Obesity Class II')->count();
        //     $data_barangay_obesity3[]=User::where('role','Beneficiary')->where('status','Active')->where('barangay',$b->id)->where('nutritional_status','Obesity Class III')->count();
        // }
        $months = [];
        for ($i = 5; $i >= 0; $i--) {
            $month = Carbon::now()->subMonths($i)->format('F'); // Get month names (e.g., January, February)
            $month_disp = Carbon::now()->subMonths($i)->format('m'); // Get month names (e.g., January, February)
            $months[] = $month;
            $data_barangay_normal[]=User::join('bmi_history', 'bmi_history.beneficiary_id', '=', 'users.id')->where('role','Beneficiary')->where('status','Active')->where('bmi_history.nutritional_status','Normal weight')->whereMonth('bmi_history.bmi_date',$month_disp)->count();

            $data_barangay_underweight[]=User::join('bmi_history', 'bmi_history.beneficiary_id', '=', 'users.id')->where('role','Beneficiary')->where('status','Active')->where('bmi_history.nutritional_status','Underweight')->whereMonth('bmi_history.bmi_date',$month_disp)->count();
            $data_barangay_overweight[]=User::join('bmi_history', 'bmi_history.beneficiary_id', '=', 'users.id')->where('role','Beneficiary')->where('status','Active')->where('bmi_history.nutritional_status','Overweight')->whereMonth('bmi_history.bmi_date',$month_disp)->count();
            $data_barangay_obesity[]=User::join('bmi_history', 'bmi_history.beneficiary_id', '=', 'users.id')->where('role','Beneficiary')->where('status','Active')->where('bmi_history.nutritional_status','Obesity Class I')->whereMonth('bmi_history.bmi_date',$month_disp)->count();
            $data_barangay_obesity2[]=User::join('bmi_history', 'bmi_history.beneficiary_id', '=', 'users.id')->where('role','Beneficiary')->where('status','Active')->where('bmi_history.nutritional_status','Obesity Class II')->whereMonth('bmi_history.bmi_date',$month_disp)->count();
            $data_barangay_obesity3[]=User::join('bmi_history', 'bmi_history.beneficiary_id', '=', 'users.id')->where('role','Beneficiary')->where('status','Active')->where('bmi_history.nutritional_status','Obesity Class III')->whereMonth('bmi_history.bmi_date',$month_disp)->count();
        }
        $data = [
            // 'labels' => ['January', 'February', 'March', 'April', 'May', 'June', 'July'],
            'labels' => $months,
            'data_barangay_normal' => $data_barangay_normal,
            'data_barangay_underweight' => $data_barangay_underweight,
            'data_barangay_overweight' => $data_barangay_overweight,
            'data_barangay_obesity' => $data_barangay_obesity,
            'data_barangay_obesity2' => $data_barangay_obesity2,
            'data_barangay_obesity3' => $data_barangay_obesity3,
        ];
        return response()->json($data);
    }

    public function chart_barangaypie(){
        $barangay_loop=Barangay::orderBy('city')->get();
        $barangay=[];
        $data_barangay_pie=[];
        $data_barangay_underweight=[];
        $data_barangay_overweight=[];
        $data_barangay_obesity1=[];
        $data_barangay_obesity2=[];
        $data_barangay_obesity3=[];
        $dividenormal=0;
        $divideunderweight=0;
        $divideoverweight=0;
        $divideobisiity1=0;
        $divideobisiity2=0;
        $divideobisiity3=0;
        foreach($barangay_loop as $b){
            $barangay[]=$b->barangay_name;
            $dividenormal=User::where('role','Beneficiary')->where('status','Active')->where('barangay','!=','0')->where('nutritional_status','Normal weight')->count();
            $divideunderweight=User::where('role','Beneficiary')->where('status','Active')->where('barangay','!=','0')->where('nutritional_status','Underweight')->count();
            $divideoverweight=User::where('role','Beneficiary')->where('status','Active')->where('barangay','!=','0')->where('nutritional_status','Overweight')->count();

            $divideobisiity1=User::where('role','Beneficiary')->where('status','Active')->where('barangay','!=','0')->where('nutritional_status','Obesity Class I')->count();
            $divideobisiity2=User::where('role','Beneficiary')->where('status','Active')->where('barangay','!=','0')->where('nutritional_status','Obesity Class II')->count();
            $divideobisiity3=User::where('role','Beneficiary')->where('status','Active')->where('barangay','!=','0')->where('nutritional_status','Obesity Class III')->count();
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

            if($divideobisiity1!==0){
                $data_barangay_obesity1[]=(User::where('role','Beneficiary')->where('status','Active')->where('barangay',$b->id)->where('nutritional_status','Obesity Class I')->count() / $divideobisiity1)  * 100;
            }else{
                $data_barangay_obesity1[]=0;
            }
            if($divideobisiity2!==0){
                $data_barangay_obesity2[]=(User::where('role','Beneficiary')->where('status','Active')->where('barangay',$b->id)->where('nutritional_status','Obesity Class II')->count() / $divideobisiity2)  * 100;
            }else{
                $data_barangay_obesity2[]=0;
            }
            if($divideobisiity3!==0){
                $data_barangay_obesity3[]=(User::where('role','Beneficiary')->where('status','Active')->where('barangay',$b->id)->where('nutritional_status','Obesity Class III')->count() / $divideobisiity3)  * 100;
            }else{
                $data_barangay_obesity3[]=0;
            }
        }
        $data = [
            'labels' => $barangay,
            'data_barangay_pie' => $data_barangay_pie,
            'data_barangay_underweightpie' => $data_barangay_underweight,
            'data_barangay_overweightpie' => $data_barangay_overweight,
            'data_barangay_obesitypie1' => $data_barangay_obesity1,
            'data_barangay_obesitypie2' => $data_barangay_obesity2,
            'data_barangay_obesitypie3' => $data_barangay_obesity3,
        ];
        return response()->json($data);
    }
}
