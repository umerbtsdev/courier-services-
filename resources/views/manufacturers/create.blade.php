<div class="page-heading-primary">
	
</div>

<div class="bgcolr-grey">
	@if(Request::session()->has('user_create_status'))
		@if(Request::session()->pull('user_create_status') == 'error')
			<div class="alert alert-danger">{{Request::session()->pull('user_create_message')}}</div>
		@endif   
	@endif
	<div class="box-body">

		{!! Form::open(array('url'=>'/workshops/Manufacturers/add','method'=>'POST','id'=>'workshop-form', 'class'=>"form-horizontal", 'files' => false)) !!}
			
			<div class="form-group col-sm-6">
			<label for="manu-name" class="control-label col-sm-2">Name:</label>
			<div class="col-sm-10">
			{!! Form::textarea("manufacturer_name", "", ["id"=>"manu-name", "class"=>"col-sm-4 form-control input-form-textarea", "required"=>true, "Rows"=>1, "style"=>"resize:none",'maxlength'=>100,"minlength"=>3]) !!}
			</div>
			</div>
		

		
			<div class="form-group col-md-12" style="">
			<br/>
			<br/>
			<button style="float:left" class = "custom-btn-action custom-btn-view bgcolr-orange no-margin" type="submit">Add Manufacturer</button>
			</div>
		</form>
	</div>
</div>



