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
        <form class="form-horizontal" method="post" action="{{ route('partner.join') }}">
            {{ csrf_field() }}
            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="form-group">
                        <label class="col-md-2 control-label" style="padding-right: 0;">Join As :</label>
                        <div class="col-md-3">
                            <select class="form-control" name="type" id="type-partner">
                                @foreach($listType as $key => $value)
                                    <option value="{{ $value->id }}" data-min-order="{{ $value->min_order }}" data-price="{{ ($value->id == 2) ? $settingPin->pin_type_masterstockis_price : $settingPin->pin_type_stockis_price  }}">{{ $value->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-2 control-label" style="padding-right: 0;">Pin Amount (+Product) :</label>
                        <div class="col-md-3">
                            <label class="form-control no-border" style="padding-left: 0;" id="amount-pin">0</label>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-2 control-label" style="padding-right: 0;">Total Price (Rp) :</label>
                        <div class="col-md-3">
                            <label class="form-control no-border" style="padding-left: 0;" id="total-price">0</label>
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
@section('scripts')
<script type="text/javascript">
    $(document).ready(function() {
        $('#type-partner').on('change', function() {
            var opt = $('option:selected', this);
            var harga   = opt.data('price');
            var amount  = opt.data('min-order');
            $('#amount-pin').text(amount);
            $('#total-price').text((amount * harga).toString() + ',-');
        }).change();
    });
</script>
@endsection