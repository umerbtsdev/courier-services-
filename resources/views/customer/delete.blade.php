
<div class="page-heading-primary">
	    <h2>
	        <b> Delete Alert </b>
	    </h2>
	</div>
	<div class="bgcolr-grey">
		<div class="box-body">
			<form action="{{url('customer/delete/'.$customer->id)}}" method = "post"  autocomplete="off">
				{!! csrf_field() !!}

				
				<input type="hidden" name = "alert_id" value = "{{$customer->id}}">
				<div style="color: red; margin-left: 5px">Do you Want to Delete this Record.</div>
				<div class="form-group col-md-6">
					<label for="">Name</label>
					<input type="text" disabled="disabled" name = "name" value = "{{$customer->name}}" class = "form-control" required>
				</div>
				<div class="form-group col-md-6">
					<label for="">Phone No</label>
					<input type="text" disabled="disabled" name="phone_no" id="phone_no" value = "{{$customer->phone_no}}" class = "form-control" placeholder = "Address" required="true">
				</div>

				<div class="form-group col-md-6">
					<label for="">address</label>
					<input type="text" disabled="disabled" name="address" id="address" value = "{{$customer->address}}" class = "form-control" placeholder = "Address" required="true">
				</div>
				
				<button class = "custom-btn-action custom-btn-view bgcolr-orange no-margin" type="submit">Delete</button>
			</form>
		</div>
	</div>

