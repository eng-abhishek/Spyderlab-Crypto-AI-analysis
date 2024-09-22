@extends('backend.layouts.app')
@section('styles')
<style>.dropdown-toggle.no-caret::before{content: none;}
.select2-container--default .select2-results>.select2-results__options {
  background-color: #fff; 
  color: #000;
  font-size: .875rem;
  font-weight:400;
}

.select2-container--default .select2-selection--single{
background-color: #e9e9e900; 
padding:1px;
height:36px;
margin-top: 15px;
border: 1px solid rgba(255, 255, 255, .3);
}

.select2-container--default .select2-selection--single .select2-selection__rendered {
/* Change this to your desired text color */
color: rgba(255, 255, 255, .75);

}

@media only screen and (max-width:991px){
.select2-container--default .select2-selection--single{
	width: 100%!important;
}
}
</style>
@endsection

@section('content')
<div class="d-flex align-items-center mb-3">
	<div>
		<ul class="breadcrumb">
			<li class="breadcrumb-item"><a href="{{route('backend.dashboard')}}">DASHBOARD</a></li>
			<li class="breadcrumb-item active">SUBSCRIPTION</li>
		</ul>                    
		<h1 class="page-header">Subscription</h1>
	</div>
	<div class="ms-auto">
		<a href="{{route('backend.subscription.create')}}" class="btn btn-outline-theme"><i class="fa-light fa-plus-circle fa-fw me-1"></i> Add Subscription</a>
	</div>
</div>

<div class="card mb-3">
	<div class="card-body">
		<form>
			<div class="row justify-content-between">
				<div class="col-lg-3">
					{{ Form::select('status', ['' => 'Select Status', 'Y' => 'Active', 'N' => 'In-Active'], null, array('class' => 'form-select my-3 filter_status')) }}
				</div>
	             <div class="col-lg-3">
					<select name="plan" class="form-select my-3 filter_plan">
					<option value="">Select Plan</option>
					@foreach($plan_list as $planData)
				    <option value="{{$planData->name}}">{{$planData->name}}</option>
					@endforeach
					</select>
				</div>
                <div class="col-lg-3">
					<select name="user" class="form-select mt-3 filter_user">
					<option value="">Select User</option>
					@foreach($user_list as $userData)
				    <option value="{{$userData->username}}">{{$userData->username}}</option>
					@endforeach
					</select>
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


@include('backend.layouts.partials.alert-messages')

<div class="card">
	<div class="card-body">
		<div class="table-responsive my-3">
			<table class="table" id="m_table_1">
				<thead>
					<tr>
						<th>#</th>
						<th>User Name</th>
						<th>Plan</th>
						<th>Plan Price</th>
						<th>Status</th>
						<th>Plan Status</th>
						<th>Started At</th>
						<th>Expired At</th>
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

<!-- Button trigger modal -->

<!-- Modal -->
{{--<div class="modal fade" id="renewModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">Renew - Subscription</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<form method="post" action="" id="renewForm">
				@csrf
				<div class="modal-body">

					<div class="form-check">
						<input class="plan_type form-check-input" type="radio" name="plan_type" id="flexRadioDefault1" value="Y" checked>
						<label class="form-check-label" for="flexRadioDefault1">
							Yearly
						</label>
					</div>
					<div class="form-check">
						<input class="plan_type form-check-input" type="radio" name="plan_type" id="flexRadioDefault2" value="M">
						<label class="form-check-label" for="flexRadioDefault2">
							Monthly
						</label>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
					<button type="submit" id="renewBtn" class="btn btn-primary">Save changes</button>
				</div>
			</form>
		</div>
	</div>
</div>--}}

@endsection
@section('scripts')
<script type="text/javascript">
	$(document).ready(function(){

	$('.filter_user').select2();

		var table = $('#m_table_1').DataTable({
			processing: true,
			serverSide: true,
			ajax:{
				url:"{{ route('backend.subscription.index') }}",
				data: function (d) {
					d.search = $('input[type="search"]').val(),
					d.status = $('.filter_status').val(),
					d.plan = $('.filter_plan').val(),
					d.user = $('.filter_user').val()
				}
			},
			columns: [
			{data: 'DT_RowIndex', name:'DT_RowIndex', orderable: false, searchable: false},
			{data: 'username', name: 'username'},
			{data: 'plan', name: 'plan'},
			{data: 'plan_price', name: 'plan_price'},
			{data: 'is_active', name: 'is_active'},
			{data: 'plan_status', name: 'plan_status'},
			{data: 'started_date', name: 'started_date'},
			{data: 'expired_date', name: 'expired_date'},
			{data: 'action', name: 'action', orderable: false, searchable: false},
			]
		});

		/* Filter records */
		$('#submit_filters').click(function(){
			table.draw();
		});

		$('#reset_filters').click(function(){
			$('.filter_status').val('');
			$('.filter_plan').val('');
			$('.filter_user').val('');
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

		/*-- Renew Record ---*/

		$(document).on('click', '.renew-record', function (e) {
			var url = $(this).data('url');
			$('#renewModal').modal('show');
			$('#renewForm').attr('action',url);
			//alert(url);
		});

		$('#renewForm').on('submit',function(){

			Swal.fire({ 
				title: "Are you sure?",
				text: "You won't be able to revert this!",
				type: "warning",
				showCancelButton: true,
				confirmButtonText: "Yes, renew it!"
			}).then(function (e) {
				if(e.value){
					$.blockUI({ message: 'Please wait...' });

					url = $('#renewForm').attr('action');
					type = $('.plan_type:checked').val();

					$.ajax({
						headers: {
							'X-CSRF-Token': $('meta[name=csrf-token]').attr('content')
						},
						type: "post",
						url: url,
						data: {type:type},
						success: function (result) {
							$.unblockUI();
							$('#renewModal').modal('hide');
							if (result.status == 'success') {
								table.draw();
								toastr.success(result.message);
							} else {
								toastr.error(result.message);
							}
						},
						error: function (jqXHR, textStatus, errorThrown) {
							$.unblockUI();
							$('#renewModal').modal('hide');
						}
					});
				}
			});
			return false;
		})
		
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
						url:"{{route('backend.crypto-subscription-change-status')}}",
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