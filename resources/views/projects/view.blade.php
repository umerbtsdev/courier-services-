<style>

    .view-disabled{
        background: white !important;
        border: none !important;
        box-shadow: 0px 0px 6px 2px rgba(0,0,0,.075) !important;
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
        <form>
            <div class="box-body">
                <div class="col-sm-10">
                    <div class="form-group col-sm-12">
                        <label for="project_name" class="control-label col-sm-3">Project Name:</label>
                        <div class="col-sm-8">
                           {!! Form::text("", $project->project_name, ["class"=>"form-control view-disabled","id"=> "project_name","readonly"=>"true"]) !!}
                        </div>
                    </div>
    
                    <div class="form-group col-sm-12">
                        <label for="route_from" class="control-label col-sm-3">Route From:</label>
                        <div class="col-sm-8">
                           {!! Form::text("", $project->route_from_name, ["class"=>"form-control view-disabled","id"=> "route_from","readonly"=>"true"]) !!}                            
                        </div>
                    </div>
                    <div class="form-group col-sm-12">
                        <label for="route_to" class="control-label col-sm-3">Route To:</label>
                        <div class="col-sm-8">
                            {!! Form::text("", $project->route_to_name, ["class"=>"form-control view-disabled","id"=> "route_to","readonly"=>"true"]) !!}                            
                        </div>
                    </div>
                    <div class="form-group col-sm-12">
                        <label for="status" class="control-label col-sm-3">Status:</label>
                        <div class="col-sm-8">
                            {!! Form::text("", ($project->status ==1 ? "enabled":"disabled"), ["class"=>"form-control view-disabled","id"=> "status","readonly"=>"true"]) !!}                              
                        </div>
                    </div>
                </div>
            </div>
            
        </form>
    </div>
    
   