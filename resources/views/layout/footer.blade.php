<section class="footer6 cid-ttRZlAiJnR" once="footers" id="footer6-a">
    <div class="container">
        <div class="row content mbr-white">
            <div class="col-12 col-md-6 mbr-fonts-style display-7">
                <h5 class="mbr-section-subtitle mbr-fonts-style mb-2 display-5">
                    <strong>{{ $siteSettings->Title }}</strong>
                </h5>
                <br />
                <h5 class="mbr-section-subtitle mbr-fonts-style mb-2 display-7">
                    <strong>সোণালী জয়ন্তী বৰ্ষৰ প্রাদেশিক অধিৱেশন<br />আৰু মহাপালনাম</strong>
                </h5>
                <br />
                <p class="mbr-text mbr-fonts-style display-7">
                   {{ $siteSettings->Address }}
                </p>
            </div>
            <div class="col-12 col-md-6">
                <div class="google-map">{!! $siteSettings->Map !!}</div>
            </div>
            <div class="col-md-6">
                <div class="social-list align-left">
                    @if($siteSettings->Facebook <> "")
                        <div class="soc-item">
                            <a href="{{ $siteSettings->Facebook }}" target="_blank">
                                <span class="socicon-facebook socicon mbr-iconfont mbr-iconfont-social"></span>
                            </a>
                        </div>
                    @endif
                    @if($siteSettings->Twitter <> "")
                        <div class="soc-item">
                            <a href="{{ $siteSettings->Twitter }}" target="_blank">
                                <span class="socicon-facebook socicon mbr-iconfont mbr-iconfont-social"></span>
                            </a>
                        </div>
                    @endif
                    @if($siteSettings->Instagram <> "")
                        <div class="soc-item">
                            <a href="{{ $siteSettings->Instagram }}" target="_blank">
                                <span class="socicon-facebook socicon mbr-iconfont mbr-iconfont-social"></span>
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
        <div class="footer-lower">
            <div class="media-container-row">
                <div class="col-sm-12">
                    <hr>
                </div>
            </div>
            <div class="col-sm-12 copyright pl-0">
                <p class="mbr-text mbr-fonts-style mbr-white display-7">
                    © একশৰণ ভাগৱতী সমাজ
                </p>
            </div>
        </div>
    </div>
</section>

<script src="{{url('/')}}/assets/web/assets/jquery/jquery.min.js"></script>
<script src="{{url('/')}}/assets/popper/popper.min.js"></script>
<script src="{{url('/')}}/assets/tether/tether.min.js"></script>
<script src="{{url('/')}}/assets/bootstrap/js/bootstrap.min.js"></script>
<script src="{{url('/')}}/assets/smoothscroll/smooth-scroll.js"></script>
<script src="{{url('/')}}/assets/dropdown/js/nav-dropdown.js"></script>
<script src="{{url('/')}}/assets/dropdown/js/navbar-dropdown.js"></script>
<script src="{{url('/')}}/assets/touchswipe/jquery.touch-swipe.min.js"></script>
<script src="{{url('/')}}/assets/ytplayer/jquery.mb.ytplayer.min.js"></script>
<script src="{{url('/')}}/assets/vimeoplayer/jquery.mb.vimeo_player.js"></script>
<script src="{{url('/')}}/assets/viewportchecker/jquery.viewportchecker.js"></script>
<script src="{{url('/')}}/assets/bootstrapcarouselswipe/bootstrap-carousel-swipe.js"></script>
<script src="{{url('/')}}/assets/mbr-testimonials-slider/mbr-testimonials-slider.js"></script>
<script src="{{url('/')}}/assets/theme/js/script.js"></script>

</body>

</html>