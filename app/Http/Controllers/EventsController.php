<?php

namespace App\Http\Controllers;

use Event;
use Illuminate\Http\Request;
use App\Http\Requests\EventsRequest;
use App\Models\Events;
use App\Models\Barangay;

class EventsController extends Controller
{
    public function create_event(Request $request){
        $formData=[
            'event_name'=>'',
            'event_description'=>'',
            'barangay'=>0,
            'event_address'=>'',
            'event_time'=>'',
            'start_date'=>'',
            'end_date'=>'',
            'event_color'=>''
        ];
        return response()->json($formData);
    }

    public function add_event(EventsRequest $request){
        $validated=$request->validated();
        $barangay_name=Barangay::where('id',$request->barangay)->value('barangay_name');
        $validated['barangay_name']=$barangay_name;
        Events::create($validated);
    }

    public function get_events(){
        $event=Events::orderBy('event_name','ASC')->get();
        $eventall=[];
        foreach($event AS $b){
            $eventall[]=[
                'id'=>$b->id,
                $b->event_name,
                $b->event_description,
                $b->barangay_name,
                $b->event_address,
                date("H:i A",strtotime($b->event_time)),
                $b->start_date,
                $b->end_date,
                ''
            ];
        }
        return response()->json([
            'eventall'=>$eventall,
        ],200);
    }
    public function get_dashboard_events(){
        $event=Events::orderBy('event_name','ASC')->get();
        $eventall=array();
        foreach($event AS $b){
            // $background_colors = array('#282E33', '#25373A', '#164852', '#495E67');
            // $rand_background = $background_colors[array_rand($background_colors)];
            $eventall[]=[
                'title'=>$b->event_name,
                'start'=>$b->start_date,
                'end'=>date('Y-m-d',strtotime($b->end_date. ' +1 day')),
                'color'=>$b->event_color,
                'time'=>date("H:i A",strtotime($b->event_time)),
                'description'=>$b->event_description,
                'address'=>$b->event_address,
            ];
        }
        return response()->json([
            'eventall'=>$eventall,
        ],200);
    }

    public function edit_event($id){
        $events=Events::where('id',$id)->first();
        return response()->json([
            'events'=>$events,
        ],200);
    }
    public function update_event(EventsRequest $request, $id){
        $update=Events::where('id',$id)->first();
        $validated=$request->validated();
        $barangay_name=Barangay::where('id',$request->barangay)->value('barangay_name');
        $validated['barangay_name']=$barangay_name;
        $update->update($validated);
    }
    public function delete_event($id){
        $deleted = Events::find($id);
        $deleted->delete();
    }

    public function today_event(){
        $date=date('Y-m-d');
        $start_date=Events::where('start_date',$date)->value('start_date');
        $end_date=Events::where('end_date',$date)->value('end_date');
        $events_today=Events::where('start_date',$date)->whereBetween('start_date',[$date, $start_date])->orWhereBetween('end_date', [$date,$end_date])->get();
        return response()->json([
            'events_today'=>$events_today,
        ],200);
    }
}
