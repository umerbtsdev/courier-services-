
	<div class="page-heading-primary">
	    <h2>
	        <b> Add New City </b>
	    </h2>
	</div>

	<div class="bgcolr-grey">
		 <?php if(Request::session()->has('user_create_status')): ?>
	      <?php if(Request::session()->pull('user_create_status') == 'error'): ?>
	      <div class="alert alert-danger"><?php echo e(Request::session()->pull('user_create_message')); ?></div>
	      <?php endif; ?>   
	     <?php endif; ?>
		<div class="box-body">
			<form action="<?php echo e(url('setup/city/store')); ?>" method = "post"  autocomplete="off">
				<?php echo csrf_field(); ?>

				<div class="row">
				<div class="form-group col-md-6">
					<label for="">Country</label>
					<select name = "country_id" id="country_id" class = "form-control" required="true">
						<option value=""> Select Country </option>
						<?php $__currentLoopData = $countries; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $country): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
							<option value="<?php echo e($country->id); ?>"> <?php echo e($country->name); ?> </option>
						<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
					</select>
				</div>
				<div class="form-group col-md-6">
					<label for="">Name</label>
					<input type="text" name = "name" id="name" class = "form-control" placeholder = "Name" required="true">
				</div>
				</div>
				<button style="float: right;" class = " btn-cus-dessign btn btn-primary waves-effect waves-light" type="submit">Save</button>
			</form>
		</div>
	</div>