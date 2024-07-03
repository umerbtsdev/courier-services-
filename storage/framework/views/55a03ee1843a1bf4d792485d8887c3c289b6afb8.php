<?php $__env->startSection('htmlheader_title'); ?>
    Log in
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
        <title>ICS Xpress Login</title>
        <meta name="description" content="A responsive bootstrap 4 admin dashboard template by hencework" />

        <!-- Favicon -->
        <link rel="shortcut icon" href="favicon.ico">
        <link rel="icon" href="favicon.ico" type="image/x-icon">

        <!-- Toggles CSS -->
        <link href="<?php echo e(asset('vendors/jquery-toggles/css/toggles.css')); ?>" rel="stylesheet" type="text/css">
        <link href="<?php echo e(asset('vendors/jquery-toggles/css/themes/toggles-light.css')); ?>" rel="stylesheet" type="text/css">

        <!-- Custom CSS -->
        <link href="<?php echo e(asset('/css/style.css')); ?>" rel="stylesheet" type="text/css">
    </head>

    <body>
    <!-- Preloader -->
    <div class="preloader-it">
        <div class="loader-pendulums"></div>
    </div>
    <!-- /Preloader -->

    <!-- HK Wrapper -->
    <div class="hk-wrapper">

        <!-- Main Content -->
        <div class="hk-pg-wrapper hk-auth-wrapper">

            <div class="container-fluid">
                <div class="row">
                    <div class="col-xl-12 pa-0">
                        <div class="auth-form-wrap pt-xl-0 pt-70">
                            <div class="auth-form w-xl-30 w-lg-55 w-sm-75 w-100">
                                <a class="auth-brand text-center d-block mb-20" href="#">
                                    <img class="brand-img" src="<?php echo e(asset('/images/icslogo.png')); ?>" alt="brand"/>
                                </a>
                                <?php if(session('info')): ?>
                                    <div class="alert alert-danger" role="alert">
                                        <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
                                        <?php echo e(session('info')); ?>

                                    </div>
                                <?php endif; ?>
                                <?php if(count($errors) > 0): ?>
                                    <div class="alert alert-danger">
                                        <strong>Whoops!</strong> <?php echo e(trans('message.someproblems')); ?>

                                        <ul>
                                            <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <li><?php echo e($error); ?></li>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </ul>
                                    </div>
                                <?php endif; ?>
                                <form action="<?php echo e(url('/login')); ?>" method="post" id="form-submit" class="login100-form validate-form">

                                    <input type="hidden" name="_token" value="<?php echo e(csrf_token()); ?>">
                                    <h1 class="display-4 text-center mb-10">Fleet Managemnt System</h1>
                                    <p class="text-center mb-30">Sign in to your account.</p>
                                    <div class="form-group">
                                        <input class="form-control" placeholder="Email" name="email" id="email" type="email">
                                    </div>
                                    <div class="form-group">
                                        <div class="input-group">
                                            <input class="form-control" placeholder="Password" name="password" id="password" type="password">
                                            <div class="input-group-append">
                                                <span class="input-group-text"><span class="feather-icon"><i data-feather="eye-off"></i></span></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="custom-control custom-checkbox mb-25">
                                        <input class="custom-control-input" id="same-address" type="checkbox" checked>
                                        <label class="custom-control-label font-14" for="same-address">Keep me logged in</label>
                                    </div>
                                    <button class="btn btn-primary btn-block btn-signin" type="submit">Login</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /Main Content -->

    </div>
    <!-- /HK Wrapper -->

    <!-- JavaScript -->

    <!-- jQuery -->
    <script src="<?php echo e(asset('vendors/jquery/dist/jquery.min.js')); ?>"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="<?php echo e(asset('vendors/popper.js/dist/umd/popper.min.js')); ?>"></script>
    <script src="<?php echo e(asset('vendors/bootstrap/dist/js/bootstrap.min.js')); ?>"></script>

    <!-- Slimscroll JavaScript -->
    <script src="<?php echo e('/js/jquery.slimscroll.js'); ?>"></script>

    <!-- Fancy Dropdown JS -->
    <script src="<?php echo e(asset('/js/dropdown-bootstrap-extended.js')); ?>"></script>

    <!-- FeatherIcons JavaScript -->
    <script src="<?php echo e(asset('/js/feather.min.js')); ?>"></script>

    <!-- Init JavaScript -->
    <script src="<?php echo e(asset('/js/init.js')); ?>"></script>
    <script>
        $(function () {
            /*$('input').iCheck({
             checkboxClass: 'icheckbox_square-blue',
             radioClass: 'iradio_square-blue',
             increaseArea: '20%' // optional
             });*/

            jQuery('.btn-signin').click(function()
            {
                jQuery('#form-submit').submit();
            });

            jQuery('#form-submit input').keypress(function(e)
            {
                if(e.which == 13){//Enter key pressed
                    jQuery('.btn-signin').addClass('active');
                    jQuery('#form-submit').submit();
                }
            });
        });
    </script>
    </body>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.auth', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>