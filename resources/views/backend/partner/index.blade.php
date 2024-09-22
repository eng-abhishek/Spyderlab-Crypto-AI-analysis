@extends('backend.layouts.app')

@section('content')
<div class="d-flex align-items-center mb-3">
	<div>
		<ul class="breadcrumb">
			<li class="breadcrumb-item"><a href="{{route('backend.dashboard')}}">DASHBOARD</a></li>
			<li class="breadcrumb-item active">Partner</li>
		</ul>                    
		<h1 class="page-header">Partner</h1>
	</div>
	<div class="ms-auto">
		<a href="{{route('backend.partners.create')}}" class="btn btn-outline-theme"><i class="fa-light fa-plus-circle fa-fw me-1"></i>Add Partner</a>
	</div>
</div>

@include('backend.layouts.partials.alert-messages')

<div class="card">
	<div class="card-body">
		<div class="table-responsive my-3">
			<table class="table" id="tbl_partner_page">
				<thead>
					<tr>
						<th>#</th>
						<th>Image</th>
						<th>Url</th>
						<th>Updated At</th>
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
		var table = $('#tbl_partner_page').DataTable({
			processing: true,
			serverSide: true,
			ajax: "{{ route('backend.partners.index') }}",
			columns: [

			{data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false},

			{data: 'image_url', name: 'image_url'},

			{data: 'url', name: 'url'},

			{data: 'updated_at', name: 'updated_at'},

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