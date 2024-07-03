<style>
    .leaseAmnt{
        color: red;
    }
    
    @keyframes  animate {
        0% {
          background-position: -500%;
        }
        100% {
          background-position: 500%;
        }
      }
</style>
<div  id="s2c"></div>
<div class="bgcolr-grey">
        <?php if(Request::session()->has('user_create_status')): ?>
        <?php if(Request::session()->pull('user_create_status') == 'error'): ?>
        <div class="alert alert-danger"><?php echo e(Request::session()->pull('user_create_message')); ?></div>
        <?php endif; ?>   
        <?php endif; ?>
    <div class="box-body">
        
        <?php echo Form::open(array('url'=>'/Finance/Depreciations-Paid/add','method'=>'POST','id'=>'workshop-form', 'files' => false)); ?>

            <div class="form-group col-md-4">
                <label for="vehicles" class="form-control-label">Vehicle</label>
                <select id="vehicles" name="vehicle" class="form-control" required>
                    <option disabled selected></option>
                    <?php $__currentLoopData = $vehicles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $vehicle): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($vehicle->id); ?>" data-coa="<?php echo e($vehicle->coa_id); ?>" data-purchase-amount="<?php echo e($vehicle->purchase_amount != 0 ? $vehicle->purchase_amount:'0'); ?>" data-life="<?php echo e($vehicle->life != 0 ? $vehicle->life:'0'); ?>"><?php echo e($vehicle->vehicle_no); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>
            <div class="form-group col-md-4">
                <label for="vehicle_lease_amount" class="form-control-label">Depriciation Amount</label>
                <input id="vehicle_lease_amount" name="vehicle_lease_amount" type="number" class="form-control" readonly required> 
                <p id="e2c"></p>
            </div>
            <div class="form-group col-md-4">
                <label for="coa_list" class="form-control-label">Account</label>
                <select id="coa_list" name="coa_list" class="form-control" required>
                    <option disabled selected></option>
                    <?php $__currentLoopData = $coa; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $coa): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($coa->id); ?>" ><?php echo e($coa->name); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>
            <div class="form-group col-md-4">
                <label for="lease_amount_paid" class="form-control-label">Depriciation Paid At</label>
                
                <?php echo Form::date("date_paid", date('Y-m-d'), ["class"=>"form-control","id"=>"lease_amount_paid"]); ?>

                
            </div>
            <br/>
            <div class="col-md-12">
                <button style="float: right;" class = "custom-btn-action custom-btn-view bgcolr-orange no-margin" type="submit">Save</button>
            </div>
            
            <?php echo Form::hidden("vehicle_coa", null, ["id"=>"vehicle_coa"]); ?>

            
        <?php echo Form::close(); ?>

    </div>
</div>

<script>
    jQuery("#vehicles").on("change", function(){
        var purchase_amount = jQuery("#vehicles").find(':selected').data("purchase-amount");
        var life = jQuery("#vehicles").find(':selected').data("life");
        var coa = jQuery("#vehicles").find(':selected').data("coa");

        jQuery("#vehicle_coa").val(coa);
        jQuery("#vehicle_lease_amount").val(parseInt(purchase_amount) / parseInt(life));
    });

    jQuery("#workshop-form").on("submit", function(e){
        $vehicle_lease_amount = jQuery("#vehicle_lease_amount");
        if($vehicle_lease_amount.val() <=1 ){
            e.preventDefault();
            transition("s2c");
            jQuery("#e2c").html("<span class='leaseAmnt'>Depriciation Amount cannot be null</span>");
        }else{
            jQuery("#vehicle_lease_amount").parent().find(".leaseAmnt").remove();
        }
    });

    function transition(id){
        jQuery("#"+id).html("<style>#e2c{background: linear-gradient(90deg, #f00, #f00, #f00);background-repeat: no-repeat;background-size: 80%;animation: animate 6s linear 1;-webkit-background-clip: text;-webkit-text-fill-color: rgba(255, 255, 255, 0);}</style>")
    }
</script>