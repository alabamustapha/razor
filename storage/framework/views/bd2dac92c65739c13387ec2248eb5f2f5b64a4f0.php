<!DOCTYPE html>
<html lang="<?php echo e(app()->getLocale()); ?>">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">

    <title>Residassur.fr</title>

    <!-- Styles -->
    <link href="<?php echo e(asset('css/app.css')); ?>" rel="stylesheet">
    <!-- <link href="<?php echo e(asset('css/datatables.min.css')); ?>" rel="stylesheet"> -->
    <!-- <link href="<?php echo e(asset('css/datatables.bootstrap.min.css')); ?>" rel="stylesheet"> -->
    <!-- <link href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css" rel="stylesheet"> -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.10.16/css/dataTables.bootstrap.min.css" rel="stylesheet">
    <link href="<?php echo e(asset('css/style.css')); ?>" rel="stylesheet">
    <link href="<?php echo e(asset('css/font-awesome.css')); ?>" rel="stylesheet">

    <?php echo $__env->yieldContent('styles'); ?>
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
                <a class="navbar-brand" href="<?php echo e(url('/home')); ?>">
                    <img style="height: 80px;" src="<?php echo e(asset('../images/LogoResidassur.jpg')); ?>" alt="Groupe corim assurance">
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
                    <?php if(Auth::guest()): ?>
                        <li><a href="<?php echo e(route('login')); ?>">Login</a></li>
                        <li><a href="<?php echo e(route('register')); ?>">Register</a></li>
                    <?php else: ?>
                        <li><img style="height: 80px;" src="<?php echo e(asset('../images/logo.png')); ?>" alt="Groupe corim assurance"></li>
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                <?php echo e(Auth::user()->aff_fname); ?> <?php echo e(Auth::user()->aff_lname); ?> <span class="caret"></span>
                            </a>

                            <ul class="dropdown-menu" role="menu">
                                <li><a href="<?php echo e(url('home')); ?>">Revenir au tarificateur</a></li>
                                <?php if(Auth::check() && Auth::user()->isAdmin): ?>
                                    <li><a href="<?php echo e(url('admin')); ?>">Admin</a></li>
                                <?php endif; ?>
                                <li role="separator" class="divider"></li>
                                <li>
                                    <a href="<?php echo e(route('logout')); ?>"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        Déconnexion
                                    </a>

                                    <form id="logout-form" action="<?php echo e(route('logout')); ?>" method="POST" style="display: none;">
                                        <?php echo e(csrf_field()); ?>

                                    </form>
                                </li>
                            </ul>
                        </li>
                    <?php endif; ?>
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
                <div class="btn-group btn-group-justified" role="group" aria-label="...">
                    <div class="btn-group" role="group">
                        <a href="<?php echo e(url('/indicedebase')); ?>" class="btn btn-default">Accueil</a>
                    </div>
                    <div class="btn-group" role="group">
                        <a href="<?php echo e(url('/user')); ?>" class="btn btn-default">Gérer affiliés</a>
                    </div>
                    <div class="btn-group" role="group">
                        <a href="<?php echo e(url('tarificateurbatiment/index')); ?>" class="btn btn-default">Gèrer devis et contrats</a>
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
                            <a href="<?php echo e(url('#')); ?>" class="btn btn-default">CMAM</a>
                        </div>
                        <div class="btn-group" role="group">
                            <a href="<?php echo e(url('#')); ?>" class="btn btn-default">Groupama</a>
                        </div>
                    </div>
                </div>
        </div>

    </div>
    <br>
    <?php echo $__env->yieldContent('content'); ?>
</div>

<!-- Scripts -->
<script src="<?php echo e(asset('js/app.js')); ?>"></script>
<script src="<?php echo e(asset('js/datatables.min.js')); ?>"></script>

<?php echo $__env->yieldContent('scripts'); ?>;
</body>
</html>
