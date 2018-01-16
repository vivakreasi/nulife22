@extends('layouts.main')
@section('header')
    @include('layouts.header')
@endsection
@section('content')
        <section class="panel">
            <form class="form-horizontal" role="form" method="POST" action="{{ route('nucash.wd') }}">
                <div class="panel-body">
                    {{ csrf_field() }}

                    <div class="form-group{{ $errors->has('nominal') ? ' has-error' : '' }}">
                        <label class="col-md-4 control-label">Available Withdraw</label>
                        <div class="col-md-6">
                            <label class="form-control">Rp {{ number_format($maxWD, 0, ',', '.') }},-</label>
                        </div>
                    </div>

                    <div class="form-group{{ $errors->has('choose_bank') ? ' has-error' : '' }}">
                        <label for="choose_bank" class="col-md-4 control-label">Choose Bank</label>
                        <div class="col-md-6">
                            @if(!$myBank->isEmpty())
                                <select class="form-control" name="choose_bank"required>
                                    @foreach($myBank as $row)
                                        <option value="{{$row->id}}">{{$row->bank_name}} - {{$row->account_no}} - {{$row->account_name}}</option>
                                    @endforeach
                                </select>
                            @else 
                                <label class="control-label" >You don't have a bank account</label>
                            @endif
                            @if ($errors->has('choose_bank'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('choose_bank') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group{{ $errors->has('nominal') ? ' has-error' : '' }}">
                        <label for="nominal" class="col-md-4 control-label">Nominal Withdraw</label>
                        <div class="col-md-6">
                            <input id="email" type="nominal" class="form-control" name="nominal" value="{{ old('nominal') }}" required>
                            @if ($errors->has('nominal'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('nominal') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="panel-footer">
                    <div class="row">
                        <button class="btn btn-info" type="submit">Save</button>
                        &nbsp;
                    <a href="{{ route('nucash.wd.list') }}" class="btn btn-warning">Cancel</a>
                    </div>
                </div>
            </form>
        </section>
@endsection