@extends('layouts.main')

@section('header')
    @include('layouts.header')
@endsection

@section('content')
<section class="panel">
    <div class="panel-body">
        <div class="control-table" style="margin-bottom: 5px;">
            <!--<a href="{{ route('admin.excel.planc.wdpayroll') }}" class="btn btn-success addon-btn" id="action-excel" target="_blank"><i class="fa fa-file-excel-o"></i>&nbsp;&nbsp;Export to Excel (Payroll)</a> -->
            <!--<button id="submit-checked" class="btn btn-success addon-btn"><i class="fa fa-check-square-o"></i>&nbsp;&nbsp;Confirm Checked</button> -->
        </div>
        <table class="table table-hover responsive" id="tbl-nulife">
            <thead>
                <tr>
                    <th>User ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Active</th>
                    <th>Join Type</th>
                    <th>#</th>
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
            <?php
                if(Route::currentRouteName()=='admin.member.list'){
                    $routeajax = 'admin.member.ajax';
                }elseif(Route::currentRouteName()=='admin.planbmember.list'){
                    $routeajax = 'admin.planbmember.ajax';
                }
            ?>
            ajax            : '{{ route($routeajax) }}',
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
                {},
                {render : function (data, type, full, meta) {
                            return '<a href="/admin/view/member/'+ data +'" class="btn btn-xs btn-primary">View</a>';
                        
                    }
                },
            ],
            order: [[ 0, "desc" ]],
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
@endsection