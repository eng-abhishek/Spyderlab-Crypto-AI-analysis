@extends('backend.layouts.app')

@section('content')
<div class="d-flex align-items-center mb-3">
	<div>
		<ul class="breadcrumb">
			<li class="breadcrumb-item"><a href="{{route('backend.dashboard')}}">DASHBOARD</a></li>
			<li class="breadcrumb-item active">SEO</li>
		</ul>                    
		<h1 class="page-header">SEO</h1>
	</div>
	<div class="ms-auto">
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
					<th>Slug</th>
					<th>Title</th>
					<th>Meta Title</th>
					<th>Meta Description</th>
					<th>Meta Keyword</th>
					<th>Featured Image</th>
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

		var table = $('#m_table_1').DataTable({
			processing: true,
			serverSide: true,
			ajax:{
				url:"{{ route('backend.seo.index') }}",
				data: function (d) {
					d.search = $('input[type="search"]').val()
				}
			},
			columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false},
            {data: 'slug', name: 'slug'},
            {data: 'title', name: 'title'},
            {data: 'meta_title', name: 'meta_title'},
            {data: 'meta_des', name: 'meta_des'},
            {data: 'meta_keyword', name: 'meta_keyword'},
            {data: 'image', name: 'image'},
            {data: 'updated_at', name: 'updated_at'},
            {data: 'action', name: 'action'},
            
			]
		});

	});
</script>
@endsection