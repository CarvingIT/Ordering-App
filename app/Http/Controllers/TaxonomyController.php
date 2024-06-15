<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Models\Taxonomy;
use Session;

class TaxonomyController extends Controller
{
	public function index(Request $request){
        $taxonomies = Taxonomy::orderBy('label','ASC')->get();
	if($request->is('api/*')){
                return response()->json(['MessageType'=>1, 'taxonomies'=>$taxonomies], 200);
        }
        else{
        	return view('taxonomymanagement', ['taxonomies'=>$taxonomies, 'activePage'=>'Taxonomies','titlePage'=>'Taxonomies']);
	}
        }

        public function addEditTaxonomy($taxonomy_id, $parent_id=null){
        if($taxonomy_id == 'new'){
            $taxonomy = new Taxonomy();
        }
        else{
            $taxonomy = Taxonomy::find($taxonomy_id);
        }
        $parents=array();
        $parents= Taxonomy::orderBy('label', 'ASC')->get();
        return view('taxonomy-form', ['taxonomy'=>$taxonomy, 'parents'=>$parents,
                                        'child_of' => $parent_id,
                                        'activePage'=>'Taxonomy Management',
                                        'titlePage'=>'Taxonomy Management']);
        }

	public function save(Request $request){
        if(empty($request->input('taxonomy_id'))){
            $e = new Taxonomy;
         }
         else{
            $e = Taxonomy::find($request->input('taxonomy_id'));
         }
        $e->label = $request->input('label');
        $e->parent_id = $request->input('parent_id');
        try{
            $e->save();
	    if($request->is('api/*')){
                return response()->json(['MessageType'=>1, 'Message'=>'Taxonomy saved successfully'], 200);
            }
            else{
                Session::flash('alert-success', 'Taxonomy saved successfully!');
	    }
         }
         catch(\Exception $e){
	    if($request->is('api/*')){
                return response()->json(['MessageType'=>0, 'Message'=>'Please try again', 'error'=>$e->getMessage()], 422);
            }
            else{
            	Session::flash('alert-danger', $e->getMessage());
	    }
         }
                return redirect('/admin/taxonomies');
        }

	public function deleteCategory(Request $request){
		//echo $request->category_id; exit;
                $taxonomy = \App\Models\Taxonomy::find($request->category_id);
                $children = array();
                //if($taxonomy->parent_id != 0){
                        $children = Taxonomy::where('parent_id',$taxonomy->id)->get();
			if(!$children->isEmpty()){
                                foreach($children as $child){
					$category_products = \App\Models\Product::where('taxonomy_id',$child->id)->get();
					if(!empty($category_products)){
						foreach($category_products as $product){
							$images = \App\Models\ProductImage::where('product_id',$product->id)->get();
							if(!empty($images)){
							foreach($images as $image){
								$image->delete();
					 		}			 
							}	
							$videos = \App\Models\ProductVideo::where('product_id',$product->id)->get();
							if(!empty($videos)){
							foreach($videos as $video){
								$video->delete();
					 		}			 
							}	
							$product->delete();
						}
					}
                        	$child->delete();
                                }
                        }
			else{
				$category_products = \App\Models\Product::where('taxonomy_id',$taxonomy->id)->get();
				if(!empty($category_products)){
					foreach($category_products as $product){
							$images = \App\Models\ProductImage::where('product_id',$product->id)->get();
							if(!empty($images)){
							foreach($images as $image){
								$image->delete();
					 		}			 
							}	
							$videos = \App\Models\ProductVideo::where('product_id',$product->id)->get();
							if(!empty($videos)){
							foreach($videos as $video){
								$video->delete();
					 		}			 
							}	
						$product->delete();
					}
				}
			}
		$taxonomy->delete();
                //}
                //else{
		//	echo "SKK"; exit;
		//		$category_products = \App\Models\Product::where('taxonomy_id',$taxonomy->id)->get();
		//		if(!empty($category_products)){
		//			foreach($category_products as $product){
		//				$product->delete();
		//			}
		//		}
                 //       $taxonomy->delete();
                //}
                Session::flash('alert-success', 'Taxonomy deleted successfully!');
                return redirect('/admin/taxonomies');
        }


    //
}
