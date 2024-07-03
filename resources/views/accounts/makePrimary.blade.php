
<div class="row">
        <div class="col-md-12">
            <div class="">
                {!! Form::open(array('url'=>'/General-Setup/accounts/makePrimary','method'=>'POST','id'=>'PayDel', 'files' => true)) !!}
                    <div class="box-body">
                        {!! Form::hidden("account_id",$accounts->id) !!}
                        {!! Form::hidden("account_title",$accounts->acc_title) !!}
                        {!! Form::hidden("bank_name",$accounts->bank_name) !!}
                        {!! Form::hidden("branch_name",$accounts->branch_name) !!}
                        <div> 
                            <p><b>Bank :</b> {{ $accounts->bank_name }} - {{ $accounts->branch_name }}</p>
                            <p><b>Title :</b> {{ $accounts->acc_title }}</p>
                            <p><b>Account #:</b> {{ $accounts->acc_number }}</p>
                        </div>
                        <p>Are you sure you want to make this Account Primary? </p>
                    </div>
                    <div class="box-footer">
                        <div style="float-right">
                            <button class="btn btn-danger" id="cancel">Cancel</button>
                            <button class="btn  btn-primary">Make Primary</button>
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