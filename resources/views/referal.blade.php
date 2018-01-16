<!DOCTYPE html>
<!--
NuLife Website - Front
Version: 1.0.0
Author: NuLife Dev Team
Site: https://www.nulife.co.id
-->
<!--[if IE 9]> <html lang="{{ config('app.locale') }}" class="ie9"> <![endif]-->
<!--[if !IE]><!-->
<html lang="{{ config('app.locale') }}">
<!--<![endif]-->
<!-- BEGIN HEAD -->
<head>
    <meta property="og:url" content="https://www.nulife.co.id/r/{{$dataUser->userid}}" />
    <meta property="og:type" content="website" />
    <meta property="og:title" content="Join NuLife for Better Life" />
    <meta property="og:description" content="Join Successfull NuLife Community, Reach Your Better Future Life." />
    <meta property="og:image" content="https://www.nulife.co.id/static/betterlife.jpg" />
    <meta property="og:image:width" content="1200" />
    <meta property="og:image:height" content="630" />
    <meta property="fb:app_id" content="1857754324487852" />
    <meta charset="utf-8" />
    <title>join | nulife.co.id</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <meta http-equiv="Content-type" content="text/html; charset=utf-8">
    <!-- BEGIN GLOBAL MANDATORY STYLES -->
    <link href="https://fonts.googleapis.com/css?family=Ubuntu" rel="stylesheet">
    <link href="{{ asset('web-assets/css/plugins/socicon/socicon.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('web-assets/css/plugins/bootstrap-social/bootstrap-social.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('web-assets/css/plugins/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('web-assets/css/plugins/simple-line-icons/simple-line-icons.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('web-assets/css/plugins/animate/animate.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('web-assets/css/plugins/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <!-- END GLOBAL MANDATORY STYLES -->
    <!-- BEGIN: BASE PLUGINS  -->
    <link href="{{ asset('web-assets/css/plugins/revo-slider/css/settings.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('web-assets/css/plugins/revo-slider/css/layers.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('web-assets/css/plugins/revo-slider/css/navigation.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('web-assets/css/plugins/owl-carousel/assets/owl.carousel.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('web-assets/css/plugins/fancybox/jquery.fancybox.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('web-assets/css/plugins/slider-for-bootstrap/css/slider.css') }}" rel="stylesheet" type="text/css" />
    <!-- END: BASE PLUGINS -->
    <!-- BEGIN THEME STYLES -->
    <link href="{{ asset('web-assets/css/plugins.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('web-assets/css/components.css') }}" id="style_components" rel="stylesheet" type="text/css" />
    <link href="{{ asset('web-assets/css/themes/default.css') }}" rel="stylesheet" id="style_theme" type="text/css" />
    <link href="{{ asset('web-assets/css/custom.css') }}" rel="stylesheet" type="text/css" />
    <!-- END THEME STYLES -->
    <link rel="shortcut icon" href="{{ asset('assets/img/favicon_.ico') }}" /> </head>

<body class="c-layout-header-fixed c-layout-header-mobile-fixed c-layout-header-topbar c-layout-header-topbar-collapse">
<!-- BEGIN: LAYOUT/HEADERS/HEADER-1 -->
<!-- BEGIN: HEADER -->
<header class="c-layout-header c-layout-header-3 c-layout-header-3-custom-menu c-layout-header-default-mobile" data-minimize-offset="80">
    <div class="c-topbar c-topbar-light c-solid-bg">
        <div class="container">
            <!-- BEGIN: INLINE NAV -->
            <nav class="c-top-menu c-pull-right">
                <ul class="c-links c-theme-ul">
                    <li>
                        <a href="#">Help</a>
                    </li>
                    <li class="c-divider">|</li>
                    <li>
                        <a href="#">Contact</a>
                    </li>
                    <li class="c-divider">|</li>
                    <li>
                        <a href="#">FAQ</a>
                    </li>
                </ul>
                <ul class="c-ext c-theme-ul">
                    <li class="c-lang dropdown c-last">
                        <a href="#">&nbsp;&nbsp;</a>
                    </li>
                </ul>
            </nav>
            <!-- END: INLINE NAV -->
        </div>
    </div>
    <div class="c-navbar">
        <div class="container">
            <!-- BEGIN: BRAND -->
            <div class="c-navbar-wrapper clearfix">
                <div class="c-brand c-pull-left">
                    <a href="{{ url('/') }}" class="c-logo">
                        <img src="{{ asset('web-assets/img/logo-3.png') }}" alt="NuLife" class="c-desktop-logo">
                        <img src="{{ asset('web-assets/img/logo-3i.png') }}" alt="NuLife" class="c-desktop-logo-inverse">
                        <img src="{{ asset('web-assets/img/logo-3m.png') }}" alt="NuLife" class="c-mobile-logo"> </a>
                    <button class="c-hor-nav-toggler" type="button" data-target=".c-mega-menu">
                        <span class="c-line"></span>
                        <span class="c-line"></span>
                        <span class="c-line"></span>
                    </button>
                    <button class="c-topbar-toggler" type="button">
                        <i class="fa fa-ellipsis-v"></i>
                    </button>
                </div>
                <!-- END: BRAND -->
                <!-- BEGIN: HOR NAV -->
                <!-- BEGIN: LAYOUT/HEADERS/MEGA-MENU -->
                <!-- BEGIN: MEGA MENU -->
                <!-- Dropdown menu toggle on mobile: c-toggler class can be applied to the link arrow or link itself depending on toggle mode -->
                <nav class="c-mega-menu c-pull-right c-mega-menu-dark c-mega-menu-dark-mobile c-fonts-uppercase c-fonts-bold">
                    <ul class="nav navbar-nav c-theme-nav">
                        <li class="c-active c-link dropdown-toggle">
                            <a href="{{ url('/') }}" class="c-link dropdown-toggle">Home
                                <span class="c-arrow c-toggler"></span>
                            </a>
                        </li>
                        <li class="c-menu-type-classic">
                            <a href="javascript:;" class="c-link dropdown-toggle">About
                                <span class="c-arrow c-toggler"></span>
                            </a>
                        </li>
                        <li>
                            <a href="javascript:;" class="c-link dropdown-toggle">Why Us
                                <span class="c-arrow c-toggler"></span>
                            </a>
                        </li>
                        <li class="c-menu-type-classic">
                            <a href="javascript:;" class="c-link dropdown-toggle">Products
                                <span class="c-arrow c-toggler"></span>
                            </a>
                        </li>
                        <li class="c-menu-type-classic">
                            <a href="javascript:;" class="c-link dropdown-toggle">Plan
                                <span class="c-arrow c-toggler"></span>
                            </a>
                        </li>
                        <li>
                            <a href="javascript:;" class="c-link dropdown-toggle">NuVision
                                <span class="c-arrow c-toggler"></span>
                            </a>
                        </li>
                        <li>
                            <a href="javascript:;" data-toggle="modal" data-target="#login-form" class="c-btn-border-opacity-04 c-btn btn-no-focus c-btn-header btn btn-sm c-btn-border-1x c-btn-dark c-btn-circle c-btn-uppercase c-btn-sbold">
                                <i class="icon-user"></i> Sign In</a>
                        </li>
                    </ul>
                </nav>
                <!-- END: MEGA MENU -->
                <!-- END: LAYOUT/HEADERS/MEGA-MENU -->
                <!-- END: HOR NAV -->
            </div>
        </div>
    </div>
</header>
<!-- END: HEADER -->
<!-- END: HEADER -->
<!-- END: LAYOUT/HEADERS/HEADER-1 -->
<!-- BEGIN: CONTENT/USER/FORGET-PASSWORD-FORM -->
<div class="modal fade c-content-login-form" id="forget-password-form" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content c-square">
            <div class="modal-header c-no-border">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <h3 class="c-font-24 c-font-sbold">Password Recovery</h3>
                <p>To recover your password please fill in your email address</p>
                <form class="form-horizontal" role="form" method="POST" action="{{ route('password.email') }}">
                    {{ csrf_field() }}
                    <div class="form-group">
                        <label for="forget-email" class="hide">Email</label>
                        <input type="email" class="form-control input-lg c-square" id="email" name="email" placeholder="Email"> </div>
                    <div class="form-group">
                        <button type="submit" class="btn c-theme-btn btn-md c-btn-uppercase c-btn-bold c-btn-square c-btn-login">Submit</button>
                        <a href="javascript:;" class="c-btn-forgot" data-toggle="modal" data-target="#login-form" data-dismiss="modal">Back To Login</a>
                    </div>
                </form>
            </div>
            <div class="modal-footer c-no-border">
            </div>
        </div>
    </div>
</div>
<!-- END: CONTENT/USER/FORGET-PASSWORD-FORM -->

<!-- BEGIN: CONTENT/USER/LOGIN-FORM -->
<div class="modal fade c-content-login-form" id="login-form" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content c-square">
            <div class="modal-header c-no-border">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <h3 class="c-font-24 c-font-sbold greeting"></h3>
                <p>Let's make today a great day!</p>
                <form class="form-signin" method="post" action="{{ route('login') }}">
                    {{ csrf_field() }}
                    <div class="form-group">
                        <label for="login-email" class="hide">NuLife ID</label>
                        <input type="text" class="form-control input-lg c-square" id="userid" name="userid" placeholder="NuLife ID" autofocus> </div>
                    <div class="form-group">
                        <label for="login-password" class="hide">Password</label>
                        <input type="password" class="form-control input-lg c-square" id="password" name="password" placeholder="Password"> </div>
                    <div class="form-group">
                        <button type="submit" class="btn c-theme-btn btn-md c-btn-uppercase c-btn-bold c-btn-square c-btn-login">Login</button>
                        <a href="javascript:;" data-toggle="modal" data-target="#forget-password-form" data-dismiss="modal" class="c-btn-forgot">Forgot Your Password ?</a>
                    </div>
                </form>
            </div>
            <div class="modal-footer c-no-border">
            </div>
        </div>
    </div>
</div>
<!-- END: CONTENT/USER/LOGIN-FORM -->
<!-- BEGIN: PAGE CONTAINER -->
<div class="c-layout-page">
    <div class="row c-margin-t-60">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <p>Your Referral</p>
                    <p><i class="fa fa-user"></i> {{ucwords($dataUser->nama)}} ({{$dataUser->userid}})</p>
                    <p><i class="fa fa-phone"></i> {{$dataUser->no_handphone}} </p>
                </div>
                <div class="panel-body">
                    <form class="form-horizontal" role="form" method="POST" action="{{ route('post.referal') }}">
                        {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                            <label for="name" class="col-md-4 control-label">Name</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}" required autofocus>

                                @if ($errors->has('name'))
                                    <span class="help-block">
                                    <strong>{{ $errors->first('name') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <label for="email" class="col-md-4 control-label">E-Mail Address</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required>

                                @if ($errors->has('email'))
                                    <span class="help-block">
                                    <strong>{{ $errors->first('email') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <label for="hp" class="col-md-4 control-label">Mobile Phone</label>

                            <div class="col-md-6">
                                <input id="email" type="text" class="form-control" name="hp" value="{{ old('hp') }}" required>

                                @if ($errors->has('hp'))
                                    <span class="help-block">
                                    <strong>{{ $errors->first('hp') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            <label for="password" class="col-md-4 control-label">Password</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control" name="password" required>

                                @if ($errors->has('password'))
                                    <span class="help-block">
                                    <strong>{{ $errors->first('password') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="password-confirm" class="col-md-4 control-label">Confirm Password</label>

                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirm" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <input type="hidden" class="form-control" name="code" value="{{$dataUser->userid}}">
                            <input type="hidden" class="form-control" name="userid" value="{{$idCode}}">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    Register
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- END: PAGE CONTAINER -->

<!-- BEGIN: LAYOUT/FOOTERS/FOOTER-4 -->
<a name="footer"></a>
<footer class="c-layout-footer c-layout-footer-2">
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <div class="c-container c-first">
                    <div class="c-content-title-1">
                        <h3 class="c-font-uppercase c-font-bold">Success Starts With Your Mind</h3>
                        <div class="c-line-left"></div>
                        <p class="c-feature-16-desc c-font-grey">All can be done well if always think positive and optimistic in all things, then it will also motivate us to be the best. There is a fascinating experience from the world boxer Muhammad Ali. He once said that the champion resulted from desire, dreams, and vision.</p>
                    </div>
                    <a href="#" class="btn c-theme-btn c-btn-uppercase c-btn-square c-btn-bold">Join NuLife Now</a>
                </div>
            </div>
            <div class="col-md-6">
                <div class="c-container c-last">
                    <div class="c-content-title-1">
                        <h3 class="c-font-uppercase c-font-bold">Share the Dream</h3>
                        <div class="c-line-left"></div>
                    </div>
                    <ul class="c-socials">
                        <li>
                            <a href="#">
                                <i class="icon-social-twitter"></i>
                            </a>
                        </li>
                        <li>
                            <a href="#">
                                <i class="icon-social-facebook"></i>
                            </a>
                        </li>
                        <li>
                            <a href="#">
                                <i class="icon-social-youtube"></i>
                            </a>
                        </li>
                        <li>
                            <a href="#">
                                <i class="icon-social-tumblr"></i>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="c-copyright">
            <p>
                <a href="https://www.instantssl.com/wildcard-ssl.html" target="_blank" style="text-decoration:none; ">
                    <img alt="Wildcard SSL" src="https://www.instantssl.com/ssl-certificate-images/support/comodo_secure_100x85_transp.png" style="border: 0px;">
                </a>
            </p>
            <p class="c-font-oswald c-font-14">
                Copyright &copy; 2017, nulife.co.id
                &nbsp;&nbsp;<a class="c-font-blue c-font-grey-1-hover" href="{{ route('coc') }}">Code of Conduct</a>
                &nbsp;&nbsp;<a class="c-font-blue c-font-grey-1-hover" href="#">Term of Use</a>
                &nbsp;&nbsp;<a class="c-font-blue c-font-grey-1-hover" href="#">Privacy Policy</a>
            </p>
        </div>
    </div>
</footer>
<!-- END: LAYOUT/FOOTERS/FOOTER-4 -->
<!-- BEGIN: LAYOUT/FOOTERS/GO2TOP -->
<div class="c-layout-go2top">
    <i class="icon-arrow-up"></i>
</div>
<!-- END: LAYOUT/FOOTERS/GO2TOP -->
<!-- BEGIN: LAYOUT/BASE/BOTTOM -->
<!-- BEGIN: CORE PLUGINS -->
<!--[if lt IE 9]>
<script src="{{ asset('web-assets/js/plugins/excanvas.min.js') }}"></script>
<![endif]-->
<script src="{{ asset('web-assets/js/jquery.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('web-assets/js/jquery-migrate.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('web-assets/js/plugins/bootstrap.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('web-assets/js/plugins/jquery.easing.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('web-assets/js/plugins/wow.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('web-assets/js/plugins/reveal-animate.js') }}" type="text/javascript"></script>
<!-- END: CORE PLUGINS -->
<!-- BEGIN: LAYOUT PLUGINS -->
<script src="{{ asset('web-assets/js/plugins/jquery.themepunch.tools.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('web-assets/js/plugins/jquery.themepunch.revolution.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('web-assets/js/plugins/revolution.extension.slideanims.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('web-assets/js/plugins/revolution.extension.layeranimation.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('web-assets/js/plugins/revolution.extension.navigation.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('web-assets/js/plugins/revolution.extension.video.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('web-assets/js/plugins/jquery.cubeportfolio.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('web-assets/js/plugins/owl.carousel.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('web-assets/js/plugins/jquery.waypoints.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('web-assets/js/plugins/jquery.counterup.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('web-assets/js/plugins/jquery.fancybox.pack.js') }}" type="text/javascript"></script>
<script src="{{ asset('web-assets/js/plugins/jquery.smooth-scroll.js') }}" type="text/javascript"></script>
<script src="{{ asset('web-assets/js/plugins/bootstrap-slider.js') }}" type="text/javascript"></script>
<!-- END: LAYOUT PLUGINS -->
<!-- BEGIN: THEME SCRIPTS -->
<script src="{{ asset('web-assets/js/components.js') }}" type="text/javascript"></script>
<script src="{{ asset('web-assets/js/app.js') }}" type="text/javascript"></script>
<script>
    $(document).ready(function()
    {
        App.init(); // init core

        var thehours = new Date().getHours();
        var themessage;
        var morning = ('Good Morning!');
        var afternoon = ('Good Afternoon!');
        var evening = ('Good Evening!');

        if (thehours >= 0 && thehours < 12) {
            themessage = morning;

        } else if (thehours >= 12 && thehours < 17) {
            themessage = afternoon;

        } else if (thehours >= 17 && thehours < 24) {
            themessage = evening;
        }

        $('.greeting').append(themessage);
    });
</script>
<!-- END: THEME SCRIPTS -->
<!-- BEGIN: PAGE SCRIPTS -->
<script src="{{ asset('web-assets/js/plugins/revolution.extension.kenburn.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('web-assets/js/plugins/revolution.extension.parallax.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('web-assets/js/slider.js') }}" type="text/javascript"></script>
<!-- END: PAGE SCRIPTS -->
<!-- END: LAYOUT/BASE/BOTTOM -->

<!-- ALERT RESET PASSWORD -->
@if (session('status'))
    <div class="c-cookies-bar c-cookies-bar-2 c-cookies-bar-top c-theme-bg c-theme-darken c-rounded wow animate fadeInDown js-cookie-consent cookie-consent" data-wow-delay="1s">
        <div class="c-cookies-bar-container">
            <div class="row">
                <div class="col-md-10">
                    <div class="c-cookies-bar-content c-font-white cookie-consent__message">
                        {{ session('status') }}
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="c-cookies-bar-btn">
                        <a class="c-cookies-bar-close btn c-btn-white c-btn-square c-btn-bold js-cookie-consent-agree cookie-consent__agree" href="javascript:;">{{ trans('cookieConsent::texts.agree') }}</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endif
@if ($errors->has('email'))
    <div class="c-cookies-bar c-cookies-bar-2 c-cookies-bar-top c-theme-bg c-theme-darken c-rounded wow animate fadeInDown js-cookie-consent cookie-consent" data-wow-delay="1s">
        <div class="c-cookies-bar-container">
            <div class="row">
                <div class="col-md-10">
                    <div class="c-cookies-bar-content c-font-white cookie-consent__message">
                        {{ $errors->first('email') }}
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="c-cookies-bar-btn">
                        <a class="c-cookies-bar-close btn c-btn-white c-btn-square c-btn-bold js-cookie-consent-agree cookie-consent__agree" href="javascript:;">{{ trans('cookieConsent::texts.agree') }}</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endif


@if ($errors->has('userid') || $errors->has('password'))
    <div class="c-cookies-bar c-cookies-bar-2 c-cookies-bar-top c-theme-bg c-theme-darken c-rounded wow animate fadeInDown js-cookie-consent cookie-consent" data-wow-delay="1s">
        <div class="c-cookies-bar-container">
            <div class="row">
                <div class="col-md-10">
                    <div class="c-cookies-bar-content c-font-white cookie-consent__message">
                        User ID / Password do not match.
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="c-cookies-bar-btn">
                        <a class="c-cookies-bar-close btn c-btn-white c-btn-square c-btn-bold js-cookie-consent-agree cookie-consent__agree" href="javascript:;">{{ trans('cookieConsent::texts.agree') }}</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endif
@if ( Session::has('message') )
    <div class="c-cookies-bar c-cookies-bar-2 c-cookies-bar-top c-theme-bg c-theme-darken c-rounded wow animate fadeInDown js-cookie-consent cookie-consent" data-wow-delay="1s">
        <div class="c-cookies-bar-container">
            <div class="row">
                <div class="col-md-10">
                    <div class="c-cookies-bar-content c-font-white cookie-consent__message">
                        {{  Session::get('message')    }}
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="c-cookies-bar-btn">
                        <a class="c-cookies-bar-close btn c-btn-white c-btn-square c-btn-bold js-cookie-consent-agree cookie-consent__agree" href="javascript:;">{{ trans('cookieConsent::texts.agree') }}</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endif

</body>

</html>