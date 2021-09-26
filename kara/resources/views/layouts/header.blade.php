<header class="bg-info">
    <nav class="navbar navbar-expand-lg container navbar-dark bg-info p-0">
        <a href="{{ url("/") }}" class="navbar-brand">
            <img style="height: 50px;" class="ml-5" src="{{asset("assets/img/logo.png")}}" alt="">
        </a>
         <button class="navbar-toggler ml-4 custom-toggler " type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div  id="navbarNav" class="collapse navbar-collapse px-0">
            <ul class="navbar-nav ml-auto px-0">

                <li class="nav-item px-3 mr-md-1 px-lg-1 @if(url()->current() == url("/")) {{ "me-header-item-active"}} @endif">
                    <a class="nav-link IranBold15 fw-400 float-right w-100 text-right text-white" href="{{url("/")}}">خانه <span class="sr-only"></span></a>
                </li>

                <li class="nav-item px-3 mr-md-1 px-lg-1 @if(url()->current() == route("search")) {{ "me-header-item-active"}} @endif">
                    <a class="nav-link IranBold15 fw-400 float-right w-100 text-right text-white" href="{{ route("search") }}">جستجوی مشاغل</a>
                </li>

                {{--<li class="nav-item px-3 mr-md-1 px-lg-1 @if(url()->current() == route("blog")) {{ "me-header-item-active"}} @endif">--}}
                    {{--<a class="nav-link IranBold15 fw-400 float-right w-100 text-right text-white" href="{{ route("blog") }}">وبلاگ</a>--}}
                {{--</li>--}}

                <li class="nav-item px-3 mr-md-1 px-lg-1 @if(url()->current() == url("about")) {{ "me-header-item-active"}} @endif">
                    <a class="nav-link IranBold15 fw-400 float-right w-100 text-right text-white" href="{{ route("about") }}">درباره کارا</a>
                </li>

                <li class="nav-item px-3 mr-md-1 px-lg-1 @if(url()->current() == url("contact")) {{ "me-header-item-active"}} @endif">
                    <a class="nav-link IranBold15 fw-400 float-right w-100 text-right text-white" href="{{ route("contact") }}" >تماس با ما</a>
                </li>
                <li class="nav-item px-3 mr-md-1 px-lg-1">
                    <a class="nav-link IranBold15 fw-400 float-right w-100 text-right text-white" href="{{ route("download") }}" >دانلود اپلیکیشن</a>
                </li>
            </ul>
            <div class="d-flex d-lg-block justify-content-center my-3 my-lg-0">

                @if(isAdmin())
                    <a class="btn me-btn-outline-white mx-1 text-white IranBold14 fw-400 me-w-md-100" href="{{ route("admin.dashbord") }}" >مدیریت</a>
                @endif
                <a class="btn me-btn-outline-white mx-1 text-white IranBold14 fw-400 me-w-md-100" href="{{ route("myKara") }}" >کارای من</a>
                <a class="btn me-btn-outline-white mx-1 text-white IranBold14 fw-400 me-w-md-100" href="{{ route("posts.create") }}" >ایجاد آگهی جدید</a>
            </div>
        </div>
    </nav>





</header>