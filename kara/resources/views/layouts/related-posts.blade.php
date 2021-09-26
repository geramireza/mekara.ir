<div class="row">
    <div class="col-12">
        <div class="card mt-3">
            <div class="card-header text-right bg-white IranBold14 fw-600 text-info">
                آگهی های مشابه
            </div>
            <div class="card-body">
                <div class="row">
                    @foreach($relatedPosts as $post)
                        @php
                            $images = getArrayImages([$post->img1,$post->img2,$post->img3]);
                        @endphp

                        <div class="col-12 col-lg-6">
                            <div class="card mt-3">
                                <a href="{{ route("posts.show",["slug" => $post->slug]) }}">
                                <div class="card-body">
                                    <div class="col-8 col-md-9 pl-1 pr-0 float-right position-relative">

                                        <span class="card-title text-right @if($post->is_emergency == 1 && url()->current() == route("search")) text-danger @else me-title-text-color @endif IranBold14 fw-400 float-right w-100 text-truncate">{{ $post->title }}
                                        </span>
                                        <span class="IranBold13 fw-400 text-muted ml-1 float-right w-100 text-right">
                                            <i class="fas fa-money-bill me-text-light-gray"></i>
                                            @include("layouts.post_fee")
                                        </span>

                                        <div class="mt-3 IranBold13 fw-400 text-muted float-right w-100 text-right mr-1 pb-4">
                                            @if($post->is_emergency > 0)
                                                <span class="btn btn-outline-danger px-3 Iran14 fw-600 align-middle p-1 me-margin-top--6 float-left">فوری</span>
                                            @endif

                                            <i class="fas fa-map-marker-alt me-text-light-gray"></i>
                                            {{ getTimeAgo($post->published_at) }}
                                            <span>در</span>
                                                                 <span class="IranBold13 fw-400 text-warning">
                                                                     {{ $post->city }}
                                                                 </span>
                                        </div>
                                        {{--<div class="mt-3 IranBold13 fw-400 text-muted float-right w-100 text-right mb-2">--}}
                                            {{--<i class="fas fa-eye me-text-light-gray"></i>--}}
                                            {{--@if($post->view_count >= 1000)--}}
                                                {{--<span>{{ convert(number_format($post->view_count/1000,1))."K"}}</span>--}}
                                            {{--@else--}}
                                                {{--<span>{{ convert($post->view_count)}}</span>--}}
                                            {{--@endif--}}
                                            {{--<span>بازدید</span>--}}


                                            {{--@if($post->is_emergency > 0)--}}
                                                {{--<span class="btn btn-outline-danger px-3 Iran14 fw-600 align-middle p-1 me-margin-top--6 float-left">فوری</span>--}}
                                            {{--@endif--}}
                                        {{--</div>--}}
                                        <div>
                                        </div>
                                    </div>
                                    <div class="col-4 col-md-3 px-0 float-left">

                                        @if (count($images) > 0)
                                            <img src="{{ $images[0] }}" alt="{{ $post->slug }}"
                                                 class="w-75 rounded me-min-width-height-80" alt="">
                                        @else
                                            <img src="{{ asset("/assets/img/no-image.png") }}" alt="{{ $post->slug }}"
                                                 class="w-75 rounded c-border-radius" alt="">
                                        @endif
                                    </div>
                                </div>
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>

            </div>
        </div>
    </div>
</div>