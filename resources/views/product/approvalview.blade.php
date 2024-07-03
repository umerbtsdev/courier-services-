
           <div class="row">

            {!! Form::open(array('url'=>'products/addapprovereject','method'=>'POST', 'files'=>true, 'id'=>'approval_data')) !!}
            <input type="hidden" id="product_id" name="product_id" value="{{$id}}">

            <div class="row" style="padding-bottom: 10px;">
                <div class="col-md-9" >
                    <div class="rejectcommentsiddiv">
                        <select name="rejectcommentsid" id="rejectcommentsid" style="width: 100%;" class="form-control selectrequired">
                            <option value="">Select..</option>
                            @foreach ($rejectcomment as $rejectcom)
                                <option value="{{$rejectcom->id}}">{{$rejectcom->comments}}</option>
                            @endforeach
                        </select>
                        @foreach ($productauths as $productauth)
                            @if($productauth->name == $type)
                                <input type="hidden" id="role_id" name="role_id" value="{{$productauth->id}}">
                            @elseif($productauth->name == $type)
                                <input type="hidden" id="role_id" name="role_id" value="{{$productauth->id}}">
                            @endif
                        @endforeach
                    </div>
                </div>
                <div class="col-md-3">
                    <select name="type" id="type" style="width: 100%;" class="form-control selectrequired">
                        <option value="">Select..</option>
                        <option value="approve">Approve</option>
                        <option value="reject">Reject</option>
                    </select>
                </div>
            </div>
            <div class="row"  >
                <div class="col-md-12">
                    <textarea rows="4"  class="form-control textarearequired" style="width: 100%;" id="comment" name="comment" placeholder="Comments" maxlength="255" ></textarea>
                </div>
                  
                <div class="col-md-3" style="margin: 10px 0px;">
                    <input type="submit" class="btn btn-lg bgcolr-orange  submit-comments" type="button" value="Submit Comment">
                </div>
            </div>
            {!! Form::close() !!}

            <div class="col-md-12 product-view-wrap no-padding">

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
                                    <table class="table table-striped">
                                        <tbody>
                                        <tr>
                                            <td>
                                                Sku
                                            </td>
                                            <td>
                                                {{$prod->sku}}
                                            </td>
                                            <td>
                                                Vendor
                                            </td>
                                            <td>
                                                {{$prod->vendor_name}}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                Category
                                            </td>
                                            <td>
                                                {{$prod->categoryname}}
                                            </td>
                                            <td>
                                                Mode of Fullfillment
                                            </td>
                                            <td>
                                                {{$prod->fulfillment_name}}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <div>Qty</div>
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
                                                Attribute Sets
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
                                                            {{$attridata->name}}
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
                            <div class="tab-pane fade" id="tab2primary">

                                <div class="tab2attributearea" >
                                    <table class="table table-striped">
                                        <tbody>
                                        <?php $count= 0 ?>

                                        @foreach ($atributedata as $attridata)
                                            @if($attridata->additional_info == 1)
                                                <?php $mod = $count % 2; ?>
                                                @if($mod == 0)
                                                    <tr>
                                                        @endif
                                                        <td>
                                                            {{$attridata->name}}
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
                                                                {{$attridata->value}}
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
                                            <a href="{{url("uploads/".$file->filename)}}" title="{{$file->filename}}"><img src="{{url("public/uploads/".$file->filename)}}" width="150" height="150" /></a>
                                        @endforeach
                                    </div>
                                </div>
                                @if($files_old->count() > 0)
                                    <div class="col-md-12">
                                        <span style="font-weight: bold;"> Old Images </span>
                                        <div class="popup-gallery">

                                            @foreach($files_old as $file)
                                                <a href="{{url("uploads/".$file->filename)}}" title="{{$file->filename}}"><img src="{{url("public/uploads/".$file->filename)}}" width="150" height="150" /></a>
                                            @endforeach
                                        </div>
                                    </div>
                                @endif
                            </div>
                            <div class="tab-pane fade" id="tab4primary">
                                <div class="col-md-12">
                                    <table class="table table-striped">
                                        <head>
                                            <th class="config-size">Option Attribute</th>
                                            <th class="config-size">Description</th>
                                            <th class="config-size">Qty</th>
                                            <th class="config-size">Qty Old Value</th>
                                            <th class="config-size">Price</th>
                                            <th class="config-size">Price Old Value</th>
                                            <th class="config-size">Status</th>
                                            <th class="config-size">Status old</th>
                                            <th class="config-size">Cost</th>
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

            </div>


        </div>
    <script>

        $( document ).ready(function() {
            jQuery(document).ready(function() {
                jQuery('.popup-gallery').magnificPopup({
                    delegate: 'a',
                    type: 'image',
                    tLoading: 'Loading image #%curr%...',
                    mainClass: 'mfp-img-mobile',
                    gallery: {
                        enabled: true,
                        navigateByImgClick: true,
                        preload: [0,1] // Will preload 0 - before current, and 1 after the current image
                    },
                    image: {
                        tError: '<a href="%url%">The image #%curr%</a> could not be loaded.',
                        titleSrc: function(item) {
                            return item.el.attr('title') + '<small>by TCS Ecom</small>';
                        }
                    }
                });
            });
            $("#type").change(function(){
                if($(this).val() == "approve")
                {
                    $('#comment').rules('add', {
                        required: false   // set a new rule
                    });
                    $('#rejectcommentsid').rules('add', {
                        required: false   // set a new rule
                    });
                    $('#rejectcommentsid').val('');
                    $('#rejectcommentsid').prop('disabled', true);
                }
                else
                {
                    $('#comment').rules('add', {
                        required: true   // set a new rule
                    });
                    $('#rejectcommentsid').rules('add', {
                        required: true   // set a new rule
                    });
                    $('#rejectcommentsid').prop('disabled', false);
                }

            });

            $(".submit-comments").click(function(){

                if($("#approval_data").valid() == true)
                {
                    $("#approval_data").submit();
                }
                else{
                    return false;
                }
            })
            $("#approval_data").validate({
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
                ignore: "ui-tabs-hide"
            });
            jQuery.validator.addClassRules("textarearequired", {
                required: true,
            });
            jQuery.validator.addClassRules("selectrequired", {
                required: true,
            });
        });
    </script>