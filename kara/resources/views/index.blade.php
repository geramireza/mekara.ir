@extends("/layouts/default")


@section("meta-description")
    <meta name="keywords" content="{{ "کسب و کار اینترنتی,کاریابی و استخدام آنلاین,آگهی های استخدام استان سمنان,اشتغال و کسب و کار,استخدام دولتی و غیر دولتی,استخدام,کاریابی استان سمنان,کاریابی اینترنتی" }}">
    <meta name="description" content="{{"کارا-کاریابی اینترنتی. آگهی های فوری و جدید استخدام و کاریابی استان سمنان همه روزه از طریق وب سایت کارا منتشر می شود.با کارا نیروی متخصص کسب و کار خودت را پیدا کن."}}">
@stop

{{--Page Title--}}
@section("title")
    @parent
@stop

{{--Header Styles--}}
@section("header_styles")
    <link rel="stylesheet" href="{{asset("assets/css/index.css")}}">
    <link rel="stylesheet" href="{{asset("assets/css/main-banner-top.css")}}">
    <link rel="stylesheet" href="{{asset("assets/css/select2.min.css")}}">
    <link rel="stylesheet" href="{{asset("assets/css/search-box.css")}}">
@stop

{{--Slider Section--}}
@section("top")
    @include("main-banner-top")
@stop

{{--Content Section--}}
@section("content")
    <div class="container-fluid bg-info text-center py-3">
        <a href="{{ route("posts.more-views") }}" class="IranBold15‌ fw-600 text-white me-link-under-line-dashed">مشاهده
            پربازدید ترین آگهی ها</a>
    </div>
    <div class="container">
        <div class="row ">

            {{-- start alert free--}}
            <div class="alert alert-warning alert-dismissible fade show pr-3 IranBold13 fw-400 me-bg-warnign text-danger text-right text-md-center mt-3 mb-0 w-100 mx-2 mx-md-0" role="alert">
                    <div class="px-2">کاربر گرامی: آیا می دانید که ارسال آگهی از طریق اپلیکیشن کارا رایگان و بدون هزینه است!

                        <button type="button" class="close me-z-index-100 p-0" style="left: 5px!important;top:2px!important;right: auto!important;" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>

                        <a href="{{ route("download") }}" class="mr-2 mr-md-5 text-info">دانلود کارا</a>
                </div>
            </div>
            {{--end alert free--}}
            <div class="col-12 col-md-7 col-lg-8 mt-3 px-md-0">
                <div class="card">
                    <div class="card-header bg-white">
                        <h3 class="text-right IranBold15 fw-600 me-text-heading-color">جدید ترین آگهی های فوری</h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            @foreach($emergencies as $post)
                                <div class="col-sm-12 col-xl-6 position-relative">
                                     <div class="card mt-4">
                                         <a href="{{ route("posts.show",["slug" => $post->slug]) }}">
                                             <div class="card-body float-right w-100">
                                                 <span
                                                    class="card-title text-right me-title-text-color IranBold14 fw-400 text-truncate me-post-title-width">{{ $post->title }}
                                                 </span>
                                                 <div class="float-right w-100">
                                              <span class="float-right IranBold13 fw-400 text-muted ml-1">
                                            <i class="fas fa-money-bill me-text-light-gray"></i>
                                                  @include("layouts.post_fee")
                                              </span>
                                                 </div>
                                                 <br>
                                                 <div class="w-100 float-right">
                                                     <span class=" float-left btn btn-outline-danger px-3 Iran14 fw-600 p-1">فوری</span>
                                                     <div class="float-right IranBold13 fw-400 text-muted mr-1 mt-2">
                                                         <i class="fas fa-map-marker-alt me-text-light-gray"></i>
                                                         {{ getTimeAgo($post->published_at) }}
                                                         <span> در</span>
                                                         <span class="text-warning"> {{  $post->city }}</span>
                                                     </div>
                                                 </div>

                                                 {{--<div class="w-100 float-right">--}}
                                                     {{--<span class=" float-left btn btn-outline-danger px-3 Iran14 fw-600 p-1">فوری</span>--}}
                                                     {{-- start span post views--}}
                                                     {{--<span class="float-right IranBold13 fw-400 text-muted mt-2">--}}
                                                        {{--<i class="fa fa-eye me-text-light-gray"></i>--}}
                                                    {{--<span class="">--}}
                                                        {{--@if($post->view_count >= 1000)--}}
                                                            {{--<span>{{ convert(number_format($post->view_count/1000,1))."K"}}</span>--}}
                                                        {{--@else--}}
                                                            {{--<span>{{ convert($post->view_count)}}</span>--}}
                                                        {{--@endif--}}
                                                        {{--بازدید--}}
                                                    {{--</span>--}}
                                                    {{--</span>--}}
                                                     {{-- end span post views--}}
                                                 {{--</div>--}}


                                             </div>
                                         </a>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                    </div>

                    <div class="my-3 d-flex justify-content-center px-3">
                        <a class=" btn btn-outline-info px-5 py-2 mt-4  w-100 IranBold13 fw-400"
                           href="{{route("posts.more",["param" => "emergency"]) }}">آگهی های بیشتر</a>

                    </div>
                </div>
            </div>

            <div class="col-12 col-md-5 col-lg-4 mt-3 pl-md-0">
                <div class="card">
                    <div class="card-header bg-white">
                        <h3 class="text-right IranBold15 fw-600 me-text-heading-color">جدیدترین آگهی ها</h3>
                    </div>
                    @foreach($lastPosts as $post)
                        <a href="{{route("posts.show",["slug" => $post->slug])}}" class="float-right">
                            <div class="py-2 border-bottom float-right w-100">
                                <span class="card-title text-right me-title-text-color IranBold14 fw-400 text-truncate me-post-title-width px-3">{{ $post->title }}</span>
                                <div class="mt-4 px-3">
                                    <div class="float-right w-100">
                                  <span class="float-right IranBold13 fw-400 text-muted ml-1 w-100 text-right">
                                    <i class="fas fa-money-bill me-text-light-gray"></i>
                                      @include("layouts.post_fee")
                                   </span>
                                    </div>
                                <span class="float-right IranBold13 fw-400 text-muted mr-1 mt-2 w-100 text-right">
                                <i class="fas fa-map-marker-alt me-text-light-gray"></i>
                                    {{ getTimeAgo($post->published_at) }}
                                    <span> در</span>
                                      <span class="text-warning"> {{  $post->city }}</span>
                            </span>
                                    {{--<div class="w-100 float-right">--}}
                                    {{--<span class="float-right IranBold13 fw-400 text-muted mt-2">--}}
                                                        {{--<i class="fa fa-eye me-text-light-gray"></i>--}}
                                                    {{--<span class="">--}}
                                                        {{--@if($post->view_count >= 1000)--}}
                                                            {{--<span>{{ convert(number_format($post->view_count/1000,1))."K"}}</span>--}}
                                                        {{--@else--}}
                                                            {{--<span>{{ convert($post->view_count)}}</span>--}}
                                                        {{--@endif--}}
                                                        {{--بازدید--}}

                                                    {{--</span>--}}
                                                    {{--</span>--}}
                                    {{--</div>--}}

                                </div>
                            </div>
                        </a>
                    @endforeach

                    <div class="my-3 d-flex justify-content-center px-3">
                        <a class="btn btn-outline-info IranBold13 fw-400 px-5 w-100 py-2 mt-4"
                           href="{{ url("/more-posts",["param" => "last"]) }}">آگهی های بیشتر</a>

                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
@section("footer")
    @include("layouts.footer")
@stop

{{--Footer Scripts--}}
@section("footer_scripts")
    {{--<script src="{{asset("assets/js/script.js")}}"></script>--}}
    <script src="{{asset("assets/js/select2.full.min.js")}}"></script>
    <script src="{{asset("assets/js/search-box.js")}}"></script>
@stop