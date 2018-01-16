@extends('layouts.main')
@section('header')
    @include('layouts.header')
@endsection
@section('content')
<style type="text/css">
    .no-border {border: none; background-color: inherit;}
    label.no-margin {margin-bottom: 0; padding-left: 0; padding-bottom: 0; height: auto;}
</style>
<section class="panel">
    <div class="panel-body">
        <form class="form-horizontal" role="form" method="POST" action="{{ route('partner.upload') }}" enctype="multipart/form-data">
            {{ csrf_field() }}
            <div class="row">
                <div class="col-md-10 col-md-offset-1">
                    <div class="panel panel-default">
                        <div class="panel-heading">Upload Transfered Payment
                            <div class="pull-right">
                                <button type="submit" class="btn btn-primary" style="padding: 0 5px;"><i class="fa fa-btn fa-upload"></i> Upload</button>
                            </div>
                        </div>
                        <div class="panel-body">
                            <input type="hidden" name="nomor" value="{{ $partnerStatus->dataOrder->id }}">
                            <div class="row">
                                <label class="col-md-2 control-label">No :</label>
                                <div class="col-md-8">
                                    <label class="form-control no-border no-margin">{{  $partnerStatus->dataOrder->id }}</label>
                                </div>
                            </div>
                            <div class="row">
                                <label class="col-md-2 control-label">Name :</label>
                                <div class="col-md-8">
                                    <label class="form-control no-border no-margin">{{ Auth::user()->name }}</label>
                                </div>
                            </div>
                            <div class="row">
                                <label class="col-md-2 control-label">Type :</label>
                                <div class="col-md-8">
                                    <label class="form-control no-border no-margin">
                                    @if (Auth::user()->isStockis())
                                        Upgrade To Master Stockist
                                    @else
                                        Join Partner As {{ ($partnerStatus->dataOrder->type_stockist_id == 2) ? 'Master ' : '' }}Stockist
                                    @endif
                                    </label>
                                </div>
                            </div>
                            <div class="row">
                                <label class="col-md-2 control-label">To Bank :</label>
                                <div class="col-md-8">
                                    <h5>{{ $partnerStatus->dataOrder->bank_name }} <br />account no. <strong>{{ $partnerStatus->dataOrder->bank_account }}</strong><br />account name <strong>{{ $partnerStatus->dataOrder->bank_account_name }}</strong></h5>
                                </div>
                            </div>
                            <div class="row">
                                <label class="col-md-2 control-label">Pin Amount :</label>
                                <div class="col-md-8">
                                    <label class="form-control no-border no-margin">{{  $partnerStatus->dataOrder->jml_pin }}</label>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-2 control-label">Total Price (Rp) :</label>
                                <div class="col-md-8">
                                    <label class="form-control no-border no-margin">{{ number_format($partnerStatus->dataOrder->total_transfer, 0, ',', '.') }},-</label>
                                </div>
                            </div>
                            <div class="form-group{{ $errors->has('file') ? ' has-error' : '' }}">
                                <label class="col-md-2 control-label">File :</label>
                                <div class="col-md-8">
                                    <div class="input-group">
                                        <div class="input-group-btn">
                                            <label for="ifile" class="btn btn-primary">Browse</label>
                                            <input id="ifile" type="file" class="hide" name="file" accept="file_extension/*,.jpg,.png,.jpeg">
                                        </div>
                                        <label class="form-control" id="namafile"></label>
                                    </div>
                                    @if ($errors->has('file'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('file') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="panel-footer">
                            <div class="form-group">
                                <div class="col-md-10 col-md-offset-1">
                                    <img id="imgbukti" class="col-md-8 col-md-offset-2 img-thumbnail" alt="No File Selected" src="/">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</section>
@endsection

@section('scripts')
    <script type="text/javascript">
        $(document).ready(function() {
            function readURL(input) {
                if (input.files && input.files[0]) {
                    var reader = new FileReader();
                    reader.onload = function (e) {
                        $('#imgbukti').attr('src', e.target.result).show();
                    };
                    reader.readAsDataURL(input.files[0]);
                    $('#namafile').text(input.files[0].name);
                }
            }
            $("#ifile").on('change', function() { readURL(this); });
        });
    </script>
@endsection
