@extends('layouts.main')

@section('header')
    @include('layouts.header')
@endsection

@section('content')
<section class="panel">
    <div class="panel-body">
        <a href="{{ route('nucash.wd') }}" class="btn btn-info">Create Withdraw</a>
    </div>
    <div class="panel-body">
        <table class="table table-hover responsive" id="tbl-nulife">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Date</th>
                    <th>Nominal WD</th>
                    <th>Transfer</th>
                    <th>Confirm</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>
    
    <div id="action-modal" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Member Withdraw NuCash</h4>
                </div>
                <div class="modal-body">
                    <div class="form-horizontal">
                        <div class="form-group">
                            <div class="col-sm-10 col-sm-offset-1 col-lg-10 col-lg-offset-1">
                                <div class="row">
                                    <label class="col-md-4 control-label">Total Amount :</label>
                                    <div class="col-md-6">
                                        <h5><strong id="v-total-amount"></strong></h5>
                                    </div>
                                </div>
                                <div class="row">
                                    <label class="col-md-4 control-label">Admin Fee :</label>
                                    <div class="col-md-6">
                                        <h5><strong id="v-admin-fee"></strong></h5>
                                    </div>
                                </div>
                                <div class="row">
                                    <label class="col-md-4 control-label">Transfered Amount :</label>
                                    <div class="col-md-6">
                                        <h5><strong id="v-transfer-amount"></strong></h5>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success" id="confirm">Confirm</button>
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
    function doAction(obj) {
        $("#v-total-amount").text(obj.data('total-amount'));
        $("#v-admin-fee").text(obj.data('admin-fee'));
        $("#v-transfer-amount").text(obj.data('transfer-amount'));
        $("#wdid").val(obj.data('index'));
        $("#wtoken").val(obj.data('token'));
    }
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
            ajax            : '{{ route("nucash.wd.ajax") }}',
            columnDefs      : [
                    { className: "dt-center", targets: [0, 1, 2, 3, 4, 5] },
            ],
            columns         : [
                {}, {}, {},
                {render : function (data, type, full, meta) {
                        if (data == 1) {
                            return '<span class="btn btn-xs btn-success">Yes</span>';
                        } else {
                            return '<span class="btn btn-xs btn-danger">No</span>';
                        }
                    }
                },
                {render : function (data, type, full, meta) {
                        if (data == 1) {
                            return '<span class="btn btn-xs btn-success">Yes</span>';
                        } else {
                            return '<span class="btn btn-xs btn-danger">No</span>';
                        }
                    }
                },
                {render : function (data, type, full, meta) {
                        if (data == 1) {
                            if(full[4] == 1){
                                return '<span class="text-success">Done</span>';
                            } else {
                                return '<button class="btn btn-xs btn-info btn-action" id="action-' + full[6] + '" data-total-amount="' + full[2] + '" data-admin-fee="' + full[7] + '" data-transfer-amount="' + full[8] + '" data-toggle="modal" data-target="#action-modal" data-token="{{ csrf_token() }}" data-index="' + full[6] + '" onclick="doAction($(this));">Confirm</button>';
                            }    
                        } else{
                            return '<span class="text-muted">On Progress</span>';
                        }
                    }
                },
            ],
        });
        $("div#tbl-nulife_length select, div#tbl-nulife_filter input").addClass('form-control');
    });
    
    $('button#confirm').on('click', function() {
        var konfirm = confirm("Are you to confirm Transfer this withdrawal ?");
        if(konfirm){
            $.ajax({
                type: "POST",
                url: '{{ route("nucash.confirm.member.wd") }}',
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
    
</script>
@endsection