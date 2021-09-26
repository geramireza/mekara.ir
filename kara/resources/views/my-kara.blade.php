@extends("layouts.default")

@section("header_styles")
    <link rel="stylesheet" href="{{ asset("assets/css/manage-posts.css") }}">
@stop
@section("content")

    <div class="container">

        <div class="row">

            <div class="col-12">
                <div class="card mt-3">
                       <div class="card-header bg-white pt-3">
                <a class="text-right  IranBold15 fw-600 float-right mt-2">حساب کاربری</a>
                <a class="btn btn-outline-danger Iran16 fw-600 float-left" href="{{ route("logout") }}" >خروج از حساب</a>

                </div>
                <div class="card-body">
                <div class="text-info Iran15 fw-400 text-right">شما آگهی هایی که با شماره  <span class="px-1 fw-600 IranBold15">{{ convert(session("phone")) }}</span>ایجاد کرده اید را مشاهده می کنید
                </div>

                <div class="me-manage-tabs w-100 mt-5 text-center me-border-bottom-strock py-3 float-right">
                <a href="{{ route("myKara",["param" => "my-posts"]) }}" class="col-6 px-2 px-md-3 py-3 me-font-Iran13 Iran14 fw-600 text-info text-right @if($param == "my-posts") me-manage-tabs-color @endif" >آگهی های من</a>
                <a href="{{ route("myKara",["param" => "my-bookmarks"]) }}" class="col-6 px-2 px-md-3 py-3 me-font-Iran13 Iran14 fw-600 text-info text-right @if($param == "my-bookmarks") me-manage-tabs-color @endif">نشان شده ها</a>
                <a href="{{ route("myKara",["param" => "my-deleted"]) }}" class="col-6 px-2 px-md-3 py-3 me-font-Iran13 Iran14 fw-600 text-info text-right @if($param == "my-deleted") me-manage-tabs-color @endif">حذف شده ها</a>

                </div>

                @if($param == "my-posts")
                @include("layouts.my-posts")
                @elseif($param == "my-bookmarks")
                @include("layouts.my-bookmarks")
                @else
                @include("layouts.my-deleted")
                @endif

                </div>
                </div>

            </div>
           </div>


        @include("pagination-row")

    </div>


@endsection

@section("footer")
    @include("layouts.footer")
@stop