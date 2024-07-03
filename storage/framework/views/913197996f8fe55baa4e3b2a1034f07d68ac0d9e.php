<?php $__env->startSection('htmlheader_title'); ?>
    <div> Month wise Transport </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('contentheader_title'); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('title', 'Account List'); ?>








<?php $__env->startSection('content'); ?>
    <div class="row">
        <div class="col-md-12">
            <div class="flash-message">

                <?php $__currentLoopData = ['danger', 'warning', 'success', 'info']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $msg): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php if(Session::has('alert-' . $msg)): ?>

                        <p class="alert alert-<?php echo e($msg); ?>"><?php echo e(Session::get('alert-' . $msg)); ?> <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a></p>
                    <?php endif; ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

            </div> <!-- end .flash-message -->
        </div>
        <div class="col-md-12">
            <div class="page-heading-primary">
                <span>
                    <a href="#"> <i class="fa fa-home"></i> </a>
                    <i class="fa fa-angle-right"> &nbsp; </i>
                    <a href="#"> Month wise Transport Report </a>
                </span>
                <h1>
                    <b> Month wise Transport Report</b>
                    <br/>
                </h1>
            </div>

        </div>
        <div class="col-md-12">
            <?php if(App\Helper\Common::userwisepermission(Auth::user()->id, "Month Wise Transport Create")): ?>
                <?php echo Form::open(array('url'=>'Report/monthly-transport-report','method'=>'POST','id'=>'client-ledger-report', 'files' => true)); ?>

                <div class="col-md-3">
                    <div class="form-group adjust">
                        <label  for="Purchase_inv_id">Date From</label>
                        <input type="date" class="form-control textrequired" name="date_from" id="date_from" value="<?php echo e(isset($data["date_from"]) ? date("Y-m-d",strtotime($data["date_from"])) : ""); ?>" placeholder="Enter Date from">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group adjust">
                        <label  for="Purchase_inv_id">Date To</label>
                        <input type="date" class="form-control textrequired" name="date_to" id="date_to" value="<?php echo e(isset($data["date_to"]) ? date("Y-m-d",strtotime($data["date_to"])) : ""); ?>" placeholder="Enter Date to">
                    </div>
                </div>
                <div class="col-md-3">
                <div class="form-group adjust">
                    <label  for="Purchase_inv_id">Vehicle</label>
                <select class="form-control selectrequired" class="form-control" name="vehicle_id" id="vehicle_id" >
                    <option value="">Select Vehicle Station</option>
                    <?php $__currentLoopData = $vehicles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $vehicle): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php if(isset($data["vehicle_id"])): ?>
                            <?php if($data["vehicle_id"] == $vehicle->id): ?>
                                <option value="<?php echo e($vehicle->id); ?>" selected="selected"><?php echo e($vehicle->vehicle_no); ?></option>
                            <?php else: ?>
                                <option value="<?php echo e($vehicle->id); ?>"><?php echo e($vehicle->vehicle_no); ?></option>
                            <?php endif; ?>
                         <?php else: ?>
                            <option value="<?php echo e($vehicle->id); ?>"><?php echo e($vehicle->vehicle_no); ?></option>
                        <?php endif; ?>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
                </div>
            </div>
                <div class="col-md-1">
                    <div class="form-group adjust">
                        <label  for="Purchase_inv_id"></label>
                        <button type="submit" class="btn btn-primary bgcolr-orange" id="submit-dept" style="float: right">Submit</button>
                    </div>
                </div>
                <?php echo Form::close(); ?>


            <?php endif; ?>
        </div>
        <div class="col-md-12">
            <?php if(isset($monthwisereport)): ?>

                <table id="example" class="table table-striped table-bordered" style="width:100%">
                    <thead>
                    <tr>
                        <th>
                            id
                        </th>
                        <th>
                            Date
                        </th>
                        <th style="text-align: center;">
                            Billed
                        </th>
                        <th style="text-align: center;">
                            Detention
                        </th>
                        <th style="text-align: center;">
                            Total Billed
                        </th>
                        <th style="text-align: center;">
                            Diesel
                        </th>
                        <th style="text-align: center;">
                            Driver Allowance
                        </th>
                        <th style="text-align: center;">
                            Misc
                        </th>
                        <th style="text-align: center;">
                            Total Expense
                        </th>
                        <th style="text-align: center;">
                            Net Profit/Loss
                        </th>
                        <th style="text-align: center;">
                            Reading Start
                        </th>
                        <th style="text-align: center;">
                            Reading End
                        </th>
                        <th style="text-align: center;">
                            Total Reading
                        </th>
                        <th style="text-align: center;">
                            Remarks
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php // $profit_afn = 0; ?>
                    <?php // $profit_usd = 0; ?><?php $count = 0; $status = 0; ?>
                    <?php $period = \Carbon\CarbonPeriod::create($data["date_from"], $data["date_to"]); ?>

                    <?php $totalbl = 0; ?>
                    <?php $totalexp = 0; ?>
                    <?php $totalbilled = 0; ?>
                    <?php $totaldetention = 0; ?>
                    <?php $totaldiesel = 0; ?>
                    <?php $totaldriverallowance =0 ?>
                    <?php $totalmisc =0 ?>
                    <?php $totalprofit =0 ?>
                    <?php $totalreading = 0 ?>

                    <?php $__currentLoopData = $period; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $date): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                    <?php $__currentLoopData = $monthwisereport; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $monthwiserpt): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                        <?php if($date->format('d.m.Y') != date('d.m.Y', strtotime($monthwiserpt->trip_date))): ?>

                            <?php continue; ?>
                            <?php else: ?>
                        <?php //$profit_afn = $profit_afn + ($Profitandloss->currency == "AFN" ? floatval($Profitandloss->total_amount) : 0); ?>
                        <?php //$profit_usd = $profit_usd + ($Profitandloss->currency == "USD" ? floatval($Profitandloss->total_amount) : 0); ?>
                        <tr>
                            <td>
                                <?php echo e($count); ?>

                            </td>
                            <td>

                                <?php echo e($date->format('d.m.Y')); ?>

                                
                            </td>
                            <td>
                                <?php $totalbilled +=$monthwiserpt->Billed ?>
                                <?php echo e($monthwiserpt->Billed); ?>

                            </td>
                            <td style="text-align: center;">
                                <?php $totaldetention += $monthwiserpt->Detention ?>
                                <?php echo e($monthwiserpt->Detention); ?>

                            </td>
                            <td style="text-align: center;">
                                <?php $totalbl += floatval($monthwiserpt->Billed) + floatval($monthwiserpt->Detention); ?>
                                <?php echo e(floatval($monthwiserpt->Billed) + floatval($monthwiserpt->Detention)); ?>

                            </td>
                            <td style="text-align: center;">
                                <?php $totaldiesel += $monthwiserpt->Diesel ?>
                                <?php echo e($monthwiserpt->Diesel); ?>

                            </td>
                            <td style="text-align: center;">
                                <?php $totaldriverallowance += $monthwiserpt->driver_allowance ?>
                                <?php echo e($monthwiserpt->driver_allowance); ?>

                            </td>
                            <td style="text-align: center;">
                                <?php $totalmisc += $monthwiserpt->misc ?>
                                <?php echo e($monthwiserpt->misc); ?>

                            </td>
                            <td style="text-align: center;">
                                <?php $totalexp += floatval($monthwiserpt->driver_allowance) + floatval($monthwiserpt->Diesel) + floatval($monthwiserpt->misc); ?>
                                <?php echo e(floatval($monthwiserpt->driver_allowance) + floatval($monthwiserpt->Diesel) + floatval($monthwiserpt->misc)); ?>

                            </td>
                            <td style="text-align: center;">
                                <?php $totalprofit += floatval($monthwiserpt->Billed) + floatval($monthwiserpt->Detention) - (floatval($monthwiserpt->driver_allowance) + floatval($monthwiserpt->Diesel) + floatval($monthwiserpt->misc)); ?>
                                <?php echo e(floatval($monthwiserpt->Billed) + floatval($monthwiserpt->Detention) - (floatval($monthwiserpt->driver_allowance) + floatval($monthwiserpt->Diesel) + floatval($monthwiserpt->misc))); ?>

                            </td>
                            <td style="text-align: center;">
                                <?php echo e($monthwiserpt->reading_start); ?>

                            </td>
                            <td style="text-align: center;">
                                <?php echo e($monthwiserpt->reading_end); ?>

                            </td>
                            <td style="text-align: center;">
                                <?php $totalreading += (intval($monthwiserpt->reading_end) - intval($monthwiserpt->reading_start)) ?>
                                <?php echo e(intval($monthwiserpt->reading_end) - intval($monthwiserpt->reading_start)); ?>

                            </td>
                            <td style="text-align: center;">
                                <?php echo e($monthwiserpt->remarks); ?>

                            </td>
                        </tr>
                            <?php $status = 1; ?>
                        <?php endif; ?>

                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                            <?php $count ++; ?>
                        <?php if($status == 0): ?>
                            <tr>
                                <td>
                                    <?php echo e($count); ?>

                                </td>
                                <td>
                                    <?php echo e($date->format('d.m.Y')); ?>

                                </td>
                                <td colspan="12">
                                    <b>Not Working</b>
                                </td>
                                <td style="display: none;text-align: center;">

                                </td>
                                <td style="display: none;text-align: center;">

                                </td>
                                <td style="display: none;text-align: center;">

                                </td>
                                <td style="display: none;text-align: center;">

                                </td>
                                <td style="display: none;text-align: center;">

                                </td>
                                <td style="display: none;text-align: center;">

                                </td>
                                <td style="display: none;text-align: center;">

                                </td>
                                <td style="display: none;text-align: center;">

                                </td>
                                <td style="display: none;text-align: center;">

                                </td>
                                <td style="display: none;text-align: center;">

                                </td>
                            </tr>
                            <?php else: ?>
                            <?php $status = 0; ?>
                            <?php endif; ?>
                            
                                
                                    
                                
                            

                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td>
                            <?php echo e($count); ?>

                        </td>
                        <td>
                            <span style="font-weight: bold"> Total </span>
                        </td>
                        <td>
                            <span style="font-weight: bold;font-size: 16px;"><?php echo e($totalbilled); ?></span>
                        </td>
                        <td style="text-align: center;">
                            <span style="font-weight: bold;font-size: 16px;"><?php echo e($totaldetention); ?></span>
                        </td>
                        <td style="text-align: center;">
                            <span style="font-weight: bold;font-size: 16px;"> <?php echo e($totalbl); ?> </span>
                        </td>
                        <td style="text-align: center;">
                            <span style="font-weight: bold;font-size: 16px;"><?php echo e($totaldiesel); ?></span>
                        </td>
                        <td style="text-align: center;">
                            <span style="font-weight: bold;font-size: 16px;"><?php echo e($totaldriverallowance); ?></span>
                        </td>
                        <td style="text-align: center;">
                            <span style="font-weight: bold;font-size: 16px;"><?php echo e($totalmisc); ?></span>
                        </td>
                        <td style="text-align: center;">
                            <span style="font-weight: bold;font-size: 16px;"><?php echo e($totalexp); ?></span>
                        </td>
                        <td style="text-align: center;">
                            <span style="font-weight: bold;font-size: 16px;"><?php echo e($totalprofit); ?></span>
                        </td>
                        <td style="text-align: center;">

                        </td>
                        <td style="text-align: center;">

                        </td>

                        <td style="text-align: center;">
                            <span style="font-weight: bold;font-size: 16px;"><?php echo e($totalreading); ?></span>
                        </td>
                        <td style="text-align: center;">

                        </td>
                    </tr>
                    </tbody>
                </table>
            <?php endif; ?>
        </div>
    </div>
    <script>
        var titletop = "<div style'text-align: center;font-size: 30px;font-weight: bold;'>Month wise Transport Report from <?php echo e(isset($data['date_from']) ? date('d-m-Y',strtotime($data['date_from'])) : ''); ?> to <?php echo e(isset($data['date_from']) ? date('d-m-Y',strtotime($data['date_from'])) : ''); ?> </div>";
        $(document).ready(function() {
            $('#example').DataTable({
                lengthMenu: [[500], [500]],
                dom: 'Blfrtip',
                aaSorting : [[0, 'asc']],
                aoColumnDefs: [{ "bVisible": false, "aTargets": [0] }],
                buttons: [
                    { extend: 'print', footer: true, title: titletop },
                    { extend: 'copy', footer: true, title: titletop },
                    { extend: 'csv', footer: true, title: titletop },
                    { extend: 'excel', footer: true, title: titletop }
                ]
            } );
        } );
    </script>
<?php $__env->stopSection(); ?>





<?php echo $__env->make('adminlte::layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>