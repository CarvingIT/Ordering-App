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
            {{ __('Seller Details') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
	        <div class="p-6 sm:px-20 bg-white border-b border-gray-200">
			<div class="text-right">
			@if(Auth::user()->hasRole('admin'))
                          <a title="Edit Person" href="/admin/seller-profile-form/{{ $seller->id }}"><span class="fas fa-pencil-alt m-1 fa-2x"></span></a>
                        @endif
			</div>
    			<div class="mt-6 text-gray-500">
				<form name="save-user" action="/admin/saveseller" method="post">
				<input type="hidden" name="user_id" value="{{ $seller->id }}" />	
				<input type="hidden" name="referer" value="@php if(!empty($_SERVER['HTTP_REFERER'])){echo $_SERVER['HTTP_REFERER'];} @endphp">
				@csrf	
<div class="overflow-hidden sm:rounded-md">
    <div class="px-4 py-5 bg-white sm:p-6 text-gray-900">
       <div class="grid grid-cols-6 gap-6">
	@if(Auth::user()->hasRole('admin'))
        <div class="col-span-3">
             <label class="block font-medium text-sm" for="user_name">Registered User</label>
                <select class="form-input rounded-md shadow-sm mt-1 block w-full" id="user_id" name="user_id" readonly>
                @foreach($users as $user)
                <option value="{{ $user->id }}" @if($user->id == $seller->user_id) selected @endif>{{ $user->name }}</option>
                @endforeach
             </select>
        </div>
        <br />
@endif

        <div class="col-span-3">
             <label class="block font-medium text-sm" for="user_name">Business Name</label>
             <input class="form-input rounded-md shadow-sm mt-1 block w-full" id="name" name="business_name" type="text" value="{{ $seller->business_name }}"  readonly>
        </div>
        <br />
        <div class="col-span-3">
             <label class="block font-medium text-sm" for="user_name">Address</label>
             <input class="form-input rounded-md shadow-sm mt-1 block w-full" id="address" name="address" type="text" value="{{ $seller->address }}"  readonly>
        </div>
        <br />
        <div class="col-span-3">
             <label class="block font-medium text-sm" for="description">Description</label>
             <textarea class="form-input rounded-md shadow-sm mt-1 block w-full" id="description" rows="5" name="description" readonly>{{ $seller->description }}</textarea>
        </div>
        <br />
	<!-- Email -->
        <div class="col-span-8 md:col-span-4">
             <label class="block font-medium text-sm" for="email">Business Email</label>
             <input class="form-input rounded-md shadow-sm mt-1 block w-full" id="email" name="business_email" type="text" value="{{ $seller->business_email }}" readonly>
        </div>
        <br />
        <!-- Contact -->
        <div class="col-span-8 md:col-span-4">
             <label class="block font-medium text-sm" for="phone">Business Phone</label>
             <input class="form-input rounded-md shadow-sm mt-1 block w-full" id="phone" name="business_phone" type="text" value="{{ $seller->business_phone }}" @if(empty($seller->business_phone)) required @endif readonly>
	</div>
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
