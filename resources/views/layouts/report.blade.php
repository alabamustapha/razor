<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Residassur.fr</title>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <!-- <link href="{{ asset('css/datatables.min.css') }}" rel="stylesheet"> -->
    <!-- <link href="{{ asset('css/datatables.bootstrap.min.css') }}" rel="stylesheet"> -->
    <!-- <link href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css" rel="stylesheet"> -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.10.16/css/dataTables.bootstrap.min.css" rel="stylesheet">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    <link href="{{ asset('css/font-awesome.css') }}" rel="stylesheet">

    @yield('styles')
</head>

<body>
<div id="app">
    <nav class="navbar navbar-default navbar-static-top">
        <div class="container">
            <div class="navbar-header">

                <!-- Collapsed Hamburger -->
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse">
                    <span class="sr-only">Toggle Navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>

                <!-- Branding Image -->
                <a class="navbar-brand" href="{{ url('/home') }}" style="display: inline-table;">
                    <img style="height: 80px;" src="{{ asset('../images/LogoResidassur.jpg')}}" alt="Groupe corim assurance">
                </a>
            </div>

            <div class="collapse navbar-collapse" id="app-navbar-collapse">
                <!-- Left Side Of Navbar -->
                <ul class="nav navbar-nav">
                    &nbsp;
                </ul>

                <!-- Right Side Of Navbar -->
                <ul class="nav navbar-nav navbar-right">
                    <!-- Authentication Links -->
                    @if (Auth::guest())
                        <li><a href="{{ route('login') }}">Login</a></li>
                        <li><a href="{{ route('register') }}">Register</a></li>
                    @else
                        <li><img style="height: 80px;" src="{{ asset('../images/logo.png')}}" alt="Groupe corim assurance"></li>
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                {{ Auth::user()->aff_fname }} {{ Auth::user()->aff_lname }} <span class="caret"></span>
                            </a>

                            <ul class="dropdown-menu" role="menu">
                                <li><a href="{{ url('home') }}">Revenir au tarificateur</a></li>
                                @if(Auth::check() && Auth::user()->isAdmin)
                                    <li><a href="{{ url('admin') }}">Admin</a></li>
                                @endif
                                <li role="separator" class="divider"></li>
                                <li>
                                    <a href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        Déconnexion
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        {{ csrf_field() }}
                                    </form>
                                </li>
                            </ul>
                        </li>
                    @endif
                </ul>
            </div>
        </div>
    </nav>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading"><h3><center>Bienvenue sur le portail d'administration.</center></h3></div>
                </div>
                <div class="btn-group btn-group-justified hidden-xs" role="group" aria-label="...">
                    <div class="btn-group" role="group">
                        <a href="{{ url('/indicedebase') }}" class="btn btn-default">Accueil</a>
                    </div>
                    <div class="btn-group" role="group">
                        <a href="{{ url('/user') }}" class="btn btn-default">Gérer affiliés</a>
                    </div>
                    <div class="btn-group" role="group">
                        <a href="{{ url('tarificateurbatiment/index') }}" class="btn btn-default">Gèrer devis et contrats</a>
                    </div>
                    <div class="btn-group" role="group">
                        <a href="{{ route('show_activia_report') }}" class="btn btn-default">Extraction des activia contrats</a>
                    </div>
                    <div class="btn-group" role="group">
                        <a href="{{ route('show_report') }}" class="btn btn-default">Extraction des contrats</a>
                    </div>
                </div>

                <div class="btn-group btn-group-vertical visible-xs" role="group" aria-label="...">
                    <div class="btn-group" role="group">
                        <a href="{{ url('/indicedebase') }}" class="btn btn-default">Accueil</a>
                    </div>
                    <div class="btn-group" role="group">
                        <a href="{{ url('/user') }}" class="btn btn-default">Gérer affiliés</a>
                    </div>
                    <div class="btn-group" role="group">
                        <a href="{{ url('tarificateurbatiment/index') }}" class="btn btn-default">Gèrer devis et contrats</a>
                    </div>
                    <div class="btn-group" role="group">
                        <a href="#" class="btn btn-default">Extraction des contrats</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
                <div class="col-md-12">
                    <div class="btn-group btn-group-justified" role="group" aria-label="...">
                        <div class="btn-group" role="group">
                            <a href="{{ url('#') }}" class="btn btn-default">CMAM</a>
                        </div>
                        <div class="btn-group" role="group">
                            <a href="{{ url('#') }}" class="btn btn-default">Groupama</a>
                        </div>
                    </div>
                </div>
        </div>

    </div>
    <br>
    @yield('content')
</div>

<!-- Scripts -->
<script src="{{ asset('js/app.js') }}"></script>
<script src="{{ asset('js/datatables.min.js') }}"></script>

@yield('scripts')
</body>
</html>
