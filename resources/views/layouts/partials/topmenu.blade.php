<!-- MENU Start -->
<div class="navbar-custom">
    <div class="container-fluid">

        <div id="navigation">

            <!-- Navigation Menu-->
            <ul class="navigation-menu">

                <li class="has-submenu">
                    <a href="{{url('/')}}"><i class="icon-accelerator"></i> Dashboard</a>
                </li>

                <li class="has-submenu">
                    <a href="#"><i class="icon-pencil-ruler"></i> Setup <i class="mdi mdi-chevron-down mdi-drop"></i></a>
                    <ul class="submenu megamenu">
                        <li>
                            <ul>
                                <li><a href="{{ url('setup/countries') }}">Countries</a></li>
                                <li><a href="{{ url('setup/city') }}">City</a></li>
                                <li><a href="{{ url('setup/costcenter') }}">Cost Center</a></li>
                                <li><a href="{{ url('setup/services') }}">Services</a></li>
{{--                                <li><a href="ui-dropdowns.html">Dropdowns</a></li>--}}
{{--                                <li><a href="ui-navs.html">Navs</a></li>--}}
                            </ul>
                        </li>
{{--                        <li>--}}
{{--                            <ul>--}}
{{--                                <li><a href="ui-tabs-accordions.html"></a></li>--}}

{{--                            </ul>--}}
{{--                        </li>--}}

{{--                        <li>--}}
{{--                            <ul>--}}
{{--                                <li><a href="ui-spinner.html">Spinner</a></li>--}}
{{--                            </ul>--}}
{{--                        </li>--}}
                    </ul>
                </li>

                <li class="has-submenu">
                    <a href="#"><i class="icon-life-buoy"></i> Customer Area <i class="mdi mdi-chevron-down mdi-drop"></i></a>
                    <ul class="submenu">
                        <li>
                            <a href="{{ url('customer') }}">Customer List</a>
                        </li>

                        <li>
                            <a href="{{ url('customer/customeapprovals') }}">Customer Approval </a>
                        </li>
                        <li>
                            <a href="{{ url('customer/customerratelist') }}">Customer Rate List</a>
                        </li>

                    </ul>
                </li>

                <li class="has-submenu">
                    <a href="#"><i class="icon-diamond"></i> Booking <i class="mdi mdi-chevron-down mdi-drop"></i></a>
                    <ul class="submenu megamenu">
                        <li>
                            <ul>
                                <li><a href="{{ url('transaction/bookinglist') }}">Booking Order List</a></li>
                                <li><a href="{{ url('transaction/singlebooking') }}">Single Order Booking</a></li>
                                <li><a href="{{ url('transaction/bulkbooking') }}">Bulk Booking</a></li>

                            </ul>
                        </li>
                        <li>
                            <ul>
                                <li><a href="{{ url('transaction/cancelbooking') }}">Booking Cancellation </a></li>
                                <li><a href="{{ url('transaction/genrateloadsheet') }}">Generate LoadSheet</a></li>
                                <li><a href="{{ url('transaction/cancelgenrateloadsheet') }}">LoadSheet Cancellation</a></li>

                            </ul>
                        </li>
                    </ul>
                </li>

                <li class="has-submenu">
                    <a href="#"><i class="icon-paper-sheet"></i> Reports <i class="mdi mdi-chevron-down mdi-drop"></i></a>
                    <ul class="submenu megamenu">

                        <li>
                            <ul>
                                <li><a href="{{ url('reports/bookingsummary') }}">Booking Summary</a></li>
                                <li><a href="{{ url('reports/loadsheetsummary') }}">Load Sheet Summary</a></li>
                                <li><a href="{{ url('reports/printcn') }}">Print CN</a></li>
                                <li><a href="{{ url('reports/deliverydetails') }}">Delivery Detail</a></li>
                                <li><a href="{{ url('reports/loadsheetdetails') }}">Load Sheet Details</a></li>
                                <li><a href="{{ url('reports/codpaymentdetails') }}">Cod Payemet Details</a></li>
                                <li><a href="{{ url('reports/undeliverydetails') }}">Un Delivered Details</a></li>
                            </ul>
                        </li>
                        <li>
                            <ul>
                                <li><a href="{{ url('reports/outstandingpayment') }}">Outstanding Payments</a></li>
                                <li><a href="{{ url('reports/customerreport') }}">Customer Report</a></li>

                            </ul>
                        </li>
                    </ul>
                </li>
                @if(App\Helper\Common::userwisepermission(Auth::user()->id, "User List") || App\Helper\Common::userwisepermission(Auth::user()->id, "Role List") || App\Helper\Common::userwisepermission(Auth::user()->id, "Permission List"))
                <li class="has-submenu">
                    <a href="#"><i class="icon-paper-sheet"></i> User Management <i class="mdi mdi-chevron-down mdi-drop"></i></a>
                    <ul class="submenu megamenu">

                        <li>
                            <ul>
                                @if(App\Helper\Common::userwisepermission(Auth::user()->id, "User List"))
                                <li><a href="{{url('/users')}}">Users</a></li>
                                @endif
                                @if(App\Helper\Common::userwisepermission(Auth::user()->id, "Role List"))
                                <li><a href="{{ url('/roles') }}">Role</a></li>
                                @endif
                            </ul>
                        </li>
                    </ul>
                </li>
                @endif
            </ul>
            <!-- End navigation menu -->
        </div>
        <!-- end #navigation -->
    </div>
    <!-- end container -->
</div>
<!-- end navbar-custom -->