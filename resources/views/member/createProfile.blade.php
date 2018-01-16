@extends('layouts.main')
@section('header')
    @include('layouts.header')
@endsection
@section('content')
    <section class="panel">
        <div class="panel-body">
                <form class="form-horizontal" role="form" method="POST" action="{{ route('new.profile') }}">
                    <div class="panel-body">
                        {{ csrf_field() }}
                        <div class="form-group{{ $errors->has('alamat') ? ' has-error' : '' }}">
                            <label for="alamat" class="col-md-4 control-label">*Address</label>
                            <div class="col-md-6">
                                <textarea id="name" class="form-control" name="alamat" value="{{ old('alamat') }}" required autofocus></textarea>
                                @if ($errors->has('alamat'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('alamat') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('provinsi') ? ' has-error' : '' }}">
                            <label for="provinsi" class="col-md-4 control-label">*Province</label>
                            <div class="col-md-6">
                                <select class="form-control"  id="provinsi" name="provinsi">
                                    <option selected>- Select Province -</option>
                                    @foreach($provinsi as $rowDaerah)
                                        <option value="{{$rowDaerah->id}}">{{$rowDaerah->nama}}</option>
                                    @endforeach
                                </select>
                                @if ($errors->has('provinsi'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('provinsi') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('kota') ? ' has-error' : '' }}">
                            <label for="kota" class="col-md-4 control-label">*City</label>
                            <div class="col-md-6">
                                <select class="form-control"  id="kota" name="kota">
                                    {{--
                                    <option selected>- Select City -</option>
                                    @foreach($kota as $rowKota)
                                        <option value="{{$rowKota->id}}">{{$rowKota->nama}} - {{$rowKota->nama_kota}}</option>
                                    @endforeach
                                    --}}

                                </select>
                                @if ($errors->has('kota'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('kota') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('kode_pos') ? ' has-error' : '' }}">
                            <label for="kode_pos" class="col-md-4 control-label">*Postal Code</label>
                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control" name="kode_pos" value="{{ old('kode_pos') }}" required autofocus>
                                @if ($errors->has('kode_pos'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('kode_pos') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('gender') ? ' has-error' : '' }}">
                            <label for="gender" class="col-md-4 control-label">*Gender</label>
                            <div class="col-md-6">
                                <select class="form-control"  id="gender" name="gender">
                                    <option selected value="1">Man</option>
                                    <option value="2">Women</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('ktp') ? ' has-error' : '' }}">
                            <label for="ktp" class="col-md-4 control-label">*Identity Card</label>
                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control" name="ktp" value="{{ old('ktp') }}" required autofocus>
                                @if ($errors->has('ktp'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('ktp') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('paspor') ? ' has-error' : '' }}">
                            <label for="paspor" class="col-md-4 control-label">Passport</label>
                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control" name="paspor" value="{{ old('paspor') }}" autofocus>
                                @if ($errors->has('paspor'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('paspor') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('birth_date') ? ' has-error' : '' }}">
                            <label for="birth_date" class="col-md-4 control-label">*Birth Date</label>
                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control" name="birth_date" value="{{ old('birth_date') }}" autofocus>
                                @if ($errors->has('birth_date'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('birth_date') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="panel-footer">
                        <div class="row">
                            <button class="btn btn-info" type="submit">Save</button>
                        </div>
                    </div>
                </form>
        </div>    
    </section>
@endsection

@section('scripts')

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


<script type="text/javascript" src="//cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="//cdn.jsdelivr.net/bootstrap.daterangepicker/2/daterangepicker.js"></script>
<link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/bootstrap.daterangepicker/2/daterangepicker.css" />
<script type="text/javascript">
        $(function() {
            $('input[name="birth_date"]').daterangepicker({
                singleDatePicker: true,
                showDropdowns: true
            }, 
            function(start, end, label) {
                var years = moment().diff(start, 'years');
                //alert("You are " + years + " years old.");
            });
        });
</script>
@endsection