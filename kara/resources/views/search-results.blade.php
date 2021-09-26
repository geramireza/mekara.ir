 <div class="card">
        @if(count($posts) == 0)
            <div class="card-header text-success text-right bg-white IranBold14 fw-600">تعداد ۰ آگهی یافت شد</div>
            <i class="fa fa-geram w-100 text-center mt-5 fa-3x text-danger mb-1"></i>
            <p class="text-right IranBold14 fw-400 text-danger text-center w-100 pb-5"> موردی یافت نشد</p>

        @else
            <div class="card-header bg-white py-3">
                <h3 class="text-right Iran16 fw-600 text-success mb-0">
                @yield("search-results-title")
                </h3>
            </div>
            <div class="card-body pt-0">
                <div class="row">
                        @foreach($posts as $post)
                        @php
                            $images = getArrayImages([$post->img1,$post->img2,$post->img3]);
                        @endphp
                            <div class="col-sm-12">
                                <div class="card mt-3">
                                    <a href="{{ route("posts.show",["slug" => $post->slug]) }}">
                                        <div class="card-body float-right w-100">
                                            <div class="col-8 col-md-9 pl-1 pr-0 float-right position-relative">
                                            <span class="card-title text-right @if($post->is_emergency == 1 && url()->current() != route("posts.more",["param" => "emergency"])) text-danger @else me-title-text-color @endif IranBold14 fw-400 float-right w-100 text-truncate">{{ $post->title }}
                                            </span>

                                                            <span class="IranBold13 fw-400 text-muted ml-1 float-right w-100 text-right">
                                                                  <i class="fas fa-money-bill me-text-light-gray"></i>
                                                                @include("layouts.post_fee")
                                                              </span>

                                                <div class="mt-3 IranBold13 fw-400 text-muted float-right w-100 text-right mr-1">

                                                    @if($post->is_emergency > 0)
                                                        <span class="btn btn-outline-danger px-3 Iran14 fw-600 mb-2 align-middle p-1 float-left me-margin-top--6">فوری</span>
                                                    @endif

                                                    <i class="fas fa-map-marker-alt me-text-light-gray"></i>
                                                    {{ getTimeAgo($post->published_at) }}
                                                    <span>در</span>
                                                                 <span class="IranBold13 fw-400 text-warning">
                                                                     {{ $post->city }}
                                                                 </span>


                                                </div>

                                                {{--<div class="mt-3 IranBold13 fw-400 text-muted float-right w-100 text-right w-100">--}}
                                                    {{--<i class="fas fa-eye me-text-light-gray"></i>--}}
                                                    {{--@if($post->view_count >= 1000)--}}
                                                        {{--<span>{{ convert(number_format($post->view_count/1000,1))."K"}}</span>--}}
                                                    {{--@else--}}
                                                        {{--<span>{{ convert($post->view_count)}}</span>--}}
                                                    {{--@endif--}}
                                                    {{--<span>بازدید</span>--}}

                                                    {{--@if($post->is_emergency > 0)--}}
                                                        {{--<span class="btn btn-outline-danger px-3 Iran14 fw-600 mb-2 align-middle p-1 float-left me-margin-top--6">فوری</span>--}}
                                                    {{--@endif--}}

                                                {{--</div>--}}


                                                <div>

                                                </div>
                                            </div>
                                            <div class="col-4 col-md-3 px-0 float-left">

                                                @if (count($images) > 0)
                                                    <img src="{{$images[0]}}" alt="{{ $post->slug }}"
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

                    @endif

                </div>

            </div>

    </div>
