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
    <meta charset="utf-8" />
    <title>nulife.co.id - reset password</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <meta http-equiv="Content-type" content="text/html; charset=utf-8">
    <meta content="" name="" />
    <meta content="" name="" />
    <!-- BEGIN GLOBAL MANDATORY STYLES -->
    <link href="{{ asset('web-assets/css/loader.css') }}" rel="stylesheet" type="text/css" />
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
                        @if (Auth::check())
                            @if (Auth::user()->isAdmin())
                                <li>
                                    <a href="{{ route('admin') }}" class="c-btn-border-opacity-04 c-btn btn-no-focus c-btn-header btn btn-sm c-btn-border-1x c-btn-dark c-btn-circle c-btn-uppercase c-btn-sbold">
                                        <i class="icon-screen-desktop"></i> Admin Dashboard</a>
                                </li>
                            @else
                                <li>
                                    <a href="{{ route('dashboard') }}" class="c-btn-border-opacity-04 c-btn btn-no-focus c-btn-header btn btn-sm c-btn-border-1x c-btn-dark c-btn-circle c-btn-uppercase c-btn-sbold">
                                        <i class="icon-screen-desktop"></i> Dashboard</a>
                                </li>
                            @endif
                        @else
                            <li>
                                <a href="javascript:;" data-toggle="modal" data-target="#login-form" class="c-btn-border-opacity-04 c-btn btn-no-focus c-btn-header btn btn-sm c-btn-border-1x c-btn-dark c-btn-circle c-btn-uppercase c-btn-sbold">
                                    <i class="icon-user"></i> Sign In</a>
                            </li>
                        @endif
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

@yield('content')

<a name="footer"></a>
<footer class="c-layout-footer c-layout-footer-2" style="margin-top:30px">
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
<script src="{{ asset('web-assets/js/TweenMax.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('web-assets/js/loader.js') }}" type="text/javascript"></script>
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

<?php
if (session('pesan-flash')) {
    $pesanan = session('pesan-flash');
} else {
    if (!isset($pesanan)) {
        $pesanan = [];
    }
}
?>

@if ($pesanan && !empty($pesanan))
        <div class="c-cookies-bar c-cookies-bar-2 c-cookies-bar-top c-theme-bg c-theme-darken c-rounded wow animate fadeInDown js-cookie-consent cookie-consent" data-wow-delay="1s">
            <div class="c-cookies-bar-container">
                <div class="row">
                    <div class="col-md-10">
                        <div class="c-cookies-bar-content c-font-white cookie-consent__message">
                            {{  $pesanan['pesan']  }}
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