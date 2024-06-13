@push('js')
<link rel="stylesheet" href="/css/all.min.css" />
<link rel="stylesheet" href="/css/jquery.dataTables.min.css" />
<link rel="stylesheet" href="/css/jquery-ui.css" />
<script src="/js/jquery-3.5.1.js"></script>
<script src="/js/jquery.dataTables.min.js"></script>
<script src="/js/jquery-ui.js"></script>
<style>
/*tree view */

ul, #myUL {
  list-style-type: none;
}

#myUL {
  margin: 0;
  padding: 0;
}

#myUL li{
	padding-left:40px;
}

.caret {
  cursor: pointer;
  -webkit-user-select: none; /* Safari 3.1+ */
  -moz-user-select: none; /* Firefox 2+ */
  -ms-user-select: none; /* IE 10+ */
  user-select: none;
}

.caret::before {
  content: "\25B6";
  color: black;
  display: inline-block;
  margin-right: 6px;
}

.caret-down::before {
  -ms-transform: rotate(90deg); /* IE 9 */
  -webkit-transform: rotate(90deg); /* Safari */
  transform: rotate(90deg);  
}

.nested {
  display: none;
}

.active {
  display: block;
}
</style>
<script>
function showDeleteDialog(category_id){

$('#delete_category_id').val(category_id);
$("#deletedialog").dialog({
        title:'Are you sure?',
        dialogClass: "alert"
});
}
</script>
@endpush
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Taxonomies') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
@php
    $tags = \App\Models\Taxonomy::all();

    $children = []; 
    foreach($tags as $t){
        $children['parent_'.$t->parent_id][] = $t; 
    }   
    function getTree($children, $parent_id = 0){
        if(empty($children['parent_'.$parent_id])) return;
        foreach($children['parent_'.$parent_id] as $t){
                if(!empty($children['parent_'.$t->id]) && count($children['parent_'.$t->id]) > 0){ 
                    echo '<li>';
                    echo '<span class="caret">'.$t->label.'</span>';
                    echo '<a href="/admin/taxonomy-form/new/'.$t->id.'" rel="tooltip" class="btn btn-success btn-link">
                    <span class="fas fa-plus"></span></a>';
                    echo '<a href="/admin/taxonomy-form/'.$t->id.'" rel="tooltip" class="btn btn-success btn-link">
                    <span class="fas fa-edit"></span></a>';
                    echo '<ul class="nested">';
                    getTree($children, $t->id);
                    echo '</ul>';
                    echo '</li>';
                }   
                else{
                    echo '<li>';
                    echo $t->label;
                     echo '<a href="/admin/taxonomy-form/new/'.$t->id.'" rel="tooltip" class="btn btn-success btn-link">
                    <span class="fas fa-plus"></span></a>
                     <a href="/admin/taxonomy-form/'.$t->id.'" rel="tooltip" class="btn btn-success btn-link">
			<span class="fas fa-edit"></span>
                    </a>
                 <button onClick="showDeleteDialog(\''.$t->id.'\');"><span class="fas fa-trash"></span></button>';
                    echo '</li>';
                }
        }
    }
			@endphp

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden sm:rounded-lg">
                <div class="text-right">
                        <a class="m-5" title="New Taxonomy" href="/admin/taxonomy-form/new"><span class="fas fa-plus"></span></a>
                </div>
            <ul id="myUL">
                @php
                    getTree($children);
                @endphp
            </ul>
			</div>
		</div>
	</div>
			<div id="deletedialog" style="display:none;" class="bg-grey">
                <form name="deletedoc" method="post" action="/admin/category/delete">
                @csrf
                <input type="hidden" id="delete_category_id" name="category_id" value="" />
                        This action can not be undone.
                        <div class="flex items-center justify-end px-4 py-3 sm:px-6">
                        <button type="submit" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:shadow-outline-gray disabled:opacity-25 transition ease-in-out duration-150 m-1" wire:loading.attr="disabled">Delete</button>
                        <button type="button" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:shadow-outline-gray disabled:opacity-25 transition ease-in-out duration-150 m-1" wire:loading.attr="disabled" onclick="document.location='/admin/taxonomies';">Cancel</button>
                        </div>
                </form>
           </div>
<script>
var toggler = document.getElementsByClassName("caret");
var i;

for (i = 0; i < toggler.length; i++) {
  toggler[i].addEventListener("click", function() {
    this.parentElement.querySelector(".nested").classList.toggle("active");
    this.classList.toggle("caret-down");
  });
}
</script>

</x-app-layout>
