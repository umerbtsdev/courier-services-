<?php $__env->startSection('content'); ?>
    <div class="row">
        <div class="col-md-12">

        	<div class="container">
        		<br>
        			<div class="row">
        				

				        <div class="col-md-3">
                              <button type="button" class="btn btn-block btn-default btn-sm hvr-bounce-in" href onclick="location.href='<?php echo e(url('transaction/bulkbooking')); ?>'">
        					 <img src="<?php echo e(url('dist/img')); ?>/icon-book-b-file.png"  alt="">
                            </button>
        				</div>

        				<div class="col-md-3">
                              <button type="button" class="btn btn-block btn-default btn-sm hvr-bounce-in" href onclick="location.href='<?php echo e(url('transaction/singlebooking')); ?>'">
        					  <img src="<?php echo e(url('dist/img')); ?>/icon-booking.png" alt="">
                            </button>
        				</div>

        				<div class="col-md-3">
        					  <img src="<?php echo e(url('dist/img')); ?>/icon-reports.png"  alt="">
        				</div>

        				<div class="col-md-3">
        					  <img src="<?php echo e(url('dist/img')); ?>/icon-setup.png"  alt="">
        				</div>

        			</div>
        	</div>
        



        </div>
    </div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>