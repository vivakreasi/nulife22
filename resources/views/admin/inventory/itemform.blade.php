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
            <form class="form-horizontal" role="form" method="post" action="{{ route('admin.inventory.itemformpost') }}">
                {{ csrf_field() }}
                <input type="hidden" name="id" value="{{ isset($data) ? $data->id : '' }}">
                <input type="hidden" name="mode" value="{{ $mode }}">
                <div class="form-group {{ ($errors->has('itemname')) ? 'has-error' : '' }}">
                    <label for="itemname" class="col-lg-3 col-lg-offset-1 control-label">Item Name</label>
                    <div class="col-lg-6">
                        <input type="text" class="form-control" id="itemname" name="itemname" placeholder="Item Name" value="{{ (isset($data)) ? $data->name : old('itemname') }}">
                        <span class="text-danger"><em>{{ ($errors->has('itemname')) ? $errors->first('itemname') : '' }}</em></span>
                    </div>
                </div>
                <div class="form-group {{ ($errors->has('selmetric')) ? 'has-error' : '' }}">
                    <label class="col-lg-3 col-lg-offset-1 control-label">Metric</label>
                    <div class="col-lg-6">
                        <select class="form-control select2-offscreen" id="selmetric" name="selmetric">
                            <option></option>
                            @foreach($metriclist as $id=>$metric)
                                <option value="{{ $id }}" {{ (isset($data) && $data->metric_id==$id) ? 'selected' : ((old('selmetric')==$id) ? 'selected' : '') }}>{{ $metric }}</option>
                            @endforeach
                        </select>
                        <span class="text-danger"><em>{{ ($errors->has('selmetric')) ? $errors->first('selmetric') : '' }}</em></span>
                    </div>
                </div>
                <div class="form-group {{ ($errors->has('selcategory')) ? 'has-error' : '' }}">
                    <label class="col-lg-3 col-lg-offset-1 control-label">Category</label>
                    <div class="col-lg-6">
                        <select class="form-control select2-offscreen" id="selcategory" name="selcategory">
                            <option></option>
                            @foreach($categorylist as $id=>$category)
                                <option value="{{ $id }}" {{ (isset($data) && $data->category_id==$id) ? 'selected' : ((old('selcategory')==$id) ? 'selected' : '') }}>{{ $category }}</option>
                            @endforeach
                        </select>
                        <span class="text-danger"><em>{{ ($errors->has('selcategory')) ? $errors->first('selcategory') : '' }}</em></span>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-lg-3 col-lg-offset-1 control-label">Item Description</label>
                    <div class="col-lg-6">
                        <textarea class="form-control" id="itemdesc" name="itemdesc" cols="30" rows="8"></textarea>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-lg-offset-4 col-lg-10">
                        <button type="submit" class="btn btn-primary">Save</button>
                        <a href="{{ route('admin.inventory.item') }}" type="button" class="btn btn-danger">Cancel</a>
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
@endsection