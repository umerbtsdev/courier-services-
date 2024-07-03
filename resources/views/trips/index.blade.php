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
                    <a href="#"> <i class="fa fa-home"></i> </a>
                    <i class="fa fa-angle-right"> &nbsp; </i>
                    <a href="#"> Users Management </a><br>
                    <h1><strong> All Trips</strong></h1>
                </span>
                <h1> 
                    @if(App\Helper\Common::userwisepermission(Auth::user()->id, "Trips Create"))
                        <a onclick="editmaintenancerequest('{{ url('trip/create') }}')" class = "custom-btn-action custom-btn-view bgcolr-orange"> Add Trip</a>
                    @endif

            {{--    <button type="button" class="btn btn-default"   
                onclick="editmaintenancerequest('{{ url('vehicles/edit/3') }}')">
               
                edit</button>--}}
                </h1>
            </div>
            
        </div>

        <div class="custom-inner-container-wrap">
            <div class="col-md-12 custom-table-styles wrap-scroll" style="overflow: auto;">
                <?php
                        echo GridRender::setGridId("CatList")
                            ->enableFilterToolbar()
                            ->setGridOption('url',URL::to('/trip-grid-data'))
                            ->setGridOption('rowNum', 500)
                            ->setGridOption('sortname','id')
                            ->setGridOption('sortorder','desc')
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

                            ->addColumn(array('label'=>'Action','index'=>'action','width'=>100,'search'=>false,'exhidden'=>true))

                            ->addColumn(array('label'=>'Vehicle No', 'index'=>'vehicle_no','search'=>true, 'width'=>200))
                            ->addColumn(array('label'=>'Trip Date', 'index'=>'trip_date','search'=>true, 'width'=>200))
                            ->addColumn(array('label'=>'Name', 'index'=>'name','search'=>true, 'width'=>200))

                            ->addColumn(array('label'=>'Reading Start', 'index'=>'reading_start','search'=>true, 'width'=>200))
                            ->addColumn(array('label'=>'Created at', 'index'=>'created_at','search'=>true, 'width'=>200))
                            // ->setNavigatorOptions('navigator',array('view'=>false))
                            ->renderGrid();
                  ?>


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
                "_token": "{{ csrf_token() }}",
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

@endsection