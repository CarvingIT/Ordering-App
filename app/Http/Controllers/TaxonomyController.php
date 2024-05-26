<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Models\Taxonomy;
use Session;

class TaxonomyController extends Controller
{
	public function index(){
        $taxonomies = Taxonomy::orderBy('label','ASC')->get();
        return view('taxonomymanagement', ['taxonomies'=>$taxonomies, 'activePage'=>'Taxonomies','titlePage'=>'Taxonomies']);
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
            Session::flash('alert-success', 'Taxonomy saved successfully!');
         }
         catch(\Exception $e){
            Session::flash('alert-danger', $e->getMessage());
         }
                return redirect('/admin/taxonomies');
        }

	public function deleteTaxonomy(Request $request){
                $taxonomy = \App\Models\Taxonomy::find($request->taxonomy_id);
                $children = array();
                if($taxonomy->parent == 0){
                        $children = Category::where('parent',$taxonomy->id)->get();
                        if($taxonomy->delete()){
                                foreach($children as $child){
                                        $child->delete();
                                }
                        }
                }
                else{
                        $taxonomy->delete();
                }
                Session::flash('alert-success', 'Taxonomy deleted successfully!');
                return redirect('/admin/taxonomies');
        }


    //
}
