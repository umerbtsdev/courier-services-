<div class="row">
        <div class="col-md-12">
            <div class="box box-primary">
                {!! Form::open(array('url'=>'workshops/Manufacturers/delete/','method'=>'POST','id'=>'PayDel', 'files' => true)) !!}
                    <div class="box-body">
                        {!! Form::hidden("manufacturer_id", $id) !!}
                        <p>Are you sure you want to remove this Manufacturer? <br><strong>NOTE:</strong> This process cannot be undone.</p>
                    </div>
                    <div class="box-footer">
                        <div style="float-right">
                            <button class="btn btn-primary" id="cancel">Cancel</button>
                            <button class="btn btn-danger">Delete</button>
                        </div>
                    </div>
                {{ Form::close() }}
            </div>
        </div>
    </div>
    <script>
    $("#cancel").on("click", function(e){
        e.preventDefault();
        jQuery('.custom-modal-rj').modal('toggle');
    });
    </script>