{{ Form::model($record,array('route' => ['investigation.update',$record->id], 'id'=>'edit-investigation-form','files'=>true)) }}
@method('PUT')
<div class="modal-body">
	<div class="card">
		<div class="mb-3">
			<label for="recipient-name" class="col-form-label">Wallet Address:</label>
			{{ Form::text('address',null,array('class' => 'form-control', 'id'=>'wallet-address', 'placeholder' => 'Enter address', 'autocomplete' => 'off', 'autofocus')) }}
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
			<label for="description-text" class="col-form-label">Description:</label>
			<textarea name="description" id="description" rows="5" class="form-control" placeholder="Description">{!! $record->description !!}</textarea>
		</div>
		
	</div>
</div>
<div class="modal-footer">
	<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
	<button type="submit" class="btn btn-primary">Add</button>
</div>
{{ Form::close() }}