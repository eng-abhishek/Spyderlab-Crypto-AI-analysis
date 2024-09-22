         {{ Form::model($record,array('route' => ['monitoring.update',$record->id], 'id'=>'edit-monitoring-form','files'=>true)) }}
         @method('PUT')
         <div class="row mb-3">
            <div class="col-lg-3">
                <label for="" class="form-label">Wallet Address: </label>
            </div>
            <div class="col-lg-9">
                {{ Form::text('address',null,array('class' => 'form-control', 'placeholder' => 'Enter address', 'autocomplete' => 'off', 'autofocus')) }}
            </div>
            @error('address')
            <div class="invalid-feedback d-block">{{ $message }}</div>
            @enderror
        </div>
        <div class="row mb-3">
            <div class="col-lg-3">
                <label for="" class="form-label">Token: </label>
            </div>
            <div class="col-lg-9">
                {{ Form::select('token',[''=>'Select Token','BTC'=>'BTC','ETH'=>'ETH'],null,array('class' => 'form-select form-control', 'autocomplete' => 'off', 'autofocus')) }}
                @error('token')
                <div class="invalid-feedback d-block">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-lg-3">
                <label for="" class="form-label">Select Logo: </label>
            </div>
            <div class="col-lg-9">
                {{ Form::file('logo', ['class'=>'form-control m-input', 'data-preview' => '#view-address-image']) }}
                @error('logo')
                <div class="invalid-feedback d-block">{{ $message }}</div>
                @enderror
                <div class="image-block">
                    <img id="view-address-image" src="{{$record->image_url}}" style="margin-top:10px;max-height: 150px;width: auto;">
                </div>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-lg-3">
                <label for="" class="form-label">Recipient Email: </label>
            </div>
            <div class="col-lg-9">
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
                    <li>
                        <a href="#" class="custom-link editAddEmail"><i class="fa-light fa-plus"></i> Add Email</a>
                    </li>
                </ul>
            </div>
            @error('email_list')
            <div class="invalid-feedback d-block">{{ $message }}</div>
            @enderror
        </div>
        <div class="row mb-3">
            <div class="col-lg-3">
                <label for="description" class="form-label">Description: </label>
            </div>
            <div class="col-lg-9">
                <textarea name="description" id="description" rows="5" class="form-control" placeholder="Description">{!! $record->description !!}</textarea>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12 text-end">
                <button type="button" class="btn btn-secondary rounded-0" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-main-2">Add</button>
            </div>
        </div>
        {{ Form::close() }}