@extends('layouts.main')
@section('header')
    @include('layouts.header')
@endsection
@section('content')
<style type="text/css">
    .no-border {border: none;}
</style>
<section class="panel">
    <div class="panel-body">
        <div class="form-horizontal">
            <div class="panel panel-default">
                <div class="panel-heading">Partner Status</div>
                <div class="panel-body">
                    <div class="row">
                        <label class="col-md-2 control-label" style="padding-right: 0;">Name :</label>
                        <div class="col-md-6">
                            <label class="form-control no-border" style="padding-left: 0;"><strong>{{ Auth::user()->name }}</strong></label>
                        </div>
                    </div>
                    <div class="row">
                        <label class="col-md-2 control-label" style="padding-right: 0;">Partner Status :</label>
                        <div class="col-md-6">
                            <label class="form-control no-border" style="padding-left: 0;">
                                <strong>
                                @if (!$partnerStatus->hasOrder)
                                    {{ $partnerText }}
                                @else
                                    Registering as{{ ($partnerStatus->dataOrder->type_stockist_id == 2) ? ' Master' : '' }} Stockist
                                @endif
                                </strong>
                            </label>
                        </div>
                    </div>
                    <hr>
                    @if (!$partnerStatus->hasOrder)
                        @if (!Auth::user()->isMasterStockis())
                            <div class="row">
                                <div class="col-md-6 col-md-offset-2">
                                    @if (Auth::user()->isStockis())
                                        <a class="btn btn-success" href="{{ route('partner.upgrade') }}">Upgrade To Master Stockist</a>
                                    @else
                                        <a class="btn btn-primary" href="{{ route('partner.join') }}">Join Partner</a>
                                    @endif
                                </div>
                            </div>
                        @endif
                    @else
                        <div class="form-group">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Date</th>
                                        <th>Code</th>
                                        <th>Type</th>
                                        <th>Partner Name</th>
                                        <th>Transfer</th>
                                        <th>Status</th>
                                        <th>#</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>{{ date('Y-m-d H:i', strtotime($partnerStatus->dataOrder->created_at)) }}</td>
                                        <td>{{ $partnerStatus->dataOrder->request_code }}</td>
                                        <td>{{ !Auth::user()->isStockis() ? 'Join' : 'Upgrade' }}</td>
                                        <td>{{ ($partnerStatus->dataOrder->type_stockist_id == 2) ? 'Master ' : '' }}Stockist</td>
                                        <td>Rp {{ number_format($partnerStatus->dataOrder->total_transfer, 0, ',', '.') }},-</td>
                                        <td>
                                            @if ($partnerStatus->dataOrder->status == 1)
                                                Waiting Confirmation
                                            @else
                                                <a class="btn btn-primary" href="{{ route('partner.upload') }}">Upload</a>
                                            @endif
                                        </td>
                                        <td><a href="{{ route('partner.invoice') }}">View Invoice</a></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>
@endsection