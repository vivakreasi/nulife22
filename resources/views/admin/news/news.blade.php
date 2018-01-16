@extends('layouts.main')

@section('header')
    @include('layouts.header')
@endsection

@section('content')
<section class="panel">
        <form class="form-horizontal" role="form" method="POST" action="{{ route('admin.news.post') }}">
            <div class="panel-body">
                {{ csrf_field() }}
                
                <div class="form-group{{ $errors->has('title') ? ' has-error' : '' }}">
                    <label for="title" class="col-md-2 control-label">*Title</label>
                    <div class="col-md-8">
                        <input id="title" type="text" class="form-control" name="title" value="{{ old('title') }}" required autofocus>
                        @if ($errors->has('title'))
                            <span class="help-block">
                                <strong>{{ $errors->first('title') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>
                
                <div class="form-group{{ $errors->has('image_url') ? ' has-error' : '' }}">
                    <label for="image_url" class="col-md-2 control-label">*Image URL</label>
                    <div class="col-md-8">
                        <input id="image_url" type="text" class="form-control" name="image_url" value="{{ old('image_url') }}" required autofocus>
                        @if ($errors->has('image_url'))
                            <span class="help-block">
                                <strong>{{ $errors->first('image_url') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>
                
                <div class="form-group{{ $errors->has('sort_desc') ? ' has-error' : '' }}">
                    <label for="sort_desc" class="col-md-2 control-label">*Sort Desc</label>
                    <div class="col-md-8">
                        <textarea id="sort_desc" class="form-control" name="sort_desc" >{{ old('sort_desc') }}</textarea>
                        @if ($errors->has('sort_desc'))
                            <span class="help-block">
                                <strong>{{ $errors->first('sort_desc') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>

                <div class="form-group{{ $errors->has('desc') ? ' has-error' : '' }}">
                    <label for="desc" class="col-md-2 control-label">*Desc</label>
                    <div class="col-md-8">
                        <textarea id="desc" class="form-control" name="desc" >{{ old('desc') }}</textarea>
                        @if ($errors->has('desc'))
                            <span class="help-block">
                                <strong>{{ $errors->first('desc') }}</strong>
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
<?php // <link href="http://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.4/summernote.css" rel="stylesheet"> ?>
<link href="{{ asset('assets/css/summernote.css') }}" rel="stylesheet">
<script type="text/javascript" src="{{ asset('assets/js/vendor/summernote.js') }}"></script>
<script>
    $('#desc').summernote({
  height: 300,                 
  minHeight: null,             
  maxHeight: null,             
  focus: true,                  
  toolbar: [
    ['style', ['bold', 'italic', 'underline']],
    ['font', ['strikethrough', 'superscript', 'subscript']],
    ['fontsize', ['fontsize']],
    ['color', ['color']],
    ['picture', ['picture']],
    ['link', ['link']],
    ['height', ['height']],
  ]
});

$('#sort_desc').summernote({
  height: 100,                 
  minHeight: null,             
  maxHeight: null,             
  focus: true,                  
  toolbar: [
    ['style', ['bold', 'italic', 'underline']],
    ['fontsize', ['fontsize']],
    ['color', ['color']],
    ['link', ['link']],
    ['height', ['height']],
  ]
});
  </script>
@endsection