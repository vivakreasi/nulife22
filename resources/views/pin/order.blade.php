@extends('layouts.main')

@section('header')
    @include('layouts.header')
@endsection

@section('vendor_style')
    <link href="{{ asset('assets/css/vendor/select2.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/vendor/select2-bootstrap.css') }}" rel="stylesheet">
@endsection

@section('content')
<section class="panel">
    <div class="panel-body">
        <div class="row">
            <div class="col-sm-10 col-sm-offset-1 col-lg-10 col-lg-offset-1">
                <button class="btn btn-success" type="button">
                  Activation PIN &emsp;<span class="badge">{{ $jmlPin }}</span>
                </button>
            </div>
        </div>
        <br>
        <!-- Modal -->
        <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Are you sure?</h4>
              </div>
              <div class="modal-body">
                <input type="hidden" name="type" id="modal-type">
                <div class="title-modal"></div>
                <ul style="list-style:none;">
                    @if (!Auth::user()->isStockis())
                        <li>Userid<div class="userid-modal"></div></li>
                    @endif
                    <li>Name<div class="nama-modal"></div></li>
                    <li>No. Telepon<div class="telepon-modal"></div></li>
                </ul><br>
                By clicking the 'Sure' button then you are sure and responsible for all data which I have entered into the form<hr><small><i>WARNING : Nulife is not responsible if you incorrectly enter data on the form provided!</i></small>
              </div>
              <div class="modal-footer">
                <div class="pull-left">
                    <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-success btn-sm" onclick="javascript:submit_form();">Sure</button>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <section class="isolate-tabs">
                    <ul class="nav nav-tabs">
                        <li class="active">
                            <a data-toggle="tab" href="#buy-pin">{{ (Auth::user()->isStockis() ? "Buy" : "Order") }} PIN</a>
                        </li>
                        <li class="">
                            <a data-toggle="tab" href="#transfer-pin">Transfer PIN</a>
                        </li>
                    </ul>
                    <div class="panel-body">
                        <div class="tab-content">
                            <div id="buy-pin" class="tab-pane active">
                                @if(Auth::user()->isStockis())
                                    <form class="form-horizontal" role="form" method="POST" id="buy-form" action="{{ route('pin.buy') }}">
                                        {{ csrf_field() }}
                                        <div class="well well-lg">
                                            <div class="row">
                                                <div class="form-group">
                                                    <div class="col-sm-10 col-sm-offset-1 col-lg-10 col-lg-offset-1">
                                                        <label class="control-label col-md-3" for="{{ (str_replace(' ', '-', strtolower($pin_type_list->pin_type_name))) }}"><strong>Amount</strong></label>
                                                        <div class="col-md-3">
                                                            <input type="number" class="form-control" name="{{ (str_replace(' ', '-', strtolower($pin_type_list->pin_type_name))) }}" id="{{ (str_replace(' ', '-', strtolower($pin_type_list->pin_type_name))) }}" value="{{ old(str_replace(' ', '-', strtolower($pin_type_list->pin_type_name)), $min_order) }}" min="{{ $min_order }}" max="{{ $maxOrder }}" step="1">
                                                            <button class="btn btn-info m-t-20" type="button" data-toggle="modal" data-target="#myModal" onclick="javascript:change_modal_type('buy');">
                                                                Order
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                @else
                                    <form class="form-horizontal" role="form" method="POST" id="order-form" action="{{ route('pin.order') }}">
                                        {{ csrf_field() }}
                                        <div class="well well-lg">
                                            <div class="row">
                                                <div class="form-group">
                                                    <div class="col-sm-10 col-sm-offset-1 col-lg-10 col-lg-offset-1">
                                                        <label class="control-label col-md-3" for="{{ (str_replace(' ', '-', strtolower($pin_type_list->pin_type_name))) }}"><strong>Amount</strong></label>
                                                        <div class="col-md-3">
                                                            <input type="number" class="form-control" name="{{ (str_replace(' ', '-', strtolower($pin_type_list->pin_type_name))) }}" id="{{ (str_replace(' ', '-', strtolower($pin_type_list->pin_type_name))) }}" value="{{ old(str_replace(' ', '-', strtolower($pin_type_list->pin_type_name)), $min_order) }}" min="{{ $min_order }}" max="{{ $maxOrder }}" step="1">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="col-sm-10 col-sm-offset-1 col-lg-10 col-lg-offset-1">
                                                        <label class="control-label col-md-3" for="stockist"><strong>Stockist</strong></label>
                                                        <div class="col-md-5">
                                                            <select class="form-control select2-offscreen userid-form" id="stockist" name="stockist">
                                                                <option value="">Select Stockist</option>
                                                                @foreach($stockist_list as $key => $value)
                                                                    <option value="{{ $key }}">{{ strtoupper($value) }}</option>
                                                                @endforeach
                                                            </select>
                                                            <button class="btn btn-primary m-t-20" type="button" data-toggle="modal" data-target="#myModal" onclick="javascript:change_modal_type('order');">
                                                                Order
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                @endif
                            </div>
                            <div id="transfer-pin" class="tab-pane">
                                <form class="form-horizontal" role="form" method="POST" id="transfer-form" action="{{ route('pin.transfer') }}">
                                    {{ csrf_field() }}
                                    <div class="well well-lg">
                                        <div class="row">
                                            <div class="form-group">
                                                <div class="col-sm-10 col-sm-offset-1 col-lg-10 col-lg-offset-1">
                                                    <label class="control-label col-md-4" for="{{ (str_replace(' ', '-', strtolower($pin_type_list->pin_type_name))) }}"><strong>Amount </strong></label>
                                                    <div class="col-md-4">
                                                        <input type="number" class="form-control" name="{{ (str_replace(' ', '-', strtolower($pin_type_list->pin_type_name))) }}" id="{{ (str_replace(' ', '-', strtolower($pin_type_list->pin_type_name))) }}" value="{{ old(str_replace(' ', '-', strtolower($pin_type_list->pin_type_name)), 1) }}" min="1" max="{{ $maxOrder }}" step="1">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="col-sm-10 col-sm-offset-1 col-lg-10 col-lg-offset-1">
                                                    <label class="control-label col-md-4" for="stockist"><strong>To User ID</strong></label>
                                                    <div class="col-md-4">
                                                        <input type="text" name="userid" class="form-control userid-form">
                                                        <button class="btn btn-info m-t-20" type="button" data-toggle="modal" data-target="#myModal" onclick="javascript:change_modal_type('transfer');">
                                                            Transfer
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>
</section>
@endsection
@section('scripts')
    <script src="{{ asset('assets/js/vendor/select2.js') }}" type="text/javascript"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            $('select').select2();
        });

        function change_modal_type(type){
            switch(type) {
                case 'buy':
                    $('#modal-type').val('buy');/**/
                    var userid = 0;
                    var title = '<h3>BUY</h3>';
                    var is_id = 2;
                    getdatauser(userid,is_id,title);
                    break;
                case 'order':
                    $('#modal-type').val('order');
                    var userid = $('#'+type+'-form .userid-form').val();
                    var title = '<h3>ORDER</h3>';
                    var is_id = 1;
                    getdatauser(userid,is_id,title);
                    break;
                case 'transfer':
                    $('#modal-type').val('transfer');
                    var userid = $('#'+type+'-form .userid-form').val();
                    var title = '<h3>TRANSFER</h3>';
                    var is_id = 0;
                    getdatauser(userid,is_id,title);
                    break;
                default:
                    alert('No Modal Type Found');
            }
        }

        function getdatauser(userid,is_id,title){
            $.get('/pin/ajax-getdatauser/'+userid+'/'+is_id, function(data){
                $('.title-modal').empty();
                $('.userid-modal').empty();
                $('.nama-modal').empty();
                $('.telepon-modal').empty();
                //if(typeof data !== 'undefined' && data.length > 0){
                //    $.each(data, function(index, value){
                $('.title-modal').html(title);
                $('.userid-modal').html('<strong>' + data.userid+'</strong>');
                $('.nama-modal').html('<strong>' + data.nama+'</strong>');
                $('.telepon-modal').html('<strong>' + data.telepon+'</strong>');
                //    });
                //}
                //else{
                //    $('.title-modal').html('<div class="label label-danger">USER NOT FOUND</div><br>');
                //}
            });
        }

        function submit_form(){
            var form_id = $('#modal-type').val();
            $('#'+form_id+'-form').submit();
        }
    </script>
@endsection