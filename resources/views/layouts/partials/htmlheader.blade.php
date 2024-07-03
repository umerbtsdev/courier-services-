<head>
    <meta charset="UTF-8">
    <title> Fleet Management </title>
    {{--@yield('htmlheader_title', '')--}}
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link href="{{ url('css/all.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ url('css/custom.css') }}" rel="stylesheet" type="text/css" />

    <link rel="shortcut icon" href="{{url('img/favicon.png')}}">
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="{{ url('js/html5shiv.min.js') }}"></script>
    <script src="{{ url('js/respond.min.js') }}"></script>
    <![endif]-->


    <!-- font loading  -->
    <!-- font loadning -->

    <script>
        window.Laravel = {!! json_encode([
            'csrfToken' => csrf_token(),
        ]) !!};
    </script>
</head>