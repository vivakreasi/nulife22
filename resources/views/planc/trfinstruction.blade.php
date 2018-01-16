@extends('layouts.main')
@section('header')
    @include('layouts.header')
@endsection
@section('content')
<section class="panel">
    <div class="panel-body">
        <form class="form-horizontal" role="form" method="POST" action="{{ route('planc.trfinstruction') }}">
            {{ csrf_field() }}
            <input type="hidden" name="step" value="{{ $step }}">
            @if ($step == 2)
                <div class="form-group">
                    <div class="col-sm-10 col-sm-offset-1 col-lg-10 col-lg-offset-1">
                        <p>Your purchase order has been received and Recorded in our database.</p>
                        <p>Please make a bank transfer <strong>exactly</strong> as shown below. Once we receive your transfer, your plan will activated. <br />
                            <!--code>(No Transfer Confirmation Required)</code--></p>
                        <h4 class="m-t-20">Bank Transfer Detail</h4>
                        <div class="well" id="print">
                            <div class="row">
                                <div class="col-md-3">
                                    <h5>PIN purchase count :</h5>
                                </div>
                                <div class="col-md-9">
                                    <h5><strong>{{ $Instruction->jml_pin }}</strong></h5>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-3">
                                    <h5>Transfer amount :</h5>
                                </div>
                                <div class="col-md-9">
                                    <h4><strong><code>Rp {{ number_format($Instruction->nilai_transfer, 0, ',', '.') }},-</code></strong></h4>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-3">
                                    <h5>Bank :</h5>
                                </div>
                                <div class="col-md-9">
                                    <h5>{{ $Instruction->bank_nama }} <br />account no. <strong>{{ $Instruction->bank_rekening }}</strong><br />account name <strong>{{ $Instruction->bank_pemilik }}</strong></h5>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-3">
                                    <h5>Transfer deadline :</h5>
                                </div>
                                <div class="col-md-9">
                                    <h5><strong>{{ date('M d, Y - H:i:00', strtotime($Instruction->expire)) }} (GMT +7)</strong></h5>
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
            @elseif ($step == 1)
                <div class="row">
                    <div class="col-sm-10 col-sm-offset-1 col-lg-10 col-lg-offset-1">
                        <p>The maximum amount of the purchase is 15 PIN.<br />Unconfirmed purchase and unused PIN will reduce the maximum amount of purchase.</p>
                        <p>Your maximum purchase for now is : <code>{{ $summaryPin->available_order }} PIN</code></p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-10 col-md-offset-1">
                        <div class="well well-lg">
                            <div class="row">
                                <div class="form-group">
                                    <div class="col-sm-10 col-sm-offset-1 col-lg-10 col-lg-offset-1">
                                        <label class="control-label col-md-3" for="amount">Amount of PIN purchase</label>
                                        <div class="col-md-3">
                                            <input type="number" class="form-control" name="amount" id="amount" value="{{ old('amount', 1) }}" min="1" max="{{ $summaryPin->available_order }}" step="1">
                                            <button class="btn btn-info m-t-20" type="submit">
                                                Order
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
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