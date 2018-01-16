@extends('layouts.main')
@section('header')
    @include('layouts.header')
@endsection
@section('content')


@if($haveProfile)
<section class="panel">
    <div class="panel-body">
        <div class="form-horizontal">
            <div class="panel-body">
                <div class="form-group">
                    <label for="name" class="col-md-3 control-label">Name</label>
                    <label for="name" class="col-md-6 well well-sm">{{$dataLogin->name}}</label>
                </div>
                <div class="form-group">
                    <label for="name" class="col-md-3 control-label">User ID</label>
                    <label for="name" class="col-md-6 well well-sm">{{$dataLogin->userid}}</label>
                </div>
                <div class="form-group">
                    <label for="name" class="col-md-3 control-label">Email</label>
                    <label for="name" class="col-md-6 well well-sm">{{$dataLogin->email}}</label>
                </div>
                <div class="form-group">
                    <label for="name" class="col-md-3 control-label">Phone</label>
                    <label for="name" class="col-md-5 well well-sm">{{$dataLogin->hp}}</label>
                    <label for="name" class="col-md-2"><a href="{{ route('edit.profile', ["type" => 'hp']) }}" class="btn btn-primary">Change</a></label>
                </div>
                <div class="form-group">
                    <label for="name" class="col-md-3 control-label">Password</label>
                    <label for="name" class="col-md-2"><a href="{{ route('edit.profile', ["type" => 'passwd']) }}" class="btn btn-primary">Change Password</a></label>
                </div>
                <br>
                <div class="form-group">
                    <label for="name" class="col-md-3 control-label">Address</label>
                    <label for="name" class="col-md-6 well well-sm">{{$dataProfile->alamat}}</label>
                </div>
                <div class="form-group">
                    <label for="name" class="col-md-3 control-label">City</label>
                    <label for="name" class="col-md-6 well well-sm">{{$dataProfile->nama_kota}}</label>
                </div>
                <div class="form-group">
                    <label for="name" class="col-md-3 control-label">Province</label>
                    <label for="name" class="col-md-4 well well-sm">{{$dataProfile->nama}}</label>
                    <label for="name" class="col-md-2"><a href="{{ route('edit.profile', ["type" => 'alamat']) }}" class="btn btn-primary">Change Full Address</a></label>
                </div>
                <div class="form-group">
                    <?php
                        $gender = 'Women';
                        if($dataProfile->gender == 1){
                            $gender = 'Man';
                        }
                    ?>
                    <label for="name" class="col-md-3 control-label">Gender</label>
                    <label for="name" class="col-md-5 well well-sm">{{$gender}}</label>
                    <label for="name" class="col-md-1"><a href="{{ route('edit.profile', ["type" => 'gender']) }}" class="btn btn-primary">Change</a></label>
                </div>
                <div class="form-group">
                    <label for="name" class="col-md-3 control-label">Identity Card</label>
                    <label for="name" class="col-md-5 well well-sm">{{$dataProfile->ktp}}</label>
                    <label for="name" class="col-md-2"><a href="{{ route('edit.profile', ["type" => 'ktp']) }}" class="btn btn-primary">Change</a></label>
                </div>
                <?php
                    $birth_date = 'No Data';
                    if($dataProfile->birth_date != null){
                        $birth_date = date('d F Y', strtotime($dataProfile->birth_date));
                    }
                ?>
                <div class="form-group">
                    <label for="name" class="col-md-3 control-label">Birth Date</label>
                    <label for="name" class="col-md-5 well well-sm">{{$birth_date}}</label>
                    <label for="name" class="col-md-2"><a href="{{ route('edit.profile', ["type" => 'birth']) }}" class="btn btn-primary">Change</a></label>
                </div>
                <div class="form-group">
                    <label for="name" class="col-md-3 control-label">Passport</label>
                    <label for="name" class="col-md-5 well well-sm">{{$dataProfile->paspor}}</label>
                    <label for="name" class="col-md-2"><a href="{{ route('edit.profile', ["type" => 'paspor']) }}" class="btn btn-primary">Change</a></label>
                </div>
            </div>
        </div>
    </div>
</section>  
@else 
<section class="panel">
    <div class="panel-body">
        <div class="form-horizontal">
            <div class="panel-body">
                <div class="form-group">
                    <label for="name" class="col-md-3 control-label">Name</label>
                    <label for="name" class="col-md-6 well well-sm">{{$dataLogin->name}}</label>
                </div>
                <div class="form-group">
                    <label for="name" class="col-md-3 control-label">User ID</label>
                    <label for="name" class="col-md-6 well well-sm">{{$dataLogin->userid}}</label>
                </div>
                <div class="form-group">
                    <label for="name" class="col-md-3 control-label">Phone</label>
                    <label for="name" class="col-md-3 well well-sm">{{$dataLogin->hp}}</label>
                    <label for="name" class="col-md-2"><a href="{{ route('edit.profile', ["type" => 'hp']) }}" class="btn btn-primary">Change Phone</a></label>
                </div>
                <div class="form-group">
                    <label for="name" class="col-md-3 control-label">Password</label>
                    <label for="name" class="col-md-2"><a href="{{ route('edit.profile', ["type" => 'passwd']) }}" class="btn btn-primary">Change Password</a></label>
                </div>
            </div>
        </div>
    </div>
</section>
<section class="panel">
    <div class="panel-body">
            <a href="{{ route('new.profile') }}" class="btn btn-info">Create New Profile</a>
    </div>
</section>
@endif

    
@endsection