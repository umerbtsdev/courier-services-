<style>
    .required:after {
        content:"*";
        color:red;
    }
</style>
<div class = 'container-fluid'>

    
        {!! Form::open(array('url'=>'/workshops/schedule-job-processing/job/save','method'=>'POST','id'=>'purchase-order-form', 'class'=>"form-inline", 'autocomplete' => "off")) !!}
        <div class="col-md-12" style="padding:0; margin-bottom:4%;">
            <div class="col-md-10">
                <div class="form-group col-sm-4">
                    <label for="dated" class="control-label required">Date </label>
                    {!! Form::date("dated", $maintenance_request_schedule->sjp_date, ["id"=>"dated", "class"=>"form-control",'disabled']) !!}
                </div>
                <div class="form-group col-sm-4">
                    <label for="job_date" class="control-label required">Workshop </label>
                    <select id="workshops" class="form-control" required name="workshop">
                        @foreach ($workshops as $workshop)
                            <option value="{{ $workshop->workshop_id}}">{{  $workshop->workshop_name }}</option>                            
                        @endforeach
                    </select>
                </div>
                <div class="form-group col-sm-3">
                    <label for="vehicle" class="control-label required">Vehicle</label>
                    {!! Form::text("vehicle_id_no", $maintenance_request_schedule->vehicle_no, ["id"=>"vehicle", "class"=>"form-control",'disabled']) !!}
                </div>
                <div class="form-group col-sm-2">
                    <label for="project" class="control-label required">Project </label>
                    <select id="project" class="form-control" required name="project">
                        <option selected disabled>Select Project</option>
                        @foreach($projects as $project )
                            <option value="{{ $project->id}}">{{  $project->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-md-2">
                <button style="float: right;" class = "custom-btn-action custom-btn-view bgcolr-orange no-margin" id="submit-dept" type="submit">Save</button>
            </div>
        </div>
        <br/>
        <div class="row custom-container-wrap">
            <br/>
            <!-- Main content -->
                <div class="col-md-12">
                <div class="nav-tabs-custom">
                    <ul class="nav nav-tabs">
                        <li class="active"><a href="#servicedetails" data-toggle="tab" class="required"><strong>Services </strong></a></li>
                        <li><a href="#externalparts" data-toggle="tab" class="required"><strong>External Parts </strong></a></li>


                    </ul>
                    <div class="tab-content">

                        <div class="active tab-pane" id="servicedetails" style="">
                            <div class="row">
                                <div class="col-md-12">
                                    <table id="routeList" class="table table-bordered table-striped">
                                        <thead>
                                        <tr>
                                            <th class="required">Services </th>
                                            <th class="required">description </th>
                                            <th class="required">Amount </th>
                                            <th class="required">Action </th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr>
                                            <td>
                                                <select class="form-control income_account_id selectrequired" class="form-control" name="service_id[]" id="income_account_id[]" >
                                                    <option value="" selected disabled>Select Service</option>
                                                    @foreach($services as $service)
                                                        <option value="{{ $service->id }}">{{ $service->service_name }}</option>
                                                    @endforeach
                                                </select>

                                            </td>
                                            <td class="col-md-5">
                                                <input type="text" class="form-control income_description selectrequired" name="service_description[]" id="service_description" value="" placeholder="Enter Description">
                                            </td>

                                            <td class="col-md-4">
                                                <input type="text" class="form-control income_amount selectrequired" required name="service_amount[]" id="service_amount" value="" placeholder="Enter Amount">
                                            </td>
                                            <td class="col-md-3 text-center">
                                                <button class="btnSubmit addbutton" style="padding: 0px; border: 0px; border-radius: 10px;" type="button"><img class="fa-plus-circle" src="{{ asset('images/Add.png')}}" style="width: 17px;" /> </button>

                                                <button style="padding: 0px; border: 0px; border-radius: 10px;" class="btnSubmit removebutton" type="button"><img class="fa-plus-circle" src="{{ asset('images/remove.jpg')}}" style="width: 20px;" /></button>
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="col-md-12">
                                    <div class="col-md-3"></div>
                                    <div class="col-md-3" style="text-align: center;font-weight: bold;font-size: 20px;">Total Amount</div>
                                    <div style="text-align: center;font-weight: bold;font-size: 20px;" class="col-md-3 total_amount_income" id="gtotal">0</div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane" id="externalparts" style="">
                            <div class="row">
                                <div class="col-md-12">
                                    <table id="routeList" class="table table-bordered table-striped">
                                        <thead>
                                        <tr>
                                            <th class="required">Parts </th>
                                            <th class="required">description </th>
                                            <th class="required">Amount </th>
                                            <th class="required">Action </th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr>
                                            <td>
                                                <select class="form-control external_part_id selectrequired" class="form-control" name="external_part_id[]" id="external_part_id[]" >
                                                    <option value="" selected disabled>Select Part</option>
                                                    @foreach($parts as $part)
                                                        <option value="{{ $part->part_id }}">{{ $part->part_name }}</option>
                                                    @endforeach
                                                </select>

                                            </td>
                                            <td class="col-md-5">
                                                <input type="text" class="form-control external_part_description selectrequired" name="external_part_description[]" id="external_part_description" value="" placeholder="Enter Description">
                                            </td>

                                            <td class="col-md-4">
                                                <input type="text" class="form-control income_amount selectrequired" name="external_part_amount[]" id="external_part_amount" value="" placeholder="Enter Amount">
                                            </td>
                                            <td class="col-md-2 text-center">
                                                <button class="btnSubmit addbutton" style="padding: 0px; border: 0px; border-radius: 10px;" type="button"><img class="fa-plus-circle" src="{{ asset('images/Add.png')}}" style="width: 17px;" /> </button>

                                                <button style="padding: 0px; border: 0px; border-radius: 10px;" class="btnSubmit removebutton" type="button"><img class="fa-plus-circle" src="{{ asset('images/remove.jpg')}}" style="width: 20px;" /></button>
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
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
        
        {!! Form::hidden("grandtotal", null, ["class"=>"total_income_front"]) !!}
        
        {!! Form::hidden("job_date", $maintenance_request_schedule->sjp_date) !!}
        {!! Form::hidden("vehicle", $maintenance_request_schedule->vehicle_id) !!}
        
        {!! Form::hidden("sjpid", $id) !!}
        
        
        {!! Form::close() !!}
   

<script>
    var current_amount=0;
    product.productvalidate();
  
    jQuery("table").on("click",".addbutton", function(){
        //if(CheckValidation())
        //{
        //debugger;
            addnewrow(this)
        //}

    })
    function addnewrow(obj){
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
    jQuery("table").on("click",".removebutton", function(){
            if (jQuery(this).parent().parent().parent().find("tr").length > 1 )
            {
            jQuery(this).parent().parent().closest("tr").remove();
            // getGrandTotal();
              
                income_total();
            }
        
    }); 

  
  
   
    $("body").on("change",".income_amount",function(){
        income_total(this);
    })



    function income_total(obj){
        $(".total_amount_income").text("0");

        var total = parseInt($("#gtotal").text());
        current_amount = parseInt(obj.value);

        $.each($(".income_amount"),function(i, val){
           // $(".total_amount_income").text(parseInt($(".total_amount_income").text() == "" ? "0": $(".total_amount_income").text()) + parseInt($($(".income_amount")[i]).val()))
                
           var income_amount = ($(".income_amount")[i].value);
           income_amount = parseInt(income_amount);

 
 
            if(! isNaN(income_amount)){
                total += parseInt(income_amount);
            }
           else{
               if(! isNaN(income_amount)){
                   total += parseInt(income_amount);
               }
               
           }
           
        });
        $(".total_income_front").val(total);
        $(".total_amount_income").text(total);
    }


    $("body").on("click", "#submit-dept", function () {

        if ($("#purchase-order-form").valid() == true) {
            return true;
        }
        else {
            return false;
        }
    });

    $("#purchase-order-form").submit(function(e){
        
        $("#purchase-order-form input").each(function(index, value){
            var values = $(this).val();

            if(values == null || values==''){
                e.preventDefault();
                modelpopup("Please Fill all required fields");
                
            }
            if($(this).attr('name') == 'service_amount[]' || $(this).attr('name')=="external_part_amount[]"){
                if(isNaN($(this).val())){
                    e.preventDefault();
                    modelpopup('Please Enter a valid amount');
                }
            }
        });
    });
    function modelpopup(text){
        jQuery('.custom-modal-ics-inner').modal('show');

        jQuery('.custom-modal-title-inner').html("Alert");//SET TITLE
        jQuery('.custom-modal-body-ics-inner').html("<div>"+ text +"</div>");//SET BODY

        //SHOW LOADER B/C AJAX EVENT NOT CALL AFTER ONCOLSE IN JQGRI
    }


        jQuery(".selectrequired").attr('required', true);

</script>
</div>