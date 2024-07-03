
<div class="page-heading-primary">
	    <h2>
	        <b> Delete Alert </b>
	    </h2>
	</div>
	<div class="bgcolr-grey">
		<div class="box-body">
			<form action="<?php echo e(url('setup/city/delete/'.$city->id)); ?>" method = "post"  autocomplete="off">
				<?php echo csrf_field(); ?>


				
				<input type="hidden" name = "alert_id" value = "<?php echo e($city->id); ?>">
				<div style="color: red; margin-left: 5px">Do you Want to Delete this Record.</div>
				<div class="row" >
					<div class="form-group col-md-6">
						<label for="">Country</label>
						<select disabled="disabled" name = "country_id" id="country_id" class = "form-control" required="true">
							<?php $__currentLoopData = $countries; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $country): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
								<?php if($city->country_id == $country->id): ?>
									<option value="<?php echo e($country->id); ?>" selected="selected"> <?php echo e($country->name); ?> </option>

								<?php endif; ?>

							<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
						</select>

					</div>
					<div class="form-group col-md-6">
						<label for="">Name</label>
						<input type="text" disabled="disabled" name = "name" value = "<?php echo e($city->name); ?>" class = "form-control" required>
					</div>
				</div>

				<button class = "float-right btn-cus-dessign btn btn-primary waves-effect waves-light" type="submit">Delete</button>
			</form>
		</div>
	</div>

