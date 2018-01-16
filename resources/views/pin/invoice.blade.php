@extends('layouts.main')
@section('header')
    @include('layouts.header')
@endsection
@section('content')
<section class="panel">
    <div class="panel-body">
        <form class="form-horizontal" role="form" method="POST" action="{{ route('pin.order') }}">
            <div class="form-group">
                <div class="col-sm-10 col-sm-offset-1 col-lg-10 col-lg-offset-1">
                    @if($transaction->transaction_type == 2)
                        <p>Your pin transfer has been succeeded</p>
                    @else
                        <p>Your purchase order has been received and Recorded in our database.</p>
                    @endif
                    @if($confirm_order)
                    <h4 class="m-t-20">Thank you for the confirmation, We will review your order.</h4>
                    <div class="well">
                        <div class="row">
                            <div class="col-md-2">
                                <h5><a href="{{ route('pin.confirm.image') }}?img={{ $confirm_order->filename }}" target="_blank" class="btn btn-xs btn-default"><img src="{{ route('pin.confirm.image') }}?img={{ $confirm_order->filename }}" class="img-responsive"></a></h4>
                            </div>
                            <div class="col-md-4">
                                <h4>Bank : <strong><code>{{ $confirm_order->bank_name }}</code></strong></h4>
                                <h4>Account Number : <strong><code>{{ $confirm_order->account_no }}</code></strong></h4>
                                <h4>Account Name : <strong><code>{{ $confirm_order->account_name }}</code></strong></h4>
                            </div>
                        </div>
                    </div>
                    @endif
                    <h4 class="m-t-20">{{ (($transaction->transaction_type != 2) ? "Bank " : "Pin ") }}Transfer Detail</h4>
                    <div class="well" id="print">
                    	<div class="row">
                            <div class="col-md-3">
                                <h5>Transaction Code :</h5>
                            </div>
                            <div class="col-md-9">
                                <h4><strong><code>{{ $transaction->transaction_code }}</code></strong></h4>
                            </div>
                        </div>
                    	<div class="row">
                            <div class="col-md-3">
                                <h5>Detail :</h5>
                            </div>
                            <div class="col-md-9">
                            	<table class='table'>
                            		<thead>
                            			<tr>
                            				<td><strong>Name</strong></td>
                                            @if($transaction->transaction_type != 2)
                                                <td><strong>Each Price</strong></td>
                                            @endif
                            				<td><strong>Amount</strong></td>
                            				<!-- <td><strong>Total Price</strong></td> -->
                            			</tr>
                            		</thead>
                            		<tbody>
                            		@foreach($list as $key)
                                        @php
                                        if( substr($transaction->transaction_code,0,3) == 'OLD' ){
                                            $price = 350000;
                                        }
                                        else{
                                            if(Auth::user()->isStockis()){
                                                if(Auth::user()->isMasterStockis()){
                                                    $price = $key->ref_pin_type->pin_type_masterstockis_price;
                                                }
                                                else{
                                                    $price = $key->ref_pin_type->pin_type_stockis_price;
                                                }
                                            }
                                            else{
                                                $price = $key->ref_pin_type->pin_type_price;
                                            }
                                        }
                                        @endphp
	                            		<tr>
	                            			<td>{{ $key->ref_pin_type->pin_type_name }}</td>
                                            @if($transaction->transaction_type != 2)
                                                <td>Rp {{ number_format($price, 0, ',', '.') }},-</td>
                                            @endif
                                            <td>{{ $key->amount }}</td>
	                            			<!-- <td><strong>Rp {{ number_format($price*$key->amount, 0, ',', '.') }},-</strong></td> -->
	                            		</tr>
	                            	@endforeach
	                            	</tbody>
                            	</table>
                            </div>
                        </div>
                        @if($transaction->from == 0)
                        <div class="row">
                            <div class="col-md-3">
                                <h5>Unique Digit :</h5>
                            </div>
                            <div class="col-md-9">
                                <h4><strong><code><i>
                                    {{ $transaction->unique_digit }}
                                </i></code></strong></h4>
                            </div>
                        </div>
                        @endif
                        @if($transaction->transaction_type != 2)
                        <div class="row">
                            <div class="col-md-3">
                                <h5>Transfer amount :</h5>
                            </div>
                            <div class="col-md-9">
                                <h4><strong><code>
                                @if($transaction->from == 0)
                                    Rp {{ number_format(($transaction->total_price+round($transaction->unique_digit)), 0, ',', '.') }},-
                                @else
                                    Rp {{ number_format($transaction->total_price, 0, ',', '.') }},-
                                @endif
                                </code></strong></h4>
                            </div>
                        </div>
                        @endif
                        <div class="row">
                            @if($transaction->transaction_type == 1 || $transaction->transaction_type == 3)
                            <div class="col-md-3">
                                <h5>Bank :</h5>
                            </div>
                            <div class="col-md-9">
                                @if($from)
                                    @if($transaction->from == 0)
                                    <h5>{{ $from->bank_name }} <br />account no. <strong>{{ $from->bank_account }}</strong><br />account name <strong>{{ $from->bank_account_name }}</strong></h5>
                                    @else
                                    <h5>{{ $from->bank_name }} <br />account no. <strong>{{ $from->account_no }}</strong><br />account name <strong>{{ $from->account_name }}</strong></h5>
                                    @endif
                                @else
                                    @if($transaction->from == 0)
                                    <h5>Bank Not Found (Ask <i>Admin</i> to add an active bank)</h5>
                                    @else
                                    <h5>Bank Not Found (Ask <i>{{ $transaction->ref_from->userid }} [{{$transaction->ref_from->name}})</i> to add an active bank)</h5>
                                    @endif
                                @endif
                            </div>
                            @else
                            <div class="col-md-3">
                                @if($transaction->from == 0)
                                <h5>Transfer From :</h5>
                                @else
                                <h5>Transfer To :</h5>
                                @endif
                            </div>
                            <div class="col-md-9">
                                @if($transaction->from == 0)
                                <h5><strong>Admin</strong></h5>
                                @else
                                <h5><strong>{{ $transaction->ref_to->userid }}</strong><br>{{ $transaction->ref_to->name }}</h5>
                                @endif
                            </div>
                            @endif
                        </div>
                        <div class="row">
                            <div class="col-md-3">
                                <h5>Time :</h5>
                            </div>
                            <div class="col-md-9">
                                <h5><strong>{{ date('M d, Y - H:i:00', strtotime($transaction->created_at)) }} (GMT +7)</strong></h5>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3">
                                <h5>Status :</h5>
                            </div>
                            <div class="col-md-9">
                                @if($transaction->transaction_type == 2)
                                    <h5><strong>Success</strong></h5>
                                @else
                                    <h5><strong>{{ ($transaction->status == 0 ? 'Pending' : ($transaction->status == 1 ? 'Transfered' : ($transaction->status == 2 ? 'Approved' : 'Cancelled'))) }}</strong></h5>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="col-lg-10 col-lg-offset-1">
                    <a class="btn btn-info addon-btn m-b-10" id="btn_print">
                        <i class="fa fa-print"></i>
                        Print
                    </a>
                </div>
            </div>
        </form>
    </div>
</section>
@endsection
@section('scripts')
    <script src="{{ asset('assets/js/vendor/jquery.print.min.js') }}" type="text/javascript"></script>
    <script type="text/javascript">
        $('#btn_print').click(function () {
            $("#print").print(/*options*/);
        })
    </script>
@endsection