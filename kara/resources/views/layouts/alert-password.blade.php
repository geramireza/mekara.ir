 <div class="me-alert-form-box row justify-content-center d-flex me-z-index-100 position-relative">
        <div class="col-12 col-md-10 me-alert-box">
    <div class="alert alert-info alert-dismissible fade show position-absolute p-3 p-lg-5 me-position-absolute-trl-0" role="alert" >

        <div class="card">
            <div class="card-header text-right IranBold15 fw-600 text-info">
 تایید شماره موبایل

            </div>
            <div class="me-alert-form-card card-body">

                <div class="me-alert-form-error me-confirm-error btn btn-outline-danger my-2 w-100 me-display-none me-font-Iran13 Iran14 float-right"> کد تایید کارا معتبر نیست</div>
                <div class="me-alert-form-resend-success btn btn-outline-success my-2 w-100 me-display-none me-font-Iran13 Iran14 float-right"> کد تایید کارا مجدد ارسال شد</div>
                <div class="me-server-error btn btn-outline-danger my-2 w-100 me-display-none me-font-Iran13 Iran14 float-right">شما لحظاتی پیش درخواست ارسال رمز داده اید.اندکی صبر کنید</div>
                <form id="" class="me-alert-form-form">
                    <meta name="csrf-token" content="{{ csrf_token() }}">

                    <div class="form-group">
                        <a class="me-alert-form-send-success me-confirm-success my-2 btn btn-outline-success text-success  text-center float-right w-100 me-font-Iran13 Iran14 float-right">کد تایید کارا از طریق پیامک برای شما ارسال شد.</a>
                        <input id="input-login-password" class="me-alert-form-input-password form-control col-md-6 mr-auto ml-auto Iran15 me-input-password" type="text" placeholder="کد تایید کارا...">
                    </div>

                    <div id="div-input-login-remember" class="form-group mt-md-3">
                        <div class="col-md-8 justify-content-center d-flex mr-md-5">
                                <span class="me-span-checkbox ml-2 mt-2">
                                <input type="checkbox" id="remember_me" name="remember_me" class="form-control me-input-checkbox opacity-none">
                                </span>
                            <label for="" class="col-form-label text-right float-right Iran14 fw-600">مرا به خاطر بسپار</label>

                        </div>
                    </div>

                    <div class="form-group text-center">
                        <div class=" w-100 mt-3 me-loading me-display-none"><i class="fas fa-2x fa-spinner fa-spin"></i><br><span class="fw-600 Iran13">در حال پردازش...</span></div>

                        <button type="button" disabled class="me-alert-form-btn-password btn btn-info col-md-6 mr-auto ml-auto mt-2 me-btn-password ">تایید</button>
                    </div>

                    <div class="form-group text-center">
                        <input type="hidden" class="me-input-phone" value="{{$post->phone}}">
                        <strong class="w-100 float-right text-center mt-3 mb-1">{{ convert($post->phone) }}</strong>
                        <button  type="button" class="me-alert-form-btn-resend-password col-md-6 btn btn-outline-info mr-auto ml-auto Iran13 fw-600">ارسال مجدد کد تایید</button>
                    </div>
                    <button type="button" class="me-alert-cancle btn btn-outline-danger IranBold14 fw-600">
                        <i class="fas fa-times"></i>
                        انصراف</button>

                </form>

            </div>
        </div>

        <button class="me-alert-close" type="button">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>

        </div>
    </div>
    <div class="me-alert-form-position-fixed me-alert-dark"></div>
