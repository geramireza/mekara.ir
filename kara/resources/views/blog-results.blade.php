@extends("layouts.default")

@section("content")
    <div class="container">
        <div class="row">
            <div class="col">
                <div class="card">
                    @if(count($blogs) == 0)
                        <div class="card-header text-success text-right bg-white IranBold14 fw-600">تعداد ۰ مقاله یافت شد</div>
                        <div class="card-body">
                            <i class="fa fa-geram w-100 text-center mt-5 fa-3x text-danger mb-1"></i>
                            <p class="text-right IranBold14 fw-400 text-danger text-center w-100 pb-5"> موردی یافت نشد</p>
                        </div>
                    @else
                        <div class="card-body pt-0">
                            <div class="row">
                                @foreach($blogs as $blog)
                                    <div class="col-sm-12">
                                        <div class="card mt-3">
                                            <a href="{{ route("blogs.show",["slug" => $blog->slug]) }}">
                                                <div class="card-body float-right w-100">
                                                    <div class="col-8 col-md-9 pl-1 pr-0 float-right position-relative">
                                            <span class="card-title text-right @if($blog->is_emergency == 1 && url()->current() != route("posts.more",["param" => "emergency"])) text-danger @else me-title-text-color @endif IranBold14 fw-400 float-right w-100 text-truncate">{{ $blog->title }}
                                            </span>
                                                        <div>

                                                        </div>
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
            </div>
        </div>
    </div>
@stop
