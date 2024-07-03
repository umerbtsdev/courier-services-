
<div class="page-heading-primary">
	    <h2>
	        <b> Delete Country </b>
	    </h2>
	</div>
	<div class="bgcolr-grey">
		<div class="box-body">
			<form action="{{url('setup/countries/delete/'.$countries->id)}}" method = "post"  autocomplete="off">
				{!! csrf_field() !!}

				
				<input type="hidden" name = "alert_id" value = "{{$countries->id}}">
				<div style="color: red; margin-left: 5px">Do you Want to Delete this Record.</div>
				<div class="form-group col-md-6">
					<label for="">Name</label>
					<input type="text" disabled="disabled" name = "name" value = "{{$countries->name}}" class = "form-control" required>
				</div>
				<button class = "float-right btn-cus-dessign btn btn-primary waves-effect waves-light" type="submit">Delete</button>
			</form>
		</div>
	</div>

