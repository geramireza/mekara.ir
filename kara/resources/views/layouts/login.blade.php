@extends("layouts.default")

@section("header_styles")
    <link rel="stylesheet" href="{{ asset("assets/css/alert-form.css") }}">
@stop
@section("content")

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8 me-margin-top">
                <div class="alert alert-info text-right me-font-Iran12 fw-400 Iran14">شما هنوز وارد حساب کاربری خود نشده اید.برای مشاهده آگهی های خود شماره موبایل خود را وارد نمایید</div>
                <div class="card">
                    <div class="card-header text-right float-right"> ورود به حساب کاربری</div>

                    <div class="card-body px-4">
                        <span class="text-right float-right text-info me-font-Iran12 Iran14 fw-600">شما آگهی هایی که با این شماره ثبت کرده اید را مشاهده می کنید</span>
                        <br>

                        <div class="me-confirm-error btn btn-outline-danger my-2 me-font-Iran12 Iran14 fw-600 w-100 me-display-none float-right"> کد تایید کارا معتبر نیست</div>
                        <div class="me-server-error btn btn-outline-danger my-2 me-font-Iran12 Iran14 fw-600 w-100 me-display-none float-right">شما به تازگی درخواست کد داده اید.لطفا صبور باشید.</div>
                        <div class="me-confirm-success btn btn-outline-success my-2 w-100 me-font-Iran12 Iran14 fw-600 me-display-none float-right"> کد تایید کارا از طریق پیامک برای شما ارسال شد</div>


                        <form method="POST">
                            <div id="div-input-login-phone" class="form-group mt-md-3">
                                <label for="" class="col-md-3 col-form-label text-right Iran14 fw-600 float-right">موبایل:</label>
                                <input type="text" name="phone" class="me-input-phone form-control col-md-6 float-right " placeholder="09123456789">
                            </div>

                            <div id="div-input-login-password" class="form-group mt-md-3 me-display-none w-100 float-right">
                                <label for="" class="col-md-3 col-form-label text-right float-right Iran14 fw-600 float-right">کد تایید کارا:</label>
                                <input type="text" name="phone" class="me-input-password form-control col-md-6 float-right" placeholder="1234">
                            </div>

                            <div id="div-input-login-remember" class="form-group mt-md-2 mr-3 me-display-none">
                                <div class="col-md-8 justify-content-center d-flex">
                                <span class="me-span-checkbox ml-2 mt-1">
                                <input type="checkbox" name="remember_me" class="form-control me-input-checkbox opacity-none">
                                </span>
                                    <label for="" class="col-form-label text-right float-right Iran14 fw-600">مرا به خاطر بسپار</label>

                                </div>
                              </div>


                            <div class="form-group text-center">
                                <div class=" w-100 mt-3 me-display-none me-loading mr-auto ml-auto float-right"><i class="fas fa-2x fa-spinner fa-spin"></i><br><span class="fw-600 Iran13">در حال پردازش...</span></div>

                            </div>

                            <div id="div-btn-login-phone" class="form-group text-center">
                                <button type="button" id="btn-login-phone" class="me-btn-phone me-btn-phone-send btn btn-outline-info mt-4 px-5 Iran14 fw-600 mr-auto ml-auto" disabled >دریافت رمز عبور</button>
                            </div>

                            <div id="div-btn-login-password" class="form-group me-display-none text-center">
                                <button type="button"class="me-btn-password me-btn-password-send btn btn-outline-info mt-4 px-5 Iran14 fw-600 mr-auto ml-auto" disabled>ارسال رمز عبور</button>
                            </div>

                        </form>
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
    <script type="text/javascript" src="{{ asset("assets/js/alert-form.js") }}"></script>
@stop