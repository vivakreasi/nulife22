@extends('layouts.main')
@section('header')
    @include('layouts.header')
@endsection
@section('content')
    @if($havePin)
        <section class="panel">
            <form class="form-horizontal" role="form" method="POST" action="{{ route('new.register2') }}">
                <div class="panel-body">
                    {{ csrf_field() }}

                    <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                                <label for="name" class="col-md-4 control-label">Name </label>

                                <div class="col-md-6">
                                    <input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}" required autofocus>

                                    @if ($errors->has('name'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('name') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                                <label for="email" class="col-md-4 control-label">E-Mail Address</label>

                                <div class="col-md-6">
                                    <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required>

                                    @if ($errors->has('email'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('email') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                                <label for="hp" class="col-md-4 control-label">Mobile Phone</label>

                                <div class="col-md-6">
                                    <input id="email" type="text" class="form-control" name="hp" value="{{ old('hp') }}" required>

                                    @if ($errors->has('hp'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('hp') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                                <label for="password" class="col-md-4 control-label">Password</label>

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
                                <label for="password-confirm" class="col-md-4 control-label">Confirm Password</label>

                                <div class="col-md-6">
                                    <input id="password-confirm" type="password" class="form-control" name="password_confirm" required>
                                </div>
                            </div>
							
							
							<div class="form-group {{ ($errors->has('sel_product')) ? 'has-error' : '' }}">
                                        <label class="col-md-4 control-label">Select Plan</label>
                                        <div class="col-md-6">
                                            <select class="form-control select2-offscreen" id="sel_product" name="sel_product">
                                                <option value="">Select Plan</option>
                                                <option value="3">-- Plan B --</option>
                                                
                                            </select>
                                            <span class="text-danger"><em>{{ ($errors->has('sel_product')) ? $errors->first('sel_product') : '' }}</em></span>
                                        </div>
                                    
                                </div>

                </div>
                <div class="panel-footer">
                    <div class="row">
                        <button class="btn btn-info" type="submit">Register</button>
                    </div>
                </div>
            </form>
        </section>
    @endif
@endsection