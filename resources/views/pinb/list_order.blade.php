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
<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
        <form class="form-horizontal" role="form" method="POST" action="{{ route('pinb.confirm') }}" enctype="multipart/form-data">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title" id="myModalLabel">Confirm your payment</h4>
          </div>
          <div class="modal-body">
            <div class="row">
                {{ csrf_field() }}
                <input type="hidden" name="transaction_code" id="trans-code">
                <input type="hidden" name="type" id="modal-type">
                <div class="form-group">
                    <label class="col-md-4 control-label">Bank Name</label>
                    <div class="col-md-6">
                        <input class="form-control" type="text" name="bank_name" value="{{ old('bank_name') }}" required>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-4 control-label">Bank Account Number</label>
                    <div class="col-md-6">
                        <input class="form-control" type="text" name="account_no" value="{{ old('account_no') }}" required>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-4 control-label">Bank Account Name</label>
                    <div class="col-md-6">
                        <input class="form-control" type="text" name="account_name" value="{{ old('account_name') }}" required>
                    </div>
                </div>
                <div class="form-group{{ $errors->has('file') ? ' has-error' : '' }}">
                    <label class="col-md-4 control-label">File</label>
                    <div class="col-md-6">
                        <input id="ifile" type="file" name="file" accept="file_extension/*,.jpg,.png,.jpeg">
                    </div>
                </div>
            </div>
            <br>
            By clicking the 'Confirm' button then you are sure and responsible for all data which I have entered into the form<hr><small><i>WARNING : Nulife is not responsible if you incorrectly enter data on the form provided!</i></small>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Cancel</button>
            <button type="submit" class="btn btn-success btn-sm" data-token="{{ csrf_token() }}">Confirm</button>
          </div>
      </form>
    </div>
  </div>
</div>
<section class="panel">
    <div class="panel-body">
        <table class="table table-hover responsive nowrap" id="tbl-nulife">
            <thead>
                <tr>
                    <th>Status</th>
                    <th>Order Date</th>
                    <th>Transaction Code</th>
                    <th>Amount</th>
                    <th>Total Price</th>
                    <th>Description</th>
                    <th>Detail</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table><br>
        <div class="alert-info">Pending* = Existing transactions confirm payment but not approve yet by admin or stockist</div>
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
    var myUrl = '<?php echo route("pinb.ajax.list"); ?>';
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
                    { className: "dt-center", targets: [0,1,2,3,4,5] }
            ],
            /*
            columns         : [
                {}, {}, {}, {}, {},
                {render : function (data, type, full, meta) {
                            if (data == 5) {
                                return 'Belum Approve<br><a href="javascript:void(0);" onclick="javascript:update_confirm(' + full[7] + ');" class="btn btn-xs btn-primary">CONFIRM</a><a href="javascript:void(0);" onclick="javascript:update_cancel(' + full[7] + ');" class="btn btn-xs btn-default">CANCEL</a>';
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
            */
            columns         : [
                {
                    render : function (data, type, full, meta) {

                        var punyasendiri = 'Pending<br><a class="btn btn-sm btn-warning" href="javascript:void(0);" onclick="javascript:update_cancel(' + full[5] + ');">Cancel</a><button class="btn btn-sm btn-default" onclick="$(\'#modal-type\').val('+full[8]+');$(\'#trans-code\').val(\''+full[4]+'\');" data-toggle="modal" data-target="#myModal">Confirm</a>';

                        var mintaapprove = 'Pending<br><a class="btn btn-sm btn-warning" href="javascript:void(0);" onclick="javascript:update_approve(' + full[5] + ');">Approve</a>';

                        var punyasendiri2 = 'Pending*<br><a class="btn btn-sm btn-warning" href="javascript:void(0);" onclick="javascript:update_cancel(' + full[5] + ');">Cancel</a><button class="btn btn-sm btn-default" onclick="$(\'#modal-type\').val('+full[8]+');$(\'#trans-code\').val(\''+full[4]+'\');" data-toggle="modal" data-target="#myModal">Confirm</button>';

                        var mintaapprove2 = 'Pending*<br><a class="btn btn-sm btn-warning" href="javascript:void(0);" onclick="javascript:update_approve(' + full[5] + ');">Approve</a>';

                        if(data == 0){
                            // full[8] = TRANSACTION_TYPE
                            if(full[8] == 1){
                                // full[7] = TO
                                if(full[7] == {{ Auth::user()->id }}){
                                    return punyasendiri;
                                }
                                // full[6] = FROM
                                else if(full[6] == {{ Auth::user()->id }}){
                                    return mintaapprove;
                                }
                                else{
                                    return 'Pending';
                                }
                            }
                            else if(full[8] == 3){
                                // full[7] = TO
                                if(full[7] == {{ Auth::user()->id }}){
                                    return punyasendiri;
                                }
                                // full[6] = FROM
                                else if(full[6] == {{ Auth::user()->id }} || full[6] == 0){
                                    return mintaapprove;
                                }
                                else{
                                    return 'Pending';
                                }
                            }
                            else{
                                return 'Pending';
                            }
                        }
                        else if(data == 1){
                            // full[8] = TRANSACTION_TYPE
                            if(full[8] == 1){
                                // full[6] = FROM
                                if(full[6] == {{ Auth::user()->id }}){
                                    return mintaapprove2;
                                }
                                else{
                                    return 'Pending*';
                                }
                            }
                            else if(full[8] == 3){
                                // full[6] = FROM
                                if(full[6] == {{ Auth::user()->id }} || full[6] == 0){
                                    {!! (Auth::user()->isAdmin() ? "return mintaapprove2;" : "return 'Pending*';") !!}
                                }
                                else{
                                    return 'Pending*';
                                }
                            }
                            else{
                                return 'Pending*';
                            }
                        }
                        else if(data == 2){
                            if(full[6] == {{ Auth::user()->id }}){
                                return 'Sent';
                            }
                            else{
                                return 'Received';
                            }
                        }
                        else{
                            return 'Cancelled';
                        }
                    }
                }, {}, {}, {}, {},
                {
                    render : function (data, type, full, meta) {
                        if(full[6] == {{ Auth::user()->id }}){
                            return full[9]+' <strong>To</strong> '+full[10];
                        }
                        else{
                            return full[10]+' <strong>From</strong> '+full[9];
                        }
                    }
                },
                {
                    render : function (data, type, full, meta) {
                        return '<a class="btn btn-sm btn-info" href="{{ route("pinb.invoice", ["transaction_code" => null]) }}/'+full[2]+'">Detail</a>';
                    }
                }
            ],
        });
        var tb_array = [
                '<div class="control-table">',
                '<label for="status">Status',
                '<select id="status" class="form-control">',
                '<option value="0"{{ ($status==0) ? " selected" : "" }}>Pending</option>',
                '<option value="1"{{ ($status==1) ? " selected" : "" }}>Pending*</option>',
                '<option value="2"{{ ($status==2) ? " selected" : "" }}>Sent/Received</option>',
                '<option value="3"{{ ($status==3) ? " selected" : "" }}>Cancelled</option>',
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
    function update_confirm(orderid){
        var confirmation = confirm("Are you to confirm this order?");
        if(confirmation){
            $.ajax({
                type: "POST",
                url: '{{ route("pinb.order.post") }}',
                data: {
                    id : orderid,
                    status : 1,
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
    function update_approve(orderid){
        var confirmation = confirm("Are you to approve this order?");
        if(confirmation){
            $.ajax({
                type: "POST",
                url: '{{ route("pinb.order.post") }}',
                data: {
                    id : orderid,
                    status : 2,
                    _token : '{{ csrf_token() }}'
                },
                success: function(data) {
                    if(data == 1){
                        $('#tbl-nulife').DataTable().ajax.reload();
                        alert("Success to approve the order!");
                    }
                    else{
                        alert("Sorry, Your PIN Stock is not enough to complete this order");
                    }
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
                url: '{{ route("pinb.order.post") }}',
                data: {
                    id : orderid,
                    status : 3,
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
</script>
@endsection