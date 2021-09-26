@extends("layouts.default")

@section("header_styles")
    <link rel="stylesheet" href="{{ asset("assets/css/search-sidebar.css") }}">
    <link rel="stylesheet" href="{{ asset("assets/css/select2.min.css") }}">
    <link rel="stylesheet" href="{{ asset("assets/css/me-select2.css") }}">
    <link rel="stylesheet" href="{{ asset("assets/css/create-and-edit.css") }}">
@stop
@section("content")
    <div class="container">
        <div class="row">
            <div class="col-md-12 my-3 my-md-5 ml-auto mr-auto">
            <div class="card">
                    <div class="card-header bg-info">
                        <h3 class="IranBold15 fw-600 text-right text-white mt-1"> ایجاد آگهی جدید</h3>
                    </div>

                    <div class="card-body">
                        <form method="POST" action="{{route("posts.store")}}" enctype="multipart/form-data">
                            {{ csrf_field() }}
                            <div class="form-group">
                                <label class="text-right float-right IranBold14 fw-600 me-text-heading-color" >عنوان آگهی</label>
                                <input type="text" class="Iran14 py-3  form-control @error("title") is-invalid  @enderror " name="title" value="{{ old("title")}}" placeholder="عنوان آگهی...">
                                <small class="text-danger float-right w-100 text-right">{{ $errors->first("title") }}</small>

                            </div>

                            <div class="form-group">
                                <div id= "fee_radio" class="w-100 float-right me-parent-radio">
                                    <label class="text-right float-right w-100 IranBold14 fw-600 me-text-heading-color">میزان حقوق</label>
                                    <br>
                                <span id="create_check1" class="me-span-radio me-radio-fee @if(old("fee_type") == 0 || old("fee_type") == null) me-checked @endif">
                                    <input id="0" type="radio" name="fee_type" value="0" class="form-control ml-1 me-input-radio opacity-none"  @if(old("fee_type") == 0 && old("fee_type") != null) checked @endif checked>
                                    </span>
                                    <label class="Iran14 fw-600 text-right float-right mr-1 ml-4 text-secondary" for="">توافقی</label>

                                        <span id="create_check2" class="me-span-radio me-radio-fee @if(old("fee_type") == 1) me-checked @endif">
                                        <input id="1" type="radio" name="fee_type" value="1" class="form-control ml-1 me-input-radio opacity-none"  @if(old("fee_type") == 1) checked @endif>
                                    </span>
                                    <label class="Iran14 fw-600 text-right float-right mr-1 ml-4 text-secondary" for="">روزانه</label>

                                    <span id="create_check3" class="me-span-radio me-radio-fee @if(old("fee_type") == 2) me-checked @endif">
                                        <input id="2" type="radio" name="fee_type" value="2"  @if(old("fee_type") == 2) checked @endif class="form-control ml-1 me-input-radio opacity-none">
                                    </span>
                                    <label class="Iran14 fw-600 text-right float-right mr-1 ml-4 text-secondary">ماهیانه</label>

                                </div>

                                <div class="w-100 @if(old("fee_type") == 0) me-display-none @endif" id="me_fee_input">
                                    <input type="text" name="fee_value" class="Iran14 py-3 form-control @error("fee_value") is-invalid @enderror"  placeholder="میزان حقوق به تومان " value="{{ old("fee_value") }}">
                                    <small class="text-danger float-right w-100 text-right w-100 text-right">{{ $errors->first("fee_value") }}</small>

                                </div>

                            </div>
                            <div class="form-group ">
                                <label class="float-right text-right IranBold14 fw-600 me-text-heading-color">دسته آگهی</label>
                                <select class="me-select2 Iran14 form-control @error("category_id") is-invalid @enderror " name="category_id">
                                    <option value="">انتخاب دسته بندی</option>
                                    @foreach($categories as $category)
                                        <option class="Iran14 fw-400"  @if( old("category_id") == $category->id) {{ "selected" }} @endif value="{{  $category->id }}"
                                        >{{ $category->title }}</option>
                                    @endforeach
                                </select>
                                <small class="text-danger float-right w-100 text-right">{{ $errors->first("category_id") }}</small>

                            </div>
                            <div class="form-group">
                                <label class="float-right text-right IranBold14 fw-600 me-text-heading-color">موقعیت آگهی</label>
                                <select type="text" class="me-select2 form-control @error("city") is-invalid @enderror"  name="city">
                                    <option value="">انتخاب شهر</option>
                                    @foreach($cities as $city)
                                        <option class="Iran14 fw-400" @if(old("city") == $city->title) {{ "selected" }} @endif value="{{ $city->title }}">{{ $city->title }}</option>
                                    @endforeach
                                </select>
                                <small class="text-danger float-right w-100 text-right">{{ $errors->first("city") }}</small>

                            </div>

                            <div class="form-group">

                                <div class="float-right w-100 me-parent-radio">
                                <label class="text-right w-100 IranBold14 fw-600 me-text-heading-color">آگهی دهنده</label>
                              <div>
                                <span class="me-span-radio @if( old("post_type") == 0) {{ "me-checked" }} @endif" >
                                <input type="radio" name="post_type" class="form-control ml-1 me-input-radio opacity-none" value="0" @if( old("post_type") == 0) {{ "checked" }} @endif>
                                </span>
                                  <label class="Iran14 fw-600 float-right mr-1 ml-4 text-secondary">کارفرما</label>
                              </div>
                              <div>
                                  <span class="me-span-radio @if( old("post_type") == 1) {{ "me-checked" }} @endif">
                                <input type="radio" name="post_type" class="form-control ml-1 me-input-radio opacity-none" value="1" @if( old("post_type") == 1) {{ "checked" }} @endif>
                                </span>
                                   <label class="Iran14 fw-600 text-right float-right mr-1 ml-4 text-secondary">جویای
                                       کار</label>
                              </div>
                                    <small class="text-danger float-right w-100 text-right">{{ $errors->first("post_type") }}</small>

                                </div>
                            </div>

                            <div class="form-group mt-5">
                                <label class="float-right IranBold14 fw-600 me-text-heading-color">توضیحات</label>
                                <textarea type="text" rows="7" class="form-control @error("body") is-invalid @enderror" id="body" name="body">{{ old("body") }}</textarea>
                                <small class="text-danger float-right w-100 text-right">{{ $errors->first("body") }}</small>
                            </div>

                            <div class="form-group">
                                    <label class="float-right IranBold14 fw-600 me-text-heading-color">موبایل</label>
                                    <input type="text" class="form-control @error("phone") is-invalid @enderror" name="phone" placeholder="09100000000" value="{{ old("phone") }}">
                                    <small class="text-danger float-right w-100 text-right">{{ $errors->first("phone") }}</small>

                            </div>
                            <div class="form-group mt-3">
                                <div class="w-100 float-right mt-3">
                                    <label class="float-right IranBold14 fw-600 me-text-heading-color">تصاویر
                                        <span class="badge text-danger ">(اختیاری)</span>
                                    </label>
                                </div>
                                <div class="card">
                                    <div class="card-body">
                                        <div class="row">
                                            <small class="float-right text-right">انتخاب تصویر مناسب سبب دیده شدن بیشتر آگهی شما می شود</small>
                                        </div>
                                        <div class="row d-flex justify-content-center">
                                            <div id="img1" class="col-12 col-md-3 my-5">

                                                <div class="picture text-center">
                                                    <img id="img1-file" class="img-thumbnail me-radius-50 me-border-strock me-img-width-height" src="{{asset("assets/img/no-image.png")}}" alt="">
                                                    <input id="input1-file" type="file" multiple name = "img[img1]"class="opacity-none w-100 h-100 position-absolute me-position-absolute-trl-0 me-cursor-pointer">
                                                </div>
                                                <label class="w-100 text-center mt-3 Iran14 fw-400">تصویر اول (تصویر اصلی)</label>
                                                <small class="text-danger float-right w-100 text-right">{{ $errors->first("img.img1") }}</small>

                                            </div>
                                            <div id="img2" class="col-12 col-md-3 my-5">
                                                <div class="picture text-center">
                                                    <img  id="img2-file" class="img-thumbnail me-radius-50 me-border-strock me-img-width-height"  src="
                                                    {{ asset("assets/img/no-image.png") }}" alt="">
                                                    <input id="input2-file" multiple name="img[img2]" type="file" class="opacity-none w-100 h-100 position-absolute me-position-absolute-trl-0 me-cursor-pointer ">

                                                </div>
                                                <label class="w-100 text-center mt-3 Iran14 fw-400">تصویر دوم</label>
                                                <small class="text-danger float-right w-100 text-right">{{ $errors->first("img.img2") }}</small>

                                            </div>
                                            <div id="img3" class="col-12 col-md-3 my-5">

                                                <div class="picture text-center">
                                                    <img id="img3-file" class="img-thumbnail me-radius-50 me-border-strock me-img-width-height"  src="
                                                    {{  asset("assets/img/no-image.png") }}" alt="">
                                                    <input id="input3-file" multiple type="file" name="img[img3]" class="opacity-none w-100 h-100
                                                        position-absolute me-position-absolute-trl-0 me-cursor-pointer ">

                                                </div>
                                                <label class="w-100 text-center mt-3 Iran14 fw-400">تصویر سوم</label>
                                                <small class="text-danger float-right w-100 text-right">{{ $errors->first("img.img3") }}</small>

                                            </div>
                                        </div>

                                    </div>
                                   </div>
                            </div>
                            <div class="form-group mt-5">
                                <button type="submit" class="btn btn-outline-info px-5 IranBold14 fw-600">انتشار آگهی</button>
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
@stop

