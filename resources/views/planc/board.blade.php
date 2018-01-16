@extends('layouts.main')
@section('header')
    @include('layouts.header')
@endsection
@section('content')
<section class="panel">
    <div class="panel-body">
        <div class="panel-group">
            <div class="panel panel-primary">
                <div class="panel-heading panel-table-heading">Plan-C Board</div>
                <div class="panel-body">
                    @if(!empty($activeC))
                        <?php $nomor = 1; $baris = ''; ?>
                        @foreach($activeC as $row)
                            <?php 
                                $cls = in_array($row->plan_c_code, $myListQueue) ? ' btn-success' : ' btn-primary';
                                if ($nomor == 1) {
                                    $baris = '<div class="row"><div class="col-md-4 col-md-offset-4 plan-c-id"><button class="btn' . $cls . ' m-b-10">' . $row->plan_c_code . '</button></div></div>';
                                } else {
                                    if (in_array($nomor, [2, 5, 8, 11])) $baris .= '<div class="row">';
                                    $baris .= '<div class="col-md-4 plan-c-id"><button class="btn' . $cls . ' m-b-10">' . $row->plan_c_code . '</button></div>';
                                    if (in_array($nomor, [4, 7, 10, 13])) $baris .= '</div>';
                                }
                                $nomor++;
                            ?>
                        @endforeach
                        {!! $baris !!}
                    @endif
                </div>
            </div>
            <div class="panel panel-primary">
                <div class="panel-heading panel-table-heading">Queue</div>
                <div class="panel-body">
                    <table class="table responsive nowrap queue-c" id="tbl-queue-c">
                        <thead>
                            <tr>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
@section('scripts')
    <link href="{{ asset('assets/js/vendor/datatables/datatables.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/js/vendor/datatables/DataTables-1.10.13/css/jquery.dataTables.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/js/vendor/datatables/Responsive-2.1.1/css/responsive.datatables.min.css') }}" rel="stylesheet">
    <style type="text/css">
        .panel {
            border: 1px solid #337ab7;
        }
        .panel-heading {
            text-transform: none;
            padding: 4px
        }
        .panel-body .plan-c-id {text-align: center;}
        .queue-c thead tr th {padding: 0; border: none; line-height: 0;height: 0;}
        div#tbl-nulife_length select {width: auto;}
        div#tbl-nulife_length select, div#tbl-nulife_filter input {display: inline;}
        div#tbl-nulife_filter input {width: 150px;}
    </style>
    <script type="text/javascript" src="{{ asset('assets/js/vendor/datatables/datatables.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/js/vendor/datatables/DataTables-1.10.13/js/jquery.dataTables.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/js/vendor/datatables/Responsive-2.1.1/js/dataTables.responsive.min.js') }}"></script>
    <script type="text/javascript">
        var nuTable;
        $(document).ready(function() {
            nuTable = $('#tbl-queue-c').DataTable({
                processing      : true,
                serverSide      : true,
                stateSave       : false,
                scrollCollapse  : true,
                info            : true,
                filter          : true,
                autoWidth       : true,
                paginate        : true,
                bLengthChange   : false,
                ajax            : '{{ route("planc.ajax.queue") }}',
                sort            : false,
                columnDefs      : [
                        { className: "dt-center", targets: [0, 1, 2, 3, 4] },
                ],
                columns         : [
                    {render : function (data, type, full, meta) {
                            if (data.toString().indexOf('#') == -1 && data != '') {
                                return '<button class="btn btn-info">' + data + '</button>';
                            }
                            return data;
                        }
                    },
                    {render : function (data, type, full, meta) {
                            if (data.toString().indexOf('#') == -1 && data != '') {
                                return '<button class="btn btn-info">' + data + '</button>';
                            }
                            return data;
                        }
                    },
                    {render : function (data, type, full, meta) {
                            if (data.toString().indexOf('#') == -1 && data != '') {
                                return '<button class="btn btn-info">' + data + '</button>';
                            }
                            return data;
                        }
                    },
                    {render : function (data, type, full, meta) {
                            if (data.toString().indexOf('#') == -1 && data != '') {
                                return '<button class="btn btn-info">' + data + '</button>';
                            }
                            return data;
                        }
                    },
                    {render : function (data, type, full, meta) {
                            if (data.toString().indexOf('#') == -1 && data != '') {
                                return '<button class="btn btn-info">' + data + '</button>';
                            }
                            return data;
                        }
                    },
                ]
            });
            $("div#tbl-queue-c_length select, div#tbl-queue-c_filter input").addClass('form-control');
        });
    </script>
@endsection