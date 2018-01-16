@extends('layouts.main')

@section('header')
    @include('layouts.header')
@endsection

@section('vendor_style')
    <link href="{{ asset('assets/css/vendor/select2.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/vendor/select2-bootstrap.css') }}" rel="stylesheet">
@endsection

@section('content')
    <section class="panel">
        <header class="panel-heading">
            {{ $subtitle }}
        </header>
        <div class="panel-body">
            <form class="form-horizontal" role="form" method="post" action="{{ route('admin.inventory.supplierformpost') }}">
                {{ csrf_field() }}
                <input type="hidden" name="id" value="{{ isset($data) ? $data->id : '' }}">
                <input type="hidden" name="mode" value="{{ $mode }}">
                <div class="form-group {{ ($errors->has('suppliername')) ? 'has-error' : '' }}">
                    <label for="itemname" class="col-lg-3 col-lg-offset-1 control-label">Supplier Name</label>
                    <div class="col-lg-6">
                        <input type="text" class="form-control" id="suppliername" name="suppliername" placeholder="Supplier Name" value="{{ (isset($data)) ? $data->name : old('suppliername') }}">
                        <span class="text-danger"><em>{{ ($errors->has('suppliername')) ? $errors->first('suppliername') : '' }}</em></span>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-lg-3 col-lg-offset-1 control-label">Address</label>
                    <div class="col-lg-6">
                        <textarea class="form-control" id="supplieraddress" name="supplieraddress" cols="30" rows="8" placeholder="Supplier Address">{{ (isset($data)) ? $data->address : old('supplieraddress') }}</textarea>
                    </div>
                </div>
                <div class="form-group {{ ($errors->has('selprovince')) ? 'has-error' : '' }}">
                    <label class="col-lg-3 col-lg-offset-1 control-label">Province</label>
                    <div class="col-lg-6">
                        <select class="form-control select2-offscreen" id="selprovince" name="selprovince">
                            <option>Select Province</option>
                            @foreach($provincelist as $province)
                                <option value="{{ $province->nama }}" {{ (isset($data) && $data->region==$province->nama) ? 'selected' : ((old('selprovince')==$province->nama) ? 'selected' : '') }}>{{ $province->nama }}</option>
                            @endforeach
                        </select>
                        <span class="text-danger"><em>{{ ($errors->has('selprovince')) ? $errors->first('selprovince') : '' }}</em></span>
                    </div>
                </div>
                <div class="form-group {{ ($errors->has('selcity')) ? 'has-error' : '' }}">
                    <label class="col-lg-3 col-lg-offset-1 control-label"><i id="cityspinner" class="fa fa-spin fa-spinner" style="display:none"></i> City</label>
                    <div class="col-lg-6">
                        <select class="form-control select2-offscreen" id="selcity" name="selcity" disabled>
                            <option>Select City</option>
                            @if (isset($data) && $data->city!='' && !is_null($data->city))
                                <option value="{{ $data->city }}" selected>{{ $data->city }}</option>
                            @endif
                        </select>
                        <span class="text-danger"><em>{{ ($errors->has('selcity')) ? $errors->first('selcity') : '' }}</em></span>
                    </div>
                </div>
                <div class="form-group {{ ($errors->has('contactname')) ? 'has-error' : '' }}">
                    <label for="contactname" class="col-lg-3 col-lg-offset-1 control-label">Contact Name</label>
                    <div class="col-lg-6">
                        <input type="text" class="form-control" id="contactname" name="contactname" placeholder="Contact Name" value="{{ (isset($data)) ? $data->contact_name : old('contactname') }}">
                        <span class="text-danger"><em>{{ ($errors->has('contactname')) ? $errors->first('contactname') : '' }}</em></span>
                    </div>
                </div>
                <div class="form-group {{ ($errors->has('contactphone')) ? 'has-error' : '' }}">
                    <label for="contactphone" class="col-lg-3 col-lg-offset-1 control-label">Phone</label>
                    <div class="col-lg-6">
                        <input type="text" class="form-control" id="contactphone" name="contactphone" placeholder="Contact Phone Number" value="{{ (isset($data)) ? $data->contact_phone : old('contactphone') }}">
                        <span class="text-danger"><em>{{ ($errors->has('contactphone')) ? $errors->first('contactphone') : '' }}</em></span>
                    </div>
                </div>
                <div class="form-group {{ ($errors->has('contactfax')) ? 'has-error' : '' }}">
                    <label for="contactfax" class="col-lg-3 col-lg-offset-1 control-label">Fax</label>
                    <div class="col-lg-6">
                        <input type="text" class="form-control" id="contactfax" name="contactfax" placeholder="Contact Fax Number" value="{{ (isset($data)) ? $data->contact_fax : old('contactfax') }}">
                        <span class="text-danger"><em>{{ ($errors->has('contactfax')) ? $errors->first('contactfax') : '' }}</em></span>
                    </div>
                </div>
                <div class="form-group {{ ($errors->has('contactemail')) ? 'has-error' : '' }}">
                    <label for="contactemail" class="col-lg-3 col-lg-offset-1 control-label">Email</label>
                    <div class="col-lg-6">
                        <input type="text" class="form-control" id="contactemail" name="contactemail" placeholder="Contact Email Address" value="{{ (isset($data)) ? $data->contact_email : old('contactemail') }}">
                        <span class="text-danger"><em>{{ ($errors->has('contactemail')) ? $errors->first('contactemail') : '' }}</em></span>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-lg-offset-4 col-lg-10">
                        <button type="submit" class="btn btn-primary">Save</button>
                        <a href="{{ route('admin.inventory.supplier') }}" type="button" class="btn btn-danger">Cancel</a>
                    </div>
                </div>
            </form>
        </div>
    </section>
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
                    url: '{{ route("city2.ajax") }}/'+selectedprovince,
                    error: function() {
                        alert('Something Error has occured');
                    }
                }).done(function(data) {
                    data = $.parseJSON(data);
                    city.empty();
                    $(data).each(function() {
                        $('<option />', {
                            val: this.nama_kota,
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
                city.prop('disabled',true);
                cityspinner.show();
                var provname = $('option:selected', province).val();
                $.ajax({
                    type: "GET",
                    url: '{{ route("city2.ajax") }}/'+provname,
                    error: function() {
                        alert('Something Error has occured');
                    }
                }).done(function(data) {
                    data = $.parseJSON(data);
                    city.empty();
                    $(data).each(function() {
                        $('<option />', {
                            val: this.nama_kota,
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