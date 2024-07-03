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
                    <a href="#"> <i class="fa fa-home"></i> </a>
                    <i class="fa fa-angle-right"> &nbsp; </i>
                    <a href="#"> Users Management </a><br>
                    <h1><strong> All Vehicles</strong></h1>
                </span>
                <h1>
                <?php if(App\Helper\Common::userwisepermission(Auth::user()->id, "Vehicles Create")): ?>
                    <a onclick="editmaintenancerequest('<?php echo e(url('vehicles/create')); ?>')" class = "custom-btn-action custom-btn-view bgcolr-orange"> Add Vehicles</a>
                <?php endif; ?>
            
                </h1>
            </div>
            
        </div>

      <div class="custom-inner-container-wrap">
            <div class="col-md-12 custom-table-styles wrap-scroll" style="overflow: auto;">
                <?php
                        echo GridRender::setGridId("VehiclesGrid")
                            ->enableFilterToolbar()
                            ->setGridOption('url',URL::to('/vehicles-grid-data'))
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
                           
                            ->addColumn(array('label'=>'Action','index'=>'action','width'=>100,'search'=>false,'exhidden'=>true))

                            ->addColumn(array('label'=>'ID', 'index'=>'VehiclesID','search'=>true, 'width'=>200))

                            ->addColumn(array('label'=>'Vehicle Number', 'index'=>'vehicle_no','search'=>true, 'width'=>200))

                            ->addColumn(array('label'=>'Start Date', 'index'=>'start_date', 'search'=>true, 'width'=>200))

                            ->addColumn(array('label'=>'End Date','index'=>'end_date','search'=>true,'width'=>300,'exhidden'=>true))

                            ->addColumn(array('label'=>'Description', 'index'=>'description', 'search'=>true, 'width'=>200))

                            ->addColumn(array('label'=>'Driver','index'=>'DriverName','search'=>true,'width'=>300,'exhidden'=>true))

                            ->addColumn(array('label'=>'Warrenty', 'index'=>'warranty', 'search'=>true, 'width'=>200))

                            ->addColumn(array('label'=>'Owner', 'index'=>'owner', 'search'=>true,'width'=>300,'exhidden'=>true))

                            ->addColumn(array('label'=>'Brand', 'index'=>'BrandName','search'=>true, 'width'=>200))

                            ->addColumn(array('label'=>'Category','index'=>'Category','search'=>true,'width'=>300,'exhidden'=>true))

                            // ->setNavigatorOptions('navigator',array('view'=>false))
                            ->renderGrid();
                  ?>



            </div>
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
<?php echo $__env->make('adminlte::layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>