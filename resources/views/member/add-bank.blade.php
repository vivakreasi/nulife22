@extends('layouts.main')
@section('header')
    @include('layouts.header')
@endsection
@section('content')
    <section class="panel">
        <form class="form-horizontal" role="form" method="POST" action="{{ route('post.create.bank') }}">
            <div class="panel-body">
                {{ csrf_field() }}

                <div class="form-group{{ $errors->has('bank_name') ? ' has-error' : '' }}">
                    <label for="bank_name" class="col-md-4 control-label">Bank Name</label>
                    <div class="col-md-6">
                        <select class="form-control" name="bank_name"required>
                            @foreach($daftarBank as $row)
                                <option value="{{$row['name']}}">{{$row['name']}}</option>
                            @endforeach
                        </select>
                        @if ($errors->has('bank_name'))
                            <span class="help-block">
                                <strong>{{ $errors->first('bank_name') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>

                <div class="form-group{{ $errors->has('account_no') ? ' has-error' : '' }}">
                    <label for="account_no" class="col-md-4 control-label">Bank Account Number</label>
                    <div class="col-md-6">
                        <input id="name" type="text" class="form-control" name="account_no" value="{{ old('account_no') }}" required autofocus>
                        @if ($errors->has('account_no'))
                            <span class="help-block">
                                <strong>{{ $errors->first('account_no') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>

                <div class="form-group">
                    <label for="account_name" class="col-md-4 control-label">Bank Account's Name</label>
                    <div class="col-md-6">
                        <input id="name" type="text" class="form-control" value="{{$dataLogin->name}}" disabled="disabled" >
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-md-6">
                        <button class="btn btn-info" type="submit">Save</button>
                        &nbsp;
                        <a href="{{ route('dashboard') }}" class="btn btn-warning">Cancel</a>
                    </div>
                </div>
            </div>
        </form>
    </section>

    <section class="panel-group">
            <div class="panel panel-primary member-panel">
                <div class="panel-heading member-panel-heading">My Bank Account</div>
                <div class="panel-body">
                    <table class="table table-bordered table-hover responsive nowrap" id="tbl-nulife">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Bank</th>
                                <th>Account Number</th>
                                <th>Account Name</th>
                                <th>Edit</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if (!$myBank->isEmpty())
                                <?php $no = 0; ?>
                                @foreach($myBank as $row)
                                    <?php $no++; ?>
                                    <tr>
                                        <td>{{ $no }}</td>
                                        <td>{{ $row->bank_name }}</td>
                                        <td>{{ $row->account_no }}</td>
                                        <td>{{$dataLogin->name}}</td>
                                        <td><a href="{{ route('edit.bank', ['id' => $row->id]) }}">Edit</a></td>
                                    </tr>
                                @endforeach
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </section>
@endsection