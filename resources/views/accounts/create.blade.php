<div class="row">
    {!! Form::open(array('url'=>'/General-Setup/accounts/save','method'=>'POST','id'=>'purchase-order-form', 'files' => true)) !!}
    <div class="col-md-12">
        <div class="box box-primary">
            <div class="box-body">

                <div class="col-md-2">
                    <div class="form-group">
                        <label for="bankSelect" class="control-label ">Bank:</label>
                        <select class="form-control" name="bank_id" required id="bankSelect">
                            <option> - </option>
                            @foreach ($banks as $bank)
                                <option value="{{ $bank->bank_id }}" > {{ $bank->bank_name }} </option>
                            @endforeach
                        </select>
                    </div>    
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="bank_branches" class="control-label ">Branch:</label>
                        <select class="form-control" name="bank_branch" required id="bank_branches">
                           
                        </select>
                    </div>   
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="companySelect" class="control-label ">Account #:</label>
                        {!! Form::text("account_num", null, ["class"=>"form-control","required"=>true ]) !!}
                    </div>   
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="companySelect" class="control-label ">Account Title:</label>
                        {!! Form::text("account_title", null, ["class"=>"form-control","required"=>true ]) !!}
                    </div>   
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="companySelect" class="control-label ">IBAN #:</label>
                        {!! Form::text("account_iban", null, ["class"=>"form-control"]) !!}
                    </div>   
                </div>
            </div>
        </div> 
        
        {!! Form::hidden("bank_name", null, ["id"=> "bank_name"]) !!}
        
        <div class="col-md-12">
            {!! Form::submit("Save", ["class"=>" btn col-md-12 submi btn-primary "]) !!} 
        </div>
    </div>
    {!! Form::close() !!}
</div>
<script>
    jQuery(document).ready(function(){
        jQuery("#bankSelect").on("change", function(){
            jQuery("#bank_name").val(jQuery("#bankSelect :selected").text());
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

