@extends('backend.layouts.app')

@section('content')
<div class="d-flex align-items-center mb-3">
	<div>
		<ul class="breadcrumb">
			<li class="breadcrumb-item"><a href="{{route('backend.dashboard')}}">DASHBOARD</a></li>
			<li class="breadcrumb-item active">SEARCH HISTORIES</li>
		</ul>                    
		<h1 class="page-header">Search Histories</h1>
	</div>
</div>

@include('backend.layouts.partials.alert-messages')

<div class="card">
	<div class="card-body">
		<div class="table-responsive my-3">
			<table class="table" id="m_table_1">
				<thead>
					<tr>
						<th>#</th>
						<th>User</th>
						<th>IP Address</th>
						<th>Search By</th>
						<th>Search Value</th>
						<th>Status</th>                                    
						<th>Location</th>
						<th>User Agent</th>
						<th>Time</th>
						<th>Action</th>
					</tr>
				</thead>
				<tbody></tbody>
			</table>
		</div>
	</div>
	<div class="card-arrow">
		<div class="card-arrow-top-left"></div>
		<div class="card-arrow-top-right"></div>
		<div class="card-arrow-bottom-left"></div>
		<div class="card-arrow-bottom-right"></div>
	</div>
</div>
@endsection

@section('scripts')
<script type="text/javascript">
	$(document).ready(function(){

		var table = $('#m_table_1').DataTable({
			processing: true,
			serverSide: true,
			scrollX: true,
			ajax:{
				url:"{{ route('backend.search-histories.index') }}",
				data: function (d) {
					d.search = $('input[type="search"]').val()
				}
			},
			columns: [
				{data: 'DT_RowIndex', name:'DT_RowIndex', orderable: false, searchable: false},
				{data: 'user', name: 'user'},
				{data: 'ip_address', name: 'ip_address'},
				{data: 'search_key', name: 'search_key'},
				{data: 'search_value', name: 'search_value'},
				{data: 'status_code', name: 'status_code'},
				{data: 'location', name: 'location'},
				{data: 'user_agent', name: 'user_agent'},
				{data: 'search_at', name: 'search_at'},
				{data: 'action', name: 'action', orderable: false, searchable: false},
				]
		});

		/* Delete record */
		$(document).on('click', '.delete-record', function (e) {
			var url = $(this).data('url');

			Swal.fire({ 
				title: "Are you sure?",
				text: "You won't be able to revert this!",
				type: "warning",
				showCancelButton: true,
				confirmButtonText: "Yes, delete it!"
			}).then(function (e) {
				if(e.value){
					$.blockUI({ message: 'Please wait...' });

					$.ajax({
						headers: {
							'X-CSRF-Token': $('meta[name=csrf-token]').attr('content')
						},
						type: "delete",
						url: url,
						success: function (result) {
							$.unblockUI();
							if (result.status == 'success') {
								table.draw();
								toastr.success(result.message);
							} else {
								toastr.error(result.message);
							}
						},
						error: function (jqXHR, textStatus, errorThrown) {
							$.unblockUI();
						}
					});
				}
			});
		});

	});
</script>
@endsection