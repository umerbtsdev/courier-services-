@extends('adminlte::layouts.app')
@section('title','Create Products')
@section('content')

<div class = 'container-fluid'>
    <div class="col-md-12">
        <div class="flash-message">
          @foreach (['danger', 'warning', 'success', 'info'] as $msg)
          @if(Session::has('alert-' . $msg))
          <p class="alert alert-{{ $msg }}">{{ Session::get('alert-' . $msg) }} <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a></p>
          @endif
          @endforeach
        </div>
    </div>

    @if($isEnable == 1)
      <?php echo Form::open(array('url'=>'products/add','method'=>'POST', 'files'=>true, 'id'=>'product_data')); ?>
      <div class="row custom-container-wrap">
          <div class="col-md-12">
                  
              <div class="page-heading-primary">
                  <span>
                      <a href="#"> <i class="fa fa-home"></i> </a>
                      <i class="fa fa-angle-right"> &nbsp; </i>
                      <b> Product </b>
                      <i class="fa fa-angle-right"> &nbsp; </i>
                      <b> Create Product </b>
                  </span>
                  <h1>
                     <b>Add Product</b>

                     @if($createpermissions != 0)
                      <input class="custom-btn-action custom-btn-view bgcolr-orange" id="submit-product" type="submit" value="Submit">
                     @endif
                  </h1>
              </div>
              
          </div>

          <div class="custom-inner-container-wrap">
              <div class="col-md-12 product-view-wrap">
                  <div class="panel with-nav-tabs panel-primary">
                    <div class="panel-heading">
                      <ul class="nav nav-tabs">
                        <li class="active tab1primary" ><a href="#tab1primary" data-toggle="tab">Product Information</a></li>
                        <li class="tab2primary" ><a href="#tab2primary" data-toggle="tab">Additional Info</a></li>
                        <li class="tab3primary"><a href="#tab3primary" data-toggle="tab">Image</a></li>
                        <li  class="tab4primary"><a href="#tab4primary" data-toggle="tab">Configurable Options</a></li>
                      </ul>
                    </div>
                    <div class="panel-body">
                      <div class="tab-content">
                        <div class="tab-pane fade in active" id="tab1primary">

                          <!--                                <div class="col-xs-12 col-sm-6 col-md-6">-->
                          <!--                                    <div class="form-group">-->
                          <!--                                        <div class="col-xs-12 col-sm-12 col-md-12"> --><?php //echo Form::label('Universal Sku '); ?><!-- </div>-->
                          <!--                                        <div class="col-xs-12 col-sm-12 col-md-12"> --><?php //echo Form::text('universal_sku', null, array('placeholder' => 'universal sku','class' => 'form-control','id'=>'universal_sku')); ?><!--</div>-->
                          <!--                                    </div>-->
                          <!--                                </div>-->
                          <div class="col-xs-12 col-sm-6 col-md-4">
                            <div class="form-group">
                              <div class="col-xs-12 col-sm-12 col-md-12"><label>Category L1</label><span style="color: red;">*</span> </div>
                              <div class="col-xs-12 col-sm-12 col-md-12">
                                <select id="categoryl1" class="chosen-select form-control selectrequired" name="categoryl1">
                                  <option value="">Select Categories</option>
                                </select>
                              </div>
                            </div>
                          </div>
                          <div class="col-xs-12 col-sm-6 col-md-4">
                            <div class="form-group">
                              <div class="col-xs-12 col-sm-12 col-md-12"><label>Category L2</label><span style="color: red;">*</span> </div>
                              <div class="col-xs-12 col-sm-12 col-md-12">
                                <select id="categoryl2" class="chosen-select form-control selectrequired" name="categoryl2">
                                  <option value="">Select Categories</option>
                                </select>
                              </div>
                            </div>
                          </div>
                          <div class="col-xs-12 col-sm-6 col-md-4">
                            <div class="form-group">
                              <div class="col-xs-12 col-sm-12 col-md-12"><label>Category L3</label><span style="color: red;">*</span> </div>
                              <div class="col-xs-12 col-sm-12 col-md-12">
                                <select id="categoryl3" class="chosen-select form-control selectrequired" name="categoryl3">
                                  <option value="">Select Categories</option>
                                </select>
                              </div>
                            </div>
                          </div>
                            <div class="col-xs-12 col-sm-6 col-md-4">
                                <div class="form-group">
                                    <div class="col-xs-12 col-sm-12 col-md-12"><label>Category L4</label><span style="color: red;">*</span> </div>
                                    <div class="col-xs-12 col-sm-12 col-md-12">
                                        <select id="categories" class="chosen-select form-control selectrequired" name="categories">
                                            <option value="">Select Categories</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                          <div class="col-xs-12 col-sm-6 col-md-4">
                            <div class="form-group">
                              <div class="col-xs-12 col-sm-12 col-md-12"><label>Sku</label><span style="color: red;">*</span></div>
                              <div class="col-xs-12 col-sm-12 col-md-12"><input placeholder="sku" class="form-control textrequired specialcharremovesku" id="sku" name="sku" type="text" maxlength="100"></div>
                            </div>
                          </div>
                          @if($vendor == 0)
                          <div class="col-xs-12 col-sm-6 col-md-4">
                            <div class="form-group">
                              <div class="col-xs-12 col-sm-12 col-md-12"><label>Vendor</label><span style="color: red;">*</span> </div>
                              <div class="col-xs-12 col-sm-12 col-md-12">
                                <select id="vendor" data-placeholder="Choose a Vendor..."  class="chosen-select form-control selectrequired" name="vendor">
                                  <option value="">Select Vendor</option>
                                  @foreach ($allvendors as $allvendor)
                                  <option value="{{$allvendor->id}}">{{$allvendor->name}}</option>
                                  @endforeach
                                </select>
                              </div>
                            </div>
                          </div>
                          @else
                          <input type="hidden" id="vendor" name="vendor" value="{{$vendor}}">
                          @endif
                          <input type="hidden" placeholder="Qty Stocking" class="form-control " value="0" id="qty_stocking" name="qty_stocking" >
                          <div class="col-xs-12 col-sm-6 col-md-4">
                            <div class="form-group">
                              <div class="col-xs-12 col-sm-12 col-md-12"><label>Qty</label><span style="color: red;">*</span> </div>
                              <div class="col-xs-12 col-sm-12 col-md-12"><input type="number" placeholder="Qty" class="form-control numberrequired numericOnlyField" id="qty_dropship" name="qty_dropship" min="0" max="100000" ></div>
                            </div>
                          </div>
                          <input type="hidden" class="form-control attribute_sets" name="attribute_sets" id="attribute_sets" aria-describedby="attribute_sets_Help" placeholder="Enter attribute_sets">
                          <div class="tab1attributearea" >
                          </div>
                        </div>
                        <div class="tab-pane fade" id="tab2primary">
                          <div class="tab2attributearea" >
                          </div>
                        </div>
                        <div class="tab-pane fade" id="tab3primary">
                          <div class="laradrop"
                            laradrop-file-source="<?php echo e(route('product.imagesave')); ?>"
                            laradrop-upload-handler="<?php echo e(route('product.store')); ?>"
                            laradrop-file-delete-handler="<?php echo e(route('product.imagedestroy', 0)); ?>"
                            laradrop-file-move-handler="<?php echo e(route('product.move')); ?>"
                            laradrop-file-create-handler="<?php echo e(route('product.imagecreate')); ?>"
                            laradrop-containers="<?php echo e(route('product.containers')); ?>"
                            laradrop-csrf-token="<?php echo e(csrf_token()); ?>"> </div>
                        </div>
                        <div class="tab-pane fade" id="tab4primary" >
                          <div class="row option-attribute-inner1 option-attribute-inner">
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
                              </select>
                            </div>
                            <div class="form-group col-md-2 descinputs">
                              <label for="Description">Description</label>
                              <select id="description[]" name="description[]" class="description desc_config form-control validate emptyfeildselect">
                                <option value="">Select option</option>
                              </select>
                            </div>
                            <div class="form-group col-md-2 qtyinputs">
                              <label for="qty">Qty</label>
                              <input type="number" id="qty[]" name="qty[]" class="qty form-control validate numericOnlyField emptyfeild" min="0" >
                            </div>
                            <div class="form-group col-md-2 priceinputs">
                              <label for="price">Price</label>
                              <input type="number" id="price[]" name="price[]" type="text" class="price form-control validate numericOnlyField emptyfeild" min="0" >
                            </div>
                            <div class="form-group col-md-2">
                              <label for="Status">Status</label>
                              <select id="status[]" name="status[]" class="status form-control validate">
                                <option value="1">Enabled</option>
                                <option value="2">Disabled</option>
                              </select>
                            </div>

                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
              </div>
          </div>
      </div>

                </div>

            </div>
            <?php echo Form::close(); ?>

            <script>
                var productvalidrule = [];
                var allcategories;

                @foreach ($ProductValidRule as $rule)
                    product.validationrule('{{$rule->FirstAttrId}}','{{$rule->secondAttrId}}','{{$rule->validate}}');
                 @endforeach

                product.productcreateinit({
                    configurableopturl: "<?php echo url('/products/configurableopt');?>",
                    token:'<?php echo e(csrf_token()); ?>',
                    getalll3categoriesurl:"<?php echo url('/products/getalll3categories');?>",
                    vendor: '{{$vendor}}',
                    attributeListByCategoryurl:'<?php echo url('/product/attributeListByCategory');?>',
                    attributeListByattributeseturl: '<?php echo url('/product/attributeListByattributeset');?>',
                    sampleCSVDownloadurl: '<?php echo url('/product/sampleCSVDownload');?>',
                    searchajax:"<?php echo e(route('searchajax')); ?>",
                    baseurl: '{{url('')}}',
                     duplicatesku:'<?php echo url('/products/duplicatesku');?>'
                });
      </script>
    @endif
</div>

@endsection
