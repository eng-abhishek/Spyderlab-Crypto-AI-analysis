@extends('backend.layouts.app')
@section('content')
<div class="d-flex align-items-center mb-3">
	<div>
		<ul class="breadcrumb">
			<li class="breadcrumb-item"><a href="{{route('backend.dashboard')}}">DASHBOARD</a></li>
			<li class="breadcrumb-item active">{{strtoupper('Comments')}}</li>
		</ul>                    
	</div>
	<div class="ms-auto">
		<a class="btn btn-outline-theme bulk_delete"><i class="fa-light fa-plus-circle fa-fw me-1"></i>Delete All Selected</a>
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
						<th width="50px"><div class="form-check"><input type="checkbox" id="master" class="form-check-input"></div></th>
						<th>Name</th>
						<th>Email</th>
						<th>Description</th>
						<th>Status</th>
						<th>View Post</th>
						<th>Created At</th>
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
			responsive: true,
			ajax:{
				url:"{{ route('backend.posts.comment.index') }}",
				data: function (d) {
					d.status = $('.filter_status').val(),
					d.search = $('input[type="search"]').val()
				}
			},
			columns: [
			{data: 'DT_RowIndex', name:'DT_RowIndex', orderable: false, searchable: false},
			{data:'delCheckbox',name:'delCheckbox',orderable: false, searchable: false},
			{data: 'name', name: 'name'},
			{data: 'email', name: 'email'},
			
			{data: 'description', name: 'description'},
			{data: 'is_active', name: 'is_active'},
			{data: 'post_view', name: 'post_view'},
			{data: 'created_at', name: 'created_at'},
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


		$('#master').on('click', function(e) {
			if($(this).is(':checked',true))  
			{
				$(".order_checkbox").prop('checked', true);

			}else{

				$(".order_checkbox").prop('checked',false);

			}
		});

		$(document).on('click', '.bulk_delete', function(){
			var id = [];

			$('.order_checkbox:checked').each(function(){
				id.push($(this).val());
			});

			if(id.length > 0)
			{

				Swal.fire({
					title: 'Are you sure?',
					text: "Once deleted, you will not be able to recover this Inquries!",
					icon: "warning",
					showCancelButton: true,
					confirmButtonText: 'Yes, deleted it!'

				}).then((result) => {
					if (result.value){
						//$.blockUI();

						$('.order_checkbox:checked').each(function(){
							id.push($(this).val());
						});

						$.ajax({
							url:"{{ route('backend.posts.removeall-comment')}}",
							headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
							method:"post",
							data:{id:id},
							success:function(data)
							{
								if(data.status=='success'){
									table.draw();
									//$.unblockUI();
									Swal.fire({
										html: data.message,
										icon: "success",
										confirmButtonText: 'Close'
									});
									$('#master').prop('checked',false);
								}else{
									//$.unblockUI();
									Swal.fire({
										html: data.message,
										icon: "error",
										confirmButtonText: 'Close'
									});
								} 
							},
							error: function(data) {
								var errors = data.responseJSON;
								console.log(errors);
							}
						});

					}else if (result.dismiss === 'cancel') {

						//$.unblockUI();
						Swal.fire({
							html: "Something went Wrong!",
							icon: "error",
							confirmButtonText: 'Close'
						});
					}
				});
			}else{
				Swal.fire({
					html: "Please select atleast one item Wrong!",
					icon: "error",
					confirmButtonText: 'Close'
				});
			}
		});

$(document).on( 'click', '#customSwitch1', function () {

			var id = $(this).attr("data-id");
			var is_active;  
			if($('.is_active'+id).is(":checked")){
				is_active='Y';
			}else{
				is_active='N';  
			}

			Swal.fire({
				title: "Are you sure?",
				text: "You won't be able to revert this!",
				type: "warning",
				showCancelButton: true,
				confirmButtonText: "Yes, change it!"
			}).then(function (e) {

				if (e.value) {

					$.blockUI({ message: 'Please wait...' });

					$.ajax({
						url:"{{route('backend.posts.change_comment_status')}}",
						method:'post',
						data:{is_active:is_active,id:id,"_token":'{{ csrf_token() }}'},  
						success:function(data){
							if(data.status=='success'){
								toastr.success(data.message);
								table.draw();
								$.unblockUI();
							}else{
								$('.is_active'+id).prop("checked",false);
								toastr.error(data.message);
								$.unblockUI();
							}

						}
					});
				}else{

					if($('.is_active'+id).is(":checked")){

						$('.is_active'+id).prop("checked",false);
					}else{
						$('.is_active'+id).prop("checked",true);
					}
					swal.fire(
						'Cancelled',
						'Your status do not change:)',
						'error'
						)
				}
			})
		});


	});
</script>
@endsection