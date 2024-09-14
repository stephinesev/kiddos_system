<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\DonationsRequest;
use App\Http\Requests\DonorsRequest;
use Illuminate\Http\Request;
use App\Models\Donations;
use App\Models\DonationImages;
use App\Models\Donor;
use App\Models\Events;
use Illuminate\Support\Facades\File;

class DonationsController extends Controller
{
    public function create_registration(Request $request){
        $registerdata=[
            'fullname'=>'',
            'password'=>'',
            'birth_date'=>'',
            'gender'=>'',
            'address'=>'',
            'email'=>'',
            'contact_no'=>'',
        ];
        return response()->json($registerdata);
    }
    public function registration(DonorsRequest $request){
        $validated=$request->validated();
        Donor::create($validated);
    }
    public function create_donation(Request $request){
        $formData=[
            'donor_id'=>'',
            'event_id'=>'',
            'where_date'=>'',
            'where_time'=>'',
            'barangay'=>'',
            'donation_type'=>'',
            'mode_of_collection'=>'',
            'pickup_description'=>'',
        ];
        return response()->json($formData);
    }
    public function add_donation(DonationsRequest $request){
        $validated=$request->validated();
        $insert=Donations::create($validated);
        if($insert){
            if(count(json_decode($request->input("images")))>0){
                foreach(json_decode($request->images) as $i){
                    $from = storage_path('app/public/tmp/uploads/' . $i->name);
                    $to = storage_path('app/public/images/' . $i->name);
                    File::move($from, $to);
                    $validated_image['donation_id']=$insert->id;
                    $validated_image['image_name']=$i->name;
                    DonationImages::create($validated_image);
                }
            }
        }
        
    }

    public function get_events_donation(){
        $events=Events::orderBy('start_date','ASC')->get();
        return response()->json([
            'events'=>$events,
        ],200);
    }

    public function get_event_address($id){
        $address=Events::where('id',$id)->value('event_address');
        return $address;
    }

    public function upload_image(Request $request){
        $path = storage_path('app/public/tmp/uploads');
        if (!file_exists($path)) {
            mkdir($path, 0777, true);
        }
        $file = $request->file('image');
        $name = uniqid() . '_' . trim($file->getClientOriginalName());
        $file->move($path, $name);
        return ['name' => $name];
    }

    public function get_donations(){
        $donations=Donations::where('donor_id',Auth::guard('donor')->id())->orderBy('when_date','ASC')->get();
        $donationsall=[];
        foreach($donations AS $b){
            $event_name=Events::where('id',$b->event_id)->value('event_name');
            $donationsall[]=[
                'id'=>$b->id,
                $event_name,
                "<center>".date('F d,Y',strtotime($b->when_date))."</center>",
                "<center>".date('H:i A',strtotime($b->when_time))."</center>",
                $b->barangay,
                "<center>".$b->donation_type."</center>",
                "<center>".$b->mode_of_collection."</center>",
                ''
            ];
        }
        return response()->json([
            'donationsall'=>$donationsall,
        ],200);
    }
    public function get_images($id){
        $images=DonationImages::where('donation_id',$id)->get();
        return response()->json([
            'images'=>$images,
        ],200);
    }
}
