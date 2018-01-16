@extends('layouts.main')

@section('header')
    @include('layouts.header')
@endsection

@section('content')
    <section class="panel">
        <header class="panel-heading">
            {{ $subtitle }}
        </header>
        <div class="panel-body">
            <form class="form-horizontal" role="form" method="post" action="{{ route('admin.inventory.metricformpost') }}">
                {{ csrf_field() }}
                <input type="hidden" name="id" value="{{ isset($data) ? $data->id : '' }}">
                <input type="hidden" name="mode" value="{{ $mode }}">
                <div class="form-group {{ ($errors->has('metricname')) ? 'has-error' : '' }}">
                    <label for="metricname" class="col-lg-3 col-lg-offset-1 control-label">Metric Name</label>
                    <div class="col-lg-6">
                        <input type="text" class="form-control" id="metricname" name="metricname" placeholder="Metric Name" value="{{ (isset($data)) ? $data->name : old('metricname') }}">
                        <span class="text-danger"><em>{{ ($errors->has('metricname')) ? $errors->first('metricname') : '' }}</em></span>
                    </div>
                </div>
                <div class="form-group {{ ($errors->has('metricsymbol')) ? 'has-error' : '' }}">
                    <label for="metricsymbol" class="col-lg-3 col-lg-offset-1 control-label">Metric Symbol</label>
                    <div class="col-lg-6">
                        <input type="text" class="form-control" id="metricsymbol" name="metricsymbol" placeholder="Metric Symbol" value="{{ (isset($data)) ? $data->symbol : old('metricsymbol') }}">
                        <span class="text-danger"><em>{{ ($errors->has('metricsymbol')) ? $errors->first('metricsymbol') : '' }}</em></span>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-lg-offset-4 col-lg-10">
                        <button type="submit" class="btn btn-primary">Save</button>
                        <a href="{{ route('admin.inventory.metric') }}" type="button" class="btn btn-danger">Cancel</a>
                    </div>
                </div>
            </form>
        </div>
    </section>
@endsection