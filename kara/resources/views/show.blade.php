@extends("layouts.default")

@section("title")
    {{ $post->title }} |
    @parent
@stop
@section("header_styles")
    <link rel="stylesheet" href="{{ asset("assets/css/select2.min.css") }}">
    <link rel="stylesheet" href="{{ asset("assets/css/alert-form.css") }}">
    <link rel="stylesheet" href="{{ asset("assets/css/login.css") }}">
    <link rel="stylesheet" href="{{ asset("assets/css/show.css") }}">

@stop
@section("content")

    <div class="container">
        @include("layouts.alert-report")
        @include("layouts.alert-bookmark")

        <div class="row">
            <div class="col px-md-0">
                @include("layouts.search-box")
            </div>
        </div>

        @include("layouts.detail-posts")

        @if(count($relatedPosts))
        <div class="row">
            <div class="col-12 px-md-0">
            @include("layouts.related-posts")
            </div>
        </div>
        @endif

    </div>

@endsection


@section("footer")
    @include("layouts.footer")
@stop

@section("footer_scripts")
    <script type="text/javascript" src="{{ asset("assets/js/alert-form.js") }}"></script>
    <script type="text/javascript" src="{{ asset("assets/js/login.js") }}"></script>
    <script type="text/javascript" src="{{ asset("assets/js/select2.full.min.js") }}"></script>
    <script type="text/javascript" src="{{ asset("assets/js/detail-posts.js") }}"></script>
    <script type="text/javascript" src="{{ asset("assets/js/show.js") }}"></script>
@stop