@extends('layouts.main')

@section('header')
    @include('layouts.header')
@endsection

@section('content')
<section class="panel">
    <div class="panel-body">
        <form class="form-horizontal" role="form" onsubmit="return false;" id="form-checked">
            {{ csrf_field() }}
            <div class="control-table">
                <label for="status">Status
                    <select id="status" class="form-control">
                        <option value="0"{{ ($status==0) ? " selected" : "" }}>Confirmed</option>
                        <option value="1"{{ ($status==1) ? " selected" : "" }}>Unconfirmed</option>
                        <option value="2"{{ ($status==2) ? " selected" : "" }}>Rejected</option>
                    </select>
                </label>
                <a href="{{ route('admin.excel.planc.wd.leadership',['status' => $status]) }}" class="btn btn-success addon-btn" id="action-excel" target="_blank"><i class="fa fa-file-excel-o"></i>&nbsp;&nbsp;Export to Excel</a>
                <a href="{{ route('admin.excel.planc.wdpayroll.leadership') }}" class="btn btn-success addon-btn" id="action-excel" target="_blank"><i class="fa fa-file-excel-o"></i>&nbsp;&nbsp;Export to Excel (Payroll)</a>
                <button id="submit-checked" class="btn btn-info addon-btn"><i class="fa fa-check-square-o"></i>&nbsp;&nbsp;Confirm Checked</button>
            </div>
            <table class="table table-hover responsive nowrap" id="tbl-nulife">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Bank Account</th>
                        <th>ID</th>
                        <th><input type="checkbox" id="select-all" value="1" ></th>
                        <th>Name</th>
                        <th>To be Transfer</th>
                        <th>B.Amount</th>
                        <th>Adm.Charge</th>
                        <th> </th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </form>
    </div>
    <div id="action-modal" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Member Bank Account</h4>
                </div>
                <div class="modal-body">
                    <div class="form-horizontal">
                        <div class="form-group">
                            <div class="col-sm-10 col-sm-offset-1 col-lg-10 col-lg-offset-1">
                                <div class="row">
                                    <label class="col-md-3 control-label">Bank Name :</label>
                                    <div class="col-md-6">
                                        <h5><strong>Bank Mandiri</strong></h5>
                                    </div>
                                </div>
                                <div class="row">
                                    <label class="col-md-3 control-label">Bank Account :</label>
                                    <div class="col-md-6">
                                        <h5><strong id="v-bank-account"></strong></h5>
                                    </div>
                                </div>
                                <div class="row">
                                    <label class="col-md-3 control-label">Account Name :</label>
                                    <div class="col-md-6">
                                        <h5><strong id="v-account-name"></strong></h5>
                                    </div>
                                </div>
                                <div class="row">
                                    <label class="col-md-3 control-label">To Be Transfer :</label>
                                    <div class="col-md-6">
                                        <h5><strong id="v-amount"></strong></h5>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success" id="confirm">Confirm</button>
                    <button type="button" class="btn btn-warning" id="reject">Reject</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
                <div class="hide">
                    <input type="hidden" id="wdid" value="">
                    <input type="hidden" id="wtoken" value="">
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
<script type="text/javascript" src="{{ asset('assets/js/vendor/bootstrap-daterangepicker/daterangepicker.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/js/vendor/bootstrap-daterangepicker/moment.min.js') }}"></script>

<script type="text/javascript">
    var myUrl = '<?php echo route("admin.ajax.planc.wd.leadership"); ?>';
    var nuTable;
    function doAction(obj) {
        $("#v-bank-account").text(obj.data('account'));
        $("#v-account-name").text(obj.data('account-name'));
        $("#v-amount").text(obj.data('amount'));
        $("#wdid").val(obj.data('index'));
        $("#wtoken").val(obj.data('token'));
    }
    $(document).ready(function() {
        var status = <?php echo $status; ?>;
        function unCheckedAll() {
            $('#tbl-nulife thead input[type="checkbox"]#select-all').prop('checked', false);
        }
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
            ajax            : myUrl + "?status=" + status,
            columnDefs      : [
                    { className: "dt-right", targets: [6 , 8] },
                    { className: "dt-center", targets: [3] },
            ],
            columns         : [
                {}, {}, {}, 
                {orderable: false, shortable: false, 
                    render: function (data, type, full, meta) {
                        return '<input type="checkbox" name="id[]" id="idselect" value="' + data + '">';
                    }
                }, 
                {}, {}, {}, {}, 
                {render : function (data, type, full, meta) {
                        if (data == 0 || data == 2) {
                            return '<button class="btn btn-info btn-action" id="action-' + full[3] + '" data-account="' + full[1] + '" data-account-name="' + full[4] + '" data-toggle="modal" data-target="#action-modal" data-amount="' + full[6] + '" data-token="{{ csrf_token() }}" data-index="' + full[3] + '" onclick="doAction($(this));">Action</button>';
                        } else if (data == 1) {
                            return 'Confirmed';
                        } else {
                            return 'Unkown';
                        }
                    }
                },
            ],
            fnDrawCallback: function( oSettings ) {
                unCheckedAll();
            }
        });
        //$("div.toolbar").attr('style', 'float:left; margin-bottom:6px;  margin-right:15px; line-height:16px;');
        $("div#tbl-nulife_length select, div#tbl-nulife_filter input").addClass('form-control');
        $('select#status').on('change', function() {
            status = $(this).val();
            nuTable.ajax.url(myUrl + "?status=" + status).load();
        });
        $('#tbl-nulife tbody').on('click', 'tr.odd', function () {
            nuTable.$('tr.selected').removeClass('selected');
            $(this).addClass('selected');
        });
        $('#tbl-nulife tbody').on('click', 'tr.even', function () {
            nuTable.$('tr.selected').removeClass('selected');
            $(this).addClass('selected');
        });
        $('button#confirm').on('click', function() {
            var konfirm = confirm("Are you to confirm this withdrawal ?");
            if(konfirm){
                $.ajax({
                    type: "POST",
                    url: '{{ route("admin.confirm.planc.wd.leadership") }}',
                    data: {
                        id : $('#wdid').val(),
                        _token : $('#wtoken').val()
                    },
                    error: function() {
                        alert('Something Error has occured');
                    }
                }).done(function(html) {
                    html = $.parseJSON(html);
                    if (html.status == 0) {
                        $('#action-modal').modal('hide');
                        $('#tbl-nulife').DataTable().ajax.reload();
                    }
                    alert(html.msg);
                });
            }
        });
        $('button#reject').on('click', function() {
            var note = prompt("Fill this based on how much the account transfer", "Note Message");
            if (note && note != '') {
                $.ajax({
                    type: "POST",
                    url: '{{ route("admin.reject.planc.wd.leadership") }}',
                    data: {
                        id : $('#wdid').val(),
                        note : note,
                        _token : $('#wtoken').val()
                    },
                    error: function() {
                        alert('Something Error has occured');
                    }
                }).done(function(html) {
                    html = $.parseJSON(html);
                    if (html.status == 0) {
                        $('#action-modal').modal('hide');
                        $('#tbl-nulife').DataTable().ajax.reload();
                    }
                    alert(html.msg);
                });
            }
        });
        $('#tbl-nulife thead').on('click', 'input[type="checkbox"]#select-all', function() {
            if(this.checked){
                $('#tbl-nulife tbody input[type="checkbox"]#idselect:not(:checked)').trigger('click');
            } else {
                $('#tbl-nulife tbody input[type="checkbox"]#idselect:checked').trigger('click');
            }
        });
        $('#tbl-nulife tbody').on('click', 'input[type="checkbox"]#idselect', function(e) {
            //var jmlRow = nuTable.rows().count();
            var jmlChecked = $('#tbl-nulife tbody input[type="checkbox"]#idselect:checked').length;
            var jmlUnChecked = $('#tbl-nulife tbody input[type="checkbox"]#idselect:not(:checked)').length;
            var checkAll = $('#tbl-nulife thead input[type="checkbox"]#select-all');
            checkAll.prop('checked', (jmlChecked > 0 && jmlUnChecked < 1));
            e.stopPropagation();
        });

        $('#submit-checked').on('click', function() {
            var jmlChecked = $('#tbl-nulife tbody input[type="checkbox"]#idselect:checked').length;
            if (jmlChecked > 0) {
                var okConfirm = confirm('Sure to submit checked data?');
                if (okConfirm) {
                    var values = $('#tbl-nulife tbody input[type="checkbox"]#idselect:checked, input[name="_token"]', $("#form-checked"));
                    $.ajax({
                        type: "POST",
                        url: '{{ route("admin.confirm.planc.wd.leadership.checked") }}',
                        data: values.serialize(),
                        error: function() {
                            alert('Something Error has occured');
                        }
                    }).done(function(html) {
                        html = $.parseJSON(html);
                        if (html.status == 0) {
                            $('#tbl-nulife').DataTable().ajax.reload();
                        }
                        alert(html.msg);
                    });
                }
            } else {
                alert('No data to submit');
            }
        });
    });

    if (top.location != location) {
        top.location.href = document.location.href ;
    }
</script>
@endsection