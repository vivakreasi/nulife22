<?php /*
@if (isset($globalProgressC))
<div class="sidebar-widget" style="margin-bottom: 5px;">
    <h4>Summary Plan-C Status</h4>
    <ul class="list-group">
        <li>
            @if($globalProgressC < 30)
                <?php $bartype = 'danger'; ?>
            @elseif($globalProgressC && $globalProgressC < 70)
                <?php $bartype = 'warning'; ?>
            @elseif($globalProgressC >= 70 && $globalProgressC < 100)
                <?php $bartype = 'info'; ?>
            @else
                <?php $bartype = 'success'; ?>
            @endif
            <div class="progress progress-lg">
                <div class="progress-bar progress-bar-{{ $bartype }}" style="width: {{ $globalProgressC }}%;">
                    <span>{{ round($globalProgressC,2) }}%</span>
                </div>
            </div>
        </li>
    </ul>
</div>
@endif
*/
?>
@if (isset($globalStatisticC))
    <div class="sidebar-widget">
        <h4>Summary Plan-C Statistic</h4>
        <ul class="list-group">
            @if (isset($globalStatisticC->progress))
            <li>
                @if($globalStatisticC->progress < 30)
                    <?php $bartype = 'danger'; ?>
                @elseif($globalStatisticC->progress >= 30 && $globalStatisticC->progress < 70)
                    <?php $bartype = 'warning'; ?>
                @elseif($globalStatisticC->progress >= 70 && $globalStatisticC->progress < 100)
                    <?php $bartype = 'info'; ?>
                @else
                    <?php $bartype = 'success'; ?>
                @endif
                <div class="progress progress-lg">
                    <div class="progress-bar progress-bar-{{ $bartype }}" style="width: {{ $globalStatisticC->progress }}%;">
                        <span>{{ round($globalStatisticC->progress, 2) }}%</span>
                    </div>
                </div>
            </li>
            @endif
            <li>
                <span class="label label-success pull-right">{{ number_format($globalStatisticC->today,0,',','.') }}</span>
                <p>Today</p>
            </li>
            <li>
                <span class="label label-warning pull-right">{{ number_format($globalStatisticC->yesterday,0,',','.') }}</span>
                <p>Yesterday</p>
            </li>
            {{--<li>--}}
                {{--<span class="label label-info pull-right">{{ number_format($globalStatisticC->total,0,',','.') }}</span>--}}
                {{--<p>Total</p>--}}
            {{--</li>--}}
            @if ($isAdmin)
            <li>
                <span class="label label-primary pull-right">{{ number_format($globalStatisticC->totalfly,0,',','.') }}</span>
                <p>Total Fly</p>
            </li>
            @endif
        </ul>
    </div>
    <div class="sidebar-widget">
        <ul class="list-group">
            <li>
                <a style="margin-left: 45px;" href="https://www.instantssl.com/wildcard-ssl.html" target="_blank" style="text-decoration:none; ">
                    <img alt="Wildcard SSL" src="https://www.instantssl.com/ssl-certificate-images/support/comodo_secure_100x85_transp.png" style="border: 0px;">
                </a>
            </li>
        </ul>
    </div>

@endif