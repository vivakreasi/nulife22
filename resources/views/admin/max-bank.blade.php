@extends('layouts.main')

@section('header')
    @include('layouts.header')
@endsection

@section('content')
<section class="panel">
        <div class="panel panel-primary member-panel">
            <div class="panel-heading member-panel-heading">Last Maximum Bank Member</div>
            <div class="panel-body">
                <table class="table table-bordered table-hover responsive nowrap" id="tbl-nulife">
                    <thead>
                        <tr>
                            <th>Max Used Bank</th>
                            <th>Date Created</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>{{$data->max_bank}}</td>
                            <td>
                                @if($data->date == null)
                                    Default Setting
                                @else 
                                    {{date('d F Y', strtotime($data->date))}}
                                @endif
                                
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
</section>
<section class="panel">
    <form class="form-horizontal" role="form" method="POST" action="{{ route('admin.max.bank.post') }}">
        <div class="panel-body">
            {{ csrf_field() }}

            <div class="form-group{{ $errors->has('max_bank') ? ' has-error' : '' }}">
                <label for="max_bank" class="col-md-2 control-label">*Max Used Bank</label>
                <div class="col-md-8">
                    <input id="max_bank" type="text" class="form-control autoNumDot" name="max_bank" value="{{ old('max_bank') }}" required autofocus>
                    @if ($errors->has('max_bank'))
                        <span class="help-block">
                            <strong>{{ $errors->first('max_bank') }}</strong>
                        </span>
                    @endif
                </div>
            </div>

            <div class="form-group">
                <div class="col-md-6">
                    <button class="btn btn-info" type="submit">Save</button>
                    &nbsp;
                    <a href="{{ route('dashboard') }}" class="btn btn-warning">Cancel</a>
                </div>
            </div>
        </div>
    </form>
</section>
@endsection

@section('scripts')
<script type="text/javascript">
    $(function(){
        $('.autoNumDot').keypress(function(event) {
            var charCode = (event.which) ? event.which : event.keyCode
        if (
            (charCode != 46 || $(this).val().indexOf('.') != -1) &&      // “.” CHECK DOT, AND ONLY ONE.
            (charCode < 48 || charCode > 57))
            return false;

        return true;
        });
    });
</script>
@endsection
