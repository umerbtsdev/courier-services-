<!-- Left side column. contains the logo and sidebar -->
<aside class="main-sidebar">

    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">

        <!-- Sidebar user panel (optional) -->
        @if (! Auth::guest())
            <div class="user-panel">
                <div class="pull-left image">
                    <img src="{{ Gravatar::get($user->email) }}" class="img-circle" alt="User Image" />
                </div>
                <div class="pull-left info">
                    <p>{{ Auth::user()->name }}</p>
                    <!-- Status -->
                    <a href="#"><i class="fa fa-circle text-success"></i> {{ trans('adminlte_lang::message.online') }}</a>
                </div>
            </div>
        @endif

        <!-- search form (Optional) -->
        <form action="#" method="get" class="sidebar-form">
            <div class="input-group">
                <input type="text" name="q" class="form-control" placeholder="{{ trans('adminlte_lang::message.search') }}..."/>
              <span class="input-group-btn">
                <button type='submit' name='search' id='search-btn' class="btn btn-flat"><i class="fa fa-search"></i></button>
              </span>
            </div>
        </form>
        <!-- /.search form -->

        <!-- Sidebar Menu -->
        <ul class="sidebar-menu">
            <li class="header">MAIN NAVIGATION</li>
			
			<?php  
				//if user is superadmin
				//if(Auth::user()->hasRole(Config::get('constants.superadminRole'))){
			?>
				<li class="active treeview">
					<a href="{{url('dashboard')}}">
						<i class="fa fa-dashboard"></i> <span>Dashboard</span></i>
					</a>
				</li>
				<li class="header">ADMINISTRATOR</li>
				<li class="treeview"><a href="{{url('/users')}}"><i class="fa fa-users"></i> <span>Users</span></a></li>
				<li class="treeview"><a href="{{url('/roles')}}"><i class="fa fa-user-plus"></i> <span>Role</span></a></li>
				<li class="treeview"><a href="{{url('/permissions')}}"><i class="fa fa-key"></i> <span>Permissions</span></a></li>
			<?php
				//}
			?>
        </ul><!-- /.sidebar-menu -->
    </section>
    <!-- /.sidebar -->
</aside>
