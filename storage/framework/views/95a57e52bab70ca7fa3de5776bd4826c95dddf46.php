
	<div class="page-heading-primary">
	    <h2>
	        <b> Create Cost Center </b>
	    </h2>
	</div>

	<div class="bgcolr-grey">
		 <?php if(Request::session()->has('user_create_status')): ?>
	      <?php if(Request::session()->pull('user_create_status') == 'error'): ?>
	      <div class="alert alert-danger"><?php echo e(Request::session()->pull('user_create_message')); ?></div>
	      <?php endif; ?>   
	     <?php endif; ?>
		<div class="box-body">
			<form action="<?php echo e(url('setup/costcenter/store')); ?>" method = "post"  autocomplete="off">
				<?php echo csrf_field(); ?>

				<div class="row">
					<div class="form-group col-md-6">
						<label for="">Name</label>
						<input type="text" name = "name" id="name" class = "form-control" placeholder = "Name" required="true">
					</div>

					<div class="form-group col-md-6">
						<label for="">Phone No</label>
						<input type="text" name="phone_no" id="phone_no" class = "form-control" placeholder = "Phone No" required="true">
					</div>

				</div>
				<div class="row">
				<div class="form-group col-md-12">
					<label for="">Address</label>
					<input type="text" name="address" id="address" class = "form-control" placeholder = "Address" required="true">
				</div>
				</div>

				<button style="float: right;" class = "btn-cus-dessign btn btn-primary waves-effect waves-light" type="submit">Add Cost Center</button>
			</form>
		</div>
	</div>