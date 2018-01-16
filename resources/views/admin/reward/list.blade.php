@extends('layouts.main')

@section('header')
    @include('layouts.header')
@endsection

@section('content')
<section class="panel">
    <div class="panel-body">
        <div class="control-table">
            <button data-url="{{ route('admin.reward.setting.add') }}" class="btn btn-success addon-btn" id="action-add"><i class="fa fa-plus"></i>&nbsp;&nbsp;Add</a>
        </div>
        <table class="table table-bordered table-hover responsive" id="tbl-nulife">
            <thead>
                <tr>
                    <th rowspan="2">Plan</th>
                    <th rowspan="2">Target (Left)</th>
                    <th rowspan="2">Target (Right)</th>
                    <th colspan="2">Reward</th>
                    <th rowspan="2"></th>
                </tr>
                <tr>
                    <th>By Value</th>
                    <th>By Name</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>
</section>
@endsection
@section('scripts')
<link href="{{ asset('assets/js/vendor/datatables/datatables.min.css') }}" rel="stylesheet">
<link href="{{ asset('assets/js/vendor/datatables/DataTables-1.10.13/css/jquery.dataTables.min.css') }}" rel="stylesheet">
<link href="{{ asset('assets/js/vendor/datatables/Responsive-2.1.1/css/responsive.datatables.min.css') }}" rel="stylesheet">

<style type="text/css">
    .table > thead > tr > th {
        text-align: center !important;
        vertical-align: middle;
    }
    .control-table {display: inline-block; margin-right: 10px; margin-bottom: 10px;}
    .control-table select, div#tbl-nulife_length select {width: auto;}
    .control-table select, div#tbl-nulife_length select, div#tbl-nulife_filter input {display: inline;}
    div#tbl-nulife_length select {width: auto;}
    div#tbl-nulife_length select, div#tbl-nulife_filter input {display: inline;}
    div#tbl-nulife_filter input {width: 150px;}
    table.dataTable > tbody > tr.child span.dtr-title {min-width: 1px;}
</style>

<script type="text/javascript" src="{{ asset('assets/js/vendor/datatables/datatables.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/js/vendor/datatables/DataTables-1.10.13/js/jquery.dataTables.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/js/vendor/datatables/Responsive-2.1.1/js/dataTables.responsive.min.js') }}"></script>

<script type="text/javascript">
    var nuTable;
    $(document).ready(function() {
        nuTable = $('#tbl-nulife').DataTable({
            processing      : true,
            serverSide      : true,
            stateSave       : false,
            scrollCollapse  : true,
            info            : true,
            filter          : false,
            autoWidth       : true,
            paginate        : false,
            sort            : false,
            ajax            : '{{ route("admin.reward.ajax.setting") }}',
            columnDefs      : [
                    { className: "dt-center", targets: [0, 1, 2, 5] },
                    { className: "dt-right", targets: [3] }
            ],
            columns         : [
                {}, {}, {}, {}, {},
                {render : function (data, type, full, meta) {
                    return '<a href="{{ route('admin.reward.setting') }}/edit/' + data + '" class="btn btn-xs btn-primary">Edit</a>';
                    }
                }
            ],
        });
        $("div#tbl-nulife_length select, div#tbl-nulife_filter input").addClass('form-control');
        $('#action-add').on('click', function() {
            window.location = $(this).data('url');
        });
    });
</script>
@endsection