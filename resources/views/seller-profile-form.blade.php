<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
	@if(empty($seller->id))
            {{ __('New Seller Profile') }}
	@else
            {{ __('Edit Seller Profile') }}
	@endif
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
	        <div class="p-6 sm:px-20 bg-white border-b border-gray-200">
    			<div class="mt-6 text-gray-500">
				<form name="save-user" action="/admin/saveseller" method="post">
				<input type="hidden" name="seller_id" value="{{ $seller->id }}" />	
				<input type="hidden" name="referer" value="@php if(!empty($_SERVER['HTTP_REFERER'])){echo $_SERVER['HTTP_REFERER'];} @endphp">
				@csrf	
<h2>Business Details </h2>
<div class="overflow-hidden sm:rounded-md">
    <div class="px-4 py-5 bg-white sm:p-6 text-gray-900">
	<div class="grid grid-cols-6 gap-6">

@if(Auth::user()->hasRole('admin'))
        <div class="col-span-4">
             <label class="block font-medium text-sm" for="user_name">Registered User</label>
		<select class="form-input rounded-md shadow-sm mt-1 block w-full" id="user_id" name="user_id">
		@foreach($users as $user)
                <option value="{{ $user->id }}" @if($user->id == $seller->user_id) selected @endif>{{ $user->name }}</option>
		@endforeach
             </select>
        </div>
	<br />
@endif

        <div class="col-span-4">
             <label class="block font-medium text-sm" for="user_name">Business Name</label>
             <input class="form-input rounded-md shadow-sm mt-1 block w-full" id="name" name="business_name" type="text" value="{{ $seller->business_name }}" >
        </div>
	<br />
        <div class="col-span-4">
             <label class="block font-medium text-sm" for="user_name">Address</label>
             <input class="form-input rounded-md shadow-sm mt-1 block w-full" id="address" name="address" type="text" value="{{ $seller->address }}" >
        </div>
	<br />
        <div class="col-span-4">
             <label class="block font-medium text-sm" for="description">Description</label>
             <textarea class="form-input rounded-md shadow-sm mt-1 block w-full" id="description" rows="5" name="description">{{ $seller->description }}</textarea>
        </div>
	<br />
        <!-- Email -->
        <div class="col-span-8 md:col-span-4">
             <label class="block font-medium text-sm" for="email">Business Email</label> 
             <input class="form-input rounded-md shadow-sm mt-1 block w-full" id="email" name="business_email" type="text" value="{{ $seller->business_email }}" required>
        </div>
	<br />
	<!-- Contact -->
        <div class="col-span-8 md:col-span-4">
             <label class="block font-medium text-sm" for="phone">Business Phone</label> 
             <input class="form-input rounded-md shadow-sm mt-1 block w-full" id="phone" name="business_phone" type="text" value="{{ $seller->business_phone }}" @if(empty($seller->business_phone)) required @endif>
        </div>
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
