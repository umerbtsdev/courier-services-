<head>
    <meta charset="UTF-8">
    <title> Fleet Management </title>
    
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <!-- CSRF Token -->
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">

    <link href="<?php echo e(url('css/all.css')); ?>" rel="stylesheet" type="text/css" />
    <link href="<?php echo e(url('css/custom.css')); ?>" rel="stylesheet" type="text/css" />

    <link rel="shortcut icon" href="<?php echo e(url('img/favicon.png')); ?>">
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="<?php echo e(url('js/html5shiv.min.js')); ?>"></script>
    <script src="<?php echo e(url('js/respond.min.js')); ?>"></script>
    <![endif]-->


    <!-- font loading  -->
    <!-- font loadning -->

    <script>
        window.Laravel = <?php echo json_encode([
            'csrfToken' => csrf_token(),
        ]); ?>;
    </script>
</head>