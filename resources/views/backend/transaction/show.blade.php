@extends('backend.layouts.app')

@section('content')
<div class="d-flex align-items-center mb-3">
	<div>
		<ul class="breadcrumb">
			<li class="breadcrumb-item"><a href="{{route('backend.dashboard')}}">DASHBOARD</a></li>
			<li class="breadcrumb-item active"><a href="{{route('backend.transaction.index')}}">Transaction</a></li>
			<li class="breadcrumb-item active">DETAILS</li>
		</ul>                    
	</div>
</div>

@include('backend.layouts.partials.alert-messages')

<div class="row justify-content-center align-items-center py-3">
	<div class="col-xxl-12 col-xl-12 col-lg-12 mb-3">

		<div class="card rounded-0 mb-3">
			<div class="card-header rounded-0">
				Transaction Details 
			</div>
			<div class="card-body">
				<div class="d-flex justify-content-between align-items-start my-3">
					<div>
						<h4>Transaction Id</h4>
						{{$record[0]->transaction_id}}
					</div>
				</div>
				<hr>
				<div class="my-3">
					<h4>Transaction Date</h4>
					{{$record[0]->created_at}}
				</div>

				<hr>
				<div class="my-3">
					<h4>Total Amount</h4>
					$ {{$record[0]->purchese_price}}
				</div>

				@if($record[0]->currency_type == 'crypto')
				
				<hr>
				<div class="my-3">
					<h4>Final Price</h4>
					{{$record[0]->final_price_in_crypto}} BTC
				</div>

				@else

				<hr>
				<div class="my-3">
					<h4>Final Price</h4>
					$ {{$record[0]->final_price}}
				</div>

				@endif

				<hr>
				<div class="my-3">
					<h4>Transaction Status</h4>
					{{$record[0]->status}}
				</div>

				<hr>
				<div class="my-3">
					<h4>User Name</h4>
					{{$record[0]->users->username}}
				</div>
				
				<hr>
				<div class="my-3">
					<h4>Plan Name</h4>
					{{ (!is_null($record[0]->plans) ? $record[0]->plans->name : 'N/A')}}
				</div>
				<hr>

				@if(isset($record[0]->subscription))
				<div class="my-3">
					<h4>Started At</h4>
					{{ isset($record[0]->subscription) ? $record[0]->subscription->started_date : ''}}
				</div>

				<hr>
				<div class="my-3">
					<h4>Expired At</h4>
					{{ isset($record[0]->subscription) ? $record[0]->subscription->expired_date : ''}}
				</div>
				<hr>
				@endif

			{{--<div class="my-3">
					<h4>Plan Type</h4>
					@if($record[0]->plan_type == 'Y')
					Yearly
					@elseif($record[0]->plan_type =="M")
					Monthly
					@else
					N/A
					@endif
				</div>--}}

				<hr>
				<div class="my-3">
					<h4>Exchange Type</h4>
					@if($record[0]->plan_change_type == 'N')
					New
					@elseif($record[0]->plan_change_type == 'U')
					Upgrade
					@elseif($record[0]->plan_change_type == 'D')
					Downgrade
					@elseif($record[0]->plan_change_type == 'R')
					Renew
					@endif
				</div>

				<hr>
				<div class="my-3">
					<h4>Use Payment Gateway</h4>
					{{$record[0]->payment_gateway_id}}
				</div>

				<hr>
				<div class="my-3">
					<h4>Payment Gateway Id</h4>
					{{$record[0]->payment_id}}
				</div>

				<hr>
				<div class="my-3">
					<h4>Payer Id</h4>
					{{$record[0]->payer_id ?? 'NULL'}}
				</div>

				<hr>
				<div class="my-3">
					<h4>Payer Email</h4>
					{{$record[0]->payer_email ?? 'NULL'}}
				</div>

				<hr>
				<div class="my-3">
					<h4>Currency Type</h4>
					{{$record[0]->currency_type}}
				</div>

				@if($record[0]->currency_type == 'crypto')

				<hr>
				<div class="my-3">
					<h4>Coin Payment Address</h4>
					{{$record[0]->coinpayment_address}}
				</div>

				<hr>
				<div class="my-3">
					<h4>Final Price</h4>
					{{$record[0]->final_price_in_crypto}} BTC
				</div>

				@else

				<hr>
				<div class="my-3">
					<h4>Final Price</h4>
					$ {{$record[0]->final_price}}
				</div>

				@endif

			</div>
			<div class="card-arrow">
				<div class="card-arrow-top-left"></div>
				<div class="card-arrow-top-right"></div>
				<div class="card-arrow-bottom-left"></div>
				<div class="card-arrow-bottom-right"></div>
			</div>
		</div>

	</div>
</div>
@endsection