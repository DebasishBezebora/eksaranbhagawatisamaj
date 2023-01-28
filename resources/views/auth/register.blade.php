<!DOCTYPE html>
<html lang="en">

<!-- Mirrored from adminlte.io/themes/v3/pages/examples/register-v2.html by HTTraQt Website Copier/1.x [Karbofos 2012-2017] Sat, 08 Oct 2022 05:53:30 GMT -->

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>AdminLTE 3 | Registration Page (v2)</title>
    <link rel="stylesheet" href="../../../../../fonts.googleapis.com/css24b9.css?family=Source+Sans+Pro:300,400,400i,700&amp;display=fallback">
    <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
    <link rel="stylesheet" href="plugins/icheck-bootstrap/icheck-bootstrap.min.css">
    <link rel="stylesheet" href="dist/css/adminlte.min2167.css?v=3.2.0">
    <script nonce="3d6ddf8d-e9fd-4288-999a-cc3f21e782c7">
        (function(w, d) {
            ! function(a, e, t, r) {
                a.zarazData = a.zarazData || {};
                a.zarazData.executed = [];
                a.zaraz = {
                    deferred: [],
                    listeners: []
                };
                a.zaraz.q = [];
                a.zaraz._f = function(e) {
                    return function() {
                        var t = Array.prototype.slice.call(arguments);
                        a.zaraz.q.push({
                            m: e,
                            a: t
                        })
                    }
                };
                for (const e of ["track", "set", "debug"]) a.zaraz[e] = a.zaraz._f(e);
                a.zaraz.init = () => {
                    var t = e.getElementsByTagName(r)[0],
                        z = e.createElement(r),
                        n = e.getElementsByTagName("title")[0];
                    n && (a.zarazData.t = e.getElementsByTagName("title")[0].text);
                    a.zarazData.x = Math.random();
                    a.zarazData.w = a.screen.width;
                    a.zarazData.h = a.screen.height;
                    a.zarazData.j = a.innerHeight;
                    a.zarazData.e = a.innerWidth;
                    a.zarazData.l = a.location.href;
                    a.zarazData.r = e.referrer;
                    a.zarazData.k = a.screen.colorDepth;
                    a.zarazData.n = e.characterSet;
                    a.zarazData.o = (new Date).getTimezoneOffset();
                    a.zarazData.q = [];
                    for (; a.zaraz.q.length;) {
                        const e = a.zaraz.q.shift();
                        a.zarazData.q.push(e)
                    }
                    z.defer = !0;
                    for (const e of [localStorage, sessionStorage]) Object.keys(e || {}).filter((a => a.startsWith("_zaraz_"))).forEach((t => {
                        try {
                            a.zarazData["z_" + t.slice(7)] = JSON.parse(e.getItem(t))
                        } catch {
                            a.zarazData["z_" + t.slice(7)] = e.getItem(t)
                        }
                    }));
                    z.referrerPolicy = "origin";
                    z.src = "../../../../cdn-cgi/zaraz/sd0d9.js?z=" + btoa(encodeURIComponent(JSON.stringify(a.zarazData)));
                    t.parentNode.insertBefore(z, t)
                };
                ["complete", "interactive"].includes(e.readyState) ? zaraz.init() : a.addEventListener("DOMContentLoaded", zaraz.init)
            }(w, d, 0, "script");
        })(window, document);
    </script>
</head>

<body class="hold-transition register-page">
    <div class="register-box">
        <div class="card card-outline card-primary">
            <div class="card-header text-center">
                <a href="../../index2.html" class="h1"><b>Admin</b>LTE</a>
            </div>
            <div class="card-body">
                <p class="login-box-msg">Register a new membership</p>
                <form action="{{url('/')}}/register-user" method="post">
                    @if(Session::has('Success'))
                        <div class="alert alert-success">{{Session::get('Success')}}</div>
                    @endif
                    @if(Session::has('Fail'))
                        <div class="alert alert-danger">{{Session::get('Fail')}}</div>
                    @endif
                    @csrf
                    <div class="input-group mb-3">
                        <input type="text" name="name" id="" class="form-control" placeholder="Full name" value="{{old('name')}}">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-user"></span>
                            </div>
                        </div>
                        <small id="helpId" class="col-12 text-danger">
                            @error('name')
                                {{ $message }}
                            @enderror
                        </small>
                    </div>
                    <div class="input-group mb-3">
                        <input type="email" name="email" id="" class="form-control" placeholder="Email" value="{{old('email')}}">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-envelope"></span>
                            </div>
                        </div>
                        <small id="helpId" class="col-12 text-danger">
                            @error('email')
                                {{ $message }}
                            @enderror
                        </small>
                    </div>
                    <div class="input-group mb-3">
                        <input type="number" name="phone" id="" class="form-control" placeholder="Phone No" value="{{old('phone')}}">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-phone"></span>
                            </div>
                        </div>
                        <small id="helpId" class="col-12 text-danger">
                            @error('phone')
                                {{ $message }}
                            @enderror
                        </small>
                    </div>
                    <div class="input-group mb-3">
                        <input type="password" name="password" id="" class="form-control" placeholder="Password">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-lock"></span>
                            </div>
                        </div>
                        <small id="helpId" class="col-12 text-danger">
                            @error('password')
                                {{ $message }}
                            @enderror
                        </small>
                    </div>
                    <div class="input-group mb-3">
                        <input type="password" name="password_confirmation" id="" class="form-control" placeholder="Retype password">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-lock"></span>
                            </div>
                        </div>
                        <small id="helpId" class="col-12 text-danger">
                            @error('password_confirmation')
                                {{ $message }}
                            @enderror
                        </small>
                    </div>
                    <div class="input-group mb-3">
                        <div class="custom-control custom-radio" style="margin-right:10px;">
                            <input class="custom-control-input" type="radio" id="status1" name="status" value="1" checked>
                            <label for="customRadio1" class="custom-control-label">Active </label>
                        </div>
                        <div class="custom-control custom-radio">
                            <input class="custom-control-input" type="radio" id="status2" name="status" value="0">
                            <label for="customRadio2" class="custom-control-label">Suspended</label>
                        </div>
                        <small id="helpId" class="col-12 text-danger">
                            @error('status')
                                {{ $message }}
                            @enderror
                        </small>
                    </div>
                    <div class="row">
                        <div class="col-8">
                            <div class="icheck-primary">
                                <input type="checkbox" name="agreeTerms" id="agreeTerms" name="terms" value="agree">
                                <label for="agreeTerms">
                                    I agree to the <a href="#">terms</a>
                                </label>
                            </div>
                            <small id="helpId" class="col-12 text-danger">
                                @error('agreeTerms')
                                    {{ $message }}
                                @enderror
                            </small>
                        </div>

                        <div class="col-4">
                            <button type="submit" class="btn btn-primary btn-block">Register</button>
                        </div>

                    </div>
                </form>
                {{-- <div class="social-auth-links text-center">
                    <a href="#" class="btn btn-block btn-primary">
                        <i class="fab fa-facebook mr-2"></i>
                        Sign up using Facebook
                    </a>
                    <a href="#" class="btn btn-block btn-danger">
                        <i class="fab fa-google-plus mr-2"></i>
                        Sign up using Google+
                    </a>
                </div> --}}
                {{-- <a href="login.html" class="text-center">I already have a membership</a> --}}
            </div>
        </div>
    </div>
    <script src="plugins/jquery/jquery.min.js"></script>
    <script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="dist/js/adminlte.min2167.js?v=3.2.0"></script>
</body>
</html>