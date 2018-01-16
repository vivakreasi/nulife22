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
        @if (Auth::user()->plan_status == 0)
            <form role="form" method="POST" action="{{ route('plan.upgrade.b') }}">
                {{ csrf_field() }}
                <div class="row">
                    <div class="col-sm-10 col-sm-offset-1">
                        <p>Your network count : <code>LEFT</code> <strong>{{ number_format(Auth::user()->getCountLeftStructure(), 0, ',', '.') }}</strong> <code>RIGHT</code> <strong>{{ number_format(Auth::user()->getCountRightStructure(), 0, ',', '.') }}</strong></p>
                        <p><code>Upgrade Price </code> : @ Rp. <strong>{{ number_format(Auth::user()->priceUpgradeToB(), 0, ',', '.') }}</strong> + unique digits + delivery cost.</p>
                        <p>Click the <code>"Upgrade Now"</code> button to start upgrade to NuLife Plan-B program. <em>(You must agree with our Term &amp; Conditions.)</em></p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-10 col-sm-offset-1 col-md-10 col-md-offset-1">
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="control-label text-left" style="padding-left: 0px;">Position(s)</label>
                                    <select class="form-control" id="sel_position" name="sel_position">
                                        <option value="1">1 position</option>
                                        <option value="3">3 position</option>
                                        <option value="7">7 position</option>
                                    </select>
                                </div>
{{--
                                <div class="form-group">
                                    <label class="checkbox-custom inline check-info">
                                        <input type="checkbox" value="1" id="chk_profile_address" name="chk_profile_address"> <label for="chk_profile_address">Use My Profile Address</label>
                                    </label>
                                </div>
--}}
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="control-label text-left">Delivery Address</label>
                                    <textarea class="form-control" name="address" id="address" rows="11"></textarea>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="control-label text-left">Province</label>
                                    <select class="form-control select2 select2-offscreen" id="provinsi" name="provinsi">
                                        <option selected>- Select Province -</option>
                                        @foreach($provinsi as $rowDaerah)
                                            <option value="{{$rowDaerah->id}}">{{$rowDaerah->nama}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label class="control-label text-left">City</label>
                                    <select class="form-control select2 select2-offscreen" id="kota" name="kota"></select>
                                </div>
                                <div class="form-group">
                                    <label class="control-label text-left">Districts</label>
                                    <select class="form-control select2 select2-offscreen" id="kelurahan" name="kelurahan">
                                        <option selected>- Select District -</option>
                                        @foreach($kecamatan as $row)
                                            <option value="{{$row->id}}">{{$row->tujuan}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label class="control-label text-left">Zip Code</label>
                                    <input class="form-control" type="text"name="zip_code" id="zip_code">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="checkbox-custom inline check-info">
                                <input type="checkbox" value="1" id="checkbox-101" name="agree"> <label for="checkbox-101">Yes, I am agree with <a href="#">Terms &amp; Conditions</a></label>
                            </label>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-info">Upgrade Now</button>
                        </div>
                    </div>
                </div>
            </form>
        @elseif (Auth::user()->plan_status == 1)
            <form class="form-horizontal" role="form" method="POST" action="{{ route('plan.upgrade.b') }}" enctype="multipart/form-data">
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
                                <input type="hidden" name="nomor" value="{{ Auth::user()->getDataUpgrade()->upgrade_kode }}">
                                <div class="form-group">
                                    <label class="col-md-4 control-label">Transaction Code</label>
                                    <div class="col-md-8">
                                        <label class="form-control">{{ strtoupper(Auth::user()->getDataUpgrade()->upgrade_kode) }}</label>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-4 control-label">Transfer Amount (Rp)</label>
                                    <div class="col-md-8">
                                        <label class="form-control">{{ number_format(Auth::user()->getDataUpgrade()->total_price, 0, '.', '.') }},-</label>
                                        <span class="help-block">
                                            <ul>
                                                <li>Package - {{ number_format(Auth::user()->getDataUpgrade()->planb_type, 0, '.', '.') }} position(s) : {{ number_format(Auth::user()->getDataUpgrade()->upgrade_price, 0, '.', '.') }}</li>
                                                <li>Delivery Cost : {{ number_format(Auth::user()->getDataUpgrade()->kirim_tarif, 0, '.', '.') }}</li>
                                                <li>Unique Digit : {{ number_format(Auth::user()->getDataUpgrade()->unique_digit, 0, '.', '.') }}</li>
                                                <li>Delivery Cost Discount : <code>{{ number_format(Auth::user()->getDataUpgrade()->kirim_tarif_subsidi, 0, '.', '.') }}</code></li>
                                            </ul>
                                        </span>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-4 control-label">To Bank :</label>
                                    <div class="col-md-8">
                                        <h5>{{ Auth::user()->getDataUpgrade()->bank_name }} <br />account no. <strong>{{ Auth::user()->getDataUpgrade()->bank_account }}</strong><br />account name <strong>{{ Auth::user()->getDataUpgrade()->bank_account_name }}</strong></h5>
                                    </div>
                                </div>
                                <div class="form-group{{ $errors->has('file') ? ' has-error' : '' }}">
                                    <label class="col-md-4 control-label">File</label>
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
                                    <div class="col-md-8 col-md-offset-2">
                                        <img id="imgbukti" class="col-md-8 col-md-offset-2 img-thumbnail" alt="No File Selected" src="/">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        @elseif (Auth::user()->plan_status == 2)
            <div class="col-sm-10 col-sm-offset-1 col-lg-10 col-lg-offset-1">
                <h4>Waiting Confirmation</h4>
            </div>
        @endif
    </div>
</section>
@endsection

@section('scripts')
    <script src="{{ asset('assets/js/vendor/select2.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/js/vendor/select2-init.js') }}" type="text/javascript"></script>
    <script type="text/javascript">
        $(document).ready(function(){
            $('#provinsi').on('change', function(){
                var prop = $(this);
                var kota = $('#kota');
                var idProvinsi = $('option:selected', prop).val();
                $.ajax({
                    type: "GET",
                    url: '{{ route("city.ajax") }}/'+idProvinsi,
                    error: function() {
                        alert('Something Error has occured');
                    }
                }).done(function(data) {
                    data = $.parseJSON(data);
                    kota.empty();
                    $(data).each(function() {
                        $('<option />', {
                            val: this.id,
                            text: this.nama_kota
                        }).appendTo(kota);
                    });
                });
            });
        });
    </script>

    @if (Auth::user()->plan_status == 1)
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
    @endif
@endsection
