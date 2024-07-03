<?php

namespace App\Model\Job;

use Illuminate\Database\Eloquent\Model;
use Mgallegos\LaravelJqgrid\Repositories\EloquentRepositoryAbstract;
use App\Model\Job\job_data;
use App\Model\Job\job_details;
use App\Helper\Common, Auth;
class jobsDataRepository extends EloquentRepositoryAbstract
{
    public function getTotalNumberOfRows(array $filters = array())
    {   
       $jobs = new job_data;

        if(!empty($filters)){
            foreach($filters as $filtersRow){

                $field 	= $filtersRow['field'];
                $op 		= $filtersRow['op'];
                $data 	= $filtersRow['data'];
                $jobs->where($field, $op,$data);
            }
        }

        
        return $jobs->count();


    }

    public function getRows($limit, $offset, $orderBy = null, $sord = null, array $filters = array(),$nodeId = null, $nodeLevel = null,$exporting)
    {
        $jobs = job_data::leftjoin('users','job_data.created_by','=','users.id')
        ->leftjoin('users as user_updated','job_data.updated_by','=','user_updated.id')
        ->leftjoin('vehicles','job_data.vehicle_id','=','vehicles.id')
        ->leftjoin('projects','job_data.project_id','=','projects.id')
        ->leftjoin('workshops','job_data.workshop_id','=','workshops.workshop_id')
        ->select(
            'job_data.id',
            'job_data.vehicle_id',
            'job_data.grand_total',
            'job_data.job_date',
            'job_data.created_at as job_created_at',
            'job_data.updated_at as job_updated_at',
            'users.name as created_by',
            'user_updated.name as updated_by',
            'vehicles.vehicle_no',
            'workshops.workshop_name',
            'workshops.workshop_location',
            'projects.name as project_name'
        );

        if(!empty($filters)){
            foreach($filters as $filtersRow){

                $field 	= $filtersRow['field'];
                if($filtersRow['field'] == 'name')
                {
                    $field 	= "workshops.workshop_name";
                }
                elseif($filtersRow['field'] == 'location')
                {
                    $field 	= "workshops.workshop_location";
                }
                elseif($filtersRow['field'] == 'vehicle')
                {
                    $field 	= "vehicles.vehicle_no";
                }
                elseif($filtersRow['field'] == 'project_name')
                {
                    $field 	= "projects.name";
                }
                $op     = $filtersRow['op'];
                $data 	= $filtersRow['data'];
                $jobs->where($field, $op,$data);
            }
        }
            
        if(!empty($orderBy) && !empty($sord)){
            $orderBy="job_data.workshop_id";
            $sord = "ASC";
            $jobs->orderBy($orderBy, $sord);
        }

        $jobs->offset($offset);

        $jobs->limit($limit);
        $jobs = $jobs->get();

        $data = array();
        if(!empty($jobs)){
            $sno = 1;

      
            foreach($jobs as $job) {
                $rolesColumn    = '';
                $actionColumn   = "";
                $actionUrl = url("workshops/job/update/".$job->id);
                $actionUrlDel = url("workshops/job/delete/".$job->id);
                $actionViewUrl = url("workshops/job/view/".$job->id);

                if(Common::userwisepermission(Auth::user()->id, "Job Update")){
                    $editBtn = "<a onclick=editmaintenancerequest('".$actionUrl."','update') class='custom-btn-action custom-btn-view  bgcolr-orange' style='margin-right:0;'>Update</a>";
                    
                }
                else{
                    $editBtn ="";
                }   
                if(Common::userwisepermission(Auth::user()->id, "Job Cancel")){
                    $deleteBtn = "<a onclick=editmaintenancerequest('".$actionUrlDel."','delete') class='custom-btn-action custom-btn-view bgcolr-aqua' style='margin-right:0;'>Cancel</a>"; 
                }
                else{
                    $deleteBtn = "";
                }
                if (Common::userwisepermission(Auth::user()->id, "Job View")) {
                    $viewBtn = "<a onclick=editmaintenancerequest('".$actionViewUrl."','view') class='custom-btn-action custom-btn-view  bgcolr-orange' style='margin-right:0;'>View</a>";
                }
                else{
                    $viewBtn = "";
                }

                $actionColumn = "<div style='display: inline-flex;'>".$editBtn.$deleteBtn.$viewBtn."</div>";       
                
                $data[] = array(
                    'action'                          =>  $actionColumn,
                    'id'                              =>  $job->id,
                    'name'                            =>  $job->workshop_name,
                    'location'                        =>  $job->workshop_location,
                    'created_at'                      =>  $job->job_created_at,
                    'updated_at'                      =>  $job->job_updated_at,
                    'created_by'                      =>  $job->created_by,
                    'updated_by'                      =>  $job->updated_by,
                    'vehicle'                         =>  $job->vehicle_no,
                    'grand_total'                     =>  $job->grand_total,
                    'job_date'                        =>  $job->job_date,
                    'project_name'                    =>  $job->project_name
                );
                $sno++;
            }
        }

        return $data;
    }
}
