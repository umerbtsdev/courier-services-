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

                    <h1 class="float-left"><strong> Booking Order List</strong></h1>
                </span>
                <h1>

            
                </h1>
            </div>
            
        </div>


            <div class="col-md-12 custom-table-styles">
                <?php
                        echo GridRender::setGridId("AlertList")
                            ->enableFilterToolbar()
                            ->setGridOption('url',URL::to('/bookingorder-grid-data'))
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
                            ->addColumn(array('index'=>'Id', 'index'=>'id','search'=>true, 'width'=>80))
                            ->addColumn(array('label'=>'Action','index'=>'action','width'=>150,'search'=>false,'exhidden'=>true))
                            ->addColumn(array('index'=>'First Name', 'index'=>'first_name','search'=>true, 'width'=>200))
                            ->addColumn(array('index'=>'Last Name', 'index'=>'last_name','search'=>true, 'width'=>200))
                            ->addColumn(array('index'=>'Email', 'index'=>'email','search'=>true, 'width'=>200))
                            ->addColumn(array('index'=>'Contact No', 'index'=>'contact_no','search'=>true, 'width'=>200))
                            ->addColumn(array('index'=>'Alernate No', 'index'=>'alernate_no','search'=>true, 'width'=>200))

                            ->setNavigatorOptions('navigator',array('view'=>false))
                           
                            ->renderGrid();
                  ?>


            </div>
        </div>
</div>


<script>
    function editmaintenancerequest(url){
        var edit = url.indexOf("edit");
        var add = url.indexOf("create");
        var add = url.indexOf("approval");
        jQuery.ajax({
            url: url,
            type: "get",
            data: {
                "_token": "<?php echo e(csrf_token()); ?>",
            },
            success: function(result){
                jQuery('.custom-modal-rj').modal('toggle');
                jQuery('.custom-modal-dialog').addClass('modal-lg');
                if(edit >= 0){
                    title = '';
                }
                else if(add >= 0)
                {
                    title = ' ';
                }else
                {
                    title = '';
                }
                jQuery('.custom-modal-title').html(title);//SET TITLE
                jQuery('.custom-modal-body-rj').html(result);//SET BODY

                //SHOW LOADER B/C AJAX EVENT NOT CALL AFTER ONCOLSE IN JQGRID
                jQuery('.ajax-loader-region').fadeOut('fast');
            }
        });
        return false;
    }
</script>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>