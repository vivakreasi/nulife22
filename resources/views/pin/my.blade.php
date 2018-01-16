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
        <div class="row">
            <div class="col-sm-10 col-lg-10">
                <button class="btn btn-primary" type="button">
                    Activation PIN&emsp;<span class="badge">{{ $jmlPin }}</span>
                </button>
            </div>
        </div>
        <br>
        <table class="table table-hover responsive nowrap" id="tbl-nulife">
            <thead>
                <tr>
                    <th>Status</th>
                    <th>Pin Code</th>
                    <th>Received Date</th>
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
    .toolbar select, div#tbl-nulife_length select, div#tbl-nulife_filter input, div#tbl-payment_filter input {display: inline;}
    div#tbl-nulife_filter input, div#tbl-payment_filter input {width: 150px;}
    .control-table {display: inline-block; margin-right: 10px;}
    table.dataTable#tbl-payment tbody td {
        word-break: break-all;
        vertical-align: top;
        white-space: normal;
    }
</style>

<script type="text/javascript" src="{{ asset('assets/js/vendor/datatables/datatables.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/js/vendor/datatables/DataTables-1.10.13/js/jquery.dataTables.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/js/vendor/datatables/Responsive-2.1.1/js/dataTables.responsive.min.js') }}"></script>

<script type="text/javascript">
    var myUrl = '<?php echo route("pin.ajax.my"); ?>';
    var nuTable;
    function doAction(obj) {
        $("#ordid").val(obj.data('index'));
        $("#ordtoken").val(obj.data('token'));
    }
    $(document).ready(function() {

        var status = <?php echo $status; ?>;
        nuTable = $('#tbl-nulife').DataTable({
            dom             : '<"toolbar">lfrtip',
            processing      : true,
            serverSide      : true,
            stateSave       : false,
            scrollCollapse  : true,
            info            : true,
            filter          : true,
            autoWidth       : false,
            paginate        : true,
            ajax            : myUrl + "?status=" + status,
            columnDefs      : [
                    { className: "dt-center", targets: [0,1,2] }
            ],
            columns         : [
                {
                    render : function (data, type, full, meta) {
                        if( data == 0 ){
                            return '<label class="label label-success">Active</label>';
                        }
                        else{
                            return '<label class="label label-default">Used</label>';
                        }
                    }
                }, {}, {}
            ],
        });
        var tb_array = [
                '<div class="control-table">',
                '<label for="status">Status',
                '<select id="status" class="form-control">',
                '<option value="0"{{ ($status==0) ? " selected" : "" }}>Active</option>',
                '<option value="1"{{ ($status==1) ? " selected" : "" }}>Used</option>',
                '</select></label>',
                '</div>',
                '</div>'
            ];
        var tb = tb_array.join(' ');
        $("#tbl-nulife_wrapper div.toolbar").html(tb);
        $("#tbl-nulife_wrapper div.toolbar").attr('style', 'float:left; margin-bottom:6px; line-height:16px;');
        $("#tbl-nulife_wrapper div#tbl-nulife_length select, div#tbl-nulife_filter input, div#tbl-payment_filter input").addClass('form-control');
        $('#tbl-nulife_wrapper select#status').on('change', function() {
            status = $(this).val();
            nuTable.ajax.url(myUrl + "?status=" + status).load();
        });

        $('#tbl-nulife tbody').on('click', 'tr', function () {
            nuTable.$('tr.selected').removeClass('selected');
            $(this).addClass('selected');
        });
    });
</script>
@endsection