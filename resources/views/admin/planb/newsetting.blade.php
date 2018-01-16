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
        <form id="frmPlanB" class="form-horizontal" role="form" method="POST" action="{{ route('admin.planb.setting') }}">
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
                                        <label class="control-label col-md-7" for="bonus_up_member_b">Bonus for Sponsor</label>
                                        <div class="col-md-3">
                                            <input type="text" class="form-control right-field" name="bonus_up_member_b" id="bonus_up_member_b"
                                                   @if(session('pesan-flash') && session('pesan-flash')['type']=='error')
                                                   value="{{ old('bonus_up_member_b') }}"
                                                   @else
                                                   value="{{ !empty($data) ? $data->bonus_up_member_b : 0 }}"
                                                    @endif >
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group">
                                    <div class="col-sm-10 col-sm-offset-1 col-lg-10 col-lg-offset-1">
                                        <label class="control-label col-md-7" for="require_planb">Plan-B Required</label>
                                        <div class="col-md-3">
                                            <input type="checkbox" name="require_planb" id="require_planb" value="1"
                                                   @if(session('pesan-flash') && session('pesan-flash')['type']=='error')
                                                   @if (old('require_planb') == 1)
                                                   checked="checked"
                                                   @endif
                                                   @else
                                                   @if (!empty($data) && $data->require_planb == 1)
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
                                        <label class="control-label col-md-7" for="bonus_split_nupoint">Split Nu Point (%)</label>
                                        <div class="col-md-3">
                                            <input type="text" class="form-control right-field" name="bonus_split_nupoint" id="bonus_split_nupoint"
                                                   @if(session('pesan-flash') && session('pesan-flash')['type']=='error')
                                                   value="{{ old('bonus_split_nupoint') }}"
                                                   @else
                                                   value="{{ !empty($data) ? $data->bonus_split_nupoint : 0 }}"
                                                    @endif >
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group">
                                    <div class="col-sm-10 col-sm-offset-1 col-lg-10 col-lg-offset-1">
                                        <label class="control-label col-md-7">Split Nu Cash (%)</label>
                                        <div class="col-md-3">
                                            <label class="form-control right-field" id="bonus_split_nucash"></label>
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
                                        <label class="control-label col-md-7" for="subsidi_tarif_kirim">Subsidi Ongkir</label>
                                        <div class="col-md-3">
                                            <input type="text" class="form-control right-field" name="subsidi_tarif_kirim" id="subsidi_tarif_kirim"
                                                   @if(session('pesan-flash') && session('pesan-flash')['type']=='error')
                                                   value="{{ old('subsidi_tarif_kirim') }}"
                                                   @else
                                                   value="{{ !empty($data) ? $data->subsidi_tarif_kirim : 0 }}"
                                                    @endif >
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
            function setCash(obj) {
                var splitPoint = parseInt(obj.val());
                if (isNaN(splitPoint)) {splitPoint = 0;}
                $('#bonus_split_nucash').text(100 - splitPoint);
            }
            $('#bonus_split_nupoint').on('input', function() {
                setCash($(this));
            });
            setCash($('#bonus_split_nupoint'));

            $('select').select2();

            $('#bonus_up_member_b').mask("#.##0", {reverse: true});
            $('#subsidi_tarif_kirim').mask("#.##0", {reverse: true});

            $('#frmPlanB').submit(function(){
                $('#bonus_up_member_b').unmask();
                $('#subsidi_tarif_kirim').unmask();
            })

        });
    </script>
@endsection