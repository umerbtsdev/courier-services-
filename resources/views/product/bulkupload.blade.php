@extends('adminlte::layouts.app')
@section('title','Bulk Upload')
@section('content')

<script src="https://cdn.jsdelivr.net/jquery.validation/1.15.0/additional-methods.min.js"></script>

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
    <div class="row custom-container-wrap product-bulk-upload">
        <div class="col-md-12">
                
            <div class="page-heading-primary">
                <span>
                    <!-- breadcrums -->
                    <a href="#"> <i class="fa fa-home"></i> </a>
                    <i class="fa fa-angle-right"> &nbsp; </i>
                    <b> Product </b>
                    <i class="fa fa-angle-right"> &nbsp; </i>
                    <b> PRODUCT BULK UPLOAD </b>
                    <!-- breadcrums -->
                </span>
                <h1>
                    <b> Product Bulk Upload </b>

                    <!-- button -->
                        <!-- button goes here with classes "viewproduct custom-btn-view bgcolr-aqua" -->
                    <!-- button -->
                </h1>
            </div>
            
        </div>

        <div class="custom-inner-container-wrap">
            <div class="col-md-12 custom-table-styles">
                @if($isEnable == 1)
                    <div class="form-group csvUploadField" >
                      <div class="">
                          <div class="col-md-7" style="background: #f3f3f3;">
                            {!! Form::open(array('url'=>'product/bulkproductSubmit','method'=>'POST','id'=>'bluk_product_form', 'files'=>true)) !!}
                            <div class="col-md-6 no-padding csv-wrap" style="height: 180px;">
                              <div class="col-md-3 bulk-img-wrap no-padding">
                                <img src="{{ url('img/custom')}}/icon-csv-lg.png" style="height: 50px">
                              </div>

                              <div class="col-md-9 no-padding">
                                <h3 class="sub-heading"> Upload Product CSV </h3>
                                <p class="help-block uploaded-file-name" style="clear: both; display: block;">upload your csv here.</p>
                                <!-- <span class="uploaded-file-name" style="height: 20px; display: block;"></span> -->
                                <div class="btn_upload_wrapper">
                                  <input type="file" class="imagerequired" id="product_csv" name="product_csv">
                                  <em class="viewproduct custom-btn-view bgcolr-aqua">
                                    <i class="fa fa-upload"></i>
                                    Choose File
                                  </em>
                                </div>

                              </div>
                            </div>
                            <div class="col-md-6 no-padding zip-wrap" style="height: 180px;">
                              <div class="col-md-3 bulk-img-wrap no-padding">
                                <img src="{{ url('img/custom')}}/icon-zip-lg.png" style="height: 50px">
                              </div>
                              <div class="col-md-9 no-padding">
                                <h3 class="sub-heading"> Upload Product Image Zip </h3>
                                <p class="help-block uploaded-file-name" style="clear: both; display: block;">upload your Image Zip file.</p>
                                
                                <!-- <span class="uploaded-file-name" style="height: 20px; display: block;"></span> -->
                                <div class="btn_upload_wrapper">
                                  <input type="file" class="" id="product_image" name="product_image">
                                  <em class="viewproduct custom-btn-view bgcolr-aqua">
                                    <i class="fa fa-upload"></i>
                                    Choose File
                                  </em>
                                </div>
                              </div>
                            </div>
                            <div class="col-md-12 no-padding">
                              {!! Form::submit('Click to upload', array('style'=>'width: 100%; padding: 20px; font-size: 20px; text-transform: uppercase; margin-bottom: 15px;', 'class'=>'btn btn btn-primary bgcolr-orange btn-primary bulkuploadbtn')) !!}
                              {!! Form::close() !!}
                            </div>
                          </div>
                          <div class="col-md-5" style="background: #fff;">
                              <div class="col-md-3 bulk-img-wrap no-padding" style="height: 180px;">
                                <img src="{{ url('img/custom')}}/icon-download-lg.png" style="height: 50px">
                              </div>
                              <div class="col-md-9 no-padding">
                                <div class="form-group <?php echo e($errors->has('parent_id') ? 'has-error' : ''); ?>">
                                    {!! Form::open(array('url'=>'/product/sampleCSVDownload','method'=>'POST','id'=>'bluk_product_csv', 'files'=>true)) !!}
                                    <div class="">
                                        <h3 class="sub-heading"> Download Sample Categories </h3>
                                        <select id="categories" class="chosen-select form-control selectrequired" name="categories[]">
                                            <option value="">Select L3 Category</option>
                                            @foreach ($allcategories as $allcategory)
                                                <option value="{{$allcategory->id}}">{{$allcategory->l2catname}}/{{$allcategory->l3catname}}/{{$allcategory->l4catname}}/{{$allcategory->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <span class="text-danger"><?php echo e($errors->first('parent_id')); ?></span>
                                </div>
                                
                                <!-- <p class="help-block ">Click <input type="submit" class="csv_download_button" value="Here" style="background: transparent; border: 0px; color: blue; text-decoration: underline; padding: 0px;"></input> to download the sample of above mention categories </p> -->
                              </div>
                              <div class="col-md-12 no-padding">
                                <input type="submit" class="btn btn-primary csv_download_button bgcolr-aqua" value="Download sample categories" style="width: 100%; padding: 20px; font-size: 20px; text-transform: uppercase; margin-bottom: 15px;"></input>
                              </div>
                              {!! Form::close() !!}
                          </div>
                      </div>
                    </div>
                    
                    <!-- <div class="box-footer"></div> -->
                    @foreach ($responce as $res)
                        @if(strpos($res,"Succesfully") !== false)
                            <p class="success-log">{{$res}}</p>
                            @else
                            <p class="error-log" ><?php echo $res;?></p>
                        @endif
                    @endforeach
                  @endif
            </div>
        </div>
    </div>
</div>


<script>
    jQuery(document).ready(function(){
 $(".bulkuploadbtn").click(function(){
     if($("#bluk_product_form").valid())
     {
         $(this).val("Please Wait...");
         $(".bulkuploadbtn").prop('disabled', true);
         $("#bluk_product_form").submit();
     }
 })
        $(".csv_download_button").click(function(){
            if($("#bluk_product_csv").valid())
            {
                $("#bluk_product_csv").submit();
            }
        })
    $("#bluk_product_form").validate({
        errorElement: 'span',
        errorClass: 'help-block error-help-block',

        errorPlacement: function (error, element) {
            if (element.parent('.input-group').length ||
                element.prop('type') === 'checkbox' || element.prop('type') === 'radio') {
                error.insertAfter(element.parent());
                // else just place the validation message immediatly after the input
            } else {
                error.insertAfter(element);
            }
        },
        highlight: function (element) {
            $(element).closest('.form-group').removeClass('has-success').addClass('has-error'); // add the Bootstrap error class to the control group
        },
        focusInvalid: false, // do not focus the last invalid input
        ignore: "ui-tabs-hide",
        rules: {
            "product_csv": {
                required: true,
                extension: "csv"
            },
            "product_image": {
                extension: "zip",
                filesize: 300000000
            }
        }
    });

        $.validator.addMethod('filesize', function(value, element, param) {
            // param = size (en bytes)
            // element = element to validate (<input>)
            // value = value of the element (file name)
            return this.optional(element) || (element.files[0].size <= param)
        },"File Size is Exceed from 300MB ");

     });
    $("#bluk_product_csv").validate({
        errorElement: 'span',
        errorClass: 'help-block error-help-block',

        errorPlacement: function (error, element) {
            if (element.parent('.input-group').length ||
                element.prop('type') === 'checkbox' || element.prop('type') === 'radio') {
                error.insertAfter(element.parent());
                // else just place the validation message immediatly after the input
            } else if (element.attr("id") == "categories") {
                error.insertAfter(element.parent().find(".chosen-container"));
            }else {
                error.insertAfter(element);
            }
        },
        highlight: function (element) {
            $(element).closest('.form-group').removeClass('has-success').addClass('has-error'); // add the Bootstrap error class to the control group
        },
        focusInvalid: false, // do not focus the last invalid input
        ignore: "ui-tabs-hide",
        rules: {
            "categories": {
                required: true
            }
        }
    });

    jQuery('input:file').change(
          function(e){
            var uploaded_file_name = jQuery(this).val().split('\\').pop();
            jQuery(this).parent().parent().find('.uploaded-file-name').html("<i class='fa fa-chevron-right' style='font-size: 10px; margin-right: 6px;'> </i>"+uploaded_file_name);
              // console.log(uploaded_file_name);
          });
</script>

@endsection
