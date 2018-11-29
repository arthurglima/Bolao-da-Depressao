<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Sis Bolão</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css">
    <!-- Icons-->
    <link href="icons/css/coreui-icons.min.css" rel="stylesheet">
    <link href="vendor/flag-icon-css/css/flag-icon.min.css" rel="stylesheet">
    <link href="vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <link href="vendor/simple-line-icons/css/simple-line-icons.css" rel="stylesheet">
    <!-- Main styles for this application-->
    <link href="css/coreuistyle.min.css" rel="stylesheet">
    <link href="vendor/pace-progress/css/pace.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.8.0/css/bootstrap-datepicker.min.css"
          rel="stylesheet">
    <!-- Global site tag (gtag.js) - Google Analytics-->
    <script async="" src="https://www.googletagmanager.com/gtag/js?id=UA-118965717-3"></script>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body class="app header-fixed sidebar-fixed aside-menu-fixed sidebar-lg-show">
@guest

@else
    <header class="app-header navbar">
        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
            @csrf
        </form>
        <button class="navbar-toggler sidebar-toggler d-lg-none mr-auto" type="button" data-toggle="sidebar-show">
            <span class="navbar-toggler-icon"></span>
        </button>
        <a class="navbar-brand" href="/">
            Sis Bolão
            {{--<img class="navbar-brand-full" src="img/brand/logo.svg" width="89" height="25" alt="CoreUI Logo">--}}
            {{--<img class="navbar-brand-minimized" src="img/brand/sygnet.svg" width="30" height="30" alt="CoreUI Logo">--}}
        </a>
        <ul class="nav navbar-nav ml-auto">
            <li class="nav-item dropdown">
                <a class="nav-link" data-toggle="dropdown" href="#" role="button" aria-haspopup="true"
                   aria-expanded="false">

                    {{ Auth::user()->name }}
                    <img class="img-avatar" src="http://cdn.onlinewebfonts.com/svg/img_181369.png"
                         alt="admin@bootstrapmaster.com">
                </a>
                <div class="dropdown-menu dropdown-menu-right">
                    <div class="dropdown-header text-center">
                        <strong>Conta</strong>
                    </div>
                    <a class="dropdown-item" href="#">
                        <i class="fa fa-bell-o"></i> Updates
                        <span class="badge badge-info">42</span>
                    </a>
                    <a class="dropdown-item" href="#">
                        <i class="fa fa-envelope-o"></i> Messages
                        <span class="badge badge-success">42</span>
                    </a>
                    <div class="dropdown-header text-center">
                        <strong>Configurações</strong>
                    </div>
                    <a class="dropdown-item" href="#">
                        <i class="fa fa-user"></i> Profile</a>
                    <a class="dropdown-item" href="#">
                        <i class="fa fa-file"></i> Projects
                        <span class="badge badge-primary">42</span>
                    </a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item btn" href="{{ route('logout') }}"
                       onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <i class="fa fa-lock"></i> Logout</a>
                </div>
            </li>
        </ul>

        <a class="btn" href="{{ route('logout') }}"
           onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
            <i class="fa fa-lock"></i> Logout</a>
    </header>
    <div class="app-body" style="position: absolute;">
        <div class="sidebar">
            <nav class="sidebar-nav">
                <ul class="nav">
                    <li class="nav-title">Geral</li>
                    <li class="nav-item">
                        <a class="nav-link" href="/home">
                            <i class="nav-icon icon-speedometer"></i> Mural
                            <span class="badge badge-primary">NEW</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/boloes">
                            <i class="nav-icon icon-diamond"></i>Meus Bolões</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/campeonato">
                            <i class="nav-icon icon-layers"></i>Campeonatos</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/times">
                            <i class="nav-icon icon-people"></i>Times</a>
                    </li>
                </ul>
            </nav>
        </div>
    </div>
@endguest
@include('layouts.scripts')
<main class="main" style="margin-top: 55px">
    @if(@session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>{{@session('success')}}</strong>
            <button class="close" type="button" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">×</span>
            </button>
        </div>
    @endif
    @if(@session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>{{@session('error')}}</strong>
            <button class="close" type="button" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">×</span>
            </button>
        </div>
    @endif
    @if(@session('warning'))
        <div class="alert alert-warning alert-dismissible fade show" role="alert">
            <strong>{{@session('warning')}}</strong>
            <button class="close" type="button" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">×</span>
            </button>
        </div>
    @endif
    @yield('content')
</main>

</body>
</html>
