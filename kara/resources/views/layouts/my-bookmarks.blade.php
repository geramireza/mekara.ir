@if(count($posts) == 0)
    <div class="col-12 alert alert-info mt-3 text-center w-100 mr-auto ml-auto float-right">شما هنوز هیچ آگهی ای رو نشان نکرده اید</div>
@else
    @foreach($posts as $post)
        @php
            $images = getArrayImages([$post->img1,$post->img2,$post->img3])
        @endphp
        <div class="col-md-8 mr-auto ml-auto border-bottom py-2 justify-content-center d-flex">

    <div class="col-3 col-lg-2 float-right p-0 p-md-1">
        <img class="img-thumbnail rounded me-w-100" src="@if(count($images)) {{$images[0]}} @else {{ asset("assets/img/no-image.png") }} @endif " alt="">
    </div>
    <div class="col-9 col-lg-10 float-right">
        <div class="row my-2">
            <div class="col-lg-6 float-right mt-md-2 mb-2">
                <div class="float-right Iran14 fw-600 text-right">{{ $post->title }}</div>
            </div>
            <div class="col-lg-6 float-right">

                <div class="float-right Iran14 fw-400">
                    <div class="text-right float-right">
                    حقوق:
                    </div>
                    <span class="text-warning fw-600 Iran14 ">
                        @include("layouts.post_fee")
                    </span>
                 </div>
            </div>
        </div>
        <div class="row my-2">
            <div class="col-12 col-lg-6 px-0 px-lg-2 float-right my-2">
                <div class="float-right IranBold13 fw-400  text-info text-right">@if($post->is_expired) {{ getTimeAgo($post->deleted_at)."  منقضی شده" }} @elseif($post->is_delete) {{getTimeAgo($post->deleted_at). " حذف شده" }}
                    @else
                    {{ getTimeAgo($post->published_at)." منتشر شده" }}
                    @endif
                </div>
            </div>
            <div class="col-12 col-lg-6  px-0 px-lg-2 float-right">
                @if($post->is_expired)
                    <a href="{{ route("posts.show",["slug" => $post->slug]) }}" style="margin-right: -30px;" class="btn btn-outline-info float-right Iran14 fw-400 disabled">منقضی شده</a>

                    <form action="{{ route("posts.delete-bookmark")}}" method="POST">
                        {{ csrf_field() }}
                        <input type="hidden" name="postToken" value="{{$post->post_token}}">
                        <button type="submit" class="btn btn-outline-danger float-right IranBold13 fw-400 mr-1 px-2" ><i class="fas fa-trash ml-2"></i>حذف از نشان</button>

                    </form>
                   @elseif($post->is_delete)

                    <a href="{{ route("posts.show",["slug" => $post->slug]) }}" style="margin-right: -30px;" class="btn btn-outline-info float-right Iran14 fw-400 disabled">حذف شده</a>
                    <form action="{{ route("posts.delete-bookmark")}}" method="POST">
                        {{ csrf_field() }}
                        <input type="hidden" name="postToken" value="{{$post->post_token}}">
                        <button type="submit" class="btn btn-outline-danger float-right IranBold13 fw-400 mr-1 px-2" ><i class="fas fa-trash ml-2"></i>حذف از نشان</button>

                    </form>
                @else
                    <a href="{{ route("posts.show",["slug" => $post->slug]) }}" style="margin-right: -30px;" class="btn btn-outline-info float-right Iran14 fw-400">مشاهده آگهی</a>
                    <form action="{{ route("posts.delete-bookmark")}}" method="POST">
                        {{ csrf_field() }}
                        <input type="hidden" name="postToken" value="{{$post->post_token}}">
                        <button type="submit" class="btn btn-outline-danger float-right IranBold13 fw-400 mr-1 px-2" ><i class="fas fa-trash ml-2"></i>حذف از نشان</button>

                    </form>

                @endif
            </div>
        </div>
    </div>
</div>
@endforeach
@endif