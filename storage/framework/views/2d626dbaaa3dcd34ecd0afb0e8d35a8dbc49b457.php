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
                    <a href="#"> <i class="fa fa-home"></i> </a>
                    <i class="fa fa-angle-right"> &nbsp; </i>
                    <b> Users </b>
                </span>
                <h1>
                    <b>All Roles</b>

                    <a href="<?php echo e(url('roles/create')); ?>" class = "custom-btn-action custom-btn-view bgcolr-orange">
                    	Add New Role
                    </a>
                </h1>
            </div>
            
        </div>

        <div class="custom-inner-container-wrap">
            <div class="col-md-12 custom-table-styles">
                <table class="table table-striped tbl-user-styled">
    				<head>
    					<th>User Roles</th>
    					<th>Permissions Granted</th>
    					<th>Actions</th>
    				</head>
    				<tbody>
    					<?php $__currentLoopData = $roles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $role): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    					<tr>
    						<td class="user-col-1" width="250"><?php echo e($role->name); ?></td>
    						<td>
    							<?php if(!empty($role->permissions)): ?>
    								<?php $__currentLoopData = $role->permissions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $permission): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    									<span class="user-roles bgcolr-aqua"><?php echo e($permission->name); ?></span>
    								<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    							<?php else: ?>
    								<small class = 'label bg-red'>No Permissions</small>
    							<?php endif; ?>
    						</td>
    						<td width="150">
    							<a href="<?php echo e(url('/roles/edit')); ?>/<?php echo e($role->id); ?>" class = "custom-btn-action custom-btn-view bgcolr-aqua"> Edit Role </a>
    							<a href="<?php echo e(url('/roles/delete')); ?>/<?php echo e($role->id); ?>" class = "custom-btn-action custom-btn-view bgcolr-orange"> Delete Role </a>
    						</td>
    					</tr>
    					<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    				</tbody>
    			</table>
            </div>
        </div>
    </div>
</div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('adminlte::layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>