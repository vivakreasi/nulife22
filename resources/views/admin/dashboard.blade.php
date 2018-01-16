@extends('layouts.main')
@section('header')
    @include('layouts.header')
@endsection
@section('content')

<?php $myUser = Auth::user(); ?>

<section class="panel">
    <div class="panel-body">
        <section class="panel-group">
            @if ($totalRequestAB > 0 && 
                ($myUser->hasAccessRoute($admRequestAB->upgrade_b['route']) || $myUser->hasAccessRoute($admRequestAB->claim_reward['route']) ||
                $myUser->hasAccessRoute($admRequestAB->nucash_wd['route']) || $myUser->hasAccessRoute($admRequestAB->pin['route']) ||
                $myUser->hasAccessRoute($admRequestAB->placement['route']) ))
                <div class="panel panel-primary panel-request">
                    <div class="panel-heading panel-table-heading">Plan-A/B</div>
                    <div class="panel-body">
                        @if ($admRequestAB->upgrade_b['count'] > 0 && $myUser->hasAccessRoute($admRequestAB->upgrade_b['route']))
                            <a class="btn btn-primary" href="{{ route($admRequestAB->upgrade_b['route']) }}">
                                {{ $admRequestAB->upgrade_b['name'] }}&emsp;<span class="badge">{{ $admRequestAB->upgrade_b['count'] }}</span>
                            </a>
                        @endif
                        @if ($admRequestAB->claim_reward['count'] > 0 && $myUser->hasAccessRoute($admRequestAB->claim_reward['route']))
                            <a class="btn btn-primary" href="{{ route($admRequestAB->claim_reward['route']) }}">
                                {{ $admRequestAB->claim_reward['name'] }}&emsp;<span class="badge">{{ $admRequestAB->claim_reward['count'] }}</span>
                            </a>
                        @endif
                        @if ($admRequestAB->nucash_wd['count'] > 0 && $myUser->hasAccessRoute($admRequestAB->nucash_wd['route']))
                            <a class="btn btn-primary" href="{{ route($admRequestAB->nucash_wd['route']) }}">
                                {{ $admRequestAB->nucash_wd['name'] }}&emsp;<span class="badge">{{ $admRequestAB->nucash_wd['count'] }}</span>
                            </a>
                        @endif
                        @if ($admRequestAB->pin['count'] > 0 && $myUser->hasAccessRoute($admRequestAB->pin['route']))
                            <a class="btn btn-primary" href="{{ route($admRequestAB->pin['route']) }}">
                                {{ $admRequestAB->pin['name'] }}&emsp;<span class="badge">{{ $admRequestAB->pin['count'] }}</span>
                            </a>
                        @endif
                        @if ($myUser->hasAccessRoute($admRequestAB->placement['route']))
                            <a class="btn btn-primary" href="{{ route($admRequestAB->placement['route']) }}">
                                {{ $admRequestAB->placement['name'] }}&emsp;<span class="badge">{{ $admRequestAB->placement['count'] }}</span>
                            </a>
                        @endif
                    </div>
                </div>
            @endif
            @if ($myUser->hasAccessRoute($admRequestC->join_today['route']) || $myUser->hasAccessRoute($admRequestC->fly_today['route']) ||
                $myUser->hasAccessRoute($admRequestC->order['route']) || $myUser->hasAccessRoute($admRequestC->wd['route']) ||
                $myUser->hasAccessRoute($admRequestC->wd_ld['route']) )
                <div class="panel panel-primary panel-request">
                    <div class="panel-heading panel-table-heading">Plan-C</div>
                    <div class="panel-body">
                        @if ($myUser->hasAccessRoute($admRequestC->join_today['route']))
                            <a class="btn btn-primary" href="{{ route($admRequestC->join_today['route']) }}">
                                {{ $admRequestC->join_today['name'] }}&emsp;<span class="badge">{{ $admRequestC->join_today['count'] }}</span>
                            </a>
                        @endif
                        @if ($myUser->hasAccessRoute($admRequestC->fly_today['route']))
                            <a class="btn btn-primary" href="{{ route($admRequestC->fly_today['route']) }}">
                                {{ $admRequestC->fly_today['name'] }}&emsp;<span class="badge">{{ $admRequestC->fly_today['count'] }}</span>
                            </a>
                        @endif
                        @if ($admRequestC->order['count'] > 0 && $myUser->hasAccessRoute($admRequestC->order['route']))
                            <a class="btn btn-primary" href="{{ route($admRequestC->order['route']) }}">
                                {{ $admRequestC->order['name'] }}&emsp;<span class="badge">{{ $admRequestC->order['count'] }}</span>
                            </a>
                        @endif
                        @if ($admRequestC->wd['count'] > 0 && $myUser->hasAccessRoute($admRequestC->wd['route']))
                            <a class="btn btn-primary" href="{{ route($admRequestC->wd['route']) }}">
                                {{ $admRequestC->wd['name'] }}&emsp;<span class="badge">{{ $admRequestC->wd['count'] }}</span>
                            </a>
                        @endif
                        @if ($admRequestC->wd_ld['count'] > 0 && $myUser->hasAccessRoute($admRequestC->wd_ld['route']))
                            <a class="btn btn-primary" href="{{ route($admRequestC->wd_ld['route']) }}">
                                {{ $admRequestC->wd_ld['name'] }}&emsp;<span class="badge">{{ $admRequestC->wd_ld['count'] }}</span>
                            </a>
                        @endif
                    </div>
                </div>
            @endif
        </section>
    </div>
</section>
<style type="text/css">
    div.panel-request {
        border: 1px solid #337ab7;
    }
    div.panel-heading {
        text-transform: none;
        padding: 4px
    }
</style>
@endsection