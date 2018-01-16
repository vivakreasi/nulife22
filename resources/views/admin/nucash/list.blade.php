@extends('layouts.main')

@section('header')
    @include('layouts.header')
@endsection

@section('content')
<section class="panel">
    <div class="panel-body">
        <div class="control-table" style="margin-bottom: 5px;">
            <a href="{{ route('admin.nucash.xls') }}" class="btn btn-success addon-btn" id="action-excel" target="_blank"><i class="fa fa-file-excel-o"></i>&nbsp;&nbsp;Export Excel</a>
            <a href="{{ route('admin.nucash.xls.payroll') }}" class="btn btn-success addon-btn" id="action-excel" target="_blank"><i class="fa fa-file-excel-o"></i>&nbsp;&nbsp;Payroll Excel</a>
        </div>
        <table class="table table-hover responsive" id="tbl-nulife">
            <thead>
                <tr>
                    <?php /*
                    <th>Date</th>
                    <th>Bank Account</th>
                    <th>ID</th>
                    <th><input type="checkbox" id="select-all" value="1" ></th>
                    <th>Name</th>
                    <th>To be Transfer Rp.</th>
                    <th>Amount Rp.</th>
                    <th>Adm.Charge Rp.</th>
                    <th>Transfer</th>
                    <th>Confirm</th>
                    <th>status</th>
                     * 
                     */
                    ?>
                    <th>Name</th>
                    <th>ID</th>
                    <th>Structure</th>
                    <th>Bank</th>
                    <th>Account</th>
                    <th>Date</th>
                    <th>Amount Rp.</th>
                    <th>Adm Charge Rp. </th>
                    <th>To be Transfer Rp.</th>
                    <th>Transfer</th>
                    <th>Confirm</th>
                    <th>Status </th>
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
                    <h4 class="modal-title">Member Bank Account</h4>
                </div>
                <div class="modal-body">
                    <div class="form-horizontal">
                        <div class="form-group">
                            <div class="col-sm-10 col-sm-offset-1 col-lg-10 col-lg-offset-1">
                                <div class="row">
                                    <label class="col-md-3 control-label">Bank Name :</label>
                                    <div class="col-md-6">
                                        <h5><strong id="v-bank"></strong></h5>
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
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
                <div class="hide">
                    <input type="hidden" id="wdid" value="">
                    <input type="hidden" id="wtoken" value="">
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="myModalStructure" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
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
    function doAction(obj) {
        $("#v-bank").text(obj.data('bank'));
        $("#v-bank-account").text(obj.data('account'));
        $("#v-account-name").text(obj.data('account-name'));
        $("#v-amount").text(obj.data('amount'));
        $("#wdid").val(obj.data('index'));
        $("#wtoken").val(obj.data('token'));
    }
    var nuTable;
    $(document).ready(function() {
        function unCheckedAll() {
            $('#tbl-nulife thead input[type="checkbox"]#select-all').prop('checked', false);
        }
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
            "sScrollY" : "scrollY",
            ajax            : '{{ route("admin.nucash.wd.ajax") }}',
            columnDefs      : [
                    { className: "dt-center", targets: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11] },
            ],
            columns         : [
                {render : function (data, type, full, meta) {
                        return  full[0];
                    }
                },
                {render : function (data, type, full, meta) {
                        return  full[1];
                    }
                },
                {render : function (data, type, full, meta) {
                        if (full[2] == 1) {
                            return '<a data-toggle="modal" href="/admin/ajax/structure/'+ full[14] +'" data-target="#myModalStructure">Details</a>';
                        }
                    }
                },
                {render : function (data, type, full, meta) {
                        return  full[3];
                    }
                },
                {render : function (data, type, full, meta) {
                        return  full[4];
                    }
                },
                {render : function (data, type, full, meta) {
                        return  full[5];
                    }
                },
                {render : function (data, type, full, meta) {
                        return  full[6];
                    }
                },
                {render : function (data, type, full, meta) {
                        return  full[7];
                    }
                },
                {render : function (data, type, full, meta) {
                        return  full[8];
                    }
                },
                {render : function (data, type, full, meta) {
                        if (full[9] == 1) {
                            return '<span class="btn btn-xs btn-success">Yes</span>';
                        } else {
                            return '<span class="btn btn-xs btn-danger">No</span>';
                        }
                    }
                },
                {render : function (data, type, full, meta) {
                        if (full[10] == 1) {
                            return '<span class="btn btn-xs btn-success">Yes</span>';
                        } else {
                            return '<span class="btn btn-xs btn-danger">No</span>';
                        }
                    }
                },
                {render : function (data, type, full, meta) {
                        if (full[9] == 0) {
                            return '<button class="btn btn-xs btn-info btn-action" id="action-' + full[12] + '" data-bank="' + full[2] + '" data-account="' + full[3] + '" data-account-name="' + full[0] + '" data-toggle="modal" data-target="#action-modal" data-amount="' + full[8] + '" data-token="{{ csrf_token() }}" data-index="' + full[12] + '" onclick="doAction($(this));">Action</button>';
                        } else{
                            if(full[10] == 1){
                                return 'Done';
                            } else {
                                return 'Process Confirm';
                            }    
                        }
                    }
                },
            ],
            "order": [[ 5, "desc" ]],
            fnDrawCallback: function( oSettings ) {
                unCheckedAll();
            }
        });
        $("div#tbl-nulife_length select, div#tbl-nulife_filter input").addClass('form-control');
    });
    
    $('button#confirm').on('click', function() {
        var konfirm = confirm("Are you to confirm Transfer this withdrawal ?");
        if(konfirm){
            $.ajax({
                type: "POST",
                url: '{{ route("admin.confirm.nucash.wd") }}',
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
                        url: '{{ route("admin.confirm.planc.wd.checked") }}',
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
</script>
<script type="text/javascript">
    $("#myModalStructure").on("show.bs.modal", function(e) {
        var link = $(e.relatedTarget);
        $(this).find(".modal-content").load(link.attr("href"));
    });
</script>
@endsection