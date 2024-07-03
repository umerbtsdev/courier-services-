
	<div class="page-heading-primary">
	    
	</div>

	<div class="bgcolr-grey">
		 @if(Request::session()->has('user_create_status'))
	      @if(Request::session()->pull('user_create_status') == 'error')
	      <div class="alert alert-danger">{{Request::session()->pull('user_create_message')}}</div>
	      @endif   
	     @endif
		<div class="box-body">

			{!! Form::open(array('url'=>'/workshops/parts/update','method'=>'POST','id'=>'workshop-form', 'class'=>"form-horizontal", 'files' => false)) !!}
			
			{!! Form::hidden("part_id", $parts->part_id) !!}
			
				<div class="col-sm-6">
					<div class="form-group col-sm-12">
						<label for="m_id" class="control-label col-sm-4">Manufacturer:</label>
						<div class="col-sm-8">
							{!! Form::select("m_id", $manufacturers, $parts->manufacturer_id, ["id"=>"m_id", "class"=>"form-control"]) !!}
						</div>
					</div>
					<div class="form-group col-sm-12">
						<label for="part-name" class="control-label col-sm-4">Name:</label>
						<div class="col-sm-8">
							{!! Form::textarea("part_name", $parts->part_name, ["id"=>"part-name", "class"=>"col-sm-4 form-control input-form-textarea", "required"=>true, "Rows"=>1, "style"=>"resize:none",'maxlength'=>150,"minlength"=>3]) !!}
						</div>
					</div>
				</div>
				<div class="form-group col-md-12" style="">
					<br/>
					<br/>
					<button style="float:left" class = "custom-btn-action custom-btn-view bgcolr-orange no-margin" type="submit">Update Part</button>
				</div>
			{!! Form::close() !!}
		</div>
	</div>



