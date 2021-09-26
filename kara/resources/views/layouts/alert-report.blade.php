<div  class=" row justify-content-center d-flex me-z-index-100 position-relative">
    <div class="col-12 me-alert-box me-alert-report-box me-display-none">
                <div class="alert alert-info alert-dismissible fade show position-absolute p-3 p-md-5 me-position-absolute-trl-0" role="alert">

                    <div class="card">
                        <div class="card-header text-right IranBold15 fw-600 text-info">
                            گزارش مشکل آگهی
                        </div>
                        <div class="confirm_phone_card card-body">


                            <div id="btn-report-error" class="me-font-Iran13 Iran14 btn btn-outline-danger mb-2 w-100 me-display-none float-right">خطایی در ارتباط با سرور رخ داده است.لطفا مجدد تلاش کنید</div>
                            <div id="btn-report-success" class="me-font-Iran13 Iran14 c-confirm-success btn btn-outline-success mb-2 w-100 me-display-none float-right">انتقاد شما با موفقیت ثبت گردید.</div>


                            <form method="POST">
                                <meta name="csrf-token" content="{{ csrf_token() }}">
                                <input id="report_post_id" type="hidden" value="{{ $post->id }}">
                                <div class="form-group">
                                    <label for="" class="IranBold14 fw-400 text-right w-100">دلیل نارضایتی خود را از آگهی بیان کنید</label>
                                    <select  class="me-report-select form-control">
                                        @foreach($reports as $report)
                                            <option  class="me-report-select-option me-font-Iran12 Iran14 fw-400 py-3 text-right float-right "  value="{{ $report->id }}">
                                                {{ $report->title }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div id="div-textarea-report" class="form-group me-display-none">
                                    <label for="" class="IranBold14 fw-400 text-right float-right">توضیحات بیشتر</label>
                                    <textarea id="textarea-report" rows="4" class="form-control"></textarea>
                                </div>

                                <div class="form-group">
                                    <label for="" class="IranBold14 fw-400 text-right float-right">در صورت تمایل جهت ارتباط موثرتر شماره موبایل خود را وارد کنید </label>
                                    <small class="text-danger Iran11 fw-600 float-right">(اختیاری)</small>
                                    <input  id="input-report-phone" type="text" class="form-control" placeholder="09123456789">
                                </div>

                                <div class="form-row d-flex justify-content-center">
                                    <div class=" w-100 mt-3 me-display-none text-center me-loading"><i class="fas fa-2x fa-spinner fa-spin"></i><br><span class="fw-600 Iran13">در حال پردازش...</span></div>

                                    <button type="button" class="btn btn-outline-secondary col-3 mt-2 mx-2 IranBold14 fw-400 me-alert-cancle">بی خیال</button>
                                    <button type="button" id="btn-report-confirm" class="btn btn-info col-3 mt-2 mx-2 IranBold14 fw-400">تایید</button>
                                </div>

                            </form>

                        </div>
                    </div>

                    <button  class="me-alert-close" type="button">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

            </div>
        </div>
<div class="me-alert-form-position-fixed me-alert-dark me-alert-report-dark me-display-none"></div>


