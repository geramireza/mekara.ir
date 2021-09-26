<div class="row justify-content-center d-flex me-z-index-100 position-relative">
    <div class="col-12 col-md-10 me-alert-box me-alert-bookmark-box me-display-none">
        <div class="alert alert-info alert-dismissible fade show position-absolute p-5 me-position-absolute-trl-0" role="alert" >

            <div class="card">
                <div class="card-header text-right IranBold15 fw-600 text-info">
                    تایید شماره موبایل

                </div>
                <div class="me-alert-form-card card-body">
                    <div class="alert alert-info text-right fw-400 Iran14">شما هنوز وارد حساب کاربری خود نشده اید برای نشان کردن آگهی شماره موبایل خود را وارد کنید.</div>

                    <div class="me-confirm-error btn btn-outline-danger mb-2 w-100 me-display-none"> کد تایید کارا معتبر نیست</div>
                    <div class="me-server-error btn btn-outline-danger mb-2 w-100 me-display-none">شما لحظاتی پیش درخواست ارسال رمز داده اید.اندکی صبر کنید</div>
                    <div class="me-confirm-success btn btn-outline-success mb-2 w-100 me-display-none"> کد تایید کارا از طریق پیامک برای شما ارسال شد</div>

                    <form method="POST" >
                        <div id="div-input-login-phone" class="form-group row mt-md-3">
                            <label for="" class="col-md-3 col-form-label text-right Iran14 fw-600">موبایل:</label>
                            <input type="text" name="phone" class="me-input-phone form-control col-md-6 " placeholder="09121212121">
                        </div>

                        <div id="div-input-login-password" class="form-group row mt-md-3 me-display-none">
                            <label for="" class="col-md-3 col-form-label text-right float-right Iran14 fw-600">کد تایید کارا:</label>
                            <input type="text" name="phone" class="me-input-password form-control col-md-6 " placeholder="1234">
                        </div>

                        <div id="div-input-login-remember" class="form-group row mt-md-3 me-display-none">
                            <div class="col-md-8 justify-content-center d-flex">
                                <span class="me-span-checkbox ml-2 mt-2">
                                <input type="checkbox" name="remember_me" class="form-control me-input-checkbox opacity-none">
                                </span>
                                <label for="" class="col-form-label text-right float-right Iran14 fw-600">مرا به خاطر بسپار</label>

                            </div>
                        </div>


                        <div class="form-group">
                            <div class=" w-100 mt-3 me-display-none me-loading mr-auto ml-auto text-center"><i class="fas fa-2x fa-spinner fa-spin"></i><br><span class="fw-600 Iran13">در حال پردازش...</span></div>

                        </div>

                        <div id="div-btn-login-phone" class="form-group row mt-4">
                            <button type="button" class="me-btn-phone me-btn-phone-send btn btn-outline-info px-5 Iran14 fw-600 mr-auto ml-auto" disabled >دریافت رمز عبور</button>
                        </div>

                        <div id="div-btn-login-password" class="form-group row mt-4 me-display-none text-center">
                            <button type="button"class="me-btn-password me-btn-bookmark-password-send btn btn-outline-info px-5 Iran14 fw-600 mr-auto ml-auto" disabled>ارسال رمز عبور</button>
                        </div>

                    </form>

                </div>

            </div>

            <button class="me-alert-close" type="button">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>

    </div>
</div>
<div class="me-alert-form-position-fixed me-alert-dark me-alert-bookmark-dark me-display-none"></div>
