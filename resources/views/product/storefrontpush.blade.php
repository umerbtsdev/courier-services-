@extends('adminlte::layouts.app')
@section('title','Push to Magento')
@section('content')

<div class = 'container-fluid'>
    <div class="col-md-12">
        <div class="flash-message">

            @foreach (['danger', 'warning', 'success', 'info'] as $msg)
                @if(Session::has('alert-' . $msg))

                    <p class="alert alert-{{ $msg }}">{{ Session::get('alert-' . $msg) }} <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a></p>
                @endif
            @endforeach

        </div> <!-- end .flash-message -->
    </div>
    <div class="row custom-container-wrap">
        <div class="col-md-12">
                
            <div class="page-heading-primary">
                <span>
                    <a href="#"> <i class="fa fa-home"></i> </a>
                    <i class="fa fa-angle-right"> &nbsp; </i>
                    <b> Product </b>
                    <i class="fa fa-angle-right"> &nbsp; </i>
                    <b> Push to Magento </b>
                </span>
                <h1>
                    <b>Ready to push on Store Front</b>
                </h1>
            </div>
            
        </div>

        <div class="custom-inner-container-wrap">
            <div class="col-md-12 custom-table-styles">
                <?php
                    echo GridRender::setGridId("ProductListView")
                        ->enableFilterToolbar()
                        ->setGridOption('url',URL::to('/storefront-push-data'))
                        ->setGridOption('rowNum', 20)
                        ->setGridOption('sortname','id')
                        ->setGridOption('viewrecords',true)
                        ->setGridOption('autowidth', true)
                        ->setGridOption('height','auto')
                        ->setGridOption('rowList', [15, 20, 25, 50])
                        ->setGridOption('pager', "jqGridPager")
                        ->setGridOption('shrinkToFit', true)
                        ->setFilterToolbarOptions(array('autosearch'=>true))
                        ->setGridOption('postData', array('_token' => Session::token()))
                        //->setGridEvent('gridComplete', 'gridCompleteEvent') //gridCompleteEvent must be previously declared as a javascript function.
                        ->addColumn(array('index'=>'Id', 'index'=>'id', 'width'=> 100,'search'=>false))
                        ->addColumn(array('label'=>'Action','index'=>'action_column','search'=>false, 'width'=> '200',))
                        ->addColumn(array('label'=>'Product Name','index'=>'name'))
                        ->addColumn(array('label'=>'Sku','index'=>'sku'))
                        ->addColumn(array('label'=>'Vendor Name','index'=>'vendor_name'))
                        ->addColumn(array('label'=>'Qty Dropship','index'=>'qty_dropship'))
                        ->addColumn(array('label'=>'Qty Stocking','index'=>'qty_stocking'))
                        ->addColumn(array('label'=>'Category Name','index'=>'category_name'))
                        ->addColumn(array('label'=>'Attributeset Name','index'=>'attributeset_name'))
                        ->addColumn(array('label'=>'Error','index'=>'error_message'))
                        ->addColumn(array('label'=>'Created at','index'=>'created_at'))
                        ->addColumn(array('label'=>'Updated at','index'=>'updated_at'))
                        ->renderGrid()
                    ?>
            </div>
        </div>
    </div>
</div>

<script>
    function backtoapprovalfu(url){
        jQuery.ajax({
            url: url,
            type: "get",
            data: {
                "_token": "{{ csrf_token() }}",
            },
            success: function(result){
                jQuery('.custom-modal-rj').modal('toggle');
                jQuery('.custom-modal-dialog').addClass('modal-lg');
                jQuery('.custom-modal-title').html('');//SET TITLE
                jQuery('.custom-modal-body-rj').html(result);//SET BODY

                //SHOW LOADER B/C AJAX EVENT NOT CALL AFTER ONCOLSE IN JQGRID
                jQuery('.ajax-loader-region').fadeOut('fast');
            }
        });
        return false;
    }
    function pushtomagentofu(url){
        // alert(url);
        jQuery.ajax({
            url: url,
            type: "get",
            data: {
                "_token": "{{ csrf_token() }}",
            },
            success: function(result){
                console.log(result);
                jQuery('.custom-modal-rj').modal('toggle');
                jQuery('.custom-modal-dialog').addClass('modal-lg');
                jQuery('.custom-modal-title').html('');//SET TITLE
                jQuery('.custom-modal-body-rj').html(result);//SET BODY

                //SHOW LOADER B/C AJAX EVENT NOT CALL AFTER ONCOLSE IN JQGRID
                jQuery('.ajax-loader-region').fadeOut('fast');
            }
        });
        return false;
    }
</script>
@endsection