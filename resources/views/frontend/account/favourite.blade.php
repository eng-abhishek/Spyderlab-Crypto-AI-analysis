@extends('frontend.layouts.account_app')

@section('title')  
<title>{{config('app.name')}} - Favourite</title>
@endsection

@section('styles')
<style type="text/css">
.btn-eye{
 border-radius: 10vh;
 padding: 10px 13px 10px 13px; 
}
</style>
@endsection
@section('content')
  <div id="content" class="collapsed">
    <div class="main-content">
        <div class="container">
            <div class="favourite-section">
                <div class="col-md-12">
                    <div class="card heading-favourite">
                      <div class="heading3 d-flex">
                        <h3><img src="{{asset('assets/account/images/icons/favourite-anim.svg')}}" height="30"> Favorites</h3>
                      </div>
                    </div>
                </div>
                    <div class="favourite-search">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="search">
                                   <h4>Risk Analysis, Intelligent Tracking</h4>
                                   <div class="search-bar">
                                    <div class="row">
                                      <div class="col-md-6">
                                      <input type="search" class="search_keyword" name="search" placeholder="Search">
                                      </div>
                                      <div class="col-md-6">
                                        <div class="favourite-btn">
                                        <button type="button" class="btn search-btn text btnSearch">Search</button>
                                        <button type="reset" class="btn reset-btn reset btnReset">Reset</button>
                                        </div>
                                      </div>
                                    </div>
                                   </div>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="favourite-table">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="favourite-information">
                                    <div class="row">
                                        <div class="col-md-12 favorites-table">
                                      
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                            @include('frontend.layouts.partials.alert-message')
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
<script type="text/javascript">

  var get_table_data =  @json(route('get-favorite-data'));

  $(function(){
    getData();
  });

  $(document).on('click', '.favorites-table .pagination a', function(event){
    event.preventDefault(); 
    var page = $(this).attr('href').split('page=')[1];
    getData(page,'');
  });


  function getData(page='',search=''){

    if(search == ''){
      url = get_table_data+'?page=' + page;
    }else{
      url = get_table_data+'?search=' + search;
    }
    
    $.ajax({
      headers: {
        'X-CSRF-Token': $('meta[name=csrf-token]').attr('content')
      },
      type: "get",
      url: url,
      success: function (result) {

        $('.favorites-table').html(result);
        $('[data-bs-toggle="tooltip"]').tooltip();
      }
    });
  }

  /*----------- Filter --------*/
  $('.btnSearch').on('click',function(){

    var search = $('.search_keyword').val();
    getData('',search);

  })

  $('.btnReset').on('click',function(){
    $('.search_keyword').val('');
    getData();
  })
</script>
@endsection