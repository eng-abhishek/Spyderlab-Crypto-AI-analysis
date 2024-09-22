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
			<li class="breadcrumb-item active">USER MANAGEMENT</li>
		</ul>                    
		<h1 class="page-header">User Management</h1>
	</div>
</div>

@include('backend.layouts.partials.alert-messages')

<div class="card mb-3">
	<div class="card-body">
		<form>
			<div class="row justify-content-between">
				<div class="col-lg-3">
					{{ Form::select('status', ['' => 'Select Status', 'Y' => 'Active', 'N' => 'In-Active'], null, array('class' => 'form-select my-3 filter_status')) }}
				</div>
				<div class="col-lg-3 text-end">
					<button type="button" class="btn btn-light my-3" id="submit_filters">
						<span>
							<i class="fa-thin fa-magnifying-glass"></i>
							<span>Search</span>
						</span>
					</button>
					<button type="button" class="btn btn-secondary my-3" id="reset_filters">
						<span>
							<i class="fa-thin fa-xmark"></i>
							<span>Reset</span>
						</span>
					</button>
				</div>
			</div>
		</form>
	</div>

	<div class="card-arrow">
		<div class="card-arrow-top-left"></div>
		<div class="card-arrow-top-right"></div>
		<div class="card-arrow-bottom-left"></div>
		<div class="card-arrow-bottom-right"></div>
	</div>
</div>

<div class="card">
	<div class="card-body">
		<div class="table-responsive my-3">
			<table class="table" id="m_table_1">
				<thead>
					<tr>
						<th>#</th>
						<th>Name</th>
						<th>Username</th>
						<th>Email</th>
						<th>Phone Number</th>
						<th>Last Login</th>
						<th>Registration Date</th>
						<th>Available Credits</th>
						<th>KYC</th>
						<th>Status</th>
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
				url:"{{ route('backend.users.index') }}",
				data: function (d) {
					d.status = $('.filter_status').val(),
					d.search = $('input[type="search"]').val()
				}
			},
			columns: [
				{data: 'DT_RowIndex', name:'DT_RowIndex', orderable: false, searchable: false},
				{data: 'name', name: 'name'},
				{data: 'username', name: 'username'},
				{data: 'email', name: 'email'},
				{data: 'mobile', name: 'mobile'},
				{data: 'last_login_at', name: 'last_login_at'},
				{data: 'created_at', name: 'created_at'},
				{data: 'credits', name: 'credits'},
				{data: 'kyc', name: 'kyc'},
				{data: 'status', name: 'status'},
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

		/* Change status */
		$(document).on('click', '.change-status', function (e) {
			e.preventDefault();

			var url = $(this).data('url');
			var value = $(this).data('value');

			if(value == 'Y'){
				var text = 'Are you sure you want to in-active this user?';
			}else{
				var text = 'Are you sure you want to activate this user?';
			}

			Swal.fire({ 
				title: "Are you sure?",
				text: text,
				type: "warning",
				showCancelButton: true,
				confirmButtonText: "Yes!"
			}).then(function (e) {
				if(e.value){
					$.blockUI({ message: 'Please wait...' });

					$.ajax({
						headers: {
							'X-CSRF-Token': $('meta[name=csrf-token]').attr('content')
						},
						type: "post",
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

		/* Verify KYC */
		$(document).on('click', '.verify-kyc', function (e) {
			e.preventDefault();

			var url = $(this).data('url');

			Swal.fire({ 
				title: "Are you sure?",
				text: 'Are you sure you want to verify KYC for this user?',
				type: "warning",
				showCancelButton: true,
				confirmButtonText: "Yes!"
			}).then(function (e) {
				if(e.value){
					$.blockUI({ message: 'Please wait...' });

					$.ajax({
						headers: {
							'X-CSRF-Token': $('meta[name=csrf-token]').attr('content')
						},
						type: "post",
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