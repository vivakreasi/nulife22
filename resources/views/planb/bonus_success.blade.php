@extends('layouts.main')
@section('header')
    @include('layouts.header')
@endsection
@section('content')
<style type="text/css">
    .table > thead > tr > th {
        /*background-color: #ddf;*/
        text-align: center;
    }
</style>
<section class="panel">
    <div class="panel-body">
        <table class="table table-hover responsive nowrap" id="tbl-nulife">
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Plan-C Code</th>
                    <th>Type</th>
                    <th>Amount</th>
                    <th>Admin Fee</th>
                    <th>Receive</th>
                    <th>WD Status</th>
                </tr>
            </thead>
            <tbody>
                @if (!$bonus->isEmpty())
                    @foreach($bonus as $row)
                        <tr>
                            <td>{{ date('Y-m-d', strtotime($row->created_at)) }}</td>
                            <td>{{ $row->plan_c_code }}</td>
                            <td>
                                @if ($row->bonus_type == 2)
                                    Fly Plan-C
                                @elseif ($row->bonus_type == 1)
                                    Bonus Plan-C
                                @endif
                            </td>
                            <td style="text-align: right;">{{ number_format($row->bonus_amount, 0, ',', '.') }}</td>
                            <td style="text-align: right;">{{ number_format($row->jml_pot_admin, 0, ',', '.') }}</td>
                            <td style="text-align: right;">{{ number_format($row->jml_wd, 0, ',', '.') }}</td>
                            <td style="text-align: center;">{!! $row->status_wd !!}</td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="7" style="text-align: center;">No data available in table</td>
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

<script type="text/javascript" src="{{ asset('assets/js/vendor/datatables/datatables.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/js/vendor/datatables/DataTables-1.10.13/js/jquery.dataTables.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/js/vendor/datatables/Responsive-2.1.1/js/dataTables.responsive.min.js') }}"></script>
<script type="text/javascript">
    $(document).ready(function() {
        $('#tbl-nulife').DataTable({
            autoWidth       : false,
            paginate        : true,
        });
    } );
</script>
@endsection