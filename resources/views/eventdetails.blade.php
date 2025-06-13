@push('js')
<link rel="stylesheet" href="/css/all.min.css" />
@endpush
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Event Details') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">

               @foreach (['danger', 'warning', 'success', 'info'] as $msg)
                   @if(Session::has('alert-' . $msg))
		        <div class="p-6 sm:px-20 bg-white border-b border-gray-200">
    				<div class="mt-6 text-gray-900 leading-7 font-semibold ">
                        		<span>{{ Session::get('alert-' . $msg) }}</span>
				</div>
                        </div>
                   @endif
               @endforeach

	        <div class="p-6 sm:px-20 bg-white border-b border-gray-200">
    			<div class="mt-6 text-gray-900">
				<div class="m1">
				<p class="text-2xl"><span class="font-bold">{{ $event->event_name }}</span> 
			        <a title="Edit document" href="/admin/event-form/{{$event->id}}"><span class="fas fa-pencil-alt m-1"></span></a>
				</div>
				<p class="text-xl font-bold">Event Details -</p>
				<div class="m-1">
				<p class="text-xl"><strong>Event Start Date:</strong> 
				@php $date = strtotime($event->event_start_date); echo date('m/d/Y',$date); @endphp
				</p>
				<p class="text-xl"><strong>Event End Date:</strong> 
				@php $date = strtotime($event->event_end_date); echo date('m/d/Y',$date); @endphp
				</p>
				</div>
				<div class="m-1">
				<p class="text-xl"><strong>URL:</strong> {{ $event->event_url }}</p>
				</div>
				<div class="m-1">
				<p class="text-xl"><strong>Venue:</strong> {{ $event->event_venue }}</p>
				</div>
				<div class="m-1">
				<p class="text-xl"><strong>Key Sub Event:</strong> {{ $event->key_sub_event }}</p>
				</div>
				<div class="m-1">
				<p class="text-xl"><strong>Event Image:</strong> 
				@if(!empty($event->event_image_upload))<a href="/admin/event/{{ $event->id }}/eventIMG" target="_blank">{{ $event->event_image_upload_file }}</a><img src="/admin/event/{{ $event->id }}/eventIMG">@else {{ __('Not Uploaded') }} @endif</p>
				</div>
     <button type="button" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:shadow-outline-gray disabled:opacity-25 transition ease-in-out duration-150 m-1" wire:loading.attr="disabled" onclick="window.history.back();">
    &lt; Back to Events
     </button>
                        </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
