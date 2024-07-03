
	<div class="page-heading-primary">
	    <h2>
	        <b> Approve Customer </b>
	    </h2>
	</div>

	<div class="bgcolr-grey">
		 <?php if(Request::session()->has('user_create_status')): ?>
	      <?php if(Request::session()->pull('user_create_status') == 'error'): ?>
	      <div class="alert alert-danger"><?php echo e(Request::session()->pull('user_create_message')); ?></div>
	      <?php endif; ?>   
	     <?php endif; ?>
		<div class="box-body">
			<form action="<?php echo e(url('customer/approve-data/'.$customer->id)); ?>" method = "post"  autocomplete="off">
				<?php echo csrf_field(); ?>

				<div class="row">
					<div class="form-group col-md-4">
						<label for="">First Name</label>
						<input type="text" name = "first_name" id="first_name" readonly="readonly" value="<?php echo e($customer->first_name); ?>" class = "form-control" placeholder = "first name" required="true">
					</div>
					<div class="form-group col-md-4">
						<label for="">Last Name</label>
						<input type="text" name = "last_name" id="last_name" readonly="readonly" value="<?php echo e($customer->last_name); ?>"  class = "form-control" placeholder = "last name" required="true">
					</div>
					<div class="form-group col-md-4">
						<label for="">Email</label>
						<input type="email" name="email" id="email" readonly="readonly" value="<?php echo e($customer->email); ?>"  class = "form-control" placeholder = "Email" required="true">
					</div>
				</div>
				<div class="row">
					<div class="form-group col-md-4">
						<label for="">Contact No</label>
						<input type="text" name="contact_no" id="contact_no" readonly="readonly" value="<?php echo e($customer->contact_no); ?>" class = "form-control" placeholder = "Contact No" required="true">
					</div>

					<div class="form-group col-md-4">
						<label for="">Alternate No</label>
						<input type="text" name="alernate_no" id="alernate_no" readonly="readonly" value="<?php echo e($customer->alernate_no); ?>"  class = "form-control" placeholder = "Phone No" required="true">
					</div>
					<div class="form-group col-md-4">
						<label for="">Country</label>
						<select name="country_id" id="country_id" readonly="readonly" class = "form-control" required="true">
							<option value=""> Select Country </option>
							<?php $__currentLoopData = $countries; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $country): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
								<?php if($country->id == $customer->country_id): ?>
									<option value="<?php echo e($country->id); ?>" selected="selected"><?php echo e($country->name); ?></option>
									<?php else: ?>
									<option value="<?php echo e($country->id); ?>" ><?php echo e($country->name); ?></option>
									<?php endif; ?>

							<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
						</select>
					</div>
				</div>
				<div class="row" >
					<div class="form-group col-md-4">
						<label for="">city</label>
						<select name="city_id" id="city_id" class = "form-control" readonly="readonly" required="true">
							<option value=""> Select City </option>
							<?php $__currentLoopData = $cities; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $city): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
								<?php if($city->id == $customer->city_id): ?>
									<option value="<?php echo e($city->id); ?>" selected="selected"><?php echo e($city->name); ?></option>
								<?php else: ?>
									<option value="<?php echo e($city->id); ?>"><?php echo e($city->name); ?></option>
									<?php endif; ?>

							<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
						</select>
					</div>
					<div class="form-group col-md-4">
						<label for="">CNIC</label>
						<input type="text" name="cnic" id="cnic" value="<?php echo e($customer->cnic); ?>" readonly="readonly" class = "form-control" placeholder = "Cnic" required="true">
					</div>
					<div class="form-group col-md-4">
						<label for="">Bank</label>
						<input type="text" name="bank_name" id="bank_name" value="<?php echo e($customer->bank_name); ?>" readonly="readonly" class = "form-control" placeholder = "Bank" required="true">
					</div>
				</div>
				<div class="row" >

					<div class="form-group col-md-4">
						<label for="">Branch</label>
						<input type="text" name="branch_name" id="branch_name" value="<?php echo e($customer->branch_name); ?>" readonly="readonly" class = "form-control" placeholder = "Branch" required="true">
					</div><div class="form-group col-md-4">
						<label for="">Account #</label>
						<input type="text" name="account_no" id="account_no" value="<?php echo e($customer->account_no); ?>" readonly="readonly" class = "form-control" placeholder = "account no" required="true">
					</div>
				<div class="form-group col-md-4">
					<label for="">Account Title</label>
					<input type="text" name="account_title" id="account_title" value="<?php echo e($customer->account_title); ?>" readonly="readonly" class = "form-control" placeholder = "Account Title" required="true">
				</div>
					<div class="form-group col-md-4">
						<label for="">Birth Date</label>
						<input type="date" name="brith_date" id="brith_date"  value="<?php echo e($customer->brith_date); ?>" readonly="readonly" class = "form-control" placeholder = "date of birth" required="true">
					</div>
					<div class="form-group col-md-4">
						<label for="">Anniversary Date</label>
						<input type="date" name="anniversary_date"  value="<?php echo e($customer->anniversary_date); ?>" readonly="readonly" id="anniversary_date" class = "form-control" placeholder = "Phone No" required="true">
					</div>
				</div>
				<div class="row">
					<div class="form-group col-md-12">
						<label for="">Address</label>
						<input type="text" name="address" id="address"  value="<?php echo e($customer->address); ?>" readonly="readonly" class = "form-control" placeholder = "Address" required="true">
					</div>
				</div>

				<button style="float: right;" class = "btn-cus-dessign btn btn-primary waves-effect waves-light"  type="submit">Approve</button>
			</form>
		</div>
	</div>