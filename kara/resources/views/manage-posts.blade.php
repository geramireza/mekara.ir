@extends("/layouts/default")

@section("header_styles")
    <link rel="stylesheet" href="{{ asset("assets/css/select2.min.css") }}">
    <link rel="stylesheet" href="{{ asset("assets/css/search-sidebar.css") }}">
    <link rel="stylesheet" href="{{ asset("assets/css/alert-form.css") }}">
    <link rel="stylesheet" href="{{ asset("assets/css/create-and-edit.css") }}">
    <link rel="stylesheet" href="{{ asset("assets/css/manage-posts.css") }}">
@stop
@section("content")

<div class="container bg-white px-3 pb-5">

@include("layouts.alert-report")

@if(!isLoginWithThisPhone($post->phone))
        @include("layouts.alert-password")
@endif

        <div class="row">
        <div class="col-12 bg-white mt-3 px-3 px-md-5">
            <div class="Iran16 fw-600 text-right w-100 mt-2"> مدیریت آگهی</div>

            @if($param == "preview" && !isLoginWithThisPhone($post->phone))
                <span class="text-right IranBold14 w-100 mt-2 float-right mb-md-5 text-info">جهت انتشار آگهی باید ابتدا شماره موبایل خود را تایید نمایید</span>
            @else
            <span class="text-right IranBold14 w-100 mt-2 float-right mb-5 mb-md-5 text-info">انتشار آگهی رایگان نیست و شامل هزینه است.
                برای انتشار بر  روی دکمه ارتقا آگهی کلیک کنید.</span>

           @endif

            <div class="w-100 mt-5 mt-md-0  d-flex justify-content-center justify-content-md-end">

                @if(!isLoginWithThisPhone($post->phone))
                    <a href="" class="btn btn-info px-3 px-sm-5 me-font-Iran13 Iran16 fw-600 mx-1 text-center">
                    <i class="fas fa-check ml-1"></i>تایید شماره</a>

                @else
                    <a  href="{{ route("manage",["data" => "pay","token" =>$post->post_token]) }}" class="btn btn-info px-3 px-sm-5 mx-1 me-font-Iran13 Iran16 fw-600"> <i class="fas fa-credit-card ml-2"></i>ارتقاء آگهی</a>
                @endif

                @if($post->is_delete == 0)
                        <form action="{{ route("posts.delete",["token" =>$post->post_token]) }}" method="POST">
                            {{ csrf_field() }}
                            <button type="submit" class="btn btn-danger px-3 px-sm-5 mx-1 me-font-Iran13 Iran16 fw-600 text-center">  <i class="fas fa-trash ml-1"></i>حذف آگهی</button>
                        </form>
                    @else
                        <form action="{{ route("rePublishPost",["token" =>$post->post_token]) }}" method="POST">
                            <input type="hidden" name="_method" value="PATCH">
                            {{ csrf_field() }}
                            <button type="submit" class="btn btn-danger px-3 px-sm-5 mx-1 Iran16 fw-600">  <i class="fas fa-reply fa-rotate-90 ml-1"></i>انتشار مجدد آگهی</button>
                        </form>
                    @endif

            </div>
            <div class="me-manage-tabs w-100 mr-auto ml-auto mt-5 text-center me-border-bottom-strock py-3 float-right">

                <a href="{{ route("manage",["param" => "preview" , "token" => $post->post_token]) }}" class="my-3 px-2 px-md-3 py-3 Iran14 me-font-Iran13 fw-600 text-secondary c-text-light-danger @if($param == "preview") me-manage-tabs-color @endif" >پیش نمایش آگهی</a>
                <a href="{{ route("manage",["param" => "pay","token" => $post->post_token]) }}" class="my-3 px-2 px-md-3 py-3 Iran14 me-font-Iran13 fw-600 text-secondary @if($param == "pay") me-manage-tabs-color @endif">ارتقاء آگهی</a>
                <a href="{{ route("manage",["param" => "edit","token" => $post->post_token]) }}" class="my-3 px-2 px-md-3 py-3 Iran14 me-font-Iran13 fw-600 text-muted @if($param == "edit") me-manage-tabs-color @endif">ویرایش</a>

            </div>
        </div>
    </div>

    @if($param == "preview")
        <div class="px-3 px-md-5">
            @include("layouts.detail-posts")
        </div>
    @elseif($param == "pay")
            @include("layouts.pay")
    @elseif($param == "edit")
            @include("layouts.edit")
    @endif
</div>

@endsection

@section("footer")
    @include("layouts.footer")
@stop
@section("footer_scripts")
    <script type="text/javascript" src="{{ asset("assets/js/search-sidebar.js") }}"></script>
    <script type="text/javascript" src="{{ asset("assets/js/alert-form.js") }}"></script>
    <script type="text/javascript" src="{{ asset("assets/js/select2.full.min.js") }}"></script>
    <script type="text/javascript" src="{{ asset("assets/js/detail-posts.js") }}"></script>
    <script type="text/javascript" src="{{ asset("assets/js/create-and-edit.js") }}"></script>
    <script type="text/javascript" src="{{ asset("assets/js/manage-posts.js") }}"></script>

@stop