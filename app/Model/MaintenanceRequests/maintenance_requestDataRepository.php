<?php

namespace App\Model\MaintenanceRequests;

use Illuminate\Database\Eloquent\Model;
use Mgallegos\LaravelJqgrid\Repositories\EloquentRepositoryAbstract;
use App\Model\MaintenanceRequests\maintenance_request;
use Auth;
use App\Helper\Common;
class maintenance_requestDataRepository extends EloquentRepositoryAbstract
{
    public function getTotalNumberOfRows(array $filters = array()){   

       $maintenance_requests = maintenance_request::select('request_id');
    
        if(!empty($filters)){
            foreach($filters as $filtersRow){
                $field 	= $filtersRow['field'];
                $op 		= $filtersRow['op'];
                $data 	= $filtersRow['data'];

                $maintenance_requests->where($field, $op,$data);
            }
        }
        return $maintenance_requests->count();
    }

    public function getRows($limit, $offset, $orderBy = null, $sord = null, array $filters = array(),$nodeId = null, $nodeLevel = null,$exporting){
         $maintenance_requests = maintenance_request::leftjoin('users','maintenance_request.created_by','=','users.id')
        ->leftjoin('users as user_updated','maintenance_request.updated_by','=','user_updated.id')
        ->leftjoin('vehicles','maintenance_request.vehicle_id','=','vehicles.id')
        ->select(
            'maintenance_request.id as request_id',
            'vehicles.vehicle_no',
            'maintenance_request.from_date',
            'maintenance_request.to_date',
            'maintenance_request.days_delay',
            'maintenance_request.created_at as maintenance_request_created_at',
            'maintenance_request.updated_at as maintenance_request_updated_at',
            'users.name as created_by',
            'user_updated.name as updated_by'

        );

        if(!empty($filters)){
            foreach($filters as $filtersRow){

                $field 	= $filtersRow['field'];
                if($filtersRow['field'] == 'vehicle_no')
                {
                    $field 	= "maintenance_request.vehicle_no";
                }
                elseif($filtersRow['field'] == 'request_id')
                {
                    $field 	= "maintenance_request.request_id";
                }
                elseif($filtersRow['field'] == 'from_date')
                {
                    $field 	= "maintenance_request.from_date";
                }
                elseif($filtersRow['field'] == 'to_date')
                {
                    $field 	= "maintenance_request.to_date";
                }
                elseif($filtersRow['field'] == 'days_delay')
                {
                    $field 	= "maintenance_request.days_delay";
                }
                $op 	= $filtersRow['op'];
                $data 	= $filtersRow['data'];
                $maintenance_requests->where($field, $op,$data);
            }
        }
            
        if(!empty($orderBy) && !empty($sord)){
            $orderBy="request_id";
            $sord = "ASC";
            $maintenance_requests->orderBy($orderBy, $sord);
        }

        $maintenance_requests->offset($offset);
        $maintenance_requests->limit($limit);
        $maintenance_requests = $maintenance_requests->get();
        $data = array();
        if(!empty($maintenance_requests)){
            $sno = 1;
            foreach($maintenance_requests as $maintenance_request) {
                $rolesColumn    = '';
                $actionColumn   = "";
                
                
                if(Common::userwisepermission(Auth::user()->id, "maintenance schedule Update")){
                    $actionUrl = url("workshops/maintenance-schedule/update/".$maintenance_request->request_id);
                    $updateBtn = "<a onclick=editmaintenancerequest('".$actionUrl."','update') class='custom-btn-action custom-btn-view  bgcolr-orange' style='margin-right:0'>Update</a>";
                }
                else{ $updateBtn = "";}
                if(Common::userwisepermission(Auth::user()->id, "maintenance schedule Cancel")){
                    $actionUrlDel = url("workshops/maintenance-schedule/remove/".$maintenance_request->request_id);
                    $removeBtn = "<a onclick=editmaintenancerequest('".$actionUrlDel."','delete') class='custom-btn-action custom-btn-view bgcolr-aqua' style='margin-right:0'>Cancel</a>";
                }
                else{ $removeBtn ="";}
                if (Common::userwisepermission(Auth::user()->id, "maintenance schedule View Details")) {
                    $actionUrlView = url("workshops/maintenance-schedule/view/".$maintenance_request->request_id);
                    $viewBtn="<a onclick=editmaintenancerequest('".$actionUrlView."','view') class='custom-btn-action custom-btn-view bgcolr-orange'>View</a>";
                }
                else{ $viewBtn=""; }

                $actionBtn = "<div style='display: -webkit-inline-box;'>".$updateBtn.$removeBtn.$viewBtn."</div>";
                $data[] = array(
                    'action'                          =>  $actionBtn,
                    'request_id'                      =>  $maintenance_request->request_id,
                    'vehicle_no'                      =>  $maintenance_request->vehicle_no,
                    'from_date'                       =>  $maintenance_request->from_date,
                    'to_date'                         =>  $maintenance_request->to_date,
                    'days_delay'                      =>  $maintenance_request->days_delay,
                    'created_at'                      =>  $maintenance_request->maintenance_request_created_at,
                    'updated_at'                      =>  $maintenance_request->maintenance_request_updated_at,
                    'created_by'                      =>  $maintenance_request->created_by,
                    'updated_by'                      =>  $maintenance_request->updated_by,

                );
                $sno++;
            }
        }
        return $data;
    }
}
