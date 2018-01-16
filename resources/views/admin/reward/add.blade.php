@extends('layouts.main')
@section('header')
    @include('layouts.header')
@endsection
@section('content')
<section class="panel">
    <form class="form-horizontal" role="form" method="POST" action="{{ route('admin.reward.setting.add') }}">
        <div class="panel-body">
            {{ csrf_field() }}
            <div class="form-group">
                <div class="col-sm-10 col-sm-offset-1 col-lg-10 col-lg-offset-1">
                    <div class="row">
                        <div class="col-md-3">
                            <h5>Plan :</h5>
                        </div>
                        <div class="col-md-4">
                            <select name="plan" class="form-control" value="{{ old('plan') }}">
                                <option value="A">A</option>
                                <option value="B">B</option>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3">
                            <h5>Target (Left) :</h5>
                        </div>
                        <div class="col-md-4">
                            <input class="form-control" type="text" name="target" value="{{ old('target') }}" style="text-align: right;">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3">
                            <h5>Target (Right) :</h5>
                        </div>
                        <div class="col-md-4">
                            <input class="form-control" type="text" name="target_2" value="{{ old('target_2') }}" style="text-align: right;">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3">
                            <h5>Reward By Value :</h5>
                        </div>
                        <div class="col-md-4">
                            <input class="form-control" type="text" name="reward_by_value" value="{{ old('reward_by_value') }}" style="text-align: right;">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3">
                            <h5>Reward By Name :</h5>
                        </div>
                        <div class="col-md-4">
                            <input class="form-control" type="text" name="reward_by_name" value="{{ old('reward_by_name') }}">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3">
                            <h5>Claim By :</h5>
                        </div>
                        <div class="col-md-4">
                            <select name="reward_by" class="form-control" value="{{ old('reward_by') }}">
                                <option value="1">Value</option>
                                <option value="2">Name</option>
                                <option value="3">Both (member choose 1)</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="panel-footer">
            <div class="row">
                <div class="col-md-4 col-md-offset-3">
                    <button class="btn btn-info" type="submit">Save</button>
                </div>
            </div>
        </div>
    </form>
</section>
@endsection