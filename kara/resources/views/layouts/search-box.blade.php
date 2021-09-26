<div class="row">
    <div class="col-12">
        <div  id="search_box" class="card mt-3 mt-md-5 p-3 me-bg-overlay-search-box border-0">
        <div class="card-body float-right p-0">
            <form action="{{ route("reSearch") }}" method="GET">
                <div class="form-row py-2">

                    <div class="col-md-12 col-lg-10">
                        <div class="row">
                            <div class="col-md-4 mb-3 mb-md-0 pl-md-0">
                                <input type="text" class="form-control text-secondary Iran14 fw-400 position-relative pr-4 me-search-box-input-height" name="txtSearch" placeholder="عنوان شغل و ..." value="@if(isset($txtSearch) || isset($array_data["txtSearch"])){{ $txtSearch }}@endif">
                                <i class="fas fa-search me-icon-color-gray me-icon-search-position"></i>

                                </input>
                            </div>
                            <div class="col-md-4 mb-3 mb-md-0 pl-md-0">

                      <div id="me-category-select2-container" class="bg-white position-relative  me-search-box-input-height me-border-radious-3">
                          <i class="fas fa-bars me-icon-color-gray position-absolute me-icon-position"></i>
                          <select type="text" class="me-select2 form-control text-secondary IranBold14 fw-400" id="category_id" name="category_id">
                              <option class="text-right float-right" value="">همه دسته بندی ها</option>
                              @foreach($categories as $category)
                                  <option class="Iran14 fw-400"
                                          @isset($category_id)
                                          @if($category_id == $category->id ) {{ "selected" }} @endif
                                          @endisset
                                          @isset($array_data["category_id"])
                                          @if($array_data["category_id"] == $category->id ) {{ "selected" }} @endif
                                          @endisset
                                          value="{{ $category->id }}"
                                  >{{ $category->title }}</option>
                              @endforeach
                          </select>

                          <i class="me-chevron fas fa-chevron-down me-icon-color-gray me-icon-chevron-position"></i>

                  </div>

                            </div>

                            <div class="col-md-4 mb-3 mb-md-0">
                                <div id="me-city-select2-container" class="bg-white position-relative me-search-box-input-height me-border-radious-3">
                                    <i class="fas fa-bars me-icon-color-gray me-icon-position"></i>
                                    <select type="text" class="me-select2 form-control text-secondary IranBold14 fw-400" id="city" name="city" >
                                        <option class="text-right float-right" value="">همه شهرها</option>
                                        @foreach($cities as $city)
                                            <option class="Iran14 fw-400" value="{{ $city->title }}"
                                            @isset($city_item)
                                            @if($city_item == $city->title) {{ "selected" }} @endif
                                            @endisset
                                            @isset($array_data['city'])
                                            @if($array_data['city'] == $city->title ) {{ "selected" }} @endif
                                             @endisset
                                            >{{ $city->title }}</option>
                                        @endforeach
                                    </select>
                                    <i class="me-chevron fas fa-chevron-down me-icon-color-gray me-icon-chevron-position"></i>

                                </div>
                            </div>
                        </div>
                        </div>
                    <div class="col-md-12 mt-md-3 col-lg-2 mt-lg-0">
                        <div class="row">
                            <div class="col-12">
                                <button type="submit" class="form-control btn btn-info text-white IranBold16 fw-400 me-search-box-input-height">جستجو</button>
                            </div>
                        </div>
                    </div>

                </div>


            </form>
        </div>
    </div>
    </div>
</div>
