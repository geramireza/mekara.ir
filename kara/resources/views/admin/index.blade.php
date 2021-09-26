@extends("layouts.default")

@section("header_styles")

    {{--<link href="assets/css/bootstrap-toggle.min.css" rel="stylesheet">--}}
    <link href="{{ asset("assets/css/search-box.css") }}" rel="stylesheet">
    <link href="{{ asset("assets/css/select2.min.css") }}" rel="stylesheet">
    <link  href="{{ asset("assets/css/style.css") }}" rel="stylesheet">
    <link  href="{{ asset("assets/css/search.css") }}" rel="stylesheet" >

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
                <div class="card">
                    <div class="card-header bg-light ">
                        <div class="text-right float-right IranBold15 fw-600 text-info">کارا در یک نگاه</div>
                    </div>

                    <div class="card-body bg-white">
                        <div class="row">
                            <div class="col-md-6 mb-5">
                                <div class="card bg-info">
                                    <div class="card-body text-center text-white">
                                        <h4 class="IranBold15 fw-600 mb-4">کل آگهی های فعال</h4>
                                        <span class="IranBold15 fw-600">{{ $totalPosts }}</span>
                                    </div>
                                </div>
                            </div>


                            <div class="col-md-6 mb-5">
                                <div class="card bg-info">
                                    <div class="card-body text-center text-white">
                                        <h4 class="IranBold15 fw-600 mb-4">کل آگهی های فعال امروز</h4>
                                        <span class="IranBold15 fw-600">{{ $totalToday }}</span>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6 mb-5">
                                <div class="card bg-info">
                                    <div class="card-body text-center text-white">
                                        <h4 class="IranBold15 fw-600 mb-4">کل آگهی های فعال هفت روز گذشته</h4>
                                        <span class="IranBold15 fw-600">{{ $totalInWeek }}</span>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6 mb-5">
                                <div class="card bg-info">
                                    <div class="card-body text-center text-white">
                                        <h4 class="IranBold15 fw-600 mb-4">کل آگهی های فعال سی روز گذشته</h4>
                                        <span class="IranBold15 fw-600">{{ $totalInMonth }}</span>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6 mb-5">
                                <div class="card bg-info">
                                    <div class="card-body text-center text-white">
                                        <h4 class="IranBold15 fw-600 mb-4">آگهی های در انتظار تایید</h4>
                                        <span class="IranBold15 fw-600">{{ $countNotConfirmed }}</span>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6 mb-5">
                                <div class="card bg-info">
                                    <div class="card-body text-center text-white">
                                        <h4 class="IranBold15 fw-600 mb-4">تعداد کاربران کارا</h4>
                                        <span class="IranBold15 fw-600">{{ $totalUsers }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>

                </div>
            </div>
        </div>
    </div>

@endsection

@section("footer")
    @include("layouts.footer")
@stop
@section("footer_scripts")
    {{--<script src="assets/js/bootstrap-toggle.min.js"></script>--}}
    <script src="{{ asset("assets/js/select2.full.min.js") }}"></script>
    <script src="{{ asset("assets/js/search.js") }}"></script>

    <script>
        $(".me-select2").select2();

    </script>
@stop
