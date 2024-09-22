@if(session()->has('status'))
<div class="alert alert-{{session('status')}} alert-dismissable fade show p-3">
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    {{session('message')}}
</div>
@endif