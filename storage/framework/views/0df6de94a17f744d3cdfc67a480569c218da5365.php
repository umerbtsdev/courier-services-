<!-- MENU Start -->
<div class="navbar-custom">
    <div class="container-fluid">

        <div id="navigation">

            <!-- Navigation Menu-->
            <ul class="navigation-menu">

                <li class="has-submenu">
                    <a href="<?php echo e(url('/')); ?>"><i class="icon-accelerator"></i> Dashboard</a>
                </li>

                <li class="has-submenu">
                    <a href="#"><i class="icon-pencil-ruler"></i> Setup <i class="mdi mdi-chevron-down mdi-drop"></i></a>
                    <ul class="submenu megamenu">
                        <li>
                            <ul>
                                <li><a href="<?php echo e(url('setup/countries')); ?>">Countries</a></li>
                                <li><a href="<?php echo e(url('setup/city')); ?>">City</a></li>
                                <li><a href="<?php echo e(url('setup/costcenter')); ?>">Cost Center</a></li>
                                <li><a href="<?php echo e(url('setup/services')); ?>">Services</a></li>


                            </ul>
                        </li>












                    </ul>
                </li>

                <li class="has-submenu">
                    <a href="#"><i class="icon-life-buoy"></i> Customer Area <i class="mdi mdi-chevron-down mdi-drop"></i></a>
                    <ul class="submenu">
                        <li>
                            <a href="<?php echo e(url('customer')); ?>">Customer List</a>
                        </li>

                        <li>
                            <a href="<?php echo e(url('customer/customeapprovals')); ?>">Customer Approval </a>
                        </li>
                        <li>
                            <a href="<?php echo e(url('customer/customerratelist')); ?>">Customer Rate List</a>
                        </li>

                    </ul>
                </li>

                <li class="has-submenu">
                    <a href="#"><i class="icon-diamond"></i> Booking <i class="mdi mdi-chevron-down mdi-drop"></i></a>
                    <ul class="submenu megamenu">
                        <li>
                            <ul>
                                <li><a href="<?php echo e(url('transaction/bookinglist')); ?>">Booking Order List</a></li>
                                <li><a href="<?php echo e(url('transaction/singlebooking')); ?>">Single Order Booking</a></li>
                                <li><a href="<?php echo e(url('transaction/bulkbooking')); ?>">Bulk Booking</a></li>

                            </ul>
                        </li>
                        <li>
                            <ul>
                                <li><a href="<?php echo e(url('transaction/cancelbooking')); ?>">Booking Cancellation </a></li>
                                <li><a href="<?php echo e(url('transaction/genrateloadsheet')); ?>">Generate LoadSheet</a></li>
                                <li><a href="<?php echo e(url('transaction/cancelgenrateloadsheet')); ?>">LoadSheet Cancellation</a></li>

                            </ul>
                        </li>
                    </ul>
                </li>

                <li class="has-submenu">
                    <a href="#"><i class="icon-paper-sheet"></i> Reports <i class="mdi mdi-chevron-down mdi-drop"></i></a>
                    <ul class="submenu megamenu">

                        <li>
                            <ul>
                                <li><a href="<?php echo e(url('reports/bookingsummary')); ?>">Booking Summary</a></li>
                                <li><a href="<?php echo e(url('reports/loadsheetsummary')); ?>">Load Sheet Summary</a></li>
                                <li><a href="<?php echo e(url('reports/printcn')); ?>">Print CN</a></li>
                                <li><a href="<?php echo e(url('reports/deliverydetails')); ?>">Delivery Detail</a></li>
                                <li><a href="<?php echo e(url('reports/loadsheetdetails')); ?>">Load Sheet Details</a></li>
                                <li><a href="<?php echo e(url('reports/codpaymentdetails')); ?>">Cod Payemet Details</a></li>
                                <li><a href="<?php echo e(url('reports/undeliverydetails')); ?>">Un Delivered Details</a></li>
                            </ul>
                        </li>
                        <li>
                            <ul>
                                <li><a href="<?php echo e(url('reports/outstandingpayment')); ?>">Outstanding Payments</a></li>
                                <li><a href="<?php echo e(url('reports/customerreport')); ?>">Customer Report</a></li>

                            </ul>
                        </li>
                    </ul>
                </li>
                <?php if(App\Helper\Common::userwisepermission(Auth::user()->id, "User List") || App\Helper\Common::userwisepermission(Auth::user()->id, "Role List") || App\Helper\Common::userwisepermission(Auth::user()->id, "Permission List")): ?>
                <li class="has-submenu">
                    <a href="#"><i class="icon-paper-sheet"></i> User Management <i class="mdi mdi-chevron-down mdi-drop"></i></a>
                    <ul class="submenu megamenu">

                        <li>
                            <ul>
                                <?php if(App\Helper\Common::userwisepermission(Auth::user()->id, "User List")): ?>
                                <li><a href="<?php echo e(url('/users')); ?>">Users</a></li>
                                <?php endif; ?>
                                <?php if(App\Helper\Common::userwisepermission(Auth::user()->id, "Role List")): ?>
                                <li><a href="<?php echo e(url('/roles')); ?>">Role</a></li>
                                <?php endif; ?>
                            </ul>
                        </li>
                    </ul>
                </li>
                <?php endif; ?>
            </ul>
            <!-- End navigation menu -->
        </div>
        <!-- end #navigation -->
    </div>
    <!-- end container -->
</div>
<!-- end navbar-custom -->