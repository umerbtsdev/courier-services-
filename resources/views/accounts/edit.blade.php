<div class="row">
        {!! Form::open(array('url'=>'/General-Setup/accounts/edit','method'=>'POST','id'=>'purchase-order-form', 'files' => true)) !!}
        <div class="col-md-12">
            <div class="box box-primary">
                <div class="box-body">
                    
                    {!! Form::hidden("account_id", $account->id) !!}
                    
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="bankSelect" class="control-label ">Bank:</label>
                            <select class="form-control" name="bank_id" required id="bankSelect">
                                <option> - </option>
                                @foreach ($banks as $bank)
                                    <option value="{{ $bank->bank_id }}" {{ ($account->bank_id ==$bank->bank_id ? "selected":"" ) }} > {{ $bank->bank_name }} </option>
                                @endforeach
                            </select>
                        </div>   
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="bank_branches" class="control-label ">Branch:</label>
                            <select class="form-control" name="bank_branch" required id="bank_branches">
                               @foreach ($BankBranches as $BankBranch)
                                   <option value="{{ $BankBranch->id }}" {{ ($account->branch_id ==$BankBranch->id ? "selected":"" ) }}>{{ $BankBranch->branch_name }}</option>
                               @endforeach
                            </select>
                        </div>   
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="companySelect" class="control-label ">Account #:</label>
                            {!! Form::text("account_num", $account->acc_number, ["class"=>"form-control","required"=>true ]) !!}
                        </div>   
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="companySelect" class="control-label ">Account Title:</label>
                            {!! Form::text("account_title", $account->acc_title, ["class"=>"form-control","required"=>true ]) !!}
                        </div>   
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="companySelect" class="control-label ">IBAN #:</label>
                            {!! Form::text("account_iban", $account->iban, ["class"=>"form-control"]) !!}
                        </div>   
                    </div>
                </div>
            </div> 
            
            {!! Form::hidden("bank_name", null, ["id"=> "bank_name"]) !!}
            {!! Form::hidden("coa_code", $account->coa_code) !!}
            
            <div class="col-md-12">
                {!! Form::submit("Save", ["class"=>" btn col-md-12 submi btn-primary "]) !!} 
            </div>
        </div>
        {!! Form::close() !!}
    </div>
    <script>
        jQuery(document).ready(function(){
            jQuery("#bank_name").val(jQuery("#bankSelect :selected").text());
            jQuery("#bankSelect").on("change", function(){
                jQuery('#bank_branches').empty();
                var bank_id= jQuery(this).val();
                jQuery.ajax({
                    url: '/General-Setup/FetchBankBranches/'+bank_id,
                    type: "get",
                    data: {
                        "_token": "{{ csrf_token() }}",
                    },
                    success: function(data){
        
                        let deptSelect = jQuery('#bank_branches');
                        deptSelect.empty();
                        deptSelect.append(jQuery('<option></option>').attr('value', '').text(''));
                        jQuery.each(JSON.parse(data),function(i,obj){
                            deptSelect.append(jQuery('<option></option>').attr('value', obj.id).text(obj.branch_name));
                        });  
                    }
                });
            });
            
        });
    </script>
    
    