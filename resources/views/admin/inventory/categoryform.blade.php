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
            <form class="form-horizontal" role="form" method="post" action="{{ route('admin.inventory.categoryformpost') }}">
                {{ csrf_field() }}
                <input type="hidden" name="id" value="{{ isset($data) ? $data->id : '' }}">
                <input type="hidden" name="mode" value="{{ $mode }}">
                <div class="form-group {{ ($errors->has('categoryname')) ? 'has-error' : '' }}">
                    <label for="categoryname" class="col-lg-3 col-lg-offset-1 control-label">Category Name</label>
                    <div class="col-lg-6">
                        <input type="text" class="form-control" id="categoryname" name="categoryname" placeholder="Category Name" value="{{ (isset($data)) ? $data->name : old('categoryname') }}">
                        <span class="text-danger"><em>{{ ($errors->has('categoryname')) ? $errors->first('categoryname') : '' }}</em></span>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-lg-offset-4 col-lg-10">
                        <button type="submit" class="btn btn-primary">Save</button>
                        <a href="{{ route('admin.inventory.category') }}" type="button" class="btn btn-danger">Cancel</a>
                    </div>
                </div>
            </form>
        </div>
    </section>
@endsection