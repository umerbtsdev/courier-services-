@extends('layouts.app')
@section('content')

<div class = 'container-fluid'>
    <div class="col-md-12">
        <div class="flash-message">

            <!-- @foreach (['danger', 'warning', 'success', 'info'] as $msg)
                @if(Session::has('alert-' . $msg))

                    <p class="alert alert-{{ $msg }}">{{ Session::get('alert-' . $msg) }} <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a></p>
                @endif
            @endforeach -->

        </div> <!-- end .flash-message -->
    </div>
    <div class="row custom-container-wrap">
        <div class="col-md-12">
                
            <div class="page-heading-primary">
                <span>

                </span>
                <h1>
                    <b>All Roles</b>

                    <a href="{{url('roles/create')}}" class = "float-right btn-cus-dessign btn btn-primary waves-effect waves-light">
                    	Add New Role
                    </a>
                </h1>
            </div>
            
        </div>

        <div class="custom-inner-container-wrap">
            <div class="col-md-12 custom-table-styles">
                <table class="table table-striped tbl-user-styled">
    				<head>
    					<th>User Roles</th>
    					<th>Permissions Granted</th>
    					<th>Actions</th>
    				</head>
    				<tbody>
    					@foreach($roles as $role)
    					<tr>
    						<td class="user-col-1" width="250">{{$role->name}}</td>
    						<td>
    							@if(!empty($role->permissions))
    								@foreach($role->permissions as $permission)
    									<span class="user-roles bgcolr-aqua">{{$permission->name}}</span>
    								@endforeach
    							@else
    								<small class = 'label bg-red'>No Permissions</small>
    							@endif
    						</td>
    						<td width="150">
    							<a href="{{url('/roles/edit')}}/{{$role->id}}" class = "btn-cus-dessign btn btn-primary waves-effect waves-light"> Edit Role </a>
    							<a href="{{url('/roles/delete')}}/{{$role->id}}" class = "btn-cus-dessign btn btn-primary waves-effect waves-light"> Delete Role </a>
    						</td>
    					</tr>
    					@endforeach
    				</tbody>
    			</table>
            </div>
        </div>
    </div>
</div>

@endsection