@extends('adminlte::layouts.app')
@section('title','Pending Approval VM')
@section('content')

<div class = 'container-fluid'>
    <div class="col-md-12">
        <div class="flash-message">

            <!-- error/success etc messages -->

        </div> <!-- end .flash-message -->
    </div>
    <div class="row custom-container-wrap">
        <div class="col-md-12">
                
            <div class="page-heading-primary">
                <span>
                    <!-- breadcrums -->
                    <a href="#"> <i class="fa fa-home"></i> </a>
                    <i class="fa fa-angle-right"> &nbsp; </i>
                    <b> Product </b>
                    <i class="fa fa-angle-right"> &nbsp; </i>
                    <b> Pending Vendor Approval</b>
                    <!-- breadcrums -->
                </span>
                <h1>
                    <b> Pending Vendor Approval </b>

                    <!-- button -->
                        <!-- button goes here with classes "viewproduct custom-btn-view bgcolr-aqua" -->
                    <!-- button -->
                </h1>
            </div>
            
        </div>

        <div class="custom-inner-container-wrap">
            <div class="col-md-12 custom-table-styles">
                <?php
                echo GridRender::setGridId("ProductListView")
                    ->enableFilterToolbar()
                    ->setGridOption('url',URL::to('/pending-approval-vm'))
                    ->setGridOption('rowNum', 20)
                    ->setGridOption('sortname','id')
                    ->setGridOption('viewrecords',true)
                    ->setGridOption('autowidth', true)
                    ->setGridOption('height', 'auto')
                    ->setGridOption('rowList', [15, 20, 25, 50, 100, 500])
                    ->setGridOption('pager', "jqGridPager")
                    ->setGridOption('shrinkToFit', true)
                    ->setFilterToolbarOptions(array('autosearch'=>true))
                    ->setGridOption('postData', array('_token' => Session::token()))
                    //->setGridEvent('gridComplete', 'gridCompleteEvent') //gridCompleteEvent must be previously declared as a javascript function.
                    ->addColumn(array('index'=>'Id', 'index'=>'id','width'=>100,'search'=>false))
                    ->addColumn(array('label'=>'Vendor Manager','index'=>'name', 'width'=>'200'))
                    ->addColumn(array('label'=>'Vendor Name','index'=>'vendor_name', 'width'=>100))
                    ->addColumn(array('label'=>'Pending Vendor Approval','index'=>'total_product', 'width'=>100))
                    ->renderGrid()
                ?>
            </div>
        </div>
    </div>
</div>

<script>
    function pendingapprovedreject(url, product_id){
        //SHOW LOADER B/C AJAX EVENT NOT CALL AFTER ONCOLSE IN JQGRID
        //jQuery('.ajax-loader-region').show();

        //var vendorId = jQuery(this).attr('vendor-id');
        jQuery.ajax({
            url: url,
            type: "get",
            data: {
                "_token": "{{ csrf_token() }}"
            },
            success: function(result){
                jQuery('.custom-modal-view').modal('toggle');
                jQuery('.custom-modal-dialog').addClass('modal-lg');
                jQuery('.custom-modal-title').html('Product Reject');//SET TITLE
                jQuery('.custom-modal-body').html(result);//SET BODY

                //SHOW LOADER B/C AJAX EVENT NOT CALL AFTER ONCOLSE IN JQGRID
                jQuery('.ajax-loader-region').hide();
            }
        });
        return false;
    }
</script>

@endsection