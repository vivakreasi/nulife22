<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
    <meta name="author" content="adsnet global persada, pt" />
    <meta name="keyword" content="nulife, plan-c" />
    <meta name="description" content="" />
    <link rel="shortcut icon" href="{{ asset('assets/img/favicon.ico') }}" />

    <title>nulife.co.id - Login</title>

    <!--vendors-->
    <link href="{{ asset('assets/css/vendor/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/vendor/bootstrap-reset.min.css') }}" rel="stylesheet">

    <!--nulife-->
    <link href="{{ asset('assets/css/style.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/style-responsive.min.css') }}" rel="stylesheet">

    <style>
        html, body {
            background: url('{{ asset('assets/img/home_bg.jpg') }}') no-repeat center center fixed;
            -webkit-background-size: cover;
            -moz-background-size: cover;
            -o-background-size: cover;
            background-size: cover;
            background-color: #fff;
            color: #fff;
            font-family: 'Raleway', sans-serif;
            font-weight: 100;
            height: 100vh;
            margin: 0;
        }
    </style>
    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html5shiv/3.7.3/html5shiv.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>

<body class="login-body">

<div class="login-logo">
    <a href="{{ url('/') }}">
        <img src="{{ asset('assets/img/login_logobiru.png') }}" alt=""/>
    </a>
</div>

<h2 class="form-heading">nulife login</h2>
<div class="container log-row">
    <form class="form-signin" method="post" action="{{ route('login') }}">
        {{ csrf_field() }}
        @if ($errors->has('userid') || $errors->has('password'))
        <span class="help-block alert alert-danger">
        <strong>User ID / Password do not match.</strong>
        </span>
        @endif
        @if ( Session::has('message') )
            <span class="help-block alert alert-{{ Session::get('messageclass') }}">
                <strong>{{  Session::get('message')    }}</strong>
            </span>
        @endif
        <div class="login-wrap">
            <input type="text" class="form-control" placeholder="User ID" id="userid" name="userid" autofocus>
            <input type="password" class="form-control" placeholder="Password" id="password" name="password">
            <button class="btn btn-lg btn-info btn-block" type="submit">LOGIN</button>
            &nbsp;
            <div class="registration">
                Have you 
                <a class="" href="/forgot/password">
                    Lost Password?
                </a>
            </div>

        </div>
    </form>
</div>

</body>
</html>