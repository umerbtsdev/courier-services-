{{--@extends('adminlte::layouts.page')--}}
@extends('adminlte::layouts.app')
@section('htmlheader_title')

@endsection

@section('contentheader_title')

@endsection

@section('title', 'Banks')

{{--@section('content_header')--}}
    {{--<h1>Clients List</h1>--}}



{{--@stop--}}

@section('content')
<style>
.icon-custom-btn{
    width: fit-content;
    margin-right: 8px !important;
    display: -webkit-inline-box;
    margin: 5px 0px;
}
#CompanyListView{
    //font-size: 15px;
}
</style>
<div class="row">
    <div class="col-md-12">
        <div class="flash-message">
            @foreach (['danger', 'warning', 'success', 'info'] as $msg)
                @if(Session::has('alert-' . $msg))
                    <p class="alert alert-{{ $msg }}">{!! Session::get('alert-' . $msg) !!} <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a></p>
                @endif
            @endforeach
        </div>
    </div>
    <div class="col-md-12">
        <div class="page-heading-primary">
            
            <h1>
                <b>All Accounts</b>

                @if(App\Helper\Common::userwisepermission(Auth::user()->id, "Bank Accounts Create"))
                    <a onclick="editmaintenancerequest('/General-Setup/accounts/add','create')" class = "custom-btn-action custom-btn-view bgcolr-orange">Add Account</a>
                @endif
            </h1>
        </div>
    
    </div>
    <div class="col-md-12" style="overflow-x: auto;">
        <div class="grid-container-wrap">
            <div class="col-md-12 custom-table-styles wrap-scroll" style="overflow: auto;">
                <?php
                    echo GridRender::setGridId("CompanyListView")
                    ->enableFilterToolbar()
                    ->setGridOption('url',URL::to('General-Setup/accounts/fetch-grid'))
                    ->setGridOption('rowNum', 20)
                    ->setGridOption('sortname','id')
                    ->setGridOption('viewrecords',true)
                    // ->setGridOption('caption','Product Listing ')
                    ->setGridOption('autowidth', false)
                    ->setGridOption('height', 'auto')
                    ->setGridOption('rowList', [5,10,15,20, 25, 50])
                    ->setGridOption('pager', "jqGridPager")
                    ->setGridOption('shrinkToFit', false)
                    ->setGridOption('multiselect', false)
                    ->setFilterToolbarOptions(array('autosearch'=>true))
                    ->setGridOption('postData', array('_token' => Session::token()))
                    //->setGridEvent('gridComplete', 'gridCompleteEvent') //gridCompleteEvent must be previously declared as a javascript function.
                    ->addColumn(array('label'=>'ID', 'index'=>'account_id', 'width' =>50, 'search'=>false))
                    ->addColumn(array('label'=>'Action','index'=>'action','width' =>160,'search'=>false))
                    ->addColumn(array('label'=>'Bank','index'=>'bank_name','width'=>100,'search'=>true))
                    ->addColumn(array('label'=>'Branch','index'=>'branch_name','width'=>100,'search'=>true))
                    ->addColumn(array('label'=>'Account #','index'=>'acc_number','width'=>200,'search'=>true))
                    ->addColumn(array('label'=>'Account Title','index'=>'acc_title','width'=>200,'search'=>true))
                    ->addColumn(array('label'=>'IBAN','index'=>'iban','width'=>200,'search'=>true))
                    ->addColumn(array('label'=>'Created At','index'=>'created_at','width'=>200,'search'=>false))
                    ->addColumn(array('label'=>'Created By','index'=>'created_by','width'=>200,'search'=>false))
                    ->addColumn(array('label'=>'Updated At','index'=>'updated_at','width'=>200,'search'=>false))
                    ->addColumn(array('label'=>'Updated By','index'=>'updated_by','width'=>200,'search'=>false))
                    
                    

                
                    //->addColumn(array('label'=>'Created at','index'=>'created_at','sorttype'=>'date',))
                    //->addColumn(array('label'=>'Updated at','index'=>'updated_at','sorttype'=>'date',))
                    ->renderGrid()
                ?>
            </div>

        </div>
    </div>
</div>
<script>
        function editmaintenancerequest(url,type){
            var edit = url.indexOf("edit");
            var add = url.indexOf("create");
            var add = url.indexOf("approval");

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
                        title = 'Add Account';
                       
                        jQuery('.custom-modal-dialog').attr('style','margin-top: 25%;text-align:center;');
                    }
                    if(type=='update')
                    {
                        title = 'Update Account';
                        
                        jQuery('.custom-modal-dialog').attr('style','margin-top: 25%;text-align:center;');
                    }
                    if(type=='delete'){
                        title = 'Delete Account';
                        jQuery('.custom-modal-dialog').removeClass('modal-lg');
                        jQuery('.custom-modal-dialog').addClass('modal-sm');
                        jQuery('.custom-modal-dialog').attr('style','margin-top: 25%;text-align:center;');
                    }
                    if(type=='MakePrimary'){
                        title = 'Make Account Primary';
                        jQuery('.custom-modal-dialog').removeClass('modal-lg');
                        jQuery('.custom-modal-dialog').addClass('');
                        jQuery('.custom-modal-dialog').attr('style','margin-top: 20%;text-align:center;');
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


@section('js')

@stop