@extends('backend.layouts.app')

@section('content')
<div class="d-flex align-items-center mb-3">
	<div>
		<ul class="breadcrumb">
			<li class="breadcrumb-item"><a href="{{route('backend.dashboard')}}">DASHBOARD</a></li>
			<li class="breadcrumb-item active">API SERVICES</li>
		</ul>                    
		<h1 class="page-header">Api Services</h1>
	</div>
</div>

@include('backend.layouts.partials.alert-messages')

<div class="card">
	<div class="card-body">
		<div class="table-responsive my-3">
			<table class="table" id="m_table_1">
				<thead>
					<tr>
						<th>#</th>
						<th>Name</th>
						<th>Error Code</th>
						<th>Error Message</th>
						<th>Action</th>
					</tr>
				</thead>
				<tbody></tbody>
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
				url:"{{ route('backend.api-services.index') }}",
				data: function (d) {
					d.search = $('input[type="search"]').val()
				}
			},
			columns: [
				{data: 'DT_RowIndex', name:'DT_RowIndex', orderable: false, searchable: false},
				{data: 'name', name: 'name'},
				{data: 'error_code', name: 'error_code'},
				{data: 'error_message', name: 'error_message'},
				{data: 'action', name: 'action', orderable: false, searchable: false},
				]
		});

		/* Filter records */
		$('#submit_filters').click(function(){
			table.draw();
		});

		$('#reset_filters').click(function(){
			$('input[type="search"]').val('');
			table.draw();
		});

	});
</script>
@endsection