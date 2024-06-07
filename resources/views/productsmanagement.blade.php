@push('js')
<link rel="stylesheet" href="/css/all.min.css" />
<link rel="stylesheet" href="/css/jquery.dataTables.min.css" />
<link rel="stylesheet" href="/css/jquery-ui.css" />
<script src="/js/jquery-3.5.1.js"></script>
<script src="/js/jquery.dataTables.min.js"></script>
<script src="/js/jquery-ui.js"></script>

<script type="text/javascript">
$(document).ready(function() {
	$("#products").DataTable(
		{
		stateSave: true,
        	"scrollX": true,
		columnDefs: [
                        { width: '10%', targets: 0 },
			{ "orderable": false, targets: 4 }
                ],
                "lengthMenu": [ 100, 500, 1000 ],
                "pageLength": 100,
                fixedColumns: true
		}
	);
// New code to retain search value
// Restore state
    var state = table.state.loaded();
    if ( state ) {
      table.columns().eq( 0 ).each( function ( colIdx ) {
        var colSearch = state.columns[colIdx].search;

        if ( colSearch.search ) {
          $( 'input', table.column( colIdx ).footer() ).val( colSearch.search );
        }
      } );

      table.draw();
    }

    // Apply the search
    table.columns().eq( 0 ).each( function ( colIdx ) {
        $( 'input', table.column( colIdx ).footer() ).on( 'keyup change', function () {
            table
                .column( colIdx )
                .search( this.value )
                .draw();
        } );
    } );

//
});

function showDeleteDialog(product_id){
$('#delete_product_id').val(product_id);
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
            {{ __('Products') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">

               @foreach (['danger', 'warning', 'success', 'info'] as $msg)
                   @if(Session::has('alert-' . $msg))
		        <div class="p-6 sm:px-20 bg-white border-b border-gray-200">
    				<div class="mt-6 text-gray-900 leading-7 font-semibold ">
                        		<span @if($msg == 'danger') style="color:red" @endif>{{ Session::get('alert-' . $msg) }}</span>
				</div>
                        </div>
                   @endif
               @endforeach

	        <div class="p-6 sm:px-20 bg-white border-b border-gray-200">
		<div class="text-right">
			@if(Auth::user()->hasRole('admin'))
			<a class="m-5" title="New Person" href="/admin/product-form/new"><span class="fas fa-plus"></span></a>
			@endif

			</div>

    			<div class="mt-6 text-gray-900">
			<div class="table-responsive">
                    <table id="products" class="display">
			<thead class="text-primary">
                            <tr>
                            <th>Product Name</th>
                            <th>Description</th>
                            <th>Seller</th>
                            <th>Category</th>
                            <th class="text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach ($products as $p)
                        <tr>
                        <td>{{ $p->product_name }}</td>
                        <td>{{ $p->description }}</td>
                        <td>{{ $p->seller->business_name }}</td>
                        <td>{{ $p->category->label }}</td>
			<td>
				<a href="/admin/product/{{ $p->id }}" title="View Details"><span class="fas fa-eye"></span></a>
				@if(Auth::user()->hasRole('admin'))
				<a href="/admin/product-form/{{ $p->id }}" title="Edit"><span class="fas fa-pencil-alt"></span></a>
				<button id="opener" onClick="showDeleteDialog({{ $p->id }});" title="Delete"><span class="fas fa-trash-alt"></span></button>
				@endif

	    <div id="deletedialog" style="display:none;" class="bg-grey">
                <form name="deleteproduct" method="post" action="/admin/product/delete">
                @csrf
                <input type="hidden" id="delete_product_id" name="product_id" value="{{ $p->id }}" />
			This action can not be undone.
			<div class="flex items-center justify-end px-4 py-3 sm:px-6">
     			<button type="submit" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:shadow-outline-gray disabled:opacity-25 transition ease-in-out duration-150 m-1" wire:loading.attr="disabled">Delete</button>
     			<button type="button" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:shadow-outline-gray disabled:opacity-25 transition ease-in-out duration-150 m-1" wire:loading.attr="disabled" onclick="document.location='/admin/products';">Cancel</button>
   			</div>
		</form>
	   </div>
			</td>
			</tr>
               		@endforeach
			</tbody>
		        </table>
                        </div>
                        </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
