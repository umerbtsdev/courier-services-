@extends('layouts.app')
@section('content')
<section class="content">
	<div class="page-heading-primary">
	    <span>
	        <a href="#"> <i class="fa fa-home"></i> </a>
	        <i class="fa fa-angle-right"> &nbsp; </i>
	        <b> Change Password </b>
	    </span>
	    <h1>
	        <b> Users ({{$user->name}}) </b>
	    </h1>
	</div>

	<div class="bgcolr-grey">
		
		 @if(Request::session()->has('user_changepassword_status'))
		 <?php  $status = Request::session()->pull('user_changepassword_status'); ?>
		 @foreach(Request::session()->pull('user_changepassword_message') as $value)
	      @if($status == 'error')
	      <div class="alert-danger">*{{$value}}</div>
	      @else
	      <div class="alert-success">
	      {{$value}} Do you want to  <a href="{{url('logout')}}" class=""
                                       onclick="event.preventDefault();
											document.getElementById('logout-form').submit();">Sign out</a>
                                    <form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
                                        {{ csrf_field() }}
         </form>

	      </div>
	      @endif  
	      @endforeach
		@endif 


		<div class="box-body">
			<form action="{{url('users/changepassword')}}" method = "post"  autocomplete="off" id="changePasswordForm" 	>
				{!! csrf_field() !!}
				
				<div class="form-group">
					<label for="">Old Password</label>
					<input type="password" name = "old_password"  class = "form-control" required>
				</div>
				<div class="form-group">
					<label for="">New Password</label>
					<input type="password" name = "new_password" class = "form-control" required>
				</div>
				<div class="form-group">
					<label for="">Confirm New Password</label>
					<input type="password" name = "c_new_password" class = "form-control" required>
				</div>
				<button type="submit" class = "custom-btn-action custom-btn-view bgcolr-orange no-margin" type="submit"> Update Password </button>
			</form>
		</div>
	</div>
</section>

@endsection