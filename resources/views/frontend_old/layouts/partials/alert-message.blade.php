@if(session()->has('status'))
<div class="toast-container">
    <div class="toast align-items-center text-white bg-{{session('status')}} border-0 fade show" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="d-flex">
            <div class="toast-body">
                {!! session('message') !!}
            </div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
    </div>
</div>
@endif