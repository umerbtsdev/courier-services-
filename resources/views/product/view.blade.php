@extends('adminlte::layouts.app')
@section('title','View Products')
@section('content')

<div class = 'container-fluid'>
  <div class="row custom-container-wrap">
    <div class="col-md-12">
            
      <div class="page-heading-primary">
          <span>
              <a href="#"> <i class="fa fa-home"></i> </a>
              <i class="fa fa-angle-right"> &nbsp; </i>
              <b > Product </b>
              <i class="fa fa-angle-right"> &nbsp; </i>
              <b> View Product </b>
          </span>
          <h1>
              <b> View Product </b>
          </h1>
      </div>
        
    </div>

    <div class="custom-inner-container-wrap">
        <div class="col-md-12 product-view-wrap">
            {!! Form::open(array('url'=>'product/add','method'=>'POST', 'files'=>true)) !!}

            <div class="panel with-nav-tabs panel-primary">
                <div class="panel-heading">
                    <ul class="nav nav-tabs">
                        <li class="active"><a href="#tab1primary" data-toggle="tab">Product Information</a></li>
                        <li><a href="#tab2primary" data-toggle="tab">Additional Info</a></li>
                        <li><a href="#tab3primary" data-toggle="tab">Image</a></li>
                        <li><a href="#tab4primary" data-toggle="tab">Configurable Options</a></li>
                    </ul>
                </div>

                <div class="panel-body">

                    <div class="tab-content">

                        <div class="tab-pane fade in active" id="tab1primary">
                            @foreach ($prodata as $prod)
                                <table class="table table-striped tbl-style-2">
                                    <tbody>
                                    <tr>
                                        <td>
                                            <i class="fa fa-caret-right"></i> &nbsp; Sku
                                        </td>
                                        <td>
                                            {{$prod->sku}}
                                        </td>
                                        <td>
                                            <i class="fa fa-caret-right"></i> &nbsp; Vendor
                                        </td>
                                        <td>
                                            {{$prod->vendor_name}}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <i class="fa fa-caret-right"></i> &nbsp; Category
                                        </td>
                                        <td>
                                            {{$prod->categoryname}}
                                        </td>
                                        <td>
                                            <i class="fa fa-caret-right"></i> &nbsp; Mode of Fullfillment
                                        </td>
                                        <td>
                                            {{$prod->fulfillment_name}}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div><i class="fa fa-caret-right"></i> &nbsp; Qty</div>
                                            @if($prod->invupdateflag == 1 && $prod->dropship_qty_old != $prod->dropship_qty)
                                            <div style="font-weight: bold"><i class="fa fa-caret-right"></i> &nbsp; Old Qty</div>
                                                @endif
                                        </td>
                                        <td>
                                            <div>{{$prod->dropship_qty}}</div>
                                            @if($prod->invupdateflag == 1 && $prod->dropship_qty_old != $prod->dropship_qty)
                                            <div style="font-weight: bold">{{$prod->dropship_qty_old}}</div>
                                                @endif
                                        </td>
                                        <td>
                                            <i class="fa fa-caret-right"></i> &nbsp; Attribute Sets
                                        </td>
                                        <td>
                                            {{$prod->attributeset_name}}
                                        </td>
                                    </tr>
                                    <?php $count= 0 ?>

                                    @foreach ($atributedata as $attridata)
                                        @if($attridata->additional_info == 0)
                                            <?php $mod = $count % 2; ?>
                                            @if($mod == 0)
                                                <tr>
                                                    @endif
                                                    <td>
                                                        <div>
                                                            <i class="fa fa-caret-right"></i> &nbsp; {{$attridata->name}}
                                                        </div>
                                                        <div style="font-weight: bold;">
                                                            @if ($attridata->updateflag == 1 && ($attridata->option_value_old != $attridata->option_value || $attridata->oldvalue != $attridata->value))
                                                                <i class="fa fa-caret-right"></i> &nbsp;{{$attridata->name}} Old Value
                                                            @endif
                                                        </div>

                                                    </td>
                                                    <td>
                                                        @if($attridata->frontend_type == "select")
                                                            <div style="max-height: 200px; overflow: hidden; overflow-y: auto;"> {{$attridata->option_value}} </div>
                                                            <div style="font-weight: bold; max-height: 200px; overflow: hidden; overflow-y: auto;">
                                                                @if ($attridata->updateflag == 1 && $attridata->option_value_old != $attridata->option_value)
                                                                    {!!$attridata->option_value_old!!}
                                                                @endif
                                                            </div>
                                                        @elseif ($attridata->frontend_type == "textarea")
                                                            <div style="max-height: 200px; overflow: hidden; overflow-y: auto;">
                                                                {!! $attridata->value !!}
                                                            </div>
                                                            <div style="font-weight: bold; max-height: 200px; overflow: hidden; overflow-y: auto;">
                                                                @if ($attridata->updateflag == 1 && $attridata->oldvalue != $attridata->value)
                                                                    {!!$attridata->oldvalue!!}
                                                                @endif
                                                            </div>

                                                        @else
                                                            <div>
                                                                {{$attridata->value}}
                                                            </div>
                                                            <div style="font-weight: bold;">
                                                                @if ($attridata->updateflag == 1 && $attridata->oldvalue != $attridata->value)
                                                                    {{$attridata->oldvalue}}
                                                                @endif
                                                            </div>

                                                        @endif
                                                    </td>
                                                    @if($mod == 1)
                                                </tr>
                                            @endif
                                            <?php $count++ ?>
                                        @endif
                                    @endforeach
                                    </tbody>
                                </table>

                            @endforeach
                        </div>
                        <div class="tab-pane fade " id="tab2primary">

                            <div class="tab2attributearea" >
                                <table class="table table-striped tbl-style-2">
                                    <tbody>
                                    <?php $count= 0 ?>

                                    @foreach ($atributedata as $attridata)
                                        @if($attridata->additional_info == 1)
                                            <?php $mod = $count % 2; ?>
                                            @if($mod == 0)
                                                <tr>
                                                    @endif
                                                    <td>
                                                        <i class="fa fa-caret-right"></i> &nbsp; {{$attridata->name}}
                                                        <div style="font-weight: bold;">
                                                            @if ($attridata->updateflag == 1 && ($attridata->option_value_old != $attridata->option_value || $attridata->oldvalue != $attridata->value))
                                                                <i class="fa fa-caret-right"></i> &nbsp;{{$attridata->name}} Old Value
                                                            @endif
                                                        </div>
                                                    </td>
                                                    <td>
                                                        @if($attridata->frontend_type == "select")
                                                            <div style="max-height: 200px; overflow: hidden; overflow-y: auto;"> {{$attridata->option_value}} </div>
                                                            <div style="font-weight: bold; max-height: 200px; overflow: hidden; overflow-y: auto;">
                                                                @if ($attridata->updateflag == 1 && $attridata->option_value_old != $attridata->option_value)
                                                                    {!!$attridata->option_value_old!!}
                                                                @endif
                                                            </div>
                                                        @elseif ($attridata->frontend_type == "textarea")
                                                            <div style="max-height: 200px; overflow: hidden; overflow-y: auto;">
                                                                {!! $attridata->value !!}
                                                            </div>
                                                            <div style="font-weight: bold; max-height: 200px; overflow: hidden; overflow-y: auto;">
                                                                @if ($attridata->updateflag == 1 && $attridata->oldvalue != $attridata->value)
                                                                    {!!$attridata->oldvalue!!}
                                                                @endif
                                                            </div>
                                                        @else
                                                            <div>
                                                                {{$attridata->value}}
                                                            </div>
                                                            <div style="font-weight: bold;">
                                                                @if ($attridata->updateflag == 1 && $attridata->oldvalue != $attridata->value)
                                                                    {{$attridata->oldvalue}}
                                                                @endif
                                                            </div>
                                                        @endif
                                                    </td>
                                                    @if($mod == 1)
                                                </tr>
                                            @endif
                                            <?php $count++ ?>
                                        @endif
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>

                        </div>
                        <div class="tab-pane fade" id="tab3primary">
                            <div class="col-md-12">
                                <div class="popup-gallery">
                                    @foreach($files as $file)
                                        <a href="{{url("uploads/".$file->filename)}}" title="{{$file->filename}}"><img src="{{url("uploads/".$file->filename)}}" width="150" height="150" /></a>
                                    @endforeach
                                </div>
                            </div>
                            @if($files_old->count() > 0)
                            <div class="col-md-12">
                                <span style="font-weight: bold;"> Old Images </span>
                                <div class="popup-gallery">

                                    @foreach($files_old as $file)
                                        <a href="{{url("uploads/".$file->filename)}}" title="{{$file->filename}}"><img src="{{url("uploads/".$file->filename)}}" width="150" height="150" /></a>
                                    @endforeach
                                </div>
                            </div>
                            @endif
                        </div>

                        <div class="tab-pane fade" id="tab4primary">
                            <div class="col-md-12">
                                <table class="table table-striped tbl-style-conf">
                                    <head>
                                        <th>Option Attribute</th>
                                        <th>Description</th>
                                        <th>Qty</th>
                                        <th>Qty Old Value</th>
                                        <th>Price</th>
                                        <th>Price Old Value</th>
                                        <th>Status</th>
                                        <th>Status old</th>
                                        <th>Cost</th>
                                    </head>
                                    <tbody>
                                    @foreach($configurabledata as $configurablepro)
                                        <tr>
                                            <td>{{$configurablepro->name}}</td>
                                            <td>
                                                {{$configurablepro->option_value}}
                                            </td>
                                            <td>
                                                {{$configurablepro->qty}}
                                            </td>
                                            <td>
                                                @if($configurablepro->qty_old != $configurablepro->qty)
                                                    {{$configurablepro->qty_old}}
                                                @endif
                                            </td>
                                            <td>
                                                {{$configurablepro->price}}
                                            </td>
                                            <td>
                                                @if($configurablepro->price_old != $configurablepro->price)
                                                {{$configurablepro->price_old}}
                                                @endif
                                            </td>
                                            <td>
                                                @if ($configurablepro->status == 1)
                                                    Enable
                                                @else
                                                    Disable
                                                @endif
                                            </td>
                                            <td>
                                                @if($configurablepro->status_old != $configurablepro->status)
                                                    @if ($configurablepro->status_old != null)
                                                        @if ($configurablepro->status_old == 1)
                                                            Enable
                                                        @else
                                                            Disable
                                                        @endif
                                                    @endif
                                                @endif
                                            </td>
                                            <td>
                                                {{$configurablepro->cost}}
                                            </td>

                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                </div>

            </div>
            
            {!! Form::close() !!}
        </div>
    </div>
    <script>
        jQuery(document).ready(function() {
            product.loadmagnificPopup();
        });
</script>

@endsection