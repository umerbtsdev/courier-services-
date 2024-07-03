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
                <h1>
                <?php if(App\Helper\Common::userwisepermission(Auth::user()->id, "Expense Payment Create")): ?>
                    <a onclick="editmaintenancerequest('<?php echo e(url('/Finance/Expense-Payment/add')); ?>','create')" class = "custom-btn-action custom-btn-view bgcolr-orange">Make Expense Payment</a>
                <?php endif; ?>
                </h1>
            </div>
            
        </div>

      <div class="custom-inner-container-wrap">
            <div class="col-md-12 custom-table-styles wrap-scroll" style="overflow: auto;">
                <?php
                        echo GridRender::setGridId("expense-payment-grid")
                            ->enableFilterToolbar()
                            ->setGridOption('url',URL::to('/expense-payment-grid'))
                            ->setGridOption('rowNum', 500)
                            ->setGridOption('sortname','id')
                            ->setGridOption('sortorder','desc')
                            ->setGridOption('viewrecords',true)
                            ->setGridOption('autowidth', false)
                            ->setGridOption('height', 'auto')
                            ->setGridOption('rowList', [5,10, 15, 25, 50])
                            ->setGridOption('pager', "jqGridPager")
                            ->setGridOption('shrinkToFit', false)
                            ->setFilterToolbarOptions(array('autosearch'=>true))
                            ->setGridOption('postData', array('_token' => Session::token()))
                            //->setGridEvent('gridComplete', 'gridCompleteEvent') //gridCompleteEvent must be previously declared as a javascript function.
                            ->addColumn(array('label'=>'ID', 'index'=>'id','search'=>false, 'width'=>80))
                            ->addColumn(array('label'=>'Action','index'=>'action','width'=>100,'search'=>false,'exhidden'=>true))
                            ->addColumn(array('label'=>'Invoice ID', 'index'=>'invoice_id','search'=>true, 'width'=>150))
                            ->addColumn(array('label'=>'Total Expense', 'index'=>'total_expense','search'=>false, 'width'=>200))
                            ->addColumn(array('label'=>'Date Paid', 'index'=>'paid_date','search'=>false, 'width'=>150))
                            ->addColumn(array('label'=>'Created By', 'index'=>'ExpensePayment_created_by','search'=>false, 'width'=>150))
                            ->addColumn(array('label'=>'Created At', 'index'=>'created_at','search'=>false, 'width'=>150))
                            ->addColumn(array('label'=>'Updated By', 'index'=>'updated_at','search'=>false, 'width'=>150))
                            ->addColumn(array('label'=>'Updated At', 'index'=>'ExpensePayment_updated_by','search'=>false, 'width'=>150))



                            // ->setNavigatorOptions('navigator',array('view'=>false))
                            ->renderGrid();
                  ?>



            </div>
        </div>
    </div>
</div>



<script>
    function editmaintenancerequest(url,typed){
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
                if(typed == 'edit'){
                    title = 'Edit Expense Payment';
                }
                else if(typed =='create'){
                    title = "Make Expense Payment";
                }
                else if(typed == 'cancel')
                {
                    title = 'Delete  Expense Payment';
                    jQuery('.custom-modal-dialog').removeClass('modal-lg');
                    jQuery('.custom-modal-dialog').addClass('modal-sm');
                    jQuery('.custom-modal-dialog').attr('style','margin-top: 25%;text-align:center;');
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
<?php echo $__env->make('adminlte::layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>