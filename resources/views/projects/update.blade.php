<style>
        .selectsEff{
            border-width: 1px;
            border-style: solid;
            border-color: red;
            
        }
        .selects{
            transition: all 1s cubic-bezier(0.68, -0.55, 0.27, 1.55);
            -webkit-transition: border 1s cubic-bezier(0.68, -0.55, 0.27, 1.55);
          
        }
        
    </style>
    <div class="page-heading-primary">
            
    </div>
    
    <div class="bgcolr-grey">
         @if(Request::session()->has('user_create_status'))
          @if(Request::session()->pull('user_create_status') == 'error')
          <div class="alert alert-danger">{{Request::session()->pull('user_create_message')}}</div>
          @endif   
         @endif
         {!! Form::open(array('url'=>'project-management/projects/edit/','method'=>'POST','id'=>'project-form', 'class'=>"form-horizontal", 'files' => false)) !!}
         {!! Form::hidden("project_id", $project->id) !!}
            <div class="box-body">
                <div class="col-sm-10">
                    <div class="form-group col-sm-12">
                        <label for="project_name" class="control-label col-sm-3">Project Name:</label>
                        <div class="col-sm-8">
                           {!! Form::text("project_name", $project->name, ["class"=>"form-control","name"=>"project_name", "id"=> "project_name","pattern"=>".{3,}","required"=>true, "title"=> "please Enter Project Name with 3 characters minimum"]) !!}
                        </div>
                    </div>
    
                    <div class="form-group col-sm-12">
                        <label for="route_from" class="control-label col-sm-3">Route From:</label>
                        <div class="col-sm-8">
                           <select class="form-control selects" id="route_from" required name="route_from">
                                <option disabled selected value="unkown">Select Route</option>
                                @foreach ($routes as $route)
                                    <option value="{{ $route->id }}" {{ ($project->route_from_id == $route->id ? "selected":"") }}> {{ $route->name }}</option>
                                @endforeach
                                
                           </select>
                        </div>
                    </div>
                    <div class="form-group col-sm-12">
                        <label for="route_to" class="control-label col-sm-3">Route To:</label>
                        <div class="col-sm-8">
                           <select class="form-control selects" id="route_to" required name="route_to">
                                <option disabled selected value="unkown">Select Route</option>
                                @foreach ($routes as $route)
                                    <option value="{{ $route->id }}" {{ ($project->route_to_id == $route->id ? "selected":"") }}> {{ $route->name }}</option>
                                @endforeach
                           </select>
                        </div>
                    </div>
                    <div class="form-group col-sm-12">
                        <label for="status" class="control-label col-sm-3">Status:</label>
                        <div class="col-sm-8">
                           <select class="form-control" id="status" required name="status">
                                <option selected value="0" {{ ($project->status == 0 ? "selected":"") }} >disabled</option>
                                <option value="1" {{ ($project->status == 1 ? "selected":"") }} >enabled</option>
    
                           </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="box-footer">
                <div class="col-md-12" style="">
                    <button style="float:right" class = "custom-btn-action custom-btn-view bgcolr-orange no-margin" type="submit">Update Project</button>
                </div>
            </div>
        {!! Form::close() !!}
    </div>
    
    <script>
    
        jQuery("#project-form").on("submit", function(pf){
            jQuery(".selects").each(function(i,v){
                if(jQuery(this).val()==null){
                    pf.preventDefault();
                    jQuery(this).addClass('selectsEff');
                }
            });
        });
        jQuery(".selects").on("change", function(){
            jQuery(this).removeClass('selectsEff');
        })
    </script>