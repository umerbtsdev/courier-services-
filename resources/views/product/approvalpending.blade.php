@extends('adminlte::layouts.app')
@section('title','Approval Pending')
@section('content')


<div class = 'container-fluid'>
    <div class="custom-container-wrap">

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
                    <b> Pending Approval</b>
                </span>
                <h1>
                    <b>Pending Approval</b>

                    <?php   if($QC_Role == 1){?>
                    <input class="custom-btn-action custom-btn-view bgcolr-orange submit-approve-qc" style="float: right;" type="button" value="Approve QC">
                    <input class="custom-btn-action custom-btn-view bgcolr-red submit-reject-qc" style="float: right;" type="button" value="Reject QC">
                    <?php } if($VM_Role == 1) { ?>
                    <input class="custom-btn-action custom-btn-view bgcolr-orange submit-approve-vm" style="float: right;" type="button" value="Approve VM">
                    <input class="custom-btn-action custom-btn-view bgcolr-red submit-reject-vm" style="float: right;" type="button" value="Reject VM">
                    <?php } ?>
                </h1>
            </div>
            
        </div>

        <div class="custom-inner-container-wrap">
            <div class="col-md-12 custom-table-styles wrap-scroll">
                <?php
                    $grid = GridRender::setGridId("ProductListView")
                        ->enableFilterToolbar()
                        ->setGridOption('url',URL::to('/approval-pending-data'))
                        ->setGridOption('rowNum', 20)
                        ->setGridOption('sortname','id')
                        ->setGridOption('viewrecords',true)
                        ->setGridOption('autowidth', false)
                        ->setGridOption('height', 'auto')
                        ->setGridOption('rowList', [15, 20, 25, 50, 100,200,500])
                        ->setGridOption('pager', "jqGridPager")
                        ->setGridOption('shrinkToFit', false)
                        ->setGridOption('multiselect', true)
                        ->setFilterToolbarOptions(array('autosearch'=>true))
                        ->setGridOption('postData', array('_token' => Session::token()))
                        //->setGridEvent('gridComplete', 'gridCompleteEvent') //gridCompleteEvent must be previously declared as a javascript function.
                        ->addColumn(array('index'=>'Id', 'index'=>'id', 'width'=>100, 'search'=>false));
                        

                        if($is_vendor != 1){
                            $grid->addColumn(array('label'=>'Action','index'=>'action_column','width'=>160,'search'=>false));
                        }

                        $grid->addColumn(array('label'=>'Product Name','index'=>'name'))
                        ->addColumn(array('label'=>'Sku','index'=>'sku'))
                        ->addColumn(array('label'=>'Vendor Name','index'=>'vendor_name'))
                        ->addColumn(array('label'=>'Product Image','index'=>'product_image','search'=>false))
                        ->addColumn(array('label'=>'Qty Dropship','index'=>'qty_dropship'))
                        ->addColumn(array('label'=>'Category Name','index'=>'category_name'))
                        ->addColumn(array('label'=>'Attributeset Name','index'=>'attributeset_name'))
                        ->addColumn(array('label'=>'Created at','index'=>'created_at','sorttype'=>'date','searchoptions'=>array()))
                        ->addColumn(array('label'=>'Updated at','index'=>'updated_at','sorttype'=>'date','searchoptions'=>array()));
                        
                        echo $grid->renderGrid();
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
              "_token": "{{ csrf_token() }}",
          },
          success: function(result){
              jQuery('.custom-modal-rj').modal('toggle');
              jQuery('.custom-modal-dialog').addClass('modal-lg');
              jQuery('.custom-modal-title').html('Product Approval');//SET TITLE
              jQuery('.custom-modal-body-rj').html(result);//SET BODY
  
              //SHOW LOADER B/C AJAX EVENT NOT CALL AFTER ONCOLSE IN JQGRID
              jQuery('.ajax-loader-region').hide();
          }
      });
      return false;
  }
  jQuery(".submit-approve-qc").click(function(){
  
      var ProductIds = jQuery("#ProductListView").jqGrid('getGridParam','selarrrow');
      jQuery.ajax({
          url: '{{url('/products/bulkapproveqc')}}',
          type: "post",
          data: {
              "_token": "{{ csrf_token() }}",
              "approveids": ProductIds,
          },
          success: function(result){
              if(result.indexOf('Product Approved by Quality Control') >= 0)
              {
                  $(".flash-message").html('<p class="alert alert-success">'+result+'<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a></p>');
              }else
              {
                  $(".flash-message").html('<p class="alert alert-danger">'+result+'<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a></p>');
              }
              jQuery("#ProductListView").trigger("reloadGrid");
          }
      });
  })
  jQuery(".submit-reject-qc").click(function(){
      var ProductIds = jQuery("#ProductListView").jqGrid('getGridParam','selarrrow');
      jQuery.ajax({
          url: '{{url('/products/bulkrejectqc')}}',
          type: "post",
          data: {
              "_token": "{{ csrf_token() }}",
              "rejectids": ProductIds,
          },
          success: function(result){
              if(result.indexOf('Product Reject by Quality Control') >= 0)
              {
                  $(".flash-message").html('<p class="alert alert-success">'+result+'<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a></p>');
              }else
              {
                  $(".flash-message").html('<p class="alert alert-danger">'+result+'<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a></p>');
              }
              jQuery("#ProductListView").trigger("reloadGrid");
          }
      });
  })
  
  jQuery(".submit-approve-vm").click(function(){
  
      var ProductIds = jQuery("#ProductListView").jqGrid('getGridParam','selarrrow');
      jQuery.ajax({
          url: '{{url('/products/bulkapprovevm')}}',
          type: "post",
          data: {
              "_token": "{{ csrf_token() }}",
              "approveids": ProductIds,
          },
          success: function(result){
              if(result.indexOf('Product Approved by Vendor Manager') >= 0)
              {
                  $(".flash-message").html('<p class="alert alert-success">'+result+'<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a></p>');
              }else
              {
                  $(".flash-message").html('<p class="alert alert-danger">'+result+'<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a></p>');
              }
              jQuery("#ProductListView").trigger("reloadGrid");
          }
      });
  })
  jQuery(".submit-reject-vm").click(function(){
      var ProductIds = jQuery("#ProductListView").jqGrid('getGridParam','selarrrow');
      jQuery.ajax({
          url: '{{url('/products/bulkrejectvm')}}',
          type: "post",
          data: {
              "_token": "{{ csrf_token() }}",
              "rejectids": ProductIds,
          },
          success: function(result){
              if(result.indexOf('Product Reject by Vendor Manager') >= 0)
              {
                  $(".flash-message").html('<p class="alert alert-success">'+result+'<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a></p>');
              }else
              {
                  $(".flash-message").html('<p class="alert alert-danger">'+result+'<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a></p>');
              }
              jQuery("#ProductListView").trigger("reloadGrid");
          }
      });
  })
  function pendingapprovedreject(url, product_id, title){
      //SHOW LOADER B/C AJAX EVENT NOT CALL AFTER ONCOLSE IN JQGRID
      //jQuery('.ajax-loader-region').show();
  if (title == "approve")
  {
  title = "Product Approve";
  }
  else
  {
  title = "Product Reject";
  }
      //var vendorId = jQuery(this).attr('vendor-id');
      jQuery.ajax({
          url: url,
          type: "get",
          data: {
              "_token": "{{ csrf_token() }}"
          },
          success: function(result){
              jQuery('.custom-modal-rj').modal('toggle');
              jQuery('.custom-modal-dialog').addClass('modal-lg');
              jQuery('.custom-modal-title').html(title);//SET TITLE
              jQuery('.custom-modal-body-rj').html(result);//SET BODY
  
              //SHOW LOADER B/C AJAX EVENT NOT CALL AFTER ONCOLSE IN JQGRID
              jQuery('.ajax-loader-region').hide();
          }
      });
      return false;
  }
</script>

@endsection