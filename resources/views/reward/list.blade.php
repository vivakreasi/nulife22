@extends('layouts.main')

@section('header')
    @include('layouts.header')
@endsection

@section('content')
<section class="panel">
    <div class="panel-body">
        <section class="isolate-tabs">
        @if (Auth::user()->isPlanB())
            <ul class="nav nav-tabs">
                <li class="active"><a data-toggle="tab" id="tab-plan-a" href="#plan-a">Plan-A</a></li>
                <li><a data-toggle="tab" id="tab-plan-b" href="#plan-b">Plan-B</a></li>
            </ul>
            <div class="panel-body">
                <div class="tab-content">
                    <div id="plan-a" class="tab-pane fade in active" style="width: 100%;">
                        <table class="table table-bordered table-hover responsive" id="tbl-nulife-a" style="width: 100%;">
                            <thead>
                                <tr>
                                    <th colspan="2">Target</th>
                                    <th rowspan="2">Reward</th>
                                    <th rowspan="2">Status</th>
                                    <th rowspan="2">Date</th>
                                </tr>
                                <tr>
                                    <th>Left</th>
                                    <th>Right</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                    <div id="plan-b" class="tab-pane fade" style="width: 100%;">
                        <table class="table table-bordered table-hover responsive" id="tbl-nulife-b" style="width: 100%;">
                            <thead>
                                <tr>
                                    <th colspan="2">Target</th>
                                    <th rowspan="2">Reward</th>
                                    <th rowspan="2">Status</th>
                                    <th rowspan="2">Date</th>
                                </tr>
                                <tr>
                                    <th>Left</th>
                                    <th>Right</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        @else
            <div class="panel-body">
                <table class="table table-bordered table-hover responsive" id="tbl-nulife-a">
                    <thead>
                        <tr>
                            <th colspan="2">Target</th>
                            <th rowspan="2">Reward</th>
                            <th rowspan="2">Status</th>
                            <th rowspan="2">Date</th>
                        </tr>
                        <tr>
                            <th>Left</th>
                            <th>Right</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        @endif
        </section>
    </div>
</section>
@endsection
@section('scripts')
<link href="{{ asset('assets/js/vendor/datatables/datatables.min.css') }}" rel="stylesheet">
<link href="{{ asset('assets/js/vendor/datatables/DataTables-1.10.13/css/jquery.dataTables.min.css') }}" rel="stylesheet">
<link href="{{ asset('assets/js/vendor/datatables/Responsive-2.1.1/css/responsive.datatables.min.css') }}" rel="stylesheet">

<style type="text/css">
    .table > thead > tr > th {
        text-align: center;
        vertical-align: middle;
    }
    div#tbl-nulife_length select {width: auto;}
    div#tbl-nulife_length select, div#tbl-nulife_filter input {display: inline;}
    div#tbl-nulife_filter input {width: 150px;}
    table.dataTable > tbody > tr.child span.dtr-title {min-width: 1px;}
</style>

<script type="text/javascript" src="{{ asset('assets/js/vendor/datatables/datatables.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/js/vendor/datatables/DataTables-1.10.13/js/jquery.dataTables.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/js/vendor/datatables/Responsive-2.1.1/js/dataTables.responsive.min.js') }}"></script>

<script type="text/javascript">
    var nuTableA;
    @if (Auth::user()->isPlanB()) 
        var nuTableB;
    @endif
    function doAction(obj) {
        var url = "{{ route('bonus.reward') }}/claim/" + obj.data('index') + '/' + obj.data('plan');
        if (confirm('Are you sure to claim this reward?')) {
            window.location = url;
        }
    }
    $(document).ready(function() {
        nuTableA = $('#tbl-nulife-a').DataTable({
            processing      : true,
            serverSide      : true,
            stateSave       : false,
            scrollCollapse  : true,
            info            : false,
            filter          : false,
            autoWidth       : true,
            paginate        : false,
            sort            : false,
            ajax            : '{{ route("bonus.reward.ajax", "a") }}',
            columnDefs      : [
                    { className: "dt-center", targets: [0, 1, 3, 4] },
            ],
            columns         : [
                {}, {}, 
                {render : function (data, type, full, meta) {
                        return data.split('{br}').join('<br>');
                    }
                },
                {render : function (data, type, full, meta) {
                        if (full[5] == -1) {
                            if (full[12] == 1) {
                                return '<button class="btn btn-primary" data-token="{{ csrf_token() }}" data-index="' + full[4] + '" data-plan="a" onclick="doAction($(this));">Claim</button>';
                            } else {
                                return '';
                            }
                        } else if (full[5] == 1) {
                            return 'Claimed';
                        } else {
                            return 'Waiting Confirmation';
                        }
                    }
                },
                {render : function (data, type, full, meta) {
                        return full[15];
                    }
                },
            ]
        });
        @if (Auth::user()->isPlanB())
        nuTableB = $('#tbl-nulife-b').DataTable({
            processing      : true,
            serverSide      : true,
            stateSave       : false,
            scrollCollapse  : true,
            info            : false,
            filter          : false,
            autoWidth       : true,
            paginate        : false,
            sort            : false,
            ajax            : '{{ route("bonus.reward.ajax", "b") }}',
            columnDefs      : [
                    { className: "dt-center", targets: [0, 1, 3, 4] },
            ],
            columns         : [
                {}, {}, {},
                {render : function (data, type, full, meta) {
                        if (full[5] == -1) {
                            if (full[12] == 1) {
                                return '<button class="btn btn-primary btn-claim" data-token="{{ csrf_token() }}" data-index="' + full[4] + '" data-plan="b" onclick="doAction($(this));">Claim</button>';
                            } else {
                                return '';
                            }
                        } else if (full[5] == 1) {
                            return 'Claimed';
                        } else {
                            return 'Waiting Confirmation';
                        }
                    }
                },
                {render : function (data, type, full, meta) {
                        return full[15];
                    }
                },
            ]
        });
        $('a[data-toggle="tab"]#tab-plan-a').on( 'shown.bs.tab', function (e) {
            nuTableA.columns.adjust();
        });
        $('a[data-toggle="tab"]#tab-plan-b').on( 'shown.bs.tab', function (e) {
            nuTableB.columns.adjust();
        });
        @endif
    });
</script>
@endsection