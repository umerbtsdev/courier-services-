<?php $__env->startSection('content'); ?>
	<div class="page-heading-primary">
	    <span>
	      
	    </span>
	    <h1>
	        <b> Create New User </b>
	    </h1>
	</div>

	<div class="bgcolr-grey">
		 <?php if(Request::session()->has('user_create_status')): ?>
	      <?php if(Request::session()->pull('user_create_status') == 'error'): ?>
	      <div class="alert alert-danger"><?php echo e(Request::session()->pull('user_create_message')); ?></div>
	      <?php endif; ?>   
	     <?php endif; ?>
		<div class="box-body">
			<form action="<?php echo e(url('users/store')); ?>" method = "post"  autocomplete="off">
				<?php echo csrf_field(); ?>

				<input type="hidden" name = "user_id">
				<div class="form-group">
					<label for="">Email</label>
					<input type="email" name = "email" class = "form-control" placeholder = "Email" required="true">
				</div>
				<div class="form-group">
					<label for="">Name</label>
					<input type="text" name = "name" class = "form-control" placeholder = "Name" required="true">
				</div>
				<div class="form-group">
					<label for="">Password</label>
					<input type="password" name = "password" class = "form-control" autocomplete="new-password" placeholder = "Password" required="true">
				</div>
				<button class = "btn-cus-dessign btn btn-primary waves-effect waves-light" type="submit">Add User</button>
			</form>
		</div>
	</div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>