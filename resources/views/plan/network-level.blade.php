@extends('layouts.main')
@section('header')
    @include('layouts.header')
@endsection
@section('content')
    <section class="panel">
        <div class="panel-body">
            <div class="col-md-10 col-md-offset-1">
                <div class="form-horizontal" style="margin-bottom: 15px;">
                    <div class="col-md-6">
                        <div class="btn-group btn-group-tree">
                            <button class="btn btn-primary" id="back-to-me" onclick="window.location='{{ route('plan.network.level') }}';">Back To Me</button>
                            <button class="btn btn-success" onclick="jQuery('#plan-structure').treetable('expandAll'); return false;">Expand All</button>
                            <button class="btn btn-info" onclick="jQuery('#plan-structure').treetable('collapseAll'); return false;">Collapse All</button>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div  style="display: block; float: right;">
                            <div class="input-group">
                                <input type="text" class="form-control search-control" placeholder="Search member in your structure" id="search-id"/>
                                <span id="search" class="input-group-addon btn-search" style="font-weight: bold">Search</span>
                            </div>
                        </div>
                    </div>
                </div>
                <table id="plan-structure">
                    <thead>
                        <tr>
                            <th class="tree-cell-center">Code - Name</th>
                            <th class="tree-cell-center">Level</th>
                            {{--
                            <th class="tree-cell-center">Left</th>
                            <th class="tree-cell-center">Right</th>
                            --}}
                            <th class="tree-cell-center">Plan Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if (!empty($struktur))
                            <?php $nomor = 1; ?>
                            @foreach($struktur as $row)
                                <tr data-tt-id="{{ $row->kode }}" data-tt-parent-id="{{ $row->parent_kode }}">
                                    <td>
                                        <span class="fa fa-user"></span>&nbsp;
                                        @if ($nomor > 1)
                                            <a href="{{ route('plan.network.level', $row->userid) }}">
                                                {{ $row->userid }} - {{ $row->name }}
                                            </a>
                                        @else
                                            {{ $row->userid }} - {{ $row->name }}
                                        @endif
                                    </td>
                                    <td class="tree-cell-right">{{ $row->level }}</td>
                                    {{--
                                    <td class="tree-cell-right">{{ number_format($row->kiri, 0, '.', ',') }}</td>
                                    <td class="tree-cell-right">{{ number_format($row->kanan, 0, '.', ',') }}</td>
                                    --}}
                                    <td class="tree-cell-center">{{ ($row->plan_status == 3) ? 'B' : 'A' }}</td>
                                </tr>
                                <?php $nomor++; ?>
                            @endforeach
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </section>
@endsection
@section('scripts')
    @if (!empty($struktur))
        <style type="text/css">
            @import url("{{ asset('assets/js/vendor/ludo-jquery-treetable/css/jquery.treetable.css') }}");
            @import url("{{ asset('assets/js/vendor/ludo-jquery-treetable/css/jquery.treetable.theme.default.css') }}");
        </style>
        <style type="text/css">
            table.treetable {font-size: 12px;}
            table.treetable thead tr th {
                font-weight: bold;
            }
            table.treetable thead tr th.tree-cell-center, table.treetable tbody tr td.tree-cell-center {text-align: center;}
            table.treetable thead tr th.tree-cell-right, table.treetable tbody tr td.tree-cell-right {text-align: right;}
            table.treetable tbody tr.selected td, table.treetable tbody tr.selected td a:not(:hover) {color: #d9edf7;}
            .btn-search {cursor: pointer;}
            .btn-group-tree .btn {padding: 4px 8px;}
            .search-control {height: 30px;}
        </style>
        <script src="{{ asset('assets/js/vendor/jquery-ui.min.js') }}" type="text/javascript"></script>
        <script src="{{ asset('assets/js/vendor/ludo-jquery-treetable/jquery.treetable.js') }}" type="text/javascript"></script>
        <script type="text/javascript">
            $(document).ready(function() {
                $("#plan-structure").treetable({
                    expandable  : true,
                    initialState: 'expanded'
                });
                // Highlight selected row
                $("#plan-structure tbody").on("mousedown", "tr", function() {
                    $(".selected").not(this).removeClass("selected");
                    $(this).toggleClass("selected");
                });
                $('#search').on('click', function(){
                    var url = "{{ route('plan.network.level') }}";
                    var id = $('#search-id').val();
                    if (id) {
                        window.location = url + '/' + id.toString();
                    }
                });
            });
        </script>
    @endif
@endsection

