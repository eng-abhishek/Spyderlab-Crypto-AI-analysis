@extends('frontend.layouts.account_app')
@section('content')
<div id="content" class="collapsed">
    <div class="main-content">
        <div class="container">
            <div class="investigation-section">
                <div class="card heading-investigation">
                    <div class="col-md-12">
                      <div class="heading4">
                        <div class="row">
                          <div class="col-md-6">
                            <h3><i class="fa-solid fa-bullseye"></i>Investigation</h3>
                        </div>
                        <div class="col-md-6">
                            @if($chk_user_sub > 0)
                            <a class="btn btn-primary investigation-btn addModalbtn" data-bs-toggle="modal" data-bs-target="#add-investigation" data-bs-whatever="@getbootstrap">Add Investigation <span class="badge badge-pill badge-light" style="background-color: rgb(7, 12, 35);">PRO</span></a>
                            @else
                            <a href="{{route('pricing')}}" class="btn btn-primary investigation-btn addModalbtn" data-bs-toggle="modal" data-bs-target="#add-investigation" data-bs-whatever="@getbootstrap">Continues with <span class="badge badge-pill badge-light" style="background-color: rgb(7, 12, 35);">PRO</span></a>
                            @endif
                        </div>
                    </div>  
                </div>
            </div>
        </div>
        @if($chk_user_sub > 0)
        <div class="investigation-search">
            <div class="card">
                <div class="investigation-information">
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
                                <button type="reset" class="btn btn-main reset-btn btnReset">reset</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>  
        </div>
        <div class="investigation-table">
            <div class="card">
                <div class="col-md-12">
                    <div class="table-data table-Data">

                    </div>
                </div>
            </div>
        </div>
        @else
        <div class="card">
            <div class="row">
                <div class="col-lg-12">
                    <div class="coin-item my-3">
                        <div class="text-center">
                            <h3 class="mt-5">This features only avaliable for paid user</h3>
                            <p> for more click on below button</p>
                            <a href="{{route('pricing')}}" class="btn btn-primary"><i class="fa-regular fa-share-from-square"></i>Click Here</a>           
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endif
    </div>
     @include('frontend.layouts.partials.alert-message')
</div>
</div>
</div>
<!---  Add Modal --->
<!-- add investigation -->

<div class="modal fade" id="add-investigation" tabindex="-1" aria-labelledby="addModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        {{ Form::open(array('route' => 'investigation.store', 'id'=>'add-investigation-form','files' => true)) }}
        @csrf
        <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="addModalLabel">New Investigation</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
              <div class="card">
                <div class="mb-3">
                  <label for="recipient-name" class="col-form-label">Wallet Address:</label>
                  <input type="text" name="address" class="form-control" id="wallet-address" placeholder="Wallet Address" >
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
              <label for="description-text" class="col-form-label">Description:</label>
              <textarea name="description" id="description-text" rows="5" class="form-control" placeholder="Description"></textarea>
          </div>
      </div>
  </div>
  <div class="modal-footer">
      <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
      <button type="submit" class="btn btn-primary">Add</button>
  </div>
</div>
{{ Form::close() }}
</div>
</div>

<!-- Edit investigation -->
<div class="modal fade" id="edit-investigation" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="editModalLabel">Edit Investigation</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="edit-form">

      </div>
  </div>
</div>
</div>

@endsection
@section('scripts')
{!! JsValidator::formRequest('App\Http\Requests\InvestigationRequest', '#add-investigation-form'); !!}
{!! JsValidator::formRequest('App\Http\Requests\InvestigationRequest', '#edit-investigation-form'); !!}

<script type="text/javascript">
    var get_table_data = @json(route('get-investigation-table-data'));

    $(document).on('click', '.table-Data .pagination a', function(event){
        event.preventDefault(); 
        var page = $(this).attr('href').split('page=')[1];
        getData(page,'');
    });

    $(function(){
        getData();        
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

    $('.addModalbtn').on('click',function(){
        data_edit = 0;
    });


    $(document).on("click",".editAddEmail",function() {
        $('.addMonitoringDynamicModalTop').attr('data-bs-target','#editMonitoringModal');
        $('.addMonitoringDynamicModalBottom').attr('data-bs-target','#editMonitoringModal');
        $('#editMonitoringModal').modal('hide');

    });

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
                $('#edit-investigation').modal('show');
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
                url:"{{route('change-investigation-status')}}",
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