@extends('layouts.main')

@section('header')
    @include('layouts.header')
@endsection

@section('content')
<section class="panel">
    <div class="panel-body">
        <form class="form-horizontal" role="form" onsubmit="return false;" id="form-checked">
            {{ csrf_field() }}
            <table class="table table-bordered table-hover responsive nowrap" id="tbl-nulife">
                <thead>
                    <tr>
                        <th rowspan="2">Date</th>
                        <th colspan="3">Member</th>
                        <th colspan="2">Reward</th>
                        <th rowspan="2"></th>
                    </tr>
                    <tr>
                        <th>Name</th>
                        <th>ID</th>
                        <th>HP</th>
                        <th>Plan</th>
                        <th>Description</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </form>
    </div>
</section>
@endsection
@section('scripts')
<link href="{{ asset('assets/js/vendor/datatables/datatables.min.css') }}" rel="stylesheet">
<link href="{{ asset('assets/js/vendor/datatables/DataTables-1.10.13/css/jquery.dataTables.min.css') }}" rel="stylesheet">
<link href="{{ asset('assets/js/vendor/datatables/Responsive-2.1.1/css/responsive.datatables.min.css') }}" rel="stylesheet">

<style type="text/css">
    .table > thead > tr > th {
        /*background-color: #ddf;*/
        text-align: center;
        vertical-align: middle;
    }
    .control-table {display: inline-block; margin-right: 10px;}
    /*.toolbar select, div#tbl-nulife_length select {width: auto;}*/
    .control-table select, div#tbl-nulife_length select {width: auto;}
    /*.toolbar select, div#tbl-nulife_length select, div#tbl-nulife_filter input {display: inline;}*/
    .control-table select, div#tbl-nulife_length select, div#tbl-nulife_filter input {display: inline;}
    div#tbl-nulife_filter input {width: 150px;}
    .dataTable .view, .dataTable .confirm, .dataTable .reject {
        padding: 2px 4px;
    }
    table.dataTable > tbody > tr.child span.dtr-title {min-width: 1px;}
</style>

<script type="text/javascript" src="{{ asset('assets/js/vendor/datatables/datatables.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/js/vendor/datatables/DataTables-1.10.13/js/jquery.dataTables.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/js/vendor/datatables/Responsive-2.1.1/js/dataTables.responsive.min.js') }}"></script>

<script type="text/javascript">
    var nuTable;
    function doAction(obj) {
        if(confirm("Are you to confirm this claimed reward ?")){
            $.ajax({
                type: "POST",
                url: '{{ route("admin.confirm.plan.reward") }}',
                data: {
                    id : obj.data('index'),
                    _token : obj.data('token')
                },
                error: function() {
                    alert('Something Error has occured');
                }
            }).done(function(html) {
                html = $.parseJSON(html);
                if (html.status == 0) {
                    nuTable.ajax.reload();
                }
                alert(html.msg);
            });
        }
    }
    $(document).ready(function() {
        nuTable = $('#tbl-nulife').DataTable({
            //dom             : '<"toolbar">lfrtip',
            processing      : true,
            serverSide      : true,
            stateSave       : false,
            scrollCollapse  : true,
            info            : true,
            filter          : true,
            autoWidth       : true,
            paginate        : true,
            ajax            : '{{ route("admin.ajax.plan.reward") }}',
            columnDefs      : [
                    { className: "dt-center", targets: [4] },
            ],
            columns         : [
                {}, {}, {}, {}, {}, {},
                {render : function (data, type, full, meta) {
                        return '<button class="btn btn-info btn-action" data-index="' + data + '" data-token="{{ csrf_token() }}" onclick="doAction($(this));">Approve</button>';
                    }
                }
            ],
        });
        $("div#tbl-nulife_length select, div#tbl-nulife_filter input").addClass('form-control');
    });
</script>
@endsection