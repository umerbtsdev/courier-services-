
	<div class="page-heading-primary">
	    
	</div>

	<div class="bgcolr-grey">
		 <?php if(Request::session()->has('user_create_status')): ?>
	      <?php if(Request::session()->pull('user_create_status') == 'error'): ?>
	      <div class="alert alert-danger"><?php echo e(Request::session()->pull('user_create_message')); ?></div>
	      <?php endif; ?>   
	     <?php endif; ?>
		<div class="box-body">

				<?php echo Form::open(array('url'=>'setup/workshops/service/update','method'=>'POST','id'=>'workshop-form', 'class'=>"form-horizontal", 'files' => false)); ?>

				
				
				<?php echo Form::hidden("service_id", $services->id); ?>

	<div class="row">
				<div class="form-group col-sm-12">
                    <label for="service_name" class="control-label">Service Name:</label>

                        <?php echo Form::textarea("service_name", $services->service_name, ["id"=>"service_name", "class"=>"form-control input-form-textarea", "required"=>true, "Rows"=>1, "style"=>"resize:none",'maxlength'=>100,"minlength"=>3]); ?>


				</div>
	</div>
<div class="row">
                
				<div class="form-group col-md-12" style="">
                        <br/>
                        <br/>
                    <button style="float:left" class = " btn-cus-dessign btn btn-primary waves-effect waves-light" type="submit">Update Service</button>
				</div>
</div>
			</form>
		</div>
	</div>



