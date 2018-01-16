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
                         <div class="col-sm-12"><h4>Information Transfer</h4></div>
                         <div class="col-sm-12">
                            <h4><i class='fa fa-user'></i> Registration {{$data->name}}</h4>
                         </div>
                        <div class="col-md-3 col-sm-6 col-xs-6">
                            <p>Bank Name</p>
                            <p>Account Number</p>
                            <p>Account Name</p>
                            <p>Hak Usaha</p>
                        </div>
                        <div class="col-md-3 col-sm-6 col-xs-6">
                            <p>{{$data->bank}}</p>
                            <p>{{$data->bank_account}}</p>
                            <p>{{$data->account_name}}</p>
                            <p>{{$data->hak_usaha}}</p>
                         </div>
                        <div class="col-sm-12" style="border-top: 1px solid #ddd;"><h4>Nominal Transfer</h4></div>
                        <div class="col-sm-4">
                           <h4><i class='fa fa-money'></i> &nbsp;&nbsp; Rp {{number_format($data->price, 0, ',', '.')}},-</h4>
                        </div>
                        <div class="col-sm-8">
                           <img src="/img/transfer/{{$data->file_upload}}" class="img-responsive" style="max-height: 300px;">
                        </div>
                   </div>
                     <form class="form-horizontal" role="form" method="POST" action="{{ route('post.confirm.referal') }}">
                        <div class="panel-body">
                            {{ csrf_field() }}
                            <input type="hidden" class="form-control" name="kode" value="{{$data->id}}">
                            <div class="row">
                                <button class="btn btn-info" type="submit">Approve</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection