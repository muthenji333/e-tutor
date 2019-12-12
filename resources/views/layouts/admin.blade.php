<!DOCTYPE html>
<html  lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <!-- Required meta tags-->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="tutor system">
    <meta name="author" content="Group assignment">
    <meta name="keywoorrds" content="tutor system">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Title Page-->
    <title>@yield('title') - {{ config('app.name', 'eTutor') }}</title>

    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}"/>

    <!-- Fontfaces CSS-->
    <link href="{{ asset('css/font-face.css') }}" rel="stylesheet" media="all">
    <link href="{{ asset('font-awesome-4.7/css/font-awesome.min.css') }}" rel="stylesheet" media="all">
    <link href="{{ asset('font-awesome-5/css/fontawesome-all.min.css') }}" rel="stylesheet" media="all">
    <link href="{{ asset('mdi-font/css/material-design-iconic-font.min.css') }}" rel="stylesheet" media="all">

    <!-- Bootstrap CSS-->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet" media="all">

    <!-- Vendor CSS-->
    <link href="{{ asset('bootstrap-progressbar/bootstrap-progressbar-3.3.4.min.css') }}" rel="stylesheet" media="all">
    <link href="{{ asset('wow/animate.css') }}" rel="stylesheet" media="all">
    <link href="{{ asset('css-hamburgers/hamburgers.min.css') }}" rel="stylesheet" media="all">
    <link href="{{ asset('slick/slick.css') }}" rel="stylesheet" media="all">
    <link href="{{ asset('select2/select2.min.css') }}" rel="stylesheet" media="all">
    <link href="{{ asset('perfect-scrollbar/perfect-scrollbar.css') }}" rel="stylesheet" media="all">

    <!-- Main CSS-->
    <link href="{{ asset('css/theme.css') }}" rel="stylesheet" media="all">
    @yield('page-css')
</head>

<body>
<div class="page-wrapper" id="content-wrapper">
    <!-- HEADER MOBILE-->
    <header class="header-mobile d-block d-lg-none">
        <div class="header-mobile__bar">
            <div class="container-fluid">
                <div class="header-mobile-inner">
                    <a class="logo" href="{{ route('admin.home') }}">
                        <img src="{{ asset('images/icon/logo.png') }}" alt="CoolAdmin" />
                    </a>
                    <button class="hamburger hamburger--slider" type="button">
                            <span class="hamburger-box">
                                <span class="hamburger-inner"></span>
                            </span>
                    </button>
                </div>
            </div>
        </div>
        <nav class="navbar-mobile">
            <div class="container-fluid">
                <ul class="navbar-mobile__list list-unstyled">
                    <li>
                        <a href="{{ route('admin.home') }}">
                            <i class="fas fa-tachometer-alt"></i>Dashboard</a>
                    </li>
                    <li>
                        <a href="{{ route('admin.users') }}">
                            <i class="fas fa-fw fa-users"></i>
                            Users
                        </a>
                    </li>

                    <li>
                        <a href="{{ route('admin.users.chats') }}">
                            <i class="fas fa-fw fa-comments"></i>
                            Chats
                        </a>
                    </li>

                    <li>
                        <a href="{{ route('admin.users.logs') }}">
                            <i class="fas fa-fw fa-history"></i>
                            User logs
                        </a>
                    </li>
                </ul>
            </div>
        </nav>
    </header>
    <!-- END HEADER MOBILE-->

    <!-- MENU SIDEBAR-->
    <aside class="menu-sidebar d-none d-lg-block">
        <div class="logo">
            <a href="#">
                <img src="{{ asset('images/icon/logo.png') }}" alt="Cool Admin" />
            </a>
        </div>
        <div class="menu-sidebar__content js-scrollbar1">
            <nav class="navbar-sidebar">
                <ul class="list-unstyled navbar__list">
                    <li>
                        <a href="{{ route('admin.home') }}">
                            <i class="fas fa-tachometer-alt"></i>Dashboard</a>
                    </li>
                    <li>
                        <a href="{{ route('admin.users') }}">
                            <i class="fas fa-fw fa-users"></i>
                            Users
                        </a>
                    </li>

                    <li>
                        <a href="{{ route('admin.users.chats') }}">
                            <i class="fas fa-fw fa-comments"></i>
                            Chats
                        </a>
                    </li>

                    <li>
                        <a href="{{ route('admin.users.logs') }}">
                            <i class="fas fa-fw fa-history"></i>
                            User logs
                        </a>
                    </li>
                </ul>
            </nav>
        </div>
    </aside>
    <!-- END MENU SIDEBAR-->

    <!-- PAGE CONTAINER-->
    <div class="page-container">
        <!-- HEADER DESKTOP-->
        <header class="header-desktop">
            <div class="section__content section__content--p30">
                <div class="container-fluid">
                    <div class="header-wrap">
                        <form class="form-header" action="" method="POST">
                            <input class="au-input au-input--xl" type="text" name="search" placeholder="Search for datas &amp; reports..." />
                            <button class="au-btn--submit" type="submit">
                                <i class="zmdi zmdi-search"></i>
                            </button>
                        </form>
                        <div class="header-button">
                            <div class="account-wrap">
                                <div class="account-item clearfix js-item-menu">
                                    <div class="image">
                                        <img src="{{ asset('images/icon/avatar-01.jpg') }}" alt="John Doe" />
                                    </div>
                                    <div class="content">
                                        <a class="js-acc-btn" href="#">{{ \Auth::user()->name }}</a>
                                    </div>
                                    <div class="account-dropdown js-dropdown">
                                        <div class="info clearfix">
                                            <div class="image">
                                                <a href="#">
                                                    <img src="images/icon/avatar-01.jpg" alt="John Doe" />
                                                </a>
                                            </div>
                                            <div class="content">
                                                <h5 class="name">
                                                    <a href="#">{{ \Auth::user()->name }}</a>
                                                </h5>
                                                <span class="email">{{ \Auth::user()->email }}</span>
                                            </div>
                                        </div>
                                        <div class="account-dropdown__body">
                                            <div class="account-dropdown__item">
                                                <a href="#">
                                                    <i class="zmdi zmdi-account"></i>Account</a>
                                            </div>
                                            <div class="account-dropdown__item">
                                                <a href="#">
                                                    <i class="zmdi zmdi-settings"></i>Setting</a>
                                            </div>
                                        </div>
                                        <div class="account-dropdown__footer">
                                            <a href="{{ route('logout') }}" onclick="event.preventDefault();
                                document.getElementById('logout-form').submit();">
                                                <i class="zmdi zmdi-power"></i>Logout</a>
                                        </div>
                                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                            @csrf
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </header>
        <!-- HEADER DESKTOP-->

        <!-- MAIN CONTENT-->
        <div class="main-content">
            <div class="section__content section__content--p30">
                <div class="container-fluid">
                    @yield('page-heading')
                    @yield('page-content')
                </div>
            </div>
        </div>
        <!-- END MAIN CONTENT-->
        <!-- END PAGE CONTAINER-->
    </div>

</div>

<!-- Jquery JS-->
<script src="{{ asset('js/app.js') }}"></script>
<!-- Vendor JS       -->
<script src="{{ asset('slick/slick.min.js') }}"></script>
<script src="{{ asset('wow/wow.min.js') }}"></script>
<script src="{{ asset('bootstrap-progressbar/bootstrap-progressbar.min.js') }}"></script>
<script src="{{ asset('counter-up/jquery.waypoints.min.js') }}"></script>
<script src="{{ asset('counter-up/jquery.counterup.min.js') }}"></script>
<script src="{{ asset('circle-progress/circle-progress.min.js') }}"></script>
<script src="{{ asset('perfect-scrollbar/perfect-scrollbar.js') }}"></script>
<script src="{{ asset('chartjs/Chart.bundle.min.js') }}"></script>
<script src="{{ asset('select2/select2.min.js') }}">
</script>

<!-- Main JS-->
<script src="{{ asset('js/main.js') }}"></script>

</body>

</html>
<!-- end document-->
