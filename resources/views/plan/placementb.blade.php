@extends('layouts.main')
@section('header')
    @include('layouts.header')
@endsection
@section('content')
    @if ($actions->continue)
        <form class="form-horizontal" method="post" id="form-placement" action="{{ route('plan.placement.b.post') }}">
            <input type="hidden" name="parent" value="" id="f_parent">
            <input type="hidden" name="foot" value="" id="f_foot">
            <input type="hidden" name="userid" value="" id="f_userid">
            <input type="hidden" name="email" value="" id="f_email">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
        </form>
        <section class="panel-group">
            <div class="panel panel-primary member-panel">
                <div class="panel-heading member-panel-heading">Members</div>
                <div class="panel-body">
                    <table class="table table-bordered table-hover responsive nowrap" id="tbl-nulife">
                        <thead>
                        <tr>
                            <th>Code</th>
                            <th>Name</th>
                            <th>Email</th>
                        </tr>
                        </thead>
                        <tbody>
                        @if (!empty($own))
                            @foreach($own as $row)
                                <tr>
                                    <td>{{ $row->userid }}</td>
                                    <td>{{ $row->name }}</td>
                                    <td>{{ $row->email }}</td>
                                </tr>
                            @endforeach
                        @endif
                        @if (!$members->isEmpty())
                            @foreach($members as $row)
                                <tr>
                                    <td>{{ $row->userid }}</td>
                                    <td>{{ $row->name }}</td>
                                    <td>{{ $row->email }}</td>
                                </tr>
                            @endforeach
                        @endif
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="panel">
                <div class="panel-body">
                    <div class="col-md-10 col-md-offset-1">
                        @if (!empty($struktur->data))
                            <div id="container-struktur" class="mychart" data-id="struktur"></div>
                        @endif
                    </div>
                </div>
            </div>
        </section>
    @else
        <section class="panel">
            <div class="profile-head">
                <div class="profiles container">
                    <div class="col-md-8 col-sm-8 col-xs-9">
                        <div class="row">
                            <div class="col-sm-12"><h4>{{$actions->message}}</h4></div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    @endif
@endsection
@section('scripts')
    @if (isset($struktur->data) && !empty($struktur->data) && $actions->continue)
        <link href="{{ asset('assets/js/vendor/datatables/datatables.min.css') }}" rel="stylesheet">
        <link href="{{ asset('assets/js/vendor/datatables/DataTables-1.10.13/css/jquery.dataTables.min.css') }}" rel="stylesheet">
        <link href="{{ asset('assets/js/vendor/datatables/Responsive-2.1.1/css/responsive.datatables.min.css') }}" rel="stylesheet">
        <style type="text/css">
            .table > thead > tr > th {
                /*background-color: #ddf;*/
                text-align: center;
            }
            .toolbar select, div#tbl-nulife_length select {width: auto;}
            .toolbar select, div#tbl-nulife_length select, div#tbl-nulife_filter input {display: inline;}
            div#tbl-nulife_filter input {width: 150px;}
            .control-table {display: inline-block; margin-right: 10px;}
            .google-visualization-orgchart-table{
                font-size: 0.8em;
            }
            .btn-tree {
                display: block;
                width: 100%;
                padding: .1rem;
                font-size: small;
            }
            .form-control-tree {
                padding: .1rem;
                font-size: small;
                height: auto;
            }
            .empty-field {
                padding-top: 10px;
            }
            .member-panel {
                border: 1px solid #337ab7;
            }
            .member-panel-heading {
                text-transform: none;
                padding: 4px
            }
            .member-panel table thead tr th.cell-header {
                text-align: center;
                background-color: #dfdfdf;
            }
            .member-panel table tbody tr td {
                vertical-align: top;
            }
        </style>
        <script type="text/javascript" src="{{ asset('assets/js/vendor/datatables/datatables.min.js') }}"></script>
        <script type="text/javascript" src="{{ asset('assets/js/vendor/datatables/DataTables-1.10.13/js/jquery.dataTables.min.js') }}"></script>
        <script type="text/javascript" src="{{ asset('assets/js/vendor/datatables/Responsive-2.1.1/js/dataTables.responsive.min.js') }}"></script>
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
            function goPlacement(obj) {
                var nu = $.map(nuTable.rows('.selected').data(), function (item) {return item;});
                if ('' == nu || null == nu || nu.length < 1) {
                    alert('Please select the member to place into your structure.');
                    return;
                }
                var konfirm = confirm('Are you sure ?');
                if (konfirm) {
                    $('#f_email').val(nu[2]);
                    $('#f_userid').val(nu[0]);
                    $('#f_parent').val(obj.data('parent'));
                    $('#f_foot').val(obj.data('foot'));
                    $('#form-placement').submit();
                }
            }
            var nuTable;
            $(document).ready(function() {
                nuTable = $('#tbl-nulife').DataTable({
                    info            : true,
                    filter          : true,
                    autoWidth       : false,
                    paginate        : false,
                });

                $('#tbl-nulife tbody').on('click', 'tr', function () {
                    nuTable.$('tr.selected').removeClass('selected');
                    $(this).addClass('selected');
                });


                function drawChart() {
                    var data = new google.visualization.DataTable();
                    <?php
                    $fn = "";
                    for ($i = 0; $i < $struktur->maxLevel; $i++) {
                        $fn .= "data.addColumn('string', 'Level_" . $i . "');\n";
                    }
                    foreach ($struktur->data as $key => $value) {
                        $fn .= "data.addRows([" . $value . "]);\n";
                        $fn .= "var chart = new google.visualization.OrgChart(document.getElementById('container-struktur'));\n";
                    }
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

