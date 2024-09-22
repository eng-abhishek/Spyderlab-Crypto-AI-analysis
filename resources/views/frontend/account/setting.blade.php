@extends('frontend.layouts.account_app')
@section('title')  
<title>{{config('app.name')}} - Setting</title>
@endsection
@section('content')
<div id="content" class="collapsed">
  <div class="main-content">
    <div class="container">
      <div class="settings-section">
        <div class="col-md-12">
          <div class="card heading-settings">
            <div class="heading d-flex">
              <h3><i class="fa fa-gear fa-1x fa-spin"></i> Settings</h3>
            </div>
          </div>
        </div>
        <div class="global-settings">
          <div class="col-md-12">

            <h2>Global Settings</h2>
            <!--my account  -->
            <div class="my-account">
              <div class="card">
                <h4><i class="fa fa-user"></i> My Account</h4>
                <div class="col-md-12">
                 <div class="user-table">
                  <table class="table">
                    <thead>
                      <tr>
                        <th scope="col">Username</th>
                        <th scope="col">Mobile</th>
                        <th scope="col">Current Plan</th>
                        <th scope="col">Status</th>
                        <th scope="col">Total Credit(s)</th>
                        <th scope="col">Expire DateD</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <td scope="row">{{$record->username}}</td>
                        <td>{{$record->mobile}}</td>

                        <td>
                          @if($record->plan_name)
                          <p class="mb-0">{{$record->plan_name}}</p>
                          <a href="{{route('pricing')}}" class="mx-lg-3 mx-0 my-lg-0 my-3 custom-link">
                           @if($record->plan_slug == $top_plan->slug)
                           <button class="btn btn-primary btn-sm"><i class="fa fa-right-long"></i>Change</button>
                           @else
                           <button class="btn btn-primary btn-sm"><i class="fa fa-right-long"></i>Upgrade</button>
                           @endif
                         </a>
                         @else
                         <p class="mb-0">You do`t have any plan</p>
                         <a href="{{route('pricing')}}">
                          <button class="btn btn-primary btn-sm"><i class="fa fa-right-long"></i>Buy Now</button></a>
                          @endif
                        </td>

                        <td>
                          @if($record->is_active == 'Y')
                          <p class="mb-0 text-break">Enabled</p>
                          @else
                          <p class="mb-0 text-break">Disabled</p>
                          @endif
                        </td>


                        <td>{{available_credits()}} <a href="{{route('pricing')}}" class="btn btn-success btn-sm"><i class="fa fa-cart-shopping"></i> Buy Credits</a></td>
                        <td>{{$record->sub_exp_date}}</td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>

          <!-- edit profile -->
          <div class="edit-account">
            <div class="card">
              <h4><i class="fa-solid fa-user-pen"></i> Edit Profile</h4>
              <div class="col-md-12">
                <div class="edit-form">
                  {{ Form::model($record, array('route' => 'account.profile.update', 'method' => 'post', 'class'=>'mt-3', 'id'=>'update-profile-form', 'files' => true)) }}
                  <div class="form-group">
                    <label>Name</label>

                    {{ Form::text('name', null, array('class' => 'form-control', 'id' => 'name', 'placeholder' => 'Enter name', 'autocomplete' => 'off', 'autofocus')) }}
                    @error('name')
                    <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                  </div>
                  <div class="form-group">
                    <label>Username</label>

                    {{ Form::text('username', null, array('class' => 'form-control', 'id' => 'username', 'placeholder' => 'Enter username')) }}
                    @error('username')
                    <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                  </div>
                  <div class="form-group">
                    <label>Email address</label>

                    {{ Form::text('email', null, array('class' => 'form-control', 'id' => 'email', 'placeholder' => 'Enter email', 'autocomplete' => 'off','readonly'=>'readonly')) }}
                    @error('email')
                    <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                  </div>

                  @if(empty(auth()->user()->password))

                  <div class="form-group">
                    <label>Password</label>
                    {{ Form::password('password', array('id' => 'password', 'class'=>'form-control', 'placeholder' => 'Enter Password' , 'autocomplete'=>'off') ) }}
                    @error('password')
                    <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                  </div>
                  <div class="form-group">
                    <label>Confirm Password</label>
                    {{ Form::password('password_confirmation', array('id' => 'password_confirmation', 'class'=>'form-control', 'placeholder' => 'Re-enter password' , 'autocomplete'=>'off') ) }}
                    @error('password_confirmation')
                    <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                  </div>
                  @else

                  @endif
                  <button type="submit" class="btn btn-primary">Save</button>
                  {!! Form::close() !!}
                </div>
              </div>
            </div>
          </div>

          @if(empty(auth()->user()->password))

          @else
          <!-- change password -->
          <div class="change-password">
            <div class="card">
              <h4><i class="fa-solid fa-key"></i> Change Password</h4>
              <div class="col-md-12">
                <div class="password-form">
                  {{ Form::open(array('route' => 'account.change-password.update', 'method' => 'post', 'id'=>'change-password-form','class'=>'mt-3')) }}
                  <div class="form-group">
                    <label>Old Password</label>
                    {{ Form::password('current_password', array('class'=>'form-control', 'id' => 'current_password', 'placeholder' => 'Current Password' , 'autocomplete'=>'off', 'autofocus') ) }}
                    @error('current_password')
                    <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                  </div>
                  <div class="form-group">
                    <label>New Password</label>
                    {{ Form::password('password', array('class'=>'form-control', 'id' => 'new_password', 'placeholder' => 'New Password' , 'autocomplete'=>'off') ) }}
                    @error('password')
                    <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                  </div>
                  <div class="form-group">
                    <label>Confirm Password</label>
                    {{ Form::password('password_confirmation', array('class'=>'form-control', 'id' => 'confirm_password', 'placeholder' => 'Confirm Password' , 'autocomplete'=>'off') ) }}
                    @error('password_confirmation')
                    <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                  </div>
                  <button type="submit" class="btn btn-success">Change Password</button>
                  {!! Form::close() !!}
                </div>
              </div>
            </div>
          </div>
          @endif

        </div>
      </div>
    </div>
  </div>
</div>
</div>

@endsection

@section('scripts')
{!! JsValidator::formRequest('App\Http\Requests\UpdateProfileRequest', '#update-profile-form'); !!}
{!! JsValidator::formRequest('App\Http\Requests\ChangePasswordRequest', '#change-password-form'); !!}
@endsection