@extends('layouts.main')

@section('header')
    @include('layouts.header')
@endsection

@section('content')
<section class="panel">
    <div class="panel-body">
        <div class="control-table" style="margin-bottom: 5px;">
            <a href="{{ route('admin.report.bonus.global.xls') }}" class="btn btn-success addon-btn" id="action-excel" target="_blank"><i class="fa fa-file-excel-o"></i>&nbsp;&nbsp;Export to Excel</a>
        </div>
        <table class="table table-hover responsive" id="tbl-nulife">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Date</th>
                    <th>Placement PIN</th>
                    <th>Sponsor</th>
                    <th>Pairing</th>
                    <th>Upgrade Plan B</th>
                    <th>Fly Plan C</th>
                    <th>Ranking</th>
                </tr>
            </thead>
            <tbody>
                <?php $noA = 0; ?>
                @foreach($data as $row)
                    <?php $noA++; ?>
                    <tr>
                        <td class=" dt-center">{{$noA}}</td>
                        <td class=" dt-center">{{$row->date}}</td>
                        <td class=" dt-center">{{$row->placement_pin}}</td>
                        <td class=" dt-center">{{$row->sponsor}}</td>
                        <td class=" dt-center">{{$row->pairing}}</td>
                        <td class=" dt-center">{{$row->upgrade_plan_b}}</td>
                        <td class=" dt-center">{{$row->fly_plan_c}}</td>
                        <td class=" dt-center">{{$row->ranking}}</td>
                    </tr>
                @endforeach
                
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
    $(document).ready(function() {
        $('#tbl-nulife').DataTable();
    } );
</script>
@endsection