@extends('layouts.main')

@section('header')
    @include('layouts.header')
@endsection

@section('content')
<section class="panel">
    <div class="panel-body">
        <div class="control-table" style="margin-bottom: 5px;">
            <a href="{{ route('admin.pin.report.xls') }}" class="btn btn-success addon-btn" id="action-excel" target="_blank"><i class="fa fa-file-excel-o"></i>&nbsp;&nbsp;Export Excel</a>
        </div>
        <table class="table table-hover responsive" id="tbl-nulife">
            <thead>
                <tr>
                    <th>No</th>
                    <th>UserID</th>
                    <th>Name</th>
                    <th>Transfered PIN </th>
                    <th>Active PIN</th>
                    <th>Used PIN</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>
    
    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
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
    var nuTable;
    $(document).ready(function() {
        nuTable = $('#tbl-nulife').DataTable({
            dom             : '<"toolbar">lfrtip',
            processing      : true,
            serverSide      : true,
            stateSave       : false,
            scrollCollapse  : true,
            info            : true,
            filter          : true,
            autoWidth       : true,
            paginate        : true,
            ajax            : '{{ route("admin.pin.report.ajax") }}',
            columnDefs      : [
                    { className: "dt-center", targets: [0, 1, 2, 3, 4, 5] },
            ],
            columns         : [
                {}, {}, {}, {}, {}, {},
            ],
            order: [[ 0, "asc" ]],
        });
        $('.dataTables_filter input').unbind().keyup(function(e) {
            var value = $(this).val();
            if (e.keyCode == 13) {
                nuTable.search(value).draw();
            }      
        });
        $("div#tbl-nulife_length select, div#tbl-nulife_filter input").addClass('form-control');
    });
</script>
<script type="text/javascript">
    $("#myModal").on("show.bs.modal", function(e) {
        var link = $(e.relatedTarget);
        $(this).find(".modal-content").load(link.attr("href"));
    });
</script>
@endsection