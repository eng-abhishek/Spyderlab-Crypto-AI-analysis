{{ Form::model($record,array('route' => ['monitoring.update',$record->id], 'id'=>'edit-monitoring-form','files'=>true)) }}
@method('PUT')
<div class="card">
	<!-- Form content -->
	<div class="mb-3">
		<label for="wallet-address" class="col-form-label">Wallet Address:</label>
		{{ Form::text('address',null,array('class' => 'form-control', 'id'=> 'wallet-address', 'placeholder' => 'Enter address', 'autocomplete' => 'off', 'autofocus')) }}

		@error('address')
		<div class="invalid-feedback d-block">{{ $message }}</div>
		@enderror

	</div>

	<div class="mb-3">
		<label for="recipient-name" class="col-form-label">Token:</label>

		{{ Form::select('token',[''=>'Select Token','BTC'=>'BTC','ETH'=>'ETH'],null,array('class' => 'form-select form-control', 'autocomplete' => 'off', 'autofocus')) }}
		@error('token')
		<div class="invalid-feedback d-block">{{ $message }}</div>
		@enderror
	</div>

	<div class="mb-3">
		<label for="file-name" class="col-form-label">Select Logo:</label>
		{{ Form::file('logo', ['class'=>'form-control m-input', 'data-preview' => '#view-address-image','id'=>'inputGroupFile02']) }}

		@error('logo')
		<div class="invalid-feedback d-block">{{ $message }}</div>
		@enderror
		<div class="image-block">
			<img id="view-address-image" src="{{$record->image_url}}" style="margin-top:10px;max-height: 150px;width: auto;">
		</div>
	</div>

	<div class="mb-3">
		<label for="recipient-email" class="col-form-label">Recipient Email:</label>
		
		<ul class="email_list list-unstyled mb-0">
			@if(count($email) > 0)
			@foreach($email as $key => $emailData)
			<li>
				<div class="form-check">
					<input class="form-check-input"  type="checkbox" checked name="email_list[]" value="{{$emailData}}" id="{{$key}}">
					<label class="form-check-label" for="{{$key}}">{{$emailData}}</label>
				</div>
			</li>
			@endforeach
			@endif
		</ul>

		{{--<button type="button" class="btn btn-secondary open-email-from-edit editAddEmail" data-bs-toggle="modal" data-bs-target="#recipientEmailModal" data-bs-dismiss="modal"><i class="fa-solid fa-plus fa-1x"></i> Add Email</button>--}}

		<button type="button" class="btn btn-secondary open-email-from-edit editAddEmail" data-bs-toggle="modal" data-bs-target="#recipientEmailModal" data-bs-dismiss="modal"><i class="fa-solid fa-plus fa-1x"></i> Add Email</button>

		@error('email_list')
		<div class="invalid-feedback d-block">{{ $message }}</div>
		@enderror

	</div>

	<div class="mb-3">
		<label for="description" class="col-form-label">Description:</label>
		<textarea name="description" id="description" rows="5" class="form-control" placeholder="Description">{!! $record->description !!}</textarea>

	</div>
</div>
<div class="modal-footer">
	<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
	<button type="submit" class="btn btn-primary">Save</button>
</div>

{{ Form::close() }}