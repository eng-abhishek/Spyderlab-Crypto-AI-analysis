@extends('backend.layouts.app')

@section('content')
<div class="d-flex align-items-center mb-3">
	<div>
		<ul class="breadcrumb">
			<li class="breadcrumb-item"><a href="{{route('backend.dashboard')}}">DASHBOARD</a></li>
			<li class="breadcrumb-item active">View</li>
		</ul>                    
		<h1 class="page-header">Views</h1>
	</div>
</div>

@include('backend.layouts.partials.alert-messages')

<div class="card">
	<div class="card-body">
		<div class="table-responsive my-3">
			<table class="table" id="tbl_view_page">
				<thead>
					<tr>
				        <th>#</th>
						<th>Title</th>
						<th>Slug</th>
						<th>Views</th>
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
        var table = $('#tbl_view_page').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('backend.posts.view.index') }}",
		    
		    columns: [
			
			{data: 'DT_RowIndex', name:'DT_RowIndex', orderable: false, searchable: false},
			{data: 'title', name: 'title'},
			{data: 'slug', name: 'slug'},
			{data: 'post_view', name: 'post_view'},
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