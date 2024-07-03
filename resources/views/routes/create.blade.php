
	<div class="page-heading-primary">
	    <h2>
	        <b> Add New Route </b>
	    </h2>
	</div>

	<div class="bgcolr-grey">
		 @if(Request::session()->has('user_create_status'))
	      @if(Request::session()->pull('user_create_status') == 'error')
	      <div class="alert alert-danger">{{Request::session()->pull('user_create_message')}}</div>
	      @endif   
	     @endif
		<div class="box-body">
			<form action="{{url('route/store')}}" method = "post"  autocomplete="off">
				{!! csrf_field() !!}
				<input type="hidden" name = "user_id">
				<div class="form-group col-md-12">
					<label for="">Name</label>
					<input type="text" name = "name" class = "form-control" placeholder = "Name" required="true">
				</div>

				<button style="float: right;" class = "custom-btn-action custom-btn-view bgcolr-orange no-margin" type="submit">Add Route</button>
			</form>
		</div>
	</div>