<?php

namespace App\model\JobProcessingSchedule;

use Illuminate\Database\Eloquent\Model;
use App\Model\MaintenanceRequests\maintenance_request;
use App\Model\MaintenanceRequests\maintenance_request_schedule;
use Mgallegos\LaravelJqgrid\Repositories\EloquentRepositoryAbstract;
use App\Helper\Common;
use DB,Auth;
class JobProcessingScheduleDataRepository extends EloquentRepositoryAbstract
{
    public function getTotalNumberOfRows(array $filters = array()){   

        $maintenance_schedules = maintenance_request_schedule::join('maintenance_request','maintenance_request_schedule.request_id','=','maintenance_request.id')
          ->leftjoin('vehicles','maintenance_request.vehicle_id','=','vehicles.id')
          ->leftjoin('brands','vehicles.brand','=','brands.id')
          ->leftjoin('categories','vehicles.category_id','=','categories.id')
          ->select(
              'maintenance_request_schedule.id as sjp_id',
              'maintenance_request_schedule.request_id as sjp_request_id',
              'maintenance_request_schedule.date as sjp_date',
              'maintenance_request_schedule.status as sjp_status',
              'brands.name as brand_name',
              'vehicles.vehicle_no',
              'categories.name as vehicle_category'

            )
            ->where('date','<=',date('Y-m-d'))
            ->where('status','=',0);
     
         if(!empty($filters)){
             foreach($filters as $filtersRow){
                 $field 	= $filtersRow['field'];
                 $op 		= $filtersRow['op'];
                 $data 	= $filtersRow['data'];
 
                 $maintenance_schedules->where($field, $op,$data);
             }
         }
         return $maintenance_schedules->count();
    }
 
    public function getRows($limit, $offset, $orderBy = null, $sord = null, array $filters = array(),$nodeId = null, $nodeLevel = null,$exporting){
          $maintenance_schedules = maintenance_request_schedule::join('maintenance_request','maintenance_request_schedule.request_id','=','maintenance_request.id')
          ->leftjoin('vehicles','maintenance_request.vehicle_id','=','vehicles.id')
          ->leftjoin('brands','vehicles.brand','=','brands.id')
          ->leftjoin('categories','vehicles.category_id','=','categories.id')
          ->select(
              'maintenance_request_schedule.id as sjp_id',
              'maintenance_request_schedule.request_id as sjp_request_id',
              'maintenance_request_schedule.date as sjp_date',
              'maintenance_request_schedule.status as sjp_status',
              'brands.name as brand_name',
              'vehicles.vehicle_no',
              'categories.name as vehicle_category'

            )
            ->where('date','<=',date('Y-m-d'))
            ->where('status','=',0);
         
         if(!empty($filters)){
             foreach($filters as $filtersRow){
 
                 $field 	= $filtersRow['field'];
                 if($filtersRow['field'] == 'date')
                 {
                     $field 	= "maintenance_request_schedule.date";
                 }
                 elseif($filtersRow['field'] == 'vehicle_category')
                 {
                     $field 	= "categories.name";
                 }
                 elseif($filtersRow['field'] == 'brand_name')
                 {
                     $field 	= "brands.name";
                 }
                 elseif($filtersRow['field'] == 'vehicle_no')
                 {
                     $field 	= "vehicles.vehicle_no";
                 }
                

 
                 $op 	= $filtersRow['op'];
                 $data 	= $filtersRow['data'];
                 $maintenance_schedules->where($field, $op,$data);
             }
         }
             
         if(!empty($orderBy) && !empty($sord)){
             $orderBy="sjp_date";
             $sord = "ASC";
             $maintenance_schedules->orderBy($orderBy, $sord);
         }
 
         $maintenance_schedules->offset($offset);
         $maintenance_schedules->limit($limit);
         $maintenance_schedules = $maintenance_schedules->get();
         $data = array();
         if(!empty($maintenance_schedules)){
             $sno = 1;
             foreach($maintenance_schedules as $maintenance_schedule) {
                 $rolesColumn    = '';
                 $actionColumn   = "";
                 $updateBtn = "";
                 if($maintenance_schedule->sjp_status==0){
                    if(Common::userwisepermission(Auth::user()->id, "schedule job processing Perform")){
                        $actionUrl = url("workshops/schedule-job-processing/perform/".$maintenance_schedule->sjp_id);
                        $updateBtn = "<a onclick=editmaintenancerequest('".$actionUrl."','perform') class='custom-btn-action custom-btn-view  bgcolr-orange' style='margin-right:0'>Perform</a>";
                    }
                }
                
                 
 
                 $actionBtn = "<div style='display: -webkit-inline-box;'>".$updateBtn."</div>";
                 $data[] = array(
                     'action'                          =>  $actionBtn,
                     'request_id'                      =>  $maintenance_schedule->sjp_id,
                     'date'                            =>  $maintenance_schedule->sjp_date,
                     'status'                          =>  ($maintenance_schedule->sjp_status==0 ? "Pending":"Completed"),
                     'sno'                             =>  $sno,
                     'vehicle_category'                =>  $maintenance_schedule->vehicle_category,
                     'brand_name'                      =>  $maintenance_schedule->brand_name,
                     'vehicle_no'                      =>  $maintenance_schedule->vehicle_no,
 
                 );
                 $sno++;
             }
         }
         return $data;
     }
}
