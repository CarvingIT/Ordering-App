@push('js')
<link rel="stylesheet" href="/css/all.min.css" />
<link rel="stylesheet" href="/css/jquery.dataTables.min.css" />
<link rel="stylesheet" href="/css/jquery-ui.css" />
<script src="/js/jquery-3.5.1.js"></script>
<script src="/js/jquery.dataTables.min.js"></script>
<script src="/js/jquery-ui.js"></script>

<script type="text/javascript">
$( function() {
    $( "#datepickerstart" ).datepicker();
  } );
$( function() {
    $( "#datepickerend" ).datepicker();
  } );
</script>

<!--link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous"-->
<!--script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js" integrity="sha384-b5kHyXgcpbZJO/tY9Ul7kGkf1S0CWuKcCD38l8YkeH8z8QjE0GmW1gYU5S9FOnJ0" crossorigin="anonymous"></script-->
<!--script src="https://cdn.tiny.cloud/1/57yud8hji4ltgdkaea05vb4gx1yvvbqdmzx605fgpsauwm10/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script-->

<link href="/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">
<script src="/js/bootstrap.bundle.min.js" integrity="sha384-b5kHyXgcpbZJO/tY9Ul7kGkf1S0CWuKcCD38l8YkeH8z8QjE0GmW1gYU5S9FOnJ0" crossorigin="anonymous"></script>
<script src="/js/tinymce/tinymce.min.js" referrerpolicy="origin"></script>

<script>
                            tinymce.init({
                                selector: '#event_notes',
                                plugins: [
                                    "advlist autolink lists link image charmap print preview hr anchor pagebreak",
                                    "searchreplace wordcount visualblocks visualchars code fullscreen",
                                    "insertdatetime media table nonbreaking save contextmenu directionality paste"
                                ],
                                toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image",
                                relative_urls: false,
                                remove_script_host: false,
                                convert_urls: true,
                                force_br_newlines: true,
                                force_p_newlines: false,
                                forced_root_block: '', // Needed for 3.x
                              file_picker_callback (callback, value, meta) {
        let x = window.innerWidth || document.documentElement.clientWidth || document.getElementsByTagName('body')[0].clientWidth
        let y = window.innerHeight|| document.documentElement.clientHeight|| document.getElementsByTagName('body')[0].clientHeight

        tinymce.activeEditor.windowManager.openUrl({
          url : '/file-manager/tinymce5',
          title : 'Laravel File manager',
          width : x * 0.8,
          height : y * 0.8,
          onMessage: (api, message) => {
            callback(message.content, { text: message.text })
          }
        })
      },
                            });
</script>


@endpush

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
	@if(empty($event->id))
            {{ __('New Event') }}
	@else
            {{ __('Edit Event') }}
	@endif
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
	        <div class="p-6 sm:px-20 bg-white border-b border-gray-200">
    			<div class="mt-6 text-gray-500">
				<form name="save-event" action="/admin/saveevent" method="post" enctype="multipart/form-data">
				<input type="hidden" name="event_id" value="{{ $event->id }}" />	
				<input type="hidden" name="referer" value="@php if(!empty($_SERVER['HTTP_REFERER'])){ echo $_SERVER['HTTP_REFERER'];} @endphp">
				@csrf	
<div class="overflow-hidden sm:rounded-md">
    <div class="px-4 py-5 bg-white sm:p-6 text-gray-900">
       <div class="grid grid-cols-6 gap-6">
	<!-- Event Title -->
	<div class="col-span-8">
             <label class="block font-medium text-sm" for="event_title">Title</label>
             <input class="form-input rounded-md shadow-sm mt-1 block w-full" id="event_title" name="title" type="text" value="{{ $event->title }}" required>
        </div>

	<!-- Event Date -->
        <div class="col-span-1">
             <label class="block font-medium text-sm" for="event_date">Event Date</label>
             <input class="form-input rounded-md shadow-sm mt-1 block w-full" id="datepickerstart" name="show_till" type="text" value="{{ $event->show_till }}" placeholder="YYYY-MM-DD" >
        </div>
	<!-- Event End Date -->
	<!--
        <div class="col-span-1">
             <label class="block font-medium text-sm" for="event_end_date">Event End Date</label>
             <input class="form-input rounded-md shadow-sm mt-1 block w-full" id="datepickerend" name="event_end_date" type="text" value="{{ $event->event_end_date }}" placeholder="YYYY-MM-DD" >
        </div>
	-->

	<!-- Event Announcement -->
	<div class="col-span-8">
             <label class="block font-medium text-sm" for="event_name">Announcement</label>
             <textarea class="form-input rounded-md shadow-sm mt-1 block w-full" id="announcement" name="announcement" cols="8" rows="10">{{ $event->announcement }}</textarea>
        </div>

	<!-- Event Venue -->
	<!--
	<div class="col-span-2">
             <label class="block font-medium text-sm" for="event_venue">Event Venue</label>
             <input class="form-input rounded-md shadow-sm mt-1 block w-full" id="event_venue" name="event_venue" type="text" value="{{ $event->event_venue }}" >
        </div>
	-->

	<!-- Key Sub Event -->
	<!--
	<div class="col-span-4">
             <label class="block font-medium text-sm" for="key_sub_event">Key Sub Event</label>
             <input class="form-input rounded-md shadow-sm mt-1 block w-full" id="key_sub_event" name="key_sub_event" type="text" value="{{ $event->key_sub_event }}" >
        </div>
	-->

	<!-- Event URL -->
	<!--
	<div class="col-span-8">
             <label class="block font-medium text-sm" for="event_url">Event URL</label>
             <input class="form-input rounded-md shadow-sm mt-1 block w-full" id="event_url" name="event_url" type="text" value="{{ $event->event_url }}" >
        </div>
	-->

	<!-- Event Image Upload -->
	<!--
        <div class="col-span-8 md:col-span-4">
             <label class="block font-medium text-sm" for="event_image_upload">Event Image Upload @if(!empty($event->event_image_upload)) <a href="/admin/event/{{ $event->id }}/eventIMG" target="_blank" style="color:#F1541E;">{{ $event->event_image_upload_file }}</a> @endif</label>
             <input class="form-input rounded-md shadow-sm mt-1 block w-full" id="event_image_upload" type="file" name="event_image_upload" @if(empty($event->id)) @endif>
        </div>
	-->

	<!--
        <div class="col-span-8 md:col-span-6">
             <label class="block font-medium text-sm" for="event_notes">Description</label> 
             <textarea class="form-input rounded-md shadow-sm mt-1 block w-full" id="event_notes" name="event_notes" type="text">{{ $event->event_notes }}</textarea>
        </div>
	-->

       </div>
    </div>

    <div class="flex items-center justify-end px-4 py-3 text-right sm:px-6">
     <button type="submit" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:shadow-outline-gray disabled:opacity-25 transition ease-in-out duration-150 m-1" wire:loading.attr="disabled">
    Save
     </button>
     <button type="button" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:shadow-outline-gray disabled:opacity-25 transition ease-in-out duration-150 m-1" wire:loading.attr="disabled" onclick="window.history.back();">
    Cancel
     </button>

   </div>
                            </div>
				</form>
                        </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
