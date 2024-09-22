@extends('backend.layouts.app')

@section('content')
<div class="d-flex align-items-center mb-3">
	<div>
		<ul class="breadcrumb">
			<li class="breadcrumb-item"><a href="{{route('backend.dashboard')}}">DASHBOARD</a></li>
			<li class="breadcrumb-item active">{{strtoupper('Inquiries')}}</li>
			<li class="breadcrumb-item active">DETAILS</li>
		</ul>                    
	</div>
</div>

@include('backend.layouts.partials.alert-messages')

<div class="row justify-content-center align-items-center py-3">
	<div class="col-xxl-12 col-xl-12 col-lg-12 mb-3">

		<div class="card rounded-0 mb-3">
			<div class="card-header rounded-0">
				Inquiries Details 
			</div>
			<div class="card-body">
				<div class="d-flex justify-content-between align-items-start my-3">
					<div>
						<h4>Name</h4>
						{{$record->name}}
					</div>
				</div>
				<hr>
				<div class="my-3">
					<h4>Email</h4>
					{{$record->email}}
				</div>
				<hr>

				<div class="my-3">
					<h4>Query Type</h4>
					
					@if($record->query_type == 'registering_authorising')

					Registering/Authorising

					@elseif ($record->query_type == 'using_application') 

					Using Application

					@elseif ($record->query_type == 'troubleshooting') 

					Troubleshooting

					@elseif ($record->query_type == 'backup_restore') 

					Backup/Restore

					@else

					Other

					@endif
				</div>
				<hr>
				<div class="my-3">
					<h4>Phone No</h4>
					{{$record->phone}}
				</div>
				<hr>
				<div class="my-3">
					<h4>Description</h4>
					{{$record->description}}
				</div>

				<div class="row">
					<div class="col-lg-12 col-md-12 text-end">
						<a href="{{route('backend.contact.index')}}" class="btn btn-secondary">Back</a>
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