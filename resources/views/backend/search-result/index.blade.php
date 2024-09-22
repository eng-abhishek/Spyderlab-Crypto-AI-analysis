@extends('backend.layouts.app')

@section('content')
<div class="d-flex align-items-center mb-3">
	<div>
		<ul class="breadcrumb">
			<li class="breadcrumb-item"><a href="{{route('backend.dashboard')}}">DASHBOARD</a></li>
			<li class="breadcrumb-item active">SEARCH RESULTS</li>
		</ul>                    
		<h1 class="page-header">Search Results</h1>
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
						<th>Search By</th>
						<th>Search Value</th>
						<th>Status</th>
						<th>Created At</th>
						<th>Updated At</th>
						<th>Updated By</th>
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
			responsive: true,
			ajax:{
				url:"{{ route('backend.search-results.index') }}",
				data: function (d) {
					d.search = $('input[type="search"]').val()
				}
			},
			columns: [
				{data: 'DT_RowIndex', name:'DT_RowIndex', orderable: false, searchable: false},
				{data: 'search_key', name: 'search_key'},
				{data: 'search_value', name: 'search_value'},
				{data: 'status_code', name: 'status_code'},
				{data: 'created_at', name: 'created_at'},
				{data: 'updated_at', name: 'updated_at'},
				{data: 'updated_by', name: 'updated_by'},
				{data: 'action', name: 'action', orderable: false, searchable: false},
				]
		});

	});
</script>
@endsection