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
            <form id="frmStock" class="form-horizontal" role="form" method="post" action="{{ route('admin.inventory.stockaddpost') }}">
                {{ csrf_field() }}
                <div class="form-group {{ ($errors->has('selitem')) ? 'has-error' : '' }}">
                    <label class="col-lg-3 col-lg-offset-1 control-label">Item</label>
                    <div class="col-lg-6">
                        <select class="form-control select2-offscreen" id="selitem" name="selitem">
                            <option value="">Select Item</option>
                            @foreach($items as $item)
                                <option value="{{ $item->id }}">{{ $item->name }}</option>
                            @endforeach
                        </select>
                        <span class="text-danger"><em>{{ ($errors->has('selitem')) ? $errors->first('selitem') : '' }}</em></span>
                    </div>
                </div>
                <div class="form-group {{ ($errors->has('sellocation')) ? 'has-error' : '' }}">
                    <label class="col-lg-3 col-lg-offset-1 control-label">Location</label>
                    <div class="col-lg-6">
                        <select class="form-control select2-offscreen" id="sellocation" name="sellocation">
                            <option value="">Select Location</option>
                            @foreach($locations as $location)
                                <option value="{{ $location->id }}">{{ $location->name }}</option>
                            @endforeach
                        </select>
                        <span class="text-danger"><em>{{ ($errors->has('sellocation')) ? $errors->first('sellocation') : '' }}</em></span>
                    </div>
                </div>
                <div class="form-group {{ ($errors->has('quantity')) ? 'has-error' : '' }}">
                    <label for="quantity" class="col-lg-3 col-lg-offset-1 control-label">Quantity</label>
                    <div class="col-lg-6">
                        <input type="text" class="form-control" id="quantity" name="quantity" placeholder="Stock Quantity" value="{{ old('quantity') }}">
                        <span class="text-danger"><em>{{ ($errors->has('quantity')) ? $errors->first('quantity') : '' }}</em></span>
                    </div>
                </div>
                <div class="form-group {{ ($errors->has('cost')) ? 'has-error' : '' }}">
                    <label for="cost" class="col-lg-3 col-lg-offset-1 control-label">Cost</label>
                    <div class="col-lg-6">
                        <input type="text" class="form-control" id="cost" name="cost" placeholder="Stock Cost (IDR)" value="{{ old('cost') }}">
                        <span class="text-danger"><em>{{ ($errors->has('cost')) ? $errors->first('cost') : '' }}</em></span>
                    </div>
                </div>
                <div class="form-group {{ ($errors->has('reason')) ? 'has-error' : '' }}">
                    <label for="reason" class="col-lg-3 col-lg-offset-1 control-label">Notes</label>
                    <div class="col-lg-6">
                        <input type="text" class="form-control" id="reason" name="reason" placeholder="Notes" value="{{ old('reason') }}">
                        <span class="text-danger"><em>{{ ($errors->has('reason')) ? $errors->first('reason') : '' }}</em></span>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-lg-offset-4 col-lg-10">
                        <button type="submit" class="btn btn-primary">Save</button>
                        <a href="{{ route('admin.inventory.stock') }}" type="button" class="btn btn-danger">Cancel</a>
                    </div>
                </div>
            </form>
        </div>
    </section>
@endsection

@section('scripts')
    <script src="{{ asset('assets/js/vendor/select2.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/js/vendor/jquery.mask.min.js') }}" type="text/javascript"></script>
    <script type="text/javascript">
        $(document).ready(function(){
            $('select').select2();
            $('#cost').mask('000.000.000.000.000,00', {reverse: true});
            $('#quantity').mask("#.##0", {reverse: true});

            $('#frmStock').submit(function(){
                $('#cost').unmask();
                $('#quantity').unmask();
            })
        });
    </script>
@endsection