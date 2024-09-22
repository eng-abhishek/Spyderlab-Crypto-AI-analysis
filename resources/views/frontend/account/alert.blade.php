@extends('frontend.layouts.account_app')
@section('styles')
<style>
	.coin-icon-h-40{
		height:40px;
	}
</style>
@endsection

@section('title')  
<title>{{config('app.name')}} - Alert</title>
@endsection

@section('content')
<div id="content" class="collapsed">
	<div class="main-content">
		<div class="container">
			<div class="alert-section">
				<div class="card heading-alert">
					<div class="col-md-12">
						<div class="heading5 d-flex">
							<h3><img src="{{asset('assets/account/images/icons/alert-ani.svg')}}" height="50" alt=""> Alert</h3>
						</div>
					</div>
				</div>
				<div class="alert-search">
					<div class="card">
						<div class="alert-information">
						<form action="" id="form_filter">
							<div class="row">
								<div class="col-md-4">
									<select name="token" id="token" class="form-control form-select">
										<option value="">Token</option>
										<option value="BTC">Bitcoin (BTC)</option>
										<option value="ETH">Ethereum (ETH)</option>
									</select>
								</div>
								<div class="col-md-4 d-flex">
									<input type="date" class="form-control" name="date_from" placeholder="Transaction Begin Date" value="{{$start_date}}"><span>To</span>
									<input type="date" class="form-control" name="date_to" placeholder="Transaction End Date" value="{{$end_date}}">
								</div>
								<div class="col-md-4 d-flex">
									<button type="submit" class="search-btn">Search</button>
									<button class="reset-btn btnReset" type="reset">reset</button>
								</div>
							</div>
						</form>
						</div>
					</div>  
				</div>
				<div class="alert-table">
					<div class="card">
						<div class="col-md-12">
							<div class="table-data table-record">

							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection

@section('scripts')
<script type="text/javascript">


	var get_table_data = @json(route('get-alerts-table-data'));

	$(document).on('click', '.table-record .pagination a', function(event){
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
        		console.log(result);
        		$('.table-record').html(result);
        		$('[data-bs-toggle="tooltip"]').tooltip();
                $.unblockUI();
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
    	getData();
    })

</script>
@endsection