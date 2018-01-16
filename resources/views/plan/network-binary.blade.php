@extends('layouts.main')
@section('header')
    @include('layouts.header')
@endsection
@section('content')
    <style>
        .google-visualization-orgchart-nodesel {
            border: none;
            padding: 3px;
            width: 2.5%;
            vertical-align: top;
        }
        .google-visualization-orgchart-node {
            border: none;
            padding: 3px;
            width: 2.5%;
            vertical-align: top;
        }
        .google-visualization-orgchart-linenode {
            vertical-align: top;
        }
        .btn-tree {
            display: block;
            width: 100%;
            font-size: small;
        }
        .form-control-tree {
            font-size: small;
            height: auto;
        }
        .occupation {color: #23f;}
        .left-binary, .right-binary {
            display: inline-block;
            width: 50%;
            font-size: 9px;
        }
        .left-binary {background-color: #f55; color: #fff;}
        .right-binary {background-color: #fff; color: #f22;}
    </style>
    <section class="panel">
        <div class="panel-body">
            <div class="col-xs-12">
                @if (!empty($struktur->data))
                    <div id="container-struktur" class="mychart" data-id="struktur"></div>
                @endif
            </div>
        </div>
    </section>
@endsection
@section('scripts')
    @if (!empty($struktur->data))
        <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
        <script type="text/javascript">
            function goTop(obj) {
                var url = $('option:selected', obj).data('url');
                if (url !== undefined) {
                    window.location = url;
                }
            }
            function goTree(obj) {
                window.location = obj.data('url');
            }
            $(document).ready(function() {
                function drawChart() {
                    var data = new google.visualization.DataTable();
                    <?php
                    $fn = "";
                    for ($i = 0; $i < $struktur->maxLevel; $i++) {
                        $fn .= "data.addColumn('string', 'Level_" . $i . "');\n";
                    }
                    $fn .= "data.addRows([";
                    $x = 1;
                    foreach ($struktur->data as $key => $value) {
                        if ($x==1) {
                            $fn .= $value;
                        } else {
                            $fn .= "," . $value;
                        }
                        $x = $x + 1;
                    }
                    $fn .= "]);\n";
                    $fn .= "var chart = new google.visualization.OrgChart(document.getElementById('container-struktur'));\n";

                    $fn .= "chart.draw(data, {allowHtml:true});\n";
                    echo $fn;
                    ?>
                }
                google.charts.load("current", {packages:["orgchart"]});
                google.charts.setOnLoadCallback(drawChart);
            });
        </script>
    @endif
@endsection

