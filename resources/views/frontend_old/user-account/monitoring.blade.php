@extends('frontend.layouts.account_app')
@section('content')
<div id="content" class="collapsed">
  <div class="main-content">
    <div class="container">
      <div class="monitoring-section">
        <div class="card heading-monitoring">
          <div class="col-md-12">
            <div class="heading5">
              <div class="row">
                <div class="col-md-6">
                  <h3><i class="fa fa-crosshairs fa-1x"></i> Monitoring</h3>
                </div>
                <div class="col-md-6">
                 {{--<button class="btn btn-primary monitoring-btn addModalbtn" data-bs-toggle="modal" data-bs-target="#add-monitoring">Add Monitoring</button>--}}
                 {{--<button class="btn btn-primary monitoring-btn" data-bs-toggle="modal" data-bs-target="#add-monitoring" data-bs-whatever="@getbootstrap">Add Monitoring</button>--}}
                 <button class="btn btn-primary monitoring-btn addModalbtn" data-bs-toggle="modal" data-bs-target="#addMonitoringModal" data-bs-whatever="@getbootstrap">Add Monitoring</button>
               </div>
             </div> 
           </div>
         </div>
       </div>

       <div class="monitoring-search">
        <div class="card">
          <div class="monitoring-information">
            <form action="" id="form_filter">
              <div class="row">
                <div class="col-md-4">
                 <select name="token" id="token" class="form-control form-select">
                  <option value="">Token</option>
                  <option value="BTC">Bitcoin (BTC)</option>
                  <option value="ETH">Ethereum (ETH)</option>
                </select>
              </div>
              <div class="col-md-4">
                <select name="status" id="status" class="form-control form-select">
                  <option value="">Status</option>
                  <option value="Y">Active</option>
                  <option value="N">Inactive</option>
                </select>
              </div>
              <div class="col-md-4 d-flex">
                <button type="submit" class="search-btn btn btn-main-2">Search</button>
                <button type="reset" class="btn btn-main-2 reset-btn btnReset">reset</button>
              </div>
            </div>
          </form>
        </div>
      </div>  
    </div>
    <div class="monitoring-table">
      <div class="card">
        <div class="col-md-12">
          <div class="table-data table-Data">
            
          </div>
        </div>
      </div>
    </div>
      @include('frontend.layouts.partials.alert-message')
  </div>
</div>
</div>
</div>

<!-- Add Monitoring Modal -->
<div class="modal fade" id="addMonitoringModal" tabindex="-1" aria-labelledby="addMonitoringModal" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="addMonitoringLabel">Add Monitoring</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="card">
          <!-- Form content -->
          {{ Form::open(array('route' => 'monitoring.store', 'id'=>'add-monitoring-form','files' => true)) }}
          @csrf
          <div class="mb-3">
            <label for="wallet-address" class="col-form-label">Wallet Address:</label>
            <input type="text" class="form-control" name="address" id="wallet-address" placeholder="Wallet Address">
            @error('address')
            <div class="invalid-feedback d-block">{{ $message }}</div>
            @enderror
          </div>

          <div class="mb-3">
            <label for="recipient-name" class="col-form-label">Token:</label>

            <select class="form-select form-control" name="token" aria-label="Default select example">
              <option value="">Select Token</option>
              <option value="BTC">BTC</option>
              <option value="ETH">ETH</option>
            </select>

            @error('token')
            <div class="invalid-feedback d-block">{{ $message }}</div>
            @enderror

          </div>
          <div class="mb-3">
            <label for="file-name" class="col-form-label">Select Logo:</label>

            <input type="file" name="logo" class="form-control" id="inputGroupFile02">
            @error('logo')
            <div class="invalid-feedback d-block">{{ $message }}</div>
            @enderror
          </div>

          {{--<div class="mb-3">
            <label for="recipient-email" class="col-form-label">Recipient Email:</label>
            <button class="btn btn-secondary open-email-from-add" data-bs-toggle="modal" data-bs-target="#recipientEmailModal" data-bs-dismiss="modal"><i class="fa-solid fa-plus fa-1x"></i> Add Email</button>
          </div>--}}

          <div class="mb-3">
            <label for="recipient-email" class="col-form-label">Recipient Email:</label>

            <ul class="email_list list-unstyled mb-0">
            </ul>

            <button type="button" class="btn btn-secondary open-email-from-add" data-bs-toggle="modal" data-bs-target="#recipientEmailModal" data-bs-dismiss="modal" id="add_email"><i class="fa-solid fa-plus fa-1x"></i> Add Email</button>
            @error('email_list')
            <div class="invalid-feedback d-block">{{ $message }}</div>
            @enderror
          </div>

          <div class="mb-3">
            <label for="description" class="col-form-label">Description:</label>

            <textarea name="description" id="description" rows="5" class="form-control" placeholder="Description"></textarea>
          </div>

        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Save</button>
        </div>
        {{ Form::close() }}
      </div>
    </div>
  </div>
</div>

<!-- Edit Monitoring Modal -->
<div class="modal fade" id="editMonitoringModal" tabindex="-1" aria-labelledby="editMonitoringLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="editMonitoringLabel">Edit Monitoring</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="edit-form">
          
        </div>
      </div>
    </div>
  </div>
</div>

<!-- add Email -->
<div class="modal fade" id="recipientEmailModal" tabindex="-1" aria-labelledby="addEmailLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="addEmailLabel">Recipient Email:</h5>
        <button type="button" class="btn-close addMonitoringDynamicModalTop" data-bs-target="#addMonitoringModal" data-bs-toggle="modal"></button>
      </div>
      <form action="">
        <div class="modal-body">
          <div class="card">
            
            <div class="email-recipient">
              <div class="row">  
                <div class="col-md-3">
                  <label for="recipient-name" class="col-form-label">Recipient Email:</label>
                </div>
                <div class="col-md-9 d-flex">
                  <input type="email" class="form-control recipent_email" id="email" placeholder="Recipient Email:" name="recipent_email"><button type="button" class="btn btn-success" id="verify_email">Send Code</button>
                </div>
              </div>
              <div class="row user_veridication_code d-none">  
                <div class="col-md-3">
                  <label for="code" class="col-form-label">Code:</label>
                </div>
                <div class="col-md-9">
                  <input type="text" name="user_verification_code" class="form-control user_verification_code" placeholder="Code:" >
                </div>
              </div>
              <div class="row">  
                <div class="col-md-3">
                  <label for="code" class="col-form-label"></label>
                </div>
                <div class="col-md-7">
                  <div class="count">
                    <p class="timerStart"></p>
                  </div>
                </div>
                <div class="col-md-2">
                  <div class="re-send-btn">
                    <button type="button" class="btn resend_btn d-none">Resend</button>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary addMonitoringDynamicModalBottom" data-bs-toggle="modal" data-bs-target="#addMonitoringModal">Close</button>
          <button type="button" class="btn btn-primary verifiy_btn" id="liveToastBtn">Add</button>
        </div>
      </form>
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

{{--<div class="toast-container position-fixed bottom-0 end-0 p-3 ajax-alert-box d-none">
  <div class="toast align-items-center toster-bg border-0 fade show" role="alert" aria-live="assertive" aria-atomic="true">
    <div class="d-flex">
      <div class="toast-body toster-ajax-message">

      </div>
      <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
    </div>
  </div>
</div>--}}

@endsection
@section('scripts')
{!! JsValidator::formRequest('App\Http\Requests\MonitoringRequest', '#add-monitoring-form'); !!}
{!! JsValidator::formRequest('App\Http\Requests\MonitoringRequest', '#edit-monitoring-form'); !!}
<script type="text/javascript">
  var get_table_data = @json(route('get-monitoring-table-data'));

  $(document).on('click', '.table-Data .pagination a', function(event){
    event.preventDefault(); 
    var page = $(this).attr('href').split('page=')[1];
    getData(page,'');
  });

  $(function(){
    getData();        
  })

  $('.addMonitoringDynamicModalTop').on('click',function(){
  $('#recipientEmailModal').modal('hide');
  });

  $('.addMonitoringDynamicModalBottom').on('click',function(){
      $('#recipientEmailModal').modal('hide');
  })

  function getData(page='',search=''){
     $.blockUI({ message: 'Please wait...' });
     if(search == ''){
      url = get_table_data+'?page=' + page;
    }else{
      url = get_table_data+'?' + search;
    }

    $.ajax({
      headers: {
        'X-CSRF-Token': $('meta[name=csrf-token]').attr('content')
      },
      type: "get",
      url: url,
      success: function (result) {
        $('.table-Data').html(result);
        $('[data-bs-toggle="tooltip"]').tooltip();
        $.unblockUI();
    }
  });
  }

  var myTimer = null;
  var verified_email =0;
  var data_edit = 0;

  $('#verify_email').on('click',function(){
    var input_email = $('.recipent_email').val();

    if(input_email == ''){
      $('.recipent_email').addClass('is-invalid');
      return false;
    }

    var EmailRegex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
    if(EmailRegex.test(input_email) == false){
      $('.recipent_email').addClass('is-invalid');
            //alert('false');
            return false;
          }
          $('.recipent_email').removeClass('is-invalid');
          $.blockUI({ message: 'Please wait...' });
        $('.timerStart').html('');
        $.ajax({
          headers: {
            'X-CSRF-Token': $('meta[name=csrf-token]').attr('content')
          },
          type: "post",
          url: "{{route('backend.send-verification-email')}}",
          data:{sender_email:input_email},
          success: function (result) {

                $.unblockUI();
                if (result.status == 'success') {

                  $('#verify_email').attr('disabled','disabled');   
                  $('.recipent_email').attr('readonly','readonly');
                  $('.user_veridication_code').removeClass('d-none');
                  $('.timer_start').removeClass('d-none');
                  verified_email = 0;
                  /* timer */
                  begin();
                  
                  $('.toster-bg').removeClass('text-bg-danger');
                  $('.ajax-alert-box').removeClass('d-none');

                  $('.toster-bg').addClass('show');      
                  $('.toster-bg').addClass('bg-success');
                  $('.toster-ajax-message').html(result.message);

                }else{
                  $('.resend_btn').addClass('d-none');
                  $('.user_veridication_code').addClass('d-none');
                  $('.ajax-alert-box').removeClass('d-none');
                  $('.toster-bg').addClass('show');      
                  $('.toster-bg').addClass('bg-danger');
                  $('.toster-ajax-message').html(result.message);
                }
              },
              error: function (jqXHR, textStatus, errorThrown) {
              $.unblockUI();
              }
            });
      })

  $('.verifiy_btn').on('click',function(){
    var user_code = $('.user_verification_code').val();

        $.blockUI({ message: 'Please wait...' });

        $.ajax({
          headers: {
            'X-CSRF-Token': $('meta[name=csrf-token]').attr('content')
          },
          type: "post",
          url: "{{route('backend.match-verification-code')}}",
          data:{user_code:user_code},
          success: function (result) {

               $.unblockUI();
               if (result.status == 'success') {
                $('#recipientEmailModal').modal('hide');
                $('.recipent_email').val('');
                $('.user_verification_code').val('');
                $('.user_veridication_code').addClass('d-none');
                $('.timer_start').addClass('d-none');
                $('.resend_btn').addClass('d-none');

                
                if(data_edit > 0){

                  $('#editMonitoringModal .email_list').append('<li><div class="form-check"><input class="form-check-input"  type="checkbox" name="email_list[]" value="'+result.email+'" id="'+result.email+'"><label class="form-check-label" for="'+result.email+'">'+result.email+'</label></div></li>');

                  $('#editMonitoringModal').modal('show');
                }else{

                  $('#addMonitoringModal .email_list').append('<li><div class="form-check"><input class="form-check-input"  type="checkbox" name="email_list[]" value="'+result.email+'" id="'+result.email+'"><label class="form-check-label" for="'+result.email+'">'+result.email+'</label></div></li>');

                  $('#addMonitoringModal').modal('show');
                }

                window.clearInterval(myTimer);
                verified_email = 1;

                $('.toster-bg').removeClass('bg-danger');

                $('.ajax-alert-box').removeClass('d-none');
                $('.toster-bg').addClass('show');      
                $('.toster-bg').addClass('text-bg-success');
                $('.toster-ajax-message').html(result.message);

              }else{
                
                $('.ajax-alert-box').removeClass('d-none');
                $('.toster-bg').addClass('show');      
                $('.toster-bg').addClass('bg-danger');
                $('.toster-ajax-message').html(result.message);
              }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                $.unblockUI();
             }
           });
      })

  $('.resend_btn').on('click',function(){

        $.blockUI({ message: 'Please wait...' });
        $('.timerStart').html('');
        $.ajax({
          headers: {
            'X-CSRF-Token': $('meta[name=csrf-token]').attr('content')
          },
          type: "get",
          url: "{{route('backend.resend-email')}}",
          success: function (result) {
                $.unblockUI();
                if (result.status == 'success') {
                  $('.user_verification_code').val('');
                  $('.timerStart').removeClass('d-none');
                  $('.resend_btn').addClass('d-none');
                  begin();

                  $('.toster-bg').removeClass('bg-danger');
                  $('.ajax-alert-box').removeClass('d-none');
                  $('.toster-bg').addClass('show');      
                  $('.toster-bg').addClass('bg-success');
                  $('.toster-ajax-message').html(result.message);

                }else{

                  if(result.status == 'error'){
                    result.status = 'danger';
                  }else{
                    result.status = 'success';
                  }

                  $('.ajax-alert-box').removeClass('d-none');
                  $('.toster-bg').addClass('show');      
                  $('.toster-bg').addClass('bg-danger');
                  $('.toster-ajax-message').html(result.message);

                }
              },
              error: function (jqXHR, textStatus, errorThrown) {
                $.unblockUI();
             }
           });
      })

  $('.addModalbtn').on('click',function(){
    data_edit = 0;
  });

  $('#add_email').on('click',function(){
    
    $('.addMonitoringDynamicModalTop').attr('data-bs-target','#addMonitoringModal');
    $('.addMonitoringDynamicModalBottom').attr('data-bs-target','#addMonitoringModal');
      

      $('#addMonitoringModal').modal('hide');
      if(verified_email>0){
        $('#verify_email').removeAttr('disabled');   
        $('.recipent_email').removeAttr('readonly');
      }
      $('.timerStart').html('');
      $('#recipientEmailModal').modal('show');
    });

  $(document).on("click",".editAddEmail",function() {
    $('.addMonitoringDynamicModalTop').attr('data-bs-target','#editMonitoringModal');
    $('.addMonitoringDynamicModalBottom').attr('data-bs-target','#editMonitoringModal');

      $('#editMonitoringModal').modal('hide');

      if(verified_email>0){
        $('#verify_email').removeAttr('disabled');   
        $('.recipent_email').removeAttr('readonly');
      }

      $('.timerStart').html('');
      $('#recipientEmailModal').modal('show');

    });

  function begin() {
    timing = 60;
    $('.timerStart').html('You have left: '+timing);
    myTimer = setInterval(function() {
      --timing;
      $('.timerStart').html('You have left: '+timing);
      if (timing === 0) {
        $('.resend_btn').removeClass('d-none');
        clearInterval(myTimer);
      }
    }, 1000);
  }

  /*--------- Edit Form -------*/
  function getEditData(id){
    var url = $('.editItem'+id).data('url');

    $.ajax({
      headers: {
        'X-CSRF-Token': $('meta[name=csrf-token]').attr('content')
      },
      type: "get",
      url: url,
      success: function (result) {
        data_edit = 1;
        $('#editMonitoringModal').modal('show');
        $('.edit-form').html(result);
      }
    });
  }

  /*----------- Filter --------*/

  $('#form_filter').on('submit',function(){
    var $form = $('#form_filter');
    var data = $form.serialize();
    getData('',data);
    return false;
  })


  $('.btnReset').on('click',function(){
    $('.search').val('');
    getData();
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
                  url:"{{route('change-monitoring-status')}}",
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