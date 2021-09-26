@extends("layouts.default-no-header")

@section("content")
    <div class="container">
        <div class="row">
        <div class="col">
            <div class="card mt-3">
                <div class="card-header bg-white text-right text-right IranBold15 fw-600 ">

                    @if($status == 100 || $status == 101)
                        <div class="text-success">
                             عملیات پرداخت با موفقیت انجام شد.
                        </div>
                    @else
                        <div class="text-danger">
 عملیات پرداخت ناموفق بود.
                        </div>
                    @endif
                   </div>
                <div class="card-body">
                    <div class="card-title text-right IranBold14 me-post-title-width my-2">
             <span class="me-text-heading-color fw-600">
                        عنوان آگهی:
             </span>
                        <span class="text-muted fw-400">
                                                {{$post->title }}
                       </span>
                    </div>

                    <div class="float-right w-100 my-2">
                        <span class="float-right IranBold13  ml-1">
                            <span class="me-text-heading-color fw-600">
                            مبلغ پرداختی:
                            </span>
                        <span class="text-muted fw-400">

                    @if($status == 100 || $status == 101)
                                {{ $payment->amount }}
                    @else
                                {{ 0 }}
                    @endif
                            تومان
                        </span>
                        </span>
                    </div>
                    <br>
                    <div class="w-100 float-right my-2">
                        <div class="float-right IranBold13 mr-1">
                            <span class="me-text-heading-color fw-600">
                            کد رهگیری:
                            </span>

                            <span class="text-muted fw-400">

                                @if($status == 100 || $status == 101)
                                  {{ $payment->reference_id }}
                               @else
                                {{ 0 }}
                              @endif
                            </span>
                        </div>
                    </div>
                    <div class="w-100 float-right my-2">
                        <div class="float-right IranBold13 mr-1">
                            <span class="me-text-heading-color fw-600">
                           زمان تراکنش:
                            </span>

                            <span class="text-muted fw-400">
                            @if($payment->created_at)
                            {{ $payment->created_at }}
                            @else
                                {{ \Carbon\Carbon::now()}}
                             @endif
                            </span>
                        </div>
                    </div>

                    <div class="card-title text-right IranBold13 my-2">
             <span class="me-text-heading-color fw-600">
                        توضیحات تراکنش:
             </span>
                        <span class="text-muted fw-400">
                                                {{ $message }}
                       </span>
                    </div>

                    {{--href="{{ route("back-to-app",["postId" => $post->id,"status" => $status ]) }}"--}}
                    <div class="w-100 mt-5" style="margin-top: 25px;">
                        <input type="hidden" id="postId" value="{{$post->id}}"/>
                        <input type="hidden" id="status" value= "{{ $status }}"/>
                        <button type="button" onclick="loadChartData()"  class="btn btn-outline-danger px-3 Iran14 fw-600 p-1 text-center">بازگشت به برنامه</button>
                    </div>
                </div>
            </div>
        </div>
        </div>
    </div>
@stop

<script>
    function loadChartData() {
        var postId = document.getElementById("postId").value;
        var status = document.getElementById("status").value;
        var  data = postId +"/"+status;
        Android.get(data);
    }
</script>