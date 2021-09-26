
@php
    $images = getArrayImages([$post->img1,$post->img2,$post->img3]);
    $imagesName = getArrayImageNames([$post->img1,$post->img2,$post->img3]);
@endphp
<div class="row">
    <div class="col-12 mt-4 px-0">
        <div class="card card_parent">
            <div class="card-header py-2 bg-white">
                <a id="{{ $post->post_token }}"
                   class="post_show_title IranBold14 fw-600 text-info text-right float-right mt-2">{{ $post->title }}</a>
                <form method="POST">
                    <input type="hidden" class="me-input-bookmark" value="{{$post->id}}">
                    <button type="button"
                            class="btn me-btn-outline-book me-btn-bookmark IranBold14 fw-400 ml-md-5 @if(!isLogin()) basic @endif  @if($post->bookmark) {{ "me-btn-outline-booked" }}@endif">
                        <i class="fas fa-bookmark ml-1 mt-1"></i>@if($post->bookmark) {{ "نشان شده" }} @else {{ "نشان کردن" }} @endif
                    </button>
                </form>

            </div>

            <div class="card-body px-3 py-0 pt-md-3 overflow-hidden">
                <div class="row">
                    <div class="my-3 col-lg-6 order-lg-first">
                        <div class="col-6 mb-5 float-right text-center">
                            <h3 class="Iran15 fw-400 text-black mb-3">دسته بندی شغل</h3>
                            <h3 class="IranBold14 fw-400 badge badge-secondary">{{ $post->category }}</h3>

                        </div>

                        <div class="col-6 mb-5 float-right text-center">
                            <h3 class="Iran15 text-black w-100 mb-3">میزان حقوق</h3>
                            <h3 class="IranBold14 fw-400 badge badge-secondary ">
                                @include("layouts.post_fee")
                            </h3>
                        </div>
                        <div class="col-6 mb-5 float-right text-center">
                            <h3 class="Iran15 fw-400 text-black w-100 mb-3">موقعیت شغل:</h3>
                            <h3 class="IranBold14 fw-400 badge badge-secondary">{{ $post->city }}</h3>

                        </div>
                        <div class="col-6 mb-5 float-right text-center">
                            <h3 class="Iran15 fw-400 text-black w-100 mb-3">آگهی دهنده:</h3>
                            <h3 class="IranBold14 fw-400 badge badge-secondary">
                                @if($post->post_type == 0)
                                    {{ "کارفرما" }}
                                @elseif($post->post_type == 1)
                                    {{ "جویای کار" }}
                                @endif
                            </h3>

                        </div>
                        <div class="col-12 my-5 float-right" style="z-index: 10;">
                            <div class="Iran14 fw-400 text-right w-100"
                                 style="text-align:justify!important;line-height: 30px;">
                                @if($post->is_emergency > 0)
                                    <span class="text-danger IranBold14 fw-400 ml-1 py-0" style="margin-top: -2px;float: right;">فوری</span>@endif  {!! $post->body !!} </div>
                        </div>

                        <div class="col-12 float-right text-right px-0 px-md-3">
                            <div class="alert alert-warning alert-dismissible fade show pr-3 Iran13 fw-400 me-bg-warnign" role="alert">
                                <div class="w-100"><strong>هشدار:</strong></div>
                                <div>
                                    <div class="w-100 mb-2 mt-1">
                                        1. از پرداخت هرگونه وجه به دلایل مختلف اجتناب کنید. هرگونه درخواست واریز وجه به معنی کلاهبرداری می باشد.
                                    </div>
                                    <div class="w-100">
                                        2. اطمینان از صحت آگهی و اطلاعات مندرج در آن به عهده خود کاربر می باشد و کارا در این  زمینه هیچ گونه مسئولیتی ندارد.
                                    </div>
                                </div>
                                {{--<button type="button" class="close me-z-index-100" style="left: -8px;top:-8px;" data-dismiss="alert" aria-label="Close">--}}
                                    {{--<span aria-hidden="true">&times;</span>--}}
                                {{--</button>--}}
                            </div>
                        </div>
                        <div class="col-12 mb-2 text-right">

                            <button type="button" id="btn-show-phone"
                                    class="btn btn-outline-info text-center  IranBold14 fw-400 me-cursor-pointer">نمایش
                                اطلاعات تماس
                            </button>
                            <div id="div-show-phone" class="w-100 me-display-none float-right mb-3">
                                <div class="col-12 w-100 text-right mt-2 float-right bg-light py-2">
                                    <label class="IranBold14 fw-400 mb-0 w-25 float-right">
                                        <i class="fas fa-phone align-middle Iran18 ml-2 text-secondary float-right"></i>
                                        <span class="d-none d-sm-block">موبایل</span>
                                    </label>
                                    <span class="IranBold15 fw-400 float-right">{{ $post->phone }}</span>
                                </div>
                            </div>
                        </div>
                        @if(isAdmin())
                            <div class="w-100 my-5 text-center">
                                <button class="btn btn-outline-warning pt-0 pb-0 px-1 mb-2">
                                    @if($post->is_enable == 0)
                                        <span class="me-span-text IranBold14 fw-600 text-info ml-2 mt-2 float-right">منتشر بشه</span>
                                    @else
                                        <span class="me-span-text IranBold14 fw-600 text-info ml-2 mt-2 float-right">غیرفعال بشه</span>
                                    @endif
                                    <label class="switch mb-0">
                                        <input class="toggle_button" name="is_enable"
                                               type="checkbox" @if($post->is_enable) {{ "checked" }} @endif>
                                        <span class="slider round text-warning"></span>
                                    </label>
                                </button>
                                <a href="{{ route("admin.posts.edit",["token" => $post->post_token]) }}"
                                   class="btn btn-outline-info IranBold14 fw-400 px-5 fw-600 mb-2"> ویرایش </a>

                                <br><br>
                                @if($post->is_enable == 0)
                                    <a href="{{ route("admin.posts.delete",["token" => $post->post_token])}}"
                                       class="btn btn-outline-danger IranBold14 fw-400 px-4 fw-600 mb-2 w-50">حذف
                                        آگهی</a>
                                @endif

                            </div>
                        @endif

                    </div>

                    <div class="my-3 col-lg-6 order-first d-md-flex justify-content-md-center">
                        <div class="row align-content-start">
                            @if(count($images) > 0)
                                <div class="col-12">
                                    <div id="karaCarousel"
                                         class="carousel slide w-100" data-ride="carousel" data-interval="false">
                                        <div class="carousel-inner">

                                            @foreach($images as $key => $image)
                                                <div class="carousel-item @if($key == 0) {{ "active" }} @endif">
                                                    <img id="{{$key}}" alt="{{ $post->slug }}" src="{{ $image }}" class="d-block w-100 rounded">
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                    @if(count($images) > 1)
                                        <div class="col-12 d-flex justify-content-center mt-3 px-0">
                                            <ul class="float-right list-inline m-2 px-0">
                                                @foreach($imagesName as $key => $name)
                                                    <li class="list-inline-item float-left">
                                                        <a href="#{{$key}}">
                                                            <img data-target="#karaCarousel" alt="{{ $post->slug }}" data-slide-to="{{ $key }}"
                                                                 class=" me-list-carousel-photo @if($key == 0) {{"me-active"}} @endif img-thumbnail rounded"
                                                                 src="{{ URL("storage/images/thumbnail/".$name) }}"
                                                                 alt="">
                                                        </a>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    @endif
                                </div>
                            @else
                                <div class="col-12 d-none d-lg-block text-center me-height-fit-content">
                                    <img src="{{ asset("assets/img/no-image.png")}}" alt="{{ $post->slug }}" class="img-fluid w-100">
                                </div>
                            @endif
                            <div class="col-lg-12 me-height-fit-content mt-5 float-right  d-none d-lg-block">
                                <div class="card w-100 float-right px-3 py-3 me-cursor-pointer"
                                     onclick="copyToClipboard('.share_link')" data-toggle="tooltip"
                                     data-placement="bottom" data-html="true"
                                     title='<span class="IranBold14 fw-400">کپی لینک</spna>'>
                                            <span>
                                                <div class="bg-light p-2 me-border-radious-3 float-right">
                                                <i class="fas fa-share-alt float-right IranBold18 fw-800"></i>
                                                <div class=" float-right mx-2 IranBold14 fw-400">لینک به اشتراک گذاری</div>
                                                </div>
                                                <div class="float-left p-2 IranBold14 fw-400 share_link">{{ App\Constants::BASE_URL.$post->post_token }}</div>
                                            </span>
                                </div>
                            </div>
                            <div class="col-lg-12 me-height-fit-content mt-4 float-right d-none d-lg-block">
                                <div class="w-100 px-4 py-1 bg-light float-right ">
                                    <button type="button"
                                            class="btn float-right text-right text-secondary IranBold13 fw-400 me-cursor-pointer btn-report-post">
                                        <i class="fas fa-flag ml-1"></i>گزارش مشکل آگهی
                                    </button>
                                </div>

                            </div>
                        </div>
                    </div>

                </div>

                <div class="col-lg-12 card mt-5 w-100 float-right px-3 py-3 d-lg-none me-cursor-pointer"
                     onclick="copyToClipboard('.share_link')" data-toggle="tooltip" data-placement="bottom"
                     data-html="true" title='<span class="IranBold14 fw-400">کپی لینک</spna>'>
                                            <span>
                                                <div class="bg-light p-2 me-border-radious-3 float-right">
                                                <i class="fas fa-share-alt float-right IranBold18 fw-800"></i>
                                                <div class=" float-right mx-2 IranBold14 fw-400 bg-light">لینک به اشتراک گذاری</div>
                                                </div>
                                                <div class="float-left p-2 IranBold14 fw-400 share_link">{{ App\Constants::BASE_URL.$post->post_token }}</div>
                                            </span>


                </div>

                <div class="col-12 px-0 w-100 mt-4 py-1  float-right d-lg-none">
                    <button type="button"
                            class="btn float-right text-right text-secondary IranBold13 fw-400 me-cursor-pointer btn-report-post">
                        <i class="fas fa-flag ml-1"></i>گزارش مشکل آگهی
                    </button>
                </div>

            </div>

        </div>
    </div>
</div>

