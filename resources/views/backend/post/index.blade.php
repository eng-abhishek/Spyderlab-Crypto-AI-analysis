@extends('backend.layouts.app')

@section('content')
<div class="d-flex align-items-center mb-3">
	<div>
		<ul class="breadcrumb">
			<li class="breadcrumb-item"><a href="{{route('backend.dashboard')}}">DASHBOARD</a></li>
			<li class="breadcrumb-item active">Post</li>
		</ul>                    
		<h1 class="page-header">Post</h1>
	</div>
	<div class="ms-auto">
		<a href="{{route('backend.posts.create')}}" class="btn btn-outline-theme"><i class="fa-light fa-plus-circle fa-fw me-1"></i>Add New Post</a>
	</div>
</div>

@include('backend.layouts.partials.alert-messages')

<div class="card">
	<div class="card-body">
		<div class="table-responsive my-3">
			<table class="table" id="tbl_category_page">
				<thead>
					<tr>
				        <th>#</th>
						<th>Title</th>
						<th>Slug</th>
						<!--<th>View</th>-->
						<th>Category</th>
						<th>Status</th>
						<th>Publish At</th>
						<th width="100px">Action</th>
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
        var table = $('#tbl_category_page').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('backend.posts.index') }}",
		    
		    columns: [
			
			{data: 'DT_RowIndex', name:'DT_RowIndex', orderable: false, searchable: false},
			{data: 'title', name: 'title'},
			{data: 'slug', name: 'slug'},
			//{data: 'postviews_count', name: 'postviews_count'},
			{data: 'category', name: 'category'},
			{data: 'status', name: 'status'},
			{data: 'publish_at', name: 'publish_at'},
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

		/* Restore trashed record */
		$(document).on('click', '.restore-record', function (e) {
			var url = $(this).data('url');

			Swal.fire({
				title: "Are you sure?",
				text: "Are you sure you want to restore this post",
				type: "warning",
				showCancelButton: true,
				confirmButtonText: "Yes, restore it!"
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

    });
</script>
@endsection