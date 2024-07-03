<?php $__env->startSection('content'); ?>
<section class="content">

	<div class="page-heading-primary">
	    <span>

	    </span>
	    <h1>
	        <b>Edit Permission</b>
	    </h1>
	</div>

	<div class="bgcolr-grey">
		<div class="box-body">
			<form action="<?php echo e(url('permissions/update')); ?>" method = "post">
				<?php echo csrf_field(); ?>

				<input type="hidden" name = "permission_id" value = "<?php echo e($permission->id); ?>">
				<div class="form-group">
				<label for=""> Available Permission </label>
					<input type="text" name = "name" class = "form-control" placeholder = "Name" value = "<?php echo e($permission->name); ?>">
				</div>
				<div class="box-footer">
					<button class = 'btn-cus-dessign btn btn-primary waves-effect waves-light' type = "submit">Update</button>
				</div>
			</form>
		</div>
	</div>
</section>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>