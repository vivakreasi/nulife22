@extends('layouts.main')

@section('header')
    @include('layouts.header')
@endsection

@section('content')
    <section class="panel">
        <div class="panel-body">
            <a href="{{ route('admin.inventory.metricform',['mode'=>1,'id'=>0]) }}" class="btn btn-info addon-btn m-b-10">
                <i class="fa fa-plus"></i> Add New Metric
            </a>
            <table class="table table-hover responsive" id="tbl-nulife">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Metric Name</th>
                    <th>Metric Symbol</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                @foreach($metrics as $row)
                    <tr>
                        <td>{{ $row->id }}</td>
                        <td>{{ $row->name }}</td>
                        <td>{{ $row->symbol }}</td>
                        <td>
                            <a href="{{ url('/admin/inventory/metricform/2/'. $row->id) }}">edit</a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </section>
@endsection