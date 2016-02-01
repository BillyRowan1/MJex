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
    <title></title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('fonts/fonts.css') }}">
    <link rel="stylesheet" href="{{ asset('css/bootstrap-theme.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/main.css') }}">
    <link rel="stylesheet" href="{{ asset('css/main-responsive.css') }}">
    <script src="{{ asset('js/vendor/modernizr-2.8.3-respond-1.4.2.min.js') }}"></script>
</head>

<body id="mjex">
<header>
    <nav id="top-nav">
        <a class="navbar-brand" href="{{ url('/') }}"><img id="logo" src="img/logo.png" alt="logo"></a>
        <div>
            <a href="{{ url('register') }}" class="btn green-gradient sign-up-btn">SIGN UP</a>
            <form class="navbar-form navbar-right" role="form">
                <div class="form-group">
                    <input type="text" placeholder="Email" class="form-control">
                </div>
                <div class="form-group">
                    <input type="password" placeholder="Password" class="form-control">
                </div>
                <button type="submit" class="btn btn-default">LOG IN</button>
            </form>
        </div>
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

<!-- popups -->
<section id="legal-page">
    <div class="content fluid-center">
        <h2 class="title">Age Restricted Content</h2>
        <p>Marijuana Exchange does business in accordance
            with state laws regarding access to cannabis.
            <br>
            You must be at least 21 years old, or a
            valid medical marijuana patient.
            <br>
            Are you eligible to visit
            Marijuana Exchange?</p>
        <div class="btn-group">
            <div class="btn bg-cover no">no</div>
            <div class="btn bg-cover yes">yes</div>
        </div>
    </div>
</section>

<script src="{{ asset('libs/jquery.min.js') }}"></script>
<script>
    window.jQuery || document.write('<script src="js/vendor/jquery-1.11.2.min.js"><\/script>')
</script>
<script src="{{ asset('js/vendor/bootstrap.min.js') }}"></script>
<script src="{{ asset('libs/jquery.nicescroll/jquery.nicescroll.min.js') }}"></script>
<script src="{{ asset('js/main.js') }}"></script>
</body>

</html>