@extends("/layouts/default")

@section("title")
    جستجوی مشاغل
    @parent
@stop

@section("header_styles")
    <link rel="stylesheet" href="{{ asset("assets/css/style.css") }}">
    <link rel="stylesheet" href="{{ asset("assets/css/search.css") }}">
    <link rel="stylesheet" href="{{ asset("assets/css/select2.min.css") }}">
@stop

@section("search-results-title")
    {{ convert($posts->total())." فرصت شغلی فعال یافت شد" }}
@stop

@section("content")

    <div class="container">

        <div class="row">
            <div class="col px-md-0">
                @include("layouts.search-box")
            </div>
        </div>
            <div class="row">
                <div class="col-12 px-md-0">
                    <div class="card mt-1 bg-white py-2 d-block text-center">
                        <button type="button" class="btn btn-outline-info me-btn-search-just IranBold14 fw-400 ml-sm-2 mb-1">
                            <span class="align-middle float-right mt-2">فقط آگهی های فوری</span>
                            <label class="switch mr-1 m-0">
                                <input id="just-emergency" class="toggle_button" name="is_emergency" type="checkbox" @if(isset($array_data["is_emergency"]) && $array_data["is_emergency"] == 1) checked @endif>
                                <span class="slider round p-2 text-warning"></span>
                            </label>
                        </button>
                        <button type="button" class="btn btn-outline-info me-btn-search-just IranBold14 fw-400 mr-sm-2 mb-1">
                            <span class="align-middle float-right mt-2">فقط آگهی های امروز</span>
                            <label class="switch mr-1 m-0">
                                <meta name="csrf-token" content="{{ csrf_token() }}">
                                <input id="just-today" class="toggle_button" name="is_today" type="checkbox"  @if(isset($array_data["is_today"])) checked @endif>
                                <span class="slider round p-2 text-warning"></span>
                            </label>

                        </button>
                    </div>
                </div>

            </div>
        <div class="row ">

            <div class="d-none d-lg-block col-lg-3 mt-3 order-lg-3 pr-md-0">
                @include("layouts.search-sidebar")
            </div>
            <div class="col-lg-9 order-lg-9 my-3 px-md-0">
            @include("search-results")

            @include("pagination-row")
            </div>
        </div>
    </div>


@endsection

@section("footer")
    @include("layouts.footer")
@stop

@section("footer_scripts")

    <script type="text/javascript" src="{{ asset("assets/js/select2.full.min.js") }}"></script>
    <script type="text/javascript" src="{{ asset("assets/js/script.js") }}"></script>
    <script type="text/javascript" src="{{ asset("assets/js/search.js") }}"></script>
    <script type="text/javascript" src="{{ asset("assets/js/search-results.js") }}"></script>
    <script type="text/javascript" src="{{ asset("assets/js/search-sidebar.js") }}"></script>
    <script type="text/javascript" src="{{ asset("assets/js/search-box.js") }}"></script>

@stop