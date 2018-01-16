@extends('layouts.main')
@section('header')
    @include('layouts.header')
@endsection
@section('content')
    <section class="panel">
        <div class="profile-head">
        <div class="profiles container">
             <div class="col-md-8 col-sm-8 col-xs-9">
                 <div class="row">
                     <div class="col-sm-12"><h4>Referal's Bank</h4></div>
                     <div class="col-sm-12">
                        <h4><i class='fa fa-user'></i> &nbsp;&nbsp;{{$infoRef->nama}}</h4>
                     </div>
                    <div class="col-md-3 col-sm-6 col-xs-6">
                        <p>Bank Name</p>
                        <p>Account Number</p>
                        <p>Account Name</p>
                        <p>Mobile Phone</p>
                    </div>
                     
                    <div class="col-md-3 col-sm-6 col-xs-6">
                        @if($infoBank != null)
                            <p>{{$infoBank->bank_name}}</p>
                            <p>{{$infoBank->account_no}}</p>
                            <p>{{$infoBank->account_name}}</p>
                        @endif
                        <p>{{$infoRef->no_handphone}}</p>
                     </div>
                    <div class="col-sm-12" style="border-top: 1px solid #ddd;"><h4>Nominal Transfer</h4></div>
                    <div class="col-sm-12">
                       <h4><i class='fa fa-money'></i> &nbsp;&nbsp; Rp {{number_format($hakUsaha * $hargaDasar, 0, ',', '.')}},-</h4>
                    </div>
               </div>
                 
            </div>
        </div>
    </section>
    @if($infoBank != null)
    <section class="panel">
        <form class="form-horizontal" role="form" method="POST" action="{{ route('post.transfer.referal') }}" enctype="multipart/form-data">
            <div class="panel-body">
                {{ csrf_field() }}

                <div class="form-group{{ $errors->has('price') ? ' has-error' : '' }}">
                    <label for="price" class="col-md-4 control-label">Nominal Transfer</label>
                    <div class="col-md-6">
                        <input id="price" type="text" class="form-control" name="price" value="{{ old('price') }}" required autofocus>
                        @if ($errors->has('price'))
                            <span class="help-block">
                                <strong>{{ $errors->first('price') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>
                
                <div class="form-group{{ $errors->has('bank') ? ' has-error' : '' }}">
                    <label for="bank" class="col-md-4 control-label">Bank Name</label>
                    <div class="col-md-6">
                        <select class="form-control" name="bank"required>
                            @foreach($daftarBank as $row)
                                <option value="{{$row['name']}}">{{$row['name']}}</option>
                            @endforeach
                            
                        </select>
                        @if ($errors->has('bank'))
                            <span class="help-block">
                                <strong>{{ $errors->first('bank') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>
                
                <div class="form-group{{ $errors->has('bank_account') ? ' has-error' : '' }}">
                    <label for="bank_account" class="col-md-4 control-label">Account Number</label>
                    <div class="col-md-6">
                        <input id="bank_account" type="text" class="form-control" name="bank_account" value="{{ old('bank_account') }}" required autofocus>
                        @if ($errors->has('bank_account'))
                            <span class="help-block">
                                <strong>{{ $errors->first('bank_account') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>
                
                <div class="form-group{{ $errors->has('account_name') ? ' has-error' : '' }}">
                    <label for="account_name" class="col-md-4 control-label">Account Name</label>
                    <div class="col-md-6">
                        <input id="bank_account" type="text" class="form-control" name="account_name" value="{{ old('account_name') }}" required autofocus>
                        @if ($errors->has('account_name'))
                            <span class="help-block">
                                <strong>{{ $errors->first('account_name') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>
                
                <div class="form-group{{ $errors->has('file_upload') ? ' has-error' : '' }}">
                    <label for="file_upload" class="col-md-4 control-label">Upload File</label>
                    <div class="col-md-6">
                        <input id="file_upload" type="file" class="form-control" name="file_upload" value="{{ old('file_upload') }}" required autofocus>
                        @if ($errors->has('bank_account'))
                            <span class="help-block">
                                <strong>{{ $errors->first('file_upload') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>
                
            </div>
            <div class="panel-footer">
                <input type="hidden" class="form-control" name="kode" value="{{$kode}}">
                <div class="row">
                    <button class="btn btn-info" type="submit">Register</button>
                    &nbsp;
                    <a href="{{ route('hakusaha') }}" class="btn btn-warning">Cancel</a>
                </div>
            </div>
        </form>
    </section>
    @endif
@endsection