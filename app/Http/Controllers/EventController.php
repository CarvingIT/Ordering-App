<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Models\User;
use \App\Models\Event;
use Session;

class EventController extends Controller
{
    //
	public function index(Request $request){
	if($request->is('api/*')){
                $events = Event::whereNotNull('show_till')
			->whereDate('show_till','>=',NOW())
                        ->skip($request->offset)->take($request->length)
                        ->orderBy('id','DESC')
                        ->get();
                return response()->json(['MessageType'=>1, 'events'=>$events], 200);
        }
        else{
        $events = Event::all();
        return view('eventmanagement', ['events'=>$events, 'activePage'=>'Events','titlePage'=>'Events']);
	}
        }

	public function viewEvent($event_id){
        $event= Event::find($event_id);
        return view('eventdetails', ['event'=>$event]);
        }

        public function addEditEvent($event_id){
        if($event_id == 'new'){
            $event = new Event();
        }
        else{
            $event = Event::find($event_id);
        }
        return view('event-form', ['event'=>$event,
                        'activePage'=>'Event', 'titlePage'=>'Event']);
        }

	public function save(Request $request){
         if(empty($request->input('event_id'))){
            $e = new Event;
         }
         else{
            $e = Event::find($request->input('event_id'));
         }
         $referer = $request->input('referer');
         $e->show_till = date('Y-m-d', strtotime($request->input('show_till')));
         $e->title = $request->input('title');
         $e->announcement = $request->input('announcement');

         try{
         $e->save();
         Session::flash('alert-success', 'Event saved successfully!');
         }
         catch(\Exception $e){
            Session::flash('alert-danger', $e->getMessage());
         }

         return redirect($referer);
        }

	public function deleteEvent(Request $request){
                $event = \App\Models\Event::find($request->event_id);
                if($event->delete()){
                Session::flash('alert-success', 'Event deleted successfully!');
                return redirect('/admin/events');
                }
        }


####
} ## Class Ends
