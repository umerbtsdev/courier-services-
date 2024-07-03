@extends('layouts.app')
@section('content')
<section class="content">

	<div class="page-heading-primary">
	    <span>

	    </span>
	    <h1>
	        <b>Edit Permission</b>
	    </h1>
	</div>

	<div class="bgcolr-grey">
		<div class="box-body">
			<form action="{{url('permissions/update')}}" method = "post">
				{!! csrf_field() !!}
				<input type="hidden" name = "permission_id" value = "{{$permission->id}}">
				<div class="form-group">
				<label for=""> Available Permission </label>
					<input type="text" name = "name" class = "form-control" placeholder = "Name" value = "{{$permission->name}}">
				</div>
				<div class="box-footer">
					<button class = 'btn-cus-dessign btn btn-primary waves-effect waves-light' type = "submit">Update</button>
				</div>
			</form>
		</div>
	</div>
</section>
@endsection
