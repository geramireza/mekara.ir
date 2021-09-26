@extends("layouts.default")


@section("header_styles")
    <link rel="stylesheet" href="{{ asset("assets/css/select2.min.css") }}">
    <link rel="stylesheet" href="{{ asset("assets/css/create-and-edit.css") }}">
@stop
@section("content")
    <div class="container">
        <div class="row">
            <div class="col-md-10 mt-4 ml-auto mr-auto">
                <div class="card card_parent">
                    <div class="card-header text-right bg-info text-white IranBold15 fw-600">
                        ویرایش آگهی
                    </div>
                    <div class="card-body px-4">
                        <form enctype="multipart/form-data" id="{{$post->id}}"   method="POST" action="{{route("admin.posts.update",["post_token" => $post->post_token])}}">
                            <input type="hidden" name="_method" value="PUT">
                            {{ csrf_field() }}
                            <div class="form-group">
                                <label class="text-right float-right IranBold14 fw-600" >عنوان آگهی</label>
                                <input type="text" class="form-control Iran14 py-3 @error("title") is-invalid  @enderror " id="title" name="title" value="{{ $post->title }}">
                                <small class="text-danger float-right w-100 text-right">{{ $errors->first("title") }}</small>

                            </div>
                            <div class="form-group">
                                <div id= "fee_radio" class="w-100 float-right me-parent-radio">
                                    <label class="text-right float-right w-100 IranBold14 fw-600">میزان حقوق</label>
                                    <br>
                                    <span id="create_check1" class="me-span-radio me-radio-fee @if(old("fee_type",$post->fee_type) == 0) me-checked @endif">
                                    <input id="0" type="radio" name="fee_type" value="0" class="form-control me-input-radio opacity-none" @if(old("fee_type",$post->fee_type) == 0) checked @endif>
                                    </span>
                                    <label class="Iran14 fw-600 text-right float-right mr-1 ml-4 text-secondary" for="">توافقی</label>


                                <span id="create_check2" class="me-span-radio me-radio-fee @if( old("fee_type",$post->fee_type) == 1) me-checked @endif">
                                        <input id="1" type="radio" name="fee_type" value="1" class="form-control me-input-radio opacity-none"  @if(old("fee_type",$post->fee_type) == 1) checked @endif>
                                    </span>
                                    <label class="Iran14 fw-600 text-right float-right mr-1 ml-4 text-secondary" for="">روزانه</label>


                                    <span id="create_check3" class="me-span-radio  me-radio-fee @if( old("fee_type",$post->fee_type) == 2) me-checked @endif">
                                        <input id="2" type="radio" name="fee_type" value="2"  @if( old("fee_type",$post->fee_type) == 2) checked @endif class="form-control me-input-radio opacity-none">
                                    </span>
                                    <label class="Iran14 fw-600 text-right float-right mr-1 ml-4 text-secondary">ماهیانه</label>
                                </div>

                                <div class="w-100 @if(old("fee_type",$post->fee_type) == 0) me-display-none @endif" id="me_fee_input">
                                    <input type="text" name="fee_value" class="Iran14 py-3 form-control"  placeholder="میزان حقوق ماهیانه" value="@if(old("fee_type",$post->fee_type) != 0) {{ $post->fee }} @endif">
                                    <small class="text-danger float-right w-100 text-right w-100 text-right">{{ $errors->first("fee_value") }}</small>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputAddress" class="float-right text-right IranBold14 fw-600">دسته آگهی</label>
                                <select type="text" class="me-select2 form-control" id="category_id" name="category_id">
                                    @foreach($categories as $category)
                                        <option class="Iran14 fw-400" value="{{ $category->id }}"
                                        @if($category->id == old("category_id",$post->category_id))
                                            {{ "selected" }}
                                                @endif
                                        >{{ $category->title }}</option>
                                    @endforeach
                                </select>
                                <small class="text-danger float-right w-100 text-right">{{ $errors->first("category_id") }}</small>

                            </div>
                            <div class="form-group">
                                <label for="inputAddress" class="float-right text-right IranBold14 fw-600">موقعیت آگهی</label>
                                <select type="text" class="me-select2 form-control"  name="city" id="city">
                                    @foreach($cities as $city)
                                        <option class="Iran14 fw-400" value="{{ $city->title }}"
                                        @if($city->title == old("city",$post->city))
                                            {{ "selected" }}
                                                @endif
                                        >{{ $city->title }}</option>
                                    @endforeach
                                </select>
                                <small class="text-danger float-right w-100 text-right">{{ $errors->first("city") }}</small>

                            </div>

                            <div class="form-group">
                                <div class="float-right w-100 me-parent-radio">
                                    <label class="text-right w-100 IranBold14 fw-600 me-text-heading-color">آگهی دهنده</label>
                                    <div>
                                <span class="me-span-radio @if( $post->post_type == 0) {{ "me-checked" }} @endif" >
                                <input type="radio" name="post_type" class="form-control ml-1 me-input-radio opacity-none" value="0" @if( $post->post_type == 0) {{ "checked" }} @endif>
                                </span>
                                        <label class="Iran14 fw-600 float-right mr-1 ml-4 text-secondary">کارفرما</label>
                                    </div>
                                    <div>
                                  <span class="me-span-radio @if($post->post_type == 1) {{ "me-checked" }} @endif">
                                <input type="radio" name="post_type" class="form-control ml-1 me-input-radio opacity-none" value="1" @if($post->post_type == 1) {{ "checked" }} @endif>
                                </span>
                                        <label class="Iran14 fw-600 text-right float-right mr-1 ml-4 text-secondary">جویای
                                            کار</label>
                                    </div>
                                    <small class="text-danger float-right w-100 text-right">{{ $errors->first("post_type") }}</small>
                                </div>
                            </div>

                            <div class="form-group mt-5">
                                <label for="inputAddress2" class="float-right IranBold14 fw-600">توضیحات</label>
                                <textarea type="text" rows="7" class="form-control Iran15 fw-400  @error("body") is-invalid @enderror" id="body" name="body">{{ old("body",$post->body) }}</textarea>
                            </div>

                            <div class="form-group">
                                <label class="float-right IranBold14 fw-600">موبایل</label>
                                <input type="text" class="form-control @error("phone") is-invalid @enderror" name="phone" placeholder="09123456789" value="{{ old("phone",$post->phone) }}">
                                <small class="text-danger float-right w-100 text-right">{{ $errors->first("phone") }}</small>
                            </div>

                            <div class="form-group">
                                <span id="check1" class="me-span-checkbox ml-2 @if($post->is_emergency > 0) me-checked @endif" >
                                    <input name="emergency" type="checkbox" class="form-control me-input-checkbox ml-1 opacity-none" @if($post->is_emergency > 0) checked @endif>
                                </span>
                                <label class="float-right IranBold14 fw-600 me-text-heading-color">برچسب فوری</label>
                                <small class="text-danger float-right w-100 text-right">{{ $errors->first("emergency") }}</small>
                            </div>


                            <div class="form-group mt-3  me-form-group">
                                <div class="w-100 float-right mt-md-3">
                                    <label class="float-right IranBold14 fw-600">تصاویر
                                        <span class="badge text-danger pr-0">(اختیاری)</span>
                                    </label>
                                </div>
                                <div class="card">
                                    <div class="card-body">
                                        <div class="row">
                                            <small class="float-right text-right">انتخاب تصویر مناسب سبب دیده شدن بیشتر آگهی شما می شود</small>
                                        </div>
                                        <div class="row d-flex justify-content-center">
                                            <div id="img1" class="col-12 col-md-3 my-5 text-center me-col-img">
                                                    <div class="picture text-center">
                                                    <img id="img1-file" class="img-thumbnail me-radius-50 me-border-strock me-img-width-height" src="
                                                    @if($post->img1 != null) {{$post->img1}} @else {{ asset("assets/img/no-image.png") }} @endif" alt="">

                                                        <input id="input1-file" multiple type="file" name="img[img1]" class="opacity-none w-100 h-100
                                                        position-absolute me-position-absolute-trl-0 me-cursor-pointer ">

                                                        <button id="img1" class="close me-btn-delete text-danger" type="button" style="position: absolute;top:0;right:10px;">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>

                                                    </div>
                                                <button type="button" class="btn btn-outline-info w-100 text-center mt-3 Iran14 me-font-Iran13 fw-400 ">ویرایش </button>
                                                <small class="text-danger float-right w-100 text-right">{{ $errors->first("img.img1") }}</small>


                                            </div>
                                            <div id="img2" class="col-12 col-md-3 my-5 text-center me-col-img">
                                                <div class="picture text-center">
                                                    <img  id="img2-file" class="img-thumbnail me-radius-50 me-border-strock me-img-width-height" src="
                                                     @if($post->img2 != null)  {{ $post->img2 }} @else {{ asset("assets/img/no-image.png") }} @endif" alt="">
                                                    <input id="input2-file" multiple type="file" name="img[img2]" class="opacity-none w-100 h-100
                                                        position-absolute me-position-absolute-trl-0 me-cursor-pointer ">

                                                    <button id="img2" class="close me-btn-delete text-danger" type="button" style="position: absolute;top:0;right:10px;">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>

                                                <button type="button" class="btn btn-outline-info w-100 text-center mt-3 Iran14 me-font-Iran13 fw-400 ">ویرایش </button>
                                                <small class="text-danger float-right w-100 text-right">{{ $errors->first("img.img2") }}</small>


                                            </div>
                                            <div id="img3" class="col-12 col-md-3 my-5 text-center me-col-img">
                                                <div class="picture text-center">
                                                    <img id="img3-file" class="img-thumbnail me-radius-50 me-border-strock me-img-width-height"  src="
                                                     @if($post->img3 != null) {{  $post->img3 }} @else {{ asset("assets/img/no-image.png") }} @endif" alt="">
                                                    <input id="input3-file" multiple type="file" name="img[img3]" class="opacity-none w-100 h-100
                                                        position-absolute me-position-absolute-trl-0 me-cursor-pointer ">

                                                    <button id="img3" class="close me-btn-delete text-danger" type="button" style="position: absolute;top:0;right:10px;">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>

                                                </div>

                                                <button type="button" class="btn btn-outline-info w-100 text-center mt-3 Iran14 me-font-Iran13 fw-400 ">ویرایش </button>
                                                <small class="text-danger float-right w-100 text-right">{{ $errors->first("img.img3") }}</small>


                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>

                            <div class="form-group mt-5">
                                <button type="submit" class="btn btn-info IranBold14 fw-400 px-4 mt-2">ثبت تغییرات</button>
                            </div>

                        </form>

                    </div>

                </div>
            </div>
        </div>
    </div>
@stop


@section("footer")
    @include("layouts.footer")
@stop
@section("footer_scripts")
    <script type="text/javascript" src="{{ asset("assets/js/select2.full.min.js") }}"></script>
    <script type="text/javascript" src="{{ asset("assets/js/create-and-edit.js") }}"></script>
    <script>
        $(".me-btn-delete").click(function () {
            var img = $(this).attr("id");
            var postId = $("form").attr("id");
            var path = $(this);
            $.ajax({
                type : "post",
                url : "/admin/delete-img-post",
                dataType : "json",
                data : {img:img,postId:postId},
                headers :
                {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success : function (data) {
                    if(data)
                    {
                        $(path).parents(".me-col-img").remove();
                        var count = $(".me-col-img").length;
                        if( count == 0)
                                $(".me-form-group").remove();
                    }
                }
            })
        })
    </script>
@stop