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
        #PRremarks{
            height: 80px !important;
            resize: none;
            margin-bottom:1%;
        }
        #radios {
            margin-top: 2%;

        }
        .ApprovalBox{
            border: 1px solid gainsboro;
            padding: 12px 0;
        }
</style>

    <div class = 'container-fluid'>
        <div class="col-md-12" style="margin-bottom:2%;">
            <div class="form-group col-sm-2" style="display:grid">
                <label for="costCenter_id" class="control-label required">Cost Center </label>
                <select id="costCenter_id" class="form-control" required name="costCenter_id" disabled>
                    
                    @foreach($costcenters as $costcenter)
                        <option value="{{ $costcenter->id }}" {{ ($invoice->cost_center_id == $costcenter->id ? "Selected":"") }}>{{ $costcenter->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group col-sm-2" style="display:grid">
                <label for="client_id" class="control-label required">Client </label>
                <select id="client_id" class="form-control" required name="client_id" disabled> 
                    
                    @foreach($customers as $customer)
                        <option value="{{ $customer->id }}"  {{ ($invoice->client_id == $customer->id ? "Selected":"") }}>{{ $customer->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group col-sm-2" style="display:grid">
                <label for="vehicle_id" class="control-label required">Vehicle </label>
                <select id="vehicle_id" class="form-control" required name="vehicle_id" disabled>
                    
                    @foreach($vehicles as $vehicle)
                        @if($invoice->vehicle_id == $vehicle->id)
                            <option value="{{ $vehicle->id }}" {{ ($invoice->vehicle_id == $vehicle->id ? "Selected":"") }}>{{ $vehicle->vehicle_no }}</option>
                        @endif
                    @endforeach
                </select>
            </div>
            <div class="form-group col-sm-3" >
                <label for="date_from" class="control-label required">Start From </label>
                {!! Form::date("date_from", $invoice->date_from, ["id"=>"date_from", "class"=>"form-control ", "readonly"=>true]) !!}
            </div>
            <div class="form-group col-sm-3">
                <label for="date_to" class="control-label required">End On </label>
                {!! Form::date("date_to", $invoice->date_to,  ["id"=>"date_to", "class"=>"form-control ", "readonly"=>true]) !!}
            </div>
        </div>
     
        <div class="col-md-12" id="newFields">
            <div class="form-group col-sm-2" style="display:grid">
                <label for="totalBilled" class="control-label">Total Billed</label>
                <input type="text" readonly name="totalBilled" id="totalBilled" class="form-control" value="{{ $invoice->total_billed }}">
            </div>
            <div class="form-group col-sm-2" style="display:grid">
                <label for="totalExpense" class="control-label">Total Expenses</label>
                <input type="text" readonly name="totalExpense" id="totalExpense" class="form-control" value="{{ $invoice->total_expenses }}">
                </div>
            <div class="form-group col-sm-2" style="display:grid">
                <label for="grandTotal" class="control-label">Grand Total</label>
                <input type="text" readonly name="grandTotal" id="grandTotal" class="form-control" value="{{ $invoice->grand_total }}">
            </div>
            <div class="form-group col-sm-2" style="display:grid">
                <label for="totalReading" class="control-label">Total Reading</label>
                <input type="text" readonly name="totalReading" id="totalReading" class="form-control" value="{{ $invoice->total_reading }}">
            </div>
            <div class="form-group col-sm-2" style="display:grid">
                <label for="totalworkingdays" class="control-label">Total Working Days</label>
                <input type="text" readonly name="totalworkingdays" id="totalworkingdays" class="form-control" value="{{ $invoice->total_working_days }}">
            </div>
            <div class="form-group col-sm-2" style="display:grid">
                <label for="daysworked" class="control-label">Days Worked</label>
                <input type="text" readonly name="daysworked" id="daysworked" class="form-control" value="{{ $invoice->days_worked }}">
            </div>
            <div class="form-group col-sm-2" style="display:grid">
                <label for="MaintenanceTotal" class="control-label">Maintenance Total</label>
                    <input type="text" readonly name="MaintenanceTotal" id="MaintenanceTotal" class="form-control" value="{{ $invoice->maintenance_total }}">
                </div>
            <div class="form-group col-sm-2" style="display:grid">
                <label for="Depreciation" class="control-label">Depreciation</label>
                <input type="text" readonly name="Depreciation" id="Depreciation" class="form-control"  value="{{ $invoice->depreciation }}">
            </div>
            <div class="form-group col-sm-2" style="display:grid">
                <label for="DriverName" class="control-label">Driver Name</label>
                <input type="text" readonly name="DriverName" id="DriverName" class="form-control" value="{{ $invoice->driver_name }}">
            </div>
            <div class="form-group col-sm-2" style="display:grid">
                <label for="DriverSalary" class="control-label">Driver Salary</label>
                <input type="text" readonly name="DriverSalary" id="DriverSalary" class="form-control" value="{{ $invoice->driver_salary }}">
            </div>
            <div class="form-group col-sm-2" style="display:grid">
                <label for="profitLoss" class="control-label">Net profit/loss</label>
                <input type="text" readonly name="profitLoss" id="profitLoss" class="form-control"  value="{{ $invoice->profitLoss }}">
            </div>
            <input type="hidden" name="driver_id" value="7">
        </div>

        <div class="col-md-12">
            <div class="btn-app btn-github btn-group-justified col-md-8 hideme"><p id="error"></p></div>
                <div id="actionBtn">
                    {{--  <button style="float: right;" class = "col-md-2 custom-btn-action custom-btn-view bgcolr-orange no-margin" id="generateTable" type="button">Generate</button>  --}}
                </div>
            </div>
        </div>
        
        @if($invoice->is_approved == 1)
            <div class = 'container-fluid' style="    margin-bottom: 2%;" >
                <div class="form-group col-sm-2" style="display:grid">
                    <button id="btn1" onclick="openInNewTab('{{ url('/Transactions/Customer-Inovices/print/customerInvoice').'/'.$invoice->id }}')" class="btn btn-flat btn-dropbox">Print Customer Invoice</button>
                </div>
            </div>
            @else
                @if($approvalPermissionCheck ==1)
                    
                    <div class = 'container-fluid' style="    margin-bottom: 2%;" >
                        {!! Form::open(array('url'=>'/Transactions/Customer-Inovices/ApproveReject','method'=>'POST','id'=>'customerInvoiceApproval', 'class'=>"", 'autocomplete' => "off")) !!}
                            {!! Form::hidden('invoice_id', $invoice->id) !!}
                            
                            {!! Form::hidden("totalBilled", $invoice->total_billed) !!}
                            
                            <div class="col-sm-6 ApprovalBox">
                                <div class="form-group adjust">
                                    <div class="col-sm-4">
                                        <label for="PRremarks"> Remarks</label>
                                        {!! Form::textarea("remarks", "", ["class"=>"form-control","id"=>"PRremarks",'rows'=>4,"maxlength"=>250]) !!}
                                    </div>
                                    <div class="col-sm-3" >
                                        <label for="radios">Status</label>
                                        <div id="radios" style="    margin-top: 5%;">
                                            <label for="approve">
                                                {!! Form::radio("status", 'approve', "", ["class"=>"icheckbox_polaris paymentrequestCheckViewSave", "id"=>"approve", 'required'=>true]) !!}
                                                Approve
                                            </label>
                                            <br>
                                            <label for="reject"> 
                                                {!! Form::radio("status", 'reject', "", ["class"=>"icheckbox_polaris paymentrequestCheckViewSave","id"=>"reject"]) !!}
                                                Reject
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-sm-4" style="float: right;padding-right: 0;">
                                        <button type="submit" class="custom-btn-action custom-btn-view  bgcolr-aqua" style="float:right;    margin-top: 38%;">Submit</button>
                                    </div>
                                </div>
                                
                            </div>
                        {!! Form::close() !!}
                    </div>
                    <br>
                @endif
        @endif
        <div class = 'container-fluid' id="generatedTable1">
                <div class='nav-tabs-custom'>
                    <ul class='nav nav-tabs'>
                        <li class='active'><a href='#tab_1' data-toggle='tab'>Trip Details</a></li>
                        <li><a href='#tab_2' data-toggle='tab'>Maintenance Details</a></li>
                    </ul>
                    <div class='tab-content'>
                        <div class='tab-pane active' id='tab_1'>
                            
                        </div>
                        <div class='tab-pane' id='tab_2'> 

                        </div>
                    </div>
                </div>
        </div>
    </div>



<script>
    jQuery(document).ready(function(){
        jQuery.ajax({
            url: '/Transactions/Report/monthly-transport-report-view',
            type: "post",
            data: {
                "_token": "{{ csrf_token() }}",
                "vehicle_id" :$('#vehicle_id').val(),
                "date_from":$('#date_from').val(),
                "date_to":$('#date_to').val()
            },
            success: function(data){
               
                $("#tab_1").html(data);
                
            }
        });
        jQuery.ajax({
            url: '/Transactions/Report/monthly-job-report',
            type: "post",
            data: {
                "_token": "{{ csrf_token() }}",
                "vehicle_id" :$('#vehicle_id').val(),
                "date_from":$('#date_from').val(),
                "date_to":$('#date_to').val()
            },
            success: function(data){
                $("#tab_2").html(data);
                
            }
        });

        
    });
    function openInNewTab(url) {
        var win = window.open(url, '_blank');
        win.focus();
    }
</script>
            