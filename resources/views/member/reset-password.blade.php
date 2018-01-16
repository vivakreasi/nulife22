@extends('layouts.main2')

@section('content')

<div class="c-layout-page">
    <div class="col-md-6 col-md-offset-3" style="margin-top:20px">
        <div class="panel panel-primary">
            <div class="panel-heading">
                Reset Password
            </div>
            <div class="panel-body">
                <form class="form-horizontal" role="form" method="POST" action="{{ route('post.activation.password') }}">
                    {{ csrf_field() }}

                    <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                        <label for="password" class="col-md-5 control-label">New Password</label>

                        <div class="col-md-6">
                            <input id="password" type="password" class="form-control" name="password" required>

                            @if ($errors->has('password'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('password') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="password-confirm" class="col-md-5 control-label">Confirm New Password</label>

                        <div class="col-md-6">
                            <input id="password-confirm" type="password" class="form-control" name="password_confirm" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <input type="hidden" class="form-control" name="email" value="{{$data->email}}">
                        <input type="hidden" class="form-control" name="kode" value="{{$kode}}">
                        <div class="col-md-4 col-md-offset-9">
                            <button type="submit" class="btn btn-primary">
                                Save
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection