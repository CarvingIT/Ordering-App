<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Session;

class UserController extends Controller
{
	public function index(){
        $users = User::all();
        $users = User::where('deleted_at',NULL)
                        ->get();
        return view('usermanagement', ['users'=>$users, 'activePage'=>'Users','titlePage'=>'Users']);
        }

	public function addEditUser($user_id){
        if($user_id == 'new'){
            $user = new User();
        }
        else{
            $user = User::find($user_id);
        }
        return view('user-form', ['user'=>$user, 'activePage'=>'User', 'titlePage'=>'User']);
        }
	
	public function save(Request $request){
         if(empty($request->input('user_id'))){
            $u = new User;
         }
         else{
            $u = User::find($request->input('user_id'));
         }
         $u->name = $request->input('name');
         $u->email = $request->input('email');
	 if(!empty($request->input('password'))){
         $u->password = Hash::make($request->input('password'));
         if(!empty($request->input('password'))){
                $u->email_verified_at = time();
         }
         }

         try{
            $u->save();
            $user_id = $u->id;
            Session::flash('alert-success', "Person's details saved successfully");
         }
         catch(\Exception $e){
            Session::flash('alert-danger', $e->getMessage());
         }
	return redirect('/admin/people');
        }

	public function viewUser(Request $request){
        $user = User::where('id',$request->user_id)
                ->first();
        return view('userdetails', ['user'=>$user, 'activePage'=>'Users','titlePage'=>'Users']);
        }

        public function deleteUser(Request $request){
        $user = User::find($request->user_id);
          if(!empty($user)){
                if($user->delete()){
                Session::flash('alert-success', 'Person deleted successfully!');
                return redirect('/admin/people');
                }
          }
        }



//#####
}// class ends
