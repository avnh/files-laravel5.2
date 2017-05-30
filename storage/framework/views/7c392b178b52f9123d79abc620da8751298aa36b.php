<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Files</title>

    <!-- Fonts -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css" integrity="sha384-XdYbMnZ/QjLh6iI4ogqCTaIjrFk87ip+ekIjefZch0Y+PvJ8CDYtEs1ipDmPorQ+" crossorigin="anonymous">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Lato:100,300,400,700">

    <!-- Styles -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
    <?php /* <link href="<?php echo e(elixir('css/app.css')); ?>" rel="stylesheet"> */ ?>

     <!-- jQuery -->
    <script src="<?php echo e(asset('assets/js/jquery-1.11.3.min.js')); ?>"></script>
    <!-- Bootstrap Core JavaScript -->
    <script src="<?php echo e(asset('assets/js/jquery.frontbox-1.1.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/js/tables.min.js')); ?>"></script>
   
    <!-- JavaScripts -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>

    <style>
        body {
            font-family: 'Lato';
        }

        .fa-btn {
            margin-right: 6px;
        }
    </style>
</head>
<body id="app-layout">
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
                <a class="navbar-brand" href="<?php echo e(url('/')); ?>">
                    Files
                </a>
            </div>

            <div class="collapse navbar-collapse" id="app-navbar-collapse">
                <!-- Left Side Of Navbar -->
                <ul class="nav navbar-nav">
                    <?php if(Auth::check()): ?>
                        <li><a href="<?php echo e(url('user/'.Auth::user()->username.'/home')); ?>">Home</a></li>
                        <li><a href="<?php echo e(url('user/'.Auth::user()->username.'/dashboard')); ?>">Dashboard</a></li>
                        <li><a href="<?php echo e(url('user/'.Auth::user()->username.'/upload')); ?>">Upload</a></li>
                    <?php endif; ?>
                </ul>

                <!-- Right Side Of Navbar -->
                <ul class="nav navbar-nav navbar-right">
                    <!-- Authentication Links -->
                    <?php if(Auth::guest()): ?>
                        <li><a href="<?php echo e(url('/login')); ?>">Login</a></li>
                        <li><a href="<?php echo e(url('/register')); ?>">Register</a></li>
                    <?php else: ?>
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                <?php echo e(Auth::user()->username); ?> <span class="caret"></span>
                            </a>

                            <ul class="dropdown-menu" role="menu">
                                <?php if(Auth::user()->level == '1'): ?>
                                    <li><a href="<?php echo e(url('admin/dashboard')); ?>"><i class="fa fa-fw fa-tasks"></i>Admin panel</a></li>
                                <?php endif; ?>
                                <li><a href="<?php echo e(url('user/'.Auth::user()->username.'/setting')); ?>"><i class="fa fa-fw fa-gear"></i>Setting</a></li>
                                <li><a href="<?php echo e(url('/logout')); ?>"><i class="fa fa-btn fa-sign-out"></i>Logout</a></li>
                            </ul>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>

    <?php echo $__env->yieldContent('content'); ?>
    <?php if( isset($data) ): ?>
        <?php if($data['nav'] === 'home' ): ?>
            <?php echo $__env->yieldContent('home'); ?>
        <?php endif; ?>
        <?php if($data['nav'] === 'dashboard' ): ?>
            <?php echo $__env->yieldContent('user.dashboard'); ?>
        <?php endif; ?>
        <?php if($data['nav'] === 'file' ): ?>
            <?php echo $__env->yieldContent('user.file'); ?>
        <?php endif; ?>
        <?php if($data['nav'] === 'upload' ): ?>
            <?php echo $__env->yieldContent('user.upload'); ?>
        <?php endif; ?>
        <?php if($data['nav'] === 'pages' ): ?>
            <?php echo $__env->yieldContent('pages'); ?>
        <?php endif; ?>
        <?php if($data['nav'] === 'setting' ): ?>
            <?php echo $__env->yieldContent('user.setting'); ?>
        <?php endif; ?>
    <?php endif; ?>

 
    <?php /* <script src="<?php echo e(elixir('js/app.js')); ?>"></script> */ ?>
</body>
</html>
