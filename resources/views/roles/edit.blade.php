@extends('layouts.app')
@section('content')
<section class="content">
	<div class="page-heading-primary">
	    <span>

	    </span>
	    <h1>
	        <b>Edit Role </b>
	    </h1>
	</div>

	<div class="bgcolr-grey">
		
		<div class="box-body">
			<form action="{{url('roles/update')}}" method = "post">
				{!! csrf_field() !!}
				<input type="hidden" name = "role_id" value = "{{$role->id}}">
				<div class="form-group">
				<label for="">Role</label>
					<input type="text" name = "name" class = "form-control" placeholder = "Name" value = "{{$role->name}}">
				</div>
				<div class="box-footer">
					<button class = 'btn-cus-dessign btn btn-primary waves-effect waves-light' type = "submit">Update</button>
				</div>
			</form>
		</div>
	</div>

	<div class="row">
		<div class="col-md-12">

			<div class="page-heading-primary">
			    <h1>
			        <b> {{$role->name}} Permissions </b>
			    </h1>
			</div>

			<div class="bgcolr-grey">
				<div class="box-body">
					<form action="{{url('roles/addPermission')}}" method = "post">
						{!! csrf_field() !!}
						<input type="hidden" name = "role_id" value = "{{$role->id}}">
						<div class="form-group">
							<select name="permission_name" id="" class = "form-control">
								<option> select permission </option>
								@foreach($permissions as $permission)
									<option value="{{$permission->name}}">{{$permission->name}}</option>
								@endforeach
							</select>
						</div>
						<div class="form-group">
							<button class = 'btn-cus-dessign btn btn-primary waves-effect waves-light'>Add permission</button>
						</div>
					</form>
					<table class = 'table table-striped'>
						<thead>
						<th>Permission</th>
						<th>Action</th>
						</thead>
						<tbody>
						@foreach($userPermissions as $permission)
							<tr>
								<td>{{$permission->name}}</td>
								<td><a href="{{url('roles/removePermission')}}/{{str_slug($permission->name,'-')}}/{{$role->id}}" class = "custom-btn-action custom-btn-view bgcolr-red no-margin" style="display: inline-block;"> Delete </a></td>
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

