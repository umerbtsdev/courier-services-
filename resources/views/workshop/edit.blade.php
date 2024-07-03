
	<div class="page-heading-primary">
	    
	</div>

	<div class="bgcolr-grey">
		 @if(Request::session()->has('user_create_status'))
	      @if(Request::session()->pull('user_create_status') == 'error')
	      <div class="alert alert-danger">{{Request::session()->pull('user_create_message')}}</div>
	      @endif   
	     @endif
		<div class="box-body">

				{!! Form::open(array('url'=>'workshops/setup/update','method'=>'POST','id'=>'workshop-form', 'class'=>"form-horizontal", 'files' => false)) !!}
                
                
                {!! Form::hidden("workshop_id", $workshop->workshop_id) !!}
                
                <div class="col-sm-6">            
                    <div class="form-group col-sm-12">
                        <label for="workshop_name" class="control-label col-sm-3">Name:</label>
                        <div class="col-sm-9">
                            {!! Form::textarea("workshop_name", $workshop->workshop_name, ["id"=>"workshop_name", "class"=>"col-sm-4 form-control input-form-textarea", "required"=>true, "Rows"=>1, "style"=>"resize:none",'maxlength'=>100,"minlength"=>5]) !!}
                        </div>
                    </div>
                    <div class="form-group col-sm-12">
                        <label for="workshop_location" class="control-label col-sm-3">Location:</label>
                        <div class="col-sm-9">
                            {!! Form::textarea("workshop_location", $workshop->workshop_location, ["id"=>"workshop_location", "class"=>"col-sm-4 form-control input-form-textarea", "Rows"=>1, "style"=>"resize:none",'maxlength'=>100,"minlength"=>5]) !!}
                        </div>
                    </div>
			  
                </div>
                
				<div class="form-group col-md-12" style="">
                        <br/>
                        <br/>
                    <button style="float:left" class = "custom-btn-action custom-btn-view bgcolr-orange no-margin" type="submit">Update Workshop</button>
				</div>
			</form>
		</div>
	</div>



