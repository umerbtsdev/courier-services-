
	<div class="page-heading-primary">
	    <h2>
	        <b> Disable Customer </b>
	    </h2>
	</div>

	<div class="bgcolr-grey">
		 @if(Request::session()->has('user_create_status'))
	      @if(Request::session()->pull('user_create_status') == 'error')
	      <div class="alert alert-danger">{{Request::session()->pull('user_create_message')}}</div>
	      @endif
	     @endif
		<div class="box-body">
			<form action="{{url('customer/disable-data/'.$customer->id)}}" method = "post"  autocomplete="off">
				{!! csrf_field() !!}
				<div class="row">
					<div class="form-group col-md-4">
						<label for="">First Name</label>
						<input type="text" name = "first_name" id="first_name" readonly="readonly" value="{{$customer->first_name}}" class = "form-control" placeholder = "first name" required="true">
					</div>
					<div class="form-group col-md-4">
						<label for="">Last Name</label>
						<input type="text" name = "last_name" id="last_name" readonly="readonly" value="{{$customer->last_name}}"  class = "form-control" placeholder = "last name" required="true">
					</div>
					<div class="form-group col-md-4">
						<label for="">Email</label>
						<input type="email" name="email" id="email" readonly="readonly" value="{{$customer->email}}"  class = "form-control" placeholder = "Email" required="true">
					</div>
				</div>
				<div class="row">
					<div class="form-group col-md-4">
						<label for="">Contact No</label>
						<input type="text" name="contact_no" id="contact_no" readonly="readonly" value="{{$customer->contact_no}}" class = "form-control" placeholder = "Contact No" required="true">
					</div>

					<div class="form-group col-md-4">
						<label for="">Alternate No</label>
						<input type="text" name="alernate_no" id="alernate_no" readonly="readonly" value="{{$customer->alernate_no}}"  class = "form-control" placeholder = "Phone No" required="true">
					</div>
					<div class="form-group col-md-4">
						<label for="">Country</label>
						<select name="country_id" id="country_id" readonly="readonly" class = "form-control" required="true">
							<option value=""> Select Country </option>
							@foreach($countries as $country)
								@if($country->id == $customer->country_id)
									<option value="{{$country->id}}" selected="selected">{{$country->name}}</option>
									@else
									<option value="{{$country->id}}" >{{$country->name}}</option>
									@endif

							@endforeach
						</select>
					</div>
				</div>
				<div class="row" >
					<div class="form-group col-md-4">
						<label for="">city</label>
						<select name="city_id" id="city_id" readonly="readonly" class = "form-control" required="true">
							<option value=""> Select City </option>
							@foreach($cities as $city)
								@if($city->id == $customer->city_id)
									<option value="{{$city->id}}" selected="selected">{{$city->name}}</option>
								@else
									<option value="{{$city->id}}">{{$city->name}}</option>
									@endif

							@endforeach
						</select>
					</div>
					<div class="form-group col-md-4">
						<label for="">CNIC</label>
						<input type="text" name="cnic" id="cnic" readonly="readonly" value="{{$customer->cnic}}" class = "form-control" placeholder = "Cnic" required="true">
					</div>
					<div class="form-group col-md-4">
						<label for="">Bank</label>
						<input type="text" name="bank_name" id="bank_name" readonly="readonly" value="{{$customer->bank_name}}" class = "form-control" placeholder = "Bank" required="true">
					</div>
				</div>
				<div class="row" >

					<div class="form-group col-md-4">
						<label for="">Branch</label>
						<input type="text" name="branch_name" id="branch_name" readonly="readonly" value="{{$customer->branch_name}}" class = "form-control" placeholder = "Branch" required="true">
					</div><div class="form-group col-md-4">
						<label for="">Account #</label>
						<input type="text" name="account_no" id="account_no" readonly="readonly" value="{{$customer->account_no}}"  class = "form-control" placeholder = "account no" required="true">
					</div>
				<div class="form-group col-md-4">
					<label for="">Account Title</label>
					<input type="text" name="account_title" id="account_title" readonly="readonly" value="{{$customer->account_title}}" class = "form-control" placeholder = "Account Title" required="true">
				</div>
					<div class="form-group col-md-4">
						<label for="">Birth Date</label>
						<input type="date" name="brith_date" id="brith_date" readonly="readonly" value="{{$customer->brith_date}}" class = "form-control" placeholder = "date of birth" required="true">
					</div>
					<div class="form-group col-md-4">
						<label for="">Anniversary Date</label>
						<input type="date" name="anniversary_date" readonly="readonly" value="{{$customer->anniversary_date}}" id="anniversary_date" class = "form-control" placeholder = "Phone No" required="true">
					</div>
				</div>
				<div class="row">
					<div class="form-group col-md-12">
						<label for="">Address</label>
						<input type="text" name="address" id="address" readonly="readonly" value="{{$customer->address}}" class = "form-control" placeholder = "Address" required="true">
					</div>
				</div>

				<button style="float: right;" class = "btn-cus-dessign btn btn-primary waves-effect waves-light" type="submit">Disable</button>
			</form>
		</div>
	</div>