<!-- Main Header -->
<!-- Left side column. contains the logo and sidebar -->
<aside class="main-sidebar">

    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
        <!-- Sidebar Menu -->
        <ul class="sidebar-menu" data-widget="tree">
            <li class="header">MAIN NAVIGATION</li>
            <?php if(App\Helper\Common::userwisepermission(Auth::user()->id, "General Setup")): ?>
                <li class="treeview <?php echo (Request::is('General-Setup/*')) ? 'menu-open':''; ?>">
                    <a href="">
                        <i class="fa fa-fw fa-gears "></i>
                        <span>Customer Area</span>
                        <span class="pull-right-container">
                        <span class="label label-success pull-right"></span>
                                <i class="fa fa-angle-left pull-right"></i>
                    </span>
                    </a>
                    <ul class="treeview-menu <?php echo (Request::is('General-Setup/*')) ? 'active':''; ?>" <?php echo (Request::is('General-Setup/*')) ? "style='display:block'":''; ?>>
                        <?php if(App\Helper\Common::userwisepermission(Auth::user()->id, "Banks View")): ?>
                            <li class="<?php echo (Request::is('General-Setup/Banks')) ? 'active custom':''; ?>">
                                <a href="<?php echo e(url('/General-Setup/Banks')); ?>">
                                    <?php if(Request::is('General-Setup/Banks')): ?>
                                        <i class="fa fa-fw fa-circle"></i>
                                    <?php else: ?>
                                        <i class="fa fa-fw fa-circle-o "></i>
                                    <?php endif; ?>  
                                    <span>Customer List</span>
                                </a>
                            </li>
                        <?php endif; ?>
                        <?php if(App\Helper\Common::userwisepermission(Auth::user()->id, "Bank Branch View")): ?>
                            <li class="<?php echo (Request::is('General-Setup/Banks/Branches')) ? 'active custom':''; ?>">
                                <a href="<?php echo e(url('/General-Setup/Banks/Branches')); ?>">
                                    <?php if(Request::is('General-Setup/Banks/Branches')): ?>
                                        <i class="fa fa-fw fa-circle"></i>
                                    <?php else: ?>
                                        <i class="fa fa-fw fa-circle-o "></i>
                                    <?php endif; ?>  
                                    <span>Customer Approval</span>
                                </a>
                            </li>
                        <?php endif; ?>

                        <?php if(App\Helper\Common::userwisepermission(Auth::user()->id, "Customer")): ?>
                            <li class="<?php echo (Request::is('General-Setup/customerinfo')) ? 'active custom':''; ?>">
                                <a href="<?php echo e(url('/General-Setup/customerinfo')); ?>">
                                    <?php if(Request::is('General-Setup/customerinfo')): ?>
                                        <i class="fa fa-fw fa-circle"></i>
                                    <?php else: ?>
                                        <i class="fa fa-fw fa-circle-o "></i>
                                    <?php endif; ?>
                                    <span>Customer Rate List</span>
                                </a>
                            </li>
                        <?php endif; ?>

























                    </ul>
                </li>
            <?php endif; ?>
            <?php if(App\Helper\Common::userwisepermission(Auth::user()->id, "Transactions")): ?>
                <li class="treeview <?php echo (Request::is('Transactions/*')) ? 'menu-open':''; ?>">
                    <a href="">
                        <i class="fa fa-fw fa-exchange "></i>
                        <span>Booking</span>
                        <span class="pull-right-container">
                        <span class="label label-success pull-right"></span>
                                <i class="fa fa-angle-left pull-right"></i>
                    </span>
                    </a>
                    <ul class="treeview-menu <?php echo (Request::is('Transactions/*')) ? 'active':''; ?>" <?php echo (Request::is('Transactions/*')) ? "style='display:block'":''; ?>>
                        <?php if(App\Helper\Common::userwisepermission(Auth::user()->id, "Trips")): ?>
                            <li class="<?php echo (Request::is('Transactions/tripinfo')) ? 'active custom':''; ?>">
                                <a href="<?php echo e(url('Transactions/tripinfo')); ?>">
                                    <?php if(Request::is('Transactions/tripinfo')): ?>
                                        <i class="fa fa-fw fa-circle"></i>
                                    <?php else: ?>
                                        <i class="fa fa-fw fa-circle-o "></i>
                                    <?php endif; ?>
                                    <span>Booking Order List</span>
                                </a>
                            </li>
                        <?php endif; ?>
                        <?php if(App\Helper\Common::userwisepermission(Auth::user()->id, "Trips")): ?>
                        <li class="<?php echo (Request::is('booking/singlebooking')) ? 'active custom':''; ?>">
                            <a href="<?php echo e(url('booking/singlebooking')); ?>">
                                <?php if(Request::is('Transactions/tripinfo')): ?>
                                    <i class="fa fa-fw fa-circle"></i>
                                <?php else: ?>
                                    <i class="fa fa-fw fa-circle-o "></i>
                                <?php endif; ?>
                                <span>Single Booking</span>
                            </a>
                        </li>
                        <?php endif; ?>
                        <?php if(App\Helper\Common::userwisepermission(Auth::user()->id, "Road Receipt")): ?>
                        <li class="<?php echo (Request::is('Transactions/roadreceiptinfo')) ? 'active custom':''; ?>">
                            <a href="<?php echo e(url('Transactions/roadreceiptinfo')); ?>">
                                <?php if(Request::is('Transactions/roadreceiptinfo')): ?>
                                    <i class="fa fa-fw fa-circle"></i>
                                <?php else: ?>
                                    <i class="fa fa-fw fa-circle-o "></i>
                                <?php endif; ?>
                                <span>Booking By file</span>
                            </a>
                        </li>
                        <?php endif; ?>
                        <?php if(App\Helper\Common::userwisepermission(Auth::user()->id, "Customer Invoices View")): ?>
                        <li class="<?php echo (Request::is('Transactions/Customer-Inovices')) ? 'active custom':''; ?>">
                            <a href="<?php echo e(url('Transactions/Customer-Inovices')); ?>">
                                <?php if(Request::is('Transactions/Customer-Inovices')): ?>
                                    <i class="fa fa-fw fa-circle"></i>
                                <?php else: ?>
                                    <i class="fa fa-fw fa-circle-o "></i>
                                <?php endif; ?>
                                <span>Generate LoadSheet</span>
                            </a>
                        </li>
                        <?php endif; ?>
                    </ul>
                </li>
            <?php endif; ?>
            <?php if(App\Helper\Common::userwisepermission(Auth::user()->id, "Reports")): ?>
                <li class="treeview <?php echo (Request::is('Report/*')) ? 'menu-open':''; ?>">
                    <a href="">
                        <i class="fa fa-fw fa-line-chart "></i>
                        <span>Reports</span>
                        <span class="pull-right-container">
                        <span class="label label-success pull-right"></span>
                                <i class="fa fa-angle-left pull-right"></i>
                    </span>
                    </a>
                    <ul class="treeview-menu <?php echo (Request::is('Report/*')) ? 'active':''; ?>" <?php echo (Request::is('Report/*')) ? "style='display:block'":''; ?>>
                        <?php if(App\Helper\Common::userwisepermission(Auth::user()->id, "Month Wise Transport")): ?>
                        <li class="<?php echo (Request::is('Report/monthly-transport-report')) ? 'active custom':''; ?>">
                            <a href="<?php echo e(url('Report/monthly-transport-report')); ?>">
                                <?php if(Request::is('Report/monthly-transport-report')): ?>
                                    <i class="fa fa-fw fa-circle"></i>
                                <?php else: ?>
                                    <i class="fa fa-fw fa-circle-o "></i>
                                <?php endif; ?>
                                <span>Month Wise Transport</span>
                            </a>
                        </li>
                        <?php endif; ?>
                    </ul>
                </li>
            <?php endif; ?>
            <?php if(App\Helper\Common::userwisepermission(Auth::user()->id, "User List") || App\Helper\Common::userwisepermission(Auth::user()->id, "Role List") || App\Helper\Common::userwisepermission(Auth::user()->id, "Permission List")): ?>
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
                        <?php if(App\Helper\Common::userwisepermission(Auth::user()->id, "User List")): ?>
                            <li class="">
                                <a href="<?php echo e(url('/users')); ?>">
                                    <i class="fa fa-fw fa-circle-o "></i>
                                    <span>Users</span>
                                </a>
                            </li>
                        <?php endif; ?>
                        <?php if(App\Helper\Common::userwisepermission(Auth::user()->id, "Role List")): ?>
                            <li class="">
                                <a href="<?php echo e(url('/roles')); ?>">
                                    <i class="fa fa-fw fa-circle-o "></i>
                                    <span>Role</span>
                                </a>
                            </li>
                        <?php endif; ?>
                    </ul>
                </li>
            <?php endif; ?>
        </ul>
        <!-- /.sidebar-menu -->
    </section>

    </section>

</aside>
