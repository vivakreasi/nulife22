@extends('layouts.main')
@section('header')
    @include('layouts.header')
@endsection
@section('content')
<section class="panel">
    <div class="panel-body">
        <table class="table table-hover responsive nowrap" id="tbl-nulife">
            <thead>
                <tr>
                    <th>Plan-C ID</th>
                    <th>Status</th>
                    <th>Date Join</th>
                    <th>Date Fly</th>
                </tr>
            </thead>
            <tbody>
                @if (!$myPlanC->isEmpty())
                    @foreach($myPlanC as $row)
                        <tr>
                            <td style="text-align: center;">{{ $row->plan_c_code }}</td>
                            <td style="text-align: center;">{{ empty($row->fly_at) ? 'In Queue' : 'Flyed' }}</td>
                            <td style="text-align: center;">{{ date('Y-m-d H:i', strtotime($row->created_at)) }}</td>
                            <td style="text-align: center;">
                                @if (!empty($row->fly_at))
                                    {{ date('Y-m-d H:i', strtotime($row->fly_at)) }}
                                @endif
                            </td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="4" style="text-align: center;">No data available in table</td>
                    </tr>
                @endif
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
    .table.dataTable > thead > tr > th {
        text-align: center;
    }
</style>


<script type="text/javascript" src="{{ asset('assets/js/vendor/datatables/datatables.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/js/vendor/datatables/DataTables-1.10.13/js/jquery.dataTables.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/js/vendor/datatables/Responsive-2.1.1/js/dataTables.responsive.min.js') }}"></script>
<script type="text/javascript">
    $(document).ready(function() {
        $('#tbl-nulife').DataTable({
            autoWidth       : false,
            paginate        : true,
            sort            : false
        });
    } );
</script>
@endsection