<style>
    .required:after {
        content:"*";
        color:red;
    }
    #error{
        color: white;
        /*font-size: x-large;*/
    }
    .hideme{
        display:none;
    }
    #generatedTable1 {
        overflow-x: scroll;
    }
</style>

{!! Form::open(array('url'=>'/Transactions/Customer-Inovices/create-invoice','method'=>'POST','id'=>'create-schedule-form', 'class'=>"", 'autocomplete' => "off")) !!}
    <div class = 'container-fluid'>
        <div class="col-md-12" style="margin-bottom:4%;">
            
                <div class="form-group col-sm-2" style="display:grid">
                    <label for="costCenter_id" class="control-label required">Cost Center </label>
                    <select id="costCenter_id" class="form-control" required name="costCenter_id">
                        
                        @foreach($costcenters as $costcenter)
                            <option value="{{ $costcenter->id }}">{{ $costcenter->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group col-sm-2" style="display:grid">
                    <label for="client_id" class="control-label required">Client </label>
                    <select id="client_id" class="form-control" required name="client_id">
                        
                        @foreach($customers as $customer)
                            <option value="{{ $customer->id }}">{{ $customer->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group col-sm-2" style="display:grid">
                    <label for="vehicle_id" class="control-label required">Vehicle </label>
                    <select id="vehicle_id" class="form-control" required name="vehicle_id">
                        
                        @foreach($vehicles as $vehicle)
                            <option value="{{ $vehicle->id }}">{{ $vehicle->vehicle_no }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group col-sm-3" >
                    <label for="date_from" class="control-label required">Start From </label>
                    {!! Form::date("date_from", null, ["id"=>"date_from", "class"=>"form-control ", "required"=>true]) !!}
                </div>
                <div class="form-group col-sm-3">
                    <label for="date_to" class="control-label required">End On </label>
                    {!! Form::date("date_to", date("Y-m-d"),  ["id"=>"date_to", "class"=>"form-control ", "required"=>true]) !!}
                </div>
                
            
        </div>
        <div class="col-md-12" id="newFields">
        </div>
        <div class="col-md-12">
            <div class="btn-app btn-github btn-group-justified col-md-8 hideme"><p id="error"></p></div>
            <div id="actionBtn">
                <button style="float: right;" class = "col-md-2 custom-btn-action custom-btn-view bgcolr-orange no-margin" id="generateTable" type="button">Generate</button>
            </div>
        </div>
    </div>
    <div class = 'container-fluid' id="generatedTable1">
    </div>
    {!! Form::close() !!}

    <script>
        var isTableCreated = true;

        $("#generateTable").on("click",function(){
            //debugger;
            makeInputReadonly(['date_from','date_to','vehicle_id']);
            $from_date = $("#date_from");
            $to_date = $("#date_to");
            $vehicle_id = $("#vehicle_id");
            
            $actionBtn = $("#actionBtn");
            var error = document.getElementById("error");
            var isError = 0;
            if($to_date.val()==""){
                isError=1;
                $("#error").parent().removeClass('hideme');                
                error.innerHTML = "Please enter <em>End Date</em>";
            }
            else if($from_date.val() == $to_date.val()){
                isError=1;
                $("#error").parent().removeClass('hideme');
                error.innerHTML = "<u>Start Date</u> cannot be same as <u>End Date</u>";
                $to_date.val('');
            }
            else if($from_date.val()==""){
                
                    isError=1;
                    $("#error").parent().removeClass('hideme');                
                    error.innerHTML = "Please enter <em>Start Date</em>";
                
            }
            
            else if(isError==0){
                $("#error").parent().addClass('hideme');  
               
                createTabbedPannel();
                createBoxes("totalBilled","Total Billed");
                createBoxes("totalExpense","Total Expenses");
                createBoxes("grandTotal","Grand Total");
                createBoxes("totalReading","Total Reading");
                createBoxes("totalworkingdays","Total Working Days");
                createBoxes("daysworked","Days Worked");
                createBoxes("MaintenanceTotal","Maintenance Total");
                createBoxes("Depreciation","Depreciation");
                createBoxes("DriverName","Driver Name");
                createBoxes("DriverSalary","Driver Salary");
                createBoxes("profitLoss","Net profit/loss");
                createBoxes("TotalDetentions","Total Detentions");
                createBoxes("DetentionCount","Number of Detentions");

                createHiddenInputs("JobCount","JobCount");
                createHiddenInputs("TripCount","TripCount");
                jQuery.ajax({
                    url: '/Transactions/Report/monthly-transport-report',
                    type: "post",
                    data: {
                        "_token": "{{ csrf_token() }}",
                        "vehicle_id" :$vehicle_id.val(),
                        "date_from":$from_date.val(),
                        "date_to":$to_date.val()
                    },
                    success: function(data){
                       
                        $("#tab_1").html(data);
                        if(data != null){
                            $("#totalBilled").val($("#getTotalBilled").val());
                            $("#totalExpense").val($("#getTotalExpenses").val());
                            $("#grandTotal").val(parseInt($("#getTotalBilled").val()) - parseInt($("#getTotalExpenses").val()));
                            
                            $("#totalReading").val($("#getTotalReading").val());
                            $("#totalworkingdays").val($("#GetTotalWorkingDays").val());
                            $("#daysworked").val($("#Getdaysworked").val());
                            $("#TotalDetentions").val($("#getTotalDetention").val());
                            $("#DetentionCount").val($("#getDetentionCount").val());
                            $("#TripCount").val($("#getTripCount").val());
                            
                        }
                    }
                });
                jQuery.ajax({
                    url: '/Transactions/Report/monthly-job-report',
                    type: "post",
                    data: {
                        "_token": "{{ csrf_token() }}",
                        "vehicle_id" :$vehicle_id.val(),
                        "date_from":$from_date.val(),
                        "date_to":$to_date.val()
                    },
                    success: function(data){
                        $("#tab_2").html(data);
                        if(data != null){
                            $("#MaintenanceTotal").val($("#getMaintenanceGrandTotal").val());                         
                            $("#JobCount").val($("#getJobCount").val());                         
                        }
                    }
                });
                jQuery.ajax({
                    url: '/Transactions/Report/getDepreciation',
                    type: "post",
                    data: {
                        "_token": "{{ csrf_token() }}",
                        "vehicle_id" :$vehicle_id.val(),
                    },
                    success: function(data){
                        
                        if(data != null){
                            jQuery.each(JSON.parse(data),function(i,obj){
                                
                                if(i == "Depreciation" ){
                                    $("#Depreciation").val(obj);
                                }
                                else if(i == "DriverName"){
                                    $("#DriverName").val(obj); 
                                }
                                else if(i == "DriverSalary"){
                                    $("#DriverSalary").val(obj); 
                                }
                                else if(i == "driver_id"){
                                    $("#newFields").append("<input type='hidden' name='driver_id' value='"+obj+"'>"); 
                                }
                            });
                                           
                        }
                        calculateNetProfitLoss();
                        createSaveBtn();
                        
                    }
                });

            }
        });

        $('#create-schedule-form').submit(function(e){
            if(isTableCreated){
                e.preventDefault();
            }
        });

        function createBoxes(name,labelText){
            var BoxLabel = "<label for='"+name+"' class='control-label'>"+labelText+"</label>";
            var BoxInput = "<input type='text' readonly name='"+name+"' id='"+name+"' class='form-control'>";
            var Box = "<div class='form-group col-sm-2' style='display:grid'>"+BoxLabel+BoxInput+"</div>";
            $("#newFields").append(Box);
        }

        function calculateNetProfitLoss(){
            //total bill - total expense - total Maintenance  -  Depreciation - Salary

            var grandTotal = ($("#grandTotal").val());
            var MaintenanceTotal = ($("#MaintenanceTotal").val());
            var Depreciation = ($("#Depreciation").val());
            var DriverSalary = ($("#DriverSalary").val());

            var netProfitLoss = grandTotal - MaintenanceTotal - Depreciation - DriverSalary;

            $("#profitLoss").val(parseInt(netProfitLoss));
        }
        function createSaveBtn(){
            var saveBtn = " <button style='float: right;' id='saveBTN' class = 'col-md-2 custom-btn-action custom-btn-view bgcolr-orange no-margin' type='button'>Save</button>";
            $('#actionBtn').html(saveBtn);

            $("#saveBTN").click(function() {
                isTableCreated = false;
                $("#create-schedule-form").submit();
            });
        }

        function createHiddenInputs(id, name){
            var input = "<input name='"+name+"' type='hidden' readonly required id='"+id+"' >";
            $("#newFields").append(input);
        }
        function createTabbedPannel(){
            $TableBox1 = $("#generatedTable1");
            var tabbedPanel = "<div class='nav-tabs-custom'><ul class='nav nav-tabs'><li class='active'><a href='#tab_1' data-toggle='tab'>Trip Details</a></li><li><a href='#tab_2' data-toggle='tab'>Maintenance Details</a></li></ul><div class='tab-content'><div class='tab-pane active' id='tab_1'></div><div class='tab-pane' id='tab_2'> </div></div></div>";
            $TableBox1.html(tabbedPanel);
        }

        function makeInputReadonly(elem){

           
            
            for(x = 0; x <= elem.length ; x++){
                
                $('#'+elem[x]).attr('readonly',true);

                if($('#'+elem[x]).attr('readonly')==true){
                    console.log($('#'+elem[x]));
                }
                
            
                
            }
            
        }
    </script>