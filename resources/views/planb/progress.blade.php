@extends('layouts.main')
@section('header')
    @include('layouts.header')
@endsection
<?php $listCode = []; ?>
@section('content')
    @if (!empty($myProgress))
        <style>
            .google-visualization-orgchart-table{
                font-size: 0.6em;
            }
        </style>
        <section class="panel">
            <div class="panel-body">
                <div class="col-md-10 col-md-offset-1">
                    <ul class="list-group" style="list-style-type: decimal;">
                        @foreach($myProgress as $value)
                            @if($value->progress < 30)
                                <?php $bartype = 'danger'; ?>
                            @elseif($value->progress >= 30 && $value->progress < 70)
                                <?php $bartype = 'warning'; ?>
                            @elseif($value->progress >= 70 && $value->progress < 100)
                                <?php $bartype = 'info'; ?>
                            @else
                                <?php $bartype = 'success'; ?>
                            @endif
                            <li>
                                <p>
                                    {{ $value->code }}</span>
                                    <a href="#" data-id="{{ $value->code }}" data-show="" class="pull-right chart-detail hidden-sm hidden-xs">Detail</a>
                                </p>
                                <div class="progress">
                                    <div class="progress-bar progress-bar-{{ $bartype }} progress-bar-striped active" role="progressbar" style="width: {{ round($value->progress,2) }}%;">
                                        {{ round($value->progress,2) }}%
                                    </div>
                                </div>

                                @if (!empty($value->structure))
                                    <?php
                                    $listCode[$value->code] = $value->structure;
                                    //dd($value->structure);
                                    ?>
                                    <div id="container-{{ $value->code }}" class="mychart" data-id="{{ $value->code }}"></div>
                                @endif
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </section>
    @else
        <section class="panel">
            <div class="panel-body">
                <p>You have not join NuLife Plan-C program. click <a href="{{ route('planc.join') }}">here</a> to start join.</p>
            </div>
        </section>
    @endif
@endsection

@if (!empty($listCode))
@section('scripts')
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            <?php
            $fn = '';
            foreach ($listCode as $key => $value) {
                $fn .= ' function drawChart' . $key . '() {';
                $fn .= 'var data = new google.visualization.DataTable();';
                $fn .= 'data.addColumn("string", "Name");';
                $fn .= 'data.addColumn("string", "Manager");';
                $fn .= 'data.addColumn("string", "Manager2");';
                $fn .= 'data.addRows([';
                foreach ($value as $row) {
                    $fn .= $row . ',';
                }
                $fn .= ']);';
                $fn .= 'var chart = new google.visualization.OrgChart(document.getElementById("container-' . $key . '"));';
                $fn .= 'chart.draw(data, {allowHtml:true});';
                $fn .= '} ';
                $fn .= 'google.charts.load("current", {packages:["orgchart"]}); google.charts.setOnLoadCallback(drawChart' . $key . '); ';
            }
            $fn .= '$(".chart-detail").on("click", function() {';
            $fn .= '$(".mychart").hide();';
            $fn .= 'var id=$(this).data("id");';
            $fn .= 'var ada=$(this).data("show");';
            $fn .= '$(".chart-detail").data("show", "");';
            $fn .= 'var e=$("#container-" + id);';
            $fn .= 'if (ada != undefined && ada != ""){';
            $fn .= 'e.hide();';
            $fn .= '$(this).data("show", "");';
            $fn .= '}else{';
            $fn .= 'e.show();';
            $fn .= '$(this).data("show", id);';
            $fn .= '}';
            $fn .= 'return false;';
            $fn .= '});';
            $fn .= '$(".mychart").hide();';

            echo $fn;
            ?>
        });
    </script>
@endsection
@endif