@extends('layouts.main')

@section('header')
    @include('layouts.header')
@endsection

@section('content')
    <section class="panel">
        <div class="panel-body">
            <a href="{{ route('admin.inventory.locationform',['mode'=>1,'id'=>0]) }}" class="btn btn-info addon-btn m-b-10">
                <i class="fa fa-plus"></i> Add New Location
            </a>
            <table class="table table-hover responsive" id="tbl-nulife">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Location Name</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                @foreach($locations as $row)
                    <tr>
                        <td>{{ $row->id }}</td>
                        <td>{{ $row->name }}</td>
                        <td>
                            <a href="{{ url('/admin/inventory/locationform/2/'. $row->id) }}">edit</a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </section>
@endsection