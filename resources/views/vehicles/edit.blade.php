<div class="page-heading-primary">
	    <h2>
	        <b> Update Vehicles </b>
	    </h2>
	</div>
	<div class="bgcolr-grey">
		<div class="box-body">
			<form action="{{url('vehicles/update/'.$Vehicles->id)}}" method = "post"  autocomplete="off">
				{!! csrf_field() !!}
			
				<input type="hidden" name = "$Vehicles->id">
			
				<div class="form-group col-md-4">
					<label for="">Vehicles Number:</label>
					<input type="text" name = "vcnum" value="{{ $Vehicles->vehicle_no }}" class = "form-control" placeholder = "Name" required="true">
				</div>
				<?php $datest = $Vehicles->start_date; $enddate = $Vehicles->end_date;

				$datest = explode(" ", $datest);
				$enddate = explode(" ", $enddate);
				?>

				<div class="form-group col-md-4">
					<label for="">Start Date:</label><br>
			     	<input type="text" name="start_date"  value="{{ $datest[0] }}" class="form-control datepickerstrt"  placeholder="Enter Date">
				</div>

				<div class="form-group col-md-4">
					<label for="">End Date:</label><br>
					<input type="text" name="end_date" class="form-control datepickerend" value="{{ $enddate[0] }}"  placeholder="Enter Date of Birth">
				</div>

				<div class="form-group col-md-4">
					<label for="">Description:</label>
					<input type="text" name = "dscrp"  value="{{ $Vehicles->description }}" class = "form-control " placeholder = "dscp" required="true">
				</div>

				<div class="form-group col-md-4">
					<label for="">Driver:</label>
					{!! Form::select('drivers', $drivers, $Vehicles->driver, ['class' => 'form-control' , 'id' => $Vehicles->id ,'requried' => 'true']) !!}
				</div>

				<div class="form-group col-md-4">
					<label for="">Warranty:</label>
					<input type="text" name = "warranty" value="{{ $Vehicles->warranty }}" class = "form-control" placeholder = "Enter License Number" required="true">
				</div>


					<div class="form-group col-md-4">
					<label for="">Owner:</label>
					<input type="text" name="owner" value="{{ $Vehicles->owner }}"  class="form-control datepickereo" placeholder = "Expiry Date" required="true">
				</div>


			   <div class="form-group col-md-4">
				<label for="">Brand:</label>

 					{!! Form::select('brand', $brands, $Vehicles->brand, ['class' => 'form-control select2' , 'id' => $Vehicles->id ,'requried' => 'true']) !!}
         
				</div>


				<div class="form-group col-md-4">
				   <label for="">Cetagory:</label>

 					{!! Form::select('cetagory', $categories, $Vehicles->category_id, ['class' => 'form-control select2' , 'id' => $Vehicles->id ,'requried' => 'true']) !!}
				</div>
				<div class="form-group col-md-4">
					<label for="">Purchase Amount</label>
					<input type="number" name="purchase_amount" class = "form-control" placeholder = "Purchase Amount" required="true" value="{{$Vehicles->purchase_amount}}">
				</div>
				<div class="form-group col-md-4">
					<label for="">Life (Months)</label>
					<input type="number" name="life" class = "form-control" placeholder = "Life" required="true" value="{{$Vehicles->life}}">
				</div>
				<div class="form-group col-md-4">
					<label for="">Deperciation (%)</label>
					<input type="number" name="deperciation" class = "form-control" placeholder = "deperciation"  value="{{$Vehicles->deperciation}}">
				</div>


				<div class="form-group col-md-4">
					<label for="">Lease Amount</label>		
					<input type="number" name="lease_amount" class = "form-control" placeholder = "Lease Amount" required="true" value="{{ $Vehicles->lease_amount }}">			
				</div>
				<div class="form-group col-md-4">
					<label for="">Duration (Months)</label>
					<input type="number" name="lease_duration" class = "form-control" placeholder = "Lease Duration" required="true" value="{{ $Vehicles->lease_duration }}">
				</div>
				<div class="form-group col-md-4">
					<label for="">Total</label>
					<input type="number" name="lease_total" class = "form-control" placeholder = "" required="true" readonly value="{{ intval($Vehicles->lease_amount) * intval($Vehicles->lease_duration)}}">
				</div>
				<div class="form-group col-md-4">
					<label for="">Total Lease Paid</label>
					<input type="number" name="lease_paid_total" class = "form-control" placeholder = ""  readonly>
				</div>
				<div class="form-group col-md-4">
					<label for="">Remaining Lease Amount</label>
					<input type="number" name="remaining_lease_amount" id="remaining_lease_amount" class = "form-control" placeholder = "" readonly>
				</div>
				<div class="form-group col-md-4">
					<label for="">Total Deperciation Paid</label>
					<input type="number" class = "form-control" placeholder = "" value="{{ $Vehicles->deperciation_total }}" readonly>
				</div>


				<button style="float: right;" class = "custom-btn-action custom-btn-view bgcolr-orange no-margin" type="submit">Update</button>
			</form>
		</div>
	</div>


<script>

$(".datepickerstrt").datepicker({
 	format: 'yyyy-mm-dd',
});

$(".datepickerend").datepicker({
 	
 	format: 'yyyy-mm-dd',
});

jQuery(document).ready(function(){
	jQuery("#lease_amount").on("change", function(){
		calc_lease_total();
	});

	jQuery("#lease_duration").on("change", function(){
		calc_lease_total();
	});


	function calc_lease_total(){
		jQuery("#lease_total").val(parseInt(jQuery("#lease_amount").val()) * parseInt(jQuery("#lease_duration").val()));
	}


});
</script>
