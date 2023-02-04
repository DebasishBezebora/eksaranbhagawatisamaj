@extends('photogallery.photoGallery')
@section('main-section')
@push('breadcrumbs')
<section class="content4 cid-ttSbRPqhFq" id="content4-o">
    <div class="container">
        <div class="row justify-content-center">
            <div class="title col-md-12 col-lg-12 pb-3 pt-1">
                <h3 class="mbr-section-title mbr-fonts-style align-left mb-3 display-2">
                    ২০২৩ চনৰ আভাস
                </h3>
                <h4 class="mbr-section-subtitle align-left mbr-fonts-style display-7"><i class="fa-sharp fa-solid fa-house-chimney"></i> / ২০২৩ চনৰ আভাস</h4>
            </div>
        </div>
    </div>
</section>
@endpush

<section class="features8 medicalm4_features8 cid-tulRAYtM3H" id="features8-1g">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12"></div>
        </div>
        <div class="row row-content justify-content-center">
            @foreach($siteGlimpse as $rows)
                @php
                    $a = explode(",", $rows['Photos']);
                    $pic = array_rand($a, 1);
                    $b = $a[$pic];
                @endphp
                
                    <div class="card p-3 col-12 col-md-6 col-lg-4">
                        <a href="{{url('/')}}/আভাস/{{$rows['ID']}}">
                            <div class="card-wrapper">
                                <img src="{{url('/')}}/admin/eksaranbhagawatisamaj/files/{{ $b }}" title="">
                                <div class="card-box">
                                    <h4 class="card-title mbr-fonts-style mbr-bold display-7">
                                        <span class="mbr-iconfont mbrib-user"></span>
                                        {{ $rows['Album_Name'] }}    
                                    </h4>
                                </div>
                            </div>
                        </a>
                    </div>
            @endforeach
        </div>
    </div>
</section>

@endsection