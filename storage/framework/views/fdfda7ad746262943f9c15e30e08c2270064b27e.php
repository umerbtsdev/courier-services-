<div class="page-heading-primary">
	    <h2>
	        <b> Update Country </b>
	    </h2>
	</div>
	<div class="bgcolr-grey">
		<div class="box-body">
			<form action="<?php echo e(url('setup/countries/update/'.$countries->id)); ?>" method = "post"  autocomplete="off">
				<?php echo csrf_field(); ?>

				<input type="hidden" name = "alert_id" value = "<?php echo e($countries->id); ?>">
				<div class="form-group col-md-6">
					<label for="">Name</label>
					<input type="text" name = "name" value = "<?php echo e($countries->name); ?>" class = "form-control" required>
				</div>
				<button style="float: right;" class = "btn-cus-dessign btn btn-primary waves-effect waves-light" type="submit">Update</button>
			</form>
		</div>
	</div>

