<div class = 'container-fluid'>

    <form action="{{url('roadreceipt/updatesave/'.$RoadreceiptData->id)}}" id='purchase-order-form' method = "post"  autocomplete="off">
        {!! csrf_field() !!}
        <button style="float: right;" class = "custom-btn-action custom-btn-view bgcolr-orange no-margin" id="submit-dept" type="submit">Save</button>
        <div class="row custom-container-wrap">

            <!-- Main content -->
            <div class="col-md-12">
                <div class="nav-tabs-custom">
                    <ul class="nav nav-tabs">
                        <li class="active"><a href="#tripdetails" data-toggle="tab"><strong>Main Detail</strong></a></li>
                        <li><a href="#rrlink" class="rr_link" data-toggle="tab"><strong>Road Receipt Link</strong></a></li>
                    </ul>
                    <div class="tab-content">
                        <div class="active tab-pane tabBody" id="tripdetails">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="box box-primary">
                                        <div class="box-header with-border">
                                            <h3 class="box-title">Main info</h3>
                                        </div>
                                        <div class="col-md-4">
                                            <label>Vehicles:</label>
                                            <select class="form-control item selectrequired" class="form-control" name="vehicle_id" id="vehicle_id" >
                                                <option value="">Select Vehicles</option>
                                                @foreach($Vehicles as $Vehicle)
                                                    @if($RoadreceiptData->vehicle_id ==  $Vehicle->id)
                                                        <option selected value="{{$Vehicle->id}}" rel="{{$Vehicle->brand_name}},{{$Vehicle->driver_name}}">{{$Vehicle->vehicle_no}}</option>
                                                    @else
                                                        <option value="{{$Vehicle->id}}" rel="{{$Vehicle->brand_name}},{{$Vehicle->driver_name}}">{{$Vehicle->vehicle_no}}</option>
                                                    @endif

                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-2">
                                            <label>Driver:</label>
                                            <input type="text" disabled="disabled" id="driver" class="form-control item_code" name=""  value="">
                                        </div>
                                        <div class="col-md-2">
                                            <label>Brand:</label>
                                            <input type="text" disabled="disabled" id="brand" class="form-control item_co de" name=""  value="">
                                        </div>
                                        <div class="col-md-4">
                                            <label>Date:</label>
                                            <input type="date" id="rr_date" class="rr_date form-control item_co de" name="rr_date"  value="{{date("Y-m-d", strtotime($RoadreceiptData->rr_date))}}">
                                        </div>
                                        <div class="col-md-4">
                                            <label>Cost Center:</label>
                                            <select class="form-control item selectrequired" name="cost_center" id="cost_center" >
                                                <option value="">Select Cost Center</option>
                                                @foreach($cost_centers as $cost_center)
                                                    @if($RoadreceiptData->cost_center ==  $cost_center->id)
                                                        <option selected="selected" value="{{$cost_center->id}}" >{{$cost_center->name}}</option>
                                                    @else
                                                        <option value="{{$cost_center->id}}" >{{$cost_center->name}}</option>
                                                    @endif

                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-4">
                                            <label>Client:</label>
                                            <select class="form-control item selectrequired" name="client" id="client" >
                                                <option value="">Select Client </option>
                                                @foreach($Customers as $Customer)
                                                    @if($RoadreceiptData->client ==  $Customer->id)
                                                        <option selected="selected" value="{{$Customer->id}}" >{{$Customer->name}}</option>
                                                    @else
                                                        <option value="{{$Customer->id}}" >{{$Customer->name}}</option>
                                                    @endif

                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-4">
                                            <label>Status</label>
                                            <select class="form-control item selectrequired" name="rr_type" id="rr_type">
                                                <option value="own" {{$RoadreceiptData->rr_type == "own" ? "selected=selected" : ""}}>
                                                    Own
                                                </option>
                                                <option value="rental" {{$RoadreceiptData->rr_type == "rental" ? "selected=selected" : ""}}>
                                                    Rental
                                                </option>
                                                <option value="contractor" {{$RoadreceiptData->rr_type == "contractor" ? "selected=selected" : ""}}>
                                                    Contractor
                                                </option>
                                            </select>
                                        </div>
                                    </div>

                                </div>
                            </div>
                            <br/>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="box box-primary">

                                        <div class="row">
                                            <div class="col-md-12">
                                                <table id="routeList" class="table table-bordered table-striped">
                                                    <thead>
                                                    <tr>
                                                        <th >Income Account</th>
                                                        <th >description</th>
                                                        <th >Amount</th>
                                                        <th >Action</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    @foreach($Roadreceiptincome as $Roadreceiptin)
                                                    <tr>
                                                        <td class="col-md-2">
                                                        <input type="hidden" class="income_id" name="income_id[]" id="income_id" value="{{$Roadreceiptin->id}}">
                                                            <select class="form-control income_account_id selectrequired" class="form-control" name="income_account_id[]" id="income_account_id[]" >
                                                                <option value="">Select Account</option>>
                                                                @foreach($Accounts as $Account)
                                                                    @if($Account->type == "Income")
                                                                        @if($Roadreceiptin->income_ac_id == $Account->id)
                                                                            <option value="{{$Account->id}}" selected="selected">{{$Account->name}}</option>
                                                                        @else
                                                                            <option value="{{$Account->id}}">{{$Account->name}}</option>
                                                                        @endif

                                                                    @endif
                                                                @endforeach
                                                            </select>

                                                        </td>
                                                        <td class="col-md-2">
                                                            <input type="text" class="form-control income_description" name="income_description[]" id="income_description" value="{{$Roadreceiptin->description}}" placeholder="Enter Description">
                                                        </td>

                                                        <td class="col-md-1">
                                                            <input type="text" class="form-control income_amount textrequired" name="income_amount[]" id="income_amount" value="{{$Roadreceiptin->amount}}" placeholder="Enter Amount">
                                                        </td>
                                                        <td class="col-md-2">
                                                            <button class="btnSubmit addbutton" style="padding: 0px; border: 0px; border-radius: 10px;" type="button"><img class="fa-plus-circle" src="{{ asset('images/Add.png')}}" style="width: 22px;" /> </button>
                                                            <button style="padding: 0px; border: 0px; border-radius: 10px;" class="btnSubmit removebutton" type="button"><img class="fa-plus-circle" src="{{ asset('images/remove.jpg')}}" style="width: 22px;" /></button>
                                                        </td>
                                                    </tr>
                                                    @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                            <div class="col-md-12"><div class="col-md-3"></div><div class="col-md-3" style="text-align: center;font-weight: bold;font-size: 20px;">Total Amount</div><div style="text-align: center;font-weight: bold;font-size: 20px;" class="col-md-3 total_amount_income"></div></div>
                                        </div>
                                    </div>


                                </div>
                            </div>
                        </div>
                        <div class="tab-pane" id="rrlink">

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group col-sm-6">
                                        <input type="hidden" name="selected_rr" id="selected_rr" value="{{$RoadreceiptData->trip_id}}">
                                        <label for="trip_id" class="control-label required">Road Recipt </label>
                                        <select id="trip_id" class="form-control" required name="trip_id">
                                            <option value="">Select Road Receipt</option>

                                        </select>
                                    </div>
                                    <div class="form-group col-sm-6">
                                        <label for="project" class="control-label required">Project </label>
                                        <select id="project" class="form-control" required name="project">
                                            <option selected disabled>Select Project</option>
                                            @foreach($projects as $project )
                                                @if($RoadreceiptData->project_id == $project->id)
                                                    <option value="{{ $project->id}}" selected="selected">{{$project->name }}</option>
                                                @else
                                                    <option value="{{ $project->id}}">{{  $project->name }}</option>
                                                @endif

                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-12">


                                    <div style="text-align: center;font-weight: bold;font-size: 20px;" class="col-md-3 total_amount_income">

                                    </div>
                                </div>

                            </div>
                        </div>
                        <!-- /.tab-pane -->
                    </div>
                    <!-- /.tab-content -->
                </div>
                <!-- /.nav-tabs-custom -->
            </div>
            <!-- /.col -->


            <!-- /.content -->
        </div>
    </form>

    <script>
        product.productvalidate();
        income_total();
        jQuery("#driver").val(jQuery("#vehicle_id").find(":selected").attr("rel").split(',')[1]);
        jQuery("#brand").val(jQuery("#vehicle_id").find(":selected").attr("rel").split(',')[0])
        jQuery("#vehicle_id").change(function(){
            jQuery("#driver").val(jQuery("#vehicle_id").find(":selected").attr("rel").split(',')[1]);
            jQuery("#brand").val(jQuery("#vehicle_id").find(":selected").attr("rel").split(',')[0])
        });
        jQuery("table").on("click",".addbutton", function(){
            //if(CheckValidation())
            //{
            //debugger;
            addnewrow(this)
            //}

        })
        jQuery(".rr_link").click(function(){
            if(jQuery("#vehicle_id").val() == ""){
                modelpopup("Please Select the Vehicle first");
                return false;
            }
            if(jQuery("#cost_center").val() == ""){
                modelpopup("Please Select the Cost Center first");
                return false;
            }
            if(jQuery("#client").val() == ""){
                modelpopup("Please Select the Client first");
                return false;
            }
            var selected_value = jQuery("#selected_rr").val();
            jQuery.ajax({
                url: "{{url('roadreceipt/roadreceipt-data')}}",
                type: "post",
                data: {
                    "_token": "{{ csrf_token() }}",
                    "vehicles": jQuery("#vehicle_id").val(),
                    "customer": jQuery("#client").val(),
                    "cost_center": jQuery("#cost_center").val(),

                },
                success: function(result){
                    debugger;
                    jQuery("#trip_id").find("option").remove();
                    var option_data = JSON.parse(result)
                    jQuery("#trip_id").append("<option value=''>Select Road Receipt</option>")
                    for(var i = 0; i < option_data.length; i++)
                    {
                        if(option_data[i].roadreceipt_id == null || option_data[i].id == jQuery("#selected_rr").val()) {
                            jQuery("#trip_id").append("<option value='" + option_data[i].id + "' rel='" + option_data[i].rr_amount + "'> RR#" + option_data[i].id + " - " + option_data[i].vehicle_no + " - " + option_data[i].cost_center_name + " - " + option_data[i].customer_name + "</option>")
                        }
                    }
                    jQuery("#trip_id").val(selected_value);
                    jQuery('.rr_link').tab('show')
                }
            });
            return false;
        })
        function addnewrow(obj)
        {
            var clonerow = jQuery(obj).parent().parent().clone();

            jQuery(clonerow).find(".income_id").val("");
            jQuery(clonerow).find(".income_description").val("");
            jQuery(clonerow).find(".income_amount").val("");
            jQuery(obj).parent().parent().parent().append(clonerow);
        }
        jQuery("table").on("click",".removebutton", function(){
            if (jQuery(this).parent().parent().parent().find("tr").length > 1 )
            {
                jQuery(this).parent().parent().closest("tr").remove();
                // getGrandTotal();
                fueltotal();
                routetotal();
                expense_total();
                income_total();
            }

        });

        jQuery("table").on("keypress",".serialno", function(e){

            if(e.which == 13) {
                if(jQuery(this).closest("tr").find(".serialno").val() != "" && (parseFloat(jQuery(this).closest("tr").find(".qty").val() == "" ? 0 : jQuery(this).closest("tr").find(".qty").val()) < parseFloat(jQuery(this).closest("tr").find(".remainning_qty").val() == "" ? 0 : jQuery(this).closest("tr").find(".remainning_qty").val())) )
                {
                    var html= '<div class="serialdata-label">'
                    html +='<p class="serialdata-ptag" >';
                    html +='<span class="serial-dataspan">'+jQuery(this).closest("tr").find(".serialno").val()+'</span>';
                    html +='<button type="button" class="btn btn-box-tool remove-serialno"><i class="fa fa-times"></i></button></p>';
                    html +='</div>'
                    jQuery(this).closest("tr").find(".serialnodata").html(jQuery(this).closest("tr").find(".serialnodata").html()+html);

                    jQuery(this).closest("tr").find(".qty").val(parseFloat(jQuery(this).closest("tr").find(".qty").val() == "" ? 0 : jQuery(this).closest("tr").find(".qty").val())+1);
                    jQuery(this).closest("tr").find(".serialno").val("");
                }
                return false;
            }


        });

        $('#VehicleID').change(function() {
            $.ajax({
                url: "{{ url(Request::path().'/get_vehicles') }}",
                type: "POST",
                'headers': {'X-CSRF-TOKEN': '{{ csrf_token() }}'},
                data: {'VehicleID':$(this).val()},
                success: function (vcres) {
                    //console.log(vcres);
                    $('#driver').val(vcres.driver);
                    $('#brand').val(vcres.brand);

                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.log();
                }
            });
        });
        $("body").on("change",".reading_start",function(){
            $(".reading_total").val(parseInt($(".reading_end").val()) - parseInt($(".reading_start").val()) );
        });
        $("body").on("change",".reading_end",function(){
            $(".reading_total").val(parseInt($(".reading_end").val()) - parseInt($(".reading_start").val()) );
        });
        $("body").on("change",".route_from_reading",function(){
            calculatekm(this);
            //$(this).parent().parent().parent().find(".route_km").val(parseInt($(this).parent().parent().parent().find(".route_to_reading").val() == "" ? "0" : $(this).parent().parent().parent().find(".route_to_reading").val()) - parseInt($(this).parent().parent().parent().find(".route_from_reading").val() == "" ? "0" : $(this).parent().parent().parent().find(".route_from_reading").val()) );
        });
        $("body").on("change",".route_to_reading",function(){
            calculatekm(this);
            //$(this).parent().parent().parent().find(".route_km").val(parseInt($(this).parent().parent().parent().find(".route_to_reading").val() == "" ? "0" : $(this).parent().parent().parent().find(".route_to_reading").val()) - parseInt($(this).parent().parent().parent().find(".route_from_reading").val() == "" ? "0" : $(this).parent().parent().parent().find(".route_from_reading").val()) );
        });






        function fueltotal(){
            $(".total_amount_fuel").text("");
            $.each($(".fuel_amount"),function(i, val){
                $(".total_amount_fuel").text(parseInt($(".total_amount_fuel").text() == "" ? "0": $(".total_amount_fuel").text()) + parseInt($($(".fuel_amount")[i]).val()))
            })
            $(".total_fuel_front").val($(".total_amount_fuel").text());
        }
        $("body").on("change",".income_amount",function(){
            income_total();
        })

        function income_total(){
            var total_amount_income = 0;
            //$(".total_amount_income").text("");

            $.each($(".income_amount"),function(i, val){
                total_amount_income = parseInt(total_amount_income) + parseInt($($(".income_amount ")[i]).val());
            })
            $(".total_amount_income").text(total_amount_income);
            $(".total_income_front").val(total_amount_income);
        }


        $("body").on("click", "#submit-dept", function () {

            if ($("#purchase-order-form").valid() == true) {
                return true;
            }
            else {
                return false;
            }


        })
        function modelpopup(text){
            jQuery('.custom-modal-ics-inner').modal('show');

            jQuery('.custom-modal-title-inner').html("Alert");//SET TITLE
            jQuery('.custom-modal-body-ics-inner').html("<div>"+ text +"</div>");//SET BODY

            //SHOW LOADER B/C AJAX EVENT NOT CALL AFTER ONCOLSE IN JQGRI
        }
    </script>
</div>