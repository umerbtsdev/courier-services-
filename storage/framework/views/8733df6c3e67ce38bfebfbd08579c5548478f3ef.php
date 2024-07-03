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
        
        <?php echo Form::open(array('url'=>'/Finance/Expense-Payment/add','method'=>'POST','id'=>'workshop-form', 'files' => false)); ?>

            <div class="form-group col-md-4">
                <label for="invoices" class="form-control-label">Invoice</label>
                <select id="invoices" name="invoice" class="form-control" required>
                    <option disabled selected></option>
                    <?php $__currentLoopData = $invoices; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $invoice): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($invoice->id); ?>" data-expenses="<?php echo e($invoice->total_expenses); ?>"><?php echo e($invoice->id); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>
            <div class="form-group col-md-4">
                <label for="expense_amount" class="form-control-label">Expense Amount</label>
                <input id="expense_amount" name="expense_amount" type="number" class="form-control" readonly required> 
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
                <label for="expense_paid_date" class="form-control-label">Expense Paid At</label>
                
                <?php echo Form::date("date_paid", date('Y-m-d'), ["class"=>"form-control","id"=>"expense_paid_date"]); ?>

                
            </div>
            <br/>
            <div class="col-md-12">
                <button style="float: right;" class = "custom-btn-action custom-btn-view bgcolr-orange no-margin" type="submit">Save</button>
            </div>
        <?php echo Form::close(); ?>

    </div>
</div>

<script>
    jQuery("#invoices").on("change", function(){
        var expenses = jQuery("#invoices").find(':selected').data("expenses");

        jQuery("#expense_amount").val(expenses);
    });

    jQuery("#workshop-form").on("submit", function(e){
        $expense_amount = jQuery("#expense_amount");
        if($expense_amount.val() <=1 ){
            e.preventDefault();
            transition("s2c");
            jQuery("#e2c").html("<span class='leaseAmnt'>Expense Amount cannot be null</span>");
        }else{
            jQuery("#expense_amount").parent().find(".leaseAmnt").remove();
        }
    });

    function transition(id){
        jQuery("#"+id).html("<style>#e2c{background: linear-gradient(90deg, #f00, #f00, #f00);background-repeat: no-repeat;background-size: 80%;animation: animate 6s linear 1;-webkit-background-clip: text;-webkit-text-fill-color: rgba(255, 255, 255, 0);}</style>")
    }
</script>