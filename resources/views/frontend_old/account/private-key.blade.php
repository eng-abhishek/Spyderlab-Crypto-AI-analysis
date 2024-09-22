@extends('frontend.layouts.app')

@section('og')
<title>{{config('app.name').' - '.'Private Key'}}</title>
<meta name="title" content="{{config('app.name').' - '.'Private Key'}}">
<meta name="description" content="{{settings('site')->meta_description ?? ''}}">
<meta name="keywords" content="{{settings('site')->meta_keywords ?? ''}}">
<meta property="og:image" content="{{asset('assets/frontend/images/spyderlab_featured_image.png')}}" />
@endsection

@section('content')
<main>
    <section class="section-home py-5">
        <div class="container-xl container-fluid">
            <div class="row justify-content-center text-center">
                <div class="col-lg-12">
                    <nav>
                        <ol class="breadcrumb justify-content-center mb-3 text-light">
                            <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
                            <li class="breadcrumb-item active">Private Key</li>
                        </ol>
                    </nav>
                    <h1 class="fs-2 mb-0">Private Key</h1>
                </div>
            </div>
        </div>
    </section>
    <section class="bg-custom-light py-5">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-2">
                           @include('frontend.layouts.partials.profile-sidebar')
                </div>
                <div class="col-lg-10">
                    <div class="row">
                        <div class="col-lg-12 col-md-12">
                            <div class="coin-item">
                                <div class="row align-items-center">
                                    <div class="col-md-6 text-md-start text-center">
                                        <h2 class="mb-md-0 mb-3"><i class="fa-light fa-user-shield"></i>  Private Key</h2>
                                    </div>
                                    <div class="col-md-6 text-md-end text-center">
                                        <a href="{{route('account.create-user-key')}}" class="btn btn-dark addModalbtn">Generate Key</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="coin-item my-3">
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>S.No</th>
                                                <th>Key</th>
                                                <th>Status</th>
                                                <th>Created at</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                           @forelse($records as $key => $value)
                                           <tr>
                                             <td>{{$key+1}}</td>
                                             <td class="d-flex align-items-center"><span class="mb-0 text-truncate txn-address d-inline-block userKey{{$value->id}}">{{$value->key}}</span><a href="javascript:void(0)"><i class="fa-light fa-copy me-1" onclick="copyToClipboard('.userKey','{{$value->id}}')"></i></a>
                                             </td>

                                             <td>
                                                @php
                                                if($value->is_active == 'Y'){
                                                $checked = 'checked';
                                            }else{
                                            $checked = '';
                                        }
                                        @endphp
                                        <div class="form-check form-switch">
                                            <input type="checkbox" {{$checked}} class="is_active{{$value->id}} form-check-input" id="customSwitch1" data-id="{{$value->id}}">
                                            <label class="form-check-label" for="customSwitch1"></label>
                                        </div>
                                    </td>

                                    <td>{{\Carbon\Carbon::parse($value->created_at)->format('Y-m-d h:i A')}}</td>
                                    <td><div class="dropstart">
                                        <a class="btn btn-main-2 btn-sm dropdown-toggle no-caret" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                            <i class="fa-solid fa-ellipsis"></i>
                                        </a>
                                        <ul class="dropdown-menu">
                                          <li><a href="{{URL('private-key/destroy/'.$value->id)}}" class="dropdown-item">Delete</a></li>
                                      </ul>
                                  </div>
                              </td>
                          </tr>
                          @empty
                          <tr><td colspan="5" class="text-center">no record found</td></tr>
                          @endforelse
                      </tbody>
                  </table>
              </div>
          </div>
      </div>
  </div>
</div>
</div>
</div>

<div class="toast-container position-fixed bottom-0 end-0 p-3 ajax-alert-box d-none">
  <div class="toast align-items-center toster-bg border-0 fade show" role="alert" aria-live="assertive" aria-atomic="true">
    <div class="d-flex">
      <div class="toast-body toster-ajax-message">

      </div>
      <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
  </div>
</div>
</div>

</section>
@if(session()->has('status'))
<div class="toast-container position-fixed bottom-0 end-0 p-3">
    <div class="toast align-items-center text-bg-{{session('status')}} border-0 fade show" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="d-flex">
            <div class="toast-body">
                {{session('message')}}
            </div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
    </div>
</div>
@endif
</main>
@endsection
@section('scripts')
{!! JsValidator::formRequest('App\Http\Requests\ChangePasswordRequest', '#change-password-form'); !!}
<script type="text/javascript">
  
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
            url:"{{route('account.change-private-key-status')}}",
            method:'post',
            data:{is_active:is_active,id:id,"_token":'{{ csrf_token() }}'},  
            success:function(data){
                if(data.status=='success'){

                    $('.toster-bg').removeClass('text-bg-danger');
                    $('.ajax-alert-box').removeClass('d-none');
                    $('.toster-bg').addClass('show');      
                    $('.toster-bg').addClass('text-bg-'+data.status);
                    $('.toster-ajax-message').html(data.message);

                    $.unblockUI();
                }else{
                    $('.is_active'+id).prop("checked",false);
                    
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
</script>
@endsection