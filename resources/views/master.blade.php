<!doctype html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang=""> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8" lang=""> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9" lang=""> <![endif]-->
<!--[if gt IE 8]><!-->
<html class="no-js" lang="">
<!--<![endif]-->

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <title>Mjex</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/bootstrap-theme.min.css') }}">
    <link rel="stylesheet" href="{{ asset('fonts/fonts.css') }}">
    <link rel="stylesheet" href="{{ asset('libs/trumbo/ui/trumbowyg.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/main.css') }}">
    <link rel="stylesheet" href="{{ asset('css/main-responsive.css') }}">
    <script src="{{ asset('js/vendor/modernizr-2.8.3-respond-1.4.2.min.js') }}"></script>
    <script src="{{ asset('libs/jquery.min.js') }}"></script>

    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.10.0/css/bootstrap-select.min.css">

    <!-- Latest compiled and minified JavaScript -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.10.0/js/bootstrap-select.min.js"></script>

    <script>
        jQuery(document).ready(function($) {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name=csrf-token]').attr('content')
                }
            });
        }); 
    </script>
</head>

<body id="mjex">
<div id="loading">
    <img src="{{ asset('img/ajax-loader.gif') }}" alt="loading">
</div>
<header>
    <nav id="top-nav">
        <a class="navbar-brand" href="{{ url('/') }}"><img id="logo" src="{{ asset('img/logo.png') }}" alt="logo"></a>
        @if(!auth()->user())
        <div>
            <a href="{{ url('register') }}" class="btn green-gradient sign-up-btn">SIGN UP</a>
            <form class="navbar-form navbar-right" method="post" action="{{ url('login') }}" role="form">
                {!! csrf_field() !!}
                <input type="hidden" name="_topbar_login" value="1">
                <script>
                    @if (count($errors) > 0 && old('_topbar_login') == '1')
                        @foreach ($errors->all() as $error)
                            alert('{{ $error . '\n' }}');
                        @endforeach
                    @endif
                </script>
                <div class="form-group">
                    <input type="text" placeholder="Email" name="email" class="form-control">
                </div>
                <div class="form-group">
                    <input type="password" placeholder="Password" name="password" class="form-control">
                </div>
                <button type="submit" class="btn btn-default">LOG IN</button>
            </form>
        </div>
        @else
            <div class="dropdown">
                <p data-toggle="dropdown" aria-haspopup="true" aria-expanded="true" class="welcome">Hi, {{ auth()->user()->community_name }} <span class="glyphicon glyphicon-chevron-down"></span></p>
                
                <ul class="dropdown-menu pull-right">
                    @if(auth()->user()->package != 'none')
                    <li><a href="#">Current package: {{ str_replace('_',' ', strtoupper(auth()->user()->package)) }}</a></li>

                    @if(auth()->user()->package != 'weekly_pro')
                    <li><a href="{{ url('account/upgrade') }}"><span class="glyphicon glyphicon-fire"></span> UPGRADE NOW</a></li>
                    @endif

                    <li role="separator" class="divider"></li>
                    @endif
                    <li><a href="{{ url('logout') }}"><span class="glyphicon glyphicon-off"></span> Logout</a></li>
                </ul>
            </div>
        @endif
    </nav>
    @include('inc.menu')
</header>
<!-- end /header -->

@yield('main')

<footer>
    <div class="container">
        <div class="row">
            @include('inc.footer_menu')
        </div>
    </div>
</footer>



<script>
    window.jQuery || document.write('<script src="libs/jquery.min.js"><\/script>')
</script>
<script src="http://maps.google.com/maps/api/js?libraries=places"></script>
<script src="{{ asset('libs/gmaps.min.js') }}"></script>
<script src="{{ asset('js/vendor/bootstrap.min.js') }}"></script>
<script src="{{ asset('libs/jquery.nicescroll/jquery.nicescroll.min.js') }}"></script>
<script src="{{ asset('libs/trumbo/trumbowyg.min.js') }}"></script>

<script src="{{ asset('js/main.js') }}"></script>
<script src="{{ asset('js/home.js') }}"></script>
<script src="{{ asset('js/search.js') }}"></script>

@yield('page-js')
</body>

</html>