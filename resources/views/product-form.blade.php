<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
	@if(empty($product->id))
            {{ __('New Product') }}
	@else
            {{ __('Edit Product') }}
	@endif
        </h2>
    </x-slot>

<!--Resume Flyer Validatiobn-->
<script type="text/javascript">
function ImagefileValidation(){
    var fileInput = document.getElementById('image_path');
    var filePath = fileInput.value;
    var allowedExtensions = /(\.jpg|\.jpeg|\.png|\.gif)$/i;
    if(!allowedExtensions.exec(filePath)){
        alert('Please upload file having extensions .jpeg/.jpg/.png/.gif only.');
        fileInput.value = '';
        return false;
    }else{
        //Image preview
        if (fileInput.files && fileInput.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('imagePreview').innerHTML = '<img src="'+e.target.result+'"/>';
            };
            reader.readAsDataURL(fileInput.files[0]);
        }
    }
        if (fileInput.files[0].size > 2097152){
                        alert('File size is more than 2MB');
                        fileInput.value = '';
                        return false;
                    }
}

</script>


    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
	        <div class="p-6 sm:px-20 bg-white border-b border-gray-200">
    			<div class="mt-6 text-gray-500">
				<form name="save-user" action="/admin/saveproduct" method="post" enctype="multipart/form-data">
				<input type="hidden" name="product_id" value="{{ $product->id }}" />	
				<input type="hidden" name="referer" value="@php if(!empty($_SERVER['HTTP_REFERER'])){echo $_SERVER['HTTP_REFERER'];} @endphp">
				@csrf	
<h2>Product Details </h2>
<div class="overflow-hidden sm:rounded-md">
    <div class="px-4 py-5 bg-white sm:p-6 text-gray-900">
	<div class="grid grid-cols-6 gap-6">

        <div class="col-span-4">
             <label class="block font-medium text-sm" for="sellers">Sellers</label>
		<select class="form-input rounded-md shadow-sm mt-1 block w-full" id="seller_id" name="seller_id">
		@foreach($sellers as $seller)
                <option value="{{ $seller->id }}" @if($seller->id == $product->seller_id) selected @endif>{{ $seller->business_name }}</option>
		@endforeach
             </select>
        </div>
	<br />

        <div class="col-span-4">
             <label class="block font-medium text-sm" for="product_name">Product Name</label>
             <input class="form-input rounded-md shadow-sm mt-1 block w-full" id="product_name" name="product_name" type="text" value="{{ $product->product_name }}" >
        </div>
	<br />

        <div class="col-span-4">
             <label class="block font-medium text-sm" for="categories">Categories</label>
		<select class="form-input rounded-md shadow-sm mt-1 block w-full" id="category_id" name="category_id">
		@foreach($taxonomies as $taxonomy)
                <option value="{{ $taxonomy->id }}" @if($taxonomy->id == $product->taxonomy_id) selected @endif>{{ $taxonomy->label }}</option>
		@endforeach
             </select>
        </div>
	<br />

    	<div class="col-span-4">
      	<label for="name">Upload Product Image</label>
		<ul>
		@foreach($product_images as $photo)
		<li><a href="/product/{{ $product->id }}/loadimage/{{ $photo->id }}" target="_blank"><img src="/product/{{ $product->id }}/loadimage/{{ $photo->id }}" width="150" height="150"></a><br /></li>
		@endforeach
		</ul>
		<br />
             <input id="image_path" type="file" name="image_path" onchange="return ImagefileValidation()">
                <p class="small">Flyer images of type jpg, png,jpeg,gif are allowed. Allowed maximum size is 2MB.</p>
    	</div>
	<br />

        <div class="col-span-4">
             <label class="block font-medium text-sm" for="product_video">Product Video URL</label>
		<ul>
		@foreach($product_videos as $video)
			<li><a href="{{ $video->video_url }}" target="_blank">Click here to view video</a><br /></li>
		@endforeach
		</ul>
             <input class="form-input rounded-md shadow-sm mt-1 block w-full" id="video_url" name="video_url" type="text" value="" >
        </div>
	<br />

        <div class="col-span-4">
             <label class="block font-medium text-sm" for="description">Description</label>
             <textarea class="form-input rounded-md shadow-sm mt-1 block w-full" id="description" rows="5" name="description">{{ $product->description }}</textarea>
        </div>
	<br />

    </div>
    </div>

@if(Auth::user()->hasRole('admin'))
    <div class="flex items-center justify-end px-4 py-3 text-right sm:px-6">
     <button type="submit" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:shadow-outline-gray disabled:opacity-25 transition ease-in-out duration-150 m-1" wire:loading.attr="disabled">
    Save
     </button>
     <button type="button" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:shadow-outline-gray disabled:opacity-25 transition ease-in-out duration-150 m-1" wire:loading.attr="disabled" onclick="window.history.back();">
    Cancel
     </button>
   </div>
@endif
                            </div>
				</form>
                        </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
