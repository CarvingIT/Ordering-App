<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    You're logged in!<br />
		@foreach (['danger', 'warning', 'success', 'info'] as $msg)
                   @if(Session::has('alert-' . $msg))
                        <div class="p-6 sm:px-20 bg-white border-b border-gray-200">
                                <div class="mt-6 text-gray-900 leading-7 font-semibold ">
                                        <span @if($msg == 'danger') style="color:red" @endif>{{ Session::get('alert-' . $msg) }}</span>
                                </div>
                        </div>
                   @endif
               @endforeach
		@if(auth()->user()->hasRole('admin'))
			<strong>List of Requests for Seller Role</strong><br />
			@php
				$seller_requests = \App\Models\UserSellerRequest::where('status','0')->get();
			@endphp

				@if(!empty($seller_requests))
                			@foreach($seller_requests as $request_details)
					{{ $request_details->user->name }}
					<form name="user_seller_request" method="post" action="/admin/user/assignrole">
						@csrf
						<button type="submit" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:shadow-outline-gray disabled:opacity-25 transition ease-in-out duration-150 m-1" wire:loading.attr="disabled">
   Approve Seller Request 
     </button>
					</form>
					<hr />
					@endforeach
				@endif

		@elseif(!auth()->user()->hasRole('Seller'))
			<form name="user_seller_request" method="post" action="/save_user_seller_request">
				@csrf
				<input type="checkbox" value="1" name="user_seller_request"> I want to become a Seller<br />
				<button type="submit" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:shadow-outline-gray disabled:opacity-25 transition ease-in-out duration-150 m-1" wire:loading.attr="disabled">
    Submit a request
     </button>
			</form>
		@endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
