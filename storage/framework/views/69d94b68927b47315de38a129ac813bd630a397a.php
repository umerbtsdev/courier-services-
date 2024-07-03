<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <title>Falcon Courier and Logistics</title>
    <meta content="njbcreation a software company" name="description" />
    <meta content="shoaibbadla" name="author" />
    <link rel="shortcut icon" href="assets/images/favicon.ico">

    <link href="<?php echo e(asset('/css/bootstrap.min.css')); ?>" rel="stylesheet" type="text/css">
    <link href="<?php echo e(asset('/css/metismenu.min.css')); ?>" rel="stylesheet" type="text/css">
    <link href="<?php echo e(asset('/css/icons.css')); ?>" rel="stylesheet" type="text/css">
    <link href="<?php echo e(asset('/css/style.css')); ?>" rel="stylesheet" type="text/css">

</head>
<body>
<!-- Begin page -->
<div class="accountbg"></div>
<div class="home-btn d-none d-sm-block">

</div>

<?php echo $__env->yieldContent('content'); ?>

<!-- jQuery  -->
<script src="<?php echo e(asset('/js/jquery.min.js')); ?>"></script>
<script src="<?php echo e(asset('/js/bootstrap.bundle.min.js')); ?>"></script>
<script src="<?php echo e(asset('/js/metismenu.min.js')); ?>"></script>
<script src="<?php echo e(asset('/js/jquery.slimscroll.js')); ?>"></script>
<script src="<?php echo e(asset('/js/waves.min.js')); ?>"></script>

<!-- App js -->
<script src="<?php echo e(asset('/js/app.js')); ?>"></script>
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
</html>