@extends('layouts.main')
@section('header')
    @include('layouts.header')
@endsection
@section('content')

@if($haveData)
<section class="panel">
    <div class="panel-body">
        <div class="form-horizontal">
            <form class="form-horizontal" role="form" method="POST" action="{{ route('admin.edit.member.post') }}">
                <div class="panel-body">
                    {{ csrf_field() }}
                    @if($type == 'name')
                        <div class="form-group">
                            <label for="name" class="col-md-3 control-label">Old Name</label>
                            <label for="name" class="col-md-6 well well-sm">{{$dataUser->nama}}</label>
                        </div>

                        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                            <label for="name" class="col-md-3 control-label">New Name</label>
                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}" required autofocus>
                                @if ($errors->has('name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                    @endif 
                    
                    @if($type == 'email')
                        <div class="form-group">
                            <label for="name" class="col-md-3 control-label">Old Email</label>
                            <label for="name" class="col-md-6 well well-sm">{{$dataUser->email}}</label>
                        </div>

                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <label for="email" class="col-md-3 control-label">New Email</label>
                            <div class="col-md-6">
                                <input id="email" type="text" class="form-control" name="email" value="{{ old('email') }}" required autofocus>
                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                    @endif
                    <div class="form-group">
                        <input type="hidden" name="type" value="{{ $type }}">
                        <input type="hidden" name="id" value="{{ $dataUser->id }}">
                        <div class="col-md-6">
                            <button class="btn btn-info" type="submit">Save</button>
                            &nbsp;
                            <a href="{{ route('admin.view.member', ['id' => $dataUser->id]) }}" class="btn btn-warning">Cancel</a>
                        </div>
                    </div>

                </div>
            </form>
        </div>
    </div>
</section>  
@else
<section class="panel">
    <div class="panel-body">
            We can not find a user data
    </div>
</section>
@endif

    
@endsection