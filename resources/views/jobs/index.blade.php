@extends('adminlte::layouts.app')
@section('content')
<style>
        .modal-content *{
            font-family:'Varela Round', sans-serif !important
        }
</style>
<link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap.min.css">
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/responsive/2.2.3/css/responsive.bootstrap.min.css">

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
                    <h1><strong> All jobs</strong></h1>
                </span>
                
                @if(App\Helper\Common::userwisepermission(Auth::user()->id, "Job Create"))
                <h1>
                    <a onclick="editmaintenancerequest('{{ url('workshops/job/add') }}','create')" class = "custom-btn-action custom-btn-view bgcolr-orange"> Add Job</a>
                </h1>
                @endif
            </div>
            
        </div>
        <div class="custom-inner-container-wrap">
            <div class="col-md-12 custom-table-styles wrap-scroll" style="overflow: auto;">
                <?php
                    echo GridRender::setGridId("ManufacturerList")
                        ->enableFilterToolbar()
                        ->setGridOption('url',URL::to('workshops/Jobs/fetch-grid'))
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
                         
                        ->addColumn(array('index'=>'ID', 'index'=>'id','search'=>false, 'width'=>50))
                        ->addColumn(array('label'=>'Action','index'=>'action','width'=>190,'search'=>false))
                        ->addColumn(array('label'=>'Project Name','index'=>'project_name','width'=>100,'search'=>true))
                        ->addColumn(array('label'=>'Job Date','index'=>'job_date','width'=>100,'search'=>false))
                        ->addColumn(array('label'=>'Vehicle','index'=>'vehicle','width'=>100,'search'=>true))
                        ->addColumn(array('label'=>'Workshop','index'=>'name','width'=>100,'search'=>true))
                        ->addColumn(array('label'=>'Location','index'=>'location','width'=>100,'search'=>true))
                        ->addColumn(array('label'=>'Total','index'=>'grand_total','width'=>100,'search'=>false))
                        ->addColumn(array('label'=>'Created At','index'=>'created_at','width'=>130,'search'=>false))
                        ->addColumn(array('label'=>'Created By','index'=>'created_by','width'=>100,'search'=>false))
                        ->addColumn(array('label'=>'Updated At','index'=>'updated_at','width'=>130,'search'=>false))
                        ->addColumn(array('label'=>'Updated By','index'=>'updated_by','width'=>100,'search'=>false))
                        ->renderGrid();
                ?>


            </div>
        </div>
    </div>
</div>
<script src="https://cdn.datatables.net/responsive/2.2.3/js/dataTables.responsive.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.2.3/js/responsive.bootstrap.min.js"></script>
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

                    if(type=='create')
                    {
                        title = 'Add a Job';
                    }
                    else if(type=='update')
                    {
                        title = 'Update Job';
                    }
                    else if(type=='delete'){
                        title = 'Delete Job';
                        jQuery('.custom-modal-dialog').removeClass('modal-lg');
                        jQuery('.custom-modal-dialog').addClass('modal-sm');
                        jQuery('.custom-modal-dialog').attr('style','margin-top: 25%;text-align:center;');
                    }
                    else if(type=='view'){
                        title = "View Job";
                        jQuery('.custom-modal-dialog').attr('style','width:100%');
                        
                     
                    }
                    jQuery('.custom-modal-title').html(title);//SET TITLE
                    jQuery('.custom-modal-body-rj').html(result);//SET BODY

                    //SHOW LOADER B/C AJAX EVENT NOT CALL AFTER ONCOLSE IN JQGRID
                    jQuery('.ajax-loader-region').fadeOut('fast');
                    
                    if(typeof total == 'number'){
                        total = 0;
                    }
                }
            });
        
        return false;
    }
</script>

@endsection