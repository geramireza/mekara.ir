@extends("layouts.default")

@section("header_styles")
    <link rel="stylesheet" href="{{ asset("assets/css/search-sidebar.css") }}">
    <link rel="stylesheet" href="{{ asset("assets/css/select2.min.css") }}">
    <link rel="stylesheet" href="{{ asset("assets/css/me-select2.css") }}">
    <link rel="stylesheet" href="{{ asset("assets/css/create-and-edit.css") }}">
    <link rel="stylesheet" href="{{ asset("assets/css/ckeditor.css") }}">
@stop
@section("content")
    <div class="container">
        <div class="row">
            <div class="col-md-12 my-3 my-5 ml-auto mr-auto">
                <div class="card">
                    <div class="card-header bg-info">
                        <h3 class="IranBold15 fw-600 text-right text-white mt-1"> ایجاد مقاله جدید</h3>
                    </div>

                    <div class="card-body">
                        <form method="POST" action="{{route("admin.blog.store")}}" enctype="multipart/form-data">
                            {{ csrf_field() }}
                            <div class="form-group">
                                <label class="text-right float-right IranBold14 fw-600 me-text-heading-color" >عنوان مقاله</label>
                                <input type="text" class="Iran14 py-3  form-control @error("title") is-invalid  @enderror " name="title" value="{{ old("title")}}" placeholder="عنوان مقاله...">
                                <small class="text-danger float-right w-100 text-right">{{ $errors->first("title") }}</small>

                            </div>

                            <div class="form-group ">
                                <label class="float-right text-right IranBold14 fw-600 me-text-heading-color">دسته مقاله</label>
                                <select class="me-select2 Iran14 form-control @error("category_id") is-invalid @enderror " name="category_id">
                                    <option value="">انتخاب دسته بندی</option>
                                    @foreach($blogCategories as $category)
                                        <option class="Iran14 fw-400"  @if( old("category_id") == $category->id) {{ "selected" }} @endif value="{{  $category->id }}"
                                        >{{ $category->title }}</option>
                                    @endforeach
                                </select>
                                <small class="text-danger float-right w-100 text-right">{{ $errors->first("category_id") }}</small>

                            </div>

                                <label class="float-right IranBold14 fw-600 me-text-heading-color">توضیحات</label>
                                <div class="form-group mt-5">
                                    <textarea class="form-control input-group" id="body" rows="200" name="body"></textarea>
                                    <small class="text-danger float-right w-100 text-right">{{ $errors->first("body") }}</small>
                                </div>

                            <div class="form-group mt-3">
                                <div class="w-100 float-right mt-3">
                                    <label class="float-right IranBold14 fw-600 me-text-heading-color">تصویر مقاله
                                      </label>
                                </div>
                                <div class="card">
                                    <div class="card-body">
                                        <div class="row d-flex justify-content-center">
                                            <div id="img" class="col my-5">
                                                <div class="picture text-center">
                                                    <img id="img-file" class="img-thumbnail me-radius-50 me-border-strock me-img-width-height" src="{{asset("assets/img/no-image.png")}}" alt="">
                                                    <input id="input-file" type="file" multiple name = "img"class="opacity-none w-100 h-100 position-absolute me-position-absolute-trl-0 me-cursor-pointer">
                                                </div>
                                                <label class="w-100 text-center mt-3 Iran14 fw-400">تصویر مقاله</label>
                                                <small class="text-danger float-right w-100 text-right">{{ $errors->first("img") }}</small>

                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>

                            <div class="form-group mt-5">
                                <button type="submit" class="btn btn-outline-info px-5 IranBold14 fw-600">ارسال</button>
                            </div>

                        </form>
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
    <script type="text/javascript" src="{{ asset("assets/js/search-sidebar.js") }}"></script>
    <script type="text/javascript" src="{{ asset("assets/js/select2.full.min.js") }}"></script>
    <script type="text/javascript" src="{{ asset("assets/js/create-and-edit.js") }}"></script>
    <script type="text/javascript" src="{{ asset("assets/js/image-crop.js") }}"></script>


    <script type="text/javascript" src="{{asset('assets/js/ckeditor/ckeditor.js')}}"></script>
    <script>
        CKEDITOR.replace('body',     {filebrowserImageBrowseUrl: '/file-manager/ckeditor'});
    </script>
@stop

