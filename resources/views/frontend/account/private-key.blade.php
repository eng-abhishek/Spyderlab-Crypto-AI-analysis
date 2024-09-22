@extends('frontend.layouts.account_app')

@section('title')  
<title>{{config('app.name')}} - Private Key</title>
@endsection

@section('content')
<!-- main content -->
<div id="content" class="collapsed">
  <div class="main-content">
    <div class="container">
      <div class="private-key py-4">
        <!-- private key heading -->
        <div class="col-md-12">
          <div class="card private-key-heading">
            <div class="heading py-3 px-3">
              <div class="row">
                <div class="col-md-6">
                  <h3><img src="{{asset('assets/account/images/icons/key.svg')}}" height="50" class="px-2">Private Key</h3>
                </div>
                <div class="col-md-6 text-end">
                <a href="{{route('account.create-user-key')}}" class="btn btn-primary monitoring-btn">Generate Key</a>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="private-key-table">
          <div class="card">
            <div class="col-md-12">
              <div class="table-data">
                <table class="table">
                  <thead>
                    <tr>
                      <th scope="col">S.No</th>
                      <th scope="col">Key</th>
                      <th scope="col">Status</th>
                      <th scope="col">Created at</th>
                      <th scope="col">Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    @forelse($records as $key => $value)
                    <tr>
                     <td scope="row">{{$key+1}}</td>

                     <td data-bs-toggle="tooltip" data-bs-placement="top" title="{{$value->key}}" class="col-2 text-truncate"><text style="max-width:50px;" class="txn-address userKey{{$value->id}}">{{$value->key}}</text><span><i onclick="copyToClipboard('.userKey','{{$value->id}}')" class="fa-solid fa-copy"></i></span></td>
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

                <td>
                  <div class="dropdown">
                    <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton2" data-bs-toggle="dropdown" aria-expanded="false">
                      <i class="fa-solid fa-ellipsis"></i>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-dark" aria-labelledby="dropdownMenuButton2">
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
</div>

<!-- Toast Container -->
<div class="toast-container ajax-alert-box">
  <div class="toast align-items-center text-white toster-bg border-0" role="alert" aria-live="assertive" aria-atomic="true">
    <div class="d-flex">
      <div class="toast-body toster-ajax-message">

      </div>
      <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
    </div>
  </div>
</div>
@endsection

@section('scripts')
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

              $('.toster-bg').removeClass('bg-danger');
              $('.ajax-alert-box').removeClass('d-none');
              $('.toster-bg').addClass('show');      
              $('.toster-bg').addClass('bg-'+data.status);
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