@extends('layouts.main')
@section('header')
    @include('layouts.header')
@endsection
@section('content')
<style type="text/css">
    .no-border {border: none;}
    .control-label {padding-right: 0;}
    label.form-control {margin-bottom: 0; padding-left: 0; padding-bottom: 0; height: auto;}
</style>
<section class="panel">
    <div class="panel-body">
        <form class="form-horizontal" method="post" action="{{ route('partner.upgrade') }}">
            {{ csrf_field() }}
            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="form-group">
                        <label class="col-md-2 control-label" style="padding-right: 0;">Join As :</label>
                        <div class="col-md-3">
                            <label class="form-control no-border" style="padding-left: 0;" id="amount-pin">{{ $listType->name }}</label>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-2 control-label" style="padding-right: 0;">Pin Amount (+Product) :</label>
                        <div class="col-md-3">
                            <label class="form-control no-border" style="padding-left: 0;" id="amount-pin">{{ $listType->min_order }}</label>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-2 control-label" style="padding-right: 0;">Total Price (Rp) :</label>
                        <div class="col-md-3">
                            <label class="form-control no-border" style="padding-left: 0;" id="total-price">{{ number_format($settingPin->pin_type_masterstockis_price * $listType->min_order, 0, ',', ',') }},-</label>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-2 control-label" style="padding-right: 0;">Transfer To :</label>
                        <div class="col-md-6">
                            <select class="form-control" name="bank">
                                @foreach($bankCompany as $key => $value)
                                    <option value="{{ $key }}">{{ $value }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <hr>
                    <div class="form-group">
                        <div class="col-md-3 col-md-offset-2">
                            <button class="btn btn-primary" type="submit">Join</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</section>
@endsection
