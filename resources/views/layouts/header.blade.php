@if (isset($page_header) && !empty($page_header))
    <div class="page-head">
        @if (isset($page_header->title) && $page_header->title != '')
            <h3>{{ $page_header->title }}</h3>
        @endif
        @if (isset($page_header->description) && $page_header->description != '')
            <span class="sub-title">{{ $page_header->description }}</span>
        @endif

        <div class="state-information">
            @if (isset($page_header->gnetworkgrowth) && $page_header->gnetworkgrowth != '')
                <div class="state-graph">
                    <div id="gnetworkgrowth" class="chart"><canvas width="82" height="32" style="display: inline-block; width: 82px; height: 32px; vertical-align: top;"></canvas></div>
                    <div class="info">Global Network Growth</div>
                </div>
            @endif
            @if (isset($page_header->gbonusearn) && $page_header->gbonusearn != '')
                <div class="state-graph">
                    <div id="gbonusearn" class="chart"><canvas width="82" height="32" style="display: inline-block; width: 82px; height: 32px; vertical-align: top;"></canvas></div>
                    <div class="info">Global Bonus Earnings</div>
                </div>
            @endif
        </div>
    </div>
@endif