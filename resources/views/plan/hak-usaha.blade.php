@extends('layouts.main')
@section('header')
    @include('layouts.header')
@endsection
@section('content')
        <section class="panel">
            <!-- item -->
                <div class="col-md-3 text-center">
                    <div class="panel panel-danger panel-pricing">
                        <div class="panel-heading">
                            <i class="fa fa-code-fork"></i>
                            <h3>Silver</h3>
                        </div>
                        <div class="panel-body text-center">
                            <p><strong>Rp {{number_format(1 * $hargaDasar, 0, ',', '.')}},-</strong></p>
                        </div>
                        <ul class="list-group text-center">
                            <li class="list-group-item"><i class="fa fa-check"></i> 1 Hak Usaha</li>
                            <li class="list-group-item"><i class="fa fa-check"></i> 24/7 support</li>
                        </ul>
                        <div class="panel-footer">
                            <form class="form-horizontal" role="form" method="POST" action="{{ route('hakusaha.post', ['type' => 1]) }}">
                                {{ csrf_field() }}
                                <button class="btn btn-lg btn-block btn-primary" type="submit">ORDER NOW!</button>
                            </form>
                        </div>
                    </div>
                </div>
                <!-- /item -->

                <!-- item -->
                <div class="col-md-3 text-center">
                    <div class="panel panel-warning panel-pricing">
                        <div class="panel-heading">
                            <i class="fa fa-code-fork"></i>
                            <h3>Gold</h3>
                        </div>
                        <div class="panel-body text-center">
                            <p><strong>Rp {{number_format(3 * $hargaDasar, 0, ',', '.')}},-</strong></p>
                        </div>
                        <ul class="list-group text-center">
                            <li class="list-group-item"><i class="fa fa-check"></i> 3 Hak Usaha</li>
                            <li class="list-group-item"><i class="fa fa-check"></i> 24/7 support</li>
                        </ul>
                        <div class="panel-footer">
                            <form class="form-horizontal" role="form" method="POST" action="{{ route('hakusaha.post', ['type' => 2]) }}">
                                {{ csrf_field() }}
                                <button class="btn btn-lg btn-block btn-primary" type="submit">ORDER NOW!</button>
                            </form>
                        </div>
                    </div>
                </div>
                <!-- /item -->

                <!-- item -->
                <div class="col-md-3 text-center">
                    <div class="panel panel-success panel-pricing">
                        <div class="panel-heading">
                            <i class="fa fa-code-fork"></i>
                            <h3>Platinum</h3>
                        </div>
                        <div class="panel-body text-center">
                            <p><strong>Rp {{number_format(7 * $hargaDasar, 0, ',', '.')}},-</strong></p>
                        </div>
                        <ul class="list-group text-center">
                            <li class="list-group-item"><i class="fa fa-check"></i> 7 Hak Usaha</li>
                            <li class="list-group-item"><i class="fa fa-check"></i> 24/7 support</li>
                        </ul>
                        <div class="panel-footer">
                            <form class="form-horizontal" role="form" method="POST" action="{{ route('hakusaha.post', ['type' => 3]) }}">
                                {{ csrf_field() }}
                                <button class="btn btn-lg btn-block btn-primary" type="submit">ORDER NOW!</button>
                            </form>
                        </div>
                    </div>
                </div>
                <!-- /item -->
                
                <div class="col-md-3 text-center">
                    <div class="panel panel-success panel-pricing">
                        <div class="panel-heading">
                            <i class="fa fa-code-fork"></i>
                            <h3>Titanium</h3>
                        </div>
                        <div class="panel-body text-center">
                            <p><strong>Rp {{number_format(15 * $hargaDasar, 0, ',', '.')}},-</strong></p>
                        </div>
                        <ul class="list-group text-center">
                            <li class="list-group-item"><i class="fa fa-check"></i> 15 Hak Usaha</li>
                            <li class="list-group-item"><i class="fa fa-check"></i> 24/7 support</li>
                        </ul>
                        <div class="panel-footer">
                            <form class="form-horizontal" role="form" method="POST" action="{{ route('hakusaha.post', ['type' => 4]) }}">
                                {{ csrf_field() }}
                                <button class="btn btn-lg btn-block btn-primary" type="submit">ORDER NOW!</button>
                            </form>
                        </div>
                    </div>
                </div>
        </section>
@endsection