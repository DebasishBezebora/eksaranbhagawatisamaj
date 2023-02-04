<section class="carousel slide testimonials-slider features4 medicalm4_features4 cid-tulM8GfMss" data-interval="false" id="features4-1e">
    <div class="container text-center"></div>
    <div class="carousel slide container" role="listbox" data-pause="true" data-keyboard="false" data-ride="carousel" data-interval="3000">
        <div class="carousel-inner">
            @php
                $pic = explode(",", $photos->Photos);
                $pic_count = count($pic);
                $items = 3;
                $pic_arr_divided_three = round($pic_count/$items);
                $arr_start = 0;
                $arr_end = 0;
            @endphp

            @for($i=1;$i<=$pic_arr_divided_three;$i++)
                @php
                    $arr_end = $i*$items;
                @endphp
                <div class="carousel-item">
                    <div class="row justify-content-center">
                    @for($j=$arr_start;$j<$arr_end;$j++)
                        <div class="col-md-4 d-none d-md-block">
                            <div class="card">
                                <div class="card-img mb-3" style="width:100%;height:200px;background:url('{{url('/')}}/admin/eksaranbhagawatisamaj/files/{{ $pic[$j] }}') no-repeat;background-size:cover;">
                                    {{-- <img src="{{url('/')}}/admin/eksaranbhagawatisamaj/files/{{ $pic[$j] }}" title="{{ $pic[$j] }}"> --}}
                                </div>
                                {{-- <div class="service-icon">
                                    <div class="service-icon-wrapper">
                                        <span class="front mbr-iconfont mobi-mbri-hot-cup mobi-mbri"></span>
                                    </div>
                                </div> --}}
                                
                                <div class="mbr-text mbr-fonts-style align-center card-text display-6">
                                    একশৰণ ভাগৱতী সমাজ
                                </div>
                                
                            </div>
                        </div>
                        @php
                            $arr_start++;
                        @endphp
                    @endfor
                    </div>
                </div>
            @endfor
        </div>

        <div class="carousel-indicators">
        @for($i=0;$i<$pic_arr_divided_three;$i++)
            <li data-slide-to="{{ $i }}"></li>
        @endfor
        </div>
        <div class="carousel-controls">
            <a class="carousel-control-prev" role="button" data-slide="prev">
                <span aria-hidden="true" class="mbri-left mbr-iconfont"></span>
                <span class="sr-only">Previous</span>
            </a>

            <a class="carousel-control-next" role="button" data-slide="next">
                <span aria-hidden="true" class="mbri-right mbr-iconfont"></span>
                <span class="sr-only">Next</span>
            </a>
        </div>
    </div>
</section>