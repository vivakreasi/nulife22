@extends('layouts.main')
@section('header')
    @include('layouts.header')
@endsection
@section('content')

<section class="panel">
    <div class="panel-body">
        <div class="form-horizontal">
            <form class="form-horizontal" role="form" method="POST" action="{{ route('edit.profile.post') }}">
                {{ csrf_field() }}
                @if($type == 'passwd')
            <div class="container">
            <div id="changepassword" style="margin-top:20px" class="mainbox col-md-6 col-md-offset-2 col-sm-8 col-sm-offset-2">
                <div class="panel">
                    <div class="panel-body">
                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            <label for="password" class="col-md-4 control-label">New Password</label>
                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control" name="password" value="{{ old('password') }}" required autofocus>
                                @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('re_password') ? ' has-error' : '' }}">
                            <label for="re_password" class="col-md-4 control-label">Confirm New Password</label>
                            <div class="col-md-6">
                                <input id="re_password" type="password" class="form-control" name="re_password" value="{{ old('re_password') }}" required autofocus>
                                @if ($errors->has('re_password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('re_password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <input type="hidden" name="type" value="{{ $type }}">
                        <div class="row">
                            <button class="btn btn-info" type="submit">Save</button>
                            &nbsp;
                            <a href="{{ route('my.profile') }}" class="btn btn-warning">Cancel</a>
                        </div>
                    </div>
                </div>
            </div>
            </div>
                @endif
                @if($type == 'hp')
            <div class="container">
            <div id="changehp" style="margin-top:20px" class="mainbox col-md-6 col-md-offset-2 col-sm-8 col-sm-offset-2">
                <div class="panel">
                    <div class="panel-body">
                        <div class="form-group">
                            <label for="hp" class="col-md-4 control-label">Old Phone</label>
                            <div class="col-md-6">
                                <input id="hp" type="text" class="form-control" value="{{ $dataLogin->hp }}" disabled autofocus>
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('hp') ? ' has-error' : '' }}">
                            <label for="hp" class="col-md-4 control-label">New Phone</label>
                            <div class="col-md-6">
                                <input id="hp" type="text" class="form-control" name="hp" value="{{ old('hp') }}" required autofocus>
                                @if ($errors->has('hp'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('hp') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <input type="hidden" name="type" value="{{ $type }}">
                        <div class="row">
                            <button class="btn btn-info" type="submit">Save</button>
                            &nbsp;
                            <a href="{{ route('my.profile') }}" class="btn btn-warning">Cancel</a>
                        </div>
                    </div>
                </div>
            </div>
            </div>
                @endif
                
                @if($type == 'alamat')
            <div class="container">
            <div id="changealamat" style="margin-top:20px" class="mainbox col-md-6 col-md-offset-2 col-sm-8 col-sm-offset-2">
                <div class="panel">
                    <div class="panel-body">
                        <div class="form-group">
                            <label for="hp" class="col-md-4 control-label">Old Address</label>
                            <div class="col-md-7">
                                <input id="hp" type="text" class="form-control" value="{{ $dataProfile->alamat }}" disabled autofocus>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="provinsi" class="col-md-4 control-label">Old Province</label>
                            <div class="col-md-7">
                                <input id="hp" type="text" class="form-control" value="{{ $dataProfile->nama }}" disabled autofocus>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="kota" class="col-md-4 control-label">Old City</label>
                            <div class="col-md-7">
                                <input id="hp" type="text" class="form-control" value="{{ $dataProfile->nama_kota }}" disabled autofocus>
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('alamat') ? ' has-error' : '' }}">
                            <label for="alamat" class="col-md-4 control-label">New Address</label>
                            <div class="col-md-7">
                                <textarea id="name" class="form-control" name="alamat" value="{{ old('alamat') }}" required autofocus></textarea>
                                @if ($errors->has('alamat'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('alamat') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('provinsi') ? ' has-error' : '' }}">
                            <label for="provinsi" class="col-md-4 control-label">New Province</label>
                            <div class="col-md-7">
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
                            <label for="kota" class="col-md-4 control-label">New City</label>
                            <div class="col-md-7">
                                <select class="form-control"  id="kota" name="kota">
                                </select>
                                @if ($errors->has('kota'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('kota') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        
                        
                        <input type="hidden" name="type" value="{{ $type }}">
                        <div class="row">
                            <button class="btn btn-info" type="submit">Save</button>
                            &nbsp;
                            <a href="{{ route('my.profile') }}" class="btn btn-warning">Cancel</a>
                        </div>
                    </div>
                </div>
            </div>
            </div>
                @endif
                
                @if($type == 'ktp')
            <div class="container">
            <div id="changektp" style="margin-top:20px" class="mainbox col-md-6 col-md-offset-2 col-sm-8 col-sm-offset-2">
                <div class="panel">
                    <div class="panel-body">
                        <div class="form-group">
                            <label for="ktp" class="col-md-4 control-label">Old Identity Card</label>
                            <div class="col-md-6">
                                <input id="hp" type="text" class="form-control" value="{{ $dataProfile->ktp }}" disabled autofocus>
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('ktp') ? ' has-error' : '' }}">
                            <label for="ktp" class="col-md-4 control-label">New Identity Card</label>
                            <div class="col-md-6">
                                <input id="hp" type="text" class="form-control" name="ktp" value="{{ old('ktp') }}" required autofocus>
                                @if ($errors->has('ktp'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('ktp') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <input type="hidden" name="type" value="{{ $type }}">
                        <div class="row">
                            <button class="btn btn-info" type="submit">Save</button>
                            &nbsp;
                            <a href="{{ route('my.profile') }}" class="btn btn-warning">Cancel</a>
                        </div>
                    </div>
                </div>
            </div>
            </div>
                @endif
                
                @if($type == 'gender')
            <div class="container">
            <div id="changegender" style="margin-top:20px" class="mainbox col-md-6 col-md-offset-2 col-sm-8 col-sm-offset-2">
                <div class="panel">
                    <div class="panel-body">
                        <div class="form-group">
                            <label for="ktp" class="col-md-4 control-label">Old Gender</label>
                            <?php
                                $gender = 'Man';
                                if($dataProfile->gender == 2){
                                    $gender = 'Woman';
                                }
                            ?>
                            <div class="col-md-6">
                                <input id="hp" type="text" class="form-control" value="{{ $gender }}" disabled autofocus>
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('gender') ? ' has-error' : '' }}">
                            <label for="gender" class="col-md-4 control-label">New Gender</label>
                            <div class="col-md-6">
                                <select class="form-control"  id="gender" name="gender">
                                    <option selected value="1">Man</option>
                                    <option value="2">Women</option>
                                </select>
                            </div>
                        </div>
                        <input type="hidden" name="type" value="{{ $type }}">
                        <div class="row">
                            <button class="btn btn-info" type="submit">Save</button>
                            &nbsp;
                            <a href="{{ route('my.profile') }}" class="btn btn-warning">Cancel</a>
                        </div>
                    </div>
                </div>
            </div>
            </div>
                @endif
                
                @if($type == 'birth')
                    <?php
                        $birth_date = 'No Data';
                        if($dataProfile->birth_date != null){
                            $birth_date = date('d F Y', strtotime($dataProfile->birth_date));
                        }
                    ?>
            <div class="container">
            <div id="changebirth" style="margin-top:20px" class="mainbox col-md-6 col-md-offset-2 col-sm-8 col-sm-offset-2">
                <div class="panel">
                    <div class="panel-body">
                        <div class="form-group">
                            <label for="birth_date" class="col-md-4 control-label">Old Birth Date</label>
                            <div class="col-md-6">
                                <input id="hp" type="text" class="form-control" value="{{ $birth_date }}" disabled autofocus>
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('birth_date') ? ' has-error' : '' }}">
                            <label for="birth_date" class="col-md-4 control-label">New Birth Date</label>
                            <div class="col-md-6">
                                <input id="bisrth_date" type="text" class="form-control" name="birth_date" value="{{ old('birth_date') }}" autofocus>
                                @if ($errors->has('birth_date'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('birth_date') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <input type="hidden" name="type" value="{{ $type }}">
                        <div class="row">
                            <button class="btn btn-info" type="submit">Save</button>
                            &nbsp;
                            <a href="{{ route('my.profile') }}" class="btn btn-warning">Cancel</a>
                        </div>
                    </div>
                </div>
            </div>
            </div>
                @endif
                
                @if($type == 'paspor')
            <div class="container">
            <div id="changepaspor" style="margin-top:20px" class="mainbox col-md-6 col-md-offset-2 col-sm-8 col-sm-offset-2">
                <div class="panel">
                    <div class="panel-body">
                        <div class="form-group">
                            <label for="paspor" class="col-md-4 control-label">Old Passport</label>
                            <div class="col-md-6">
                                <input id="hp" type="text" class="form-control" value="{{ $dataProfile->paspor }}" disabled autofocus>
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('paspor') ? ' has-error' : '' }}">
                            <label for="paspor" class="col-md-4 control-label">New Passport</label>
                            <div class="col-md-6">
                                <input id="hp" type="text" class="form-control" name="paspor" value="{{ old('paspor') }}" required autofocus>
                                @if ($errors->has('paspor'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('paspor') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <input type="hidden" name="type" value="{{ $type }}">
                        <div class="row">
                            <button class="btn btn-info" type="submit">Save</button>
                            &nbsp;
                            <a href="{{ route('my.profile') }}" class="btn btn-warning">Cancel</a>
                        </div>
                    </div>
                </div>
            </div>
            </div>
                @endif
            </form>
        </div>
    </div>
</section>  

@endsection

@section('scripts')
@if($type == 'birth')
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
@endif
@if($type == 'alamat')
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
@endif
@endsection