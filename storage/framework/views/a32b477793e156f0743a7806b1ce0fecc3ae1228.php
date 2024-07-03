<?php $__env->startSection('content'); ?>
<section class="content">

	<div class="page-heading-primary">
	    <span>
	        <a href="#"> <i class="fa fa-home"></i> </a>
	        <i class="fa fa-angle-right"> &nbsp; </i>
	        <b>Edit Users </b>
	    </span>
	    <h1>
	        <b>Edit User (<?php echo e($user->name); ?>)</b>
	    </h1>
	</div>

	<div class="bgcolr-grey">
		<div class="box-body">
			<form action="<?php echo e(url('users/update')); ?>" method = "post"  autocomplete="off">
				<?php echo csrf_field(); ?>

				<input type="hidden" name = "user_id" value = "<?php echo e($user->id); ?>">
				<div class="form-group">
					<label for="">Email</label>
					<input type="email" name = "email" value = "<?php echo e($user->email); ?>" class = "form-control" required>
				</div>
				<div class="form-group">
					<label for="">Name</label>
					<input type="text" name = "name" value = "<?php echo e($user->name); ?>" class = "form-control" required>
				</div>
				<div class="form-group">
					<label for="">Password</label>
					<input type="password" name = "password" class = "form-control" autocomplete="new-password"  placeholder = "password" required>
				</div>
				<button class = "btn-cus-dessign btn btn-primary waves-effect waves-light" type="submit">Update</button>
			</form>
		</div>
	</div>

	<div class="page-heading-primary">
	    <h1>
	        <b>Edit Roles (<?php echo e($user->name); ?>)</b>
	    </h1>
	</div>

	<div class="row">
		<div class="col-md-12">
			<div class="bgcolr-grey">
				<div class="box-body">
					<form action="<?php echo e(url('users/addRole')); ?>" method = "post">
						<?php echo csrf_field(); ?>

						<input type="hidden" name = "user_id" value = "<?php echo e($user->id); ?>">
						<div class="form-group">
							<select name="role_name" id="" class = "form-control">
								<?php $__currentLoopData = $roles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $role): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
								<option value="<?php echo e($role); ?>"><?php echo e($role); ?></option>
								<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
							</select>
						</div>
						<div class="form-group">
							<button class = 'btn-cus-dessign btn btn-primary waves-effect waves-light'>Add role</button>
						</div>
					</form>
					<table class = 'table table-striped'>
						<thead>
							<th>Role</th>
							<th>Action</th>
						</thead>
						<tbody>
							<?php $__currentLoopData = $userRoles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $role): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
							<tr>
								<td><?php echo e($role->name); ?></td>
								<td><a href="<?php echo e(url('users/removeRole')); ?>/<?php echo e($role->id,'-'); ?>/<?php echo e($user->id); ?>" class = "custom-btn-action custom-btn-view btn-danger no-margin" style="display: inline-block"> Delete </a></td>
							</tr>
							<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
						</tbody>
					</table>
				</div>
			</div>
		</div>

	</div>
</section>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>