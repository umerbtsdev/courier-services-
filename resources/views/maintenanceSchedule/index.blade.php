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
                    <h1><strong> All Maintenance Schedules</strong></h1>
                </span>
                @if(App\Helper\Common::userwisepermission(Auth::user()->id, "maintenance schedule Write"))
                <h1>
                    <a onclick="editmaintenancerequest('{{ url('/workshops/maintenance-schedule/add') }}','create')" class = "custom-btn-action custom-btn-view bgcolr-orange"> Create Schedule</a>
                </h1>
                @endif
            </div>
            
        </div>
        <div class="custom-inner-container-wrap">
            <div class="col-md-12 custom-table-styles wrap-scroll" style="overflow: auto;">
                <?php
                    echo GridRender::setGridId("ManufacturerList")
                        ->enableFilterToolbar()
                        ->setGridOption('url',URL::to('/workshops/maintenance-schedule/fetch-grid'))
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
                         
                        ->addColumn(array('index'=>'ID', 'index'=>'request_id','search'=>true, 'width'=>50))
                        ->addColumn(array('label'=>'Action','index'=>'action','width'=>190,'search'=>false))
                        ->addColumn(array('label'=>'Vehicle','index'=>'vehicle_no','width'=>200,'search'=>true))
                        ->addColumn(array('label'=>'Schedule Start','index'=>'from_date','width'=>200,'search'=>true))
                        ->addColumn(array('label'=>'Schedule End','index'=>'to_date','width'=>200,'search'=>true))
                        ->addColumn(array('label'=>'Days Delay','index'=>'days_delay','width'=>200,'search'=>true))
                        ->addColumn(array('label'=>'created_at','index'=>'created_at','width'=>150,'search'=>false))
                        ->addColumn(array('label'=>'created_by','index'=>'created_by','width'=>150,'search'=>false))
                        ->addColumn(array('label'=>'updated_at','index'=>'updated_at','width'=>150,'search'=>false))
                        ->addColumn(array('label'=>'updated_by','index'=>'updated_by','width'=>150,'search'=>false))
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
                if(type=='create')
                {
                    title = 'Create Schedule';
                }
                else if(type=='update')
                {
                    title = 'Update Schedule';
                }
                else if(type=='delete')
                {
                    title = 'Cancel Schedule';
                    jQuery('.custom-modal-dialog').removeClass('modal-lg');
                    jQuery('.custom-modal-dialog').addClass('modal-sm');
                    jQuery('.custom-modal-dialog').attr('style','margin-top: 25%;text-align:center;');
                }
                else if(type=='view')
                {
                    title = 'View Schedule';
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