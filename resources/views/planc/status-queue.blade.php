@extends('layouts.main')
@section('header')
    @include('layouts.header')
@endsection
@section('content')
<section class="panel">
    <div class="panel-body">
        <div class="panel-group">
            <div class="panel panel-primary">
                <div class="panel-heading panel-table-heading">Plan-C Board</div>
                <div class="panel-body">
                    @if(!empty($activeC))
                        <?php $nomor = 1; $baris = ''; ?>
                        @foreach($activeC as $row)
                            <?php 
                                $cls = in_array($row->plan_c_code, $myListQueue) ? ' btn-success' : ' btn-info';
                                if ($nomor == 1) {
                                    $baris = '<div class="row"><div class="col-md-4 col-md-offset-4 plan-c-id"><button class="btn' . $cls . ' m-b-10">' . $row->plan_c_code . '</button></div></div>';
                                } else {
                                    if (in_array($nomor, [2, 5, 8, 11])) $baris .= '<div class="row">';
                                    $baris .= '<div class="col-md-4 plan-c-id"><button class="btn' . $cls . ' m-b-10">' . $row->plan_c_code . '</button></div>';
                                    if (in_array($nomor, [4, 7, 10, 13])) $baris .= '</div>';
                                }
                                $nomor++;
                            ?>
                        @endforeach
                        {!! $baris !!}
                    @endif
                </div>
            </div>
            <div class="panel panel-primary">
                <div class="panel-heading panel-table-heading">Queue</div>
                <div class="panel-body">
                    @for ($y = 1; $y <= 25; $y++)
                        <div class="row">
                        @for ($x = 0; $x <= 3; $x++)
                            <?php 
                                $key = $y + ($x * 15);
                            ?>
                            @if (array_key_exists($key, $listQueue) )
                                <div class="col-md-3 plan-c-id text-danger">{{ $listQueue[$key]->text }}</div>
                            @else
                                <div class="col-md-3 plan-c-id">##########</div>
                            @endif
                        @endfor
                        </div>
                    @endfor
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
@section('scripts')
    <style type="text/css">
        .panel {
            border: 1px solid #337ab7;
        }
        .panel-heading {
            text-transform: none;
            padding: 4px
        }
        .panel-body .plan-c-id {text-align: center;}
    </style>
@endsection