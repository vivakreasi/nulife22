@extends('layouts.main')
@section('header')
    @include('layouts.header')
@endsection
@section('content')
        <section class="panel-group">
            <div class="panel panel-primary member-panel">
                <div class="panel-heading member-panel-heading">Members Transfer Referral</div>
                <div class="panel-body">
                    <table class="table table-bordered table-hover responsive nowrap" id="tbl-nulife">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>From</th>
                                <th>Bank</th>
                                <th>Nominal (Rp.)</th>
                                <th>Hak Usaha</th>
                                <th>Detail</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if (!$data->isEmpty())
                                <?php $no = 0; ?>
                                @foreach($data as $row)
                                    <?php $no++; ?>
                                    <tr>
                                        <td>{{ $no }}</td>
                                        <td>{{ $row->name }}</td>
                                        <td>{{ $row->bank }}</td>
                                        <td>{{number_format($row->price, 0, ',', '.')}}</td>
                                        <td>{{ $row->hak_usaha }}</td>
                                        <td><a href="{{ route('confirm.referal', ['id' => $row->id]) }}" class="btn btn-info btn-sm">detail</a></td>
                                    </tr>
                                @endforeach
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </section>
@endsection