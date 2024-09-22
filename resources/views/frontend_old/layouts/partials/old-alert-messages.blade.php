@if(session()->has('status'))
<div class="alert alert-{{session('status')}} alert-dismissible">
    <a href="{{(isset($redirect_url))?$redirect_url:route('home')}}" class="close" data-dismiss="alert" aria-label="close">&times;</a>
    {{session('message')}}
</div>
@endif