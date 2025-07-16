<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Models\User;
use \App\Models\Announcement;
use Session;

class AnnouncementController extends Controller
{
    //
	public function index(Request $request){
	if($request->is('api/*')){
                $announcements = Announcement::whereNotNull('show_till')
			->whereDate('show_till','>=',NOW())
                        ->skip($request->offset)->take($request->length)
                        ->orderBy('id','DESC')
                        ->get();
                return response()->json(['MessageType'=>1, 'announcements'=>$announcements], 200);
        }
        else{
        $announcements = Announcement::all();
        return view('announcementmanagement', ['announcements'=>$announcements, 'activePage'=>'Announcement','titlePage'=>'Announcement']);
	}
        }

	public function viewAnnouncement($announcement_id){
        $announcement= Announcement::find($announcement_id);
        return view('announcementdetails', ['announcement'=>$announcement]);
        }

        public function addEditAnnouncement($announcement_id){
        if($announcement_id == 'new'){
            $announcement = new Announcement();
        }
        else{
            $announcement = Announcement::find($announcement_id);
        }
        return view('announcement-form', ['announcement'=>$announcement,
                        'activePage'=>'Announcement', 'titlePage'=>'Announcement']);
        }

	public function save(Request $request){
         if(empty($request->input('announcement_id'))){
            $e = new Announcement;
         }
         else{
            $e = Announcement::find($request->input('announcement_id'));
         }
         $referer = $request->input('referer');
         $e->show_till = date('Y-m-d', strtotime($request->input('show_till')));
         $e->title = $request->input('title');
         $e->announcement = $request->input('announcement');

         try{
         $e->save();
         Session::flash('alert-success', 'Announcement saved successfully!');
         }
         catch(\Exception $e){
            Session::flash('alert-danger', $e->getMessage());
         }

         return redirect($referer);
        }

	public function deleteAnnouncement(Request $request){
                $announcement = \App\Models\Announcement::find($request->announcement_id);
                if($announcement->delete()){
                Session::flash('alert-success', 'Announcement deleted successfully!');
                return redirect('/admin/announcements');
                }
        }


####
} ## Class Ends
