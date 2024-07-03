<div class="row">
        <div class="col-md-12">
            <div class="box box-primary">
                <?php echo Form::open(array('url'=>'/Finance/Vehicle-Leasing/delete','method'=>'POST','id'=>'PayDel', 'files' => true)); ?>

                    <div class="box-body">
                        <?php echo Form::hidden("lease_id", $id); ?>

                        <p>Are you sure you want to delete this record? <br><strong>NOTE:</strong> This process cannot be undone.</p>
                    </div>
                    <div class="box-footer">
                        <div style="float-right">
                            <button class="btn btn-primary" id="cancel">Cancel</button>
                            <button class="btn btn-danger">Delete</button>
                        </div>
                    </div>
                <?php echo e(Form::close()); ?>

            </div>
        </div>
    </div>
    <script>
    $("#cancel").on("click", function(e){
        e.preventDefault();
        jQuery('.custom-modal-rj').modal('toggle');
    });
    </script>