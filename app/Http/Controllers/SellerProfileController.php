<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Models\User;
use \App\Models\SellerProfile;
use Session;

class SellerProfileController extends Controller
{
	public function index(Request $request){
	if($request->is('api/*')){
		$sellers = SellerProfile::skip($request->offset)->take($request->length)
			->orderBy('id','DESC')
			->get();
        	return response()->json(['MessageType'=>1, 'sellers'=>$sellers], 200);
        }
        else{
        	$sellers = SellerProfile::all();
        	return view('sellermanagement', ['sellers'=>$sellers, 'activePage'=>'Users','titlePage'=>'Users']);
	}
        }// function ends

	public function getMyBusinesses(Request $request){
	if($request->is('api/*')){
		$sellers = SellerProfile::where('user_id',auth()->user()->id)
			->skip($request->offset)->take($request->length)
			->orderBy('id','DESC')
			->get();
        	return response()->json(['MessageType'=>1, 'sellers'=>$sellers], 200);
        }
        else{
        	$sellers = SellerProfile::where('user_id',auth()->user()->id)->get();
        	return view('sellermanagement', ['sellers'=>$sellers, 'activePage'=>'Users','titlePage'=>'Users']);
	}
        }// function ends

	

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
	 if(auth()->user()->hasRole('admin')){
	 $u->user_id = $request->input('user_id');
	 }
	 else{
	 $u->user_id = auth()->user()->id;
	 }

         try{
            $u->save();
            $seller_id = $u->id;
	    if($request->is('api/*')){
               return response()->json(['MessageType'=>1, 'Message'=>'Seller Profile details saved successfully'], 200);
            }
            else{
            	Session::flash('alert-success', "Seller profile details saved successfully");
	    }
         }
         catch(\Exception $e){
	    if($request->is('api/*')){
                return response()->json(['MessageType'=>0, 'Message'=>'Please try again later', 'error'=>$e->getMessage()], 422);
            }
            else{
            	Session::flash('alert-danger', $e->getMessage());
	    }
         }
	return redirect('/admin/sellerprofiles');
        }

	public function viewSeller(Request $request){
        $seller = SellerProfile::where('id',$request->seller_id)
                ->first();
	$users = \App\Models\User::all();
	    if($request->is('api/*')){
               return response()->json(['MessageType'=>1, 'seller'=>$seller, 'users'=>$users], 200);
            }
            else{
        	return view('sellerdetails', ['seller'=>$seller, 'users'=>$users, 'activePage'=>'Seller','titlePage'=>'Seller']);
	    }
        }

        public function deleteSeller(Request $request){
        $seller = SellerProfile::find($request->seller_id);
          if(!empty($seller)){
			$products = \App\Models\Product::where('seller_id',$request->seller_id)->get();
			if(!empty($products)){
				foreach($products as $product){
					$product_images = \App\Models\ProductImage::where('product_id',$product->id)->get();
			                if(!empty($product_images)){
                			foreach($product_images as $img){
                        			$img->delete();
                			}
                			}
                			$product_videos = \App\Models\ProductVideo::where('product_id',$product->id)->get();
                			if(!empty($product_videos)){
                			foreach($product_videos as $video){
                        			$video->delete();
                			}
					}
				$product->delete();
				}	
			}
                if($seller->delete()){
	    		if($request->is('api/*')){
               		return response()->json(['MessageType'=>1, 'Message'=>'Seller profile deleted successfully'], 200);
            		}
            		else{
                		Session::flash('alert-success', 'Seller profile deleted successfully!');
                		return redirect('/admin/sellerprofiles');
	    		}
                }
          }
        }


//#####
}// class ends
