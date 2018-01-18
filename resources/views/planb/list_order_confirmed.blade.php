@extends('layouts.main')
@section('header')
    @include('layouts.header')
@endsection
@section('content')
<style type="text/css">
    .table > thead > tr > th {
        background-color: #ddf;
        text-align: center;
    }
</style>
<section class="panel">
    <div class="panel-body">
        <table class="table table-bordered table-hover">
            <thead>
                <tr>
                    <th>Tanggal Order</th>
                    <th>Jumlah Pin</th>
                    <th>Harga Pin</th>
                    <th>Status</th>
                    <th>Tanggal Status</th>
                </tr>
            </thead>
            <tbody>
                @if (!$orders->isEmpty())
                    @foreach($orders as $row)
                        <tr>
                            <td>{{ date('Y-m-d', strtotime($row->tgl_order)) }}</td>
                            <td style="text-align: center;">{{ $row->x_jmlpin }}</td>
                            <td style="text-align: right;">Rp 
                                @if (intval($row->harus_transfer) > 0)
                                    {{ number_format($row->harus_transfer, 0, ',', '.') }}
                                @else
                                    {{ number_format($row->transfer_pin, 0, ',', '.') }}
                                @endif
                                ,-
                            </td>
                            <td>
                                @if ($row->status == 5)
                                    Sukses
                                @elseif ($row->status == 3)
                                    Pending, Sudah Transfer
                                @else
                                    Belum Transfer
                                @endif
                            </td>
                            <td>
                                @if ($row->status == 5)
                                    @if (!empty($row->tgl_approve))
                                        {{ date('Y-m-d', strtotime($row->tgl_approve)) }}
                                    @else
                                        @if (!empty($row->tgl_konfirmasi))
                                            {{ date('Y-m-d', strtotime($row->tgl_konfirmasi)) }}
                                        @else
                                            {{ date('Y-m-d', strtotime($row->tgl_order)) }}
                                        @endif
                                    @endif
                                @elseif ($row->status == 3)
                                    @if (!empty($row->tgl_konfirmasi))
                                        {{ date('Y-m-d', strtotime($row->tgl_konfirmasi)) }}
                                    @else
                                        {{ date('Y-m-d', strtotime($row->tgl_order)) }}
                                    @endif
                                @else
                                    {{ date('Y-m-d', strtotime($row->tgl_order)) }}
                                @endif
                            </td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="5" style="text-align: center;">Tidak Ada Data</td>
                    </tr>
                @endif
            </tbody>
        </table>
    </div>
</section>
@endsection