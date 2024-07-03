<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <title>Falcon Courier and Logistics</title>
    <meta content="Themesdesign" name="author" />
    <link rel="shortcut icon" href="{{asset('/images/favicon/favicon.ico')}}">
    <link rel="apple-touch-icon" sizes="57x57" href="{{asset('/images/favicon/apple-icon-57x57.png')}}">
    <link rel="apple-touch-icon" sizes="60x60" href="{{asset('/images/favicon/apple-icon-60x60.png')}}">
    <link rel="apple-touch-icon" sizes="72x72" href="{{asset('/images/favicon/apple-icon-72x72.png')}}">
    <link rel="apple-touch-icon" sizes="76x76" href="{{asset('/images/favicon/apple-icon-76x76.png')}}">
    <link rel="apple-touch-icon" sizes="114x114" href="{{asset('/images/favicon/apple-icon-114x114.png')}}">
    <link rel="apple-touch-icon" sizes="120x120" href="{{asset('/images/favicon/apple-icon-120x120.png')}}">
    <link rel="apple-touch-icon" sizes="144x144" href="{{asset('/images/favicon/apple-icon-144x144.png')}}">
    <link rel="apple-touch-icon" sizes="152x152" href="{{asset('/images/favicon/apple-icon-152x152.png')}}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{asset('/images/favicon/apple-icon-180x180.png')}}">
    <link rel="icon" type="image/png" sizes="192x192"  href="{{asset('/images/favicon/android-icon-192x192.png')}}'">
    <link rel="icon" type="image/png" sizes="32x32" href="{{asset('/images/favicon/favicon-32x32.png')}}">
    <link rel="icon" type="image/png" sizes="96x96" href="{{asset('/images/favicon/favicon-96x96.png')}}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{asset('/images/favicon/favicon-16x16.png')}}">
    <link rel="manifest" href="/manifest.json">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="/ms-icon-144x144.png">
    <meta name="theme-color" content="#ffffff">

    <!--Morris Chart CSS -->
    <link rel="stylesheet" href="{{asset('/plugins/morris/morris.css')}}">

    <link href="{{asset('/css/bootstrap.min.css')}}" rel="stylesheet" type="text/css">
    <link href="{{asset('/css/metismenu.min.css')}}" rel="stylesheet" type="text/css">
    <link href="{{asset('/css/icons.css')}}" rel="stylesheet" type="text/css">
    <link href="{{asset('/css/style.css')}}" rel="stylesheet" type="text/css">
    <link href="{{asset('/css/custom.css')}}" rel="stylesheet" type="text/css">
    <link href="{{url('css/ui.jqgrid-bootstrap.css')}}" rel="stylesheet">
    <link href="{{url('css/ui.jqgrid-bootstrap-ui.css')}}" rel="stylesheet">
    <link href="{{url('css/ui.jqgrid.css')}}" rel="stylesheet">
    <link href="{{url('jquery-ui-1.12.1.custom/jquery-ui.min.css')}}" rel="stylesheet">
</head>
<body>
<div class="header-bg">
    <!-- Navigation Bar-->
    <header id="topnav">
        <div class="topbar-main">
            <div class="container-fluid">

                <!-- Logo-->
                <div>
                    <a href="{{url('/')}}" class="logo">
                            <span class="logo-light">
                                    <img src="{{asset('/images/falconlogo4.png')}}" style="width: 50px;" /> Falcon
                            </span>
                    </a>
                </div>
                <!-- End Logo-->

                <div class="menu-extras topbar-custom navbar p-0">
                    <ul class="list-inline d-none d-lg-block mb-0">
                        <li class="hide-phone app-search float-left">
                            <form role="search" class="app-search">
                                <div class="form-group mb-0">
                                    <input type="text" class="form-control" placeholder="Search..">
                                    <button type="submit"><i class="fa fa-search"></i></button>
                                </div>
                            </form>
                        </li>
                    </ul>

                    <ul class="navbar-right ml-auto list-inline float-right mb-0">


                        <!-- full screen -->
                        <li class="dropdown notification-list list-inline-item d-none d-md-inline-block">
                            <a class="nav-link waves-effect" href="#" id="btn-fullscreen">
                                <i class="mdi mdi-arrow-expand-all noti-icon"></i>
                            </a>
                        </li>

                        <!-- notification -->
                        <li class="dropdown notification-list list-inline-item">
                            <a class="nav-link dropdown-toggle arrow-none waves-effect" data-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
                                <i class="mdi mdi-bell-outline noti-icon"></i>
{{--                                <span class="badge badge-pill badge-danger noti-icon-badge">3</span>--}}
                            </a>
                            <div class="dropdown-menu dropdown-menu-right dropdown-menu-animated dropdown-menu-lg px-1">
                                <!-- item-->
                                <h6 class="dropdown-item-text">
                                    Notifications
                                </h6>
                                <div class="slimscroll notification-item-list">
                                    <!-- item-->
{{--                                    <a href="javascript:void(0);" class="dropdown-item notify-item active">--}}
{{--                                        <div class="notify-icon bg-success"><i class="mdi mdi-cart-outline"></i></div>--}}
{{--                                        <p class="notify-details"><b>Your order is placed</b><span class="text-muted">Dummy text of the printing and typesetting industry.</span></p>--}}
{{--                                    </a>--}}
                                </div>
                                <!-- All-->
{{--                                <a href="javascript:void(0);" class="dropdown-item text-center notify-all text-primary">--}}
{{--                                    View all <i class="fi-arrow-right"></i>--}}
{{--                                </a>--}}
                            </div>
                        </li>

                        <li class="dropdown notification-list list-inline-item">
                            <div class="dropdown notification-list nav-pro-img">
                                <a class="dropdown-toggle nav-link arrow-none nav-user" data-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
                                    <img src="{{asset('/images/users/user-4.jpg')}}" alt="user" class="rounded-circle">
                                </a>
                                <div class="dropdown-menu dropdown-menu-right profile-dropdown ">
                                    <!-- item-->
                                    <a class="dropdown-item" href="#"><i class="mdi mdi-account-circle"></i> Profile</a>
                                    <a class="dropdown-item" href="#"><i class="mdi mdi-wallet"></i> My Wallet</a>
                                    <a class="dropdown-item d-block" href="#"><span class="badge badge-success float-right">11</span><i class="mdi mdi-settings"></i> Settings</a>
                                    <a class="dropdown-item" href="#"><i class="mdi mdi-lock-open-outline"></i> Lock screen</a>
                                    <div class="dropdown-divider"></div>
                                    <form id="logout-form" action="{{ url('/logout') }}" method="POST" >
                                        {{ csrf_field() }}
                                        <input type="submit" class="dropdown-item text-danger" value="logout" />
                                    </form>
                                </div>
                            </div>
                        </li>

                        <li class="menu-item dropdown notification-list list-inline-item">
                            <!-- Mobile menu toggle-->
                            <a class="navbar-toggle nav-link">
                                <div class="lines">
                                    <span></span>
                                    <span></span>
                                    <span></span>
                                </div>
                            </a>
                            <!-- End mobile menu toggle-->
                        </li>

                    </ul>

                </div>
                <!-- end menu-extras -->

                <div class="clearfix"></div>

            </div>
            <!-- end container -->
        </div>
        <!-- end topbar-main -->

        @include('layouts.partials.topmenu')
    </header>
    <!-- End Navigation Bar-->

</div>
<!-- header-bg -->
<script src="{{asset('/js/jquery.min.js')}}"></script>
<script src="{{ asset('jqGrid/i18n/grid.locale-en.js' )}}"></script>
<script src="{{ asset('jqGrid/jquery.jqGrid.min.js')}}"></script>
<div class="wrapper">
    <div class="container-fluid">
        @yield('content')
    </div>
</div>
@include('layouts.partials.footer')

<!-- jQuery  -->

<script src="{{asset('/js/bootstrap.bundle.min.js')}}"></script>
<script src="{{asset('/js/jquery.slimscroll.js')}}"></script>
<script src="{{asset('/js/waves.min.js')}}"></script>

<!--Morris Chart-->

<script src="{{asset('/plugins/raphael/raphael.min.js')}}"></script>

<script src="{{asset('/pages/dashboard.init.js')}}"></script>

<!-- App js -->
<script src="{{asset('/js/app.js')}}"></script>
<div class="modal fade custom-modal-rj"  tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
    <div class="modal-dialog custom-modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title custom-modal-title float-left" id="myLargeModalLabel">Large modal</h4>
                <button type="button" class="close float-right" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">x</span></button>

            </div>
            <div class="modal-body custom-modal-body-rj">  </div>
        </div>
    </div>
</div>
</body>
</html>
