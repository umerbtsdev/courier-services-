
<div class="page-heading-primary">
	    <h2>
	        <b> Delete Vehicles</b>
	    </h2>
	</div>
	<div class="bgcolr-grey">
		<div class="box-body">
			<form action="{{url('vehicles/delete/'.$Vehicles->id)}}" method = "post"  autocomplete="off">
				{!! csrf_field() !!}

				<input type="hidden" name = "$Vehicles->id">
			
				<div class="form-group col-md-4">
					<label for="">Vehicles Number:</label>
					<input type="text" name = "vcnum" value="{{ $Vehicles->vehicle_no }}" class = "form-control" disabled="disabled" placeholder = "Name" required="true">
				</div>
				<?php $datest = $Vehicles->start_date; $enddate = $Vehicles->end_date;

				$datest = explode(" ", $datest);
				$enddate = explode(" ", $enddate);
				?>

				<div class="form-group col-md-4">
					<label for="">Start Date:</label><br>
			     	<input type="text" name="start_date"  value="{{ $datest[0] }}" class="form-control datepickerstrt" disabled="disabled"  placeholder="Enter Date">
				</div>

				<div class="form-group col-md-4">
					<label for="">End Date:</label><br>
					<input type="text" name="end_date" class="form-control datepickerend" value="{{ $enddate[0] }}" disabled="disabled" placeholder="Enter Date of Birth">
				</div>

				<div class="form-group col-md-4">
					<label for="">Description:</label>
					<input type="text" name = "dscrp"  value="{{ $Vehicles->description }}" class = "form-control" disabled="disabled" placeholder = "dscp" required="true">
				</div>

				<div class="form-group col-md-4">
					<label for="">Driver:</label>
{!! Form::select('drivers', $drivers, $Vehicles->driver, ['class' => 'form-control' , 'id' => $Vehicles->id ,'requried' => 'true', 'disabled' => 'disabled']) !!}
				</div>

				<div class="form-group col-md-4">
					<label for="">Warranty:</label>
					<input type="text" name = "warranty" value="{{ $Vehicles->warranty }}" class = "form-control" disabled="disabled" placeholder = "Enter License Number" required="true">
				</div>


					<div class="form-group col-md-4">
					<label for="">Owner:</label>
					<input type="text" name="owner" value="{{ $Vehicles->owner }}"  class="form-control datepickereo" disabled="disabled" placeholder = "Expiry Date" required="true">
				</div>


			   <div class="form-group col-md-4">
				<label for="">Brand:</label>

 					{!! Form::select('brand', $brands, $Vehicles->brand, ['class' => 'form-control select2' , 'id' => $Vehicles->id ,'requried' => 'true', 'disabled' => 'disabled']) !!}
         
				</div>


				<div class="form-group col-md-4">
				   <label for="">Cetagory:</label>

 					{!! Form::select('cetagory', $categories, $Vehicles->category_id, ['class' => 'form-control select2' , 'id' => $Vehicles->id ,'requried' => 'true', 'disabled' => 'disabled']) !!}
				</div>
				

				<button style="float: right;" class = "custom-btn-action custom-btn-view bgcolr-orange no-margin" type="submit">Delete</button>
			</form>
		</div>
	</div>
