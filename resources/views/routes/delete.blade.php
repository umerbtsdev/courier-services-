
<div class="page-heading-primary">
	    <h2>
	        <b> Delete Route </b>
	    </h2>
	</div>
	<div class="bgcolr-grey">
		<div class="box-body">
			<form action="{{url('route/delete/'.$route->id)}}" method = "post"  autocomplete="off">
				{!! csrf_field() !!}

				
				<input type="hidden" name = "alert_id" value = "{{$route->id}}">
				<div style="color: red; margin-left: 5px">Do you Want to Delete this Record.</div>
				<div class="form-group col-md-12">
					<label for="">Name</label>
					<input type="text" disabled="disabled" name = "name" value = "{{$route->name}}" class = "form-control" required>
				</div>
				
				<button style="float: right;" class = "custom-btn-action custom-btn-view bgcolr-orange no-margin" type="submit">Delete</button>
			</form>
		</div>
	</div>
