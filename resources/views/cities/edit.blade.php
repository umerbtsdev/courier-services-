<div class="page-heading-primary">
	    <h2>
	        <b> Update City </b>
	    </h2>
	</div>
	<div class="bgcolr-grey">
		<div class="box-body">
			<form action="{{url('setup/city/update/'.$city->id)}}" method = "post"  autocomplete="off">
				{!! csrf_field() !!}
				<input type="hidden" name = "alert_id" value = "{{$city->id}}">
				<div class="row">
				<div class="form-group col-md-6">
					<label for="">Country</label>
					<select name = "country_id" id="country_id" class = "form-control" required="true">
						<option value=""> Select Country </option>
						@foreach($countries as $country)
							@if($city->country_id == $country->id)
								<option value="{{$country->id}}" selected="selected"> {{$country->name}} </option>
							@else
								<option value="{{$country->id}}"> {{$country->name}} </option>
							@endif

						@endforeach
					</select>

				</div>
				<div class="form-group col-md-6">
					<label for="">Name</label>
					<input type="text" name = "name" value = "{{$city->name}}" class = "form-control" required>
				</div>
				</div>
				<button style="float: right;" class = "btn-cus-dessign btn btn-primary waves-effect waves-light" type="submit">Update</button>
			</form>
		</div>
	</div>

