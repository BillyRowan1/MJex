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
    <title>Mjex Admin</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap core CSS -->
    <link href="{{ asset('admin/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('admin/css/bootstrap-reset.css') }}" rel="stylesheet">
    <!--external css-->
    <link href="{{ asset('admin/assets/font-awesome/css/font-awesome.css') }}" rel="stylesheet" />
    <!-- Custom styles for this template -->
    <link href="{{ asset('admin/css/style.css') }}" rel="stylesheet">
    <link href="{{ asset('admin/css/style-responsive.css') }}" rel="stylesheet" />
    <script src="{{ asset('admin/js/jquery.js') }}"></script>


    <!-- HTML5 shim and Respond.js IE8 support of HTML5 tooltipss and media queries -->
    <!--[if lt IE 9]>
    <script src="{{ asset('admin/js/html5shiv.js') }}"></script>
    <script src="{{ asset('admin/js/respond.min.js') }}"></script>
    <![endif]-->

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
<section id="container" class="">
    <!--header start-->
    <header class="header">
        <div class="sidebar-toggle-box">
            <div data-original-title="Toggle Navigation" data-placement="right" class="icon-reorder tooltips"></div>
        </div>
        <!--logo start-->
        <a href="{{ url('mjexadmin') }}" class="logo"><img style="height: 22px;" src="{{ asset('img/logo.png') }}" alt=""></a>
        <!--logo end-->
        <div class="top-nav ">
            @if(session()->has('mjexadmin'))
            <ul class="nav pull-right top-menu">
                <!-- user login dropdown start-->
                <li class="dropdown">
                    <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                        <span class="username">Hi, {{ session('mjexadmin')[0] }}</span>
                    </a>
                </li>
                <!-- user login dropdown end -->
            </ul>
            @endif
        </div>
    </header>
    <!--header end-->
    <!--sidebar start-->
    @if(session()->has('mjexadmin'))
    <aside>
        <div id="sidebar" class="nav-collapse ">
            <!-- sidebar menu start-->
            <ul class="sidebar-menu">
                <li class="">
                    <a class="" href="{{ url('mjexadmin') }}">
                        <i class="icon-dashboard"></i>
                        <span>Dashboard</span>
                    </a>
                </li>
                <li class="sub-menu">
                    <a href="{{ url('mjexadmin/ad-network#tabAdPlacements') }}" class="">
                        <i class="icon-book"></i>
                        <span>Ad network</span>
                    </a>
                </li>
                <li>
                    <a class="" href="{{ url('mjexadmin/auth/logout') }}">
                        <i class="icon-key"></i>
                        <span>Logout</span>
                    </a>
                </li>
            </ul>
            <!-- sidebar menu end-->
        </div>
    </aside>
    @endif
    <!--sidebar end-->
    <!--main content start-->
    <section id="main-content">
        <section class="wrapper">
            <!-- page start-->
            @yield('main')
            <!-- page end-->
        </section>
    </section>
    <!--main content end-->
</section>

<script src="{{ asset('admin/js/jquery-1.8.3.min.js') }}"></script>
<script src="{{ asset('admin/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('admin/js/jquery.scrollTo.min.js') }}"></script>
<script src="{{ asset('admin/js/jquery.nicescroll.js') }}"></script>
<script src="{{ asset('admin/js/jquery.customSelect.min.js') }}"></script>
<script src="{{ asset('admin/assets/data-tables/jquery.dataTables.js') }}"></script>
<script src="{{ asset('admin/assets/data-tables/DT_bootstrap.js') }}"></script>

<!--script for this page only-->
<script src="{{ asset('admin/js/dynamic-table.js') }}"></script>
<!--common script for all pages-->
<script src="{{ asset('admin/js/common-scripts.js') }}"></script>

@yield('page-js')
</body>

</html>