@extends('layouts.main')

@section('header')
    @include('layouts.header')
@endsection

@section('content')
<section class="panel">
    <div class="panel-body">
            <div class="row">
                 <div class="col-md-12">
                     <div class="row hidden-md hidden-lg"><h1 class="text-center" >{{$news->title}}</h1></div>

                     <div class="pull-left col-md-4 col-xs-12 thumb-contenido"><img class="center-block img-responsive" src='{{$news->image_url}}' style="max-height: 400px;"/></div>
                     <div class="">
                         <h1  class="hidden-xs hidden-sm">{{$news->title}}</h1>
                         <small>{{date('d F Y H:i', strtotime($news->created_at))}}</small><br>
                         <hr>
                         <?php echo $news->sort_desc; ?>
                         <hr>
                         <p class="text-justify"><?php echo $news->desc; ?></div>
                 </div>
            </div>
    </div>
</section>
@endsection

@section('scripts')
<style type="text/css">
    .thumb-contenido{margin-bottom:1%;margin-left: 0px;padding-left: 0px;}
</style>
@endsection
