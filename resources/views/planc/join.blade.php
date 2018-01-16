@extends('layouts.main')
@section('header')
    @include('layouts.header')
@endsection
@section('content')
<section class="panel">
    <div class="panel-body">
        @if (isset($summaryPin) && $summaryPin->sisa > 0)
            <form class="form-horizontal tasi-form" role="form" method="POST" action="{{ route('planc.dojoin') }}">
                {{ csrf_field() }}
                <div class="form-group">
                    <div class="col-sm-10 col-sm-offset-1 col-lg-10 col-lg-offset-1">
                        <p>Joining NuLife Plan-C program is as simple as one click action. You can use your available PIN to joining the program.<br />If you have no PIN available, you can <code>purchase</code> PIN from <code><a href="{{ route('planc.trfinstruction') }}">Order PIN</a></code> menu.</p>
                        <p><code>Total</code> of your PIN : <strong>{{ number_format($summaryPin->total_pin, 0, ',', '.') }}</strong>. Your <code>available</code> PIN : <strong>{{ number_format($summaryPin->sisa, 0, ',', '.') }}</strong></p>
                        <p>Click the <code>"Join Now"</code> button to start joining NuLife Plan-C program. <em>(You must agree with our Term &amp; Conditions.)</em></p>
                    </div>
                    <div class="col-lg-10 col-lg-offset-1">
                        <label class="checkbox-custom inline check-info">
                            <input type="checkbox" value="1" id="checkbox-101" name="agree"> <label for="checkbox-101">Yes, I am agree with <a href="#">Terms &amp; Conditions</a></label>
                        </label>
                    </div>
                    <div class="col-lg-10 col-lg-offset-1">
                        <button type="submit" class="btn btn-info">Join Now</button>
                    </div>
                </div>
            </form>
        @endif
    </div>
</section>
@endsection