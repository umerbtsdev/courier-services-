@extends('adminlte::layouts.app')
@section('title','Product Update')
@section('content')

<div class = 'container-fluid'>

    <div class="col-md-12">
        <div class="flash-message">

            @foreach (['danger', 'warning', 'success', 'info'] as $msg)
                @if(Session::has('alert-' . $msg))

                    <p class="alert alert-{{ $msg }}">{{ Session::get('alert-' . $msg) }} <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a></p>
                @endif
            @endforeach

        </div> <!-- end .flash-message -->
    </div>

    @if($isEnable == 1)
      {!! Form::open(array('url'=>'products/updatedata','method'=>'POST', 'files'=>true, 'id'=>'product_data')) !!}
      <div class="row custom-container-wrap">
          <div class="col-md-12">
                  
              <div class="page-heading-primary">
                  <span>
                      <a href="#"> <i class="fa fa-home"></i> </a>
                      <i class="fa fa-angle-right"> &nbsp; </i>
                      <b> Product </b>
                      <i class="fa fa-angle-right"> &nbsp; </i>
                      <b>Product Update</b>
                  </span>
                  <h1>
                      <b> Edit Product </b>

                      {!! Form::submit('Submit', array('class'=>'custom-btn-action custom-btn-view bgcolr-orange submit-product','id'=>'submit-product')) !!}
                  </h1>
              </div>
              
              @if( ! empty($productcomments->comments_qc) || !empty ($productcomments->comments_vm))
                <div class="callout bgcolr-grey no-border">
                  {{$productcomments->comments_qc}} {{$productcomments->comments_vm}}
                </div>
              @endif

          </div>

          <div class="custom-inner-container-wrap">
              <div class="col-md-12 product-view-wrap">
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
                                <input type="hidden" class="form-control " value="{{$prod->id}}" id="id" name="id" >
                                <div class="col-xs-12 col-sm-6 col-md-4">
                                  <div class="form-group <?php echo e($errors->has('parent_id') ? 'has-error' : ''); ?>">
                                    <div class="col-xs-12 col-sm-12 col-md-12"> <?php echo Form::label('Category L1'); ?> </div>
                                    <div class="col-xs-12 col-sm-12 col-md-12">
                                      <select id="categoryl1" class="chosen-select form-control selectrequired" name="categories">
                                        <option value="">Select Categories</option>
                                      </select>
                                    </div>
                                    <span class="text-danger"></span>
                                  </div>
                                </div>
                                <div class="col-xs-12 col-sm-6 col-md-4">
                                  <div class="form-group ">
                                    <div class="col-xs-12 col-sm-12 col-md-12"> <?php echo Form::label('Category L2'); ?> </div>
                                    <div class="col-xs-12 col-sm-12 col-md-12">
                                      <select id="categoryl2" class="chosen-select form-control selectrequired" name="categories">
                                        <option value="">Select Categories</option>
                                      </select>
                                    </div>
                                    <span class="text-danger"></span>
                                  </div>
                                </div>
                                <div class="col-xs-12 col-sm-6 col-md-4">
                                  <div class="form-group">
                                    <div class="col-xs-12 col-sm-12 col-md-12"> <?php echo Form::label('Category L3'); ?> </div>
                                    <div class="col-xs-12 col-sm-12 col-md-12">
                                      <select id="categories" class="chosen-select form-control selectrequired" name="categories">
                                        <option value="">Select Categories</option>
                                      </select>
                                    </div>
                                    <span class="text-danger"></span>
                                  </div>
                                </div>
                                <div class="col-xs-12 col-sm-6 col-md-4">
                                  <div class="form-group">
                                    <div class="col-xs-12 col-sm-12 col-md-12"> <label> Sku </label> </div>
                                    <div class="col-xs-12 col-sm-12 col-md-12">
                                      <input type="text" readonly class="form-control sku textrequired specialcharremovesku" name="sku" id="sku" aria-describedby="{{$prod->sku}}Help" value="{{$prod->sku}}" placeholder="Enter {{$prod->sku}}" maxlength="100">
                                    </div>
                                  </div>
                                </div>
                                @if($vendor == 0)
                                <div class="col-xs-12 col-sm-6 col-md-4">
                                  <div class="form-group">
                                    <div class="col-xs-12 col-sm-12 col-md-12"> <label> Vendor </label> </div>
                                    <div class="col-xs-12 col-sm-12 col-md-12">
                                      <select id="vendor" class="chosen-select form-control" name="vendor">
                                        @foreach ($allvendors as $allvendor)
                                        @if($prod->vendor_id == $allvendor->id)
                                        <option value="{{$allvendor->id}}" selected="selected">{{$allvendor->name}}</option>
                                        @else
                                        <option value="{{$allvendor->id}}">{{$allvendor->name}}</option>
                                        @endif
                                        @endforeach
                                      </select>
                                    </div>
                                  </div>
                                </div>
                                @else
                                <input type="hidden" id="vendor" name="vendor" value="{{$vendor}}">
                                @endif
                                @endforeach

                                <div class="col-xs-12 col-sm-6 col-md-4">
                                  <div class="form-group">
                                    <div class="col-xs-12 col-sm-12 col-md-12"><?php echo Form::label('Qty '); ?></div>
                                    <div class="col-xs-12 col-sm-12 col-md-12"><input type="number" placeholder="Qty" class="form-control numberrequired numericOnlyField" id="qty_dropship" value="{{$prod->dropship_qty}}" name="qty_dropship" min="0" ></div>
                                  </div>
                                </div>
                                <input type="hidden" class="form-control attribute_sets" name="attribute_sets" id="attribute_sets" aria-describedby="attribute_sets_Help" placeholder="Enter attribute_sets" value = "{{$prod->attribute_set_id}}">
                                <div class="tab1attributearea" >
                                  @foreach ($atributedata as $attridata)
                                  @if($attridata->additional_info == 0)
                                  <div class="col-xs-12 col-sm-6 {{$attridata->frontend_type == "textarea" ? "col-md-12" : "col-md-4"}}">
                                    <div class="form-group">
                                      <div class="col-xs-12 col-sm-12 col-md-12"><label for="Input{{$attridata->attr_id}}">{{$attridata->name}}</label></div>
                                      <div class="col-xs-12 col-sm-12 col-md-12">
                                        @if($attridata->frontend_type == "select")
                                        <select class="chosen-select form-control {{$attridata->attr_id}}" name="{{$attridata->attr_id}}" id="{{$attridata->attr_id}}" aria-describedby="{{$attridata->attr_id}}Help" >
                                          @foreach($attr_option_value as $attr_option_val)
                                          @if($attr_option_val->attribute_id == $attridata->sf_attributeid)
                                          @if($attr_option_val->option_id == $attridata->value)
                                          <option value="{{$attr_option_val->option_id}}" selected="selected">{{$attr_option_val->option_value}}</option>
                                          @else
                                          <option value="{{$attr_option_val->option_id}}">{{$attr_option_val->option_value}}</option>
                                          @endif
                                          @endif
                                          @endforeach
                                        </select>
                                        @elseif($attridata->frontend_type == "textarea")
                                        @if($attridata->required == 1)
                                        <textarea rows="4" class="editor form-control {{$attridata->code}} {{$attridata->frontend_type}}required" name="{{$attridata->attr_id}}" id="{{$attridata->attr_id}}" aria-describedby="{{$attridata->value}}Help" placeholder="Enter {{$attridata->name}}" maxlength="255">{{$attridata->value}}</textarea>
                                        @else
                                        <textarea rows="4" class="froala-editor form-control {{$attridata->code}} {{$attridata->frontend_type}}" name="{{$attridata->attr_id}}" id="{{$attridata->attr_id}}" aria-describedby="{{$attridata->value}}Help" placeholder="Enter {{$attridata->name}}" maxlength="255" >{{$attridata->value}}</textarea>
                                        @endif
                                        @elseif($attridata->frontend_type == "checkbox" || $attridata->frontend_type == "boolean")
                                          <input type="hidden" name="{{$attridata->attr_id}}" class="switchbntenv" rel="{{$attridata->attr_id}}-fill" id="{{$attridata->attr_id}}" value="{{$attridata->value}}" />
                                          <label class="switch">
                                          @if($attridata->required == 1)
                                          @if($attridata->value == "on" || $attridata->value == 1)
                                          <input required="required" checked="checked" type="checkbox" class="{{$attridata->code}} {{$attridata->frontend_type}}required" id="{{$attridata->attr_id}}-fill" aria-describedby="{{$attridata->value}}Help" placeholder="Enter {{$attridata->name}}" maxlength="255" >
                                          @else
                                          <input required="required" type="checkbox" class="{{$attridata->code}} {{$attridata->frontend_type}}required" id="{{$attridata->attr_id}}-fill" aria-describedby="{{$attridata->value}}Help" placeholder="Enter {{$attridata->name}}" maxlength="255" >
                                          @endif
                                          @else
                                          @if($attridata->value == "on" || $attridata->value == 1)
                                          <input type="checkbox" checked="checked" class="{{$attridata->code}} {{$attridata->frontend_type}}" id="{{$attridata->attr_id}}-fill" aria-describedby="{{$attridata->value}}Help" placeholder="Enter {{$attridata->value}}" maxlength="255">
                                          @else
                                          <input type="checkbox" class="{{$attridata->code}} {{$attridata->frontend_type}}" id="{{$attridata->attr_id}}-fill" aria-describedby="{{$attridata->value}}Help" placeholder="Enter {{$attridata->value}}" maxlength="255">
                                          @endif
                                          @endif
                                          <div class="slider round"></div>
                                        </label>
                                        @elseif($attridata->frontend_type == "price")
                                        <input type="number" class="form-control {{$attridata->attr_id}} numericOnlyField numericfields" name="{{$attridata->attr_id}}" id="{{$attridata->attr_id}}" aria-describedby="{{$attridata->attr_id}}Help" value="{{$attridata->value}}" placeholder="Enter {{$attridata->name}}" min="0" maxlength="255">
                                        @elseif($attridata->frontend_type == "number")
                                        <input type="{{$attridata->frontend_type}}" class="form-control {{$attridata->attr_id}} numericOnlyField numericfields" name="{{$attridata->attr_id}}" id="{{$attridata->attr_id}}" aria-describedby="{{$attridata->attr_id}}Help" value="{{$attridata->value}}" placeholder="Enter {{$attridata->name}}" min="0" maxlength="255" >
                                        @else
                                        @if($attridata->code == "name")
                                        <input type="{{$attridata->frontend_type}}" class="form-control specialcharremovename {{$attridata->attr_id}}" name="{{$attridata->attr_id}}" id="{{$attridata->attr_id}}" aria-describedby="{{$attridata->attr_id}}Help" value="{{$attridata->value}}" placeholder="Enter {{$attridata->name}}" maxlength="255">
                                        @else
                                        <input type="{{$attridata->frontend_type}}" class="form-control {{$attridata->attr_id}}" name="{{$attridata->attr_id}}" id="{{$attridata->attr_id}}" aria-describedby="{{$attridata->attr_id}}Help" value="{{$attridata->value}}" placeholder="Enter {{$attridata->name}}" maxlength="255">
                                        @endif
                                        @endif
                                      </div>
                                    </div>
                                  </div>
                                  @endif
                                  @endforeach
                                </div>
                              </div>
                              <div class="tab-pane fade" id="tab2primary">
                                <div class="tab2attributearea" >
                                  @foreach ($atributedata as $attridata)
                                  @if($attridata->additional_info == 1)
                                  <div class="col-xs-12 col-sm-6 {{$attridata->frontend_type == "textarea" ? "col-md-12" : "col-md-4"}}">
                                    <div class="form-group">
                                      <div class="col-xs-12 col-sm-12 col-md-12"><label for="Input{{$attridata->attr_id}}">{{$attridata->name}}</label></div>
                                      <div class="col-xs-12 col-sm-12 col-md-12">
                                        @if($attridata->frontend_type == "select")
                                        <select class="form-control {{$attridata->attr_id}}" name="{{$attridata->attr_id}}" id="{{$attridata->attr_id}}" aria-describedby="{{$attridata->attr_id}}Help" >
                                          <option value=''>Select {{$attridata->name}}</option>
                                          @foreach($attr_option_value as $attr_option_val)
                                          @if($attr_option_val->attribute_id == $attridata->sf_attributeid)
                                          @if($attr_option_val->option_id == $attridata->value)
                                          <option value="{{$attr_option_val->option_id}}" selected="selected">{{$attr_option_val->option_value}}</option>
                                          @else
                                          <option value="{{$attr_option_val->option_id}}">{{$attr_option_val->option_value}}</option>
                                          @endif
                                          @endif
                                          @endforeach
                                        </select>
                                        @elseif($attridata->frontend_type == "textarea")
                                        @if($attridata->required == 1)
                                        <textarea rows="4" class="editor form-control {{$attridata->code}} {{$attridata->frontend_type}}required" name="{{$attridata->attr_id}}" id="{{$attridata->attr_id}}" aria-describedby="{{$attridata->value}}Help" placeholder="Enter {{$attridata->name}}" maxlength="255">{{$attridata->value}}</textarea>
                                        @else
                                        <textarea rows="4" class="editor form-control {{$attridata->code}} {{$attridata->frontend_type}}" name="{{$attridata->attr_id}}" id="{{$attridata->attr_id}}" aria-describedby="{{$attridata->value}}Help" placeholder="Enter {{$attridata->name}}" maxlength="255" >{{$attridata->value}}</textarea>
                                        @endif
                                        @elseif($attridata->frontend_type == "checkbox" || $attridata->frontend_type == "boolean")
                                          <input type="hidden" name="{{$attridata->attr_id}}" class="switchbntenv" rel="{{$attridata->attr_id}}-fill" id="{{$attridata->attr_id}}" value="{{$attridata->value}}" />
                                          <label class="switch">
                                          @if($attridata->required == 1)
                                          <input required="required" type="checkbox" class="{{$attridata->code}}  {{$attridata->frontend_type}}required" id="{{$attridata->attr_id}}-fill" aria-describedby="{{$attridata->value}}Help" placeholder="Enter {{$attridata->name}}"  value="{{$attridata->value}}" maxlength="255" >
                                          @else
                                          <input type="checkbox" class="{{$attridata->code}} {{$attridata->frontend_type}}" id="{{$attridata->attr_id}}-fill" aria-describedby="{{$attridata->value}}Help" placeholder="Enter {{$attridata->value}}" maxlength="255">
                                          @endif
                                          <div class="slider round"></div>
                                        </label>
                                        @elseif($attridata->frontend_type == "price")
                                        <input type="number" class="form-control {{$attridata->attr_id}} numericOnlyField" name="{{$attridata->attr_id}}" id="{{$attridata->attr_id}}" aria-describedby="{{$attridata->attr_id}}Help" value="{{$attridata->value}}" placeholder="Enter {{$attridata->name}}" min="0" maxlength="255">
                                        @elseif($attridata->frontend_type == "number")
                                        <input type="{{$attridata->frontend_type}}" class="form-control {{$attridata->attr_id}} numericOnlyField" name="{{$attridata->attr_id}}" id="{{$attridata->attr_id}}" aria-describedby="{{$attridata->attr_id}}Help" value="{{$attridata->value}}" placeholder="Enter {{$attridata->name}}" min="0" maxlength="255" >
                                        @else
                                        <input type="{{$attridata->frontend_type}}" class="form-control {{$attridata->attr_id}}" name="{{$attridata->attr_id}}" id="{{$attridata->attr_id}}" aria-describedby="{{$attridata->attr_id}}Help" value="{{$attridata->value}}" placeholder="Enter {{$attridata->name}}" maxlength="255">
                                        @endif
                                      </div>
                                    </div>
                                  </div>
                                  @endif
                                  @endforeach
                                </div>
                              </div>
                              <div class="tab-pane fade" id="tab3primary">
                                <div class="laradrop"
                                  laradrop-csrf-token="<?php echo e(csrf_token()); ?>" > </div>
                              </div>
                              <div class="tab-pane fade" id="tab4primary" >
                                @foreach ($configurabledata as $condata)
                                <div class="row option-attribute-inner1 option-attribute-inner">
                                  <input type="hidden" id="conid" name="conid[]" class="conid" value="{{$condata->id}}" >
                                  <div class="box-header with-border">
                                    <div class="box-tools pull-right" style="display: block;">
                                      <button type="button" class="btn btn-box-tool addoptionattribute" style=""><i class="fa fa-plus"></i></button>
                                      <button type="button" class="btn btn-box-tool removeoptionattribute" style="display: none;"><i class="fa fa-remove"></i></button>
                                    </div>
                                  </div>
                                  <div class="form-group col-md-2 optattrinputs">
                                    <label for="Description">Option Attribute</label>
                                    <select id="optionalattr[]" name="optionalattr[]" class="optionalattr form-control validate">
                                      <option value="">Select Attribute</option>
                                      @foreach($configurableattrs as $con_att)
                                      <option value="{{$con_att->sf_attributeid}}" selected="selected">{{$con_att->name}}</option>
                                      @endforeach
                                    </select>
                                  </div>
                                  <div class="form-group col-md-2 descinputs">
                                    <label for="Description">Description</label>
                                    <select id="description[]" name="description[]" class="description form-control validate emptyfeildselect">
                                      <option value="">Select option</option>
                                      @foreach($attr_option_value_con as $attr_option_val_con)
                                      @if($attr_option_val_con->attribute_id == $condata->attribute_id)
                                      @if($attr_option_val_con->option_id == $condata->attribute_optid)
                                      <option value="{{$attr_option_val_con->option_id}}" selected="selected">{{$attr_option_val_con->option_value}}</option>
                                      @else
                                      <option value="{{$attr_option_val_con->option_id}}">{{$attr_option_val_con->option_value}}</option>
                                      @endif
                                      @endif
                                      @endforeach
                                    </select>
                                  </div>
                                  <div class="form-group col-md-2 qtyinputs">
                                    <label for="qty">Qty</label>
                                    <input type="number" id="qty[]" name="qty[]" class="qty form-control validate numericOnlyField emptyfeild" min="0" max="1000000" value="{{$condata->qty}}">
                                  </div>
                                  <div class="form-group col-md-2 priceinputs">
                                    <label for="price">Price</label>
                                    <input type="number" id="price[]" name="price[]" type="text" class="price form-control validate numericOnlyField emptyfeild" min="0" max="1000000" value="{{$condata->price}}">
                                  </div>
                                  <div class="form-group col-md-2">
                                    <label for="Status">Status</label>
                                    <select id="status[]" name="status[]" class="status form-control validate">
                                      @if($condata->status == 1)
                                      <option value="1" selected="selected">Enabled</option>
                                      <option value="2" >Disabled</option>
                                      @else
                                      <option value="1" >Enabled</option>
                                      <option value="2" selected="selected">Disabled</option>
                                      @endif
                                    </select>
                                  </div>

                                </div>
                                @endforeach
                              </div>
                            </div>
                          </div>
                        </div>
              </div>
          </div>
      </div>
      {!! Form::close() !!}

      <script>
        var categoryid = '{{$prod->categories_id}}';

        var allcategories;
        product.productupdateinit({
            configurableopturl: "<?php echo url('/products/configurableopt');?>",
            token:'<?php echo e(csrf_token()); ?>',
            getalll3categoriesurl:"<?php echo url('/products/getalll3categories');?>",
            vendor: '{{$vendor}}',
            attributeListByCategoryurl:'<?php echo url('/product/attributeListByCategory');?>',
            attributeListByattributeseturl: '<?php echo url('/product/attributeListByattributeset');?>',
            sampleCSVDownloadurl: '<?php echo url('/product/sampleCSVDownload');?>',
            searchajax:"<?php echo e(route('searchajax')); ?>",
            baseurl: '{{url('')}}',
            productid: '{{$id}}'
        });
      </script>
    @endif
</div>

@endsection