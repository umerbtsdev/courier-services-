<?php $__env->startSection('content'); ?>

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
                    <h1 class="float-left"><strong> Countries List</strong></h1>
                </span>
                <h1>
                    <?php if(App\Helper\Common::userwisepermission(Auth::user()->id, "Customer Create")): ?>
                        <a onclick="editmaintenancerequest('<?php echo e(url('/setup/countries/create')); ?>')" class="float-right btn-cus-dessign btn btn-primary waves-effect waves-light"> Add Countries </a>
                    <?php endif; ?>
            
                </h1>
            </div>
            
        </div>

            <div class="col-md-12 custom-table-styles">
                <div class="card m-b-30">
                    <div class="card-body">
                <?php
                        echo GridRender::setGridId("AlertList")
                            ->enableFilterToolbar()
                            ->setGridOption('url',URL::to('/countries-grid-data'))
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
                            ->addColumn(array('label'=>'Action','index'=>'action','width'=>100,'search'=>false,'exhidden'=>true))
                            ->addColumn(array('index'=>'Name', 'index'=>'name','search'=>true, 'width'=>200))
                            ->addColumn(array('label'=>'Description','index'=>'description','search'=>true,'width'=>300,'exhidden'=>true))
                            ->setNavigatorOptions('navigator',array('view'=>false))
                           
                            ->renderGrid();
                  ?>
                </div>

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
<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>