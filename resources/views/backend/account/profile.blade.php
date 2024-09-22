@extends('backend.layouts.app')

@section('content')
<div class="d-flex align-items-center mb-3">
	<div>
		<ul class="breadcrumb">
			<li class="breadcrumb-item"><a href="{{route('backend.dashboard')}}">DASHBOARD</a></li>
			<li class="breadcrumb-item active">PROFILE</li>
		</ul>
		<h1 class="page-header">Profile</h1>
	</div>
</div>

@include('backend.layouts.partials.alert-messages')

<div class="card">
	<div class="card-body">
		{{ Form::model($record, array('route' => 'backend.account.profile.update', 'method' => 'post', 'id'=>'update-profile-form', 'files' => true)) }}
		<div class="row mb-3">
			<div class="col-lg-3 col-md-4">
				<label class="form-label" for="name">Name: <span class="text-danger">*</span></label>
			</div>
			<div class="col-lg-9 col-md-8">
				{{ Form::text('name', null, array('id' => 'name', 'class' => 'form-control', 'placeholder' => 'Name', 'autocomplete' => 'off', 'autofocus')) }}
				@error('name')
				<div class="invalid-feedback d-block">{{ $message }}</div>
				@enderror
			</div>
		</div>
		<div class="row mb-3">
			<div class="col-lg-3 col-md-4">
				<label class="form-label">Email Address: <span class="text-danger">*</span></label>
			</div>
			<div class="col-lg-9 col-md-8">
				<p class="form-control">{{$record->email}}</p>
			</div>
		</div>
		<div class="row">
			<div class="col-lg-12 col-md-12 text-end">
				<button type="submit" class="btn btn-primary">Save</button>
			</div>
		</div>
		{{ Form::close() }}
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
{!! JsValidator::formRequest('App\Http\Requests\Backend\UpdateProfileRequest', '#update-profile-form'); !!}
<script type="text/javascript">
	$(document).ready(function(){

		/* Preview Image */
		// $('input[name="avatar"]').change(function(e) {
		// 	var preview = $(this).data('preview');
		// 	var file = $(this).get(0).files[0];

		// 	if(file){
		// 		var reader = new FileReader();

		// 		reader.onload = function(){
		// 			$(preview).attr("src", reader.result).show();
		// 		}

		// 		reader.readAsDataURL(file);
		// 	}	
		// });

		/* Remove Image */
		// $('.remove-image').click(function(e){
		// 	var this_ele = $(this);
		// 	var url = this_ele.data('url');

		// 	swal({ 
		// 		title: "Are you sure?",
		// 		text: "Are you sure you want to remove this image",
		// 		type: "warning",
		// 		showCancelButton: true,
		// 		confirmButtonText: "Yes, remove it!"
		// 	}).then(function (e) {
		// 		if(e.value){
		// 			mApp.blockPage({
		// 				overlayColor: "#000000",
		// 				type: "loader",
		// 				state: "success",
		// 				message: "Please wait..."
		// 			});

		// 			$.ajax({
		// 				headers: {
		// 					'X-CSRF-Token': $('meta[name=csrf-token]').attr('content')
		// 				},
		// 				type: "post",
		// 				url: url,
		// 				success: function (result) {
		// 					mApp.unblockPage();
		// 					if (result.status == 'success') {
		// 						$('#view-featured-image').attr('src', result.image);
		// 						$('#m_header_topbar').find('.avatar').attr('src', result.image);
		// 						this_ele.remove();
		// 						toastr.success(result.message);
		// 					} else {
		// 						toastr.error(result.message);
		// 					}
		// 				},
		// 				error: function (jqXHR, textStatus, errorThrown) {
		// 					mApp.unblockPage();
		// 				}
		// 			});
		// 		}
		// 	});
		// });

	});

</script>
@endsection