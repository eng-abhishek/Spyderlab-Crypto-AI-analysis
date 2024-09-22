@extends('errors.layout')

@section('title')
<title>Service Unavailable - {{config('app.name')}}</title>
@endsection

@section('content')
<div class="container">
	<div class="row">
		<div class="col-sm-12">
			<div class="not-found">
				<div class="four_zero_four_bg">
					<h1 class="text-center">503</h1>  
				</div>
				<div class="contant_box_404 text-center">
					<h3 class="heading-404">
						Service Unavailable
					</h3>
					<p>The server cannot handle your request right now.<br>
						Click "Go Back" to access the Home page.
					</p>
					<a href="{{route('home')}}"><button class="btn btn-404">Back to Home</button></a>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection