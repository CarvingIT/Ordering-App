<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
	@if(empty($taxonomy->id))
            {{ __('New Taxonomy') }}
	@else
            {{ __('Edit Taxonomy') }}
	@endif
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
	        <div class="p-6 sm:px-20 bg-white border-b border-gray-200">
    			<div class="mt-6 text-gray-500">
				<form name="save-user" action="/admin/savetaxonomy" method="post">
				<input type="hidden" name="taxonomy_id" value="{{ $taxonomy->id }}" />	
				<input type="hidden" name="referer" value="@php if(!empty($_SERVER['HTTP_REFERER'])){echo $_SERVER['HTTP_REFERER'];} @endphp">
				@csrf	
<div class="overflow-hidden sm:rounded-md">
    <div class="px-4 py-5 bg-white sm:p-6 text-gray-900">
        <div class="col-span-3">
             <label class="block font-medium text-sm" for="user_name">Name</label>
             <input class="form-input rounded-md shadow-sm mt-1 block w-full" id="label" name="label" type="text" value="{{ $taxonomy->label }}" >
        </div>
	<br />
        <!-- Email -->
        <div class="col-span-8 md:col-span-4">
             <label class="block font-medium text-sm" for="email">Parent</label> 
		<select name="parent_id" class="form-input rounded-md shadow-sm mt-1 block w-full" id="subject" required>
                <option value="">---Select Parent---</option>
                <option value="0" @if($taxonomy->parent == 0 && empty($child_of)) selected @endif>Main</option>
                @foreach($parents as $parent)
                <option value="{{ $parent->id }}" @if($taxonomy->parent == $parent->id || $child_of == $parent->id ) selected @endif>{{ $parent->label }}</option>
                @endforeach
                </select>
        </div>
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
