@extends('errors.layout')

@section('title')
<title>Forbidden - {{config('app.name')}}</title>
@endsection

@section('content')
<div class="container">
	<div class="row">
		<div class="col-sm-12">
			<div class="not-found">
				<div class="four_zero_four_bg">
					<h1 class="text-center">403</h1>  
				</div>
				<div class="contant_box_404 text-center">
					<h3 class="heading-404">
						Forbidden
					</h3>
					<p>The page you requested to access is forbidden.<br>
						Click "Go Back" to access the Home page.
					</p>
					<a href="{{route('home')}}"><button class="btn btn-404">Back to Home</button></a>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection