@extends('layouts.main')

@section('header')
    @include('layouts.header')
@endsection

@section('content')
<section class="panel">
    <div class="panel-body">
        <div class="control-table" style="margin-bottom: 5px;">
            <select id="selectbox" class="btn btn-success addon-btn" name="" onchange="javascript:location.href = this.value;">
                <option value="{{ route('admin.member.not.wd.list') }}">- Select Excel -</option>
                @for($x = 1; $x <= $number; $x++)
                    <option value="{{ route('admin.member.not.wd.xls', ['no' => $x]) }}">Export Excel Part {{$x}}</option>
                @endfor
            </select>
        </div>
        <table class="table table-hover responsive" id="tbl-nulife">
            <thead>
                <tr>
                    <th>User ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>All Bonus</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>
    <div class="modal fade" id="myModalBonus" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
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
            ajax            : '{{ route("admin.member.not.wd.ajax") }}',
            columnDefs      : [
                    { className: "dt-center", targets: [0, 1, 2, 3] },
            ],
            columns         : [
                {}, {}, {}, 
                {render : function (data, type, full, meta) {
                        return '<a data-toggle="modal" href="/admin/member/not/detail/wd-ajax/'+ full[3] +'" class="btn btn-xs btn-primary" data-target="#myModalBonus">Details</a>';
                    }
                },
            ],
            order: [[ 0, "asc" ]],
        });
        $('.dataTables_filter input').unbind().keyup(function(e) {
            var value = $(this).val();
            if (e.keyCode == 13) {
                nuTable.search(value).draw();
            }      
        });
        $("div#tbl-nulife_length select, div#tbl-nulife_filter input").addClass('form-control');
    });
    
</script>
<script type="text/javascript">
    $("#myModalBonus").on("show.bs.modal", function(e) {
        var link = $(e.relatedTarget);
        $(this).find(".modal-content").load(link.attr("href"));
    });
</script>
@endsection