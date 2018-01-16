@extends('layouts.main')
@section('header')
    @include('layouts.header')
@endsection
@section('content')
<style type="text/css">
    .no-border {border: none; background-color: inherit;}
    .control-label {padding-right: 0;}
    label.form-control {margin-bottom: 0; padding-left: 0; padding-bottom: 0; height: auto;}
</style>
<section class="panel">
    <div class="panel-body">
        <div class="form-horizontal">
            <div class="panel-heading">Your request to be our partner has been received and Recorded in our database</div>
            <div class="panel-body">
                <div class="well" id="print">
                    <div class="row">
                        <label class="col-md-2 control-label">No :</label>
                        <div class="col-md-6">
                            <label class="form-control no-border text-bold">{{ $partnerStatus->dataOrder->request_code }}</label>
                        </div>
                    </div>
                    <div class="row">
                        <label class="col-md-2 control-label">Name :</label>
                        <div class="col-md-6">
                            <label class="form-control no-border text-bold">{{ Auth::user()->name }}</label>
                        </div>
                    </div>
                    <div class="row">
                        <label class="col-md-2 control-label">Date :</label>
                        <div class="col-md-6">
                            <label class="form-control no-border text-bold">{{ date('M d, Y - H:i', strtotime($partnerStatus->dataOrder->created_at)) }} (GMT +7)</label>
                        </div>
                    </div>
                    <div class="row">
                        <label class="col-md-2 control-label">Type :</label>
                        <div class="col-md-6">
                            <label class="form-control no-border text-bold">
                            @if (Auth::user()->isStockis())
                                Upgrade To Master Stockist
                            @else
                                Join Partner As {{ ($partnerStatus->dataOrder->type_stockist_id == 2) ? 'Master ' : '' }}Stockist
                            @endif
                            </label>
                        </div>
                    </div>
                    <div class="row">
                        <label class="col-md-2 control-label">Transfer To :</label>
                        <div class="col-md-6">
                            <label class="form-control no-border text-bold">{{ $partnerStatus->dataOrder->bank_name }}</label>
                            <label class="form-control no-border text-bold">{{ $partnerStatus->dataOrder->bank_account }}</label>
                            <label class="form-control no-border text-bold">{{ $partnerStatus->dataOrder->bank_account_name }}</label>
                        </div>
                    </div>
                    <div class="row">
                        <label class="col-md-2 control-label">Pin Amount :</label>
                        <div class="col-md-6">
                            <label class="form-control no-border text-bold">{{ $partnerStatus->dataOrder->jml_pin }}</label>
                        </div>
                    </div>
                    <div class="row">
                        <label class="col-md-2 control-label">Total Price (Rp) :</label>
                        <div class="col-md-6">
                            <label class="form-control no-border text-bold">{{ number_format($partnerStatus->dataOrder->total_transfer, 0, ',', '.') }},-</label>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-md-4">
                        <a class="btn btn-info addon-btn m-b-10" id="btn_print"><i class="fa fa-print"></i>Print</a>
                        @if ($partnerStatus->statusOrder < 1)
                            <a class="btn btn-primary addon-btn m-b-10" href="{{ route('partner.upload') }}"><i class="fa fa-upload"></i>Upload</a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
@section('scripts')
    <script src="{{ asset('assets/js/vendor/jquery.print.min.js') }}" type="text/javascript"></script>
    <script type="text/javascript">
        $('#btn_print').click(function () {
            $("#print").print();
        })
    </script>
@endsection