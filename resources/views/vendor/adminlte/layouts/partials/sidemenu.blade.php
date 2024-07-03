<!-- Main Header -->
<!-- Left side column. contains the logo and sidebar -->
<aside class="main-sidebar">

    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
        <!-- Sidebar Menu -->
        <ul class="sidebar-menu" data-widget="tree">
            <li class="header">MAIN NAVIGATION</li>
            @if(App\Helper\Common::userwisepermission(Auth::user()->id, "General Setup"))
                <li class="treeview {!! (Request::is('General-Setup/*')) ? 'menu-open':'' !!}">
                    <a href="">
                        <i class="fa fa-fw fa-gears "></i>
                        <span>Customer Area</span>
                        <span class="pull-right-container">
                        <span class="label label-success pull-right"></span>
                                <i class="fa fa-angle-left pull-right"></i>
                    </span>
                    </a>
                    <ul class="treeview-menu {!! (Request::is('General-Setup/*')) ? 'active':'' !!}" {!! (Request::is('General-Setup/*')) ? "style='display:block'":'' !!}>
                        @if(App\Helper\Common::userwisepermission(Auth::user()->id, "Banks View"))
                            <li class="{!! (Request::is('General-Setup/Banks')) ? 'active custom':'' !!}">
                                <a href="{{ url('/General-Setup/Banks') }}">
                                    @if(Request::is('General-Setup/Banks'))
                                        <i class="fa fa-fw fa-circle"></i>
                                    @else
                                        <i class="fa fa-fw fa-circle-o "></i>
                                    @endif  
                                    <span>Customer List</span>
                                </a>
                            </li>
                        @endif
                        @if(App\Helper\Common::userwisepermission(Auth::user()->id, "Bank Branch View"))
                            <li class="{!! (Request::is('General-Setup/Banks/Branches')) ? 'active custom':'' !!}">
                                <a href="{{ url('/General-Setup/Banks/Branches') }}">
                                    @if(Request::is('General-Setup/Banks/Branches'))
                                        <i class="fa fa-fw fa-circle"></i>
                                    @else
                                        <i class="fa fa-fw fa-circle-o "></i>
                                    @endif  
                                    <span>Customer Approval</span>
                                </a>
                            </li>
                        @endif

                        @if(App\Helper\Common::userwisepermission(Auth::user()->id, "Customer"))
                            <li class="{!! (Request::is('General-Setup/customerinfo')) ? 'active custom':'' !!}">
                                <a href="{{ url('/General-Setup/customerinfo') }}">
                                    @if(Request::is('General-Setup/customerinfo'))
                                        <i class="fa fa-fw fa-circle"></i>
                                    @else
                                        <i class="fa fa-fw fa-circle-o "></i>
                                    @endif
                                    <span>Customer Rate List</span>
                                </a>
                            </li>
                        @endif
{{--                        @if(App\Helper\Common::userwisepermission(Auth::user()->id, "Cost Center"))--}}
{{--                            <li class="{!! (Request::is('General-Setup/costcenterinfo')) ? 'active custom':'' !!}">--}}
{{--                                <a href="{{ url('/General-Setup/costcenterinfo') }}">--}}
{{--                                    @if(Request::is('General-Setup/costcenterinfo'))--}}
{{--                                        <i class="fa fa-fw fa-circle"></i>--}}
{{--                                    @else--}}
{{--                                        <i class="fa fa-fw fa-circle-o "></i>--}}
{{--                                    @endif--}}
{{--                                    <span>Cost Center</span>--}}
{{--                                </a>--}}
{{--                            </li>--}}
{{--                        @endif--}}
{{--                        @if(App\Helper\Common::userwisepermission(Auth::user()->id, "Fuel Sation"))--}}
{{--                            <li class="{!! (Request::is('General-Setup/fuelstationinfo')) ? 'active custom':'' !!}">--}}
{{--                                <a href="{{ url('/General-Setup/fuelstationinfo') }}">--}}
{{--                                    @if(Request::is('General-Setup/fuelstationinfo'))--}}
{{--                                        <i class="fa fa-fw fa-circle"></i>--}}
{{--                                    @else--}}
{{--                                        <i class="fa fa-fw fa-circle-o "></i>--}}
{{--                                    @endif--}}
{{--                                    <span>Fuel Sation</span>--}}
{{--                                </a>--}}
{{--                            </li>--}}
{{--                        @endif--}}

                    </ul>
                </li>
            @endif
            @if(App\Helper\Common::userwisepermission(Auth::user()->id, "Transactions"))
                <li class="treeview {!! (Request::is('Transactions/*')) ? 'menu-open':'' !!}">
                    <a href="">
                        <i class="fa fa-fw fa-exchange "></i>
                        <span>Booking</span>
                        <span class="pull-right-container">
                        <span class="label label-success pull-right"></span>
                                <i class="fa fa-angle-left pull-right"></i>
                    </span>
                    </a>
                    <ul class="treeview-menu {!! (Request::is('Transactions/*')) ? 'active':'' !!}" {!! (Request::is('Transactions/*')) ? "style='display:block'":'' !!}>
                        @if(App\Helper\Common::userwisepermission(Auth::user()->id, "Trips"))
                            <li class="{!! (Request::is('Transactions/tripinfo')) ? 'active custom':'' !!}">
                                <a href="{{ url('Transactions/tripinfo') }}">
                                    @if(Request::is('Transactions/tripinfo'))
                                        <i class="fa fa-fw fa-circle"></i>
                                    @else
                                        <i class="fa fa-fw fa-circle-o "></i>
                                    @endif
                                    <span>Booking Order List</span>
                                </a>
                            </li>
                        @endif
                        @if(App\Helper\Common::userwisepermission(Auth::user()->id, "Trips"))
                        <li class="{!! (Request::is('booking/singlebooking')) ? 'active custom':'' !!}">
                            <a href="{{ url('booking/singlebooking') }}">
                                @if(Request::is('Transactions/tripinfo'))
                                    <i class="fa fa-fw fa-circle"></i>
                                @else
                                    <i class="fa fa-fw fa-circle-o "></i>
                                @endif
                                <span>Single Booking</span>
                            </a>
                        </li>
                        @endif
                        @if(App\Helper\Common::userwisepermission(Auth::user()->id, "Road Receipt"))
                        <li class="{!! (Request::is('Transactions/roadreceiptinfo')) ? 'active custom':'' !!}">
                            <a href="{{ url('Transactions/roadreceiptinfo') }}">
                                @if(Request::is('Transactions/roadreceiptinfo'))
                                    <i class="fa fa-fw fa-circle"></i>
                                @else
                                    <i class="fa fa-fw fa-circle-o "></i>
                                @endif
                                <span>Booking By file</span>
                            </a>
                        </li>
                        @endif
                        @if(App\Helper\Common::userwisepermission(Auth::user()->id, "Customer Invoices View"))
                        <li class="{!! (Request::is('Transactions/Customer-Inovices')) ? 'active custom':'' !!}">
                            <a href="{{ url('Transactions/Customer-Inovices') }}">
                                @if(Request::is('Transactions/Customer-Inovices'))
                                    <i class="fa fa-fw fa-circle"></i>
                                @else
                                    <i class="fa fa-fw fa-circle-o "></i>
                                @endif
                                <span>Generate LoadSheet</span>
                            </a>
                        </li>
                        @endif
                    </ul>
                </li>
            @endif
            @if(App\Helper\Common::userwisepermission(Auth::user()->id, "Reports"))
                <li class="treeview {!! (Request::is('Report/*')) ? 'menu-open':'' !!}">
                    <a href="">
                        <i class="fa fa-fw fa-line-chart "></i>
                        <span>Reports</span>
                        <span class="pull-right-container">
                        <span class="label label-success pull-right"></span>
                                <i class="fa fa-angle-left pull-right"></i>
                    </span>
                    </a>
                    <ul class="treeview-menu {!! (Request::is('Report/*')) ? 'active':'' !!}" {!! (Request::is('Report/*')) ? "style='display:block'":'' !!}>
                        @if(App\Helper\Common::userwisepermission(Auth::user()->id, "Month Wise Transport"))
                        <li class="{!! (Request::is('Report/monthly-transport-report')) ? 'active custom':'' !!}">
                            <a href="{{ url('Report/monthly-transport-report') }}">
                                @if(Request::is('Report/monthly-transport-report'))
                                    <i class="fa fa-fw fa-circle"></i>
                                @else
                                    <i class="fa fa-fw fa-circle-o "></i>
                                @endif
                                <span>Month Wise Transport</span>
                            </a>
                        </li>
                        @endif
                    </ul>
                </li>
            @endif
            @if(App\Helper\Common::userwisepermission(Auth::user()->id, "User List") || App\Helper\Common::userwisepermission(Auth::user()->id, "Role List") || App\Helper\Common::userwisepermission(Auth::user()->id, "Permission List"))
                <li class="treeview">
                    <a href="">
                        <i class="fa fa-fw fa-users "></i>
                        <span>User Managment</span>
                        <span class="pull-right-container">
                    <span class="label label-success pull-right"></span>
                            <i class="fa fa-angle-left pull-right"></i>
                </span>
                    </a>
                    <ul class="treeview-menu">
                        @if(App\Helper\Common::userwisepermission(Auth::user()->id, "User List"))
                            <li class="">
                                <a href="{{url('/users')}}">
                                    <i class="fa fa-fw fa-circle-o "></i>
                                    <span>Users</span>
                                </a>
                            </li>
                        @endif
                        @if(App\Helper\Common::userwisepermission(Auth::user()->id, "Role List"))
                            <li class="">
                                <a href="{{ url('/roles') }}">
                                    <i class="fa fa-fw fa-circle-o "></i>
                                    <span>Role</span>
                                </a>
                            </li>
                        @endif
                    </ul>
                </li>
            @endif
        </ul>
        <!-- /.sidebar-menu -->
    </section>

    </section>

</aside>
