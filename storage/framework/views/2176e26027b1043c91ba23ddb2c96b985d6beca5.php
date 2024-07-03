<?php $__env->startSection('content'); ?>

<div class = 'container-fluid'>
    <div class="col-md-12">
        <div class="flash-message">

            <?php if(Request::session()->has('user_create_status')): ?>
                  <?php if(Request::session()->pull('user_create_status') == 'success'): ?>
                  <div class="alert alert-success"><?php echo e(Request::session()->pull('user_create_message')); ?></div>
                  <?php endif; ?>
            <?php endif; ?>

        </div> <!-- end .flash-message -->
    </div>
    <div class="row custom-container-wrap">
        <div class="col-md-12">
                
            <div class="page-heading-primary">
                <span>

                </span>
                <h1>
                    <b>All Users</b>
                    <a href="<?php echo e(url('/users/create')); ?>" class = "float-right btn-cus-dessign btn btn-primary waves-effect waves-light"> Add New User </a>

                </h1>
            </div>
            
        </div>


            <div class="col-md-12 custom-table-styles">
                <?php
                        echo GridRender::setGridId("UsersList")
                            ->enableFilterToolbar()
                            ->setGridOption('url',URL::to('/user-grid-data'))
                            ->setGridOption('rowNum', 20)
                            ->setGridOption('sortname','id')
                            ->setGridOption('viewrecords',false)
                            ->setGridOption('autowidth', true)
                            ->setGridOption('height', 'auto')
                            ->setGridOption('rowList', [5,10, 15, 25, 50])
                            ->setGridOption('pager', "jqGridPager")
                            ->setGridOption('shrinkToFit', true)
                            ->setFilterToolbarOptions(array('autosearch'=>true))
                            ->setGridOption('postData', array('_token' => Session::token()))
                            //->setGridEvent('gridComplete', 'gridCompleteEvent') //gridCompleteEvent must be previously declared as a javascript function.
                           
                            ->addColumn(array('label'=>'Action','index'=>'action','width'=>100,'search'=>false,'exhidden'=>true))
                            ->addColumn(array('index'=>'Name', 'index'=>'name','search'=>true, 'width'=>200))
                            ->addColumn(array('label'=>'Email','index'=>'email','search'=>true,'width'=>300,'exhidden'=>true))
                            ->addColumn(array('label'=>'Roles','index'=>'roles','width'=>400, 'search'=>false,'exhidden'=>true))
                            ->setNavigatorOptions('navigator',array('view'=>false))
                           
                            ->renderGrid();
                  ?>
            </div>
    </div>
</div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>