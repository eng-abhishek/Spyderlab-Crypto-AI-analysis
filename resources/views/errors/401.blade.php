@extends('errors.layout')

@section('title')
<title>Unauthorized - {{config('app.name')}}</title>
@endsection

@section('content')
<div class="container">
	<div class="row">
		<div class="col-sm-12">
			<div class="not-found">
				<div class="four_zero_four_bg">
					<h1 class="text-center">401</h1>  
				</div>
				<div class="contant_box_404 text-center">
					<h3 class="heading-404">
						Unauthorized
					</h3>
					<p>The page you requested to access is Unauthorized.<br>
						Click "Go Back" to access the Home page.
					</p>
					<a href="{{route('home')}}"><button class="btn btn-404">Back to Home</button></a>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection