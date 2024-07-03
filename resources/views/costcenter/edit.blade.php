<div class="page-heading-primary">
	    <h2>
	        <b> Update Cost Center </b>
	    </h2>
	</div>
	<div class="bgcolr-grey">
		<div class="box-body">
			<form action="{{url('setup/costcenter/update/'.$customer->id)}}" method = "post"  autocomplete="off">
				{!! csrf_field() !!}
				<div class="row">
					<input type="hidden" name = "alert_id" value = "{{$customer->id}}">
					<div class="form-group col-md-6">
						<label for="">Name</label>
						<input type="text" name = "name" value = "{{$customer->name}}" class = "form-control" required>
					</div>
					<div class="form-group col-md-6">
						<label for="">Phone No</label>
						<input type="text" name="phone_no" id="phone_no" value = "{{$customer->phone_no}}" class = "form-control" placeholder = "Address" required="true">
					</div>

				</div>
				<div class="row">
					<div class="form-group col-md-12">
						<label for="">Address</label>
						<input type="text" name="address" id="address" value = "{{$customer->address}}" class = "form-control" placeholder = "Address" required="true">
					</div>
				</div>

				<button style="float: right;" class = "btn-cus-dessign btn btn-primary waves-effect waves-light" type="submit">Update</button>
			</form>
		</div>
	</div>

