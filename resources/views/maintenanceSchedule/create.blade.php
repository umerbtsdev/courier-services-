<style>
        .required:after {
            content:"*";
            color:red;
        }
        #error{
            color: white;
            font-size: x-large;
        }
        .hideme{
            display:none;
        }
    </style>
    
    {!! Form::open(array('url'=>'/workshops/maintenance-schedule/add','method'=>'POST','id'=>'create-schedule-form', 'class'=>"form-inline", 'autocomplete' => "off")) !!}
    <div class = 'container-fluid'>
        <div class="col-md-12" style="padding:0; margin-bottom:4%;">
            <div class="col-md-12">
                <div class="form-group col-sm-3" style="display:grid">
                    <label for="vehicle" class="control-label required">Vehicle </label>
                    <select id="vehicle" class="form-control" required name="vehicle">
                        
                        @foreach($vehicles as $vehicle)
                            <option value="{{ $vehicle->id }}">{{ $vehicle->vehicle_no }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group col-sm-3">
                    <label for="from_date" class="control-label required">Start From </label>
                    {!! Form::date("from_date", date("Y-m-d"), ["id"=>"from_date", "class"=>"form-control ", "required"=>true]) !!}
                </div>
                <div class="form-group col-sm-3">
                    <label for="to_date" class="control-label required">End On </label>
                    {!! Form::date("to_date", null,  ["id"=>"to_date", "class"=>"form-control ", "required"=>true]) !!}
                </div>
                <div class="form-group col-sm-3">
                    <label for="delay_days" class="control-label required">Delay (in days) </label>

                    
                    {!! Form::number("delay_days", null, ["class"=>"form-control","id"=>"delay_days", "required"=>true, "min"=>"1"]) !!}
                    
                    
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="btn-app btn-github btn-group-justified col-md-8 hideme"><p id="error"></p></div>
            <button style="float: right;" class = "col-md-2 custom-btn-action custom-btn-view bgcolr-orange no-margin" id="generateTable" type="button">Generate</button>
        </div>
    </div>
    <div class = 'container-fluid' id="generatedTable">
    </div>
    {!! Form::close() !!}
    <script>
        var isTableCreated = true;

        $("#generateTable").on("click",function(){
            //debugger;
            $from_date = $("#from_date");
            $to_date = $("#to_date");
            $delay_days = $("#delay_days");
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
            else if($delay_days.val()== ''){
                isError=1;
                $("#error").parent().removeClass('hideme');
                error.innerHTML ="Please enter <em>Delay in Days</em>";
            }
            else if(isError==0){
                $("#error").parent().addClass('hideme');                
                var tableBase = document.getElementById("generatedTable");
                var tableStart = "<table class='table dataTable table-bordered' width='100%'>";
                var tableEnd = "</table>";
                var thead = "<thead><tr><th>Date</th><th>Vehicle</th><th>Status</th></tr></thead>";
                var tbodyStart = "<tbody>";
                var tbodyEnd = "</tbody>";
                var createScheduleBtn = "<div class='col-md-12'><button style='float: right;' class = 'col-md-2 custom-btn-action custom-btn-view bgcolr-orange no-margin' id='createSchedule' type='button'>Create Schedule</button></div>";
                
                var body, table;

                function addDays(date,delay){
                    var n = new Date(date);
                    n.setDate(n.getDate() + parseInt(delay));
                    return n;
                }
                
                var from = document.getElementById("from_date");
                var delay = document.getElementById("delay_days");
                var end = document.getElementById("to_date");

                var vehicle=$("#vehicle").find(":selected").text(), status="no";
                var newDate, xx;
                var enddate = new Date(end.value);
              //  body = "<tr><td><input name='dates[]' value='"+from.value+"' type='hidden'>"+from.value+"</td><td>"+vehicle+"</td><td>"+status+"</td></tr>";
                for(var i=0; i<=300; i++){
                    if(i==0){
                        newDate = addDays(from.value,delay.value);
                        xx = addDays(from.value,delay.value);
                    }
                    else{
                        newDate = addDays(newDate,delay.value);
                        xx = addDays(newDate,delay.value);
                    }
                    var  diff= enddate-xx;
                    if(diff > 0){
                        var day = xx.getDate();
                        var month = xx.getMonth() + 1;
                        var year = xx.getFullYear();
                        if(day < 10 ){
                            day = "0"+day;
                        }
                        if(month < 10){
                            month = "0"+month;
                        }
                        body += "<tr><td><input name='dates[]' value='"+year+"-"+month+"-"+day+"' type='hidden'>"+year+"-"+month+"-"+day+"</td><td>"+vehicle+"</td><td>"+status+"</td></tr>";
                    }
                }
               
               // body += "<tr><td><input name='dates[]' value='"+end.value+"' type='hidden'>"+end.value+"</td><td>"+vehicle+"</td><td>"+status+"</td></tr>";
                table = tableStart+thead+tbodyStart+body+tbodyEnd+tableEnd;
                tableBase.innerHTML = table;


                if($("#create-schedule-form").children().length ==3){
                    $(createScheduleBtn).insertAfter("#generatedTable");
                    var formHeight = $("#create-schedule-form").height();
                    $("#create-schedule-form").height(parseInt(formHeight) + 25);
                    $('#createSchedule').click(function(){
                        isTableCreated = false;
                        $('#create-schedule-form').submit();
                    });
                }
                
                
            }
            $(this).remove();
        });
        
        $('#create-schedule-form').submit(function(e){
            if(isTableCreated){
                e.preventDefault();
            }
        });

       
    </script>