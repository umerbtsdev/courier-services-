
	<div class="page-heading-primary">
	    <h2>
	        <b> Add New City </b>
	    </h2>
	</div>

	<div class="bgcolr-grey">
		 @if(Request::session()->has('user_create_status'))
	      @if(Request::session()->pull('user_create_status') == 'error')
	      <div class="alert alert-danger">{{Request::session()->pull('user_create_message')}}</div>
	      @endif   
	     @endif
		<div class="box-body">
			<form action="{{url('setup/city/store')}}" method = "post"  autocomplete="off">
				{!! csrf_field() !!}
				<div class="row">
				<div class="form-group col-md-6">
					<label for="">Country</label>
					<select name = "country_id" id="country_id" class = "form-control" required="true">
						<option value=""> Select Country </option>
						@foreach($countries as $country)
							<option value="{{$country->id}}"> {{$country->name}} </option>
						@endforeach
					</select>
				</div>
				<div class="form-group col-md-6">
					<label for="">Name</label>
					<input type="text" name = "name" id="name" class = "form-control" placeholder = "Name" required="true">
				</div>
				</div>
				<button style="float: right;" class = " btn-cus-dessign btn btn-primary waves-effect waves-light" type="submit">Save</button>
			</form>
		</div>
	</div>