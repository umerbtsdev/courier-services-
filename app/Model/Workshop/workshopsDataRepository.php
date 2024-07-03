<?php

namespace App\Model\Workshop;

use Illuminate\Database\Eloquent\Model;
use Mgallegos\LaravelJqgrid\Repositories\EloquentRepositoryAbstract;
use App\Model\Workshop\workshops;

class workshopsDataRepository extends EloquentRepositoryAbstract
{
    public function getTotalNumberOfRows(array $filters = array())
    {   
       $workshops = workshops::leftjoin('users','workshops.created_by','=','users.id')
       ->leftjoin('users as user_updated','workshops.updated_by','=','user_updated.id')
       ->select(
           'workshops.workshop_id',
           'workshops.workshop_name',
           'workshops.workshop_location',
           'workshops.created_at as workshops_created_at',
           'workshops.updated_at as workshops_updated_at',
           'users.name as created_by',
           'user_updated.name as updated_by'
       );

        if(!empty($filters)){
            foreach($filters as $filtersRow){

                $field 	= $filtersRow['field'];
                $op 		= $filtersRow['op'];
                $data 	= $filtersRow['data'];

                $workshops->where($field, $op,$data);
            }
        }

        return $workshops->count();


    }

    public function getRows($limit, $offset, $orderBy = null, $sord = null, array $filters = array(),$nodeId = null, $nodeLevel = null,$exporting)
    {
         $workshops = workshops::leftjoin('users','workshops.created_by','=','users.id')
         ->leftjoin('users as user_updated','workshops.updated_by','=','user_updated.id')
         ->select(
             'workshops.workshop_id',
             'workshops.workshop_name',
             'workshops.workshop_location',
             'workshops.created_at as workshop_created_at',
             'workshops.updated_at as workshop_updated_at',
             'users.name as created_by',
             'user_updated.name as updated_by'
         );

        if(!empty($filters)){
            foreach($filters as $filtersRow){

                $field 	= $filtersRow['field'];
                $op 		= $filtersRow['op'];
                $data 	= $filtersRow['data'];

                $workshops->where($field, $op,$data);
            }
        }
            
        if(!empty($orderBy) && !empty($sord)){
            $orderBy="workshop_id";
            $sord = "ASC";
            $workshops->orderBy($orderBy, $sord);
        }

        $workshops->offset($offset);

        $workshops->limit($limit);
        $workshops = $workshops->get();

        $data = array();
        if(!empty($workshops)){
            $sno = 1;

      
            foreach($workshops as $workshop) {
                $rolesColumn    = '';
                $actionColumn   = "";
                $actionUrl = url("workshops/setup/update/".$workshop->workshop_id);
                $actionUrlDel = url("workshops/setup/delete/".$workshop->workshop_id);
               
                $actionColumn = "<a onclick=editmaintenancerequest('".$actionUrl."','update') class='custom-btn-action custom-btn-view  bgcolr-orange'><i class='fa fa-fw fa-pencil'></i></a><a onclick=editmaintenancerequest('".$actionUrlDel."','delete') class='custom-btn-action custom-btn-view bgcolr-aqua'><i class='fa fa-fw fa-trash'></i></a>";       
                
                $data[] = array(
                    'action'                          =>  $actionColumn,
                    'id'                              =>  $workshop->workshop_id,
                    'name'                            =>  $workshop->workshop_name,
                    'location'                            =>  $workshop->workshop_location,
                    'created_at'                      =>  $workshop->workshop_created_at,
                    'updated_at'                      =>  $workshop->workshop_updated_at,
                    'created_by'                      =>  $workshop->created_by,
                    'updated_by'                      =>  $workshop->updated_by,

                );
                $sno++;
            }
        }

        return $data;
    }
}
