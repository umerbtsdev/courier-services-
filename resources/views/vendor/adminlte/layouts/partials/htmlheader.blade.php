<head>
    <meta charset="UTF-8">
    <title> Transportation @yield('htmlheader_title', '') </title>
    <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

     <!-- google material icon -->

  <!-- font loading  -->
  <!-- font loadning -->

  <!-- Bootstrap 3.3.6 -->
  <link rel="stylesheet" href="{{ asset("bower_components/AdminLTE/bootstrap/css/bootstrap.min.css")}}">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{url('css/font-awesome.min.css')}}">
  <!-- Ionicons -->
  <link rel="stylesheet" href="{{url('css/ionicons.min.css')}}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{ asset("bower_components/AdminLTE/dist/css/AdminLTE.min.css")}}">
  <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
  <link rel="stylesheet" href="{{ asset("bower_components/AdminLTE/dist/css/skins/_all-skins.min.css")}}">

  
  <link href="{{url('css/ui.jqgrid-bootstrap.css')}}" rel="stylesheet">
  <link href="{{url('css/ui.jqgrid-bootstrap-ui.css')}}" rel="stylesheet">
  <link href="{{url('css/ui.jqgrid.css')}}" rel="stylesheet">
     <link href="{{url('css/jquery-ui-1.10.3.custom.css')}}" rel="stylesheet">
    <link href="{{url('css/jquery.ui.autocomplete.css')}}" rel="stylesheet">
    <link href="{{url('jquery-ui-1.12.1.custom/jquery-ui.min.css')}}" rel="stylesheet">
    <link href="{{url('css/custom.rj.css')}}" rel="stylesheet">
    <link href="{{url('css/dashboard.ui.css')}}" rel="stylesheet">
    <link href="{{url('css/header.ui.css')}}" rel="stylesheet">
    <link href="{{url('css/login.css')}}" rel="stylesheet">
    <!-- <link href="{{url('css/morris.css')}}" rel="stylesheet"> -->
    <link href="{{url('css/daterangepicker.css')}}" rel="stylesheet">
        <!-- mCustomScrollbar -->
    <link href="{{url('css/jquery.mCustomScrollbar.css')}}" rel="stylesheet">
    <link href="{{url('css/paraxify.css')}}" rel="stylesheet">

  <link rel="stylesheet"
        href="{{ asset('dist/css/skins/skin-' . config('adminlte.skin', 'blue') . '.min.css')}} ">
  <link rel="stylesheet" href="{{ asset('vendor/bootstrap/dist/css/bootstrap.min.css') }}">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{ asset('vendor/font-awesome/css/font-awesome.min.css') }}">
  <!-- Ionicons -->
  <link rel="stylesheet" href="{{ asset('vendor/Ionicons/css/ionicons.min.css') }}">

@if(config('adminlte.plugins.select2'))
  <!-- Select2 -->
    <link rel="stylesheet" href="{{ asset('css/select2.css') }}">
@endif

<!-- Theme style -->
  <link rel="stylesheet" href="{{ asset('dist/css/AdminLTE.min.css') }}">
<link rel="stylesheet" href="{{asset('css/buttons.dataTables.min.css')}}">
@if(config('adminlte.plugins.datatables'))
  <!-- DataTables -->

@endif
  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

<script src="{{ asset("/public/bower_components/AdminLTE/plugins/jQuery/jquery-2.2.3.min.js")}}"></script>

<!-- highcharts-->
<script src="{{ asset("/public/js/highcharts.js")}}"></script>
<!-- eChart-->
<!-- <script src="{{ asset("/public/js/echarts.js")}}"></script> -->
<!-- moris chart-->
<!-- <script src="{{ asset("/public/js/raphael.min.js")}}"></script> -->
<!-- <script src="{{ asset("/public/js/morris.min.js")}}"></script> -->
<!-- moment-->
<script src="{{ asset("/public/js/moment.js")}}"></script>
  <script type="text/javascript" src="{{ asset('/public/js/jsvalidation.js' )}}"></script>
<!-- datePicker-->
<script src="{{ asset("/public/js/daterangepicker.js")}}"></script>
<script src="{{ asset("/public/js/paraxify.js")}}"></script>

<!-- custom js | for dashboard -->
<script src="{{ asset("/public/js/dashboard.js")}}"></script>
  <script type="text/javascript" src="{{url("public/js/productmodule.js")}}"></script>

  <script src="{{ asset('public/vendor/bootstrap/dist/js/bootstrap.min.js') }}"></script>
  {{--<script src="{{ asset('public/dist/js/adminlte.min.js') }}"></script>--}}


    <script>
        //See https://laracasts.com/discuss/channels/vue/use-trans-in-vuejs
        window.trans = @php
            // copy all translations from /resources/lang/CURRENT_LOCALE/* to global JS variable
            $lang_files = File::files(resource_path() . '/lang/' . App::getLocale());
            $trans = [];
            foreach ($lang_files as $f) {
                $filename = pathinfo($f)['filename'];
                $trans[$filename] = trans($filename);
            }
            $trans['adminlte_lang_message'] = trans('adminlte_lang::message');
            echo json_encode($trans);
        @endphp
    </script>
</head>
