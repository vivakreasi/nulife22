@extends('layouts.main')
@section('header')
    @include('layouts.header')
@endsection
@section('content')
<style type="text/css">
    .table > thead > tr > th {
        /*background-color: #ddf;*/
        text-align: center;
    }
</style>
<section class="panel">
    <div class="panel-body">
        @if (empty($bank))
            <a href="{{ route('planc.bank.add') }}" class="btn btn-info">Create New Bank Account</a>
        @else
            <div class="form-horizontal">
                <div class="form-group">
                    <div class="col-sm-10 col-sm-offset-1 col-lg-10 col-lg-offset-1">
                        <p>Your bank account :</p>
                        <div class="row">
                            <div class="col-md-3">
                                <h5>Bank Name :</h5>
                            </div>
                            <div class="col-md-9">
                                <h5><strong>{{ $bank->bank_name }}</strong></h5>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3">
                                <h5>Bank Account :</h5>
                            </div>
                            <div class="col-md-9">
                                <h5><strong>{{ $bank->bank_account }}</strong></h5>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3">
                                <h5>Account Name :</h5>
                            </div>
                            <div class="col-md-9">
                                <h5><strong>{{ $bank->bank_account_name }}</strong></h5>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-10 col-sm-offset-1 col-lg-10 col-lg-offset-1">
                        <a class="btn btn-info" href="{{ route('planc.bank.edit', $bank->id) }}">Edit</a>
                    </div>
                </div>
            </div>
        @endif
    </div>
</section>
@endsection
