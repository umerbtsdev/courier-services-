<?php $__env->startSection('htmlheader_title'); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('contentheader_title'); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('title', 'General Voucher'); ?>

<?php $__env->startSection('content'); ?>
<div class="row">
    <div class="col-md-12">
        <div class="flash-message">
            <?php $__currentLoopData = ['danger', 'warning', 'success', 'info']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $msg): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php if(Session::has('alert-' . $msg)): ?>
                    <p class="alert alert-<?php echo e($msg); ?>"><?php echo e(Session::get('alert-' . $msg)); ?> <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a></p>
                <?php endif; ?>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>
    <div class="col-md-12">

        <div class="page-heading-primary">
            <span>
                <a href="/"> <i class="fa fa-home"></i> </a>
                <i class="fa fa-angle-right"> &nbsp; </i>
                <a href="#">General Vouchers</a>
            </span>
            <h1 class="text-center"><b>General Vouchers</b></h1>
            <br/>
            <div>
                <?php if(App\Helper\Common::userwisepermission(Auth::user()->id, "General Voucher Create")): ?>
                    <button onclick="editmaintenancerequest('/finance/General-Voucher/create','create')"  class="btn bgcolr-orange"  style="margin-left:16px;margin-bottom: 10px;">Create General Voucher</button> 
                <?php endif; ?>
                <br>
                <div class="col-sm-12">
                </div>
            </div>
           </div>

       </div>
       <div class="col-md-12" style="overflow-x: auto;">
           <div class="custom-inner-container-wrap" >
               <div class="col-md-12 custom-table-styles wrap-scroll" style="overflow: auto;">
                   <?php
                   echo GridRender::setGridId("OrderListView")
                       ->enableFilterToolbar()
                       ->setGridOption('url',URL::to('/finance/General-Voucher/fetch-grid'))
                       ->setGridOption('rowNum', 20)
                       ->setGridOption('id', 'DataGrid')
                       ->setGridOption('sortname','id')
                       ->setGridOption('sortorder','desc')
                       ->setGridOption('viewrecords',true)
                       // ->setGridOption('caption','Product Listing ')
                       ->setGridOption('autowidth', false)
                       ->setGridOption('height', 'auto')
                       ->setGridOption('rowList', [5,10,15,20, 25, 50])
                       ->setGridOption('pager', "jqGridPager")
                       ->setGridOption('shrinkToFit', false)
                       ->setGridOption('multiselect', false)
                       

                       ->setFilterToolbarOptions(array('autosearch'=>true))
                       ->setGridOption('postData', array('_token' => Session::token()))
                       //->setGridEvent('gridComplete', 'gridCompleteEvent') //gridCompleteEvent must be previously declared as a javascript function.
                       //->addColumn(array('label'=>'', 'index'=>'id', 'width' =>40, 'search'=>false))
                       ->addColumn(array('label'=>'ID', 'index'=>'id', 'width' =>80, 'search'=>true))
                       ->addColumn(array('label'=>'Action','index'=>'action_column','width' =>200,'search'=>false))
                      // ->addColumn(array('label'=>'Transaction Date','index'=>'transaction_date','width' =>150,'search'=>true, 'stype'=>'date','dtype'=>'DateTime','searchoptions'=>array('DataFormatString'=> '0:yyyy-m-dd')))
                      // ->addColumn(array('label'=>'Transaction Date','index'=>'transaction_date','width' =>120,'search'=>true, 'stype'=>'text','dtype'=>'DateTime','searchoptions'=>array('dataInit'=> "datePick","attr"=>array("title"=>"Select Date"))))
                      ->addColumn(array('label'=>'Transaction Date','index'=>'transaction_date','width' =>120,'search'=>true))
                       ->addColumn(array('label'=>'Due Date','index'=>'due_date','width'=>100,'search'=>true))
                       ->addColumn(array('label'=>'Debit Total','index'=>'debit_total','width'=>80,'search'=>false))
                       ->addColumn(array('label'=>'Credit Total','index'=>'credit_total','width'=>250,'search'=>true))
                       ->addColumn(array('label'=>'Remarks','index'=>'remarks','width'=>250,'search'=>true))
    
                       ->renderGrid()
                   ?>
               </div>
           </div>
       </div>
</div>
<script>
        function editmaintenancerequest(url,type){

            jQuery.ajax({
                url: url,
                type: "get",
                data: {
                    "_token": "<?php echo e(csrf_token()); ?>",
                },
                success: function(result){
                    jQuery('.custom-modal-rj').modal('toggle');
                    jQuery('.custom-modal-dialog').addClass('modal-lg');
                    if(type=='create')
                    {
                        title = 'Create General Voucher';
                    }
                    if(type=='update')
                    {
                        title = 'Update General Voucher';
                    }
                    if(type=='view')
                    {
                        title = 'View  General Voucher';
                        /*jQuery('.custom-modal-dialog').removeClass('modal-dialog');
                        jQuery('.custom-modal-dialog').removeClass('modal-lg');
                        jQuery('.custom-modal-view').attr('style', 'margin-top: 0%;');
                        jQuery('.custom-modal-dialog').attr('style', 'padding-right: 0px;');*/
                    }
                    
    
                    jQuery('.custom-modal-view').attr('style', 'margin-top: 0%;');
                    jQuery('.modal-header').attr('style','text-align:center;text-align:-webkit-center;    background-color: #2a3f54;color:white');
                    jQuery('.custom-modal-dialog').attr('style', 'padding-right: 0px;');
                    if(type=='cancel')
                    {
                        title = 'Delete General Voucher';
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