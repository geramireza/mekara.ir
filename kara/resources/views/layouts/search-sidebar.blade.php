    <div class="card" id="search_sidebar">
    <div class="card border-0 me-card-parent me-search-sidebare-slide">
        <div class="card-header me-px-6 bg-white position-relative me-cursor-pointer me-search-sidebare-slide-header">
            <h3 class="mb-0 text-right">
                <i class="fas fa-bars Iran15 me-icon-color-gray"></i>
                <div name="category_id" class="me-div-title-search-sidebar btn  IranBold15 fw-600 pr-0"  >
                    دسته بندی مشاغل
                </div>
            </h3>
            <span class="me-chevron fas fa-chevron-down fa-rotate-180  float-left Iran15 me-icon-color-gray me-icon-chevron-search-sidebar-position"></span>
        </div>
                <div class="card-body me-height overflow-hidden">
                    @isset($params['category_id'])
                    @foreach($params["category_id"] as $key =>$param)
                        <div class="row px-3 me-item-count">
                                <span id="check1" class="me-span-search-checkbox me-span-checkbox me-checked">
                                    <input id="{{$param}}" checked type="checkbox" class="form-control me-input-checkbox ml-1 opacity-none">
                                </span>
                            <label name ="category1" class="IranBold14 fw-400 text-right float-right mr-2 text-secondary" for="">{{ $categories[$param-1]->title }}</label>
                        </div>
                    @endforeach
                    @endisset
                    @foreach($categories as $category)
                        @if((isset($params['category_id']) && !in_array($category->id,$params["category_id"])) || !isset($params['category_id']) )
                        <div class="row px-3 me-item-count">
                                <span id="check1" class="me-span-search-checkbox me-span-checkbox" >
                                    <input id="{{$category->id}}" type="checkbox" class="form-control me-input-checkbox ml-1 opacity-none">
                                </span>
                            <label name ="category1" class="IranBold14 fw-400 text-right float-right mr-2 text-secondary" for="">{{$category->title }}</label>
                        </div>
                        @endif
                    @endforeach
                        <span name ="more" class="search-sidebar-more-item IranBold13 fw-400 bg-white text-info text-right px-4 py-2 me-cursor-pointer me-more-item-position" >+ موارد بیشتر</span>

                </div>
    </div>

    <div class="card border-0 me-card-parent me-search-sidebare-slide">
        <div class="card-header me-px-6 bg-white border-top position-relative me-cursor-pointer me-search-sidebare-slide-header"
        >
            <h3 class="mb-0 text-right">
                <i class="fas fa-map-marker-alt Iran15 me-icon-color-gray"></i>
                <div name="city" class="me-div-title-search-sidebar btn IranBold15 fw-600 pr-0"  >
                    موقعیت مشاغل
                </div>
            </h3>
            <span class="me-chevron fas fa-chevron-down fa-rotate-180 float-left Iran15 me-icon-color-gray me-icon-chevron-search-sidebar-position"></span>
        </div>
            <div class="card-body me-height overflow-hidden ">

                @isset($params['city'])
                @foreach($params['city'] as $key =>$city)
                    <div class="row px-3 me-item-count">
                                <span id="check1" class="me-span-search-checkbox me-span-checkbox me-checked" >
                                    <input id="{{$city}}" checked type="checkbox" class="form-control me-input-checkbox ml-1  opacity-none">
                                </span>
                        <label class="IranBold14 fw-400 text-right float-right mr-2 text-secondary" for="">{{ $city}}</label>
                    </div>
                @endforeach
                @endisset
            @foreach($cities as $city)
                    @if(!isset($params['city']) || (isset($params['city']) && !in_array($city->title,$params['city'])))
                <div class="row px-3 me-item-count">
                                <span id="check1" class="me-span-search-checkbox me-span-checkbox" >
                                    <input id="{{$city->title}}" type="checkbox" class="form-control me-input-checkbox ml-1  opacity-none">
                                </span>
                    <label class="IranBold14 fw-400 text-right float-right mr-2 text-secondary" for="">{{ $city->title }}</label>
                </div>
                    @endif
            @endforeach
                <span  name ="more" class="IranBold13 fw-400 bg-white text-info text-right px-4 py-2 me-cursor-pointer me-more-item-position search-sidebar-more-item" >+ موارد بیشتر</span>
        </div>
    </div>

    <div class="card border-0 me-card-parent me-search-sidebare-slide">
        <div class="card-header me-px-6 bg-white border-top position-relative me-cursor-pointer me-search-sidebare-slide-header">
            <h3 class="mb-0 text-right">
                <i class="fas fa-coins Iran15 me-icon-color-gray"></i>
                <div name="fee" class="me-div-title-search-sidebar btn IranBold15 fw-600 pr-0"  >
                    میزان حقوق
                </div>
            </h3>
            <span class="me-chevron fas fa-chevron-down fa-rotate-180 float-left Iran15 me-icon-color-gray me-icon-chevron-search-sidebar-position"></span>

        </div>
            <div class="card-body collapse show me-max-height">
            <div class="row px-3">
                                <span id="check1" class="me-span-search-checkbox me-span-checkbox
                                @php
                                    if(isset($params["fee"]))
                                    if(in_array(1,$params["fee"]))
                                              echo "me-checked";
                                @endphp

                                        " >
                                    <input id="1"
                                           @php
                                               if(isset($params["fee"]))
                                                if(in_array(1,$params["fee"]))
                                                     echo "checked";

                                           @endphp
                                           type="checkbox" class="form-control me-input-checkbox ml-1 opacity-none">
                                </span>
                <label class="IranBold14 fw-400 text-right float-right mr-2 text-secondary" for=""> از ۰ تا ۱۰۰۰۰۰۰ تومان
                </label>

            </div>

            <div class="row px-3">
                                <span id="check1" class="me-span-search-checkbox me-span-checkbox
                                @php
                                    if(isset($params["fee"]))
                                    if(in_array(2,$params["fee"]))
                                        echo "me-checked";
                                @endphp

                                        " >
                                    <input id="2"
                                           @php
                                               if(isset($params["fee"]))
                                                  if(in_array(2,$params["fee"]))
                                                 echo "checked";

                                           @endphp
                                           type="checkbox" class="form-control me-input-checkbox ml-1 opacity-none">
                                </span>
                <label class="IranBold14 fw-400 text-right float-right mr-2 text-secondary" for=""> از ۱۰۰۰۰۰۰ تا ۳۰۰۰۰۰۰ تومان
                </label>

            </div>

            <div class="row px-3">
                                <span id="check1" class="me-span-search-checkbox me-span-checkbox
                                @php
                                    if(isset($params["fee"]))
                                        if(in_array(3,$params["fee"]))
                                                  echo "me-checked";
                                @endphp

                                        " >
                                    <input id="3"
                                           @php
                                               if(isset($params["fee"]))
                                                   if(in_array(3,$params["fee"]))
                                                  echo "checked";

                                           @endphp
                                           type="checkbox" class="form-control me-input-checkbox ml-1 opacity-none">
                                </span>
                <label class="IranBold14 fw-400 text-right float-right mr-2 text-secondary" for="">بیشتر از ۳۰۰۰۰۰۰ تومان
                </label>

            </div>


        </div>
    </div>

</div>

