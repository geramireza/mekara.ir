<form id="form-pay-post" action="{{route("payment-request")}}" method="POST">
    {{ csrf_field() }}
    <input type="hidden" name="post_type" value="{{ $post->post_type }}">
    <input type="hidden" name="post_token" value="{{ $post->post_token }}">
    <div class="row px-md-3">
        <div class="col-lg-8 mt-4  order-first px-3 px-md-3">
            <div class="text-right IranBold15 fw-600 ">
                ارتقاء آگهی
            </div>
                <div class="form-group card px-4 py-4 mt-3 ">
                    <label for="" class="text-right IranBold14 fw-400 w-100 float-right">انتشار آگهی شامل هزینه است.</label>

                    <div class="me-parent-radio">
                        @if($post->post_type == 0)
                            <div class="row mr-1 mt-2 @if($post->is_pay == 1) disabled @endif">
                            <span id="span-pay-monthly" class="me-span-radio mt-1 @if($post->post_type == 0 && ( $post->is_pay == 0 || $post->post_life == 30)) me-checked @endif">
                                <input id="{{ $price->monthly }}" value="{{ App\Constants::KEY_MONTHLY }}" type="radio"  @if($post->post_type == 0 && $post->is_pay == 0)  checked @endif name="{{ App\Constants::KEY_PAY_TYPE }}" class="form-control me-input-radio opacity-none">
                            </span>
                                <label class="me-font-Iran13 Iran14 fw-600 mr-1 text-info" for="">
                                    <span class="d-none d-md-inline-block">انتشار آگهی به مدت</span> یک ماه
                                    <span class="mr-5 IranBold17 fw-400">{{ convert($price->monthly) }} تومان</span>
                                </label>

                            </div>

                            <div class="row mr-1 mt-2 @if($post->is_pay == 1) disabled @endif" >
                            <span id="span-pay-weekly" class="me-span-radio mt-1 @if($post->post_type == 0 && $post->post_life == 7 ) me-checked @endif">
                                <input id="{{ $price->weekly }}" value="{{ App\Constants::KEY_WEEKLY }}" type="radio" name="{{ App\Constants::KEY_PAY_TYPE }}" class="form-control me-input-radio opacity-none">
                                </span>
                                <label class="me-font-Iran13 Iran14 fw-600 mr-1 text-info" for=""><span
                                            class="d-none d-md-inline-block">انتشار آگهی به مدت</span> یک هفته<span class="mr-5 IranBold17 fw-400">{{ convert($price->weekly) }} تومان</span></label>

                            </div>

                        @elseif($post->post_type == 1)

                            <div class="row mr-1 mt-2 @if($post->is_pay == 1) disabled @endif">
                            <span id="span-pay-monthly-karjoo" class="me-span-radio mt-1  @if($post->post_type == 1 && ($post->is_pay == 0 || $post->post_life == 30)) me-checked @endif">
                                <input id="{{ $price->monthly_karjoo }}" value="{{ App\Constants::KEY_MONTHLY_KARJOO }}" type="radio"  @if($post->post_type == 1 && $post->is_pay == 0) checked @endif name="{{ App\Constants::KEY_PAY_TYPE }}" class="me-input-radio form-control opacity-none">
                                </span>
                                <label class="Iran14 fw-600 mr-1 text-info" for=""><span class="d-none d-md-inline-block">انتشار آگهی به مدت</span> یک ماه  <span class="mr-5 IranBold17 fw-400">{{ convert($price->monthly_karjoo) }} تومان</span></label>

                            </div>

                            <div class="row mr-1 mt-2 @if($post->is_pay == 1) disabled @endif">
                            <span id="span-pay-weekly-karjoo" class="me-span-radio mt-1 @if($post->post_type == 1 && $post->post_life == 7 ) me-checked @endif">
                                <input id="{{ $price->weekly_karjoo }}" value="{{ App\Constants::KEY_WEEKLY_KARJOO }}" type="radio" name="{{ App\Constants::KEY_PAY_TYPE }}" class=" me-input-radio form-control opacity-none">
                                </span>
                                <label class="Iran14 fw-600 mr-1 text-info" for=""><span class="d-none d-md-inline-block">انتشار آگهی به مدت </span> یک هفته  <span class="mr-5 IranBold17 fw-400">{{ convert($price->weekly_karjoo) }} تومان</span></label>
                            </div>

                        @endif

                    </div>

                </div>

                <div class="form-group card mt-3 px-4 py-4">
                    <label for="" class="text-right IranBold14 fw-400 w-100 float-right"> برچسب فوری</label>
                    <small class="text-right text-muted">با انتخاب این گزینه آگهی شما به مدت یک هفته با برچسب فوری منتشر می گردد.این گزینه علاوه بر ایجاد تمایز ظاهری نسبت به سایر آگهی ها، در دسته بندی فوری نیز نمایش داده می شود</small>
                    <div class="row mr-1 mt-2 @if($post->is_emergency == 1) disabled @endif">
                            <span id="span-pay-emergency" class="me-span-checkbox mt-1 @if($post->is_emergency == 1) me-checked @endif">
                                    <input id="{{ $price->emergency }}" name="{{ App\Constants::KEY_EMERGENCY }}"  type="checkbox" class="form-control me-input-checkbox opacity-none">
                            </span>
                        <label class="Iran14 fw-600 mr-1 text-info" for=""><span class="d-none d-md-inline-block">انتشار آگهی با</span> برچسب فوری  <span class="mr-5 IranBold17 fw-400">{{ convert($price->emergency) }} تومان</span></label>

                    </div>
                </div>


                <div class="form-group card mt-3 px-4 py-4">
                    <label for="" class="text-right IranBold14 fw-400 w-100 float-right">تمدید آگهی</label>
                    <small class="text-right text-muted">جهت انتشار مجدد آگهی خود شما می توانید آن را تمدید نمایید.این گزینه بعد از انتشار آگهی فعال می گردد. </small>
                    <div class="row mr-1 mt-2 @if($post->is_pay == 0 || $post->is_extended == 1) disabled @endif">
                            <span id="span-pay-extended" class="me-span-checkbox mt-1 @if($post->is_extended == 1) me-checked @endif" >
                                    <input id="{{ $price->extended }}" name="{{ App\Constants::KEY_EXTENDED }}" type="checkbox" class="form-control  me-input-checkbox opacity-none">
                            </span>
                        <label class="Iran14 fw-600 mr-1 text-info">تمدید آگهی<span class="mr-5 IranBold17 fw-400">{{ convert($price->extended) }} تومان</span></label>

                    </div>
                </div>
                <div class="form-group card mt-3 px-4 py-4">
                    <label for="" class="text-right IranBold14 fw-400 w-100 float-right">نردبان کردن آگهی</label>
                    <small class="text-right text-muted">با نردبان کردن آگهی خود شما آن را به ابتدای دسته مربوطه منتقل می کنید.این گزینه بعد از انتشار آگهی فعال می گردد</small>
                    <div class="row mr-1 mt-2 @if($post->is_pay == 0) disabled @endif">
                            <span id="span-pay-ladder" class="me-span-checkbox mt-1" >
                                    <input id="{{ $price->ladder }}" name="{{ App\Constants::KEY_LADDER }}" type="checkbox" class="me-input-checkbox form-control opacity-none">
                            </span>
                        <label class="Iran14 fw-600 mr-1 text-info" for="">نردبان آگهی<span class="mr-5 IranBold17 fw-400">{{ convert($price->ladder) }} تومان</span></label>

                    </div>
                </div>
         </div>

        <div class="col-lg-4 mt-4 order-8 px-3 px-md-3">
            <div class="text-right IranBold15 fw-600">
            مبلغ قابل پرداخت
            </div>
      <div class="card mt-3">
          <div class="card-body">
            <div class="w-100 text-center py-3 IranBold15 fw-400">جمع مبلغ قابل پرداخت</div>
              <div class="w-100 text-center text-info IranBold18 fw-400">
                  <span id="total-price"></span>
                  تومان
              </div>

              <button type="submit" id="btn-pay-post" class="btn btn-danger IranBold14 fw-600 mt-3 ml-auto mr-auto text-center w-100">پرداخت با کارت های بانکی</button>
          </div>
      </div>
    </div>

</div>

</form>
