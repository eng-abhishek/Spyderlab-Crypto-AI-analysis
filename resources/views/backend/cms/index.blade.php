@extends('backend.layouts.app')

@section('content')
<div class="d-flex align-items-center mb-3">
	<div>
		<ul class="breadcrumb">
			<li class="breadcrumb-item"><a href="{{route('backend.dashboard')}}">DASHBOARD</a></li>
			<li class="breadcrumb-item active">CMS</li>
		</ul>                    
		<h1 class="page-header">CMS</h1>
	</div>
</div>

@include('backend.layouts.partials.alert-messages')

<div class="card">
	<div class="card-body">
		<div class="table-responsive my-3">
			<table class="table" id="tbl_cms_page">
				<thead>
					<tr>
						<th>#</th>
						<th>Slug</th>
						<th>Description</th>
						<th>Updated At</th>
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
		var table = $('#tbl_cms_page').DataTable({
			processing: true,
			serverSide: true,
			ajax: "{{ route('backend.cms.index') }}",
			columns: [

			{data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false},

			{data: 'slug', name: 'slug'},

			{data: 'description', name: 'description'},

			{data: 'updated_at', name: 'updated_at'},

			{data: 'action', name: 'action', orderable: false, searchable: false},

			]
		});
	});
</script>
@endsection