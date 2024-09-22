@extends('backend.layouts.app')

@section('content')
<div class="d-flex align-items-center mb-3">
	<div>
		<ul class="breadcrumb">
			<li class="breadcrumb-item"><a href="{{route('backend.dashboard')}}">DASHBOARD</a></li>
			<li class="breadcrumb-item">TELEGRAM</li>
			<li class="breadcrumb-item">TRANSACTION</li>
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
						<h4>Txn Id</h4>
						{{$record->txn_id}}
					</div>
				</div>
				<hr>
				<div class="my-3">
					<h4>User Name</h4>
					{{$record->tg_user->name}}
				</div>

				<hr>
				<div class="my-3">
					<h4>Telegram Username</h4>
					{{$record->tg_user->username}}
				</div>

				<hr>
				<div class="my-3">
					<h4>Package Name</h4>
					{{($record->tg_package) ? $record->tg_package->name : ''}}
				</div>

				Payment Received Address

				<hr>
				<div class="my-3">
					<h4>Subscription Type</h4>
					{{$record->payment_type}}
				</div>

				<hr>
				<div class="my-3">
					<h4>Status</h4>
					{{$record->txn_status}}
				</div>

				<hr>
				<div class="my-3">
					<h4>No of Request</h4>
					{{$record->no_of_request}}
				</div>

				<hr>
				<div class="my-3">
					<h4>Price In USD</h4>
					${{$record->payment_amount_in_usd}}
				</div>

				<hr>
				<div class="my-3">
					<h4>Payment Currency</h4>
					{{$record->coin_type}}
				</div>


				<hr>
				<div class="my-3">
					<h4>Price In Crypto</h4>
					{{$record->payment_amount}} {{$record->coin_type}}
				</div>

				<hr>
				<div class="my-3">
					<h4>Payment Address</h4>
					{{$record->coin_address}}
				</div>
				<hr>
				<div class="my-3">
					<h4>Created At</h4>
					{{$record->created_at}}
				</div>

				<div class="row">
					<div class="col-lg-12 col-md-12 text-end">
						<a href="{{route('backend.telegram.transaction')}}" class="btn btn-secondary">Back</a>
					</div>
				</div>
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