<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Models\Taxonomy;
use \App\Models\Product;
use \App\Models\SellerProfile;
use Session;

class ProductController extends Controller
{
	public function index(Request $request){
        $products = Product::all();
	if($request->is('api/*')){
           	return response()->json(['MessageType'=>1, 'products'=>$products], 200);
        }
        else{
        	return view('productsmanagement', ['products'=>$products, 'activePage'=>'Products','titlePage'=>'Products']);
	}
        }// function ends

        public function addEditProduct($product_id){
        if($product_id == 'new'){
            $product = new Product();
        }
        else{
            $product = Product::find($product_id);
        }
	$sellers = SellerProfile::all();
	$taxonomies = Taxonomy::all();
        return view('product-form', ['product'=>$product, 'sellers'=>$sellers, 'taxonomies'=>$taxonomies, 'activePage'=>'Product', 'titlePage'=>'Product']);
        }// function ends

	public function save(Request $request){
         if(empty($request->input('product_id'))){
            $p = new Product;
         }
         else{
            $p = Product::find($request->input('product_id'));
         }
         $p->product_name = $request->input('product_name');
         $p->description = $request->input('description');
	 $p->taxonomy_id = $request->input('category_id');
         if(empty($request->input('seller_id'))){
	 	$seller_details = \App\Models\SellerProfile::where('user_id',auth()->user()->id)->first();		
	 	$p->seller_id = $seller_details->id;
	 }
	 else{
         	$p->seller_id = $request->input('seller_id');
	 }

         try{
            $p->save();
            $product_id = $p->id;
	    if($request->is('api/*')){
                return response()->json(['MessageType'=>1, 'Message'=>'Product Details saved successfully','Product ID'=>$product_id], 200);
            }
            else{
            	Session::flash('alert-success', "Products's details saved successfully");
	    }
         }
         catch(\Exception $e){
		if($request->is('api/*')){
                        return response()->json(['MessageType'=>0, 'Message'=> 'Please try again', 'error'=>$e->getMessage()], 422);
                }else{
            		Session::flash('alert-danger', $e->getMessage());
		}
         }
        return redirect('/admin/products');
        }// function ends

	public function viewProduct(Request $request){
        	$product = Product::where('id',$request->product_id)->first();
		$sellers = SellerProfile::all();
		$taxonomies = Taxonomy::all();
		if($request->is('api/*')){
                	return response()->json(['MessageType'=>1, 'product'=>$product, 'sellers'=>$sellers, 'taxonomies'=>$taxonomies], 200);
        	}
        	else{
        		return view('productdetails', ['product'=>$product, 'sellers'=>$sellers, 'taxonomies'=>$taxonomies, 'activePage'=>'Products','titlePage'=>'Products']);
		}
        }// function ends

        public function deleteProduct(Request $request){
        $product = Product::find($request->product_id);
          if(!empty($product)){
                if($product->delete()){
                Session::flash('alert-success', 'Product deleted successfully!');
                return redirect('/admin/products');
                }
          }
        }// function ends


    //
} //class ends
