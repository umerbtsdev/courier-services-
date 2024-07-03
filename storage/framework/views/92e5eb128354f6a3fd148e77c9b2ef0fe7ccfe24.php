<?php $__env->startSection('content'); ?>

<div class = 'container-fluid'>
    <div class="col-md-12">
        <div class="flash-message">

            <!-- <?php $__currentLoopData = ['danger', 'warning', 'success', 'info']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $msg): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php if(Session::has('alert-' . $msg)): ?>

                    <p class="alert alert-<?php echo e($msg); ?>"><?php echo e(Session::get('alert-' . $msg)); ?> <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a></p>
                <?php endif; ?>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?> -->

        </div> <!-- end .flash-message -->
    </div>
    <div class="row custom-container-wrap">
        <div class="col-md-12">
                
            <div class="page-heading-primary">
                <span>

                </span>
                <h1>
                    <b>All Permisions</b>

                    <a href="<?php echo e(url('permissions/create')); ?>" class = "float-right btn-cus-dessign btn btn-primary waves-effect waves-light">
                    	Add New Permission
                    </a>
                </h1>
            </div>
            
        </div>


            <div class="col-md-12 custom-table-styles">
                <table class="table table-striped tbl-user-styled">
    				<head>
    					<th>Permissions</th>
    					<th>Actions</th>
    				</head>
    				<tbody>
    					<?php $__currentLoopData = $permissions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $permission): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    					<tr>
    						<td style="text-align: right; width: 50%" class="user-col-1"><?php echo e($permission->name); ?></td>
    						<td style="width: 50%">
    							<a href="<?php echo e(url('/permissions/edit')); ?>/<?php echo e($permission->id); ?>" style="display: inline-block; padding: 5px 10px;" class = "btn-cus-dessign btn btn-primary waves-effect waves-light"> Edit Permision </a>
    							<a href="<?php echo e(url('/permissions/delete')); ?>/<?php echo e($permission->id); ?>" style="display: inline-block; padding: 5px 10px;" class = "btn-cus-dessign btn btn-primary waves-effect waves-light"> Delete Permision </a>
    						</td>
    					</tr>
    					<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    				</tbody>
    			</table>
            </div>

    </div>
</div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>