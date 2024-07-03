@extends('layouts.app')
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


<!--     <div class="modal fade" id="modal-default">
                         {!! Form::open(['url' => '/admin/ddelete/'.$DigiOrders->OrderID]) !!}
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span></button>
                                    <h4 class="modal-title">Delete Order</h4>
                                </div>
                                <div class="modal-body">
                                    <p>Do you Want to Delete this Order</p>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                                    <button type="submit"  class="btn btn-sm btn-danger">Delete Order</button>
                                </div>
                                  {!! Form::close() !!}
                            </div>
                            /.modal-content -->
                        <!-- </div> -->
           <!--      <-- /.modal-dialog -->
                    <!-- </div> -->


    <div class="row custom-container-wrap">
        <div class="col-md-12">
                
            <div class="page-heading-primary">
                <span>

                    <h1 class="float-left"><strong> Load Sheet Genration</strong></h1>
                        <a class = "float-right btn-cus-dessign btn btn-primary waves-effect waves-light generate_loadsheet" style="margin-left: 10px"> Generate Loadsheet  </a>
                        <a onclick="editmaintenancerequest('{{ url('setup/costcenter/create') }}')" class = "float-right btn-cus-dessign btn btn-primary waves-effect waves-light"> Print CN Bulk  </a>
                </span>
                <h1>

            {{--    <button type="button" class="btn btn-default"   
                onclick="editmaintenancerequest('{{ url('alert/edit/3') }}')">
               
                edit</button>--}}
                </h1>
            </div>
            
        </div>


            <div class="col-md-12 custom-table-styles">
                <?php
                        echo GridRender::setGridId("loadsheetgenerate")
                            ->enableFilterToolbar()
                            ->setGridOption('url',URL::to('/loadsheetgenrate-grid-data'))
                            ->setGridOption('rowNum', 20)
                            ->setGridOption('sortname','id')
                            ->setGridOption('viewrecords',false)
                            ->setGridOption('autowidth', true)
                            ->setGridOption('height', 'auto')
                            ->setGridOption('rowList', [5,10, 15, 25, 50])
                            ->setGridOption('pager', "jqGridPager")
                            ->setGridOption('shrinkToFit', true)
                            ->setGridOption('multiselect', true)
                            ->setFilterToolbarOptions(array('autosearch'=>true))
                            ->setGridOption('postData', array('_token' => Session::token()))
                            //->setGridEvent('gridComplete', 'gridCompleteEvent') //gridCompleteEvent must be previously declared as a javascript function.
                            ->addColumn(array('label'=>'Id', 'index'=>'id','search'=>true, 'width'=>80))
                            ->addColumn(array('label'=>'Action','index'=>'action','width'=>200,'search'=>false,'exhidden'=>true))
                            ->addColumn(array('label'=>'Consignment #','index'=>'CN #', 'index'=>'cn_no','search'=>true, 'width'=>200))
                            ->addColumn(array('label'=>'Customer Name','index'=>'Customer Name', 'index'=>'customer_name','search'=>true, 'width'=>200))
                            ->addColumn(array('label'=>'Consignee Name','index'=>'Consignee Name', 'index'=>'consignee_name','search'=>true, 'width'=>200))
                            ->addColumn(array('label'=>'Consignee Contact','index'=>'Contact Number', 'index'=>'contact_number','search'=>true, 'width'=>200))
                            ->addColumn(array('label'=>'Pieces','index'=>'Pieces', 'index'=>'pieces','search'=>true, 'width'=>200))
                            ->addColumn(array('label'=>'Weight','index'=>'Weight', 'index'=>'weight','search'=>true, 'width'=>200))
                            ->addColumn(array('label'=>'COD Amount','index'=>'COD Amount', 'index'=>'cod_amount','search'=>true, 'width'=>200))
                            ->addColumn(array('label'=>'Service','index'=>'Service', 'index'=>'service','search'=>true, 'width'=>200))
                            ->addColumn(array('label'=>'Destination City','index'=>'Destination City', 'index'=>'destination_City','search'=>true, 'width'=>200))

                            ->setNavigatorOptions('navigator',array('view'=>false))
                           
                            ->renderGrid();
                  ?>


            </div>
        </div>
</div>


<script>
    $(".generate_loadsheet").click(function() {
        var itemIds = jQuery("#loadsheetgenerate").jqGrid('getGridParam','selarrrow');
        jQuery.ajax({

            url: '{{url('/transaction/genrateloadsheetdata')}}',
            type: "post",
            data: {
                "_token": "{{ csrf_token() }}",
                "itemIds": itemIds,
            },
            success: function (result) {
                title = "Generate LoadSheet";
                jQuery('.custom-modal-rj').modal('toggle');
                jQuery('.custom-modal-dialog').addClass('modal-lg');
                jQuery('.custom-modal-title').html(title);//SET TITLE
                jQuery('.custom-modal-body-rj').html(result);//SET BODY
//SHOW LOADER B/C AJAX EVENT NOT CALL AFTER ONCOLSE IN JQGRID
                jQuery('.ajax-loader-region').fadeOut('fast');
            }
        });
        return false;
    });
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