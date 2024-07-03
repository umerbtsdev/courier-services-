@extends('adminlte::layouts.app')
@section('title','Manage Products')
@section('content')


<div class = 'container-fluid product-listing'>
    <div class="row custom-container-wrap">
        <div class="col-md-12">
            <div class="flash-message">

                @foreach (['danger', 'warning', 'success', 'info'] as $msg)
                    @if(Session::has('alert-' . $msg))

                        <p class="alert alert-{{ $msg }}">{{ Session::get('alert-' . $msg) }} <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a></p>
                    @endif
                @endforeach

            </div> <!-- end .flash-message -->
        </div>

        <div class="col-md-12">
                
            <div class="page-heading-primary">
                <span>
                    <a href="#"> <i class="fa fa-home"></i> </a>
                    <i class="fa fa-angle-right"> &nbsp; </i>
                    <b> Product </b>
                    <i class="fa fa-angle-right"> &nbsp; </i>
                    <b> Manage Product </b>
                </span>
                <h1>
                    <b>Product Listing</b>

                    <a href="javascript:void(0)" class="custom-btn-action custom-btn-view bgcolr-orange" id="add_new_poduct"> Add Product </a>

                    @if($isEnable == 1)
                            {!! Form::open(array('id'=>'frm_add_product', 'url'=>'product/create','method'=>'POST', 'files'=>true)) !!}
                            {!! Form::close() !!}
                    @endif
                </h1>
            </div>
            
        </div>

        <script type="text/javascript">
            function currencyFmatter (cellvalue, options, rowObject)
            {
             
               return "$"+cellvalue;
            }
        </script>
        <div class="custom-inner-container-wrap" >
            <div class="col-md-12 custom-table-styles wrap-scroll" style="overflow: auto;">
                <?php
                echo GridRender::setGridId("ProductListView")
                    ->enableFilterToolbar()
                    ->setGridOption('url',URL::to('/product-grid-data'))
                    ->setGridOption('rowNum', 20)
                    ->setGridOption('sortname','id')
                    ->setGridOption('viewrecords',true)
                    // ->setGridOption('caption','Product Listing ')
                    ->setGridOption('autowidth', false)
                    ->setGridOption('height', 'auto')
                    ->setGridOption('rowList', [5,10,15,20, 25, 50])
                    ->setGridOption('pager', "jqGridPager")
                    ->setGridOption('shrinkToFit', false)
                    ->setGridOption('multiselect', true)
                    ->setFilterToolbarOptions(array('autosearch'=>true))
                    ->setGridOption('postData', array('_token' => Session::token()))
                    //->setGridEvent('gridComplete', 'gridCompleteEvent') //gridCompleteEvent must be previously declared as a javascript function.
                    ->addColumn(array('index'=>'Id', 'index'=>'id', 'width' =>50, 'search'=>true))
                    ->addColumn(array('label'=>'Action','index'=>'action_column','width' =>70,'search'=>false))
                        ->addColumn(array('label'=>'Status','index'=>'status','width'=>120,'search'=>true, 'stype'=>'select','searchoptions'=>array('value'=> 'all:All;product_is_serve_from_stock:Product is Serve from Stock;pending_approval_qc:Pending Approval QC;pending_approval_vm:Pending Approval VM;rejected_not_published:Rejected not Published;approved_in_queue:Approved in Queue;approved_and_published:Approved & Published;published_pending_approval_qc:Published | Pending Approval QC;published_pending_approval_vm:Published | Pending Approval VM;published_change_rejected:Published | Change Rejected;published_changed_approved_in_queue:Published | Changed Approved in Queue')))
                    ->addColumn(array('label'=>'Comments','width'=>50,'index'=>'comments'))
                    ->addColumn(array('label'=>'Sku','index'=>'sku','width'=>100,'search'=>true))
                    ->addColumn(array('label'=>'StoreFront SKU','index'=>'storefront_sku','search'=>true))
                    ->addColumn(array('label'=>'Product Name','index'=>'name','search'=>true))
                    ->addColumn(array('label'=>'Product Image','index'=>'product_image','search'=>false))
                    ->addColumn(array('label'=>'Vendor Name','index'=>'vendor_name','search'=>true))
                    ->addColumn(array('label'=>'Qty','index'=>'qty_dropship'))
                    ->addColumn(array('label'=>'Category Name','index'=>'category_name'))
                    ->addColumn(array('label'=>'Created at','index'=>'created_at','sorttype'=>'date',))
                    ->addColumn(array('label'=>'Updated at','index'=>'updated_at','sorttype'=>'date',))
                    ->renderGrid()
                ?>
            </div>
        </div>
    </div>
    <script>
        //$("body").on("apply.daterangepicker", function(ev, picker) {
        //    debugger;
        //    $(this).val(picker.startDate.format("MM/DD/YYYY") + " - " + picker.endDate.format("MM/DD/YYYY"));
        //});
        //$("body").on("cancel.daterangepicker", function(ev, picker) {
         //   debugger;
         //   $(this).val("");
        //});

        jQuery('#add_new_poduct').click(function()
        {
            jQuery('#frm_add_product').submit();
        })
    </script>
</div>

@endsection