@extends('layouts.main')

@section('header')
    @include('layouts.header')
@endsection

@section('content')
    <section class="panel">
        <div class="panel-body">
            <h4>Product Plan-B</h4>
            <table class="table table-hover responsive" id="tbl-nulife">
                <thead>
                    <tr>
                        <th>Code</th>
                        <th>Quantity</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                @if(!empty($datab))
                    <tr>
                        <td>{{ $datab->upgrade_kode }}</td>
                        <td>1</td>
                        @if($datab->status==2 && is_null($datab->claim_status))
                            <td>
                                <a href="{{ route('plan.product.claimb', ['code' => $datab->upgrade_kode]) }}" class="btn btn-success">Claim Product</a>
                            </td>
                        @else
                            <td>
                                <span class="label label-warning">on process</span>
                            </td>
                        @endif
                    </tr>
                @else
                    <tr>
                        <td colspan="4" class="text-center">Tidak ada data</td>
                    </tr>
                @endif
                </tbody>
            </table>
        </div>
    </section>
    <section class="panel">
        <div class="panel-body">
            <h4>Product Plan-C</h4>
            <table class="table table-hover responsive" id="tbl-nulife">
                <thead>
                <tr>
                    {{--<th><input type="checkbox" id="checkAll"></th>--}}
                    <th>Code</th>
                    <th>Quantity</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                @if(!empty($datac))
                    @foreach($datac as $item)
                    <tr>
                        {{--<td><input type="checkbox" id="chk-planc" value="{{ $item->plan_c_code }}"></td>--}}
                        <td>{{ $item->plan_c_code }}</td>
                        <td>1</td>
                        @if(is_null($item->claim_status))
                            <td>
                                <a href="{{ route('plan.product.claimc', ['code' => $item->plan_c_code]) }}" class="btn btn-success">Claim Product</a>
                            </td>
                        @else
                            <td>
                                <span class="label label-warning">on process</span>
                            </td>
                        @endif
                    </tr>
                    @endforeach
                    {{--<tr>--}}
                        {{--<td colspan="4">--}}
                            {{--<a href="#" class="btn btn-info">Claim Checked Item</a>--}}
                        {{--</td>--}}
                    {{--</tr>--}}
                @else
                    <tr>
                        <td colspan="4" class="text-center">Tidak ada data</td>
                    </tr>
                @endif
                </tbody>
            </table>
        </div>
    </section>
@endsection

@section('scripts')
    <script type="text/javascript">
//        $("#checkAll").click(function(){
//            $('input:checkbox').not(this).prop('checked', this.checked);
//        });
    </script>
@endsection