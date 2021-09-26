@if(count($posts) == 0)
        <div class="col-12 alert alert-info mt-3 text-center w-100 mr-auto ml-auto float-right">شما هنوز هیچ آگهی ای بر روی کارا ندارید</div>
@else
        @foreach($posts as $post)
            @php
            $images = getArrayImages([$post->img1,$post->img2,$post->img3])
            @endphp
            <div class="col-md-8 mr-auto ml-auto border-bottom py-2 justify-content-center d-flex">

                <div class="col-3 col-lg-2 float-right p-0 py-md-1 ">
                    <img class="img-thumbnail rounded me-w-100 " src="@if(count($images)) {{$images[0]}} @else {{ asset("assets/img/no-image.png") }} @endif " alt="">
                </div>
                <div class="col-9 col-lg-10  float-right">
                    <div class="row my-2">
                        <div class="col-lg-6 float-right mt-md-2 mb-2">
                            <div class="float-right Iran14 fw-600 text-right">{{ $post->title }}</div>
                        </div>
                        <div class="col-lg-6 float-right">
                            <div class="float-right Iran14 fw-400">
              <div class="text-right float-right">
                  وضعیت آگهی:
              </div>

                                <span class="text-warning fw-600 Iran14 float-right">
                            @if($post->is_pay == 0)
                                        {{ "در انتظار پرداخت" }}
                            @elseif($post->is_enable == 0)
                                        {{ "در انتظار تایید" }}
                            @else
                                        {{ "در حال نمایش" }}
                            @endif
                                    </span>
                            </div>
                        </div>
                    </div>
                    <div class="row my-lg-2">
                        <div class="col-lg-6 float-right my-2">
                            <div class="float-right IranBold13 fw-400 text-info text-right">@if($post->is_update) {{ getTimeAgo($post->updated_at)." ویرایش شده" }} @elseif($post->is_pay == 0 || $post->is_enable == 0 ) {{getTimeAgo($post->created_at). "      ایجاد شده" }} @else{{getTimeAgo($post->published_at). " منتشر شده" }} @endif</div>
                        </div>
                        <div class="col-lg-6 float-right">
                            <a href="{{ route("manage",["data" => "preview","token" => $post->post_token]) }}" class="btn btn-outline-info float-right Iran14 fw-400">مدیریت آگهی</a>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    @endif