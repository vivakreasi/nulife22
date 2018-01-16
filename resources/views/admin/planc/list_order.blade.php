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
                    <th>Order Date</th>
                    <th>Member-ID</th>
                    <th>Name</th>
                    <th>Pin</th>
                    <th>Pin's Price</th>
                    <th>Status</th>
                    <th>Status Date</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>
    <div id="confirm-modal" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Received Payment Plan-C List</h4>
                </div>
                <div class="modal-body">
                    <table class="table table-hover responsive nowrap" id="tbl-payment">
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>Description</th>
                                <th>Credit</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success" id="confirm">Confirm</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
                <div class="hide">
                    <input type="hidden" id="ordid" value="">
                    <input type="hidden" id="ordtoken" value="">
                </div>
            </div>
        </div>
    </div>
</section>
<div class="modal fade" id="proof_transfer" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Proof of Transfer</h4>
            </div>
            <div class="modal-body">
                <img id="myImage" src="" style="width: 100%;">
            </div>
            <div class="modal-footer">
                <button data-dismiss="modal" class="btn btn-default" type="button">Close</button>
            </div>
        </div>
    </div>
</div>
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
    var myUrl = '<?php echo route("admin.ajax.pinc.order"); ?>';
    var nuTable;
    function doAction(obj) {
        $("#ordid").val(obj.data('index'));
        $("#ordtoken").val(obj.data('token'));
    }
    $(document).ready(function() {
        var payUrl = "{{ route('admin.ajax.pinc.payment') }}";

        payTable = $('#tbl-payment').DataTable({
            serverSide      : true,
            stateSave       : false,
            scrollCollapse  : true,
            info            : true,
            filter          : true,
            autoWidth       : false,
            paginate        : true,
            bLengthChange   : false,
            ajax            : payUrl,
            columnDefs      : [
                    { className: "dt-right", targets: [2] },
                    { className: "dt-center", targets: [0] },
                    { width: "20%", targets: [0] },
                    { width: "40%", targets: [2] }
            ]
        });

        $('#tbl-payment tbody').on('click', 'tr', function () {
            payTable.$('tr.selected').removeClass('selected');
            $(this).addClass('selected');
        });

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
                    { className: "dt-center", targets: [3] }
            ],
            columns         : [
                {}, {}, {}, {}, {},
                {render : function (data, type, full, meta) {
                            if (data == 5) {
                                return 'Belum Approve<br><a class="btn btn-xs btn-success open-viewimage-dialog" data-toggle="modal" data-image="'+ full[8] +'" href="#proof_transfer">VIEW</a><a href="javascript:void(0);" onclick="javascript:update_confirm(' + full[7] + ');" class="btn btn-xs btn-primary">CONFIRM</a><a href="javascript:void(0);" onclick="javascript:update_cancel(' + full[7] + ');" class="btn btn-xs btn-default">CANCEL</a>';
                            } else {
                                if (data == 4) {
                                    return 'Belum Transfer<br><button data-index="' + full[7] + '" data-token="{{ csrf_token() }}" class="btn btn-xs btn-info btn-action" data-toggle="modal" data-target="#confirm-modal" id="btn-' + full[7] + '" onclick="doAction($(this))">CONFIRM</button><a href="javascript:void(0);" onclick="javascript:update_cancel_manual(' + full[7] + ');" class="btn btn-xs btn-default">CANCEL</a>';
                                } else {
                                    return 'Sudah Approve';
                                }
                            }
                        }
                },
                {},
            ],
        });
        var tb_array = [
                '<div class="control-table">',
                '<label for="status">Status',
                '<select id="status" class="form-control">',
                '<option value="0"{{ ($status==0) ? " selected" : "" }}>Sudah Approve</option>',
                '<option value="1"{{ ($status==1) ? " selected" : "" }}>Belum Approve</option>',
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

        $('#confirm-modal').on('shown.bs.modal', function() {
            payTable.ajax.reload();
        });

        $('button#confirm').on('click', function() {
            var pyId = $.map(payTable.rows('.selected').data(), function (item) {return item[3][0][0];});
            var ordId = $('#ordid').val();
            if (parseInt(pyId) > 0 && parseInt(ordId) > 0) {
                var konfirm = confirm("Are you to confirm this withdrawal ?");
                if(konfirm){
                    $.ajax({
                        type: "POST",
                        url: '{{ route("admin.pinc.order.manual.confirm") }}',
                        data: {id: ordId, mutid: pyId, _token : $('#ordtoken').val()},
                        error: function() {
                            alert('Something Error has occured');
                        }
                    }).done(function(html) {
                        html = $.parseJSON(html);
                        if (html.status == 0) {
                            $('#confirm-modal').modal('hide');
                            nuTable.ajax.reload();
                            payTable.ajax.reload();
                        }
                        alert(html.msg);
                    });
                }
            }
        });
    });
    function update_confirm(orderid){
        var confirmation = confirm("Are you to confirm this order?");
        if(confirmation){
            $.ajax({
                type: "POST",
                url: '{{ route("admin.pinc.order.post") }}',
                data: {
                    id : orderid,
                    status : 3,
                    _token : '{{ csrf_token() }}'
                },
                success: function(data) {
                    console.log(data);
                    $('#tbl-nulife').DataTable().ajax.reload();
                    alert("Success to confirm the order!");
                },
                error: function() {
                    alert('Error occured');
                }
            });
        }
        else{
            alert('Action is Cancelled');
        }
    }
    function update_cancel(orderid){
        var confirmation = confirm("Are you to cancel this order?");
        if(confirmation){
            $.ajax({
                type: "POST",
                url: '{{ route("admin.pinc.order.post") }}',
                data: {
                    id : orderid,
                    status : 13,
                    _token : '{{ csrf_token() }}'
                },
                success: function(data) {
                    console.log(data);
                    $('#tbl-nulife').DataTable().ajax.reload();
                    alert("Success to cancel the order!");
                },
                error: function() {
                    alert('Error occured');
                }
            });
        }
        else{
            alert('Action is Cancelled');
        }
    }

    function update_cancel_manual(orderid){
        var confirmation = confirm("Are you to cancel this order?");
        if(confirmation){
            $.ajax({
                type: "POST",
                url: '{{ route("admin.pinc.order.post") }}',
                data: {
                    id : orderid,
                    status : 14,
                    _token : '{{ csrf_token() }}'
                },
                success: function(data) {
                    console.log(data);
                    $('#tbl-nulife').DataTable().ajax.reload();
                    alert("Success to cancel the order!");
                },
                error: function() {
                    alert('Error occured');
                }
            });
        }
        else{
            alert('Action is Cancelled');
        }
    }

    $(document).on("click", ".open-viewimage-dialog", function () {
        var url = '{{ route("planc.pin.image") }}';
        var myImage = url + '?img=' + $(this).data('image');
        $('#proof_transfer img').attr('src', myImage);
    });

</script>
@endsection