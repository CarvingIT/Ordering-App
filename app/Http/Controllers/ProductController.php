<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Carbon;
use \App\Models\Taxonomy;
use \App\Models\Product;
use \App\Models\SellerProfile;
use \App\Models\ProductImage;
use \App\Models\ProductVideo;
use Session;

class ProductController extends Controller
{
	public function index(Request $request){
	if($request->is('api/*')){
		$products = Product::whereNotNull('approved')
			->skip($request->offset)->take($request->length)
			->orderBy('id','DESC')
			->get();
           	return response()->json(['MessageType'=>1, 'products'=>$products], 200);
        }
        else{
        	$products = Product::all();
        	return view('productsmanagement', ['products'=>$products, 'activePage'=>'Products','titlePage'=>'Products']);
	}
        }// function ends

	public function getMyProducts(Request $request){
	$seller_ids = SellerProfile::where('user_id',auth()->user()->id)->get();
	$sellers = [];
	foreach($seller_ids as $seller){
		$sellers[] = $seller->id;
	}	
	if($request->is('api/*')){
        	$products = Product::wherein('seller_id',$sellers)
			->skip($request->offset)->take($request->length)
			->orderBy('id','DESC')
			->get();
           	return response()->json(['MessageType'=>1, 'products'=>$products], 200);
        }
        else{
        	$products = Product::wherein('seller_id',$sellers)->get();
        	return view('productsmanagement', ['products'=>$products, 'activePage'=>'Products','titlePage'=>'Products']);
	}
        }// function ends

	public function getCategoryProducts(Request $request){
	if($request->is('api/*')){
        	$products = Product::where('taxonomy_id',$request->category_id)
			->whereNotNull('approved')
			->skip($request->offset)->take($request->length)
			->orderBy('id','DESC')
			->get();
           	return response()->json(['MessageType'=>1, 'products'=>$products], 200);
        }
        else{
        	$products = Product::where('taxonomy_id',$request->category_id)->get();
        	return view('productsmanagement', ['products'=>$products, 'activePage'=>'Products','titlePage'=>'Products']);
	}
        }// function ends

        public function addEditProduct($product_id){
	$product_images = $product_videos = [];
        if($product_id == 'new'){
            $product = new Product();
        }
        else{
            $product = Product::find($product_id);
	    $product_images = ProductImage::where('product_id',$product_id)->get();
	    $product_videos = ProductVideo::where('product_id',$product_id)->get();
        }
	$sellers = SellerProfile::all();
	$taxonomies = Taxonomy::all();
        return view('product-form', ['product'=>$product, 'sellers'=>$sellers, 
		'taxonomies'=>$taxonomies, 'product_images'=>$product_images, 'product_videos'=>$product_videos,
		'activePage'=>'Product', 'titlePage'=>'Product']);
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
	 if(!empty($request->input('approved'))){
		$p->approved = Carbon::now();
	 }
            $p->save();
            $product_id = $p->id;

	##### Photo Gallery
        //print_r($request->image_path);exit;

	if(!empty($request->image_path)){
        //print_r($request->image_path);exit;

                $filename = $request->file('image_path')->getClientOriginalName();
                //$filename = $photo->getClientOriginalName();
                $new_filename = $product_id.'_'.time().'_'.$filename;

                ### Saved for chosen artist.
                $filepath = $request->file('image_path')->storeAs('product_photo_gallery/'.$product_id,$new_filename);
        	//echo $filepath; exit;
                $photo= new ProductImage;
                $photo->image_path = $filepath;
                $photo->product_id = $product_id;
                //$photo->display_order = $request->display_order;
                $photo->save();
        } ## image_path ends
	if(!empty($request->video_url)){
		$video = new ProductVideo;
		$video->video_url = $request->video_url;
		$video->product_id = $product_id;
		$video->save();
	} ## video url ends

         try{
	    if($request->is('api/*')){
                return response()->json(['MessageType'=>1, 'Message'=>'Product Details saved successfully','product_id'=>$product_id], 200);
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


	public function uploadProductImage(Request $request){
	$product_id = $request->product_id;
	##### Photo Gallery
        //print_r($request->image_path);exit;

	if(!empty($request->image_path)){
        //print_r($request->image_path);exit;

                $filename = $request->file('image_path')->getClientOriginalName();
                //$filename = $photo->getClientOriginalName();
                $new_filename = $product_id.'_'.time().'_'.$filename;

                ### Saved for chosen artist.
                $filepath = $request->file('image_path')->storeAs('product_photo_gallery/'.$product_id,$new_filename);
        	//echo $filepath; exit;
                $photo= new ProductImage;
                $photo->image_path = $filepath;
                $photo->product_id = $product_id;
                //$photo->display_order = $request->display_order;
                $photo->save();
        } ## image_path ends

         try{
	    if($request->is('api/*')){
                return response()->json(['MessageType'=>1, 'Message'=>'Product Image saved successfully','product_id'=>$product_id], 200);
            }
         }
         catch(\Exception $e){
		if($request->is('api/*')){
                        return response()->json(['MessageType'=>0, 'Message'=> 'Please try again', 'error'=>$e->getMessage()], 422);
                }
         }
        }// function ends


	public function loadProductImage(Request $request){
		$product = Product::find($request->product_id);
		$photo = ProductImage::where('product_id', $request->product_id)
					->where('id',$request->photo_id)
					->first();
		$file_url = $photo->image_path;
                $file_path  = $product->image_path;
                                // remove filename prefix
                                $path_parts = explode('/',$file_path);
                                $file_name = array_pop($path_parts);
                                $file_name = preg_replace('/\d*_\d*_/','',$file_name);
                                $file_name = preg_replace('/,/','',$file_name);

                $mime = Storage::disk('local')->getDriver()->getMimetype($file_url);
                $size = Storage::disk('local')->getDriver()->getSize($file_url);

                $response =  [
                'Content-Type' => $mime,
                'Content-Length' => $size,
                'Content-Description' => 'File Transfer',
                //'Content-Disposition' => "attachment; filename={$file_name}",
                'Content-Transfer-Encoding' => 'binary',
                ];
                ob_end_clean();
                return \Response::make(Storage::disk('local')->get($file_url), 200, $response);
	}


	public function viewProduct(Request $request){
        	$product = Product::where('id',$request->product_id)->first();
		//$sellers = SellerProfile::all();
		//$taxonomies = Taxonomy::all();
		$sellers = SellerProfile::find($product->seller_id);
		$taxonomies = Taxonomy::find($product->taxonomy_id);
		$product_photos = ProductImage::where('product_id',$request->product_id)->get();
		$product_videos = ProductVideo::where('product_id',$request->product_id)->get();
		if($request->is('api/*')){
                	return response()->json(['MessageType'=>1, 'product'=>$product, 
					'product_photos'=>$product_photos,
					'product_videos'=>$product_videos,
					'sellers'=>$sellers, 'taxonomies'=>$taxonomies], 200);
        	}
        	else{
        		return view('productdetails', ['product'=>$product, 'sellers'=>$sellers, 'taxonomies'=>$taxonomies, 'activePage'=>'Products','titlePage'=>'Products']);
		}
        }// function ends

        public function deleteProduct(Request $request){
        $product = Product::find($request->product_id);
          if(!empty($product)){
		$product_images = \App\Models\ProductImage::where('product_id',$request->product_id)->get();	
		if(!empty($product_images)){
		foreach($product_images as $img){
			$img->delete();
		}
		}
		$product_videos = \App\Models\ProductVideo::where('product_id',$request->product_id)->get();	
		if(!empty($product_videos)){
		foreach($product_videos as $video){
			$video->delete();
		}
		}
                if($product->delete()){
			if($request->is('api/*')){
         			try{
                		return response()->json(['MessageType'=>1, 'Message'=>'Product deleted successfully','product_id'=>$product_id], 200);
         			}
         			catch(\Exception $e){
                        	return response()->json(['MessageType'=>0, 'Message'=> 'Please try again', 'error'=>$e->getMessage()], 422);
	 			}
			}
			else{
                		Session::flash('alert-success', 'Product deleted successfully!');
                		return redirect('/admin/products');
			}
                }
          }
        }// function ends

	public function uploadProductVideoURL(Request $request){
		$product_id = $request->product_id;
	if(!empty($request->video_url)){
		$video = new ProductVideo;
		$video->video_url = $request->video_url;
		$video->product_id = $product_id;
		$video->save();
         try{
	    if($request->is('api/*')){
                return response()->json(['MessageType'=>1, 'Message'=>'Product Video saved successfully','product_id'=>$product_id], 200);
            }
         }
         catch(\Exception $e){
		if($request->is('api/*')){
                        return response()->json(['MessageType'=>0, 'Message'=> 'Please try again', 'error'=>$e->getMessage()], 422);
                }
	 }
	} ## if of video_url empty ends
	} ## function ends		

	public function loadProductVideoURL(Request $request){
		$product_video = ProductVideo::where('product_id',$request->product_id)
				->where('id',$request->video_id)
				->get();
		if($request->is('api/*')){
			if(!empty($product_video)){
                	return response()->json(['MessageType'=>1, 'product_video'=>$product_video], 200); 
			}
			else{
                	return response()->json(['MessageType'=>0, 'Message'=>'Product videos are not available'], 422); 
			}
        	}
        }// function ends


    //
} //class ends
