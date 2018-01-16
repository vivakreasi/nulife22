@extends('layouts.main')
@section('header')
    @include('layouts.header')
@endsection
@section('content')
<section class="panel">
    <div class="panel-body">
        <form class="form-horizontal" role="form" method="POST" action="{{ route('bonus.reward.claim', [$data_id, $plan]) }}">
            {{ csrf_field() }}
            <div class="form-group">
                <div class="col-sm-10 col-sm-offset-1 col-lg-10 col-lg-offset-1">
                    <p> Your reward that you want to claim is 
                    @if ($data->reward_by == 1)
                        money cash <strong>Rp {{ number_format($data->reward_by_value, 0, ',', '.') }},-</strong> &nbsp;
                        <input type="hidden" name="choose1" value="1">
                    @elseif ($data->reward_by == 2)
                        <strong>{{ $data->reward_by_name }}</strong> &nbsp;
                        <input type="hidden" name="choose1" value="2">
                    @else
                        <select name="choose1" class="form-control" style="display: inline; width: auto; height: auto; padding: 2px 4px;">
                            <option value="1">Money cash Rp {{ number_format($data->reward_by_value, 0, ',', '.') }},-</option>
                            <option value="2">{{ $data->reward_by_name }}</option>
                        </select> &nbsp;
                    @endif
                    on plan-{{ $data->plan }}
                    </p>

                    <p><code>Warning !!!</code><br>
                    Our customer service will contact you via mobile phone number, if your data is <code>incorrect</code>, then we reserve the right to refuse your claim process.
                    </p>
                    <p>Please verify your data</p>
                    <p><span class="col-md-3">Your ID</span>: <strong>{{ Auth::user()->userid }}</strong></p>
                    <p><span class="col-md-3">Your Name</span>: <strong>{{ Auth::user()->name }}</strong></p>
                    <p><span class="col-md-3">Phone number</span>: <strong>{{ Auth::user()->hp }}</strong></p>
                    <p><span class="col-md-3">E-mail</span>: <strong>{{ Auth::user()->email }}</strong></p>
                </div>
                <div class="col-lg-10 col-lg-offset-1">
                    <label class="checkbox-custom inline check-info">
                        <input type="checkbox" value="1" id="checkbox-101" name="agree"> <label for="checkbox-101">Yes, this is My Nulife Account and I am agree with <a href="#">Terms &amp; Conditions</a></label>
                    </label>
                </div>
                <div class="col-lg-10 col-lg-offset-1">
                    <button type="submit" class="btn btn-info">Claim</button>
                </div>
            </div>
        </form>
    </div>
</section>
@endsection

