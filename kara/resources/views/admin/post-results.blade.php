@extends("layouts.default")

@section("header_styles")
<link href="{{ asset("assets/css/search-box.css") }}" rel="stylesheet">
<link href="{{ asset("assets/css/select2.min.css") }}" rel="stylesheet">
<link  href="{{ asset("assets/css/search.css") }}" rel="stylesheet" >
@stop


@section("search-results-title")
    @if(url()->current() == route("admin.not-confirmed"))
    {{ convert($posts->total())." آگهی در انتظار تایید یافت شد" }}
    @elseif(url()->current() == route("admin.confirmed"))
        {{ convert($posts->total())." آگهی در حال انتشار یافت شد" }}
    @elseif(url()->current() == route("admin.edited"))
        {{ convert($posts->total())." آگهی ویرایش شده یافت شد" }}
    @endif

@stop

@section("content")
<div class="container">
    <div class="row">
        <div class="col px-md-0">
            @include("layouts.search-box")
        </div>
    </div>
    <div class="row ">

        @include("admin.sidebar")

        <div class="col-lg-9 my-3 px-md-0">
            @include("search-results")
        </div>

    </div>

    @include("pagination-row")

</div>
@stop

@section("footer")
@include("layouts.footer")
@stop
@section("footer_scripts")
<script src="{{ asset("assets/js/select2.full.min.js") }}"></script>
<script src="{{ asset("assets/js/search.js") }}"></script>
@stop