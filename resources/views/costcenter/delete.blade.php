
<div class="page-heading-primary">
	    <h2>
	        <b> Delete Cost Center </b>
	    </h2>
	</div>
	<div class="bgcolr-grey">
		<div class="box-body">
			<form action="{{url('setup/costcenter/delete/'.$customer->id)}}" method = "post"  autocomplete="off">
				{!! csrf_field() !!}

				
				<input type="hidden" name = "alert_id" value = "{{$customer->id}}">
				<div style="color: red; margin-left: 5px">Do you Want to Delete this Record.</div>
				<div class="row">
					<div class="form-group col-md-6">
						<label for="">Name</label>
						<input type="text" disabled="disabled" name = "name" value = "{{$customer->name}}" class = "form-control" required>
					</div>
					<div class="form-group col-md-6">
						<label for="">Phone No</label>
						<input type="text" disabled="disabled" name="phone_no" id="phone_no" value = "{{$customer->phone_no}}" class = "form-control" placeholder = "Address" required="true">
					</div>

				</div>
<div class="row">
	<div class="form-group col-md-12						">
		<label for="">Address</label>
		<input type="text" disabled="disabled" name="address" id="address" value = "{{$customer->address}}" class = "form-control" placeholder = "Address" required="true">
	</div>

</div>

				<button class = "btn-cus-dessign btn btn-primary waves-effect waves-light" type="submit">Delete</button>
			</form>
		</div>
	</div>

