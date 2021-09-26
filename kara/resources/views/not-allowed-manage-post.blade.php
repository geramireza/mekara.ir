@extends("layouts.default")

@section("content")

    <div class="container">
        <div class="row">
            <div class="col-12 my-5">
                <div class="alert alert-danger text-center">دسترسی شما برای مدیریت این آگهی مجاز نیست</div>

                <div class="col-6 mr-auto ml-auto justify-content-center d-flex my-5">
                    <a href="{{ route("myKara",["param" => "my-posts"]) }}" class="btn btn-outline-info">بازگشت به حساب کاربری خود</a>
                </div>
            </div>
        </div>
    </div>

@endsection
