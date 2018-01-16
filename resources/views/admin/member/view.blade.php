@extends('layouts.main')
@section('header')
    @include('layouts.header')
@endsection
@section('content')

@if($haveData)
<section class="panel">
    <div class="panel-body">
        <div class="form-horizontal">
            <div class="panel-body">
                <div class="form-group">
                    <label for="userid" class="col-md-3 control-label">User ID</label>
                    <label for="userid" class="col-md-6 well well-sm">{{$dataLogin->userid}}</label>
                </div>
                <div class="form-group">
                    <label for="name" class="col-md-3 control-label">Name</label>
                    <label for="name" class="col-md-5 well well-sm">{{$dataLogin->nama}}</label>
                    <label class="col-md-1"><a href="{{ route('admin.edit.member', ['type' => 'name', 'id' => $dataLogin->id]) }}" class="btn btn-info">Change Name</a></label>
                </div>
                <div class="form-group">
                    <label for="email" class="col-md-3 control-label">Email</label>
                    <label for="email" class="col-md-5 well well-sm">{{$dataLogin->email}}</label>
                    <label class="col-md-1"><a href="{{ route('admin.edit.member', ['type' => 'email', 'id' => $dataLogin->id]) }}" class="btn btn-info">Change Email</a></label>
                </div>
                <div class="form-group">
                    <label for="Phone" class="col-md-3 control-label">Phone</label>
                    <label for="Phone" class="col-md-3 well well-sm">{{$dataLogin->no_handphone}}</label>
                </div>
                <div class="form-group">
                    <?php
                        $active = 'no';
                        if($dataLogin->is_active == 1){
                            $active = 'Yes';
                        }
                    ?>
                    <label for="Active" class="col-md-3 control-label">Active</label>
                    <label for="Active" class="col-md-3 well well-sm">{{$active}}</label>
                </div>
            </div>
        </div>
    </div>
</section>  
<section class="panel">
    <div class="panel-body">
        <?php
            $change = 'Change to Active';
            if($dataLogin->is_active == 1){
                $change = 'Change to Inactive (blokir)';
            }
        ?>
            <a href="{{ route('admin.isactive.member', ["id" => $dataLogin->id]) }}" class="btn btn-info">{{$change}}</a>
            &nbsp;&nbsp;
             <a href="{{ route('admin.member.list') }}" class="btn btn-primary">cancel</a>
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