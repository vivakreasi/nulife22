<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="author" content="" />
    <meta name="keyword" content="" />
    <meta name="description" content="" />
    <link rel="shortcut icon" href="{{ asset('assets/img/favicon_.ico') }}" />

    <title>{{ config('app.name', 'nulife.co.id - member area') }}</title>

<!--vendors-->
    <link href="{{ asset('assets/css/vendor/jquery-ui-custom.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/css/vendor/owl.carousel.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/vendor/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/vendor/bootstrap-reset.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/vendor/jquery-ui-custom.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/vendor/font-awesome.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/vendor/simple-line-icons.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/vendor/toastr.min.css') }}" rel="stylesheet" type="text/css" />

@yield('vendor_style')

<!--nulife-->
    <link href="{{ asset('assets/css/nulife-theme.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/style-new.min.css') }}" rel="stylesheet">

@yield('custom_style')

<!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html5shiv/3.7.3/html5shiv.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

    <!-- Scripts -->
    <script>
        window.Laravel = {!! json_encode([
            'csrfToken' => csrf_token(),
        ]) !!};
    </script>
</head>

<body class="sticky-header">

<?php $myUser = Auth::user(); ?>

<section>
    <!-- sidebar left start-->
    <div class="sidebar-left sticky-sidebar">
        <!--responsive view logo start-->
        <div class="logo dark-logo-bg visible-xs-* visible-sm-*">
            <a href="#">
                <img src="{{ asset('assets/img/logoicon-biru.png') }}" alt="nulife icon logo">
                <span class="brand-name">NuLife</span>
            </a>
        </div>
        <!--responsive view logo end-->

        <div class="sidebar-left-info">
            <!-- visible small devices start-->
            <div class=" search-field">  </div>
            <!-- visible small devices end-->

            <!--sidebar nav start-->
            @if ($isLoggedIn)
                <ul class="nav nav-pills nav-stacked side-navigation">
                    <li>
                        <h3 class="navigation-title">Navigations</h3>
                    </li>
                    <li {!! (in_array(Route::currentRouteName(), ['dashboard', 'admin']) ? 'class=active' : '') !!}>
                        @if ($isAdmin)
                            <a href="{{ route('admin') }}"><i class="fa fa-dashboard"></i> <span>Dashboard</span></a>
                        @else
                            <a href="{{ route('dashboard') }}"><i class="fa fa-dashboard"></i> <span>Dashboard</span></a>
                        @endif
                    </li>
                    @if ($isAdmin)
                        @if ($myUser->hasAccessRoute('admin.plan.upgrade') || $myUser->hasAccessRoute('admin.plan.reward') ||
                            $myUser->hasAccessRoute('admin.nucash.wd.list') || $myUser->hasAccessRoute('pin.list') || 
                            $myUser->hasAccessRoute('admin.pin.list') || $myUser->hasAccessRoute('admin.member.not.wd.list') || 
                            $myUser->hasAccessRoute('admin.partner.become'))
                        <li class="menu-list
                        <?php // {!! (in_array(Route::currentRouteName(), ['admin.plan.upgrade', 'admin.plan.reward', 'admin.nucash.wd.list','admin.inventory.claima','admin.inventory.claimb','pin.list','pin.invoice','admin.pin.list','admin.member.list','admin.member.not.wd.list','admin.partner.become','admin.partner.list','admin.pin.report', 'admin.report.reward.global',  'admin.report.bonus.global']) ? 'active' : '') !!}"> ?>
                        {!! (in_array(Route::currentRouteName(), ['admin.plan.upgrade', 'admin.plan.reward', 'admin.nucash.wd.list','pin.list','pin.invoice','admin.pin.list','admin.member.list','admin.member.genealogy','admin.planbmember.list','admin.member.not.wd.list','admin.partner.become','admin.partner.list','admin.pin.report', 'admin.report.reward.global', 'admin.report.bonus.global', 'admin.member.leftright', 'plan.placement.b']) ? 'active' : '') !!}">
                            <a href=""><i class="fa fa-exchange"></i>  <span>Plan-A/B Panel</span></a>
                            <ul class="child-list">
                                @if ($myUser->hasAccessRoute('admin.plan.upgrade'))
                                    <li {!! (Route::currentRouteName()=='admin.plan.upgrade' ? 'class=active' : '') !!}><a href="{{ route('admin.plan.upgrade') }}"> List Request Upgrade</a></li>
                                @endif
                                @if ($myUser->hasAccessRoute('admin.plan.reward'))
                                    <li {!! (Route::currentRouteName()=='admin.plan.reward' ? 'class=active' : '') !!}><a href="{{ route('admin.plan.reward') }}"> List Claim Reward</a></li>
                                @endif
                                @if ($myUser->hasAccessRoute('admin.nucash.wd.list'))
                                    <li {!! (Route::currentRouteName()=='admin.nucash.wd.list' ? 'class=active' : '') !!}><a href="{{ route('admin.nucash.wd.list') }}"> List Withdrawal Plan A/B</a></li>
                                @endif
                                @if ($myUser->hasAccessRoute('pin.list') || $myUser->hasAccessRoute('admin.pin.list') || $myUser->hasAccessRoute('admin.pin.report'))
                                    <li class="">
                                        <h3 class="navigation-title" style="padding-left: 50px !important;">A-PIN</h3>
                                    </li>
                                    @if ($myUser->hasAccessRoute('pin.list'))
                                        <li {!! (Route::currentRouteName()=='pin.list' || Route::currentRouteName()=='pin.invoice' ? 'class=active' : '') !!}><a href="{{ route('pin.list') }}"> List Buy Pin</a></li>
                                    @endif
                                    @if ($myUser->hasAccessRoute('admin.pin.list'))
                                        <li {!! (Route::currentRouteName()=='admin.pin.list' ? 'class=active' : '') !!}><a href="{{ route('admin.pin.list') }}"> Summary Activation PIN</a></li>
                                    @endif
                                    @if ($myUser->hasAccessRoute('admin.pin.report'))
                                        <li {!! (Route::currentRouteName()=='admin.pin.report' ? 'class=active' : '') !!}><a href="{{ route('admin.pin.report') }}"> Report PIN</a></li>
                                    @endif
                                @endif
								
							

    @if ($myUser->hasAccessRoute('pinb.list') || $myUser->hasAccessRoute('admin.pinb.list') || $myUser->hasAccessRoute('admin.pinb.report'))
                                    <li class="">
                                        <h3 class="navigation-title" style="padding-left: 50px !important;">B-PIN</h3>
                                    </li>
                                    @if ($myUser->hasAccessRoute('pinb.list'))
                                        <li {!! (Route::currentRouteName()=='pinb.list' || Route::currentRouteName()=='pinb.invoice' ? 'class=active' : '') !!}><a href="{{ route('pin.list') }}"> List Buy Pin</a></li>
                                    @endif
                                    @if ($myUser->hasAccessRoute('admin.pin.list'))
                                        <li {!! (Route::currentRouteName()=='admin.pinb.list' ? 'class=active' : '') !!}><a href="{{ route('admin.pinb.list') }}"> Summary Activation PIN</a></li>
                                    @endif
                                    @if ($myUser->hasAccessRoute('admin.pin.report'))
                                        <li {!! (Route::currentRouteName()=='admin.pinb.report' ? 'class=active' : '') !!}><a href="{{ route('admin.pinb.report') }}"> Report PIN</a></li>
                                    @endif
                                @endif
								
														
								
								
								
							
								
								
                                @if ($myUser->hasAccessRoute('admin.member.list') || $myUser->hasAccessRoute('admin.member.not.wd.list') ||
                                    $myUser->hasAccessRoute('admin.report.reward.global') || $myUser->hasAccessRoute('admin.report.bonus.global') ||
                                    $myUser->hasAccessRoute('admin.member.leftright'))
                                    <li class="">
                                        <h3 class="navigation-title" style="padding-left: 50px !important;">Member</h3>
                                    </li>
                                    @if ($myUser->hasAccessRoute('admin.member.list'))
                                        <li {!! (Route::currentRouteName()=='admin.member.list' || Route::currentRouteName()=='admin.member.genealogy' ? 'class=active' : '') !!}><a href="{{ route('admin.member.list') }}"> All Member</a></li>
                                    @endif
                                    @if ($myUser->hasAccessRoute('admin.member.list'))
                                        <li {!! (Route::currentRouteName()=='admin.planbmember.list' ? 'class=active' : '') !!}><a href="{{ route('admin.planbmember.list') }}"> Plan-B Member</a></li>
                                <li {!! (Route::currentRouteName()=='plan.placement.b' ? 'class=active' : '') !!}><a href="{{ route('plan.placement.b') }}"> Placement Plan-B Member</a></li>
                                    @endif
                                    @if ($myUser->hasAccessRoute('admin.member.leftright'))
                                        <li {!! (Route::currentRouteName()=='admin.member.leftright' ? 'class=active' : '') !!}><a href="{{ route('admin.member.leftright') }}"> All Member<br /><small><em>(Left Right)</em></small></a></li>
                                    @endif
                                    @if ($myUser->hasAccessRoute('admin.member.not.wd.list'))
                                        <li {!! (Route::currentRouteName()=='admin.member.not.wd.list' ? 'class=active' : '') !!}><a href="{{ route('admin.member.not.wd.list') }}"> Bonus Member</a></li>
                                    @endif
                                    @if ($myUser->hasAccessRoute('admin.report.reward.global'))
                                        <li {!! (Route::currentRouteName()=='admin.report.reward.global' ? 'class=active' : '') !!}><a href="{{ route('admin.report.reward.global') }}"> Report Reward Global</a></li>
                                    @endif
                                    @if ($myUser->hasAccessRoute('admin.report.bonus.global'))
                                        <li {!! (Route::currentRouteName()=='admin.report.bonus.global' ? 'class=active' : '') !!}><a href="{{ route('admin.report.bonus.global') }}"> Report Bonus Global</a></li>
                                    @endif
                                @endif
                                @if ($myUser->hasAccessRoute('admin.partner.become') || $myUser->hasAccessRoute('admin.partner.list'))
                                    <li class="">
                                        <h3 class="navigation-title" style="padding-left: 50px !important;">Partner</h3>
                                    </li>
                                    @if ($myUser->hasAccessRoute('admin.partner.list'))
                                        <li {!! (Route::currentRouteName() == 'admin.partner.list') ? 'class=active' : '' !!}><a href="{{ route('admin.partner.list') }}"> List</a></li>
                                    @endif
                                    @if ($myUser->hasAccessRoute('admin.partner.become'))
                                        <li {!! (Route::currentRouteName() == 'admin.partner.become') ? 'class=active' : '' !!}><a href="{{ route('admin.partner.become') }}"> Request</a></li>
                                    @endif
                                @endif
                            </ul>
                        </li>
                        @endif
                        @if ($myUser->hasAccessRoute('admin.pinc.order') || $myUser->hasAccessRoute('admin.pinc.order.address') ||
                            $myUser->hasAccessRoute('admin.planc.wd') || $myUser->hasAccessRoute('admin.planc.wd.report') ||
                            $myUser->hasAccessRoute('admin.planc.wd.leadership') || $myUser->hasAccessRoute('admin.planc.wd.leadership.report') ||
                            $myUser->hasAccessRoute('admin.planc.join.report'))
                        <li class="menu-list
                        {!! (in_array(Route::currentRouteName(), ['admin.pinc.order', 'admin.pinc.order.address', 'admin.planc.wd', 'admin.planc.wd.report', 'admin.planc.join.report', 'admin.planc.wd.leadership', 'admin.planc.wd.leadership.report','admin.inventory.claimc']) ? 'active' : '') !!}">
                            <a href=""><i class="fa fa-exchange"></i>  <span>Plan-C Panel</span></a>
                            <ul class="child-list">
                                @if ($myUser->hasAccessRoute('admin.pinc.order'))
                                    <li {!! (Route::currentRouteName()=='admin.pinc.order' ? 'class=active' : '') !!}><a href="{{ route('admin.pinc.order') }}"> List Order Plan-C</a></li>
                                @endif
                                @if ($myUser->hasAccessRoute('admin.pinc.order.address'))
                                    <li {!! (Route::currentRouteName()=='admin.pinc.order.address' ? 'class=active' : '') !!}><a href="{{ route('admin.pinc.order.address') }}"> List Order Plan-C<br /><small><em>(With Address)</em></small></a></li>
                                @endif
                                @if ($myUser->hasAccessRoute('admin.planc.wd'))
                                    <li {!! (Route::currentRouteName()=='admin.planc.wd' ? 'class=active' : '') !!}><a href="{{ route('admin.planc.wd') }}"> List WD Plan-C</a></li>
                                @endif
                                @if ($myUser->hasAccessRoute('admin.planc.wd.report'))
                                    <li {!! (Route::currentRouteName()=='admin.planc.wd.report' ? 'class=active' : '') !!}><a href="{{ route('admin.planc.wd.report') }}"> Report WD Plan-C</a></li>
                                @endif
                                @if ($myUser->hasAccessRoute('admin.planc.wd.leadership'))
                                    <li {!! (Route::currentRouteName()=='admin.planc.wd.leadership' ? 'class=active' : '') !!}><a href="{{ route('admin.planc.wd.leadership') }}"> List WD Ranking Bonus</a></li>
                                @endif
                                @if ($myUser->hasAccessRoute('admin.planc.wd.leadership.report'))
                                    <li {!! (Route::currentRouteName()=='admin.planc.wd.leadership.report' ? 'class=active' : '') !!}><a href="{{ route('admin.planc.wd.leadership.report') }}"> Report WD Ranking Bonus</a></li>
                                @endif
                                @if ($myUser->hasAccessRoute('admin.planc.join.report'))
                                    <li {!! (Route::currentRouteName()=='admin.planc.join.report' ? 'class=active' : '') !!}><a href="{{ route('admin.planc.join.report') }}"> Report Join Plan-C</a></li>
                                @endif
                                @if ($myUser->hasAccessRoute('admin.planc.claimc'))
                                    <li {!! (Route::currentRouteName() == 'admin.planc.claimc') ? 'class=active' : '' !!}><a href="{{ route('admin.planc.claimc') }}"> List Claim Product</a></li>
                                @endif
                            </ul>
                        </li>
                        @endif

                        {{--<li class="menu-list--}}
                    {{--{!! (in_array(Route::currentRouteName(), ['pin.invoice', 'admin.pin.list', 'pin.list', 'admin.pin.report']) ? 'active' : '') !!}">--}}
                            {{--<a href=""><i class="fa fa-ticket"></i>  <span>PIN</span></a>--}}
                            {{--<ul class="child-list">--}}
                                {{--<li {!! (Route::currentRouteName()=='pin.list' || Route::currentRouteName()=='pin.invoice' ? 'class=active' : '') !!}><a href="{{ route('pin.list') }}"> List Buy Pin</a></li>--}}
                                {{--<li {!! (Route::currentRouteName()=='admin.pin.list' || Route::currentRouteName()=='admin.pin.list' ? 'class=active' : '') !!}><a href="{{ route('admin.pin.list') }}"> Summary Activation PIN</a></li>--}}
                                {{--<li {!! (Route::currentRouteName()=='admin.pin.report' || Route::currentRouteName()=='admin.pin.report' ? 'class=active' : '') !!}><a href="{{ route('admin.pin.report') }}"> Report PIN</a></li>--}}
                            {{--</ul>--}}
                        {{--</li>--}}
                        {{--<li class="menu-list--}}
                    {{--{!! (in_array(Route::currentRouteName(), ['admin.member.list', 'admin.member.not.wd.list']) ? 'active' : '') !!}">--}}
                            {{--<a href=""><i class="fa fa-users"></i>  <span>Member</span></a>--}}
                            {{--<ul class="child-list">--}}
                                {{--<li {!! (Route::currentRouteName()=='admin.member.list' || Route::currentRouteName()=='admin.member.list' ? 'class=active' : '') !!}><a href="{{ route('admin.member.list') }}"> All Member</a></li>--}}
                                {{--<li {!! (Route::currentRouteName()=='admin.member.not.wd.list' || Route::currentRouteName()=='admin.member.not.wd.list' ? 'class=active' : '') !!}><a href="{{ route('admin.member.not.wd.list') }}"> Bonus Member</a></li>--}}
                            {{--</ul>--}}
                        {{--</li>--}}
                        {{--<li class="menu-list {!! (in_array(Route::currentRouteName(), ['admin.partner.list', 'admin.partner.become']) ? 'active' : '') !!}">--}}
                            {{--<a href=""><i class="fa fa-share-alt"></i>  <span>Partner</span></a>--}}
                            {{--<ul class="child-list">--}}
                            {{--</ul>--}}
                            {{--<ul class="child-list">--}}
                            {{--</ul>--}}

                        @if ($myUser->hasAccessRoute('admin.inventory.claimb') || $myUser->hasAccessRoute('admin.inventory.stock') ||
                            $myUser->hasAccessRoute('admin.inventory.stockadd'))
                            <li class="menu-list {!! (in_array(Route::currentRouteName(), ['admin.inventory.stock','admin.inventory.stockadd','admin.inventory.stockaddpost','admin.inventory.claimb']) ? 'active' : '') !!}">
                                <a href=""><i class="fa fa-truck"></i>  <span>Inventory</span></a>
                                <ul class="child-list">
                                    @if ($myUser->hasAccessRoute('admin.inventory.claimb'))
                                        <li {!! (Route::currentRouteName() == 'admin.inventory.claimb') ? 'class=active' : '' !!}><a href="{{ route('admin.inventory.claimb') }}"> Product Claim (Plan-B)</a></li>
                                    @endif
                                    @if ($myUser->hasAccessRoute('admin.inventory.stock'))
                                        <li {!! (Route::currentRouteName() == 'admin.inventory.stock') ? 'class=active' : '' !!}><a href="{{ route('admin.inventory.stock') }}"> Stocks</a></li>
                                    @endif
                                    @if ($myUser->hasAccessRoute('admin.inventory.stockadd'))
                                        <li {!! (in_array(Route::currentRouteName(), ['admin.inventory.stockadd','admin.inventory.stockaddpost']) ? 'class=active' : '') !!}><a href="{{ route('admin.inventory.stockadd') }}"> Stock Add</a></li>
                                    @endif
                                </ul>
                            </li>
                        @endif
                        @if ($myUser->isAdminAll())
                            <li class="">
                                <h3 class="navigation-title">SETTINGS</h3>
                            </li>
                            <li class="menu-list
                            {!! (in_array(Route::currentRouteName(), ['admin.plana.setting', 'admin.planb.setting', 'admin.planc.setting', 'admin.pin.setting', 'admin.pinb.setting', 'admin.partner.setting', 'admin.company.bank', 'admin.company.bank.add', 'admin.reward.setting', 'admin.reward.setting.add', 'admin.reward.setting.edit']) ? 'active' : '') !!}">
                                <a href=""><i class="fa fa-cogs"></i>  <span>General Settings</span></a>
                                <ul class="child-list">
                                    <li {!! (Route::currentRouteName()=='admin.plana.setting' ? 'class=active' : '') !!}><a href="{{ route('admin.plana.setting') }}"> Plan-A</a></li>
                                    <li {!! (Route::currentRouteName()=='admin.planb.setting' ? 'class=active' : '') !!}><a href="{{ route('admin.planb.setting') }}"> Plan-B</a></li>
                                    <li {!! (Route::currentRouteName()=='admin.planc.setting' ? 'class=active' : '') !!}><a href="{{ route('admin.planc.setting') }}"> Plan-C</a></li>
                                    <li {!! (Route::currentRouteName()=='admin.pin.setting' ? 'class=active' : '') !!}><a href="{{ route('admin.pin.setting') }}"> PIN-A</a></li>
                                    <li {!! (Route::currentRouteName()=='admin.pinb.setting' ? 'class=active' : '') !!}><a href="{{ route('admin.pinb.setting') }}"> PIN-B</a></li>
                                    
									<li {!! (Route::currentRouteName()=='admin.partner.setting' ? 'class=active' : '') !!}><a href="{{ route('admin.partner.setting') }}"> Partner</a></li>
                                    <li {!! in_array(Route::currentRouteName(), ['admin.reward.setting', 'admin.reward.setting.add', 'admin.reward.setting.edit']) ? 'class=active' : '' !!}><a href="{{ route('admin.reward.setting') }}"> Reward</a></li>
                                    <li {!! in_array(Route::currentRouteName(), ['admin.company.bank', 'admin.company.bank.add']) ? 'class=active' : '' !!}><a href="{{ route('admin.company.bank') }}"> Companie's Banks</a></li>
                                    <li {!! (Route::currentRouteName()=='admin.max.bank' ? 'class=active' : '') !!}><a href="{{ route('admin.max.bank') }}"> Maximum bank</a></li>
                                </ul>
                            </li>
                            <li class="menu-list {!! (in_array(Route::currentRouteName(), ['admin.inventory.metric','admin.inventory.metricformget','admin.inventory.metricformpost',
                            'admin.inventory.category','admin.inventory.categoryform','admin.inventory.categoryformpost',
                            'admin.inventory.item','admin.inventory.itemform','admin.inventory.itemformpost',
                            'admin.inventory.location','admin.inventory.locationform','admin.inventory.locationformpost',
                            'admin.inventory.supplier','admin.inventory.supplierform','admin.inventory.supplierformpost']) ? 'active' : '') !!}">
                                <a href=""><i class="fa fa-cogs"></i>  <span>Inventory Settings</span></a>
                                <ul class="child-list">
                                    <li {!! (in_array(Route::currentRouteName(), ['admin.inventory.metric','admin.inventory.metricform','admin.inventory.metricformpost']) ? 'class=active' : '') !!}><a href="{{ route('admin.inventory.metric') }}"> Metrics</a></li>
                                    <li {!! (in_array(Route::currentRouteName(), ['admin.inventory.category','admin.inventory.categoryform','admin.inventory.categoryformpost']) ? 'class=active' : '') !!}><a href="{{ route('admin.inventory.category') }}"> Categories</a></li>
                                    <li {!! (in_array(Route::currentRouteName(), ['admin.inventory.location','admin.inventory.locationform','admin.inventory.locationformpost']) ? 'class=active' : '') !!}><a href="{{ route('admin.inventory.location') }}"> Locations</a></li>
                                    <li {!! (in_array(Route::currentRouteName(), ['admin.inventory.supplier','admin.inventory.supplierform','admin.inventory.supplierformpost']) ? 'class=active' : '') !!}><a href="{{ route('admin.inventory.supplier') }}"> Suppliers</a></li>
                                    <li {!! (in_array(Route::currentRouteName(), ['admin.inventory.item','admin.inventory.itemform','admin.inventory.itemformpost']) ? 'class=active' : '') !!}><a href="{{ route('admin.inventory.item') }}"> Items</a></li>
                                </ul>
                            </li>
                        @endif
                    @else
                        <li class="menu-list
                    {!! (in_array(Route::currentRouteName(), ['plan.direct.sponsor', 'plan.placement', 'new.register']) ? 'active' : '') !!}">
                            <a href=""><i class="fa fa-users"></i>  <span>Member</span></a>
                            <ul class="child-list">
                                <li {!! (Route::currentRouteName()=='new.register' ? 'class=active' : '') !!}><a href="{{ route('new.register') }}"> Register New Member</a></li>
                                <li {!! (Route::currentRouteName()=='plan.direct.sponsor' ? 'class=active' : '') !!}><a href="{{ route('plan.direct.sponsor') }}"> Direct Sponsor</a></li>
                                <li {!! (Route::currentRouteName()=='plan.placement' ? 'class=active' : '') !!}><a href="{{ route('plan.placement') }}"> Placement New Member</a></li>
   <!--Add By Viva-->
                            
							<li {!! (Route::currentRouteName()=='new.register2' ? 'class=active' : '') !!}><a href="{{ route('new.register2') }}"> Register Plan B New Member</a></li>
                            
							</ul>
                        </li>
                        <li class="menu-list
                    {!! (in_array(Route::currentRouteName(), ['plan.network.binary', 'plan.network.level']) ? 'active' : '') !!}">
                            <a href=""><i class="fa fa-sitemap"></i>  <span>Network</span></a>
                            <ul class="child-list">
                                <li {!! (Route::currentRouteName()=='plan.network.binary' ? 'class=active' : '') !!}><a href="{{ route('plan.network.binary') }}"> Binary</a></li>
                                <li {!! (Route::currentRouteName()=='plan.network.level' ? 'class=active' : '') !!}><a href="{{ route('plan.network.level') }}"> Level</a></li>
                            </ul>
                        </li>
                        <li class="menu-list
                    {!! (in_array(Route::currentRouteName(), ['pin.my', 'pin.order', 'pin.list', 'pin.transfer', 'pin.invoice', 'pin.previous']) ? 'active' : '') !!}">
                            <a href=""><i class="fa fa-ticket"></i>  <span>A-PIN</span></a>
                            <ul class="child-list">
                                <li {!! (Route::currentRouteName()=='pin.my' ? 'class=active' : '') !!}><a href="{{ route('pin.my') }}"> My Pin</a></li>
                                <li {!! (Route::currentRouteName()=='pin.order' || Route::currentRouteName()=='pin.transfer' || Route::currentRouteName()=='pin.invoice' ? 'class=active' : '') !!}><a href="{{ route('pin.order') }}"> {{ (Auth::user()->isStockis() ? "Buy" : "Order") }}/Transfer Pin </a></li>
                                <li {!! (Route::currentRouteName()=='pin.list' ? 'class=active' : '') !!}><a href="{{ route('pin.list') }}"> List {{ (Auth::user()->isStockis() ? "Buy" : "Order") }}/Transfer Pin</a></li>
                                <li {!! (Route::currentRouteName()=='pin.previous' ? 'class=active' : '') !!}><a href="{{ route('pin.previous') }}"> List<br /><small><em>(Previous PIN)</em></small></a></li>
                            </ul>
                        </li>
						
						 <li class="menu-list
                    {!! (in_array(Route::currentRouteName(), ['pinb.my', 'pinb.order', 'pinb.list', 'pinb.transfer', 'pinb.invoice', 'pinb.previous']) ? 'active' : '') !!}">
                            <a href=""><i class="fa fa-ticket"></i>  <span>B-PIN</span></a>
                            <ul class="child-list">
                                <li {!! (Route::currentRouteName()=='pinb.my' ? 'class=active' : '') !!}><a href="{{ route('pinb.my') }}"> My Pin</a></li>
                                <li {!! (Route::currentRouteName()=='pinb.order' || Route::currentRouteName()=='pinb.transfer' || Route::currentRouteName()=='pinb.invoice' ? 'class=active' : '') !!}><a href="{{ route('pinb.order') }}"> {{ (Auth::user()->isStockis() ? "Buy" : "Order") }}/Transfer Pin </a></li>
                                <li {!! (Route::currentRouteName()=='pinb.list' ? 'class=active' : '') !!}><a href="{{ route('pinb.list') }}"> List {{ (Auth::user()->isStockis() ? "Buy" : "Order") }}/Transfer Pin</a></li>
                            </ul>
                        </li>
						
                        <li class="menu-list
                    {!! (in_array(Route::currentRouteName(), ['bonus', 'bonus.sponsor', 'bonus.pairing', 'bonus.upgrade.b', 'bonus.reward', 'bonus.reward.claim', 'bonus.previous', 'bonus.sponsor.previous', 'bonus.pairing.previous', 'bonus.upgrade.b.previous']) ? 'active' : '') !!}">
                            <a href=""><i class="fa fa-briefcase"></i>  <span>Bonus</span></a>
                            <ul class="child-list">
                                <li {!! (Route::currentRouteName()=='bonus' ? 'class=active' : '') !!}><a href="{{ route('bonus') }}"> Summary </a></li>
                                <li {!! (Route::currentRouteName()=='bonus.sponsor' ? 'class=active' : '') !!}><a href="{{ route('bonus.sponsor') }}"> Sponsor</a></li>
                                <li {!! (Route::currentRouteName()=='bonus.pairing' ? 'class=active' : '') !!}><a href="{{ route('bonus.pairing') }}"> Pairing</a></li>
                                <li {!! (Route::currentRouteName()=='bonus.upgrade.b' ? 'class=active' : '') !!}><a href="{{ route('bonus.upgrade.b') }}"> Upgrade-B</a></li>
                                <li {!! in_array(Route::currentRouteName(), ['bonus.reward', 'bonus.reward.claim']) ? 'class=active' : '' !!}><a href="{{ route('bonus.reward') }}"> Reward</a></li>

                                <li {!! (Route::currentRouteName()=='bonus.previous' ? 'class=active' : '') !!}><a href="{{ route('bonus.previous') }}"> Prev Summary</a></li>
                                <li {!! (Route::currentRouteName()=='bonus.sponsor.previous' ? 'class=active' : '') !!}><a href="{{ route('bonus.sponsor.previous') }}"> Prev Sponsor</a></li>
                                <li {!! (Route::currentRouteName()=='bonus.pairing.previous' ? 'class=active' : '') !!}><a href="{{ route('bonus.pairing.previous') }}"> Prev Pairing</a></li>
                                <li {!! (Route::currentRouteName()=='bonus.upgrade.b.previous' ? 'class=active' : '') !!}><a href="{{ route('bonus.upgrade.b.previous') }}"> Prev Upgrade-B</a></li>
                            </ul>
                        </li>
                        <li class="menu-list {!! (in_array(Route::currentRouteName(), ['nucash', 'nucash.wd.list']) ? 'active' : '') !!}">
                            <a href=""><i class="fa fa-money"></i>  <span>Nu-Cash</span></a>
                            <ul class="child-list">
                                <li {!! (Route::currentRouteName()=='nucash' ? 'class=active' : '') !!}><a href="{{ route('nucash') }}"> Summary</a></li>
                                <li {!! (Route::currentRouteName()=='nucash.wd.list' ? 'class=active' : '') !!}><a href="{{ route('nucash.wd.list') }}"> Withdrawal</a></li>
                                <li {!! (Route::currentRouteName()=='nucash.previous.list' ? 'class=active' : '') !!}><a href="{{ route('nucash.previous.list') }}"> Previous Nucash</a></li>
                            </ul>
                        </li>
                        {{--
                        <li class="menu-list {!! (in_array(Route::currentRouteName(), ['nupoint', 'nupoint.market']) ? 'active' : '') !!}">
                            <a href=""><i class="fa fa-tags"></i>  <span>Nu-Point</span></a>
                            <ul class="child-list">
                                <li {!! (Route::currentRouteName()=='nupoint' ? 'class=active' : '') !!}><a href="{{ route('nupoint') }}"> Summary</a></li>
                                <li {!! (Route::currentRouteName()=='nupoint.market' ? 'class=active' : '') !!}><a href="{{ route('nupoint.market') }}"> Market Place</a></li>
                            </ul>
                        </li>
                        --}}


                        <li class="menu-list
                    {!! (in_array(Route::currentRouteName(), ['plan.upgrade.b','plan.network.binary.b','plan.placement.b']) ? 'active' : '') !!}">
                            <a href=""><i class="fa fa-toggle-on"></i>  <span>Plan-B</span><span class="label noti-arrow bg-danger pull-right">New</span></a>
                            <ul class="child-list">
                                
								<li {!! (Route::currentRouteName()=='plan.network.binary.b' ? 'class=active' : '') !!}><a href="{{ route('plan.network.binary.b') }}"> Network</a></li>
                                <li {!! (Route::currentRouteName()=='plan.placement.b' ? 'class=active' : '') !!}><a href="{{ route('plan.placement.b') }}"> Placement</a></li>
                            </ul>
                        </li>

                        <li class="menu-list
                        {!! (in_array(Route::currentRouteName(), ['planc', 'planc.join', 'planc.bonus', 'planc.trfinstruction', 'planc.status.order', 'planc.bank', 'planc.bonus.success', 'planc.bonus.leadership', 'planc.history']) ? 'active' : '') !!}">
                            <a href=""><i class="fa fa-toggle-off"></i>  <span>Plan-C</span></a>
                            <ul class="child-list">

                                <li {!! (Route::currentRouteName()=='planc' ? 'class=active' : '') !!}><a href="{{ route('planc') }}"> Board</a></li>
                                <li {!! (Route::currentRouteName()=='planc.join' ? 'class=active' : '') !!}><a href="{{ route('planc.join') }}"> Join</a></li>
                                <li {!! (Route::currentRouteName()=='planc.trfinstruction' ? 'class=active' : '') !!}><a href="{{ route('planc.trfinstruction') }}"> Order Pin</a></li>
                                <li {!! (Route::currentRouteName()=='planc.status.order' ? 'class=active' : '') !!}><a href="{{ route('planc.status.order') }}"> Status Order Pin</a></li>
                                <li {!! (Route::currentRouteName()=='planc.bonus' ? 'class=active' : '') !!}><a href="{{ route('planc.bonus') }}"> Bonus</a></li>
                                <li {!! (Route::currentRouteName()=='planc.bonus.success' ? 'class=active' : '') !!}><a href="{{ route('planc.bonus.success') }}"> Withdrawed Bonus</a></li>
                                <li {!! (Route::currentRouteName()=='planc.bonus.leadership' ? 'class=active' : '') !!}><a href="{{ route('planc.bonus.leadership') }}"> Ranking Bonus</a></li>
                                <li {!! (Route::currentRouteName()=='planc.bank' ? 'class=active' : '') !!}><a href="{{ route('planc.bank') }}"> Bank Account</a></li>
                                <li {!! (Route::currentRouteName()=='planc.history' ? 'class=active' : '') !!}><a href="{{ route('planc.history') }}"> History</a></li>
                            </ul>
                        </li>

                        <li class="menu-list {!! (in_array(Route::currentRouteName(), ['partner.join', 'partner.status', 'partner.upgrade', 'partner.upload', 'partner.invoice']) ? 'active' : '') !!}">
                            <a href=""><i class="fa fa-exchange"></i>  <span>Partner</span></a>
                            <ul class="child-list">
                                <li {!! in_array(Route::currentRouteName(), ['partner.status', 'partner.join', 'partner.upgrade', 'partner.upload', 'partner.invoice']) ? 'class=active' : '' !!}><a href="{{ route('partner.status') }}"> Status</a></li>
                            </ul>
                        </li>

                        <li class="menu-list {!! (in_array(Route::currentRouteName(), ['plan.product.claim','plan.product.claimb']) ? 'active' : '') !!}">
                            <a href=""><i class="fa fa-truck"></i>  <span>Product Claim</span></a>
                            <ul class="child-list">
                                <li {!! in_array(Route::currentRouteName(), ['plan.product.claim']) ? 'class=active' : '' !!}><a href="{{ route('plan.product.claim') }}"> Product Claim List</a></li>
                            </ul>
                        </li>
                        
                        <li {!! (in_array(Route::currentRouteName(), ['news.member.list']) ? 'class=active' : '') !!}>
                                <a href="{{ route('news.member.list') }}"><i class="fa fa-newspaper-o"></i> <span>News</span></a>
                        </li>
                    @endif
                <!--sidebar nav end-->

                    <!--sidebar widget start-->
                    @include('layouts.sidebar_widget');
                    <!--sidebar widget end-->
                </ul>
            @endif
        </div>
    </div>
    <!-- sidebar left end-->

    <!-- body content start-->
    <div class="body-content">

        <!-- header section start-->
        <div class="header-section">

            <!--logo and logo icon start-->
            <div class="logo white-logo-bg hidden-xs hidden-sm">
                <a href="{{ route('home') }}">
                    <img src="{{ asset('assets/img/logoicon-biru.png') }}" alt="">
                    <!--<i class="fa fa-maxcdn"></i>-->
                    <span class="brand-name">NuLife</span>
                </a>
            </div>

            <div class="icon-logo white-logo-bg hidden-xs hidden-sm">
                <a href="{{ route('home') }}">
                    <img src="{{ asset('assets/img/logoicon-biru.png') }}" alt="">
                    <!--<i class="fa fa-maxcdn"></i>-->
                </a>
            </div>
            <!--logo and logo icon end-->

            <!--toggle button start-->
            <a class="toggle-btn"><i class="fa fa-outdent"></i></a>
            <!--toggle button end-->

        {{--<!--mega menu start-->--}}
        {{--<div id="navbar-collapse-1" class="navbar-collapse collapse yamm mega-menu">--}}
        {{--<ul class="nav navbar-nav">--}}

        {{--<!-- Classic dropdown -->--}}
        {{--<li class="dropdown"><a href="javascript:;" data-toggle="dropdown" class="dropdown-toggle"> English  <b--}}
        {{--class=" fa fa-angle-down"></b></a>--}}
        {{--<ul role="menu" class="dropdown-menu language-switch">--}}
        {{--<li>--}}
        {{--<a tabindex="-1" href="javascript:;"><span> Bahasa Indonesia </span></a>--}}
        {{--</li>--}}
        {{--</ul>--}}
        {{--</li>--}}

        {{--</ul>--}}
        {{--</div>--}}
        <!--mega menu end-->
            <div class="notification-wrap">
                <!--left notification start-->
                <div class="left-notification">
                    <ul class="notification-menu">

                        {{--<!--notification info start-->--}}
                        {{--<li>--}}
                        {{--<a href="javascript:;" class="btn btn-default dropdown-toggle info-number" data-toggle="dropdown">--}}
                        {{--<i class="fa fa-bell-o"></i>--}}
                        {{--<span class="badge bg-danger">3</span>--}}
                        {{--</a>--}}

                        {{--<div class="dropdown-menu dropdown-title ">--}}

                        {{--<div class="title-row">--}}
                        {{--<h5 class="title"> <!-- add color class to add arrow accent on top -->--}}
                        {{--You have 3 New Notification--}}
                        {{--</h5>--}}
                        {{--<a href="javascript:;" class="btn-info btn-view-all">View all</a>--}}
                        {{--</div>--}}
                        {{--<div class="notification-list-scroll sidebar">--}}
                        {{--<div class="notification-list mail-list not-list">--}}
                        {{--<a href="javascript:;" class="single-mail">--}}
                        {{--<span class="icon bg-info">--}}
                        {{--<i class="fa fa-user"></i>--}}
                        {{--</span>--}}
                        {{--<strong>You have new Plan-C downline</strong>--}}
                        {{--<p>--}}
                        {{--<small>Just Now</small>--}}
                        {{--</p>--}}
                        {{--<span class="un-read tooltips" data-original-title="Mark as Read" data-toggle="tooltip" data-placement="left">--}}
                        {{--<i class="fa fa-circle"></i>--}}
                        {{--</span>--}}
                        {{--</a>--}}
                        {{--<a href="javascript:;" class="single-mail">--}}
                        {{--<span class="icon bg-info">--}}
                        {{--<i class="fa fa-user"></i>--}}
                        {{--</span>--}}
                        {{--<strong>You have new Plan-C downline</strong>--}}

                        {{--<p>--}}
                        {{--<small>30 Mins Ago</small>--}}
                        {{--</p>--}}
                        {{--<span class="un-read tooltips" data-original-title="Mark as Read" data-toggle="tooltip" data-placement="left">--}}
                        {{--<i class="fa fa-circle"></i>--}}
                        {{--</span>--}}
                        {{--</a>--}}
                        {{--<a href="javascript:;" class="single-mail">--}}
                        {{--<span class="icon bg-info">--}}
                        {{--<i class="fa fa-user"></i>--}}
                        {{--</span> You have new Plan-C downline--}}
                        {{--<p>--}}
                        {{--<small> 2 Days Ago</small>--}}
                        {{--</p>--}}
                        {{--<span class="read tooltips" data-original-title="Mark as Unread" data-toggle="tooltip" data-placement="left">--}}
                        {{--<i class="fa fa-circle-o"></i>--}}
                        {{--</span>--}}
                        {{--</a>--}}
                        {{--<a href="javascript:;" class="single-mail">--}}
                        {{--<span class="icon bg-info">--}}
                        {{--<i class="fa fa-user"></i>--}}
                        {{--</span> You have new Plan-C downline--}}
                        {{--<p>--}}
                        {{--<small>1 Week Ago</small>--}}
                        {{--</p>--}}
                        {{--<span class="read tooltips" data-original-title="Mark as Unread" data-toggle="tooltip" data-placement="left">--}}
                        {{--<i class="fa fa-circle-o"></i>--}}
                        {{--</span>--}}
                        {{--</a>--}}
                        {{--</div>--}}
                        {{--</div>--}}
                        {{--</div>--}}
                        {{--</li>--}}
                        {{--<!--notification info end-->--}}
                    </ul>
                </div>
                <!--left notification end-->


                <!--right notification start-->
                <div class="right-notification">
                    <ul class="notification-menu">

                        <li>
                            <a href="javascript:;" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
                                <img src="{{ asset('assets/img/avatar-default.jpg') }}" alt="">{{ Auth::user()->nama }} | {{ Auth::user()->userid }}
                                <span class=" fa fa-angle-down"></span>
                            </a>
                            <ul class="dropdown-menu dropdown-usermenu pull-right">
                                {{--<li><a href="javascript:;">  Profile</a></li>--}}
                                {{--<li>--}}
                                {{--<a href="javascript:;">--}}
                                {{--<span>Settings</span>--}}
                                {{--</a>--}}
                                {{--</li>--}}
                                {{--<li>--}}
                                {{--<a href="javascript:;">--}}
                                {{--Help--}}
                                {{--</a>--}}
                                {{--</li>--}}
                                <li><a href="{{ route('my.profile') }}"><i class="fa fa-user"></i> Profile</a></li>
                                <li><a href="{{ route('create.bank') }}"><i class="fa fa-university"></i> Add Bank</a></li>
                                @if ($myUser->hasAccessRoute('admin.list.news'))
                                    <li><a href="{{ route('admin.list.news') }}"><i class="fa fa-newspaper-o"></i> News</a></li>
                                @endif
                                <li>
                                    <a href="{{ route('logout') }}" onclick="event.preventDefault(); $.cookie('popup_member_bermasalah', null); document.getElementById('logout-form').submit();">
                                        <i class="fa fa-sign-out pull-right"></i>
                                        Log Out
                                    </a>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">{{ csrf_field() }}
                                    </form>
                                    <!--a href="login.html"><i class="fa fa-sign-out pull-right"></i> Log Out</a-->
                                </li>
                                
                            </ul>
                        </li>

                    </ul>
                </div>
                <!--right notification end-->
            </div>

        </div>
        <!-- header section end-->

        <!-- page head start-->
    @yield('header')
    <!-- page head end-->

        <!--body wrapper start-->
        <div class="wrapper">

            {{--<!-- Content Goes Here -->--}}
            {{--@if (session('pesan-flash') && !empty(session('pesan-flash')))--}}
            {{--@if (is_string(session('pesan-flash')))--}}
            {{--<div class="alert alert-info">--}}
            {{--<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>--}}
            {{--{!! session('pesan-flash') !!}--}}
            {{--</div>--}}
            {{--@else--}}
            {{--<div class="alert alert-{{ session('pesan-flash')['type'] }}">--}}
            {{--<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>--}}
            {{--{!! session('pesan-flash')['pesan'] !!}--}}
            {{--</div>--}}
            {{--@endif--}}
            {{--@endif--}}
            @yield('content')

        </div>
        <!--body wrapper end-->


        <!--footer section start-->
        <footer class="sticky-footer">
            <div class="pull-left">2017 &copy; NuLife.co.id</div>
        </footer>
        <!--footer section end-->

    </div>
    <!-- body content end-->
</section>

<!-- Placed js at the end of the document so the pages load faster -->
<!-- vendor -->
<script src="{{ asset('assets/js/vendor/jquery.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/js/vendor/jquery.sessionTimeout.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/js/vendor/jquery-ui-custom.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/js/vendor/jquery-migrate.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/js/vendor/bootstrap.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/js/vendor/modernizr.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/js/vendor/jquery.nicescroll.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/js/vendor/owl.carousel.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/js/vendor/toastr.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/js/vendor/jquery.cookie.js') }}" type="text/javascript"></script>

@yield('scripts')

<!--common scripts for all pages-->
<script src="{{ asset('assets/js/nulife.min.js') }}"></script>
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
        <script type="text/javascript">
            $(document).ready(function() {
                toastr.options = {
                    "closeButton": true,
                    "debug": false,
                    "progressBar": true,
                    "positionClass": "toast-top-right",
                    "onclick": null,
                    "showDuration": "300",
                    "hideDuration": "1000",
                    "timeOut": "5000",
                    "extendedTimeOut": "1000",
                    "showEasing": "swing",
                    "hideEasing": "linear",
                    "showMethod": "fadeIn",
                    "hideMethod": "fadeOut"
                };
                toastr.info("{!! $pesanan['pesan'] !!}","NOTIFICATIONS")
            });
        </script>
    @else
        <script type="text/javascript">
            $(document).ready(function() {
                toastr.options = {
                    "closeButton": true,
                    "debug": false,
                    "progressBar": true,
                    "positionClass": "toast-bottom-left",
                    "onclick": null,
                    "showDuration": "300",
                    "hideDuration": "1000",
                    "timeOut": "30000",
                    "extendedTimeOut": "1000",
                    "showEasing": "swing",
                    "hideEasing": "linear",
                    "showMethod": "fadeIn",
                    "hideMethod": "fadeOut"
                };
                toastr.{!! $pesanan['type'] !!}("{!! $pesanan['pesan'] !!}","NOTIFICATIONS")
            });
        </script>
    @endif
@endif

@if ( Session::has('memberBaru') )
    <?php
    $warning = session('memberBaru');
    $warningPesan = $warning['pesan'];
    $warningStyle = $warning['style'];
    ?>
    <script type="text/javascript">
        $(document).ready(function() {
            toastr.options = {
                "closeButton": true,
                "debug": false,
                "progressBar": true,
                "positionClass": "toast-top-center",
                "onclick": null,
                "showDuration": "0",
                "hideDuration": "0",
                "timeOut": "0",
                "extendedTimeOut": "0",
                "showEasing": "swing",
                "hideEasing": "linear",
                "showMethod": "fadeIn",
                "hideMethod": "fadeOut"
            };
            toastr["info"]("{!! $warningPesan !!}").attr('style', '{!! $warningStyle !!}');
        });
    </script>
@endif

@if (!$isAdmin && env('APP_CHAT', true))
    <!--Start of Tawk.to Script-->
    <script type="text/javascript">
        var Tawk_API=Tawk_API||{}, Tawk_LoadStart=new Date();
        (function(){
            var s1=document.createElement("script"),s0=document.getElementsByTagName("script")[0];
            s1.async=true;
            s1.src='https://embed.tawk.to/58e72a7ef7bbaa72709c4c91/default';
            s1.charset='UTF-8';
            s1.setAttribute('crossorigin','*');
            s0.parentNode.insertBefore(s1,s0);
        })();
    </script>
    <!--End of Tawk.to Script-->
@endif

</body>
</html>