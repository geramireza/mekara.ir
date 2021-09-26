
<div class="col-lg-3 my-3 px-md-0 pl-lg-3 pr-lg-0">
    <div class="card h-100" style="max-height: 600px;">
        <div class="card-header bg-white py-3">
            <a href="{{ route("admin.create") }}" class="align-bottom IranBold14 fw-600 text-right float-right text-info">ایجاد آگهی جدید توسط ادمین</a>
        </div>
        <div class="card-body">
            <ul class="list-inline text-right pr-0">

                <li class="my-3">
                    <a href="{{ route("admin.dashbord") }}" class="text-right text-secondary IranBold15 fw-400  @if(url()->current() == route("admin.dashbord"))  {{ "text-info" }} @endif ">داشبورد</a>
                </li>

                <li class="my-3">
                    <a href="{{route("admin.confirmed")}}" class="text-secondary text-right  IranBold15 fw-400 @if(url()->current() == route("admin.confirmed"))   {{ "text-info" }} @endif ">آگهی های تایید شده</a>
                </li>

                <li class="my-3">
                    <a href="{{ route("admin.not-confirmed") }}" class="text-secondary text-right  IranBold15 fw-400 @if(url()->current() == route("admin.not-confirmed"))   {{ "text-info" }} @endif " >آگهی های در انتظار تایید</a>
                    @if($countNotConfirmed)
                        <span class="badge badge-warning text-white fa-1x badge-pill IranBold14 fw-400">{{ $countNotConfirmed }}</span>
                    @endif
                </li>

                <li class="my-3">
                    <a href="{{ route("admin.edited") }}" class="text-secondary text-right  IranBold15 fw-400 @if(url()->current() == route("admin.edited"))   {{ "text-info" }} @endif " >آگهی های ویرایش شده</a>
                    @if($countEdited)
                        <span class="badge badge-warning text-white fa-1x badge-pill IranBold14 fw-400">{{ $countEdited }}</span>
                    @endif
                </li>

                {{--<li class="my-3">--}}
                    {{--<a href="{{ route("admin.blog") }}" class="text-secondary text-right  IranBold15 fw-400 @if(url()->current() == route("admin.blog"))   {{ "text-info" }} @endif " >ایجاد مقاله جدید</a>--}}
                {{--</li>--}}

                <li class="my-3">
                    <a href="{{route("admin.posts-reports")}}" class="text-secondary text-right  IranBold15 fw-400 @if(url()->current() == route("admin.posts-reports"))   {{ "text-info" }} @endif ">گزارش مشکل آگهی</a>
                    @if($countReportNotSeen)
                    <span class="badge badge-warning text-white fa-1x badge-pill IranBold14 fw-400">{{ $countReportNotSeen }}</span>
                    @endif
                </li>
                <li class="my-3">
                    <a href="{{route("admin.contacts-reports")}}" class="text-secondary text-right  IranBold15 fw-400 @if(url()->current() == route("admin.contacts-reports"))   {{ "text-info" }} @endif ">گزارش تماس با ما</a>
                    @if($countContactNotSeen)
                    <span class="badge badge-warning text-white fa-1x badge-pill IranBold14 fw-400">{{ $countContactNotSeen }}</span>
                    @endif
                </li>

            </ul>
        </div>
    </div>
</div>
