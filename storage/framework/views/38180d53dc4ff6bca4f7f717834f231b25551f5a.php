<?php $__env->startSection('htmlheader_title'); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('contentheader_title'); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('title', 'Chart of Account'); ?>
<?php $__env->startSection('content'); ?>
<style>
    .dropdownActive {
        color: rebeccapurple;
    }
    .dropdownActive:hover, .dropdownActive:focus {
        color: slateblue !important;
    }
    .dropdownNotActive:hover, .dropdownNotActive:focus {
        color: darkslategrey !important;
    }
        .coa_list ul {
            padding: 0em;
        }
        
        .coa_list ul li, .coa_list ul li ul li {
            position:relative;
            top:2px;
            bottom:0;
            padding-bottom: 0px;
            margin-bottom: 0px;
        
        }
        
        .coa_list ul li ul {
            margin-left: 17px;
            margin-top: 6px;
        }
        
        .coa_list li {
            list-style-type: none;
            
        }
        
        .coa_list li a {
            padding:0 0 0 3px;
            position: relative;
            top:0em;
        }
        
        .coa_list li a:hover {
            text-decoration: none;
        }
        
        .coa_list  a.addBorderBefore:before {
            content: "";
            display: inline-block;
            width: 2px;
            height: 28px;
            position: absolute;
            left: -47px;
            top:-39px;
            /*border-left: 1px solid gray;*/
        }
        
        .coa_list li:before {
            content: "";
            display: inline-block;
            width: 25px;
            height: 0;
            position: relative;
            /*position: initial;*/
            left: 1px;
            top: -10px;
            /*border-top: 1px solid gray;*/
        }
        
        /*.coa_list ul li ul li:last-child:after, .coa_list ul li:last-child:after {
            content: '';
            display: block;
            width: 1em;
            height: 1em;
            position: relative;
            
            top: 9px;
            left: -1px;
        }*/
</style>

<div class="container-fluid">
    <div class="col-md-12">

        <div class="page-heading-primary">
          <span>
              <a href="#"> <i class="fa fa-home"></i> </a>
              <i class="fa fa-angle-right"> &nbsp; </i>
              <b> finance </b>
              <i class="fa fa-angle-right"> &nbsp; </i>
              <b> Chart of Account</b>
          </span>
            <h1>
                <b>Chart of Account</b>
            </h1>
            <div class="col-md-12">
                <div class="flash-message">
        
                    <?php $__currentLoopData = ['danger', 'warning', 'success', 'info']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $msg): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php if(Session::has('alert-' . $msg)): ?>
        
                            <p class="alert alert-<?php echo e($msg); ?>"><?php echo e(Session::get('alert-' . $msg)); ?> <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a></p>
                        <?php endif; ?>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        
                </div> <!-- end .flash-message -->
            </div>
            <div class="row custom-container-wrap">
                <div class="col-md-6" style="height: 534px; overflow-x: auto;" >
                    <h3>Category List</h3>
                    <div class="coa_list">
                        <ul  class="coa_list_ul"><?php $pid=""; ?>
                            <?php $__currentLoopData = $charts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $chart): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                
                                <?php if($chart->parent_id ==null ): ?>
                                <li  rel="<?php echo e($chart->id."|".$chart->name."|".$chart->op_cr."|".$chart->op_dr."|".$chart->parent_id."|".$chart->level); ?>"  >
                                    <a href=""  class="no-click"> <?php echo $chart->name; ?> (<?php echo e(count($chart->childs)); ?>)</a>
                                <?php endif; ?>
                                <?php if(count($chart->childs) ): ?>
                                    <ul>
                                        <?php $__currentLoopData = $chart->childs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $child2): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <li  rel="<?php echo e($child2->id."|".$child2->name."|".$child2->op_cr."|".$child2->op_dr."|".$child2->parent_id."|".$child2->level); ?>"  >
                                                <?php if($child2->id != $pid): ?>
                                                <a href="" class="no-click"> <?php echo $child2->name; ?> (<?php echo e(count($child2->childs)); ?>)</a>
                                                <?php else: ?>
                                                    <span class="removePp"></span>
                                                <?php endif; ?>
                                                <?php if(count($child2->childs)): ?>
                                                    <ul>
                                                        <?php $__currentLoopData = $child2->childs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $child3): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                            <li  rel="<?php echo e($child3->id."|".$child3->name."|".$child3->op_cr."|".$child3->op_dr."|".$child3->parent_id."|".$child3->level); ?>"  >
                                                                <?php $pid= $child3->id; ?>
                                                                <a href=""  class="no-click"><?php echo $child3->name; ?> (<?php echo e(count($child3->childs)); ?>)</a>
                                                                <?php if(count($child3->childs)): ?>
                                                                    <?php echo $__env->make('finance.chartOfAccount.childmenu',["childs"=>$child3->childs], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                                                                <?php endif; ?>
                                                            </li>
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                    </ul>
                                                <?php endif; ?>
                                            </li>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </ul>
                                <?php endif; ?>
                                <?php if($chart->parent_id ==null): ?>
                                </li>
                                <?php endif; ?>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </ul>
                    </div>
                </div>

                <div class="col-md-6 custom-table-styles">
                    <?php //if(App\Helper\Common::userwisepermission(Auth::user()->id, "update category")) { ?>
                    <?php echo Form::open(array('url'=>'Finance/Chart-of-Account/child/save','method'=>'POST','id'=>'CatUpdate', 'files' => true)); ?>

                    <?php //} ?>                
                        <div class="col-sm-12">
                            <div class="col-md-6">
                                <div class="form-group ">
                                    <?php echo Form::label('Master:'); ?>

                                    <?php echo Form::text('master', null, ['class'=>'form-control','readonly'=>'readonly' ,'id'=>'master']); ?>

                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group ">
                                    <?php echo Form::label('Child:'); ?>

                                    <?php echo Form::text('child', null, ['class'=>'form-control','id'=>'child']); ?>

                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="col-md-6">
                                <div class="form-group">
                                <?php echo Form::label('Opening Credit:'); ?>

                                <?php echo Form::text('op_cr', null, ['class'=>'form-control', 'id'=>'op_cr',]); ?>

                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group ">
                                    <?php echo Form::label('Opening Debit:'); ?>

                                    <?php echo Form::text('op_dr', null, ['class'=>'form-control','id'=>'op_dr']); ?>

                                </div>
                            </div>
                            
                            <?php echo Form::hidden("masterID", null, ["id"=>"masterID"]); ?>

                            <?php echo Form::hidden("level", null, ["id"=>"level"]); ?>

                            
                        </div>
                        <div class="col-sm-12">
                            <div class="col-md-6"></div>
                            <div class="col-md-6">
                                <button class="btn btn-success col-md-6" style="float:right" >Save</button>
                            </div>
                        </div>
                    <?php echo Form::close(); ?>

                    


                </div>

               
            </div>
        </div>

    </div>
</div>
<script src="<?php echo e(asset('js\MultiNestedList.js')); ?>"></script>
<script>
    $(document).ready(function(){
        $(".coa_list ul li ul").css({"display":"none"});
        $(".removePp").parent().parent().remove();

        var uls = $(".coa_list_ul").children().siblings().closest("ul");

        if(uls.length > 1){
            for(var i=1; i < uls.length; i++){
                uls[i].remove();
            }
        }
       
    });

    $(".no-click").click(function(e){
        e.preventDefault();
        master = $(this).parent().attr("rel").split("|")[0];
        name = $(this).parent().attr("rel").split("|")[1];
        op_cr = $(this).parent().attr("rel").split("|")[2];
        op_dr = $(this).parent().attr("rel").split("|")[3];
        masterID = $(this).parent().attr("rel").split("|")[4];
        level = $(this).parent().attr("rel").split("|")[5];
        
        //console.log("master = "+master+"; name = "+name+"; op_cr = "+op_cr+"; op_dr = "+op_dr+"; masterID = "+masterID);

        $("#master").val(name);
        $("#name").val(name);
       // $("#op_cr").val(op_cr);
      // $("#op_dr").val(op_dr);
        $("#masterID").val(master);
        $("#level").val(level);
        
    });
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('adminlte::layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>