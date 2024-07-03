<div class = 'container-fluid'>

    <form action="{{url('trip/updatesave/'.$tripdata->id)}}" id='purchase-order-form' method = "post"  autocomplete="off">
        {!! csrf_field() !!}
        <div class="col-sm-10">

        </div>
        <button style="float: right;" class = "custom-btn-action custom-btn-view bgcolr-orange no-margin" id="submit-dept" type="submit">Save</button>
        <div class="row custom-container-wrap">

            <!-- Main content -->
            <div class="col-md-12">
                <div class="nav-tabs-custom">
                    <ul class="nav nav-tabs">
                        <li class="active"><a href="#tripdetails" data-toggle="tab"><strong>Trip Detail</strong></a></li>
                        <li><a href="#routedetails" data-toggle="tab"><strong>Route Details</strong></a></li>
                        <li><a href="#expensedetails" data-toggle="tab"><strong>Expense Detail</strong></a></li>
                        <li><a href="#fueldetails" data-toggle="tab"><strong>Fuel Detail</strong></a></li>
                        <li><a href="#roadreceipt" class="rr_trip" data-toggle="tab"><strong>Link Trip</strong></a></li>
                    </ul>
                    <div class="tab-content">
                        <div class="active tab-pane tabBody" id="tripdetails">
                            <div class="row">
                                <div class="col-md-12">
                                <div class="box box-primary">
                                    <div class="box-header with-border">
                                        <h3 class="box-title">Vehicles info</h3>
                                    </div>
                                    <div class="col-md-4">
                                        <label>Vehicles:</label>
                                        <select class="form-control item selectrequired" class="form-control" name="vehicle_id" id="vehicle_id" >
                                            <option value="">Select Vehicles</option>
                                            @foreach($Vehicles as $Vehicle)
                                                @if($Vehicle->id == $tripdata->vehicle_id)
                                                    <option value="{{$Vehicle->id}}" rel="{{$Vehicle->brand_name}},{{$Vehicle->driver_name}},{{$Vehicle->reading_start}}" selected="selected">{{$Vehicle->vehicle_no}}</option>
                                                @else
                                                    <option value="{{$Vehicle->id}}" rel="{{$Vehicle->brand_name}},{{$Vehicle->driver_name}},{{$Vehicle->reading_start}}">{{$Vehicle->vehicle_no}}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-2">
                                        <label>Driver:</label>
                                        <input type="text" disabled="disabled" id="driver" class="form-control item_code" name=""  value="{{$Vehicle->driver_name}}">
                                    </div>
                                    <div class="col-md-2">
                                        <label>Brand:</label>
                                        <input type="text" disabled="disabled" id="brand" class="form-control item_co de" name=""  value="{{$Vehicle->brand_name}}">
                                    </div>
                                    <div class="col-md-4">
                                        <label>Meter Status</label>
                                        <select class="form-control item selectrequired" name="meter_status" id="meter_status">
                                            <option value="working" {{$tripdata->meter_status=="working" ? "selected=selected" : ""}}>
                                                Working
                                            </option>
                                            <option value="faulty" {{$tripdata->meter_status=="faulty" ? "selected=selected" : ""}}>
                                                Faulty
                                            </option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            </div>
                            <br/>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="box box-primary">
                                        <div class="box-header with-border">
                                            <h3 class="box-title">Main Info</h3>
                                        </div>
                                        <div class="col-md-12">
                                            <label>Cost Center:</label>
                                            <select class="form-control item selectrequired" name="cost_center" id="cost_center" >
                                                <option value="">Select Cost Center</option>
                                                @foreach($costcenters as $costcenter)
                                                    @if($tripdata->cost_center == $costcenter->id)
                                                        <option value="{{$costcenter->id}}" selected="selected">{{$costcenter->name}}</option>
                                                    @else
                                                        <option value="{{$costcenter->id}}" >{{$costcenter->name}}</option>
                                                    @endif
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-12">
                                            <label>Client:</label>
                                            <select class="form-control item selectrequired" name="client" id="client" >
                                                <option value="">Select Cost Center</option>
                                                @foreach($Customers as $Customer)
                                                        @if($tripdata->client == $Customer->id)
                                                            <option value="{{$Customer->id}}" selected="selected" >{{$Customer->name}}</option>
                                                        @else
                                                            <option value="{{$Customer->id}}" >{{$Customer->name}}</option>
                                                        @endif
                                                @endforeach
                                            </select>
                                        </div>


                                    </div>
                                    <div class="col-md-12">
                                        <label>Status</label>
                                        <select class="form-control item selectrequired" name="status_trip" id="status_trip">
                                            <option value="active" {{$tripdata->status_trip == "active"? "selected=selected" : ""}}>
                                                Active
                                            </option>
                                            <option value="approved" {{$tripdata->status_trip == "approved"? "selected=selected" : ""}}>
                                                Approved
                                            </option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="box box-primary">
                                        <div class="box-header with-border">
                                            <h3 class="box-title">Meter Management</h3>
                                        </div>
                                        <div class="col-md-12">
                                            <label>Reading Start:</label>
                                            <input type="number" class="form-control reading_start textrequired" name="reading_start" id="reading_start"  value="{{ $tripdata->reading_start }}">
                                        </div>
                                        <div class="col-md-12">
                                            <label>Reading End:</label>
                                            <input type="number" class="form-control reading_end" name="reading_end" id="reading_end"  value="{{ $tripdata->reading_end }}">
                                        </div>
                                        <div class="col-md-12">
                                            <label>Total Reading</label>
                                            <input type="number" disabled="disabled" class="form-control reading_total de" name="reading_total" id="reading_total" value="{{intval($tripdata->reading_end) - intval($tripdata->reading_start)  }}">
                                        </div>


                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="box box-primary">
                                        <div class="box-header with-border">
                                            <h3 class="box-title">Trip Timming</h3>
                                        </div>
                                        <div class="col-md-12">
                                            <label>Start DateTime:</label>
                                            <input type="datetime-local" class="form-control start_datetime textrequired" name="start_datetime" id="start_datetime"  value="{{date("Y-m-d\TH:i", strtotime($tripdata->start_datetime))}}">
                                        </div>
                                        <div class="col-md-12">
                                            <label>Expected Return DateTime:</label>
                                            <input type="datetime-local" class="form-control exp_return_datetime item_co" name="exp_return_datetime" id="exp_return_datetime"  value="{{date("Y-m-d\TH:i", strtotime($tripdata->exp_return_datetime))}}">
                                        </div>
                                        <div class="col-md-12">
                                            <label>End DateTime:</label>
                                            <input type="datetime-local" class="form-control end_datetime item_co" name="end_datetime" id="end_datetime"  value="{{date("Y-m-d\TH:i", strtotime($tripdata->end_datetime))}}">
                                        </div>

                                    </div>
                                </div>
                                <div class="col-md-12" style="padding: 10px">
                                    <div class="col-md-4">
                                        <label>Gate Pass#</label>
                                        <input type="text" class="form-control item_co" name="gate_pass_no" id="gate_pass_no"  value="{{ $tripdata->gate_pass_no }}">
                                    </div>
                                    <div class="col-md-4">
                                        <label >Remarks</label>
                                        <input class="form-control" name="remarks" id="remarks"  value="{{$tripdata->remarks }}">
                                    </div>
                                    <div class="col-md-4" >
                                        <label>Paid Amount</label>
                                        <input class="form-control paid_amount" name="paid_amount" id="paid_amount"  value="{{ $tripdata->paid_amount }}">
                                    </div>

                                </div>

                                <div class="col-md-12">
                                    <div class="box box-primary">
                                        <div class="box-header with-border">
                                            <h3 class="box-title">Trip Summary</h3>
                                        </div>
                                        <div class="col-md-4">
                                            <label>Total Fuel:</label>
                                            <input type="text" disabled="disabled" id="total_fuel_front" class="form-control total_fuel_front" name="total_fuel_front"  value="">
                                        </div>
                                        <div class="col-md-2">
                                            <label>Total Income</label>
                                            <input type="text" disabled="disabled" id="total_income_front" class="form-control total_income_front" name="total_income_front"  value="">
                                        </div>
                                        <div class="col-md-3">
                                            <label>Total Expense:</label>
                                            <input type="text" disabled="disabled" id="total_expense_front" class="form-control total_expense_front de" name="total_expense_front"  value="">
                                        </div>
                                        <div class="col-md-2">
                                            <label>Total KM:</label>
                                            <input type="text" disabled="disabled" id="total_km_front" class="form-control total_km_front de" name="total_KM_front"  value="">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane" id="routedetails" style="overflow-x: auto;">
                            <div>Route Details</div>
                            <div class="row">
                                <div class="col-md-12">
                                    <table id="routeList" class="table table-bordered table-striped">
                                        <thead>
                                        <tr>
                                            <th >Route From</th>
                                            <th >Route To</th>
                                            <th >Other</th>
                                            <th >Action</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($triproute as $triprou)
                                        <tr>
                                            <td class="col-md-2">
                                                <input type="hidden" name="route_id[]" id="route_id" class="route_id" value="{{$triprou->id}}">
                                                <label>Route</label>
                                                <select class="form-control route_from selectrequired" name="route_from[]" id="route_from[]" >
                                                    <option value="">Select Route</option>
                                                    @foreach($Routs as $Rout)
                                                        @if($triprou->route_from == $Rout->id)
                                                            <option selected="selected" value="{{$Rout->id}}">{{$Rout->name}}</option>
                                                        @else
                                                            <option value="{{$Rout->id}}">{{$Rout->name}}</option>
                                                        @endif

                                                    @endforeach
                                                </select>
                                                <label>Route Datetime</label>
                                                <input type="datetime-local" class="form-control route_from_datetime textrequired" name="route_from_datetime[]" id="route_from_datetime" value="{{date("Y-m-d\TH:i", strtotime($triprou->route_from_datetime))}}" placeholder="Enter Route from Date time">
                                                <label>Route Reading</label>
                                                <input type="number" class="form-control route_from_reading textrequired" name="route_from_reading[]" id="route_from_reading" value="{{$triprou->route_from_reading}}" placeholder="Enter From from Reading">
                                            </td>
                                            <td>
                                                <label>Route</label>
                                                <select class="form-control route_to selectrequired" name="route_to[]" id="route_to[]" >
                                                    <option value="">Select Route</option>
                                                    @foreach($Routs as $Rout)
                                                        @if($triprou->route_to == $Rout->id)
                                                            <option value="{{$Rout->id}}" selected="selected">{{$Rout->name}}</option>
                                                        @else
                                                            <option value="{{$Rout->id}}">{{$Rout->name}}</option>
                                                        @endif
                                                    @endforeach
                                                </select>
                                                <label>Route Datetime</label>
                                                <input type="datetime-local" class="form-control route_to_datetime textrequired" name="route_to_datetime[]" id="route_to_datetime" value="{{date("Y-m-d\TH:i", strtotime($triprou->route_to_datetime))}}" placeholder="Enter Route to Date time">
                                                <label>Route Reading</label>
                                                <input type="number" class="form-control route_to_reading textrequired" name="route_to_reading[]" id="route_to_reading" value="{{$triprou->route_to_reading}}" placeholder="Enter Route to Reading">
                                            </td>
                                            <td>
                                                <label>Total KM</label>
                                                <input type="number" readonly="readonly" class="form-control route_km textrequired" name="route_km[]" value="{{intval($triprou->route_to_reading) - intval($triprou->route_from_reading) }}" id="route_km" placeholder="Enter Route KM">
                                                <label>Remarks</label>
                                                <input type="text" class="form-control remarks textrequired" name="remarks[]" id="remarks" value="{{$triprou->remarks}}" placeholder="Enter Remarks">
                                                <label>Status</label>
                                                <select class="form-control item selectrequired" name="status[]" id="status[]">
                                                    <option value="Empty" {{$triprou->status == "Empty" ? "selected=selected" : ""}}>Empty</option>
                                                    <option value="Load" {{$triprou->status == "Load" ? "selected=selected" : ""}}>Load</option>
                                                </select>
                                            </td>
                                            <td>
                                                <button class="btnSubmit addbutton" style="padding: 0px; border: 0px; border-radius: 10px;" type="button"><img class="fa-plus-circle" src="{{ asset('images/Add.png')}}" style="width: 22px;" /> </button>
                                                <button style="padding: 0px; border: 0px; border-radius: 10px;" class="btnSubmit removebutton" type="button"><img class="fa-plus-circle" src="{{ asset('images/remove.jpg')}}" style="width: 22px;" /></button>
                                            </td>
                                        </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <div><div class="col-md-4" style="text-align: center;font-weight: bold;font-size: 20px;">Total KM</div><div style="text-align: center;font-weight: bold;font-size: 20px;" class="col-md-4 total_km"></div></div>
                            </div>
                        </div>
                        <div class="tab-pane" id="expensedetails" style="overflow-x: auto;">
                            <div>Expense Details</div>
                            <div class="row">
                                <div class="col-md-12">
                                    <table id="routeList" class="table table-bordered table-striped">
                                        <thead>
                                        <tr>
                                            <th >Expense Name</th>
                                            <th >Amount</th>
                                            <th >Action</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($tripexpense as $tripexp)
                                        <tr>
                                            <td class="col-md-2">
                                                <input type="hidden" name="exp_id[]" id="exp_id" class="exp_id" value="{{$tripexp->id}}">
                                                <select class="form-control expense_ac_id selectrequired" class="form-control" name="expense_ac_id[]" id="expense_ac_id[]" >
                                                    <option value="">Select Expense Account</option>>
                                                    @if($Accounts != null)
                                                        @foreach($Accounts as $Account)
                                                            @if($Account->type == "Expense")
                                                                @if($tripexp->expense_ac_id  == $Account->id)
                                                                    <option selected="selected" value="{{$Account->id}}">{{$Account->name}}</option>
                                                                @else
                                                                    <option value="{{$Account->id}}">{{$Account->name}}</option>
                                                                @endif
                                                            @endif
                                                        @endforeach
                                                    @endif
                                                </select>
                                            </td>
                                            <td class="col-md-2">
                                                <input type="text" class="form-control expense_amount" name="expense_amount[]" id="expense_amount" value="{{$tripexp->amount}}" placeholder="Enter Amount">
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
                                <div class="col-md-12"><div class="col-md-3" style="text-align: center;font-weight: bold;font-size: 20px;">Total Amount</div><div style="text-align: center;font-weight: bold;font-size: 20px;" class="col-md-3 total_amount_expense"></div></div>
                            </div>
                        </div>
                        <div class="tab-pane" id="fueldetails" style="overflow-x: auto;">
                            <div>Fuel Details</div>
                            <div class="row">
                                <div class="col-md-12">
                                    <table id="routeList" class="table table-bordered table-striped">
                                        <thead>
                                        <tr>
                                            <th >Decription</th>
                                            <th >Liter/Reading</th>
                                            <th >Rate/Amount</th>
                                            <th >Action</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($tripfuel as $tripfu)
                                        <tr>
                                            <td class="col-md-2">
                                                <input type="hidden" name="fuel_id[]" id="fuel_id" value="{{$tripfu->id}}">
                                                <label>Fuel Station</label>
                                                <select class="form-control fuel_station_id selectrequired" class="form-control" name="fuel_station_id[]" id="fuel_station_id[]" >
                                                    <option value="">Select Fuel Station</option>
                                                    @foreach($fuelstations as $fuelstation)
                                                        @if($tripfu->fuel_station_id == $fuelstation->id)
                                                            <option value="{{$fuelstation->id}}" selected="selected">{{$fuelstation->name}}</option>
                                                        @else
                                                            <option value="{{$fuelstation->id}}">{{$fuelstation->name}}</option>
                                                        @endif

                                                    @endforeach
                                                </select>
                                                <label>Account ID</label>
                                                <select class="form-control fuel_account_id selectrequired" class="form-control" name="fuel_account_id[]" id="fuel_account_id[]" >
                                                    <option value="">Select Account</option>
                                                    @foreach($Accounts as $Account)
                                                        @if($Account->type == "Fuel")
                                                            @if($tripfu->fuel_account_id == $Account->id)
                                                                <option selected="selected" value="{{$Account->id}}">{{$Account->name}}</option>
                                                                @else
                                                                <option value="{{$Account->id}}">{{$Account->name}}</option>
                                                                @endif
                                                        @endif
                                                    @endforeach
                                                </select>

                                            </td>
                                            <td class="col-md-2">
                                                <label>Liters</label>
                                                <input type="number" class="form-control fuel_liter textrequired" name="fuel_liter[]" id="fuel_liter" value="{{$tripfu->liter}}" placeholder="Enter fuel Liter">
                                                <label>Meter Reading</label>
                                                <input type="number" class="form-control fuel_meter_reading textrequired" name="fuel_meter_reading[]" id="fuel_meter_reading" value="{{$tripfu->fuel_meter_reading}}" placeholder="Enter Fuel Meter Reading">
                                            </td>
                                            <td class="col-md-2">
                                                <label>Rates</label>
                                                <input type="number" class="form-control fuel_rate textrequired" name="fuel_rate[]" id="fuel_rate" value="{{$tripfu->rate}}" placeholder="Enter fuel Rate">
                                                <label>Amount</label>
                                                <input type="number" readonly="readonly" class="form-control fuel_amount" name="fuel_amount[]" id="fuel_amount" value="{{$tripfu->amount}}" placeholder="Enter Fuel Amount">
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
                                <div class="col-md-12"><div class="col-md-3"></div><div class="col-md-3" style="text-align: center;font-weight: bold;font-size: 20px;">Total Amount</div><div style="text-align: center;font-weight: bold;font-size: 20px;" class="col-md-3 total_amount_fuel"></div></div>
                            </div>
                        </div>
                        <div class="tab-pane" id="roadreceipt" style="overflow-x: auto;">
                            <input type="hidden" name="roadreceipt_id_selected" id="roadreceipt_id_selected" value="{{$tripdata->roadreceipt_id}}">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group col-sm-6">
                                        <label for="roadreceipt_id" class="control-label required">Road Recipt </label>
                                        <select id="roadreceipt_id" class="form-control" required name="roadreceipt_id">
                                            <option value="">Select Road Receipt</option>
                                        </select>
                                    </div>
                                    <div class="form-group col-sm-6">
                                        <label for="project" class="control-label required">Project </label>
                                        <select id="project" class="form-control" required name="project">
                                            <option selected disabled>Select Project</option>
                                            @foreach($projects as $project )
                                                @if($project->id == $tripdata->project_id)
                                                    <option value="{{ $project->id}}" selected="selected">{{  $project->name }}</option>
                                                @else
                                                    <option value="{{ $project->id}}">{{  $project->name }}</option>
                                                @endif

                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-12"><div class="col-md-3"><label for="project" class="control-label required">Total Income </label></div>

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
        //jQuery("#reading_start").val(jQuery("#vehicle_id").find(":selected").attr("rel").split(',')[2])
        jQuery("#driver").val(jQuery("#vehicle_id").find(":selected").attr("rel").split(',')[1]);
        jQuery("#brand").val(jQuery("#vehicle_id").find(":selected").attr("rel").split(',')[0])
        fueltotal();
        routetotal();
        expense_total();
        income_total();

        jQuery("#vehicle_id").change(function(){
            jQuery("#reading_start").val(jQuery("#vehicle_id").find(":selected").attr("rel").split(',')[2])
            jQuery("#driver").val(jQuery("#vehicle_id").find(":selected").attr("rel").split(',')[1]);
            jQuery("#brand").val(jQuery("#vehicle_id").find(":selected").attr("rel").split(',')[0])
        });
        jQuery("table").on("click",".addbutton", function(){
            //if(CheckValidation())
            //{
            
            addnewrow(this)
            //}

        })
        function addnewrow(obj)
        {
            var clonerow = jQuery(obj).parent().parent().clone();
            jQuery(clonerow).find(".route_from_datetime").val("");
            jQuery(clonerow).find(".route_to_datetime").val("");
            jQuery(clonerow).find(".route_from_reading").val("");
            jQuery(clonerow).find(".route_to_reading").val("");
            jQuery(clonerow).find(".remarks").val("");
            if(jQuery(clonerow).find(".route_from_reading").val() == ""){
                jQuery(clonerow).find(".route_from").val(jQuery(obj).parent().parent().find(".route_to").val());
                jQuery(clonerow).find(".route_from_reading").val(jQuery(obj).parent().parent().find(".route_to_reading").val());

            }

            jQuery(clonerow).find(".expense_amount").val("");
            jQuery(clonerow).find(".fuel_description").val("");
            jQuery(clonerow).find(".fuel_amount").val("");
            jQuery(clonerow).find(".income_description").val("");
            jQuery(clonerow).find(".income_amount").val("");
            jQuery(clonerow).find(".fuel_liter").val("");
            jQuery(clonerow).find(".fuel_rate").val("");
            jQuery(obj).parent().parent().parent().append(clonerow);
        }
        jQuery.ajax({
            url: "{{url('roadreceipt-data')}}",
            type: "post",
            data: {
                "_token": "{{ csrf_token() }}",
                "vehicles": jQuery("#vehicle_id").val(),
                "customer": jQuery("#client").val(),
                "cost_center": jQuery("#cost_center").val(),

            },
            success: function(result){
                debugger;
                jQuery("#roadreceipt_id").find("option").remove();
                var option_data = JSON.parse(result)
                jQuery("#roadreceipt_id").append("<option value=''>Select Road Receipt</option>")
                for(var i = 0; i < option_data.length; i++)
                {
                    if(option_data[i].roadreceipt_id == null || option_data[i].roadreceipt_id == jQuery("#roadreceipt_id_selected").val())
                    {
                        jQuery("#roadreceipt_id").append("<option value='"+option_data[i].id+"' rel='"+option_data[i].rr_amount+"'>"+option_data[i].vehicle_no+" - " + option_data[i].cost_center_name+" - "+ option_data[i].customer_name +"</option>")
                    }

                }
                jQuery("#roadreceipt_id").val(jQuery("#roadreceipt_id_selected").val());
                jQuery(".total_amount_income").text(jQuery("#roadreceipt :selected").attr('rel'));
                jQuery("#total_income_front").val(jQuery("#roadreceipt :selected").attr('rel'));


            }
        });
        jQuery("#roadreceipt_id").change(function(){
            jQuery(".total_amount_income").text(jQuery("#roadreceipt :selected").attr('rel'));
            jQuery("#total_income_front").val(jQuery("#roadreceipt :selected").attr('rel'));
        })
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

        jQuery(".rr_trip").click(function(){
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
            jQuery.ajax({
                url: "{{url('roadreceipt-data')}}",
                type: "post",
                data: {
                    "_token": "{{ csrf_token() }}",
                    "vehicles": jQuery("#vehicle_id").val(),
                    "customer": jQuery("#client").val(),
                    "cost_center": jQuery("#cost_center").val(),

                },
                success: function(result){
                    //debugger;
                    jQuery("#roadreceipt_id").find("option").remove();
                    var option_data = JSON.parse(result)
                    jQuery("#roadreceipt_id").append("<option value=''>Select Road Receipt</option>")
                    for(var i = 0; i < option_data.length; i++)
                    {
                        if((option_data[i].roadreceipt_id == jQuery("#roadreceipt_id_selected").val()) || option_data[i].roadreceipt_id == null)
                        {
                            jQuery("#roadreceipt_id").append("<option value='"+option_data[i].id+"' rel='"+option_data[i].rr_amount+"' data-trip='"+ option_data[i].roadreceipt_id +"' >RR#"+option_data[i].id +" - "+option_data[i].vehicle_no+" - " + option_data[i].cost_center_name+" - "+ option_data[i].customer_name +"</option>")
                        }

                    }
                    jQuery("#roadreceipt_id").val(jQuery("#roadreceipt_id_selected").val());
                    jQuery(".total_amount_income").text(jQuery("#roadreceipt :selected").attr('rel'));
                    jQuery("#total_income_front").val(jQuery("#roadreceipt :selected").attr('rel'));
                    jQuery('.rr_trip').tab('show')


                }
            });
            return false;
        })

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
        function calculatekm(obj)
        {
            //$(obj).parent().parent().parent().find(".route_km").val(parseInt($(obj).parent().parent().parent().find(".route_to_reading").val() == "" ? "0" : $(obj).parent().parent().parent().find(".route_to_reading").val()) - parseInt($(obj).parent().parent().parent().find(".route_from_reading").val() == "" ? "0" : $(obj).parent().parent().parent().find(".route_from_reading").val()) );
            routetotal();
        }
        $("body").on("change",".fuel_liter",function(){
            jQuery(this).parent().parent().closest("tr").find('.fuel_amount').val(jQuery(this).parent().parent().closest("tr").find('.fuel_rate').val()*jQuery(this).parent().parent().closest("tr").find('.fuel_liter').val());
            fueltotal();
        })
        $("body").on("change",".fuel_rate",function(){
            jQuery(this).parent().parent().closest("tr").find('.fuel_amount').val(jQuery(this).parent().parent().closest("tr").find('.fuel_rate').val()*jQuery(this).parent().parent().closest("tr").find('.fuel_liter').val());
            fueltotal();
        })
        $("body").on("change",".route_km",function(){
            routetotal();
        })

        function routetotal(){
            $(".total_km").text("");
            $.each($(".route_km"),function(i, val){
                $($(".route_km")[i]).val(parseInt($($(".route_to_reading")[i]).val() == "" ? "0" : $($(".route_to_reading")[i]).val()) - parseInt($($(".route_from_reading")[i]).val() == "" ? "0" : $($(".route_from_reading")[i]).val()) );
                $(".total_km").text(parseInt($(".total_km").text() == "" ? "0": $(".total_km").text()) + parseInt($($(".route_km")[i]).val() == "" ? "0" : $($(".route_km")[i]).val()))
            })
            $(".total_km_front").val($(".total_km").text());
        }
        $("body").on("change",".expense_amount",function(){
            expense_total();
        })

        function expense_total(){
            $(".total_amount_expense").text("");
            $.each($(".expense_amount"),function(i, val){
                $(".total_amount_expense").text(parseInt($(".total_amount_expense").text() == "" ? "0": $(".total_amount_expense").text()) + parseInt($($(".expense_amount")[i]).val()))
            })
            $(".total_expense_front").val($(".total_amount_expense").text());
        }

        $("body").on("change",".fuel_amount",function(){
            fueltotal();
        })
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
            $(".total_amount_income").text("");
            $.each($(".income_amount"),function(i, val){
                $(".total_amount_income").text(parseInt($(".total_amount_income").text() == "" ? "0": $(".total_amount_income").text()) + parseInt($($(".income_amount ")[i]).val()))
            })
            $(".total_income_front").val($(".total_amount_income").text());
        }

        $("body").on("click", "#submit-dept", function () {
            
            if(jQuery(".route_from_reading").length > 0)
            {
                if(jQuery(".reading_start").val() == "")
                {
                    modelpopup("Meter Reading Start Should Be filled");
                    return false;
                }
                if(jQuery(jQuery(".route_from_reading")[0]).val() == "")
                {
                    modelpopup("Meter Reading From Should Be filled");
                    return false;
                }
                if(jQuery(jQuery(".route_from_reading")[0]).val() != jQuery(".reading_start").val()){
                    modelpopup("Meter Reading Start and Meter Reading From is not match");
                    return false;
                }
            }
            if(jQuery(".route_to_reading").length > 0){
                if(jQuery(".reading_end").val() == "")
                {
                    modelpopup("Meter Reading End Should Be filled");
                    return false;
                }
                if(jQuery(jQuery(".route_to_reading")[jQuery(".route_to_reading").length-1]).val() == "")
                {
                    modelpopup("Meter Reading To Should Be filled");
                    return false;
                }
                if(jQuery(jQuery(".route_to_reading")[jQuery(".route_to_reading").length-1]).val() != jQuery(".reading_end").val()){
                    modelpopup("Meter Reading End and Meter Reading To is not match");
                    return false;
                }
            }
            if(jQuery(".route_from_datetime").length > 0){
                if(jQuery(".start_datetime").val() == "")
                {
                    modelpopup("Start Date time Should Be filled");
                    return false;
                }
                if(jQuery(jQuery(".route_from_datetime")[0]).val() == "")
                {
                    modelpopup("From Date time To Should Be filled");
                    return false;
                }
                if(jQuery(jQuery(".route_from_datetime")[0]).val() != jQuery(".start_datetime").val()){
                    modelpopup("Start Date time and From Date time is not match");
                    return false;
                }
            }
            if(jQuery(".route_to_datetime").length > 0){
                if(jQuery(".end_datetime").val() == "")
                {
                    modelpopup("End Date time Should Be filled");
                    return false;
                }
                if(jQuery(jQuery(".route_to_datetime")[jQuery(".route_to_datetime").length - 1]).val() == "")
                {
                    modelpopup("To Date time Should Be filled");
                    return false;
                }
                if(jQuery(jQuery(".route_to_datetime")[jQuery(".route_to_datetime").length - 1]).val() != jQuery(".end_datetime").val()){
                    modelpopup("End Date time and To Date time is not match");
                    return false;
                }
            }

            if(parseFloat($(".paid_amount").val()) != (parseFloat($(".total_fuel_front").val())+parseFloat($(".total_expense_front").val()))){
               
                modelpopup("Total Fuel + Total Expense should equal to Paid Amount");
                return false;
            }
            //else{
            //  return false;
            //}

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
