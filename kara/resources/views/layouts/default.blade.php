<!doctype html>
<html lang="en" dir="rtl">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    {{--<meta name="viewport" content="width=device-width, initial-scale=1">--}}
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no, shrink-to-fit=no">

    @yield("meta-description")


    {{--CSRF Token--}}
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->

{{--Pages Title    --}}
    <title>
        @section("title")
              کارا - کاریابی اینترنتی
        @show
    </title>

{{--Global Css Files--}}
    <link rel="stylesheet" href="{{asset("assets/css/bootstrap.min.css")}}">
    <link rel="stylesheet" href="{{asset("assets/css/all.min.css")}}">
    <link rel="stylesheet" href="{{asset("assets/css/default.css")}}">
    <link rel="stylesheet" href="{{ asset("assets/css/style.css") }}">

{{--Header Styles    --}}
    @yield("header_styles")

</head>

<body>

{{--sweet alerts--}}
@include('sweetalert::alert')

{{--Site Header--}}
@include("layouts.header")

{{--Slider Section--}}
@yield("top")

{{--Content Section--}}
@yield("content")

{{--Site footer--}}
@yield("footer")

{{--Global Scripts--}}
<script src="{{asset("assets/js/jquery-3.4.1.min.js")}}"></script>
<script src="{{ asset("assets/js/latin2Arabic.jquery.js") }}"></script>
<script src="{{asset("assets/js/popper.min.js")}}"></script>
<script src="{{asset("assets/js/bootstrap.min.js")}}"></script>
<script src="{{ asset("assets/js/select2.full.min.js") }}"></script>
<script src="{{ asset("assets/js/default.js") }}"></script>
<script src="{{asset("assets/js/all.min.js")}}"></script>
{{--<script src="{{ asset("assets/js/script.js") }}"></script>--}}


@yield("footer_scripts")


</body>
</html>