@extends("layouts.default")

@section("meta-description")
    <meta name="description" content="{{"راه های ارتباط با کارا-کاریابی اینترنتی در استان سمنان از طریق ایمیل تلگرام و فرم انتقادات وپیشنهادات به راحتی امکان پذیر هست."}}">
@stop


@section("content")

    <div class="container">
        <div class="row ">
            <div class="col-12">
                <div class="card my-3">
                    <div class="card-header text-right  IranBold16 fw-600 text-info bg-">
                        راه های ارتباط با ما
                    </div>
                    <div class="card-body text-right w-100 px-md-5 py-5">
                        <p class="IranBold15 fw-600">تماس با ما</p>
                        <p class="text-right Iran15 fw-400 mx-md-5" style="line-height: 35px;">اگر پیشنهاد و یا انتقادی دارید و یا می خواهید ما را از بروز مشکلی در سیستم مطلع کنید می توانید با یکی از راه های زیر با ما در ارتباط باشید.</p>

                        <p class="text-right IranBold14 fw-400 mt-3 mx-md-5">
                            <i class="fas fa-envelope text-secondary fa-1x ml-1 fa-2x align-middle"></i>
                            ایمیل:

                            <span class="mr-3">info.mekara@gmail.com</span></p>
                        <p class="text-right IranBold14 fw-400 mt-3 mx-md-5">
                            <i class="fab fa-telegram fa-2x text-secondary align-middle ml-1"></i>

                            تلگرام: <span class="mr-3">{{"MekaraInfo@"}}</span></p>
                        <p class="text-right IranBold14 fw-400 mt-3 mx-md-5">
                            <i class="fas fa-phone fa-2x align-middle text-secondary ml-1 "></i>
                            تلفن ثابت: <span class="mr-3">02332369224</span></p>


                        <div class="card mx-md-5 mt-5">
                            <div class="card-header IranBold15 fw-600">
                                فرم انتقاد و پیشنهاد
                            </div>
                            <div class="card-body">
                                <form action="{{ route("contacts.reports") }}" method="POST">
                                    {{ csrf_field() }}
                                    <div class="form-group">
                                        <label for="" class="Iran14 fw-600 text-secondary">پیام شما</label>
                                        <textarea class="form-control" name="message" cols="30" rows="4"></textarea>
                                    </div>
                                    <div class="form-group">
                                        <label class="Iran14 fw-600 text-secondary w-100 mb-0" for="">شماره موبایل <span class="Iran12 fw-600 text-danger">(اختیاری)</span></label>
                                        <small class="Iran12 fw-400 text-muted">وارد کردن شماره تلفن اختیاری است.با وارد کردن آن ما بهتر با شما ارتباط می گیریم.</small>
                                        <input class="me-input-phone form-control" name="phone" >
                                    </div>

                                    <button type="submit" class="me-btn-contact btn btn-outline-info float-left IranBold14 fw-600 px-3">ارسال پیام</button>
                                </form>
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
    <script>
        $(".me-input-phone").on("input",function () {
            var value = $(this).val();
            if( value == "" || (value.length == 11 && $.isNumeric(value) && value.startsWith("09"))) {
                $(".me-btn-contact").removeAttr("disabled","false");
                $(this).removeClass("me-border-danger");
            }else{
                $(".me-btn-contact").prop("disabled","true");
                $(this).addClass("me-border-danger");
            }
        })
    </script>
@stop