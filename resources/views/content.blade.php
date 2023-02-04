@extends('content.contentPage')
@section('main-section')
@push('breadcrumbs')
<section class="content4 cid-ttSbRPqhFq" id="content4-o">
    <div class="container">
        <div class="row justify-content-center">
            <div class="title col-md-12 col-lg-12 pb-3 pt-1">
                <h3 class="mbr-section-title mbr-fonts-style align-left mb-3 display-2">
                    {{ $siteLink->Title }}</h3>
                <h4 class="mbr-section-subtitle align-left mbr-fonts-style display-7"><i class="fa-sharp fa-solid fa-house-chimney"></i> / {{ $siteLink->Title }}</h4>
            </div>
        </div>
    </div>
</section>
@endpush

<section class="article2 factm5 cid-ttSaRWXRZV" id="aarticle2-n">
    <div class="container">
        <div class="row img-row justify-content-center m-0">
            <div class="p-0 col-12 col-lg-12">
                <div class="text-wrap">
                    {!! $siteLink->Link_Content !!}
                </div>

            </div>
        </div>
    </div>
</section>

@endsection