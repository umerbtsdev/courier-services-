@extends('adminlte::layouts.app')
@section('content')

<div class = 'container-fluid'>
    <div class="col-md-12">
        <div class="flash-message">

            @if(Request::session()->has('user_create_status'))
                  @if(Request::session()->pull('user_create_status') == 'success')
                  <div class="alert alert-success">{{Request::session()->pull('user_create_message')}}</div>
                  @endif
            @endif

        </div> <!-- end .flash-message -->
    </div>
    <div class="row custom-container-wrap">
        <div class="col-md-12">
                
            <div class="page-heading-primary">
                <span>
                    <h1><strong> Pending Schedule Jobs</strong></h1>
                </span>
               
            </div>
            
        </div>
        <div class="custom-inner-container-wrap">
            <div class="col-md-12 custom-table-styles wrap-scroll" style="overflow: auto;">
                <?php
                    echo GridRender::setGridId("ManufacturerList")
                        ->enableFilterToolbar()
                        ->setGridOption('url',URL::to('/workshops/schedule-job-processing/fetch-grid'))
                        ->setGridOption('rowNum', 20)
                        ->setGridOption('sortorder','ASC')
                        ->setGridOption('viewrecords',true)
                        ->setGridOption('autowidth', false)
                        ->setGridOption('height', 'auto')
                        ->setGridOption('rowList', [5,10, 15, 25, 50])
                        ->setGridOption('pager', "jqGridPager")
                        ->setGridOption('shrinkToFit', false)
                        ->setFilterToolbarOptions(array('autosearch'=>true))
                        ->setGridOption('postData', array('_token' => Session::token()))
                        //->setGridEvent('gridComplete', 'gridCompleteEvent') //gridCompleteEvent must be previously declared as a javascript function.
                         
                        ->addColumn(array('index'=>'ID', 'index'=>'sno','search'=>false, 'width'=>50))
                        ->addColumn(array('label'=>'Action','index'=>'action','width'=>100,'search'=>false))
                        ->addColumn(array('label'=>'Date','index'=>'date','width'=>180,'search'=>true))
                        ->addColumn(array('label'=>'Vehicle','index'=>'vehicle_no','width'=>180,'search'=>true))
                        ->addColumn(array('label'=>'Status','index'=>'status','width'=>140,'search'=>false))
                        ->addColumn(array('label'=>'Vehicle Type','index'=>'vehicle_category','width'=>140,'search'=>true))
                        ->addColumn(array('label'=>'Manufacturer','index'=>'brand_name','width'=>140,'search'=>true))
                        
                        ->renderGrid();
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
                "_token": "{{ csrf_token() }}",
            },
            success: function(result){
                jQuery('.custom-modal-rj').modal('toggle');
                jQuery('.custom-modal-dialog').addClass('modal-lg');
                jQuery('.custom-modal-dialog').addClass('modal-lg');
                if(type=='view')
                {
                    title = 'View Schedule';
                }
                else if(type=='perform')
                {
                    title = 'Perform Job';
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

@endsection