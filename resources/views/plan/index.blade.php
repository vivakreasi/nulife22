@extends('layouts.main')

@section('header')
    @include('layouts.header')
@endsection

@section('vendor_style')
    <link href="{{ asset('assets/css/vendor/all.min.css') }}" rel="stylesheet" />
@endsection

@section('custom_style')
    <style>
        .modal-dialog{
            overflow-y: initial !important
        }
        .modal-body{
            overflow-y: auto;
        }
    </style>
@endsection

@section('content')
    <div id="fb-root"></div>
    <script>(function(d, s, id) {
            var js, fjs = d.getElementsByTagName(s)[0];
            if (d.getElementById(id)) return;
            js = d.createElement(s); js.id = id;
            js.src = "//connect.facebook.net/en_GB/sdk.js#xfbml=1&version=v2.9&appId=1857754324487852";
            fjs.parentNode.insertBefore(js, fjs);
        }(document, 'script', 'facebook-jssdk'));</script>

<div class="row">
    <div class="col-md-6">
        <section class="panel">
            <div class="panel-body">
                <div class="user-desk">
                    <div class="avatar">
                        <img src="{{ asset('assets/img/icon_' . Auth::user()->getRanking('code') . '.png') }}" alt="">
                    </div>
                    <h5 class="text-uppercase"><i class="icon-badge"></i> {{ Auth::user()->getRanking('desc') }}</h5>
                    <h4 class="text-uppercase">{{ Auth::user()->name }}</h4>
                    <h5>
                        {{ Auth::user()->userid }}
                        @if (Auth::user()->isStockis())
                            <span class="label label-info">{{ (Auth::user()->is_stockis == 2) ? 'Master Stockist' : 'Stockist' }}</span>
                        @endif
                    </h5>
                    <span>Your Referral link : <a>https://www.nulife.co.id/r/{{ Auth::user()->userid }}</a></span>
                    <div class="s-n">
                        <div class="fb-share-button" data-href="https://www.nulife.co.id/r/{{ Auth::user()->userid }}" data-layout="button" data-size="small" data-mobile-iframe="true"><a class="fb-xfbml-parse-ignore" target="_blank" href="https://www.facebook.com/sharer/sharer.php?u=https%3A%2F%2Fdevelopers.facebook.com%2Fdocs%2Fplugins%2F&amp;src=sdkpreparse">Share</a></div>
                    </div>
                    <ul class="user-p-list">
                        <li>
                            <a>Plan Status :<br />
                                <h4>
                                    Plan-A&nbsp;<i class="icon-check green-color"></i>
                                    Plan-B&nbsp;<i class="{{ Auth::user()->isPlanB() ? 'icon-check green-color' : 'icon-close red-color' }}"></i>
                                    Plan-C&nbsp;<i class="{{ Auth::user()->isPlanC() ? 'icon-check green-color' : 'icon-close red-color' }}"></i>
                                </h4>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </section>
    </div>
    <div class="col-md-6">
        <div class="row state-overview">
            <div class="col-md-6">
                <section class="panel ">
                    <div class="symbol purple-color">
                        Sponsor
                    </div>
                    <div class="value gray">
                        <h4 class="purple-color" style="text-overflow: ellipsis; white-space: nowrap; overflow: hidden;">{{ Auth::user()->getSponsor('name') }}</h4>
                        <p>{{ Auth::user()->getSponsor('userid') }}</p>
                    </div>
                </section>
            </div>
            <div class="col-md-6">
                <section class="panel purple">
                    <div class="symbol">
                        <i class="fa fa-sitemap"></i>
                    </div>
                    <div class="value white">
                        <h1 class="timer" data-from="0" data-to="{{ $summary->sponsored->Activated + $summary->sponsored->UnActivated }}" data-speed="4000">{{ number_format($summary->sponsored->Activated + $summary->sponsored->UnActivated, 0, '.', ',') }}</h1>
                        <p>Direct Sponsor</p>
                    </div>
                </section>
            </div>
            <div class="col-md-6">
                <section class="panel blue">
                    <div class="symbol">
                        <i class="fa fa-sitemap"></i>
                    </div>
                    <div class="value white">
                        <h1 class="timer" data-from="0" data-to="{{ Auth::user()->getCountLeftStructure() }}" data-speed="4000">{{ number_format(Auth::user()->getCountLeftStructure(), 0, '.', ',') }}</h1>
                        <p>LEFT leg</p>
                    </div>
                </section>
            </div>
            <div class="col-md-6">
                <section class="panel ">
                    <div class="symbol blue-color">
                        <i class="fa fa-sitemap"></i>
                    </div>
                    <div class="value gray">
                        <h1 class="blue-color timer" data-from="0" data-to="{{ Auth::user()->getCountRightStructure() }}" data-speed="4000">{{ number_format(Auth::user()->getCountRightStructure(), 0, '.', ',') }}</h1>
                        <p>RIGHT leg</p>
                    </div>
                </section>
            </div>
            <div class="col-md-6">
                <section class="panel">
                    <div class="symbol green-color">
                        <i class="fa fa-money"></i>
                    </div>
                    <div class="value gray">
                        <h4 class="green-color timer" data-from="0" data-to="{{ Auth::user()->getTotalNewCash() }}" data-speed="4000">{{ number_format(Auth::user()->getTotalNewCash(), 0, '.', ',') }}</h4>
                        <p>NuCash (IDR)</p>
                    </div>
                </section>
            </div>
            <div class="col-md-6">
                <section class="panel green">
                    <div class="symbol">
                        <i class="fa fa-money"></i>
                    </div>
                    <div class="value white">
                        <h4 class="timer" data-from="0" data-to="{{ Auth::user()->getTotalNewPoint() }}" data-speed="4000">Rp {{ number_format(Auth::user()->getTotalNewPoint(), 0, '.', ',') }},-</h4>
                        <p>NuPoint (IDR)</p>
                    </div>
                </section>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-6">
        <section class="panel">
            <header class="panel-heading head-border">
                <h4>Latest News</h4>
            </header>
        </section>
    </div>
    <div class="col-md-6">
        <section class="panel">
            <header class="panel-heading head-border">
                <h4>Network Summary Level 1 to Level 10</h4>
            </header>
            <div class="noti-information notification-menu">
                <div class="notification-list mail-list not-list">
                    @foreach($summary->summary10Level as $key => $value)
                        <a href="javascript:;" class="single-mail">
                            @if($value==pow(2,$key))
                                <span class="icon bg-success">
                                L-{{ $key }}
                                </span>
                                <h5><strong>Yeay!</strong> level-{{ $key }} is <span class="purple-color">Fulfilled (<strong>{{ $value }}</strong> members)</span></h5>
                                <span class="read tooltips" data-original-title="Good Job" data-placement="left">
                                    <i class="fa fa-circle green-color"></i>
                                </span>
                            @else
                                @if($value/pow(2,$key)>=0.5)
                                    <span class="icon bg-info">
                                    L-{{ $key }}
                                    </span>
                                    <h5>You've reach <span class="purple-color"><strong>{{ $value }}</strong> members</span>, it should be <strong>{{ pow(2,$key) }}</strong> members</h5>
                                    <span class="read tooltips" data-original-title="You can do it!" data-placement="left">
                                    <i class="fa fa-circle-o yellow-color"></i>
                                </span>
                                @else
                                    <span class="icon bg-warning">
                                    L-{{ $key }}
                                    </span>
                                    <h5>You've reach <span class="purple-color"><strong>{{ $value }}</strong> members</span>, it should be <strong>{{ pow(2,$key) }}</strong> members</h5>
                                    <span class="read tooltips" data-original-title="Come on... You can do it!" data-placement="left">
                                    <i class="fa fa-circle-o red-color"></i>
                                </span>
                                @endif
                            @endif
                        </a>
                    @endforeach
                </div>
            </div>
        </section>
        {{--<section class="panel">--}}
            {{--<header class="panel-heading head-border">--}}
                {{--<h4>Network Summary Level 1 to Level 10</h4>--}}
            {{--</header>--}}
            {{--<div class="time-line-wrapper m-t-20">--}}
                {{--@foreach($summary->summary10Level as $key => $value)--}}
                    {{--<article class="time-line-row">--}}
                        {{--<div class="time-line-info">--}}
                            {{--<div class="panel" style="margin-bottom:5px;">--}}
                                {{--<div class="panel-body">--}}
                                    {{--<span class="arrow"></span>--}}
                                    {{--<span class="time-line-ico-box purple"></span>--}}
                                    {{--<span class="time-line-subject green" style="font-size:18px;"> <i class="fa fa-users"></i> Level-{{ $key }}</span>--}}
                                    {{--<div class="title" style="margin-bottom:5px; padding-bottom:5px;">--}}
                                        {{--<h1>{{ number_format($value, 0, '.', ',') }}</h1>--}}
                                    {{--</div>--}}
                                {{--</div>--}}
                            {{--</div>--}}
                        {{--</div>--}}
                    {{--</article>--}}
                {{--@endforeach--}}
            {{--</div>--}}
        {{--</section>--}}
    </div>
</div>
<?php // @include('plan.bermasalah') ?>
@if($news->view == true)
    @include('plan.news')
@endif
@endsection

@section('scripts')
    <script src="{{ asset('assets/js/vendor/sparkline/jquery.sparkline.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/js/vendor/jquery.countTo.min.js') }}"  type="text/javascript"></script>
    <script src="{{ asset('assets/js/icheck.min.js') }}"  type="text/javascript"></script>
    <script type="text/javascript">
        $(document).ready(function(){
            //if($.cookie("popup_member_bermasalah") != 'yes'){
            @if($news->view == true)
                $(".modal-body").css("max-height", screen.height * .60);
                $("#memberMasalah").modal("show");
            @endif
            //}

            $('.timer').countTo({
                formatter: function (value, options) {
                    value = value.toFixed(options.decimals);
                    value = value.replace(/\B(?=(\d{3})+(?!\d))/g, '.');
                    return value;
                }
            });
        });

        $(document).on("click", "#closeModal", function () {
            $.cookie("popup_member_bermasalah", "yes");
        });

        $(document).on("click", ".close", function () {
            $.cookie("popup_member_bermasalah", "yes");
        });

        @if (isset($page_header->gnetworkgrowth) && $page_header->gnetworkgrowth != '')
            $("#gnetworkgrowth").sparkline([{!! $page_header->gnetworkgrowth !!}], {
                type: 'bar',
                height: '32',
                barWidth: 5,
                barSpacing: 2,
                barColor: '#c5c5ca'
            });
        @endif

        @if (isset($page_header->gbonusearn) && $page_header->gbonusearn != '')
            $("#gbonusearn").sparkline([{!! $page_header->gbonusearn !!}], {
                type: 'bar',
                height: '32',
                barWidth: 5,
                barSpacing: 2,
                barColor: '#c5c5ca'
            });
        @endif
    </script>
@endsection

