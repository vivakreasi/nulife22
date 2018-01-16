@extends('layouts.main')

@section('header')
    @include('layouts.header')
@endsection

@section('content')
<section class="panel">
    <div class="panel-body">
        <div class="control-table" style="margin-bottom: 5px;">
        </div>
        <table class="table table-hover responsive" id="tbl-nulife">
            <thead>
                <tr>
                    <th>No</th>
                    <th>View</th>
                    <th>Image</th>
                    <th>Title</th>
                    <th>Sort Desc</th>
                    <th>Date Created</th>
                </tr>
            </thead>
            <tbody>
                <?php $no = 0; ?>
                @foreach($data as $row)
                    <?php $no++; ?>
                    <tr>
                        <td class="dt-center">{{$no}}</td>
                        <td class="dt-center"><a href="/detail/news/member/{{$row->id}}" class="btn btn-xs btn-primary">view</a></td>
                        <td class="dt-center"><img src="{{$row->image_url}}" style="height:100px;max-width: 134px;"></td>
                        <td>{{$row->title}}</td>
                        <td><?php echo $row->sort_desc; ?></td>
                        <td>{{date('d-F-Y H:i', strtotime($row->created_at))}}</td>
                    </tr>
                @endforeach
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
    .table > thead > tr > th {
        text-align: center;
        vertical-align: middle;
    }
    div#tbl-nulife_length select {width: auto;}
    div#tbl-nulife_length select, div#tbl-nulife_filter input {display: inline;}
    div#tbl-nulife_filter input {width: 150px;}
    table.dataTable > tbody > tr.child span.dtr-title {min-width: 1px;}
</style>

<script type="text/javascript" src="{{ asset('assets/js/vendor/datatables/datatables.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/js/vendor/datatables/DataTables-1.10.13/js/jquery.dataTables.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/js/vendor/datatables/Responsive-2.1.1/js/dataTables.responsive.min.js') }}"></script>

<script type="text/javascript">
    $(document).ready(function() {
        $('#tbl-nulife').DataTable();
    } );
</script>
@endsection