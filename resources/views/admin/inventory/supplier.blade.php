@extends('layouts.main')

@section('header')
    @include('layouts.header')
@endsection

@section('content')
    <section class="panel">
        <div class="panel-body">
            <a href="{{ route('admin.inventory.supplierform',['mode'=>1,'id'=>0]) }}" class="btn btn-info addon-btn m-b-10">
                <i class="fa fa-plus"></i> Add New Supplier
            </a>
            <table class="table table-hover responsive" id="tbl-nulife">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Suplier Name</th>
                    <th>City</th>
                    <th>Contact</th>
                    <th>Phone</th>
                    <th>Email</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                @foreach($suppliers as $row)
                    <tr>
                        <td>{{ $row->id }}</td>
                        <td>{{ $row->name }}</td>
                        <td>{{ $row->city }}</td>
                        <td>{{ $row->contact_name }}</td>
                        <td>{{ $row->contact_phone }}</td>
                        <td>{{ $row->contact_email }}</td>
                        <td>
                            <a href="{{ url('/admin/inventory/supplierform/2/'. $row->id) }}">edit</a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </section>
@endsection