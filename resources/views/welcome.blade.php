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
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    <link href="{{ asset('css/font-awesome.css') }}" rel="stylesheet">
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
                <a class="navbar-brand" href="{{ url('/home') }}">
                    <img src="{{ asset('images/logo_transparent.png')}}" alt="Groupe corim assurance" class="img-responsive">
                </a>
            </div>

            <div class="collapse navbar-collapse" id="app-navbar-collapse">

                <!-- Right Side Of Navbar -->
                <ul class="nav navbar-nav navbar-right">
                    <!-- Authentication Links -->
                    @if (Auth::guest())
                        <li><a href="{{ route('login') }}">Login</a></li>
                        <li><a href="{{ route('register') }}">Register</a></li>
                    @else
                        <!-- <li><img style="height: 80px;" src="{{ asset('images/logo_transparent.png') }}" alt="Groupe corim assurance"></li> -->

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

    <div class="container-fluid">
        <div class="row">
            <div class="col-md-8 col-md-offset-2 col-sm-12 text-center">
                <div>
                    <img src="{{ asset('images/logo_transparent.png') }}" class="img-responsive" alt="Groupe corim assurance" style="display: inline-block;">
                </div>
                <div class="flex-center">
                    <h3>Bienvenue sur l'espace professionnel</h3>
                </div>
                <div>
                    <p style="color: #4a8039;"><strong>BESOIN DE RENSEIGNEMENTS
                            NOUS SOMMES A VOTRE DISPOSITION AU 0806 079 879</strong></p>
                </div>
            </div>
        </div>
    </div>

    

</div>

<!-- Scripts -->
<script src="{{ asset('js/app.js') }}"></script>
</body>
</html>
