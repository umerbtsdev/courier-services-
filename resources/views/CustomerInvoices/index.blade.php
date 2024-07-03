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
            @if(\Session::has('msg'))
                <div class="alert alert-{{ \Session::get('msgtype') }}">
                    <ul style="    list-style: none;">
                        <li>{{ \Session::get('msg') }}</li>
                    </ul>
                </div>
            @endif

        </div> <!-- end .flash-message -->
    </div>
    <div class="row custom-container-wrap">
        <div class="col-md-12">
                
            <div class="page-heading-primary">
                <span>
                    <h1><strong>All Invoices</strong></h1>
                </span>
                
                @if(App\Helper\Common::userwisepermission(Auth::user()->id, "Customer Invoice Create"))
                <h1>
                    <a onclick="editmaintenancerequest('{{ url('Transactions/Customer-Inovices/create-invoice') }}','create')" class = "custom-btn-action custom-btn-view bgcolr-orange">Create Invoice</a>
                </h1>
                @endif
            </div>
            
        </div>
        <div class="custom-inner-container-wrap">
            <div class="col-md-12 custom-table-styles wrap-scroll" style="overflow: auto;">
                <?php
                    echo GridRender::setGridId("ManufacturerList")
                        ->enableFilterToolbar()
                        ->setGridOption('url',URL::to('transactions/customerinovices/fetch-grid'))
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
                         
                        ->addColumn(array('index'=>'ID', 'index'=>'id','search'=>true, 'width'=>50))
                        ->addColumn(array('label'=>'Action','index'=>'action','width'=>190,'search'=>false))
                        ->addColumn(array('label'=>'Client','index'=>'client_name','width'=>100,'search'=>true))
                        ->addColumn(array('label'=>'Vehicle','index'=>'vehicle_no','width'=>100,'search'=>true))
                        ->addColumn(array('label'=>'Cost Center','index'=>'cost_center_name','width'=>100,'search'=>true))
                        
                        ->addColumn(array('label'=>'Date From','index'=>'date_from','width'=>100,'search'=>true))
                        ->addColumn(array('label'=>'Date To','index'=>'date_to','width'=>100,'search'=>true))
                        ->addColumn(array('label'=>'Total Working Days','index'=>'total_working_days','width'=>100,'search'=>false))
                        ->addColumn(array('label'=>'Days Worked','index'=>'days_worked','width'=>100,'search'=>false))
                        ->addColumn(array('label'=>'Total Reading','index'=>'total_reading','width'=>100,'search'=>false))
                        ->addColumn(array('label'=>'Total','index'=>'grand_total','width'=>100,'search'=>false))
                        ->addColumn(array('label'=>'Created At','index'=>'invoices_created_at','width'=>130,'search'=>false))
                        ->addColumn(array('label'=>'Created By','index'=>'created_by','width'=>100,'search'=>false))
                        ->addColumn(array('label'=>'Updated At','index'=>'invoices_updated_at','width'=>130,'search'=>false))
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
                        title = 'Add a Customer Inovice';
                        jQuery('.custom-modal-dialog').attr('style','width: 90%;');
                    }
                    else if(type=='update')
                    {
                        title = 'Update Customer Inovice';
                    }
                    else if(type=='delete'){
                        title = 'Delete Customer Inovice';
                        jQuery('.custom-modal-dialog').removeClass('modal-lg');
                        jQuery('.custom-modal-dialog').addClass('modal-sm');
                        jQuery('.custom-modal-dialog').attr('style','margin-top: 25%;text-align:center;');
                        
                    }
                    else if(type=='view'){
                        title = "View Customer Inovice";
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