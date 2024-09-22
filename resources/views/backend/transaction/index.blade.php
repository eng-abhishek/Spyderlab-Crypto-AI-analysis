@extends('backend.layouts.app')

@section('content')
<div class="d-flex align-items-center mb-3">
	<div>
		<ul class="breadcrumb">
			<li class="breadcrumb-item"><a href="{{route('backend.dashboard')}}">DASHBOARD</a></li>
			<li class="breadcrumb-item active">TRANSACTION</li>
		</ul>                    
		<h1 class="page-header">Transaction</h1>
	</div>
	<!--<div class="ms-auto">
		<a href="{{route('backend.crypto-plans.create')}}" class="btn btn-outline-theme"><i class="fa-light fa-plus-circle fa-fw me-1"></i> Add Crypto Plan</a>
	</div>-->
</div>

@include('backend.layouts.partials.alert-messages')

<div class="card mb-3">
	<div class="card-body">
		<form>
			<div class="row justify-content-between">
				<div class="col-lg-3">
					{{ Form::select('status', ['' => 'Select Status', 'Pending' => 'Pending', 'Paid' => 'Paid','Cancelled'=>'Cancelled'], null, array('class' => 'form-select my-3 filter_status')) }}
				</div>
				<div class="col-lg-3 text-end">
					<button type="button" class="btn btn-light my-3" id="submit_filters">
						<span>
							<i class="fa-thin fa-magnifying-glass"></i>
							<span>Search</span>
						</span>
					</button>
					<button type="button" class="btn btn-secondary my-3" id="reset_filters">
						<span>
							<i class="fa-thin fa-xmark"></i>
							<span>Reset</span>
						</span>
					</button>
				</div>
			</div>
		</form>
	</div>

	<div class="card-arrow">
		<div class="card-arrow-top-left"></div>
		<div class="card-arrow-top-right"></div>
		<div class="card-arrow-bottom-left"></div>
		<div class="card-arrow-bottom-right"></div>
	</div>
</div>


<div class="card">
	<div class="card-body">
		<div class="table-responsive my-3">
			<table class="table" id="m_table_1">
				<thead>
					<tr>
						<th>#</th>
						<th>Tran id</th>
						<th>Tran Date</th>
						<th>Tran Amount</th>
						<th>Payment Status</th>
						<th>Plan Name</th>
						<th>User Name</th>
						<th>Exchange Type</th>
						<th>Action</th>
					</tr>
				</thead>
				<tbody>
				</tbody>
			</table>
		</div>
	</div>
	<div class="card-arrow">
		<div class="card-arrow-top-left"></div>
		<div class="card-arrow-top-right"></div>
		<div class="card-arrow-bottom-left"></div>
		<div class="card-arrow-bottom-right"></div>
	</div>
</div>
@endsection

@section('scripts')
<script type="text/javascript">
	$(document).ready(function(){

		var table = $('#m_table_1').DataTable({
			processing: true,
			serverSide: true,
			ajax:{
				url:"{{ route('backend.transaction.index') }}",
				data: function (d) {
					d.status = $('.filter_status').val(),
					d.search = $('input[type="search"]').val()
				}
			},
			columns: [
			{data: 'DT_RowIndex', name:'DT_RowIndex', orderable: false, searchable: false},
			{data: 'tran_id', name: 'tran_id'},
			{data: 'tran_date', name: 'tran_date'},
			{data: 'tran_amount', name: 'tran_amount'},
			{data: 'status', name: 'status'},
			{data:'plan', name:'plan'},
			{data: 'user', name: 'user'},
			{data:'exchange_type', name:'exchange_type'},
			{data: 'action', name: 'action', orderable: false, searchable: false},
			]
		});

/* Filter records */
		$('#submit_filters').click(function(){
			table.draw();
		});

		$('#reset_filters').click(function(){
			$('.filter_status').val('');
			$('input[type="search"]').val('');
			table.draw();
		});


	});
</script>
@endsection