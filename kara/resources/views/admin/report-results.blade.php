@extends("layouts.default")

@section("header_styles")
    <link href="{{ asset("assets/css/search-box.css") }}" rel="stylesheet">
    <link href="{{ asset("assets/css/select2.min.css") }}" rel="stylesheet">
    <link  href="{{ asset("assets/css/search.css") }}" rel="stylesheet" >
@stop


@section("content")
    <div class="container">
        <div class="row">
            <div class="col px-md-0">
                @include("layouts.search-box")
            </div>
        </div>
        <div class="row">
            @include("admin.sidebar")
            <div class="col-lg-9 my-3 px-md-0">
                    <div class="card">
                        @if(count($reports))
                        <div class="card-header IranBold14 text-right fw-600 text-info bg-white">
                            {{ "تعداد ". convert($countReportNotSeen) ." گزارش مشکل آگهی خوانده نشده یافت شد" }}
                        </div>
                        <div class="card-body">
                            @foreach($reports as $report)
                                <div class="card my-4">
                                    <div class="card-header card-header bg-light text-right">
                                        <a href="{{ route("posts.show",["slug" => $report->post->slug]) }}" class="float-right text-info IranBold14 fw-400">{{ $report->post->title }}</a>
                                        <div class="float-left IranBold12 fw-400"> موبایل صاحب آگهی:
                                            <span class="mr-md-5 bg-light fw-400 Iran14 py-2">{{ $report->post->user->phone }}</span>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <label class="text-right IranBold14 fw-600 w-100">متن گزارش:</label>
                                        <div class="text-right w-100 px-2 " style="white-space: pre-wrap;"><a href="{{ route("posts.show",["slug" => $report->post->slug]) }}" class="text-info">{{ $report->body }}</a></div>
                                        <div class="float-left IranBold14 fw-600 float-right mt-3 d-flex align-items-center">
                       <div class="float-right">
                           موبایل گزارش کننده:
                       </div>
                                            @if($report->user)
                                                <span class="mr-3 mr-md-5 bg-light fw-400 Iran14 px-2 px-md-4 py-2 float-left">{{ $report->user->phone }}</span>
                                            @else
                                                <span class="mr-3 mr-md-5 bg-light fw-400 Iran14 px-2 px-md-4 py-2 float-left">بی نشان</span>
                                            @endif
                                        </div>

                                        <div  class="text-center float-left mt-3">
                                            <span class="IranBold12 fw-600 float-right p-2">خواندم و بررسی می کنم</span>
                                            <label class="switch">
                                                <input class="toggle_button" id="{{$report->id}}" name="is_enable" type="checkbox" @if($report->is_seen) {{ "checked" }} @endif>
                                                <span class="slider round p-2 text-warning"></span>
                                            </label>
                                        </div>
                                        <div class="w-100 float-left">
                                            <a href="{{ route("admin.deleteReport",["param" => "report","id" => $report->id]) }}" class="btn btn-outline-danger IranBold14 fw-400 mt-3">حذف گزارش</a>
                                        </div>

                                    </div>
                                </div>
                            @endforeach

                        </div>
                        @else
                            <div class="card-header text-success text-right bg-white IranBold14 fw-600">
                                {{ "تعداد ". convert($countReportNotSeen) ." انتقاد و یا پیشنهاد خوانده نشده یافت شد" }}
                            </div>
                            <i class="fa fa-geram w-100 text-center mt-5 fa-3x text-danger mb-1"></i>
                            <p class="text-right IranBold14 fw-400 text-danger text-center w-100 pb-5"> موردی یافت نشد</p>

                        @endif
                    </div>

                <div class="row px-md-0">
                    <div class="col d-flex mt-5 justify-content-center">
                        {{ $reports->links() }}
                    </div>
                </div>

            </div>

          </div>
    </div>
 @stop

@section("footer")
    @include("layouts.footer")
@stop

@section("footer_scripts")
    <script src="{{ asset("assets/js/select2.full.min.js") }}"></script>
    <script src="{{ asset("assets/js/search.js") }}"></script>

    <script>
    $(".toggle_button").click(function () {
    var reportId = $(this).attr("id");
    var checked  = $(this).is(":checked");
    $.ajax({
    type : "post",
    dataType : "json",
    url : "/admin/seen-reports",
    headers:
    {
    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    },
    data : {checked : checked,reportId : reportId},
    })

    })
    </script>
@stop