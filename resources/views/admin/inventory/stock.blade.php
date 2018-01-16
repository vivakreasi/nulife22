@extends('layouts.main')

@section('header')
    @include('layouts.header')
@endsection

@section('content')
    <section class="panel">
        <div class="panel-body">
            <a href="{{ route('admin.inventory.stockadd') }}" class="btn btn-info addon-btn m-b-10">
                <i class="fa fa-plus"></i> Add New Stock
            </a>
            <table class="table table-hover responsive" id="tbl-nulife">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Item Name</th>
                    <th>Location</th>
                    <th>Stock</th>
                </tr>
                </thead>
                <tbody>
                @foreach($stocks as $row)
                    <tr>
                        <td>{{ $row->id }}</td>
                        <td>{{ $row->item->name }}</td>
                        <td>{{ $row->location->name }}</td>
                        <td>{{ $row->quantity }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </section>
@endsection