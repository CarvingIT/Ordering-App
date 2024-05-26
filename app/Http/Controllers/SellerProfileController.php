<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\SellerProfile;
use Session;

class SellerProfileController extends Controller
{
	public function index(){
        $sellers = SellerProfile::all();
        return view('sellermanagement', ['sellers'=>$sellers, 'activePage'=>'Users','titlePage'=>'Users']);
        }

	public function addEditSellerProfile($seller_id){
        if($seller_id == 'new'){
            $seller = new SellerProfile();
        }
        else{
            $seller = SellerProfile::find($seller_id);
        }
	$users = \App\Models\User::all();
        return view('seller-profile-form', ['seller'=>$seller,  'users'=>$users, 'activePage'=>'Seller', 'titlePage'=>'Seller']);
        }
	
	public function save(Request $request){
         if(empty($request->input('seller_id'))){
            $u = new SellerProfile;
         }
         else{
            $u = SellerProfile::find($request->input('seller_id'));
         }
         $u->business_name = $request->input('business_name');
         $u->address = $request->input('address');
         $u->description = $request->input('description');
         $u->business_email = $request->input('business_email');
         $u->business_phone = $request->input('business_phone');
	 if(empty($request->user_id)){
	 $u->user_id = auth()->user()->id;
	 }
	 else{
	 $u->user_id = $request->input('user_id');
	 }

         try{
            $u->save();
            $seller_id = $u->id;
            Session::flash('alert-success', "Seller profile details saved successfully");
         }
         catch(\Exception $e){
            Session::flash('alert-danger', $e->getMessage());
         }
	return redirect('/admin/sellerprofiles');
        }

	public function viewSeller(Request $request){
        $seller = SellerProfile::where('id',$request->seller_id)
                ->first();
	$users = \App\Models\User::all();
        return view('sellerdetails', ['seller'=>$seller, 'users'=>$users, 'activePage'=>'Seller','titlePage'=>'Seller']);
        }

        public function deleteSeller(Request $request){
        $user = SellerProfile::find($request->user_id);
          if(!empty($user)){
                if($user->delete()){
                Session::flash('alert-success', 'Seller profile deleted successfully!');
                return redirect('/admin/sellerprofiles');
                }
          }
        }


//#####
}// class ends
