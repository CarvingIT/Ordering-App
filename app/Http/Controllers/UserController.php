<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Role;
use App\Models\UserRole;
use Session;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
	public function index(Request $request){
        $users = User::all();
        //$users = User::where('deleted_at',NULL)
         //               ->get();
	if($request->is('api/*')){
                return response()->json(['MessageType'=>1, 'users'=>$users], 200);
        }
        else{
        	return view('usermanagement', ['users'=>$users, 'activePage'=>'Users','titlePage'=>'Users']);
	}
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

/***** Mobile app API related functions start here *****/

        public function login(Request $request)
        {
                $credentials = [
                        'email' => $request->email,
                        'password' => $request->password
                ];
                if (auth()->attempt($credentials)) {
                        //$token = auth()->user()->createToken('orderingapp_token')->accessToken;
                        $token = auth()->user()->createToken('orderingapp_token')->plainTextToken;
                        $profile = auth()->user()->profile;
			$roles = auth()->user()->roles()->get();
			$role_names = [];
			foreach($roles as $role){
				$role_name = \App\Models\Role::find($role->role_id);
				$role_names[] = $role_name->name;
			}
                        return response()->json(['MessageType'=>1,
                                        'Message'=>'Authentication successful',
                                        'user_details' => auth()->user(),
					//'Roles' => $roles,
					'role_names' => $role_names,
                                        'token' => $token], 200);
                } else {
                        return response()->json(['MessageType'=>0, 'Message'=>'UnAuthorised'], 401);
                }
        }

	public function assignRole(Request $request){
	//echo "SKK"; exit;
		$user_id = $request->input('user_id');
		$role_name = $request->input('role_name');
		$role = \App\Models\Role::where('name',$role_name)->first();
		$role_id = $role->id;
		$user = User::find($user_id);
		if(!$user->hasRole('Seller')){
			$ur = new UserRole;
			$ur->user_id = $user_id;
			$ur->role_id = $role_id;
		}	
         try{
            $ur->save();
		if($request->is('api/*')){
                return response()->json(['MessageType'=>1, 'Message'=>$role_name.' role assigned successfully'], 200);
        	}
		else{
            	Session::flash('alert-success', "Person's details saved successfully");
		}		
         }
         catch(\Exception $e){
		if($request->is('api/*')){
                return response()->json(['MessageType'=>0, 'Message'=>'Please try again','error'=>$e->getMessage()], 422);
        	}
		else{
                Session::flash('alert-danger', $e->getMessage());
		}
         }
	}// function ends

	public function register(Request $request)
        {
            $validator = Validator::make($request->all(), [
            'name' => 'required|min:3',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
                ]);
                if($validator->fails()){
                        $message = "Registration failed.";
                        $message_bag = (array) json_encode($validator->messages());
                        foreach($message_bag as $m){
                                $m = (array) json_decode($m);
                                foreach($m as $k=>$v){
                                        $message .= ' '.implode('. ',$v);
                                }
                        }
                return response()->json(['MessageType'=>0, 'Message'=> $message, 'error'=>$validator->messages()], 422);
                }
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password)
        ]);

        //$token = $user->createToken('orderingapp_token')->accessToken;
        $token = $user->createToken('orderingapp_token')->plainTextToken;

        return response()->json(['MessageType'=>1, 'Message'=>'Registration successful', 'token' => $token], 200);
    }



//#####
}// class ends
