
<div class="page-heading-primary">
	    <h2>
	        <b> Delete City </b>
	    </h2>
	</div>
	<div class="bgcolr-grey">
		<div class="box-body">
			<form action="{{url('setup/city/delete/'.$city->id)}}" method = "post"  autocomplete="off">
				{!! csrf_field() !!}

				
				<input type="hidden" name = "alert_id" value = "{{$city->id}}">
				<div style="color: red; margin-left: 5px">Do you Want to Delete this Record.</div>
				<div class="row" >
					<div class="form-group col-md-6">
						<label for="">Country</label>
						<select disabled="disabled" name = "country_id" id="country_id" class = "form-control" required="true">
							@foreach($countries as $country)
								@if($city->country_id == $country->id)
									<option value="{{$country->id}}" selected="selected"> {{$country->name}} </option>

								@endif

							@endforeach
						</select>

					</div>
					<div class="form-group col-md-6">
						<label for="">Name</label>
						<input type="text" disabled="disabled" name = "name" value = "{{$city->name}}" class = "form-control" required>
					</div>
				</div>

				<button class = "float-right btn-cus-dessign btn btn-primary waves-effect waves-light" type="submit">Delete</button>
			</form>
		</div>
	</div>

