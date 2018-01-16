@extends('layouts.main')

@section('header')
    @include('layouts.header')
@endsection

@section('content')
    <section class="panel">
        <div class="panel-body">
            <a href="{{ route('admin.inventory.itemform',['mode'=>1,'id'=>0]) }}" class="btn btn-info addon-btn m-b-10">
                <i class="fa fa-plus"></i> Add New Item
            </a>
            <table class="table table-hover responsive" id="tbl-nulife">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>SKU</th>
                    <th>Item Name</th>
                    <th>Item Decription</th>
                    <th>Metric</th>
                    <th>Category</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                @foreach($items as $row)
                    <tr>
                        <td>{{ $row->id }}</td>
                        <td>{{ $row->sku->code }}</td>
                        <td>{{ $row->name }}</td>
                        <td>{{ $row->description }}</td>
                        <td>{{ $row->metric->name }}</td>
                        <td>{{ $row->category->name }}</td>
                        <td>
                            <a href="{{ url('/admin/inventory/itemform/2/'. $row->id) }}">edit</a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </section>
@endsection