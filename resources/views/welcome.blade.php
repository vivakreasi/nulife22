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
    <title>welcome | nulife.co.id</title>
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
<div class="loader">
    <div class="send">
        <div class="send-indicator">
            <div class="send-indicator-dot"></div>
            <div class="send-indicator-dot"></div>
            <div class="send-indicator-dot"></div>
            <div class="send-indicator-dot"></div>
        </div>
    </div>
    <div class="sent-icon">
        <img src="{{ asset('web-assets/img/logohijau.png') }}">
    </div>
    <svg xmlns="http://www.w3.org/2000/svg" version="1.1" width="800">
        <defs>
            <filter id="goo">
                <feGaussianBlur in="SourceGraphic" stdDeviation="10" result="blur" />
                <feColorMatrix in="blur" mode="matrix" values="1 0 0 0 0  0 1 0 0 0  0 0 1 0 0  0 0 0 19 -9" result="goo" />
                <feComposite in="SourceGraphic" in2="goo" operator="atop"/>
            </filter>
            <filter id="goo-no-comp">
                <feGaussianBlur in="SourceGraphic" stdDeviation="10" result="blur" />
                <feColorMatrix in="blur" mode="matrix" values="1 0 0 0 0  0 1 0 0 0  0 0 1 0 0  0 0 0 19 -9" result="goo" />
            </filter>
        </defs>
    </svg>
</div>
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
@if (!Auth::check())
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
                <form class="form-horizontal" role="form" method="POST" action="{{route('post.lost.password')}}">
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

<!-- BEGIN: CONTENT/USER/RESEND-ACTIVATION-FORM -->
<div class="modal fade c-content-login-form" id="resend-activation-form" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content c-square">
            <div class="modal-header c-no-border">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <h3 class="c-font-24 c-font-sbold">Resend Activation</h3>
                <p>If you're having trouble messaging or you're not receiving email notifications.</p>
                <form class="form-horizontal" role="form" method="POST" action="{{route('post.resend.activation')}}">
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
<!-- END: CONTENT/USER/RESEND-ACTIVATION-FORM -->

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
                <form class="form-signin" method="post" action="{{ route('newlogin') }}">
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
                        <a href="javascript:;" data-toggle="modal" data-target="#resend-activation-form" data-dismiss="modal" class="c-btn-forgot">Resend Acctivation</a>
                    </div>
                </form>
            </div>
            <div class="modal-footer c-no-border">
            </div>
        </div>
    </div>
</div>
<!-- END: CONTENT/USER/LOGIN-FORM -->
@endif

<!-- BEGIN: PAGE CONTAINER -->
<div class="c-layout-page">
    <!-- BEGIN: PAGE CONTENT -->
    <!-- BEGIN: LAYOUT/SLIDERS/REVO-SLIDER-14 -->
    <section class="c-layout-revo-slider c-layout-revo-slider-14" dir="ltr">
        <div class="tp-banner-container c-theme">
            <div class="tp-banner rev_slider" data-version="5.0">
                <ul>
                    <!--BEGIN: SLIDE #1 -->
                    <li data-index="rs-16" data-transition="zoomout" data-slotamount="default" data-easein="Power4.easeInOut" data-easeout="Power4.easeInOut" data-masterspeed="2000" data-thumb="{{ asset('web-asset/img/09.jpg') }}" data-rotate="0"
                        data-fstransition="fade" data-fsmasterspeed="1500" data-fsslotamount="7" data-saveperformance="off" data-title="Let's go NuLife" data-description="">
                        <!-- MAIN IMAGE -->
                        <img src="{{ asset('web-assets/img/09.jpg') }}" alt="" data-bgposition="center center" data-kenburns="on" data-duration="15000" data-ease="Linear.easeNone" data-scalestart="100" data-scaleend="120" data-rotatestart="0"
                             data-rotateend="0" data-offsetstart="-500 0" data-offsetend="0 500" data-bgparallax="10" class="rev-slidebg" data-no-retina>
                        <!-- LAYERS -->
                        <!-- LAYER NR. 1 -->
                        <div class="tp-caption tp-resizeme rs-parallaxlevel-2 c-font-white c-font-bold" id="slide-16-layer-1" data-x="['center','center','center','center']" data-hoffset="['0','0','0','0']" data-y="['middle','middle','middle','middle']"
                             data-voffset="['0','0','0','0']" data-fontsize="['70','70','70','45']" data-lineheight="['70','70','70','50']" data-width="none" data-height="none" data-whitespace="nowrap" data-transform_idle="o:1;" data-transform_in="x:[105%];z:0;rX:45deg;rY:0deg;rZ:90deg;sX:1;sY:1;skX:0;skY:0;s:2000;e:Power4.easeInOut;"
                             data-transform_out="y:[100%];s:1000;e:Power2.easeInOut;s:1000;e:Power2.easeInOut;" data-mask_in="x:0px;y:0px;s:inherit;e:inherit;" data-mask_out="x:inherit;y:inherit;s:inherit;e:inherit;" data-start="1000" data-splitin="chars"
                             data-splitout="none" data-responsive_offset="on" data-elementdelay="0.05" style="z-index: 5; white-space: nowrap;">QUALITY PRODUCTS </div>
                        <!-- LAYER NR. 2 -->
                        <div class="tp-caption tp-resizeme rs-parallaxlevel-5 c-font-white" id="slide-16-layer-4" data-x="['center','center','center','center']" data-hoffset="['0','0','0','0']" data-y="['middle','middle','middle','middle']" data-voffset="['52','52','52','51']"
                             data-width="none" data-height="none" data-whitespace="nowrap" data-transform_idle="o:1;" data-transform_in="y:[100%];z:0;rX:0deg;rY:0;rZ:0;sX:1;sY:1;skX:0;skY:0;opacity:0;s:2000;e:Power4.easeInOut;" data-transform_out="y:[100%];s:1000;e:Power2.easeInOut;s:1000;e:Power2.easeInOut;"
                             data-mask_in="x:0px;y:[100%];s:inherit;e:inherit;" data-mask_out="x:inherit;y:inherit;s:inherit;e:inherit;" data-start="1500" data-splitin="none" data-splitout="none" data-responsive_offset="on" style="z-index: 6; white-space: nowrap;">Better Plan, Better System, For Better Life! </div>
                        <!-- LAYER NR. 3 -->
                        <div class="tp-caption tp-resizeme rs-parallaxlevel-7" id="slide-20-layer-8" data-x="['center','center','center','center']" data-hoffset="['0','0','0','0']" data-y="['middle','middle','middle','middle']" data-voffset="['105','105','105','105']"
                             data-width="none" data-height="none" data-whitespace="nowrap" data-transform_idle="o:1;" data-style_hover="cursor:default;" data-transform_in="y:[100%];z:0;rX:0deg;rY:0;rZ:0;sX:1;sY:1;skX:0;skY:0;opacity:0;s:1500;e:Power4.easeInOut;"
                             data-transform_out="y:[100%];s:1000;e:Power2.easeInOut;s:1000;e:Power2.easeInOut;" data-mask_in="x:0px;y:[100%];s:inherit;e:inherit;" data-mask_out="x:inherit;y:inherit;s:inherit;e:inherit;" data-start="2000" data-splitin="none"
                             data-splitout="none" data-responsive_offset="on" style="z-index: 7; white-space: nowrap;">
                            <a href="#" class="c-action-btn btn btn-lg c-btn-square c-btn-border-2x c-btn-white c-btn-bold c-btn-uppercase">EXPLORE</a>
                        </div>
                    </li>
                    <!--END -->
                    <!-- BEGIN: SLIDE #2 -->
                    <li data-index="rs-17" data-transition="fadetotopfadefrombottom" data-slotamount="default" data-easein="Power3.easeInOut" data-easeout="Power3.easeInOut" data-masterspeed="1500" data-thumb="{{ asset('web-assets/img/15.jpg') }}"
                        data-rotate="0" data-saveperformance="off" data-title="Parallax" data-description="">
                        <!-- MAIN IMAGE -->
                        <img src="{{ asset('web-assets/img/15.jpg') }}" alt="" data-bgposition="center center" data-kenburns="on" data-duration="15000" data-ease="Linear.easeNone" data-scalestart="100" data-scaleend="120" data-rotatestart="0"
                             data-rotateend="0" data-offsetstart="0 500" data-offsetend="0 500" data-bgparallax="10" class="rev-slidebg" data-no-retina>
                        <!-- LAYERS -->
                        <!-- LAYER NR. 1 -->
                        <div class="tp-caption tp-resizeme rs-parallaxlevel-3 c-font-white c-font-bold" id="slide-17-layer-1" data-x="['center','center','center','center']" data-hoffset="['0','0','0','0']" data-y="['middle','middle','middle','middle']"
                             data-voffset="['0','0','0','0']" data-fontsize="['70','70','70','45']" data-lineheight="['70','70','70','50']" data-width="none" data-height="none" data-whitespace="nowrap" data-transform_idle="o:1;" data-transform_in="y:[100%];z:0;rZ:-35deg;sX:1;sY:1;skX:0;skY:0;s:2000;e:Power4.easeInOut;"
                             data-transform_out="y:[100%];s:1000;e:Power2.easeInOut;s:1000;e:Power2.easeInOut;" data-mask_in="x:0px;y:0px;" data-mask_out="x:inherit;y:inherit;" data-start="1000" data-splitin="chars" data-splitout="none" data-responsive_offset="on"
                             data-elementdelay="0.05" style="z-index: 5; white-space: nowrap;">NOW IS THE TIME</div>
                        <!-- LAYER NR. 2 -->
                        <div class="tp-caption tp-resizeme rs-parallaxlevel-2 c-font-white" id="slide-17-layer-4" data-x="['center','center','center','center']" data-hoffset="['0','0','0','0']" data-y="['middle','middle','middle','middle']" data-voffset="['52','52','52','51']"
                             data-width="none" data-height="none" data-whitespace="nowrap" data-transform_idle="o:1;" data-transform_in="y:[100%];z:0;rX:0deg;rY:0;rZ:0;sX:1;sY:1;skX:0;skY:0;opacity:0;s:2000;e:Power4.easeInOut;" data-transform_out="y:[100%];s:1000;e:Power2.easeInOut;s:1000;e:Power2.easeInOut;"
                             data-mask_in="x:0px;y:[100%];" data-mask_out="x:inherit;y:inherit;" data-start="1500" data-splitin="none" data-splitout="none" data-responsive_offset="on" style="z-index: 6; white-space: nowrap;">To Change Your Financial Condition!</div>
                    </li>
                    <!-- END -->
                    <!-- SLIDE #3  -->
                    <li data-index="rs-20" data-transition="zoomin" data-slotamount="7" data-easein="Power4.easeInOut" data-easeout="Power4.easeInOut" data-masterspeed="2000" data-thumb="{{ asset('web-assets/img/29.jpg') }}" data-rotate="0" data-saveperformance="off"
                        data-title="Love it?" data-description="">
                        <!-- MAIN IMAGE -->
                        <img src="{{ asset('web-assets/img/29.jpg') }}" alt="" data-bgposition="center center" data-kenburns="on" data-duration="15000" data-ease="Linear.easeNone" data-scalestart="100" data-scaleend="120" data-rotatestart="0"
                             data-rotateend="0" data-offsetstart="0 -500" data-offsetend="0 500" data-bgparallax="10" class="rev-slidebg" data-no-retina>
                        <!-- LAYERS -->
                        <!-- LAYER NR. 1 -->
                        <div class="tp-caption tp-resizeme rs-parallaxlevel-3 c-font-white c-font-bold" id="slide-20-layer-1" data-x="['center','center','center','center']" data-hoffset="['0','0','0','0']" data-y="['middle','middle','middle','middle']"
                             data-voffset="['0','0','0','0']" data-fontsize="['70','70','70','45']" data-lineheight="['70','70','70','50']" data-width="none" data-height="none" data-whitespace="nowrap" data-transform_idle="o:1;" data-transform_in="x:[-105%];z:0;rX:0deg;rY:0deg;rZ:-90deg;sX:1;sY:1;skX:0;skY:0;s:2000;e:Power4.easeInOut;"
                             data-transform_out="y:[100%];s:1000;e:Power2.easeInOut;s:1000;e:Power2.easeInOut;" data-mask_in="x:0px;y:0px;s:inherit;e:inherit;" data-mask_out="x:inherit;y:inherit;s:inherit;e:inherit;" data-start="1000" data-splitin="chars"
                             data-splitout="none" data-responsive_offset="on" data-elementdelay="0.1" style="z-index: 5; white-space: nowrap;">BUSINESS FOR ALL </div>
                        <!-- LAYER NR. 2 -->
                        <div class="tp-caption tp-resizeme rs-parallaxlevel-2 c-font-white" id="slide-20-layer-4" data-x="['center','center','center','center']" data-hoffset="['0','0','0','0']" data-y="['middle','middle','middle','middle']" data-voffset="['52','52','52','51']"
                             data-width="none" data-height="none" data-whitespace="nowrap" data-transform_idle="o:1;" data-transform_in="y:[100%];z:0;rX:0deg;rY:0;rZ:0;sX:1;sY:1;skX:0;skY:0;opacity:0;s:2000;e:Power4.easeInOut;" data-transform_out="y:[100%];s:1000;e:Power2.easeInOut;s:1000;e:Power2.easeInOut;"
                             data-mask_in="x:0px;y:[100%];s:inherit;e:inherit;" data-mask_out="x:inherit;y:inherit;s:inherit;e:inherit;" data-start="1500" data-splitin="none" data-splitout="none" data-responsive_offset="on" style="z-index: 6; white-space: nowrap;"> </div>
                        <!-- LAYER NR. 3 -->
                        <div class="tp-caption tp-resizeme rs-parallaxlevel-5" id="slide-20-layer-8" data-x="['center','center','center','center']" data-hoffset="['0','0','0','0']" data-y="['middle','middle','middle','middle']" data-voffset="['105','105','105','105']"
                             data-width="none" data-height="none" data-whitespace="nowrap" data-transform_idle="o:1;" data-style_hover="cursor:default;" data-transform_in="y:[100%];z:0;rX:0deg;rY:0;rZ:0;sX:1;sY:1;skX:0;skY:0;opacity:0;s:1500;e:Power4.easeInOut;"
                             data-transform_out="y:[100%];s:1000;e:Power2.easeInOut;s:1000;e:Power2.easeInOut;" data-mask_in="x:0px;y:[100%];s:inherit;e:inherit;" data-mask_out="x:inherit;y:inherit;s:inherit;e:inherit;" data-start="2000" data-splitin="none"
                             data-splitout="none" data-responsive_offset="on" style="z-index: 7; white-space: nowrap;">
                            <a href="#" class="c-action-btn btn btn-lg c-btn-square c-theme-btn c-btn-bold c-btn-uppercase">Join NuLife Now!</a>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </section>
    <!-- END: LAYOUT/SLIDERS/REVO-SLIDER-14 -->
    <!-- BEGIN: CONTENT/FEATURES/FEATURES-8 -->
    <div class="c-content-box c-size-md c-bg-white">
        <div class="container">
            <div class="c-content-feature-10">
                <!-- Begin: Title 1 component -->
                <div class="c-content-title-1">
                    <h3 class="c-font-uppercase c-center c-font-bold">Chase The Vision With Us</h3>
                    <div class="c-line-center c-theme-bg"></div>
                    <p class="c-font-center c-font-thin">If you are wondering, your financial condition is 5 years away or 10 years away, see how you prioritize your current money.</p>
                    <p class="c-font-center c-font-thin">No success is achieved only by dreams. All success must be realized in a plan. If you want to succeed in finance, want to achieve financial freedom, then you need to have a plan. A plan that can lead you to realize your financial goals and achieve financial freedom. This step is the first step you can take to achieve your financial goals. Start thinking about your plan to achieve financial freedom from now on.</p>
                </div>
                <!-- End-->
            </div>
        </div>
    </div>
    <!-- END: CONTENT/FEATURES/FEATURES-8 -->
    <!-- BEGIN: CONTENT/FEATURES/FEATURES-15-2 -->
    <div id="feature-15-2" class="c-content-feature-15 c-bg-img-center" style="background-image: url({{ asset('web-assets/img/bg-11.jpg') }})">
        <div class="container">
            <div class="row">
                <div class="col-md-offset-5 col-md-7 col-xs-12">
                    <div class="c-feature-15-container c-bg-dark">
                        <h2 class="c-feature-15-title c-font-bold c-font-uppercase c-theme-border c-font-white">NuLife Works around the clock</h2>
                        <div class="row">
                            <div class="col-md-10 col-xs-12">
                                <p class="c-feature-15-desc c-font-grey"> A wise person knows where and when to expand their mindset to achieve financial freedom.</p>
                                <a class="c-feature-15-btn btn c-btn btn-lg c-theme-btn c-font-uppercase c-btn-circle c-font-bold c-btn-square"
                                   href="#" alt="Join NuLife Now">Join NuLife Now</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- END: CONTENT/FEATURES/FEATURES-15-2 -->
    <!-- BEGIN: CONTENT/STATS/COUNTER-1 -->
    <div class="c-content-box c-size-md c-bg-white">
        <div class="container">
            <div class="c-content-counter-1 c-opt-1">
                <div class="c-content-title-1">
                    <h3 class="c-center c-font-uppercase c-font-bold">Our Best Plan Suitable for You</h3>
                    <div class="c-line-center"></div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="c-counter c-theme-border c-font-bold c-theme-font" data-counter="counterup">Plan-A</div>
                    </div>
                    <div class="col-md-4">
                        <div class="c-counter c-theme-border c-font-bold c-theme-font" data-counter="counterup">Plan-B</div>
                    </div>
                    <div class="col-md-4">
                        <div class="c-counter c-theme-border c-font-bold c-theme-font" data-counter="counterup">Plan-C</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- END: CONTENT/STATS/COUNTER-1 -->
    <!-- BEGIN: CONTENT/FEATURES/FEATURES-16-2 -->
    <div id="feature-16-2" class="c-content-feature-16 c-bg-img-center" style="background-image: url({{ asset('web-assets/img/104.jpg') }})">
        <div class="container">
            <div class="row">
                <div class="col-md-5 col-xs-12">
                    <div class="c-feature-16-container c-bg-dark c-bg-opacity-4">
                        <div class="c-feature-16-line c-theme-bg"></div>
                        <h2 class="c-feature-16-title c-font-bold c-font-uppercase c-font-white">High Quality Products</h2>
                        <p class="c-feature-16-desc c-font-grey"> Nulife unites the traditional elements of indigenous Indonesians into NuLife products, and produces excellent products. Such as: NuLife Green Coffe, NuLive Rejuvenate, NuLife Moringga, and NuLife Detox Tea.</p>
                        <!-- <a class="c-feature-15-btn btn c-btn btn-lg c-theme-btn c-font-uppercase c-font-bold c-btn-square" href="https://themeforest.net/item/NuLife-highly-flexible-component-based-html5-template/11987314"
                        alt="Purchase NuLife">Purchase Now</a> -->
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- END: CONTENT/FEATURES/FEATURES-16-2 -->
    <!-- BEGIN: CONTENT/SLIDERS/CLIENT-LOGOS-2 -->
    <div class="c-content-box c-size-md c-bg-white">
        <div class="container">
            <!-- Begin: Testimonals 1 component -->
            <div class="c-content-client-logos-slider-1  c-bordered" data-slider="owl">
                <!-- Begin: Title 1 component -->
                <div class="c-content-title-1">
                    <h3 class="c-center c-font-uppercase c-font-bold">Success Stories</h3>
                    <div class="c-line-center c-theme-bg"></div>
                </div>
                <!-- End-->
                <!-- Begin: Owlcarousel -->
                <div class="owl-carousel owl-theme c-theme owl-bordered1 c-owl-nav-center" data-items="6" data-desktop-items="4" data-desktop-small-items="3" data-tablet-items="3" data-mobile-small-items="2" data-slide-speed="5000" data-rtl="false">
                    <div class="item">
                        <a href="#">
                            <img src="assets/base/img/content/client-logos/client1.jpg" alt="" />
                        </a>
                    </div>
                    <div class="item">
                        <a href="#">
                            <img src="assets/base/img/content/client-logos/client2.jpg" alt="" />
                        </a>
                    </div>
                    <div class="item">
                        <a href="#">
                            <img src="assets/base/img/content/client-logos/client3.jpg" alt="" />
                        </a>
                    </div>
                    <div class="item">
                        <a href="#">
                            <img src="assets/base/img/content/client-logos/client4.jpg" alt="" />
                        </a>
                    </div>
                    <div class="item">
                        <a href="#">
                            <img src="assets/base/img/content/client-logos/client5.jpg" alt="" />
                        </a>
                    </div>
                    <div class="item">
                        <a href="#">
                            <img src="assets/base/img/content/client-logos/client6.jpg" alt="" />
                        </a>
                    </div>
                    <div class="item">
                        <a href="#">
                            <img src="assets/base/img/content/client-logos/client5.jpg" alt="" />
                        </a>
                    </div>
                    <div class="item">
                        <a href="#">
                            <img src="assets/base/img/content/client-logos/client6.jpg" alt="" />
                        </a>
                    </div>
                    <div class="item">
                        <a href="#">
                            <img src="assets/base/img/content/client-logos/client5.jpg" alt="" />
                        </a>
                    </div>
                    <div class="item">
                        <a href="#">
                            <img src="assets/base/img/content/client-logos/client6.jpg" alt="" />
                        </a>
                    </div>
                    <div class="item">
                        <a href="#">
                            <img src="assets/base/img/content/client-logos/client5.jpg" alt="" />
                        </a>
                    </div>
                    <div class="item">
                        <a href="#">
                            <img src="assets/base/img/content/client-logos/client6.jpg" alt="" />
                        </a>
                    </div>
                </div>
                <!-- End-->
            </div>
            <!-- End-->
        </div>
    </div>
    <!-- END: CONTENT/SLIDERS/CLIENT-LOGOS-2 -->
    <!-- END: PAGE CONTENT -->
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
    @if (is_string($pesanan))
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
@endif
</body>

</html>