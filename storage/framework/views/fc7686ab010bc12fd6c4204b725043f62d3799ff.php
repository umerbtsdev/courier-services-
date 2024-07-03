<?php $__env->startSection('content'); ?>



<div class="bgcolr-grey">
    <?php if(Request::session()->has('user_create_status')): ?>
        <?php if(Request::session()->pull('user_create_status') == 'error'): ?>
            <div class="alert alert-danger"><?php echo e(Request::session()->pull('user_create_message')); ?></div>
        <?php endif; ?>
    <?php endif; ?>

    <div class="box-body">
        <form action="<?php echo e(url('transaction/singlebookingstore')); ?>" method = "post"  autocomplete="off">
            <?php echo csrf_field(); ?>

            <div class="row">
                <div class="col-md-10">
                    <div class="page-heading-primary">
                        <h2>
                            <b> Booking for Customer </b>
                        </h2>

                    </div>

                </div>
                <div class="col-md-2">
                    <button style="float: right;" class = "btn-cus-dessign btn btn-primary waves-effect waves-light" type="submit">Add Customer</button>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 col-xl-6 display-inline"  >
                    <div class="card m-b-30">
                        <div class="card-body">
                            <div class="row">
                            <div class="form-group col-md-6 display-inline">
                                <label for="">Cost Center</label>
                                <select name = "cost_center" id="cost_center" class = "form-control" required="true">
                                    <?php $__currentLoopData = $costcenters; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $costcenter): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($costcenter->id); ?>"> <?php echo e($costcenter->name); ?> </option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>

                            <div class="form-group col-md-6 display-inline">
                                <label for="">Customer Ref</label>
                                <input type="text" name="customer_ref" id="customer_ref" class = "form-control" placeholder = "Customer Reference" required="true">
                            </div>
                            </div>
                            <div class="row">
                            <div class="form-group col-md-6 display-inline">
                                <label for="">Name</label>
                                <input type="text" name="name" <?php echo e((isset($customer->first_name) ? "readonly='readonly'" : "")); ?> value="<?php echo e((isset($customer->first_name) ? $customer->first_name : "") ." ".(isset($customer->last_name) ?  $customer->last_name : "")); ?>" id="name" class = "form-control" placeholder = "Name" required="true">
                            </div>
                                <input type="hidden" name="consignee_id" value="<?php echo e((isset($customer->id) ? $customer->id : "")); ?>" id="consignee_id" />
                            <div class="form-group col-md-6 display-inline">
                                <label for="">Delivery Type</label>
                                <select name = "delivery_type" id="delivery_type" class = "form-control" placeholder="Delivery Type" required="true">
                                    <option value=""> select Delevery Type</option>
                                    <?php $__currentLoopData = $deliverytypes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $deliverytype): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($deliverytype->id); ?>"><?php echo e($deliverytype->name); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>
                            </div>
                            <div class="row">
                            <div class="form-group col-md-6 display-inline">
                                <label for="">City </label>
                                <select name = "city" id="city" <?php echo e((isset($customer->city_id) ? "readonly='readonly'" : "")); ?> class = "form-control" placeholder="City" required="true">
                                    <option value="">Select City</option>
                                    <?php $__currentLoopData = $cities; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $city): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <?php if(isset($customer->city_id)): ?>
                                            <?php if($customer->city_id ==  $city->id): ?>
                                                <option value="<?php echo e($city->id); ?>" selected="selected"><?php echo e($city->name); ?></option>
                                            <?php else: ?>
                                                <option value="<?php echo e($city->id); ?>"><?php echo e($city->name); ?></option>
                                            <?php endif; ?>
                                        <?php else: ?>
                                            <option value="<?php echo e($city->id); ?>"><?php echo e($city->name); ?></option>
                                        <?php endif; ?>

                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>
                            <div class="form-group col-md-6 display-inline">
                                <label for="">Contact </label>
                                <input type="text" name="contact" value="<?php echo e((isset($customer->contact_no) ? $customer->contact_no : "")); ?>" <?php echo e((isset($customer->contact_no) ? "readonly='readonly'" : "")); ?>  id="contact" class="form-control" placeholder="contact" required="true">
                            </div>
                            </div>
                            <div class="row">
                            <div class="form-group col-md-6 display-inline">
                                <label for="">Address</label>
                                <input type="text" name="address" value="<?php echo e((isset($customer->address) ? $customer->address : "")); ?>" <?php echo e((isset($customer->address) ? "readonly='readonly'" : "")); ?> id="address" class="form-control" placeholder="Address" required="true">
                            </div>

                            <div class="form-group col-md-6 display-inline">
                                <label for="">Email </label>
                                <input type="email" value="<?php echo e((isset($customer->email) ? $customer->email : "" )); ?>" <?php echo e((isset($customer->email) ? "readonly='readonly'" : "" )); ?> name="email" id="email" class="form-control" placeholder="Email" required="true">
                            </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-xl-6 display-inline" >

                    <div class="card m-b-30">
                        <div class="card-body">
                            <div class="row">
                                <div class="form-group col-md-12 display-inline">
                                    <label for="">Consignment Number </label>
                                    <input type="text" name="cn_no" id="cn_no" class = "form-control" placeholder = "Congiment_number" required="true">
                                </div>
                            </div>
                            <div class="row">
                            <div class="form-group col-md-6 display-inline">
                                <label for="">Customer Name </label>
                                <input type="text" name="customer_name" id="customer_name" class = "form-control" placeholder = "Address" required="true">
                            </div>
                                <div class="form-group col-md-6 display-inline">
                                    <label for="">Contact Number </label>
                                    <input type="text" name="customer_contact_number" id="customer_contact_number" class = "form-control" placeholder = "Contact Number" required="true">
                                </div>
                            </div>
                            <div class="row">

                            <div class="form-group col-md-6 display-inline">
                                <label for="">Email </label>
                                <input type="email" name="customer_email" id="customer_email" class = "form-control" placeholder = "Email" required="true">


                            </div>
                                <div class="form-group col-md-6 display-inline">
                                    <label for="">Contact Person </label>
                                    <input type="text" name="customer_contact_person" id="customer_contact_person" class = "form-control" placeholder = "Contact Person" required="true">
                                </div>
                            </div>
                                <div class="row">
                                    <div class="form-group col-md-12 display-inline">
                                        <label for="">Address </label>
                                        <input type="text" name="address" id="address" class = "form-control" placeholder = "Address" required="true">
                                    </div>
                                </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12 col-xl-12">
                <div class="card m-b-30">
                    <div class="card-body">

                        <div class="row">
                        <div class="form-group col-md-3 display-inline">
                            <label for="">Pieces</label>
                            <input type="number" name="pieces" id="pieces" class = "form-control" placeholder = "Pieces" required="true">
                        </div>
                        <div class="form-group col-md-3 display-inline">
                            <label for="">Weight</label>
                            <input type="number" name="weight" id="weight" class="form-control" placeholder="Weight in kg" required="true">
                        </div>
                        <div class="form-group col-md-3 display-inline">
                            <label for="">Fragile</label>
                            <select name="fragile" id="fragile" class="form-control" placeholder="Fragile" required="true">
                                <option value="">Select Fragile</option>
                                <option value="1">Yes</option>
                                <option value="0">No</option>
                            </select>
                        </div>
                        <div class="form-group col-md-3 display-inline">
                            <label for="">Origin </label>
                            <select name="origin" id="origin" class="form-control" placeholder="Origin" required="true">
                                <option value="">Origin</option>
                                <?php $__currentLoopData = $countries; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $country): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($country->id); ?>"><?php echo e($country->name); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>
                        </div>
                        <div class="row">
                        <div class="form-group col-md-3 display-inline">
                            <label for="">Destination Country</label>
                            <select name = "destination_country" id="destination_country" class="form-control" placeholder="Destination Country" required="true">
                                <option value="">Destination Country</option>
                                <?php $__currentLoopData = $countries; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $country): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($country->id); ?>"><?php echo e($country->name); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>
                        <div class="form-group col-md-3 display-inline">
                            <label for="">Destination City</label>
                            <select name="destination_city" id="destination_city" class="form-control" placeholder="Destination City" required="true">
                                <option value=""> Destination City</option>
                                <?php $__currentLoopData = $cities; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $city): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($city->id); ?>"><?php echo e($city->name); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                            </select>
                        </div>
                        <div class="form-group col-md-3 display-inline">
                            <label for="">COD Amount</label>
                            <input type="text" name="cod_amount" id="cod_amount" class = "form-control" placeholder="cod_amount" required="true">
                        </div>
                        <div class="form-group col-md-3 display-inline">
                            <label for="">Product Detail</label>
                            <input type="text" name="product_detail" id="product_detail" class = "form-control" placeholder = "Product Detail" required="true">
                        </div>
                        </div>
                        <div class="row">
                        <div class="form-group col-md-3">
                            <label for="">Insurance / Declared Value</label>
                            <input type="text" name="insurance" id="insurance" class = "form-control" placeholder = "Insurance / Declared Value" required="true">
                        </div>
                        <div class="form-group col-md-3">
                            <label for="">Service</label>
                            <select name = "service" id="service" class = "form-control" placeholder = "Service" required="true">
                                <option value="">Select Services</option>
                                <?php $__currentLoopData = $services; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $service): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($service->id); ?>"><?php echo e($service->name); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="">Remarks</label>
                            <input type="text" name="remarks" id="remarks" class = "form-control" placeholder = "Remarks" required="true">
                        </div>
                        </div>

                    </div>
                </div>
            </div>

        </form>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>