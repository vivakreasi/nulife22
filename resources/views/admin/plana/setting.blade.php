@extends('layouts.main')
@section('header')
    @include('layouts.header')
@endsection
@section('content')
<style type="text/css">
    .right-field {text-align: right;}
</style>
<section class="panel">
    <form id="frmPlanA" class="form-horizontal" role="form" method="POST" action="{{ route('admin.plana.setting') }}">
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
                                    <label class="control-label col-md-7" for="max_account">Max.Account</label>
                                    <div class="col-md-3">
                                        <input type="text" class="form-control right-field" name="max_account" id="max_account" 
                                        @if(session('pesan-flash') && session('pesan-flash')['type']=='error') 
                                            value="{{ old('max_account') }}"
                                        @else 
                                            value="{{ !empty($data) ? $data->max_account : 0 }}"
                                        @endif >
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group">
                                <div class="col-sm-10 col-sm-offset-1 col-lg-10 col-lg-offset-1">
                                    <label class="control-label col-md-7" for="min_upgrade_b">Min.Member To Upgrade To Plan-B</label>
                                    <div class="col-md-3">
                                        <input type="text" class="form-control right-field" name="min_upgrade_b" id="min_upgrade_b" 
                                        @if(session('pesan-flash') && session('pesan-flash')['type']=='error') 
                                            value="{{ old('min_upgrade_b') }}"
                                        @else 
                                            value="{{ !empty($data) ? $data->min_upgrade_b : 0 }}"
                                        @endif >
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group">
                                <div class="col-sm-10 col-sm-offset-1 col-lg-10 col-lg-offset-1">
                                    <label class="control-label col-md-7" for="cost_reach_upgrade_b">Cost Upgrade To Plan-B (Reached Min.Member)</label>
                                    <div class="col-md-3">
                                        <input type="text" class="form-control right-field" name="cost_reach_upgrade_b" id="cost_reach_upgrade_b" 
                                        @if(session('pesan-flash') && session('pesan-flash')['type']=='error') 
                                            value="{{ old('cost_reach_upgrade_b') }}"
                                        @else 
                                            value="{{ !empty($data) ? $data->cost_reach_upgrade_b : 0 }}"
                                        @endif >
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group">
                                <div class="col-sm-10 col-sm-offset-1 col-lg-10 col-lg-offset-1">
                                    <label class="control-label col-md-7" for="cost_unreach_upgrade_b">Cost Upgrade To Plan-B (Unreached Min.Member)</label>
                                    <div class="col-md-3">
                                        <input type="text" class="form-control right-field" name="cost_unreach_upgrade_b" id="cost_unreach_upgrade_b" 
                                        @if(session('pesan-flash') && session('pesan-flash')['type']=='error') 
                                            value="{{ old('cost_unreach_upgrade_b') }}"
                                        @else 
                                            value="{{ !empty($data) ? $data->cost_unreach_upgrade_b : 0 }}"
                                        @endif >
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group">
                                <div class="col-sm-10 col-sm-offset-1 col-lg-10 col-lg-offset-1">
                                    <label class="control-label col-md-7" for="bonus_sponsor">Sponsoring Bonus</label>
                                    <div class="col-md-3">
                                        <input type="text" class="form-control right-field" name="bonus_sponsor" id="bonus_sponsor" 
                                        @if(session('pesan-flash') && session('pesan-flash')['type']=='error') 
                                            value="{{ old('bonus_sponsor') }}"
                                        @else 
                                            value="{{ !empty($data) ? $data->bonus_sponsor : 0 }}"
                                        @endif >
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group">
                                <div class="col-sm-10 col-sm-offset-1 col-lg-10 col-lg-offset-1">
                                    <label class="control-label col-md-7" for="bonus_pairing">Pairing Bonus</label>
                                    <div class="col-md-3">
                                        <input type="text" class="form-control right-field" name="bonus_pairing" id="bonus_pairing" 
                                        @if(session('pesan-flash') && session('pesan-flash')['type']=='error') 
                                            value="{{ old('bonus_pairing') }}"
                                        @else 
                                            value="{{ !empty($data) ? $data->bonus_pairing : 0 }}"
                                        @endif >
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group">
                                <div class="col-sm-10 col-sm-offset-1 col-lg-10 col-lg-offset-1">
                                    <label class="control-label col-md-7" for="max_pairing_day">Limit Pairing Bonus in 1 day</label>
                                    <div class="col-md-3">
                                        <input type="text" class="form-control right-field" name="max_pairing_day" id="max_pairing_day" 
                                        @if(session('pesan-flash') && session('pesan-flash')['type']=='error') 
                                            value="{{ old('max_pairing_day') }}"
                                        @else 
                                            value="{{ !empty($data) ? $data->max_pairing_day : 0 }}"
                                        @endif >
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group">
                                <div class="col-sm-10 col-sm-offset-1 col-lg-10 col-lg-offset-1">
                                    <label class="control-label col-md-7" for="flush_out_pairing">Flush Out Pairing Bonus</label>
                                    <div class="col-md-3">
                                        <input type="text" class="form-control right-field" name="flush_out_pairing" id="flush_out_pairing" 
                                        @if(session('pesan-flash') && session('pesan-flash')['type']=='error') 
                                            value="{{ old('flush_out_pairing') }}"
                                        @else 
                                            value="{{ !empty($data) ? $data->flush_out_pairing : 0 }}"
                                        @endif >
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
                            <div class="form-group">
                                <div class="col-sm-10 col-sm-offset-1 col-lg-10 col-lg-offset-1">
                                    <label class="control-label col-md-7" for="daily_placement_limit">Max. Daily Placement</label>
                                    <div class="col-md-3">
                                        <input type="text" class="form-control right-field" name="daily_placement_limit" id="daily_placement_limit"
                                               @if(session('pesan-flash') && session('pesan-flash')['type']=='error')
                                               value="{{ old('daily_placement_limit') }}"
                                               @else
                                               value="{{ !empty($data) ? $data->daily_placement_limit : 0 }}"
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


            $('#max_account').mask("#.##0", {reverse: true});
            $('#min_upgrade_b').mask("#.##0", {reverse: true});
            $('#cost_reach_upgrade_b').mask("#.##0", {reverse: true});
            $('#cost_unreach_upgrade_b').mask("#.##0", {reverse: true});
            $('#bonus_sponsor').mask("#.##0", {reverse: true});
            $('#bonus_pairing').mask("#.##0", {reverse: true});
            $('#max_pairing_day').mask("#.##0", {reverse: true});
            $('#flush_out_pairing').mask("#.##0", {reverse: true});
            $('#daily_placement_limit').mask("#.##0", {reverse: true});

            $('#frmPlanA').submit(function(){
                $('#max_account').unmask();
                $('#min_upgrade_b').unmask();
                $('#cost_reach_upgrade_b').unmask();
                $('#cost_unreach_upgrade_b').unmask();
                $('#bonus_sponsor').unmask();
                $('#bonus_pairing').unmask();
                $('#max_pairing_day').unmask();
                $('#flush_out_pairing').unmask();
                $('#daily_placement_limit').unmask();
            })

        });
    </script>
@endsection