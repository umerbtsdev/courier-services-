
<div class="page-heading-primary">
	    <h2>
	        <b> Delete Alert </b>
	    </h2>
	</div>
	<div class="bgcolr-grey">
		<div class="box-body">
			<form action="<?php echo e(url('setup/countries/delete/'.$countries->id)); ?>" method = "post"  autocomplete="off">
				<?php echo csrf_field(); ?>


				
				<input type="hidden" name = "alert_id" value = "<?php echo e($countries->id); ?>">
				<div style="color: red; margin-left: 5px">Do you Want to Delete this Record.</div>
				<div class="form-group col-md-6">
					<label for="">Name</label>
					<input type="text" disabled="disabled" name = "name" value = "<?php echo e($countries->name); ?>" class = "form-control" required>
				</div>
				<button class = "float-right btn-cus-dessign btn btn-primary waves-effect waves-light" type="submit">Delete</button>
			</form>
		</div>
	</div>

