<?php $__env->startSection('content'); ?>
<section class="content">
	<div class="page-heading-primary">
	    <span>
	        <a href="#"> <i class="fa fa-home"></i> </a>
	        <i class="fa fa-angle-right"> &nbsp; </i>
	        <b> Users </b>
	    </span>
	    <h1>
	        <b>Edit Role </b>
	    </h1>
	</div>

	<div class="bgcolr-grey">
		
		<div class="box-body">
			<form action="<?php echo e(url('roles/update')); ?>" method = "post">
				<?php echo csrf_field(); ?>

				<input type="hidden" name = "role_id" value = "<?php echo e($role->id); ?>">
				<div class="form-group">
				<label for="">Role</label>
					<input type="text" name = "name" class = "form-control" placeholder = "Name" value = "<?php echo e($role->name); ?>">
				</div>
				<div class="box-footer">
					<button class = 'custom-btn-action custom-btn-view bgcolr-orange no-margin' type = "submit">Update</button>
				</div>
			</form>
		</div>
	</div>

	<div class="row">
		<div class="col-md-12">

			<div class="page-heading-primary">
			    <h1>
			        <b> <?php echo e($role->name); ?> Permissions </b>
			    </h1>
			</div>

			<div class="bgcolr-grey">
				<div class="box-body">
					<form action="<?php echo e(url('roles/addPermission')); ?>" method = "post">
						<?php echo csrf_field(); ?>

						<input type="hidden" name = "role_id" value = "<?php echo e($role->id); ?>">
						<div class="form-group">
							<select name="permission_name" id="" class = "form-control">
								<option> select permission </option>
								<?php $__currentLoopData = $permissions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $permission): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
									<option value="<?php echo e($permission->name); ?>"><?php echo e($permission->name); ?></option>
								<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
							</select>
						</div>
						<div class="form-group">
							<button class = 'custom-btn-action custom-btn-view bgcolr-orange no-margin'>Add permission</button>
						</div>
					</form>
					<table class = 'table table-striped'>
						<thead>
						<th>Permission</th>
						<th>Action</th>
						</thead>
						<tbody>
						<?php $__currentLoopData = $userPermissions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $permission): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
							<tr>
								<td><?php echo e($permission->name); ?></td>
								<td><a href="<?php echo e(url('roles/removePermission')); ?>/<?php echo e(str_slug($permission->name,'-')); ?>/<?php echo e($role->id); ?>" class = "custom-btn-action custom-btn-view bgcolr-red no-margin" style="display: inline-block;"> Delete </a></td>
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


<?php echo $__env->make('adminlte::layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>