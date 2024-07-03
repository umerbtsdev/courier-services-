
	<div class="page-heading-primary">

	</div>

	<div class="bgcolr-grey">
		@if(Request::session()->has('user_create_status'))
			@if(Request::session()->pull('user_create_status') == 'error')
				<div class="alert alert-danger">{{Request::session()->pull('user_create_message')}}</div>
			@endif
		@endif
		<div class="box-body">

			{!! Form::open(array('url'=>'setup/workshops/services/add','method'=>'POST','id'=>'workshop-form', 'class'=>"form-horizontal", 'files' => false)) !!}
			<div class="row">
			<div class="form-group col-sm-12">
				<label for="service_name" class="control-label">Name:</label>

					{!! Form::textarea("service_name", "", ["id"=>"service_name", "class"=>"form-control input-form-textarea", "required"=>true, "Rows"=>1, "style"=>"resize:none",'maxlength'=>100,"minlength"=>3]) !!}

			</div>
			</div>

<div class="row">
			<div class="form-group col-md-12" style="">

				<button style="float:left" class = "float-right btn-cus-dessign btn btn-primary waves-effect waves-light" type="submit">Add Service</button>
			</div>
</div>
			</form>
		</div>
	</div>





