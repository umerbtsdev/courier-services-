<!-- Main Header -->

<?php
?>

<header class="main-header">
  @if(config('adminlte.layout') == 'top-nav')
    <nav class="navbar navbar-static-top">
      <div class="container">
        <div class="navbar-header">
          <a href="{{ url(config('adminlte.dashboard_url', '/')) }}" class="navbar-brand">
            {!! config('adminlte.logo', '<b>Transportation</b>KXR') !!}
          </a>
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse">
            <i class="fa fa-bars"></i>
          </button>
        </div>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse pull-left" id="navbar-collapse">
          <ul class="nav navbar-nav">
            @each('adminlte::partials.menu-item-top-nav', $adminlte->menu(), 'item')
          </ul>
        </div>
        <!-- /.navbar-collapse -->
      @else
        <!-- Logo -->
          <a href="{{ url(config('adminlte.dashboard_url', '/')) }}" class="logo">
            <!-- mini logo for sidebar mini 50x50 pixels -->
            <span class="logo-mini">{!! config('adminlte.logo_mini', '<b>M</b>AT') !!}</span>
            <!-- logo for regular state and mobile devices -->
            <span class="logo-lg">{!! config('adminlte.logo', '<b>Transportation</b>') !!}</span>
          </a>

          <!-- Header Navbar -->
          <nav class="navbar navbar-static-top" role="navigation">
            <!-- Sidebar toggle button-->
            <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
              <span class="sr-only">{{ trans('adminlte::adminlte.toggle_navigation') }}</span>
            </a>
          @endif
          <!-- Navbar Right Menu -->
            <div class="navbar-custom-menu">

              <ul class="nav navbar-nav">
                <li>
                  @if(config('adminlte.logout_method') == 'GET' || !config('adminlte.logout_method') && version_compare(\Illuminate\Foundation\Application::VERSION, '5.3.0', '<'))
                    <a href="{{ url(config('adminlte.logout_url', 'auth/logout')) }}">
                      <i class="fa fa-fw fa-power-off"></i> {{ trans('adminlte::adminlte.log_out') }}
                    </a>
                  @else
                    <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                      <i class="fa fa-fw fa-power-off"></i> {{ trans('adminlte::adminlte.log_out') }}
                    </a>
                    <form id="logout-form" action="{{ url(config('adminlte.logout_url', 'auth/logout')) }}" method="POST" style="display: none;">
                      @if(config('adminlte.logout_method'))
                        {{ method_field(config('adminlte.logout_method')) }}
                      @endif
                      {{ csrf_field() }}
                    </form>
                  @endif
                </li>
              </ul>
            </div>
          @if(config('adminlte.layout') == 'top-nav')
      </div>
      @endif
    </nav>
</header>

@if(config('adminlte.layout') != 'top-nav')
  <!-- Left side column. contains the logo and sidebar -->
  <aside class="main-sidebar">

    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
            <!-- Sidebar Menu -->
            <ul class="sidebar-menu" data-widget="tree">
                <li class="header">MAIN NAVIGATION</li>
                <li class="treeview">
                    <a href="">
                        <i class="fa fa-fw fa-file "></i>
                        <span>Setups</span>
                        <span class="pull-right-container">
                    <span class="label label-success pull-right"></span>
                            <i class="fa fa-angle-left pull-right"></i>
                </span>
                    </a>
                    <ul class="treeview-menu">
                        <li class="">
                            <a href="{{url('/airlineinfo')}}">
                                <i class="fa fa-fw fa-circle-o "></i>
                                <span>Supplier</span>
                            </a>
                        </li>
                        <li class="">
                            <a href="{{url('/clientinfo')}}">
                                <i class="fa fa-fw fa-circle-o "></i>
                                <span>Client</span>
                            </a>
                        </li>
                        <li class="">
                            <a href="{{url('/bankaccountinfo')}}">
                                <i class="fa fa-fw fa-circle-o "></i>
                                <span>Bank data</span>
                            </a>
                        </li>
                        {{--<li class="">--}}
                            {{--<a href="{{url('/countryinfo')}}">--}}
                                {{--<i class="fa fa-fw fa-circle-o "></i>--}}
                                {{--<span>Country</span>--}}
                            {{--</a>--}}
                        {{--</li>--}}
                        {{--<li class="">--}}
                            {{--<a href="{{url('/cityinfo')}}">--}}
                                {{--<i class="fa fa-fw fa-circle-o "></i>--}}
                                {{--<span>City</span>--}}
                            {{--</a>--}}
                        {{--</li>--}}
                        {{--<li class="">--}}
                            {{--<a href="{{url('/commissioninfo')}}">--}}
                                {{--<i class="fa fa-fw fa-circle-o "></i>--}}
                                {{--<span>Commission Details</span>--}}
                            {{--</a>--}}
                        {{--</li>--}}
                        <li class="">
                            <a href="{{url('/accountinfo')}}">
                                <i class="fa fa-fw fa-circle-o "></i>
                                <span>Accounts</span>
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="treeview">
                    <a href="">
                        <i class="fa fa-fw fa-file "></i>
                        <span>Ticket Reservation</span>
                        <span class="pull-right-container">
                    <span class="label label-success pull-right"></span>
                            <i class="fa fa-angle-left pull-right"></i>
                </span>
                    </a>
                    <ul class="treeview-menu">
                        <li class="">
                            <a href="{{url('/ticketreservationinfo')}}">
                                <i class="fa fa-fw fa-circle-o "></i>
                                <span>Ticket Reservation</span>
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="treeview">
                    <a href="">
                        <i class="fa fa-fw fa-file "></i>
                        <span>Transaction</span>
                        <span class="pull-right-container">
                    <span class="label label-success pull-right"></span>
                            <i class="fa fa-angle-left pull-right"></i>
                </span>
                    </a>
                    <ul class="treeview-menu">
                        <li class="">
                            <a href="{{url('/airlinepaymentinfo')}}">
                                <i class="fa fa-fw fa-circle-o "></i>
                                <span>Supplier Deposit Slip</span>
                            </a>
                        </li>
                        <li class="">
                            <a href="{{url('/supplierrefundinfo')}}">
                                <i class="fa fa-fw fa-circle-o "></i>
                                <span>Supplier Refund</span>
                            </a>
                        </li>
                        <li class="">
                            <a href="{{url('/clientreceiptinfo')}}">
                                <i class="fa fa-fw fa-circle-o "></i>
                                <span>Client Cash Receipt</span>
                            </a>
                        </li>
                        <li class="">
                            <a href="{{url('/clientrefundinfo')}}">
                                <i class="fa fa-fw fa-circle-o "></i>
                                <span>Client Refund</span>
                            </a>
                        </li>
                        <li class="">
                            <a href="{{url('/bankstatmentinfo')}}">
                                <i class="fa fa-fw fa-circle-o "></i>
                                <span>Bank Transaction</span>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="treeview">
                    <a href="">
                        <i class="fa fa-fw fa-file "></i>
                        <span>Report</span>
                        <span class="pull-right-container">
                    <span class="label label-success pull-right"></span>
                            <i class="fa fa-angle-left pull-right"></i>
                </span>
                    </a>
                    <ul class="treeview-menu">
                        <li class="">
                            <a href="{{url('/totalbalanceclientreport')}}">
                                <i class="fa fa-fw fa-circle-o "></i>
                                <span>Total Balance Client</span>
                            </a>
                        </li>
                        <li class="">
                            <a href="{{url('/supplierledgerreport')}}">
                                <i class="fa fa-fw fa-circle-o "></i>
                                <span>Supplier Ledger</span>
                            </a>
                        </li>
                        <li class="">
                            <a href="{{url('/clientledgerreport')}}">
                                <i class="fa fa-fw fa-circle-o "></i>
                                <span>Client Ledger</span>
                            </a>
                        </li>
                        <li class="">
                            <a href="{{url('/dailyreservationreport')}}">
                                <i class="fa fa-fw fa-circle-o "></i>
                                <span>Daily Reservation</span>
                            </a>
                        </li>
                        <li class="">
                            <a href="{{url('/profitandlossreport')}}">
                                <i class="fa fa-fw fa-circle-o "></i>
                                <span>Profit/Loss Report</span>
                            </a>
                        </li>
                        <li class="">
                            <a href="{{url('/bankstatmentreport')}}">
                                <i class="fa fa-fw fa-circle-o "></i>
                                <span>Bank Statment</span>
                            </a>
                        </li>
                    </ul>
                </li>

                @if(App\Helper\Common::userwisepermission(Auth::user()->id, "User List") || App\Helper\Common::userwisepermission(Auth::user()->id, "Role List") || App\Helper\Common::userwisepermission(Auth::user()->id, "Permission List"))
                    <li class="treeview">
                    <a href="">
                        <i class="fa fa-fw fa-file "></i>
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
                              <a href="{{url('/roles')}}">
                                  <i class="fa fa-fw fa-circle-o "></i>
                                  <span>Role</span>
                              </a>
                          </li>
                            @endif
                            {{--@if(App\Helper\Common::userwisepermission(Auth::user()->id, "Permission List"))--}}
                          {{--<li class="">--}}
                              {{--<a href="{{url('/permissions')}}">--}}
                                  {{--<i class="fa fa-fw fa-circle-o "></i>--}}
                                  {{--<span>Permissions</span>--}}
                              {{--</a>--}}
                          {{--</li>--}}
                            {{--@endif--}}
                      </ul>
                  </li>
                @endif
            <!--li class="header">ACCOUNT SETTINGS</li>
                  <li class="">
                      <a href="http://localhost:9091/linkconsultant1/admin/settings">
                          <i class="fa fa-fw fa-user "></i>
                          <span>Profile</span>
                      </a>
                  </li>
                  <li class="">
                      <a href="http://localhost:9091/linkconsultant1/admin/settings">
                          <i class="fa fa-fw fa-lock "></i>
                          <span>Change Password</span>
                      </a>
                  </li-->
                  <!--li class="treeview">
                      <a href="#">
                          <i class="fa fa-fw fa-share "></i>
                          <span>Multilevel</span>
                          <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                  </span>
                      </a>
                      <ul class="treeview-menu">
                          <li class="">
                              <a href="#">
                                  <i class="fa fa-fw fa-circle-o "></i>
                                  <span>Level One</span>
                              </a>
                          </li>
                          <li class="treeview">
                              <a href="#">
                                  <i class="fa fa-fw fa-circle-o "></i>
                                  <span>Level One</span>
                                  <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                  </span>
                              </a>
                              <ul class="treeview-menu">
                                  <li class="">
                                      <a href="#">
                                          <i class="fa fa-fw fa-circle-o "></i>
                                          <span>Level Two</span>
                                      </a>
                                  </li>
                                  <li class="treeview">
                                      <a href="#">
                                          <i class="fa fa-fw fa-circle-o "></i>
                                          <span>Level Two</span>
                                          <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                  </span>
                                      </a>
                                      <ul class="treeview-menu">
                                          <li class="">
                                              <a href="#">
                                                  <i class="fa fa-fw fa-circle-o "></i>
                                                  <span>Level Three</span>
                                              </a>
                                          </li>
                                          <li class="">
                                              <a href="#">
                                                  <i class="fa fa-fw fa-circle-o "></i>
                                                  <span>Level Three</span>
                                              </a>
                                          </li>
                                      </ul>
                                  </li>
                              </ul>
                          </li>
                          <li class="">
                              <a href="#">
                                  <i class="fa fa-fw fa-circle-o "></i>
                                  <span>Level One</span>
                              </a>
                          </li>
                      </ul>
                  </li>
                  <li class="header">LABELS</li>
                  <li class="">
                      <a href="#">
                          <i class="fa fa-fw fa-circle-o text-red"></i>
                          <span>Important</span>
                      </a>
                  </li>
                  <li class="">
                      <a href="#">
                          <i class="fa fa-fw fa-circle-o text-yellow"></i>
                          <span>Warning</span>
                      </a>
                  </li>
                  <li class="">
                      <a href="#">
                          <i class="fa fa-fw fa-circle-o text-aqua"></i>
                          <span>Information</span>
                      </a>
                  </li-->
              </ul>
              <!-- /.sidebar-menu -->
          </section>
        <!-- Sidebar Menu -->
      {{--<ul class="sidebar-menu" data-widget="tree">--}}
      {{--@each('adminlte::layouts.partials.menu-item', $adminlte->menu(), 'item')--}}
      {{--</ul>--}}
      <!-- /.sidebar-menu -->
      </section>
      <!-- /.sidebar -->
    </aside>
  @endif