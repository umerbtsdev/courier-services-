<?php

namespace App\model\Projects;

use Illuminate\Database\Eloquent\Model;
use App\Model\Projects\projects;
use Mgallegos\LaravelJqgrid\Repositories\EloquentRepositoryAbstract;
use App\Helper\Common;
use Auth, DB;
class ProjectsDataRepository extends EloquentRepositoryAbstract
{
    public function getTotalNumberOfRows(array $filters = array()){   

        $projects = projects::leftjoin('users','projects.created_by','=','users.id')
        ->leftjoin('users as user_updated','projects.updated_by','=','user_updated.id')
        ->leftjoin('routes','projects.route_from_id','=','routes.id')
        ->leftjoin('routes as routeTo','projects.route_to_id','=','routeTo.id')
        ->select(
            'projects.id as p_id',
            'projects.name as project_name',
            'projects.status',
            'projects.created_at as project_created_at',
            'projects.updated_at as project_updated_at',
            'users.name as created_by',
            'user_updated.name as updated_by',
            'routes.name as route_from_name',
            'routeTo.name as route_to_name'

        );
     
         if(!empty($filters)){
             foreach($filters as $filtersRow){
                 $field 	= $filtersRow['field'];
                 if($filtersRow['field'] == 'p_id')
                 {
                     $field 	= "projects.id";
                 }
                 elseif($filtersRow['field'] == 'project_name')
                 {
                     $field 	= "projects.name";
                 }
                 elseif($filtersRow['field'] == 'route_from_name')
                 {
                     $field 	= "routes.name";
                 }
                 elseif($filtersRow['field'] == 'route_to_name')
                 {
                     $field 	= "routeTo.name";
                 }
                 $op 		= $filtersRow['op'];
                 $data 	= $filtersRow['data'];
 
                 $projects->where($field, $op,$data);
             }
         }
         return $projects->count();
    }
 
    public function getRows($limit, $offset, $orderBy = null, $sord = null, array $filters = array(),$nodeId = null, $nodeLevel = null,$exporting){
          $projects = projects::leftjoin('users','projects.created_by','=','users.id')
         ->leftjoin('users as user_updated','projects.updated_by','=','user_updated.id')
         ->leftjoin('routes','projects.route_from_id','=','routes.id')
         ->leftjoin('routes as routeTo','projects.route_to_id','=','routeTo.id')
         ->select(
             'projects.id as p_id',
             'projects.name as project_name',
             'projects.status',
             'projects.created_at as project_created_at',
             'projects.updated_at as project_updated_at',
             'users.name as created_by',
             'user_updated.name as updated_by',
             'routes.name as route_from_name',
             'routeTo.name as route_to_name'
 
         );
 
         if(!empty($filters)){
             foreach($filters as $filtersRow){
 
                 $field 	= $filtersRow['field'];
                 if($filtersRow['field'] == 'p_id')
                 {
                     $field 	= "projects.id";
                 }
                 elseif($filtersRow['field'] == 'project_name')
                 {
                     $field 	= "projects.name";
                 }
                 elseif($filtersRow['field'] == 'route_from_name')
                 {
                     $field 	= "routes.name";
                 }
                 elseif($filtersRow['field'] == 'route_to_name')
                 {
                     $field 	= "routeTo.name";
                 }
                 
                 $op 	= $filtersRow['op'];
                 $data 	= $filtersRow['data'];
                 $projects->where($field, $op,$data);
             }
         }
             
         if(!empty($orderBy) && !empty($sord)){
             $orderBy="p_id";
             $sord = "ASC";
             $projects->orderBy($orderBy, $sord);
         }
 
         $projects->offset($offset);
         $projects->limit($limit);
         $projects = $projects->get();
         $data = array();
         if(!empty($projects)){
             $sno = 1;
             foreach($projects as $project) {
                 $rolesColumn    = '';
                 $actionBtn   = "";
                 
                 
                 if(Common::userwisepermission(Auth::user()->id, "Projects Update")){
                     $actionUrl = url("project-management/projects/edit/".$project->p_id);
                     $updateBtn = "<a onclick=editmaintenancerequest('".$actionUrl."','update') class='custom-btn-action custom-btn-view  bgcolr-orange' style='margin-right:0'>Update</a>";
                 }
                 else{ $updateBtn = "";}
                 if(Common::userwisepermission(Auth::user()->id, "Projects Cancel")){
                     $actionUrlDel = url("project-management/projects/delete/".$project->p_id);
                     $removeBtn = "<a onclick=editmaintenancerequest('".$actionUrlDel."','delete') class='custom-btn-action custom-btn-view bgcolr-aqua' style='margin-right:0'>Cancel</a>";
                 }
                 else{ $removeBtn ="";}
                 if (Common::userwisepermission(Auth::user()->id, "Projects Details Read")) {
                     $actionUrlView = url("project-management/projects/view/".$project->p_id);
                     $viewBtn="<a onclick=editmaintenancerequest('".$actionUrlView."','view') class='custom-btn-action custom-btn-view bgcolr-orange'>View</a>";
                 }
                 else{ $viewBtn=""; }
 
                 $actionBtn = "<div style='display: -webkit-inline-box;'>".$updateBtn.$removeBtn.$viewBtn."</div>";
                 $data[] = array(
                     'action'                          =>  $actionBtn,
                     'p_id'                            =>  $project->p_id,
                     'project_name'                    =>  $project->project_name,
                     'status'                          =>  ($project->status==1 ? "enabled":"disabled"),
                     'created_at'                      =>  $project->project_created_at,
                     'updated_at'                      =>  $project->project_updated_at,
                     'created_by'                      =>  $project->created_by,
                     'updated_by'                      =>  $project->updated_by,
                     'route_from_name'                 =>  $project->route_from_name,
                     'route_to_name'                   =>  $project->route_to_name
 
                 );
                 $sno++;
             }
         }
         return $data;
     }
}
