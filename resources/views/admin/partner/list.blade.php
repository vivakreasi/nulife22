@extends('layouts.main')

@section('header')
    @include('layouts.header')
@endsection

@section('content')
<section class="panel">
    <div class="panel-body">
        <div class="control-table">
            <label for="status">Options
                <select id="status" class="form-control">
                    <option value="0"{{ ($status==0) ? " selected" : "" }}>All Partner</option>
                    <option value="1"{{ ($status==1) ? " selected" : "" }}>Stockist</option>
                    <option value="2"{{ ($status==2) ? " selected" : "" }}>Master Stockist</option>
                </select>
            </label>
        </div>
        <table class="table table-hover responsive nowrap" id="tbl-nulife">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Partner Name</th>
                    <th> </th>
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
                    <h4 class="modal-title">Partner</h4>
                </div>
                <div class="modal-body">
                    <div class="form-horizontal">
                        <div class="form-group">
                            <label class="col-md-3 control-label">Partner :</label>
                            <div class="col-md-8">
                                <h5><strong id="partner-name"></strong></h5>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 control-label" for="downto">Downgrade To :</label>
                            <div class="col-md-8">
                                <select id="downto" class="form-control">
                                    <option value="0">Member</option>
                                    <option value="1">Stockist</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 control-label">Reason :</label>
                            <div class="col-md-8">
                                <input class="form-control" type="text" id="reason" value="">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <div style="float: left; display: inline-block;">
                        <p><code>Warning!!!</code> <strong>Downgraded</strong> partner could not recovered.</p>
                    </div>
                    <button type="button" class="btn btn-success" id="confirm">Confirm</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
                <div class="hide">
                    <input type="hidden" id="partner-id" value="">
                    <input type="hidden" id="partner-token" value="">
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
    var myUrl = '{{ route("admin.partner.list.ajax") }}';
    var nuTable;
    function doAction(obj) {
        $("#partner-token").val(obj.data('token'));
        $("#partner-id").val(obj.data('index'));
        $("#partner-name").text(obj.data('account-name') + ' #' + obj.data('account'));
        $("#reason").val('');

        var partid = obj.data('partner');
        var opt = ['<option value="0">Member</option>'];
        if (partid == 2) {
            opt.push('<option value="1">Stockist</option>');
        }
        $('select#downto').empty().append(opt.join('')).val(0);
    }
    $(document).ready(function() {
        var status = {{ $status }};
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
                    { className: "dt-center", targets: [4] },
            ],
            columns         : [
                {}, {}, {}, 
                {search: false, 
                    render: function (data, type, full, meta) {
                        return (data == 2) ? 'Master Stockist' : 'Stockist';
                    }
                }, 
                {orderable: false, searchable: false, render : function (data, type, full, meta) {
                        return '<button class="btn btn-info btn-action" id="action-' + full[0] + '" data-account="' + full[0] + '" data-account-name="' + full[1] + '" data-toggle="modal" data-target="#action-modal" data-token="' + full[5] + '" data-index="' + data + '" data-partner="' + full[3] + '" onclick="doAction($(this));">Downgrade</button>';
                    }
                },
            ],
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
            var konfirm = confirm("Sure to downgrade this partner ?");
            if(konfirm){
                $.ajax({
                    type: "POST",
                    url: '{{ route("admin.partner.downgrade") }}',
                    data: {
                        id : $('#partner-id').val(),
                        to : $('select#downto').val(),
                        reason : $("#reason").val(),
                        _token : $('#partner-token').val()
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
    });
</script>
@endsection