@extends('layouts.main')
@section('header')
    @include('layouts.header')
@endsection
@section('content')
<section class="panel">
    <form class="form-horizontal" role="form" method="POST" action="{{ route('admin.reward.setting.edit', $data_id) }}">
        <div class="panel-body">
            {{ csrf_field() }}
            <div class="form-group">
                <div class="col-sm-10 col-sm-offset-1 col-lg-10 col-lg-offset-1">
                    <div class="row">
                        <div class="col-md-3">
                            <h5>Plan :</h5>
                        </div>
                        <div class="col-md-4">
                            <?php 
                            if(session('pesan-flash') && session('pesan-flash')['type']=='error') {
                                $plan = old('plan');
                            }
                            else {
                                $plan = !empty($data) ? $data->plan : 'A';
                            }
                            ?>
                            <select name="plan" class="form-control">
                                <option value="A"{{ ($plan == 'A') ? ' selected="selected"' : '' }}>A</option>
                                <option value="B"{{ ($plan == 'B') ? ' selected="selected"' : '' }}>B</option>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3">
                            <h5>Target (Left) :</h5>
                        </div>
                        <div class="col-md-4">
                            <input class="form-control" type="text" name="target" style="text-align: right;" 
                            @if(session('pesan-flash') && session('pesan-flash')['type']=='error') 
                                    value="{{ old('target') }}"
                            @else 
                                value="{{ !empty($data) ? $data->target : 0 }}"
                            @endif >
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3">
                            <h5>Target (Right) :</h5>
                        </div>
                        <div class="col-md-4">
                            <input class="form-control" type="text" name="target_2" style="text-align: right;"
                                   @if(session('pesan-flash') && session('pesan-flash')['type']=='error')
                                   value="{{ old('target_2') }}"
                                   @else
                                   value="{{ !empty($data) ? $data->target_2 : 0 }}"
                                    @endif >
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3">
                            <h5>Reward By Value :</h5>
                        </div>
                        <div class="col-md-4">
                            <input class="form-control" type="text" name="reward_by_value" style="text-align: right;" 
                            @if(session('pesan-flash') && session('pesan-flash')['type']=='error') 
                                value="{{ old('reward_by_value') }}"
                            @else 
                                value="{{ !empty($data) ? $data->reward_by_value : 0 }}"
                            @endif >
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3">
                            <h5>Reward By Name :</h5>
                        </div>
                        <div class="col-md-4">
                            <input class="form-control" type="text" name="reward_by_name" 
                            @if(session('pesan-flash') && session('pesan-flash')['type']=='error') 
                                value="{{ old('reward_by_name') }}"
                            @else 
                                value="{{ !empty($data) ? $data->reward_by_name : 0 }}"
                            @endif >
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3">
                            <h5>Claim By :</h5>
                        </div>
                        <div class="col-md-4">
                            <?php 
                            if(session('pesan-flash') && session('pesan-flash')['type']=='error') {
                                $by = old('reward_by');
                            }
                            else {
                                $by = !empty($data) ? $data->reward_by : 1;
                            }
                            ?>
                            <select name="reward_by" class="form-control">
                                <option value="1"{{ ($by == 1) ? ' selected="selected"' : '' }}>Value</option>
                                <option value="2"{{ ($by == 2) ? ' selected="selected"' : '' }}>Name</option>
                                <option value="3"{{ ($by == 3) ? ' selected="selected"' : '' }}>Both (member choose 1)</option>
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