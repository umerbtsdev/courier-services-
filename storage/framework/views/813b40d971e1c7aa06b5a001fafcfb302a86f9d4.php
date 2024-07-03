<ul>
    <?php $__currentLoopData = $childs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $child): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <?php if(count($child->childs)): ?>
            <li  rel="<?php echo e($child->id."|".$child->name."|".$child->op_cr."|".$child->op_dr."|".$child->parent_id."|".$child->level); ?>">
                    <a href="" class="no-click"><?php echo $child->name; ?> <?php echo e(count($child->childs) >0 ? "(".count($child->childs).")":""); ?> </a>
            <?php echo $__env->make('finance.chartOfAccount.childmenu',["childs"=>$child->childs], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
            </li>
        <?php else: ?>    
        <li rel="<?php echo e($child->id."|".$child->name."|".$child->op_cr."|".$child->op_dr ."|".$child->parent_id."|".$child->level); ?>"> 
            <a href="" class="no-click"><?php echo $child->name; ?> </a> 
        </li>
        <?php endif; ?>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</ul>