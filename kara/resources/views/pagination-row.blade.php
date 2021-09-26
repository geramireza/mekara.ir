@if($posts->lastPage() > 1)
<div class="row px-md-0 ">
    <div class="col d-flex mt-3 justify-content-center align-content-center">
        {{ $posts->appends(Illuminate\Support\Facades\Input::except("_token"))->links() }}
    </div>
</div>
@endif