
	<div class="page-heading-primary">
	    <h2>
	        <b> Create New Vehicles </b>
	    </h2>
	</div>

	<div class="bgcolr-grey">
		 @if(Request::session()->has('user_create_status'))
	      @if(Request::session()->pull('user_create_status') == 'error')
	      <div class="alert alert-danger">{{Request::session()->pull('user_create_message')}}</div>
	      @endif   
	     @endif
		<div class="box-body">
			<form action="{{url('vehicles/store')}}" method = "post"  autocomplete="off">
				{!! csrf_field() !!}
				<input type="hidden" name = "vec_id">
			
				<div class="form-group col-md-4">
					<label for="">Vehicles Number</label>
					<input type="text" name = "vcname" class = "form-control" placeholder = "Name" required="true">
				</div>
				<div class="form-group col-md-4">
					<label for="">Start Date</label>
					<input type="date" name = "start_date" class = "form-control" placeholder = "Name" required="true">
				</div>
				<div class="form-group col-md-4">
					<label for="">End Date</label>
					<input type="date" name = "end_date" class = "form-control" placeholder = "Name" required="true">
				</div>
			    <div class="form-group col-md-4">
					<label for="">Enter Description</label>
					<input type="text" name="discrp" class = "form-control" placeholder = "Description" required="true">
				</div>
				<div class="form-group col-md-4">
					<label for="">Drivers:</label>
					<select name="drivers" class="form-control">
					@if (!empty($drivers))
						@foreach ($drivers as $driver)
							<option value="{{ $driver->id}}">{{ $driver->name }}</option>
						@endforeach
					@endif
					</select>
				</div>
				<div class="form-group col-md-4">
					<label for="">Warranty</label>
					<input type="text" name="warranty" class = "form-control" placeholder = "Enter Warranty" required="true">
				 </div>
				  <div class="form-group col-md-4">
					<label for="">Owner</label>
					<input type="text" name="owner" class = "form-control" placeholder = "Owner Name" required="true">
				</div>
				<div class="form-group col-md-4">
					<label for="">Brand:</label>
					<select name="brand" class="form-control">
					@if (!empty($brands))
						@foreach ($brands as $brand)
							<option value="{{ $brand->id }}">{{ $brand->name }}</option>
						@endforeach
					@endif
					</select>
				</div>
				<div class="form-group col-md-4">
					<label for="">Cetagory:</label>
					<select name="category" class="form-control">
					@if (!empty($categories))
						@foreach ($categories as $category)
							<option value="{{ $category->id }}">{{ $category->name }}</option>
						@endforeach
					@endif
					</select>
				</div>
				<div class="form-group col-md-4">
					<label for="">Purchase Amount</label>
					<input type="number" name="purchase_amount" class = "form-control" placeholder = "Purchase Amount" required="true">
				</div>
				<div class="form-group col-md-4">
					<label for="">Life (Months)</label>
					<input type="number" name="life" class = "form-control" placeholder = "Life" required="true">
				</div>
				<div class="form-group col-md-4">
					<label for="">Deperciation (%)</label>
					<input type="number" name="deperciation" class = "form-control" placeholder = "deperciation" >
				</div>

				<div class="form-group col-md-4">
					<label for="">Lease Amount</label>		
					<input type="number" name="lease_amount" id="lease_amount"  class = "form-control" placeholder = "Lease Amount" required="true">			
				</div>
				<div class="form-group col-md-4">
					<label for="">Duration (Months)</label>
					<input type="number" name="lease_duration" id="lease_duration" class = "form-control" placeholder = "Lease Duration" required="true">
				</div>
				<div class="form-group col-md-4">
					<label for="">Total</label>
					<input type="number" name="lease_total" id="lease_total" class = "form-control" placeholder = "" required="true" readonly>
				</div>
				
				<button style="float: right;" class = "custom-btn-action custom-btn-view bgcolr-orange no-margin" type="submit">Add Vehicles</button>
			</form>
		</div>
	</div>

	<script>

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