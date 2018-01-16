@extends('layouts.main')
@section('header')
    @include('layouts.header')
@endsection
@section('content')
<style type="text/css">
    .table > thead > tr > th {
        /*background-color: #ddf;*/
        text-align: center;
    }
</style>
<section class="panel">
    <div class="panel-body">
        <table class="table table-hover responsive nowrap" id="tbl-nulife">
            <thead>
                <tr>
                    <th>User ID</th>
                    <th>Name</th>
                    <th>Status</th>
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
    .toolbar select, div#tbl-nulife_length select {width: auto;}
    .toolbar select, div#tbl-nulife_length select, div#tbl-nulife_filter input {display: inline;}
    div#tbl-nulife_filter input {width: 150px;}
    .control-table {display: inline-block; margin-right: 10px;}
</style>

<script type="text/javascript" src="{{ asset('assets/js/vendor/datatables/datatables.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/js/vendor/datatables/DataTables-1.10.13/js/jquery.dataTables.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/js/vendor/datatables/Responsive-2.1.1/js/dataTables.responsive.min.js') }}"></script>

<script type="text/javascript">
    var myUrl = '{{ route("plan.direct.sponsor.ajax") }}';
    var nuTable;
    $(document).ready(function() {
        nuTable = $('#tbl-nulife').DataTable({
            processing      : true,
            serverSide      : true,
            stateSave       : false,
            scrollCollapse  : true,
            info            : true,
            filter          : true,
            autoWidth       : false,
            paginate        : true,
            bLengthChange   : true,
            ajax            : myUrl,
            columnDefs      : [
                    { className: "dt-center", width: "10%", orderable: false, targets: [2] },
            ]
        });
        $("#tbl-nulife_wrapper div#tbl-nulife_length select, div#tbl-nulife_filter input, div#tbl-payment_filter input").addClass('form-control');
    });
</script>
@endsection