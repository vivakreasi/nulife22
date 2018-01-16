@extends('layouts.main')

@section('header')
    @include('layouts.header')
@endsection

@section('content')
    <style type="text/css">
        .right-field {text-align: right;}
    </style>
    <section class="panel">
        <form id="frmPartner" class="form-horizontal" role="form" method="POST" action="{{ route('admin.partner.setting') }}">
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
                                        <label class="control-label col-md-7" for="min_stockist_order">STOCKIST Minimum PIN Order</label>
                                        <div class="col-md-3">
                                            <input type="text" class="form-control right-field" name="min_stockist_order" id="min_stockist_order"
                                                   @if(session('pesan-flash') && session('pesan-flash')['type']=='error')
                                                   value="{{ old('min_stockist_order') }}"
                                                   @else
                                                   value="{{ !empty($data) ? $data->min_stockist_order : 0 }}"
                                                    @endif >
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group">
                                    <div class="col-sm-10 col-sm-offset-1 col-lg-10 col-lg-offset-1">
                                        <label class="control-label col-md-7" for="min_masterstockist_order">MASTER STOCKIST Minimum PIN Order</label>
                                        <div class="col-md-3">
                                            <input type="text" class="form-control right-field" name="min_masterstockist_order" id="min_masterstockist_order"
                                                   @if(session('pesan-flash') && session('pesan-flash')['type']=='error')
                                                   value="{{ old('min_masterstockist_order') }}"
                                                   @else
                                                   value="{{ !empty($data) ? $data->min_masterstockist_order : 0 }}"
                                                    @endif >
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group">
                                    <div class="col-sm-10 col-sm-offset-1 col-lg-10 col-lg-offset-1">
                                        <label class="control-label col-md-7" for="show_stockist_address">Show Stockist Address to Member?</label>
                                        <div class="col-md-3">
                                            <input type="checkbox" name="show_stockist_address" id="show_stockist_address" value="1"
                                                   @if(session('pesan-flash') && session('pesan-flash')['type']=='error')
                                                   @if (old('show_stockist_address') == 1)
                                                   checked="checked"
                                                   @endif
                                                   @else
                                                   @if (!empty($data) && $data->show_stockist_address == 1)
                                                   checked="checked"
                                                    @endif
                                                    @endif
                                            >
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group">
                                    <div class="col-sm-10 col-sm-offset-1 col-lg-10 col-lg-offset-1">
                                        <label class="control-label col-md-7" for="show_stockist_phone">Show Stockist Phone to Member?</label>
                                        <div class="col-md-3">
                                            <input type="checkbox" name="show_stockist_phone" id="show_stockist_phone" value="1"
                                                   @if(session('pesan-flash') && session('pesan-flash')['type']=='error')
                                                   @if (old('show_stockist_phone') == 1)
                                                   checked="checked"
                                                   @endif
                                                   @else
                                                   @if (!empty($data) && $data->show_stockist_phone == 1)
                                                   checked="checked"
                                                    @endif
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
            $('#min_masterstockist_order').mask("#.##0", {reverse: true});
            $('#min_stockist_order').mask("#.##0", {reverse: true});

            $('#frmPartner').submit(function(){
                $('#min_masterstockist_order').unmask();
                $('#min_stockist_order').unmask();
            })
        });
    </script>
@endsection