@extends('layouts.main')
@section('header')
    @include('layouts.header')
@endsection
@section('content')
<section class="panel">
    <form class="form-horizontal" role="form" method="POST" action="{{ route('admin.company.bank.add') }}">
        <div class="panel-body">
            {{ csrf_field() }}
            <div class="form-group">
                <div class="col-sm-10 col-sm-offset-1 col-lg-10 col-lg-offset-1">
                    <div class="row">
                        <div class="col-md-3">
                            <h5>Bank Name :</h5>
                        </div>
                        <div class="col-md-4">
                            <select name="bank_id" class="form-control">
                                @foreach($listBank as $row)
                                    <option value="{{ $row['code'] }}">{{ $row['name'] }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3">
                            <h5>Bank Account :</h5>
                        </div>
                        <div class="col-md-4">
                            <input class="form-control" type="text" name="bank_account" value="{{ old('bank_account') }}">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3">
                            <h5>Account Name :</h5>
                        </div>
                        <div class="col-md-4">
                            <input class="form-control" type="text" name="bank_account_name" value="{{ old('bank_account_name') }}">
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