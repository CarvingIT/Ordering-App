@push('js')
<link rel="stylesheet" href="/css/all.min.css" />
<link rel="stylesheet" href="/css/jquery.dataTables.min.css" />
<link rel="stylesheet" href="/css/jquery-ui.css" />
<script src="/js/jquery-3.5.1.js"></script>
<script src="/js/jquery.dataTables.min.js"></script>
<script src="/js/jquery-ui.js"></script>
@endpush

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Product Details') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
	        <div class="p-6 sm:px-20 bg-white border-b border-gray-200">
			<div class="text-right">
			@if(Auth::user()->hasRole('admin'))
                          <a title="Edit Person" href="/admin/product-form/{{ $product->id }}"><span class="fas fa-pencil-alt m-1 fa-2x"></span></a>
                        @endif
			</div>
    			<div class="mt-6 text-gray-500">
				<form name="saveproduct" action="/admin/saveseller" method="post">
				<input type="hidden" name="product_id" value="{{ $product->id }}" />	
				<input type="hidden" name="referer" value="@php if(!empty($_SERVER['HTTP_REFERER'])){echo $_SERVER['HTTP_REFERER'];} @endphp">
				@csrf	
<div class="overflow-hidden sm:rounded-md">
    <div class="px-4 py-5 bg-white sm:p-6 text-gray-900">
       <div class="grid grid-cols-6 gap-6">
        <div class="col-span-3">
             <label class="block font-medium text-sm" for="sellers">Sellers</label>
                <select class="form-input rounded-md shadow-sm mt-1 block w-full" id="seller_id" name="seller_id" readonly>
                @foreach($sellers as $seller)
                <option value="{{ $seller->id }}" @if($seller->id == $product->seller_id) selected @endif>{{ $seller->business_name }}</option>
                @endforeach
             </select>
        </div>
        <br />

        <div class="col-span-3">
             <label class="block font-medium text-sm" for="product_name">Product Name</label>
             <input class="form-input rounded-md shadow-sm mt-1 block w-full" id="product_name" name="product_name" type="text" value="{{ $product->product_name }}"  readonly>
        </div>
        <br />
        <div class="col-span-3">
             <label class="block font-medium text-sm" for="description">Description</label>
             <textarea class="form-input rounded-md shadow-sm mt-1 block w-full" id="description" rows="5" name="description" readonly>{{ $product->description }}</textarea>
        </div>
        <br />
        <div class="col-span-3">
             <label class="block font-medium text-sm" for="categories">Categories</label>
                <select class="form-input rounded-md shadow-sm mt-1 block w-full" id="taxonomy_id" name="taxonomy_id" readonly>
                @foreach($taxonomies as $taxonomy)
                <option value="{{ $taxonomy->id }}" @if($taxonomy->id == $product->taxonomy_id) selected @endif>{{ $taxonomy->label }}</option>
                @endforeach
             </select>
        </div>
        <br />
       </div>
    </div>

                            </div>
				</form>
                        </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
