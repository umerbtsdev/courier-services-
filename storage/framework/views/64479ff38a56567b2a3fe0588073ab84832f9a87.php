<div class="page-heading-primary">
	    <h2>
	        <b> Update City </b>
	    </h2>
	</div>
	<div class="bgcolr-grey">
		<div class="box-body">
			<form action="<?php echo e(url('setup/city/update/'.$city->id)); ?>" method = "post"  autocomplete="off">
				<?php echo csrf_field(); ?>

				<input type="hidden" name = "alert_id" value = "<?php echo e($city->id); ?>">
				<div class="row">
				<div class="form-group col-md-6">
					<label for="">Country</label>
					<select name = "country_id" id="country_id" class = "form-control" required="true">
						<option value=""> Select Country </option>
						<?php $__currentLoopData = $countries; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $country): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
							<?php if($city->country_id == $country->id): ?>
								<option value="<?php echo e($country->id); ?>" selected="selected"> <?php echo e($country->name); ?> </option>
							<?php else: ?>
								<option value="<?php echo e($country->id); ?>"> <?php echo e($country->name); ?> </option>
							<?php endif; ?>

						<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
					</select>

				</div>
				<div class="form-group col-md-6">
					<label for="">Name</label>
					<input type="text" name = "name" value = "<?php echo e($city->name); ?>" class = "form-control" required>
				</div>
				</div>
				<button style="float: right;" class = "btn-cus-dessign btn btn-primary waves-effect waves-light" type="submit">Update</button>
			</form>
		</div>
	</div>

