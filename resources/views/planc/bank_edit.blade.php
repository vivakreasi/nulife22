@extends('layouts.main')
@section('header')
    @include('layouts.header')
@endsection
@section('content')
<section class="panel">
    <form class="form-horizontal" role="form" method="POST" action="{{ route('planc.bank.edit', $bank->id) }}">
        <div class="panel-body">
            {{ csrf_field() }}
            <div class="well">
                <p>Your bank <code>must</code> be <strong>Bank Mandiri</strong>.</p>
                <p>Your bank account name <code>must</code> be <strong>{{ Auth::user()->nama }}</strong>. Other account name will be considerred <code>invalid</code>, and will be ignored from our bonus transfer list.</p>
                <p>Insert <code>only numbers</code> of your bank account <em>(no letters, dash -, dot ., etc)</em></p>
            </div>

            <input type="hidden" name="bank_id" value="{{ $bank->id }}">
            <div class="form-group">
                <div class="col-sm-10 col-sm-offset-1 col-lg-10 col-lg-offset-1">
                    <div class="row">
                        <div class="col-md-3">
                            <h5>Bank Name :</h5>
                        </div>
                        <div class="col-md-9">
                            <h5><strong>Mandiri</strong></h5>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3">
                            <h5>Bank Account :</h5>
                        </div>
                        <div class="col-md-4">
                            <input class="form-control" type="text" name="bank_account" value="{{ $bank->bank_account }}">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3">
                            <h5>Account Name :</h5>
                        </div>
                        <div class="col-md-9">
                            <h5><strong>{{ Auth::user()->name }}</strong></h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="panel-footer">
            <div class="row">
                <button class="btn btn-info" type="submit">Save</button>
            </div>
        </div>
    </form>
</section>
@endsection