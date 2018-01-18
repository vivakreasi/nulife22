@extends('layouts.main')

@section('header')
    @include('layouts.header')
@endsection

@section('content')
    <style type="text/css">
        .right-field {text-align: right;}
    </style>
    <section class="panel">
        <form id="frmPin" class="form-horizontal" role="form" method="POST" action="{{ route('admin.pinb.setting') }}">
            <div class="panel-body">
                {{ csrf_field() }}
                <input type="hidden" name="id" value="{{ !empty($data) ? $data->id : '' }}">
                <div class="row">
                    <div class="col-md-10 col-md-offset-1">
                        <div class="well well-lg">
                            <div class="row">
                                <div class="form-group">
                                    <div class="col-sm-10 col-sm-offset-1 col-lg-10 col-lg-offset-1">
                                        <label class="control-label col-md-7"><strong>Last Update</strong></label>
                                        <div class="col-md-3">
                                            <label class="control-label"><strong>{{ $data->updated_at }}</strong></label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group">
                                    <div class="col-sm-10 col-sm-offset-1 col-lg-10 col-lg-offset-1">
                                        <label class="control-label col-md-7" for="pin_type_name">PIN Name</label>
                                        <div class="col-md-3">
                                            <input type="text" class="form-control" name="pin_type_name" id="pin_type_name"
                                                   @if(session('pesan-flash') && session('pesan-flash')['type']=='error')
                                                   value="{{ old('pin_type_name') }}"
                                                   @else
                                                   value="{{ !empty($data) ? $data->pin_type_name : 0 }}"
                                                    @endif >
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group">
                                    <div class="col-sm-10 col-sm-offset-1 col-lg-10 col-lg-offset-1">
                                        <label class="control-label col-md-7" for="business_rights_amount">Business Rights Amount</label>
                                        <div class="col-md-3">
                                            <input type="text" class="form-control right-field" name="business_rights_amount" id="business_rights_amount"
                                                   @if(session('pesan-flash') && session('pesan-flash')['type']=='error')
                                                   value="{{ old('business_rights_amount') }}"
                                                   @else
                                                   value="{{ !empty($data) ? $data->business_rights_amount : 0 }}"
                                                    @endif
                                                   >
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group">
                                    <div class="col-sm-10 col-sm-offset-1 col-lg-10 col-lg-offset-1">
                                        <label class="control-label col-md-7" for="pin_type_price">Member Price</label>
                                        <div class="col-md-3">
                                            <input type="text" class="form-control right-field" name="pin_type_price" id="pin_type_price"
                                                   @if(session('pesan-flash') && session('pesan-flash')['type']=='error')
                                                   value="{{ old('pin_type_price') }}"
                                                   @else
                                                   value="{{ !empty($data) ? $data->pin_type_price : 0 }}"
                                                   @endif
                                                   >
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group">
                                    <div class="col-sm-10 col-sm-offset-1 col-lg-10 col-lg-offset-1">
                                        <label class="control-label col-md-7" for="pin_type_stockis_price">Stockist Price</label>
                                        <div class="col-md-3">
                                            <input type="text" class="form-control right-field" name="pin_type_stockis_price" id="pin_type_stockis_price"
                                                   @if(session('pesan-flash') && session('pesan-flash')['type']=='error')
                                                   value="{{ old('pin_type_stockis_price') }}"
                                                   @else
                                                   value="{{ !empty($data) ? $data->pin_type_stockis_price : 0 }}"
                                                   @endif
                                                   >
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group">
                                    <div class="col-sm-10 col-sm-offset-1 col-lg-10 col-lg-offset-1">
                                        <label class="control-label col-md-7" for="pin_type_masterstockis_price">Master Stockist Price</label>
                                        <div class="col-md-3">
                                            <input type="text" class="form-control right-field" name="pin_type_masterstockis_price" id="pin_type_masterstockis_price"
                                                   @if(session('pesan-flash') && session('pesan-flash')['type']=='error')
                                                   value="{{ old('pin_type_masterstockis_price') }}"
                                                   @else
                                                   value="{{ !empty($data) ? $data->pin_type_masterstockis_price : 0 }}"
                                                   @endif
                                                   >
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group">
                                    <div class="col-sm-10 col-sm-offset-1 col-lg-10 col-lg-offset-1">
                                        <label class="control-label col-md-7"></label>
                                        <div class="col-md-3">
                                            <button class="btn btn-success addon-btn m-b-10" type="submit">
                                                <i class="fa fa-save"></i>
                                                Save
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </section>
@endsection

@section('scripts')
    <script src="{{ asset('assets/js/vendor/jquery.mask.min.js') }}" type="text/javascript"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            $('#business_rights_amount').mask("#.##0", {reverse: true});
            $('#pin_type_price').mask("#.##0", {reverse: true});
            $('#pin_type_stockis_price').mask("#.##0", {reverse: true});
            $('#pin_type_masterstockis_price').mask("#.##0", {reverse: true});

            $('#frmPin').submit(function(){
                $('#business_rights_amount').unmask();
                $('#pin_type_price').unmask();
                $('#pin_type_stockis_price').unmask();
                $('#pin_type_masterstockis_price').unmask();
            })
        });
    </script>
@endsection