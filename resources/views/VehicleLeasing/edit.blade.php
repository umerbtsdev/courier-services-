<style>
    .leaseAmnt{
        color: red;
    }
    
    @keyframes animate {
        0% {
          background-position: -500%;
        }
        100% {
          background-position: 500%;
        }
      }
</style>
<div id="s2c"></div>
<div class="bgcolr-grey">
        @if(Request::session()->has('user_create_status'))
            @if(Request::session()->pull('user_create_status') == 'error')
                <div class="alert alert-danger">{{Request::session()->pull('user_create_message')}}</div>
            @endif   
        @endif
    <div class="box-body">
        {!! Form::open(array('url'=>'/Finance/Vehicle-Leasing/edit','method'=>'POST','id'=>'workshop-form', 'files' => false)) !!}
            
            {!! Form::hidden("lease_id", $VehicleLeasing->id) !!}
            
            <div class="form-group col-md-4">
                <label for="vehicles" class="form-control-label">Vehicle</label>
                <select id="vehicles" name="vehicle" class="form-control" readonly>
                    <option disabled selected></option>
                    @foreach ($vehicles as $vehicle)
                        <option value="{{ $vehicle->id }}" {{ $VehicleLeasing->vehicle_id == $vehicle->id ? "selected":""  }} data-Lease="{{  $vehicle->lease_amount != 0 ? $vehicle->lease_amount:'0' }}">{{ $vehicle->vehicle_no }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group col-md-4">
                <label for="vehicle_lease_amount" class="form-control-label">Lease Amount</label>
                <input id="vehicle_lease_amount" name="vehicle_lease_amount" type="number" class="form-control" value="{{ $VehicleLeasing->amount }}" readonly required> 
                <p id="e2c"></p>
            </div>
            <div class="form-group col-md-4">
                <label for="coa_list" class="form-control-label">Account</label>
                <select id="coa_list" name="coa_list" class="form-control" readonly>
                    <option disabled selected></option>
                    @foreach ($coa as $coa)
                        <option value="{{ $coa->id }}" {{ $VehicleLeasing->coa_id == $coa->id ? "selected":"" }}>{{ $coa->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group col-md-4">
                <label for="lease_amount_paid" class="form-control-label">Lease Paid At</label>
                
                {!! Form::date("date_paid", $VehicleLeasing->paid_date, ["class"=>"form-control","id"=>"lease_amount_paid"]) !!}
                
            </div>
            <br/>
            <div class="col-md-12">
                <button style="float: right;" class = "custom-btn-action custom-btn-view bgcolr-orange no-margin" type="submit">Save</button>
            </div>
        {!! Form::close() !!}
    </div>
</div>

<script>
    jQuery("#vehicles").on("change", function(){
        jQuery("#vehicle_lease_amount").val(jQuery("#vehicles").find(':selected').data("lease"));
    });

    jQuery("#workshop-form").on("submit", function(e){
        $vehicle_lease_amount = jQuery("#vehicle_lease_amount");
        if($vehicle_lease_amount.val() <=1 ){
            e.preventDefault();
            transition("s2c");
            jQuery("#e2c").html("<span class='leaseAmnt'>Lease Amount cannot be null</span>");
        }else{
            jQuery("#vehicle_lease_amount").parent().find(".leaseAmnt").remove();
        }
    });

    function transition(id){
        jQuery("#"+id).html("<style>#e2c{background: linear-gradient(90deg, #f00, #f00, #f00);background-repeat: no-repeat;background-size: 80%;animation: animate 6s linear 1;-webkit-background-clip: text;-webkit-text-fill-color: rgba(255, 255, 255, 0);}</style>")
    }
</script>