<?php

namespace App\Model\Services;

use Illuminate\Database\Eloquent\Model;
use Mgallegos\LaravelJqgrid\Repositories\EloquentRepositoryAbstract;
use App\Model\Services\services;
use DB, Auth;
use App\Helper\Common;
class servicesDataRepository extends EloquentRepositoryAbstract
{
    public function getTotalNumberOfRows(array $filters = array())
    {   
        $services = services::leftjoin('users','services.created_by','=','users.id')
        ->leftjoin('users as user_updated','services.updated_by','=','user_updated.id')
        ->select(
            'services.id as services_id',
            'services.service_name',
            'services.created_at as services_created_at',
            'services.updated_at as services_updated_at',
            'users.name as created_by',
            'user_updated.name as updated_by'
        );

        if(!empty($filters)){
            foreach($filters as $filtersRow){

                $field 	= $filtersRow['field'];
                $op 		= $filtersRow['op'];
                $data 	= $filtersRow['data'];

                $services->where($field, $op,$data);
            }
        }
        return $services->count();
    }
    public function getRows($limit, $offset, $orderBy = null, $sord = null, array $filters = array(),$nodeId = null, $nodeLevel = null,$exporting)
    {
        $services = services::leftjoin('users','services.created_by','=','users.id')
       ->leftjoin('users as user_updated','services.updated_by','=','user_updated.id')
       ->select(
           'services.id as services_id',
           'services.service_name',
           'services.created_at as services_created_at',
           'services.updated_at as services_updated_at',
           'users.name as created_by',
           'user_updated.name as updated_by'
       );


        if(!empty($filters)){
            foreach($filters as $filtersRow){
                $field 	= $filtersRow['field'];
                $op 		= $filtersRow['op'];
                $data 	= $filtersRow['data'];

                $services->where($field, $op,$data);
            }
        }
            
        if(!empty($orderBy) && !empty($sord)){
          //  $orderBy="services.id";
          //  $sord = "ASC";
            $services->orderBy($orderBy, $sord);
        }

        $services->offset($offset);

        $services->limit($limit);
        $services = $services->get();

        $data = array();
        if(!empty($services)){
            $sno = 1;

      
            foreach($services as $service) {
                
                $rolesColumn    = '';
                $actionColumn   = "";
                $actionUrl = url("setup/workshops/service/update/".$service->services_id);
                $actionUrlDel = url("setup/workshops/service/delete/".$service->services_id);
                
              //  if(Common::userwisepermission(Auth::user()->id, "Services Update")){
                    $EditBtn = "<a onclick=editmaintenancerequest('".$actionUrl."','update') class='btn-cus-dessign btn btn-primary waves-effect waves-light'>Update</a> ";
              //  }
              //  else{
              //      $EditBtn = "";
              //  }
            //    if(Common::userwisepermission(Auth::user()->id, "Services Cancel")){
                    $DeleteBtn = "<a onclick=editmaintenancerequest('".$actionUrlDel."','delete') class='btn-cus-dessign btn btn-primary waves-effect waves-light'>Cancel</a>";
              //  }
              //  else{
              //      $DeleteBtn = "";
              //  }
                $actionColumn = "";       
                
                $data[] = array(
                    'action'                          =>  $EditBtn. $DeleteBtn,
                    'id'                              =>  $service->services_id,
                    'name'                            =>  $service->service_name,
                    'created_at'                      =>  $service->services_created_at,
                    'updated_at'                      =>  $service->services_updated_at,
                    'created_by'                      =>  $service->created_by,
                    'updated_by'                      =>  $service->updated_by,

                );
                $sno++;
            }
        }

        return $data;
    }
}
