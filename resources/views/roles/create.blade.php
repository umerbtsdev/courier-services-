@extends('layouts.app')
@section('content')
<section class="content">
	<div class="page-heading-primary">
	    <span>
	        <a href="#"> <i class="fa fa-home"></i> </a>
	        <i class="fa fa-angle-right"> &nbsp; </i>
	        <b> Users </b>
	    </span>
	    <h1>
	        <b>Create Role </b>
	    </h1>
	</div>
	<div class="bgcolr-grey">
		<div class="box-body">
			<form action="{{url('roles/store')}}" method = "post">
				{!! csrf_field() !!}
				<div class="form-group">
				<label for="">Role</label>
					<input type="text" name = "name" class = "form-control" placeholder = "Name">
				</div>
				<div class="box-footer">
					<button class = 'btn-cus-dessign btn btn-primary waves-effect waves-light' type = "submit">Create Role</button>
				</div>
			</form>
		</div>
	</div>
</section>
@endsection
