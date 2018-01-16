@extends('layouts.main')

@section('header')
    @include('layouts.header')
@endsection

@section('vendor_style')
    <link href="{{ asset('assets/css/vendor/select2.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/vendor/select2-bootstrap.css') }}" rel="stylesheet">
@endsection

@section('content')
<style type="text/css">
    .right-field {text-align: right;}
</style>
<section class="panel">
    <form id="frmPlanC" class="form-horizontal" role="form" method="POST" action="{{ route('admin.planc.setting') }}">
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
                                    <label class="control-label col-md-7" for="max_c_account">Maximum Account Per-Member</label>
                                    <div class="col-md-3">
                                        <input type="text" class="form-control right-field" name="max_c_account" id="max_c_account" 
                                        @if(session('pesan-flash') && session('pesan-flash')['type']=='error') 
                                            value="{{ old('max_c_account') }}"
                                        @else 
                                            value="{{ !empty($data) ? $data->max_c_account : 0 }}"
                                        @endif >
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group">
                                <div class="col-sm-10 col-sm-offset-1 col-lg-10 col-lg-offset-1">
                                    <label class="control-label col-md-7" for="bonus_fly">Bonus Fly</label>
                                    <div class="col-md-3">
                                        <input type="text" class="form-control right-field" name="bonus_fly" id="bonus_fly" 
                                        @if(session('pesan-flash') && session('pesan-flash')['type']=='error') 
                                            value="{{ old('bonus_fly') }}"
                                        @else 
                                            value="{{ !empty($data) ? $data->bonus_fly : 0 }}"
                                        @endif >
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group">
                                <div class="col-sm-10 col-sm-offset-1 col-lg-10 col-lg-offset-1">
                                    <label class="control-label col-md-7" for="cost_pkg">Package Price</label>
                                    <div class="col-md-3">
                                        <input type="text" class="form-control right-field" name="cost_pkg" id="cost_pkg" 
                                        @if(session('pesan-flash') && session('pesan-flash')['type']=='error') 
                                            value="{{ old('cost_pkg') }}"
                                        @else 
                                            value="{{ !empty($data) ? $data->cost_pkg : 0 }}"
                                        @endif >
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{--
                        <div class="row">
                            <div class="form-group">
                                <div class="col-sm-10 col-sm-offset-1 col-lg-10 col-lg-offset-1">
                                    <label class="control-label col-md-7" for="pin_ruby">Pin Ruby</label>
                                    <div class="col-md-3">
                                        <input type="text" class="form-control right-field" name="pin_ruby" id="pin_ruby" 
                                        @if(session('pesan-flash') && session('pesan-flash')['type']=='error') 
                                            value="{{ old('pin_ruby') }}"
                                        @else 
                                            value="{{ !empty($data) ? $data->pin_ruby : 0 }}"
                                        @endif >
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group">
                                <div class="col-sm-10 col-sm-offset-1 col-lg-10 col-lg-offset-1">
                                    <label class="control-label col-md-7" for="pin_saphire">Pin Saphire</label>
                                    <div class="col-md-3">
                                        <input type="text" class="form-control right-field" name="pin_saphire" id="pin_saphire" 
                                        @if(session('pesan-flash') && session('pesan-flash')['type']=='error') 
                                            value="{{ old('pin_saphire') }}"
                                        @else 
                                            value="{{ !empty($data) ? $data->pin_saphire : 0 }}"
                                        @endif >
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group">
                                <div class="col-sm-10 col-sm-offset-1 col-lg-10 col-lg-offset-1">
                                    <label class="control-label col-md-7" for="pin_emerald">Pin Emerald</label>
                                    <div class="col-md-3">
                                        <input type="text" class="form-control right-field" name="pin_emerald" id="pin_emerald" 
                                        @if(session('pesan-flash') && session('pesan-flash')['type']=='error') 
                                            value="{{ old('pin_emerald') }}"
                                        @else 
                                            value="{{ !empty($data) ? $data->pin_emerald : 0 }}"
                                        @endif >
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group">
                                <div class="col-sm-10 col-sm-offset-1 col-lg-10 col-lg-offset-1">
                                    <label class="control-label col-md-7" for="pin_diamond">Pin Diamond</label>
                                    <div class="col-md-3">
                                        <input type="text" class="form-control right-field" name="pin_diamond" id="pin_diamond" 
                                        @if(session('pesan-flash') && session('pesan-flash')['type']=='error') 
                                            value="{{ old('pin_diamond') }}"
                                        @else 
                                            value="{{ !empty($data) ? $data->pin_diamond : 0 }}"
                                        @endif >
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group">
                                <div class="col-sm-10 col-sm-offset-1 col-lg-10 col-lg-offset-1">
                                    <label class="control-label col-md-7" for="pin_red_diamond">Pin Red Diamond</label>
                                    <div class="col-md-3">
                                        <input type="text" class="form-control right-field" name="pin_red_diamond" id="pin_red_diamond" 
                                        @if(session('pesan-flash') && session('pesan-flash')['type']=='error') 
                                            value="{{ old('pin_red_diamond') }}"
                                        @else 
                                            value="{{ !empty($data) ? $data->pin_red_diamond : 0 }}"
                                        @endif >
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group">
                                <div class="col-sm-10 col-sm-offset-1 col-lg-10 col-lg-offset-1">
                                    <label class="control-label col-md-7" for="pin_blue_diamond">Pin Blue Diamond</label>
                                    <div class="col-md-3">
                                        <input type="text" class="form-control right-field" name="pin_blue_diamond" id="pin_blue_diamond" 
                                        @if(session('pesan-flash') && session('pesan-flash')['type']=='error') 
                                            value="{{ old('pin_blue_diamond') }}"
                                        @else 
                                            value="{{ !empty($data) ? $data->pin_blue_diamond : 0 }}"
                                        @endif >
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group">
                                <div class="col-sm-10 col-sm-offset-1 col-lg-10 col-lg-offset-1">
                                    <label class="control-label col-md-7" for="pin_white_diamond">Pin White Diamond</label>
                                    <div class="col-md-3">
                                        <input type="text" class="form-control right-field" name="pin_white_diamond" id="pin_white_diamond" 
                                        @if(session('pesan-flash') && session('pesan-flash')['type']=='error') 
                                            value="{{ old('pin_white_diamond') }}"
                                        @else 
                                            value="{{ !empty($data) ? $data->pin_white_diamond : 0 }}"
                                        @endif >
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group">
                                <div class="col-sm-10 col-sm-offset-1 col-lg-10 col-lg-offset-1">
                                    <label class="control-label col-md-7" for="pin_black_diamond">Pin Black Diamond</label>
                                    <div class="col-md-3">
                                        <input type="text" class="form-control right-field" name="pin_black_diamond" id="pin_black_diamond" 
                                        @if(session('pesan-flash') && session('pesan-flash')['type']=='error') 
                                            value="{{ old('pin_black_diamond') }}"
                                        @else 
                                            value="{{ !empty($data) ? $data->pin_black_diamond : 0 }}"
                                        @endif >
                                    </div>
                                </div>
                            </div>
                        </div>
                        --}}
                        <div class="row">
                            <div class="form-group">
                                <div class="col-sm-10 col-sm-offset-1 col-lg-10 col-lg-offset-1">
                                    <label class="control-label col-md-7" for="multiple_queue">Multiple Queue</label>
                                    <div class="col-md-3">
                                        <input type="text" class="form-control right-field" name="multiple_queue" id="multiple_queue" 
                                        @if(session('pesan-flash') && session('pesan-flash')['type']=='error') 
                                            value="{{ old('multiple_queue') }}"
                                        @else 
                                            value="{{ !empty($data) ? $data->multiple_queue : 0 }}"
                                        @endif >
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group {{ ($errors->has('sel_product')) ? 'has-error' : '' }}">
                                <div class="col-sm-10 col-sm-offset-1 col-lg-10 col-lg-offset-1">
                                    <label class="col-md-7 control-label">Product</label>
                                    <div class="col-md-3">
                                        <select class="form-control select2-offscreen" id="sel_product" name="sel_product">
                                            <option value="">Select Product</option>
                                            @foreach($products as $item)
                                                <option value="{{ $item->id }}"
                                                @if(session('pesan-flash') && session('pesan-flash')['type']=='error')
                                                    {{ (old('sel_product') == $item->id) ? 'selected' : '' }}
                                                        @else
                                                    {{ (!empty($data) && $data->product_id == $item->id) ? 'selected' : '' }}
                                                        @endif
                                                >{{ $item->name }}</option>
                                            @endforeach
                                        </select>
                                        <span class="text-danger"><em>{{ ($errors->has('sel_product')) ? $errors->first('sel_product') : '' }}</em></span>
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
    <script src="{{ asset('assets/js/vendor/select2.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/js/vendor/jquery.mask.min.js') }}" type="text/javascript"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            $('select').select2();

            $('#max_c_account').mask("#.##0", {reverse: true});
            $('#cost_pkg').mask("#.##0", {reverse: true});
            $('#bonus_fly').mask("#.##0", {reverse: true});

            $('#frmPlanC').submit(function(){
                $('#max_c_account').unmask();
                $('#cost_pkg').unmask();
                $('#bonus_fly').unmask();
            })
        });
    </script>
@endsection