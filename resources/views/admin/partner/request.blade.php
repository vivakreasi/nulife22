@extends('layouts.main')

@section('header')
    @include('layouts.header')
@endsection

@section('content')
<section class="panel">
    <div class="panel-body">
        <form class="form-horizontal" role="form" onsubmit="return false;" id="form-checked">
            {{ csrf_field() }}
            <table class="table table-hover responsive nowrap" id="tbl-nulife">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Code</th>
                        <th>Member</th>
                        <th>Type</th>
                        <th>As Partner</th>
                        <th>Total Pin</th>
                        <th>Total Transfer</th>
                        <th>Company Bank</th>
                        <th> </th>
                        <th>Image</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </form>
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

<script type="text/javascript">
    var nuTable;
    function doAction(obj) {
        var act = obj.data('action');
        var txtConfirm = (act == 1) ? 'confirm' : 'rejet'
        var konfirm = confirm("Are you to " + txtConfirm + " this transfer ?");
            if(konfirm){
                $.ajax({
                    type: "POST",
                    url: '{{ route("admin.partner.confirm") }}',
                    data: {
                        id : obj.data('index'),
                        action : act,
                        _token : obj.data('token')
                    },
                    error: function() {
                        alert('Something Error has occured');
                    }
                }).done(function(html) {
                    html = $.parseJSON(html);
                    if (html.status == 0) {
                        nuTable.ajax.reload();
                    }
                    alert(html.msg);
                });
            }
    }
    $(document).ready(function() {
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
            ajax            : '{{ route("admin.partner.become.ajax") }}',
            columnDefs      : [
                    { className: "dt-right", targets: [6] },
                    { className: "dt-center", targets: [3, 4, 5] },
            ],
            columns         : [
                {}, {}, 
                {render : function (data, type, full, meta) {
                        return data.split('{br}').join('<br>');
                    }
                }, 
                {}, {}, {}, {}, 
                {render : function (data, type, full, meta) {
                        return data.split('{br}').join('<br>');
                    }
                },
                {render : function (data, type, full, meta) {
                        var conten = ['<button class="btn btn-info btn-action" id="action-' + full[10] + '" data-index="' + full[10] + '" data-action="1" data-token="{{ csrf_token() }}" onclick="doAction($(this));">Approve</button>'
                        ];
                        return conten.join(' ');
                    }
                },
                {render : function (data, type, full, meta) {
                        var fUrl = '{{ route("partner.image") }}';
                        var f = fUrl + '?img=' + data;
                        return '<img src="' + f + '" style="max-width:120px;max-height:80px">';
                    }
                }
            ],
        });
        $("div#tbl-nulife_length select, div#tbl-nulife_filter input").addClass('form-control');
        $('#tbl-nulife tbody').on('click', 'tr.odd', function () {
            nuTable.$('tr.selected').removeClass('selected');
            $(this).addClass('selected');
        });
        $('#tbl-nulife tbody').on('click', 'tr.even', function () {
            nuTable.$('tr.selected').removeClass('selected');
            $(this).addClass('selected');
        });
    });
</script>
@endsection