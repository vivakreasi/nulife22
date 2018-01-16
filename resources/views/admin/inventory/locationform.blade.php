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
            <form class="form-horizontal" role="form" method="post" action="{{ route('admin.inventory.locationformpost') }}">
                {{ csrf_field() }}
                <input type="hidden" name="id" value="{{ isset($data) ? $data->id : '' }}">
                <input type="hidden" name="mode" value="{{ $mode }}">
                <div class="form-group {{ ($errors->has('locationname')) ? 'has-error' : '' }}">
                    <label for="locationname" class="col-lg-3 col-lg-offset-1 control-label">Location Name</label>
                    <div class="col-lg-6">
                        <input type="text" class="form-control" id="locationname" name="locationname" placeholder="Location Name" value="{{ (isset($data)) ? $data->name : old('locationname') }}">
                        <span class="text-danger"><em>{{ ($errors->has('locationname')) ? $errors->first('locationname') : '' }}</em></span>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-lg-offset-4 col-lg-10">
                        <button type="submit" class="btn btn-primary">Save</button>
                        <a href="{{ route('admin.inventory.location') }}" type="button" class="btn btn-danger">Cancel</a>
                    </div>
                </div>
            </form>
        </div>
    </section>
@endsection