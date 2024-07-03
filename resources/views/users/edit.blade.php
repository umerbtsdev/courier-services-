@extends('layouts.app')
@section('content')
<section class="content">

	<div class="page-heading-primary">
	    <span>
	        <a href="#"> <i class="fa fa-home"></i> </a>
	        <i class="fa fa-angle-right"> &nbsp; </i>
	        <b>Edit Users </b>
	    </span>
	    <h1>
	        <b>Edit User ({{$user->name}})</b>
	    </h1>
	</div>

	<div class="bgcolr-grey">
		<div class="box-body">
			<form action="{{url('users/update')}}" method = "post"  autocomplete="off">
				{!! csrf_field() !!}
				<input type="hidden" name = "user_id" value = "{{$user->id}}">
				<div class="form-group">
					<label for="">Email</label>
					<input type="email" name = "email" value = "{{$user->email}}" class = "form-control" required>
				</div>
				<div class="form-group">
					<label for="">Name</label>
					<input type="text" name = "name" value = "{{$user->name}}" class = "form-control" required>
				</div>
				<div class="form-group">
					<label for="">Password</label>
					<input type="password" name = "password" class = "form-control" autocomplete="new-password"  placeholder = "password" required>
				</div>
				<button class = "btn-cus-dessign btn btn-primary waves-effect waves-light" type="submit">Update</button>
			</form>
		</div>
	</div>

	<div class="page-heading-primary">
	    <h1>
	        <b>Edit Roles ({{$user->name}})</b>
	    </h1>
	</div>

	<div class="row">
		<div class="col-md-12">
			<div class="bgcolr-grey">
				<div class="box-body">
					<form action="{{url('users/addRole')}}" method = "post">
						{!! csrf_field() !!}
						<input type="hidden" name = "user_id" value = "{{$user->id}}">
						<div class="form-group">
							<select name="role_name" id="" class = "form-control">
								@foreach($roles as $role)
								<option value="{{$role}}">{{$role}}</option>
								@endforeach
							</select>
						</div>
						<div class="form-group">
							<button class = 'btn-cus-dessign btn btn-primary waves-effect waves-light'>Add role</button>
						</div>
					</form>
					<table class = 'table table-striped'>
						<thead>
							<th>Role</th>
							<th>Action</th>
						</thead>
						<tbody>
							@foreach($userRoles as $role)
							<tr>
								<td>{{$role->name}}</td>
								<td><a href="{{url('users/removeRole')}}/{{$role->id,'-'}}/{{$user->id}}" class = "custom-btn-action custom-btn-view btn-danger no-margin" style="display: inline-block"> Delete </a></td>
							</tr>
							@endforeach
						</tbody>
					</table>
				</div>
			</div>
		</div>

	</div>
</section>
@endsection
