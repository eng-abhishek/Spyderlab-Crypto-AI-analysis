@extends('frontend.layouts.app')

@section('og')
<title>{{config('app.name').' - '.'Verify'}}</title>
<meta name="title" content="{{config('app.name').' - '.'Verify email'}}">
<meta name="description" content="{{settings('site')->meta_description ?? ''}}">
<meta name="keywords" content="{{settings('site')->meta_keywords ?? ''}}">
<meta property="og:image" content="{{asset('assets/frontend/images/spyderlab_featured_image.png')}}" />
@endsection

@section('content')
<div style="height: 500px"></div>
<!-- verify Email modal -->
<!-- Modal -->
<div class="modal fade" id="verify-email" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Verify Your Email Address</h5>
                {{--<span data-bs-dismiss="modal" aria-label="Close"><i class="fa fa-close fa-2x"></i></span>--}}
            </div>
            <div class="modal-body">

                <p>Before proceeding, please check your email for a verification link.</p>
                <h5>If you did not receive the email,</h5>

            </div>
            <form class="d-inline" method="POST" action="{{ route('verification.resend') }}">
                @csrf
                <div class="modal-footer">
                    <a href="{{route('home')}}" class="btn btn-secondary">Back to Home</a>
                    <button type="submit" class="btn btn-primary">Click here to request Another</button>
                </div>
            </form> 
        </div>
    </div>
</div>

@endsection
@section('scripts')
<script type="text/javascript">
    $(document).ready( function(){
        $('#verify-email').modal('show');
    });
</script>
@endsection