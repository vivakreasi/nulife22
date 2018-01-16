@extends('layouts.main')

@section('header')
    @include('layouts.header')
@endsection

@section('vendor_style')
    <link href="{{ asset('assets/css/vendor/select2.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/vendor/select2-bootstrap.css') }}" rel="stylesheet">
@endsection

@section('content')
    @if($type=='B')
        <form class="form-horizontal" role="form" method="post" action="{{ route('plan.product.postclaimb') }}">
    @else
        <form class="form-horizontal" role="form" method="post" action="{{ route('plan.product.postclaimc') }}">
    @endif
        {{ csrf_field() }}
        <input type="hidden" name="code" value="{{ isset($code) ? $code : '' }}">
        <input type="hidden" name="type" value="{{ $type }}">
        <section class="panel">
            <header class="panel-heading">
                Product Info
            </header>
            <div class="panel-body">
                <div class="form-group">
                    <label for="inputEmail1" class="col-lg-2 col-sm-2 control-label">Product</label>
                    <div class="col-lg-9">
                        <label class="control-label"><strong>{{ $product->name }}</strong></label>
                    </div>
                </div>
                <div class="form-group">
                    <label for="inputEmail1" class="col-lg-2 col-sm-2 control-label">Quantity</label>
                    <div class="col-lg-9">
                        <label class="control-label"><strong>1</strong></label>
                    </div>
                </div>
                @if($type=='B')
                <div class="form-group">
                    <label for="inputEmail1" class="col-lg-2 col-sm-2 control-label">Upgrade Plan-B Code</label>
                    <div class="col-lg-9">
                        <label class="control-label"><strong>{{ $code }}</strong></label>
                    </div>
                </div>
                @else
                    <div class="form-group">
                        <label for="inputEmail1" class="col-lg-2 col-sm-2 control-label">Join Plan-C Code</label>
                        <div class="col-lg-9">
                            <label class="control-label"><strong>{{ $code }}</strong></label>
                        </div>
                    </div>
                @endif
            </div>
        </section>
        <section class="panel">
            <header class="panel-heading">
                Delivery Information<br />
                <span class="help-block" style="text-transform: capitalize"><small><em>All fields are mandatory.</em></small></span>
            </header>
            <div class="panel-body">
                <div class="form-group">
                    <label for="delivery_name" class="col-lg-2 col-sm-2 control-label">Delivery to</label>
                    <div class="col-lg-9">
                        <input type="text" class="form-control" id="delivery_name" name="delivery_name" value="{{ $user->name }}" placeholder="Delivery to name">
                        <p class="help-block"></p>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-lg-2 col-sm-2 control-label">Address</label>
                    <div class="col-lg-9">
                        @if($userProfile)
                            <?php $address = $userProfile->alamat ?>
                        @else
                            <?php $address = old('address') ?>
                        @endif
                        <textarea name="address" id="address" class="form-control" id="" cols="30" rows="5">{{ $address }}</textarea>
                    </div>
                </div>
                <div class="form-group">
                    <label for="selprovince" class="col-lg-2 col-sm-2 control-label">Province</label>
                    <div class="col-lg-9">
                        <select class="form-control select2-offscreen" id="selprovince" name="selprovince">
                            <option>Select Province</option>
                            @foreach($provincelist as $province)
                                <option value="{{ $province->id }}" {{ (isset($userProfile) && $userProfile->provinsi==$province->id) ? 'selected' : ((old('selprovince')==$province->id) ? 'selected' : '') }}>{{ $province->nama }}</option>
                            @endforeach
                        </select>
                        <span class="text-danger"><em>{{ ($errors->has('selprovince')) ? $errors->first('selprovince') : '' }}</em></span>
                    </div>
                </div>
                <div class="form-group">
                    <label for="selcity" class="col-lg-2 col-sm-2 control-label"><i id="cityspinner" class="fa fa-spin fa-spinner" style="display:none"></i> City</label>
                    <div class="col-lg-9">
                        <select class="form-control select2-offscreen" id="selcity" name="selcity" disabled>
                            <option>Select City</option>
                            @if (isset($userProfile) && $userProfile->kota!='' && !is_null($userProfile->kota))
                                <option value="{{ $userProfile->kota }}" selected>{{ $userProfile->nama_kota }}</option>
                            @endif
                        </select>
                        <span class="text-danger"><em>{{ ($errors->has('selcity')) ? $errors->first('selcity') : '' }}</em></span>
                    </div>
                </div>
                <div class="form-group">
                    <label for="postcode" class="col-lg-2 col-sm-2 control-label">Postal Code</label>
                    <div class="col-lg-9">
                        <input type="text" class="form-control" id="postcode" name="postcode" placeholder="Postal Code" value="{{ old('postcode') }}">
                    </div>
                </div>
                <div class="form-group">
                    <label for="contactphone" class="col-lg-2 col-sm-2 control-label">Contact Phone</label>
                    <div class="col-lg-9">
                        <input type="text" class="form-control" id="contactphone" name="contactphone" placeholder="Contact Phone Number" value="{{ (isset($user)) ? $user->hp : old('contactphone') }}">
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-lg-offset-2 col-lg-9">
                        <button type="submit" class="btn btn-success">Claim Product</button>
                        <a href="{{ route('plan.product.claim') }}" class="btn btn-default">Cancel</a>
                    </div>
                </div>
            </div>
        </section>
    </form>
@endsection

@section('scripts')
    <script src="{{ asset('assets/js/vendor/select2.js') }}" type="text/javascript"></script>
    <script type="text/javascript">
        $('select').select2();
    </script>
    <script type="text/javascript">
        $(document).ready(function(){
            var selectedprovince = $('#selprovince').val();
            var city = $('#selcity');
            if(selectedprovince){
                var cityspinner = $('#cityspinner');
                city.prop('disabled',true);
                cityspinner.show();
                $.ajax({
                    type: "GET",
                    url: '{{ route("city.ajax") }}/'+selectedprovince,
                    error: function() {
                        alert('Something Error has occured');
                    }
                }).done(function(data) {
                    data = $.parseJSON(data);
                    city.empty();
                    $(data).each(function() {
                        $('<option />', {
                            val: this.id,
                            text: this.nama_kota
                        }).appendTo(city);
                    });
                    city.prop('disabled',false);
                    cityspinner.hide();
                });
            }

            $('#selprovince').on('change', function(){
                var province = $(this);
                var city = $('#selcity');
                var cityspinner = $('#cityspinner');
                city.select2("val", "");
                city.prop('disabled',true);
                cityspinner.show();
                var provname = $('option:selected', province).val();
                $.ajax({
                    type: "GET",
                    url: '{{ route("city.ajax") }}/'+provname,
                    error: function() {
                        alert('Something Error has occured');
                    }
                }).done(function(data) {
                    data = $.parseJSON(data);
                    city.empty();
                    $(data).each(function() {
                        $('<option />', {
                            val: this.id,
                            text: this.nama_kota
                        }).appendTo(city);
                    });
                    city.prop('disabled',false);
                    cityspinner.hide();
                });
            });
        });
    </script>
@endsection