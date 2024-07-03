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
                        <span>General Setup</span>
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
                                    <span>Banks</span>
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
                                    <span>Bank Branches</span>
                                </a>
                            </li>
                        <?php endif; ?>
                        <?php if(App\Helper\Common::userwisepermission(Auth::user()->id, "Bank Branch View")): ?>
                            <li class="<?php echo (Request::is('General-Setup/Accounts')) ? 'active custom':''; ?>">
                                <a href="<?php echo e(url('/General-Setup/Accounts')); ?>">
                                    <?php if(Request::is('General-Setup/Accounts')): ?>
                                        <i class="fa fa-fw fa-circle"></i>
                                    <?php else: ?>
                                        <i class="fa fa-fw fa-circle-o "></i>
                                    <?php endif; ?>  
                                    <span>Bank Accounts</span>
                                </a>
                            </li>
                        <?php endif; ?>
                        <?php if(App\Helper\Common::userwisepermission(Auth::user()->id, "Account")): ?>
                            <li class="<?php echo (Request::is('General-Setup/generalaccountinfo')) ? 'active custom':''; ?>">
                                <a href="<?php echo e(url('/General-Setup/generalaccountinfo')); ?>">
                                    <?php if(Request::is('General-Setup/generalaccountinfo')): ?>
                                        <i class="fa fa-fw fa-circle"></i>
                                    <?php else: ?>
                                        <i class="fa fa-fw fa-circle-o "></i>
                                    <?php endif; ?>  
                                    <span>General Accounts</span>
                                </a>
                            </li>
                        <?php endif; ?>
                        <?php if(App\Helper\Common::userwisepermission(Auth::user()->id, "Alert")): ?>
                            <li class="<?php echo (Request::is('General-Setup/alertinfo')) ? 'active custom':''; ?>">
                                <a href="<?php echo e(url('/General-Setup/alertinfo')); ?>">
                                    <?php if(Request::is('General-Setup/alertinfo')): ?>
                                        <i class="fa fa-fw fa-circle"></i>
                                    <?php else: ?>
                                        <i class="fa fa-fw fa-circle-o "></i>
                                    <?php endif; ?>
                                    <span>Alert</span>
                                </a>
                            </li>
                        <?php endif; ?>
                        <?php if(App\Helper\Common::userwisepermission(Auth::user()->id, "Brands")): ?>
                            <li class="<?php echo (Request::is('General-Setup/brandinfo')) ? 'active custom':''; ?>">
                                <a href="<?php echo e(url('/General-Setup/brandinfo')); ?>">
                                    <?php if(Request::is('General-Setup/brandinfo')): ?>
                                        <i class="fa fa-fw fa-circle"></i>
                                    <?php else: ?>    
                                        <i class="fa fa-fw fa-circle-o "></i>
                                    <?php endif; ?>
                                    <span>Brands</span>
                                </a>
                            </li>
                        <?php endif; ?>
                        <?php if(App\Helper\Common::userwisepermission(Auth::user()->id, "Categories")): ?>
                            <li class="<?php echo (Request::is('General-Setup/categoriesinfo')) ? 'active custom':''; ?>">
                                <a href="<?php echo e(url('/General-Setup/categoriesinfo')); ?>">
                                    <?php if(Request::is('General-Setup/categoriesinfo')): ?>
                                        <i class="fa fa-fw fa-circle"></i>
                                    <?php else: ?> 
                                        <i class="fa fa-fw fa-circle-o "></i>
                                    <?php endif; ?>
                                    <span>Categories</span>
                                </a>
                            </li>
                        <?php endif; ?>
                        <?php if(App\Helper\Common::userwisepermission(Auth::user()->id, "Cities")): ?>
                            <li class="<?php echo (Request::is('General-Setup/citiesinfo')) ? 'active custom':''; ?>">
                                <a href="<?php echo e(url('/General-Setup/citiesinfo')); ?>">
                                    <?php if(Request::is('General-Setup/citiesinfo')): ?>
                                        <i class="fa fa-fw fa-circle"></i>
                                    <?php else: ?>    
                                        <i class="fa fa-fw fa-circle-o "></i>
                                    <?php endif; ?>
                                    <span>Cities</span>
                                </a>
                            </li>
                        <?php endif; ?>
                        <?php if(App\Helper\Common::userwisepermission(Auth::user()->id, "Drivers")): ?>
                            <li class="<?php echo (Request::is('General-Setup/driversinfo')) ? 'active custom':''; ?>">
                                <a href="<?php echo e(url('/General-Setup/driversinfo')); ?>">
                                    <?php if(Request::is('General-Setup/driversinfo')): ?>
                                        <i class="fa fa-fw fa-circle"></i>
                                    <?php else: ?>    
                                        <i class="fa fa-fw fa-circle-o "></i>
                                    <?php endif; ?>
                                    <span>Drivers</span>
                                </a>
                            </li>
                        <?php endif; ?>
                        <?php if(App\Helper\Common::userwisepermission(Auth::user()->id, "Route")): ?>
                            <li class="<?php echo (Request::is('General-Setup/routeinfo')) ? 'active custom':''; ?>">
                                <a href="<?php echo e(url('/General-Setup/routeinfo')); ?>">
                                    <?php if(Request::is('General-Setup/routeinfo')): ?>
                                        <i class="fa fa-fw fa-circle"></i>
                                    <?php else: ?>    
                                        <i class="fa fa-fw fa-circle-o "></i>
                                    <?php endif; ?>
                                    <span>Route</span>
                                </a>
                            </li>
                        <?php endif; ?>
                        <?php if(App\Helper\Common::userwisepermission(Auth::user()->id, "Vehicles")): ?>
                            <li class="<?php echo (Request::is('General-Setup/vehiclesinfo')) ? 'active custom':''; ?>">
                                <a href="<?php echo e(url('/General-Setup/vehiclesinfo')); ?>">
                                    <?php if(Request::is('General-Setup/vehiclesinfo')): ?>
                                        <i class="fa fa-fw fa-circle"></i>
                                    <?php else: ?>
                                        <i class="fa fa-fw fa-circle-o "></i>
                                    <?php endif; ?>
                                    <span>Vehicles</span>
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
                                    <span>Customer</span>
                                </a>
                            </li>
                        <?php endif; ?>
                        <?php if(App\Helper\Common::userwisepermission(Auth::user()->id, "Cost Center")): ?>
                            <li class="<?php echo (Request::is('General-Setup/costcenterinfo')) ? 'active custom':''; ?>">
                                <a href="<?php echo e(url('/General-Setup/costcenterinfo')); ?>">
                                    <?php if(Request::is('General-Setup/costcenterinfo')): ?>
                                        <i class="fa fa-fw fa-circle"></i>
                                    <?php else: ?>
                                        <i class="fa fa-fw fa-circle-o "></i>
                                    <?php endif; ?>
                                    <span>Cost Center</span>
                                </a>
                            </li>
                        <?php endif; ?>
                        <?php if(App\Helper\Common::userwisepermission(Auth::user()->id, "Fuel Sation")): ?>
                            <li class="<?php echo (Request::is('General-Setup/fuelstationinfo')) ? 'active custom':''; ?>">
                                <a href="<?php echo e(url('/General-Setup/fuelstationinfo')); ?>">
                                    <?php if(Request::is('General-Setup/fuelstationinfo')): ?>
                                        <i class="fa fa-fw fa-circle"></i>
                                    <?php else: ?>
                                        <i class="fa fa-fw fa-circle-o "></i>
                                    <?php endif; ?>
                                    <span>Fuel Sation</span>
                                </a>
                            </li>
                        <?php endif; ?>
                        <?php if(App\Helper\Common::userwisepermission(Auth::user()->id, "Workshop Setup")): ?>
                            <li class="<?php echo (Request::is('General-Setup/workshops')) ? 'active custom':''; ?>">
                                <a href="<?php echo e(url('/General-Setup/workshops')); ?>">
                                    <?php if(Request::is('General-Setup/workshops')): ?>
                                        <i class="fa fa-fw fa-circle"></i>
                                    <?php else: ?> 
                                        <i class="fa fa-fw fa-circle-o "></i>
                                    <?php endif; ?>
                                    <span>Workshops</span>
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
                        <span>Transactions</span>
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
                                <span>Trips</span>
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
                                <span>Road Receipt</span>
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
                                <span>Customer Invoices</span>
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
            <?php if(App\Helper\Common::userwisepermission(Auth::user()->id, "Workshops")): ?>
                <li class="treeview <?php echo (Request::is('workshops/*')) ? 'menu-open':''; ?>">
                    <a href="">
                        <i class="fa fa-fw fa-users "></i>
                        <span>Workshops </span>
                        <span class="pull-right-container">
                        <span class="label label-success pull-right"></span>
                            <i class="fa fa-angle-left pull-right"></i>
                        </span>
                    </a>
                    <ul class="treeview-menu <?php echo (Request::is('workshops/*')) ? 'active':''; ?>" <?php echo (Request::is('workshops/*')) ? "style='display:block'":''; ?>>
                        <?php if(App\Helper\Common::userwisepermission(Auth::user()->id, "Manufacturers")): ?>
                        <li class="<?php echo (Request::is('workshops/Manufacturers')) ? 'active custom':''; ?>">
                            <a href="<?php echo e(url('/workshops/Manufacturers')); ?>">
                                <?php if(Request::is('workshops/Manufacturers')): ?>
                                    <i class="fa fa-fw fa-circle "></i>
                                <?php else: ?>
                                    <i class="fa fa-fw fa-circle-o "></i>
                                <?php endif; ?>
                                <span>Manufacturers</span>
                            </a>
                        </li>
                        <?php endif; ?>
                        <?php if(App\Helper\Common::userwisepermission(Auth::user()->id, "Parts")): ?>
                        <li class="<?php echo (Request::is('workshops/Parts')) ? 'active custom':''; ?>">
                            <a href="<?php echo e(url('/workshops/Parts')); ?>">
                                <?php if(Request::is('workshops/Parts')): ?>
                                    <i class="fa fa-fw fa-circle"></i>
                                <?php else: ?>
                                    <i class="fa fa-fw fa-circle-o "></i>
                                <?php endif; ?>
                                <span>Parts</span>
                            </a>
                        </li>
                        <?php endif; ?>
                        <?php if(App\Helper\Common::userwisepermission(Auth::user()->id, "Services")): ?>
                        <li class="<?php echo (Request::is('workshops/Services')) ? 'active custom':''; ?>">
                            <a href="<?php echo e(url('/workshops/Services')); ?>">
                                <?php if(Request::is('workshops/Services')): ?>
                                    <i class="fa fa-fw fa-circle"></i>
                                <?php else: ?>
                                    <i class="fa fa-fw fa-circle-o "></i>
                                <?php endif; ?>
                                <span>Services</span>
                            </a>
                        </li>
                        <?php endif; ?>
                        <?php if(App\Helper\Common::userwisepermission(Auth::user()->id, "Job")): ?>
                        <li class="<?php echo (Request::is('workshops/Jobs')) ? 'active custom':''; ?>">
                            <a href="<?php echo e(url('/workshops/Jobs')); ?>">
                                <?php if(Request::is('/workshops/Jobs')): ?>
                                    <i class="fa fa-fw fa-circle"></i>
                                <?php else: ?>
                                    <i class="fa fa-fw fa-circle-o "></i>
                                <?php endif; ?>
                                <span>Job</span>
                            </a>
                        </li>
                        <?php endif; ?>
                        <?php if(App\Helper\Common::userwisepermission(Auth::user()->id, "maintenance schedule Read")): ?>
                        <li class="<?php echo (Request::is('workshops/maintenance-schedule')) ? 'active custom':''; ?>">
                            <a href="<?php echo e(url('/workshops/maintenance-schedule')); ?>">
                                <?php if(Request::is('workshops/maintenance-schedule')): ?>
                                    <i class="fa fa-fw fa-circle"></i>
                                <?php else: ?>
                                    <i class="fa fa-fw fa-circle-o "></i>
                                <?php endif; ?>
                                <span>Maintenance Schedule</span>
                            </a>
                        </li>
                        <?php endif; ?>
                        <?php if(App\Helper\Common::userwisepermission(Auth::user()->id, "schedule job processing Read")): ?>
                        <li class="<?php echo (Request::is('workshops/schedule-job-processing')) ? 'active custom':''; ?>">
                            <a href="<?php echo e(url('/workshops/schedule-job-processing')); ?>">
                                <?php if(Request::is('workshops/schedule-job-processing')): ?>
                                    <i class="fa fa-fw fa-circle"></i>
                                <?php else: ?>
                                    <i class="fa fa-fw fa-circle-o "></i>
                                <?php endif; ?>
                                <span>Schedule Job Processing</span>
                            </a>
                        </li>
                        <?php endif; ?>
                    </ul>
                </li>
            <?php endif; ?>
            <?php if(App\Helper\Common::userwisepermission(Auth::user()->id, "Project Management")): ?>
                <li class="treeview  <?php echo (Request::is('project-management/*')) ? 'menu-open':''; ?>">
                    <a href="">
                        <i class="fa fa-fw fa-folder"></i>
                        <span>Project Management</span>
                        <span class="pull-right-container">
                        <span class="label label-success pull-right"></span>
                            <i class="fa fa-angle-left pull-right"></i>
                        </span>
                    </a>
                    <ul class="treeview-menu <?php echo (Request::is('project-management/*')) ? 'active':''; ?>" <?php echo (Request::is('project-management/*')) ? "style='display:block'":''; ?>>
                        <?php if(App\Helper\Common::userwisepermission(Auth::user()->id, "Projects Read")): ?>
                        <li class="<?php echo (Request::is('project-management/projects')) ? 'active custom':''; ?>">
                            <a href="<?php echo e(url('project-management/projects')); ?>">
                                <?php if(Request::is('project-management/projects')): ?>
                                    <i class="fa fa-fw fa-circle"></i>
                                <?php else: ?> 
                                    <i class="fa fa-fw fa-circle-o "></i>
                                <?php endif; ?>
                                <span>Projects</span>
                            </a>
                        </li>
                        <?php endif; ?>
                        
                    </ul>
                </li>
            <?php endif; ?>
            <?php if(App\Helper\Common::userwisepermission(Auth::user()->id, "Finance")): ?>
            <li class="treeview <?php echo (Request::is('Finance/*')) ? 'menu-open':''; ?>">
                <a href="">
                    <i class="fa fa-fw fa-cc-diners-club"></i>
                    <span>Finance</span>
                    <span class="pull-right-container">
                        <span class="label label-success pull-right"></span>
                            <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu <?php echo (Request::is('Finance/*')) ? 'active':''; ?>" <?php echo (Request::is('Finance/*')) ? "style='display:block'":''; ?>>

                    <?php echo $__env->make('adminlte::layouts.partials.fi_chartofAccount-sidemenu', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                    <?php echo $__env->make('adminlte::layouts.partials.fi_generalvoucher-sidemenu', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

                    <?php if(App\Helper\Common::userwisepermission(Auth::user()->id, "Vehicle Leasing View")): ?>
                    <li class="<?php echo (Request::is('Finance/Vehicle-Leasing')) ? 'active custom':''; ?>">
                        <a href="<?php echo e(url('/Finance/Vehicle-Leasing/')); ?>">
                            <i class="fa fa-angle-right"></i>
                            <span>Vehicle Leasing</span>
                        </a>
                    </li>
                    <?php endif; ?>
                    <?php if(App\Helper\Common::userwisepermission(Auth::user()->id, "Depreciations Paid View")): ?>
                    <li class="<?php echo (Request::is('Finance/Depreciations-Paid')) ? 'active custom':''; ?>">
                        <a href="<?php echo e(url('/Finance/Depreciations-Paid/')); ?>">
                            <i class="fa fa-angle-right"></i>
                            <span>Depreciations Paid</span>
                        </a>
                    </li>
                    <?php endif; ?>
                    <?php if(App\Helper\Common::userwisepermission(Auth::user()->id, "Expense Payment View")): ?>
                    <li class="<?php echo (Request::is('Finance/Expense-Payment')) ? 'active custom':''; ?>">
                        <a href="<?php echo e(url('/Finance/Expense-Payment/')); ?>">
                            <i class="fa fa-angle-right"></i>
                            <span>Expense Payment</span>
                        </a>
                    </li>
                    <?php endif; ?>
                    <?php if(App\Helper\Common::userwisepermission(Auth::user()->id, "Invoice Amount Receivable View")): ?>
                    <li class="<?php echo (Request::is('Finance/Invoice-Amount-Receivable')) ? 'active custom':''; ?>">
                        <a href="<?php echo e(url('/Finance/Invoice-Amount-Receivable/')); ?>">
                            <i class="fa fa-angle-right"></i>
                            <span>Invoice Amount Receivable</span>
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
