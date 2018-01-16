@extends('layouts.main')
@section('header')
    @include('layouts.header')
@endsection
@section('content')
<section class="panel">
    <div class="panel-body">
        <div class="control-table">
            <button id="add-bank" class="btn btn-success addon-btn"><i class="fa fa-plus"></i>&nbsp;&nbsp;Add New Bank</button>
        </div>
        <table class="table table-bordered table-hover responsive nowrap" id="tbl-nulife">
            <thead>
                <tr>
                    <th>Bank Name</th>
                    <th>No.Account</th>
                    <th>Account Name</th>
                    <th>Status</th>
                    <th></th>
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
                    <h4 class="modal-title">Update Bank</h4>
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
                                    <label class="col-md-3 control-label">Status :</label>
                                    <div class="col-md-6">
                                        <h5><strong id="v-status"></strong></h5>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success" id="save">Save</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                </div>
                <div class="hide">
                    <input type="hidden" id="id" value="">
                    <input type="hidden" id="isactive" value="">
                    <input type="hidden" id="text" value="">
                    <input type="hidden" id="wtoken" value="">
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="myEditCompanyBank" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
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
    .toolbar select, div#tbl-nulife_length select {width: auto;}
    .toolbar select, div#tbl-nulife_length select, div#tbl-nulife_filter input, div#tbl-payment_filter input {display: inline;}
    div#tbl-nulife_filter input, div#tbl-payment_filter input {width: 150px;}
    .control-table {display: inline-block; margin-right: 10px;}
    table.dataTable#tbl-payment tbody td {
        word-break: break-all;
        vertical-align: top;
        white-space: normal;
    }
    .table > thead > tr > th {text-align: center;}
</style>

<script type="text/javascript" src="{{ asset('assets/js/vendor/datatables/datatables.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/js/vendor/datatables/DataTables-1.10.13/js/jquery.dataTables.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/js/vendor/datatables/Responsive-2.1.1/js/dataTables.responsive.min.js') }}"></script>

<script type="text/javascript">
    function activateMe(obj) {
        $("#id").val(obj.data('index'));
        $("#v-status").text(obj.data('status'));
        $("#isactive").val(obj.data('isactive'));
        $("#v-bank").text(obj.data('bank'));
        $("#v-bank-account").text(obj.data('nobank'));
        $("#v-account-name").text(obj.data('acc'));
        $("#save").text(obj.data('post'));
        $("#text").val(obj.data('post'));
        $("#wtoken").val(obj.data('token'));
    }
    
    $('button#save').on('click', function() {
        var textnya = $('#text').val();
        var konfirm = confirm("Are you to "+textnya+" This company's bank ?");
        if(konfirm){
            $.ajax({
                type: "POST",
                url: '{{ route("admin.company.bank.update") }}',
                data: {
                    id : $('#id').val(),
                    is_active : $('#isactive').val(),
                    _token : $('#wtoken').val()
                },
                error: function() {
                    alert('Something Error has occured');
                }
            }).done(function(html) {
                html = $.parseJSON(html);
                if (html.status == 0) {
                    $('#confirm-modal').modal('hide');
                    $('#tbl-nulife').DataTable().ajax.reload();
                }
                alert(html.msg);
            });
        }
    });
    
    var myUrl = '{{ route("admin.company.ajax.bank") }}';
    var nuTable;
    $(document).ready(function() {

        nuTable = $('#tbl-nulife').DataTable({
            processing      : true,
            serverSide      : true,
            stateSave       : false,
            scrollCollapse  : true,
            info            : false,
            filter          : false,
            autoWidth       : false,
            paginate        : false,
            ajax            : myUrl,
            columnDefs      : [
                    { className: "dt-center", targets: [3, 4] }
            ],
            columns         : [
                {}, {}, {}, 
                {render : function (data, type, full, meta) {
                            return (data == 1) ? 'Active' : 'Inactive';
                        }
                },
                {render : function (data, type, full, meta) {
                            var status = full[3].toString();
                            var cls = (status == 1) ? 'btn-danger' : 'btn-success';
                            var text = (status == 1) ? 'Disactivate' : 'Activate';
                            var textStatus = (status == 1) ? 'Active' : 'Disactive';
                            var act = ((status == 1) ? 0 : 1).toString();
                            var tombol = [
                                '<button type="button" class="btn ' + cls + '" data-token="{{ csrf_token() }}" data-action="' + act + '" data-index="' + data + '" data-post="' + text + '" data-isactive="' + full[3] + '" data-status="' + textStatus + '"  data-bank="' + full[0] + '" data-nobank="' + full[1] + '" data-acc="' + full[2] + '" onclick="activateMe($(this));" data-toggle="modal" data-target="#confirm-modal">' + text + '</button>',
                                //'<button type="button" class="btn btn-primary" data-index="' + data + '" onclick="showUpdate();">Edit</button>'
                                '<a data-toggle="modal" class="btn btn-primary" href="/admin/company/bank/edit/'+ data +'" data-target="#myEditCompanyBank">Edit</a>'
                            ];
                            return tombol.join(' ');
                        }
                }
            ],
        });
        
        $('#tbl-nulife tbody').on('click', 'tr', function () {
            nuTable.$('tr.selected').removeClass('selected');
            $(this).addClass('selected');
        });

        $('#add-bank').on('click', function() {
            window.location = '{{ route("admin.company.bank.add") }}';
        });

        /*$('button#save').on('click', function() {
            var pyId = $.map(nuTable.rows('.selected').data(), function (item) {return item;});
            if (parseInt(pyId) > 0) {
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
        });*/
    });
</script>
<script type="text/javascript">
    $("#myEditCompanyBank").on("show.bs.modal", function(e) {
        var link = $(e.relatedTarget);
        $(this).find(".modal-content").load(link.attr("href"));
    });
</script>
@endsection