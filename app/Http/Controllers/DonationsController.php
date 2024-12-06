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
use App\Models\Notifications;
use App\Models\Barangay;
use Illuminate\Support\Facades\File;

class DonationsController extends Controller
{
    public function create_registration(Request $request){
        $registerdata=[
            'fullname'=>'',
            'password'=>'',
            'birth_date'=>'',
            'gender'=>'',
            'barangay'=>0,
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
            'event_id'=>0,
            'where_date'=>'',
            'where_time'=>'',
            'event_address'=>'',
            'barangay'=>'',
            'donation_type'=>'',
            'mode_of_collection'=>'',
            'pickup_description'=>'',
            'pickup_contact_no'=>'',
            'others'=>'',
        ];
        return response()->json($formData);
    }
    public function add_donation(DonationsRequest $request){
        $validated=$request->validated();
        $barangay_name=Barangay::where('id',$request->barangay)->value('barangay_name');
        $validated['barangay_name']=$barangay_name;
        $insert=Donations::create($validated);
        if($insert){
            $donor_name=Donor::where('id',$insert->donor_id)->value('fullname');
            $validated_notif['donor_id']=$insert->donor_id;
            $validated_notif['donation_id']=$insert->id;
            $validated_notif['event_id']=$insert->event_id;
            $validated_notif['notification']=$donor_name." has generously made a ".$insert->mode_of_collection." donation of ".$insert->donation_type." to the barangay.";
            Notifications::create($validated_notif);
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
        $date=date('Y-m-d');
        $start_date=Events::where('start_date',$date)->value('start_date');
        $end_date=Events::where('end_date',$date)->value('end_date');
        $events=Events::whereBetween('start_date',[$date, $start_date])->orWhereBetween('end_date', [$date,$end_date])->orderBy('start_date','ASC')->get();
        return response()->json([
            'events'=>$events,
        ],200);
    }

    public function get_event_address($id){
        $barangay=Events::where('id',$id)->value('barangay');
        $address=Events::where('id',$id)->value('event_address');
        $date=Events::where('id',$id)->value('start_date');
        $time=Events::where('id',$id)->value('event_time');
        return response()->json([
            'barangay'=>$barangay,
            'address'=>$address,
            'date'=>$date,
            'time'=>$time,
        ],200);
        // return $address;
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
        $donations=Donations::where('donor_id',Auth::guard('donor')->id())->orderBy('created_at','ASC')->get();
        $donationsall=[];
        foreach($donations AS $b){
            $event_name=Events::where('id',$b->event_id)->value('event_name');
            $donationsall[]=[
                'id'=>$b->id,
                'admin_message'=>$b->admin_message,
                ($b->event_id!=0) ? $event_name : $b->others,
                "<center>".date('F d,Y',strtotime($b->when_date))."</center>",
                "<center>".date('H:i A',strtotime($b->when_time))."</center>",
                $b->barangay_name,
                "<center>".$b->donation_type."</center>",
                "<center>".$b->mode_of_collection."</center>",
                '',
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

    public function get_admin_donations(){
        $donations=Donations::orderByDesc('created_at')->get();
        $donationsall=[];
        foreach($donations AS $b){
            $event_name=Events::where('id',$b->event_id)->value('event_name');
            $donor_name=Donor::where('id',$b->donor_id)->value('fullname');
            $donationsall[]=[
                'id'=>$b->id,
                $donor_name,
                ($b->event_id!=0) ? $event_name : $b->others,
                "<center>".date('F d,Y',strtotime($b->when_date))."</center>",
                "<center>".date('H:i A',strtotime($b->when_time))."</center>",
                $b->barangay_name,
                "<center>".$b->donation_type."</center>",
                "<center>".$b->mode_of_collection."</center>",
                $b->pickup_description,
                $b->pickup_contact_no,
                "<center>".(($b->status==0) ? '<span style="color:orange">Pending</span>' : (($b->status==1) ? '<span style="color:green">Accepted</span>' : '<span style="color:red">Declined</span>'))."</center>",
                ''
            ];
        }
        return response()->json([
            'donationsall'=>$donationsall,
        ],200);
    }

    public function accept_donation($id,$donor_id,$event_id){
        $update=Donations::where('id',$id)->first();
        $accepted['status']='1';
        $update->update($accepted);
        if($update){
            $validated_notif['donation_id']=$id;
            $validated_notif['donor_id']=$donor_id;
            $validated_notif['event_id']=$event_id;
            $validated_notif['notification']=($update->mode_of_collection=='Self Delivery') ? "Thankyou for your donation! We will be expecting your donation." : "Thankyou for your donation! We will be arriving on your location.";
            $validated_notif['identifier']="1";
            Notifications::create($validated_notif);
        }
    }

    public function admin_message(Request $request,$id){
        $update=Donations::where('id', $id)->first();
        $accepted['admin_message']=$request->admin_message;
        $update->update($accepted);
    }

    public function get_message($id){
        $message=Donations::where('id',$id)->first();
        return $message->admin_message;
    }

    public function decline_donation($id,$donor_id,$event_id) {
        $update=Donations::where('id',$id)->first();
        $declined['status']='2';
        $update->update($declined);
        if($update){
            $validated_notif['donation_id']=$id;
            $validated_notif['donor_id']=$donor_id;
            $validated_notif['event_id']=$event_id;
            $validated_notif['notification']="Sorry your donation has been declined.";
            $validated_notif['identifier']="1";
            Notifications::create($validated_notif);
        }
    }

    public function get_notification(){
        $notification=Notifications::with('donors')->where('read','0')->where('identifier','0')->orderByDesc('created_at')->get();
        $notification_count=Notifications::where('read','0')->where('identifier','0')->count();
        return response()->json([
            'notification'=>$notification,
            'notification_count'=>$notification_count,
        ],200);
    }

    public function get_notification_donor(){
        $notification=Notifications::with('donors')->where('donor_id',Auth::guard('donor')->id())->where('read','0')->where('identifier','1')->orderByDesc('created_at')->get();
        $notification_count=Notifications::where('donor_id',Auth::guard('donor')->id())->where('read','0')->where('identifier','1')->count();
        return response()->json([
            'notification'=>$notification,
            'notification_count'=>$notification_count,
        ],200);
    }
    public function read_notification($id){
        $update=Notifications::where('id',$id)->first();
        $notif['read']='1';
        $update->update($notif);
    }

    public function get_donation_view($id){
        $donations=Donations::with('events')->where('id',$id)->first();
        return response()->json([
            'donations'=>$donations,
        ],200);
    }
}
