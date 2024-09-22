@extends('backend.layouts.app')

@section('styles')
<style type="text/css">
    .form-switch input{
        cursor: pointer;
    }
</style>
@endsection

@section('content')
<div class="d-flex align-items-center mb-3">
	<div>
		<ul class="breadcrumb">
			<li class="breadcrumb-item"><a href="{{route('backend.dashboard')}}">DASHBOARD</a></li>
			<li class="breadcrumb-item">TELEGRAM</li>
			<li class="breadcrumb-item active">SUBSCRIPTION</li>
		</ul>                    
		<h1 class="page-header">Subscription Management</h1>
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
						<th>User Name</th>
						<th>Package Name</th>
						<th>Subscription Type</th>
						<th>No of Request</th>
			
						<th>Created At</th>
						<th>Action</th>
					</tr>
				</thead>
				<tbody>
				</tbody>
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
			ajax:{
				url:"{{ route('backend.telegram.subscription') }}",
				data: function (d) {
					d.status = $('.filter_status').val(),
					d.search = $('input[type="search"]').val()
				}
			},
			columns: [
				{data: 'DT_RowIndex', name:'DT_RowIndex', orderable: false, searchable: false},
				{data: 'username', name: 'username'},
				{data: 'package_name', name: 'package_name'},
		        {data: 'sub_type', name: 'sub_type'},

				{data: 'no_of_request', name: 'no_of_request'},
			
				{data: 'created_at', name: 'created_at'},
			    {data: 'action', name: 'action', orderable: false, searchable: false},
				]
		});

		/* Filter records */
		$('#submit_filters').click(function(){
			table.draw();
		});

		$('#reset_filters').click(function(){
			$('.filter_status').val('');
			$('input[type="search"]').val('');
			table.draw();
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