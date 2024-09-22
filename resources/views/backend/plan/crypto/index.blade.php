@extends('backend.layouts.app')

@section('content')
<div class="d-flex align-items-center mb-3">
	<div>
		<ul class="breadcrumb">
			<li class="breadcrumb-item"><a href="{{route('backend.dashboard')}}">DASHBOARD</a></li>
			<li class="breadcrumb-item active">PLANS</li>
		</ul>                    
		<h1 class="page-header">Crypto Plans</h1>
	</div>
	<div class="ms-auto">
		<a href="{{route('backend.crypto-plans.create')}}" class="btn btn-outline-theme"><i class="fa-light fa-plus-circle fa-fw me-1"></i> Add Crypto Plan</a>
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
						<th>Price (monthly)</th>
					{{--<th>Yearly Price</th>--}}
						<th>Is Free</th>
						<th>Status</th>
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
				url:"{{ route('backend.crypto-plans.index') }}",
				data: function (d) {
					d.status = $('.filter_status').val(),
					d.search = $('input[type="search"]').val()
				}
			},
			columns: [
			{data: 'DT_RowIndex', name:'DT_RowIndex', orderable: false, searchable: false},
			{data: 'name', name: 'name'},
			{data: 'monthly_price', name: 'monthly_price'},
			// {data: 'yearly_price', name: 'yearly_price'},
			{data: 'is_free', name: 'is_free'},
			{data:'is_active', name:'is_active'},
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
						url:"{{route('backend.crypto-plans-change-status')}}",
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