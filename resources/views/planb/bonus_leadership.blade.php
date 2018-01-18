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
                    <th>From</th>
                    <th>Amount</th>
                    <th>WD Status</th>
                </tr>
            </thead>
            <tbody>
                @if (!$bonus->isEmpty())
                    <?php
                        $list_index = 0;
                        $startData  = clone $bonus->first();
                        $list_wd  = (object) array(
                            'jumlah'    => explode(',', $startData->list_jml_bonus_wd),
                            'status'    => explode(',', $startData->list_status_wd),
                            'date'      => explode(',', $startData->list_date_wd),
                            'r_note'    => explode(',', $startData->list_reject_note),
                        );
                        $jmlCurrent = $list_wd->jumlah[0];
                        $maxIndex   = ($jmlCurrent > 0) ? count($list_wd->jumlah) - 1 : -1;
                    ?>
                    @foreach($bonus as $row)
                        <tr>
                            <td>{{ date('Y-m-d H:i', strtotime($row->created_at)) }}</td>
                            <td>{{ $row->from_userid }}</td>
                            <td style="text-align: right;">{{ number_format($row->bonus_amount, 0, ',', '.') }}</td>
                            <td style="text-align: center;">
                                <?php
                                    if ($jmlCurrent > 0 && $list_index <= $maxIndex) {
                                        $statusID = $list_wd->status[$list_index];
                                        if ($statusID == 1) {
                                            echo "OK";
                                        } elseif ($statusID == 2) {
                                            echo "Reject<br>" . $list_wd->r_note[$list_index];
                                        } else {
                                            echo "On Process";
                                        }
                                        $jmlCurrent -= $row->bonus_amount;
                                        if ($jmlCurrent <= 0) {
                                            $list_index += 1;
                                            if ($list_index <= $maxIndex) {
                                                $jmlCurrent = $list_wd->jumlah[$list_index];
                                            }
                                        }
                                    } else {
                                        echo '-';
                                    }
                                ?>
                            </td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="3" style="text-align: center;">No data available in table</td>
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