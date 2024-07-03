<?php

namespace App\Model\Parts;
use App\Model\Parts\parts;
use Illuminate\Database\Eloquent\Model;
use Mgallegos\LaravelJqgrid\Repositories\EloquentRepositoryAbstract;
use DB, Auth;
use App\Helper\Common;
class partsDataRepository extends EloquentRepositoryAbstract
{
    public function getTotalNumberOfRows(array $filters = array())
    {   
       $parts = parts::join('manufacturers','parts.manufacturer_id','=','manufacturers.id')
       ->join('users','parts.created_by','=','users.id')
       ->leftjoin('users as user_updated','parts.updated_by','=','user_updated.id')

       ->select(
           'parts.part_id ',
           'parts.part_name',
           'parts.created_at as parts_created_at',
           'parts.updated_at as parts_updated_at',
           'users.name as created_by',
           'user_updated.name as updated_by',
           'manufacturers.name'
       );

        if(!empty($filters)){
            foreach($filters as $filtersRow){

                $field 	= $filtersRow['field'];
                $op 		= $filtersRow['op'];
                $data 	= $filtersRow['data'];

                $parts->where($field, $op,$data);
            }
        }

        return $parts->count();
    }

    public function getRows($limit, $offset, $orderBy = null, $sord = null, array $filters = array(),$nodeId = null, $nodeLevel = null,$exporting)
    {
         $parts = parts::join('manufacturers','parts.manufacturer_id','=','manufacturers.id')
         ->join('users','parts.created_by','=','users.id')
         ->leftjoin('users as user_updated','parts.updated_by','=','user_updated.id')
  
         ->select(
             'parts.part_id',
             'parts.part_name',
             'parts.created_at as parts_created_at',
             'parts.updated_at as parts_updated_at',
             'users.name as created_by',
             'user_updated.name as updated_by',
             'manufacturers.name as manufacturers_name'
         );


        if(!empty($filters)){
            foreach($filters as $filtersRow){

                $field 	= $filtersRow['field'];
                $op 		= $filtersRow['op'];
                $data 	= $filtersRow['data'];

                $parts->where($field, $op,$data);
            }
        }
            
        if(!empty($orderBy) && !empty($sord)){

            $parts->orderBy($orderBy, $sord);
        }

        $parts->offset($offset);

        $parts->limit($limit);
        $parts = $parts->get();

        $data = array();
        if(!empty($parts)){
            $sno = 1;

            foreach($parts as $part) {
               
                $rolesColumn    = '';
                $actionColumn   = "";
                $actionUrl = url("workshops/parts/update/".$part->part_id);
                $actionUrlDel = url("workshops/parts/delete/".$part->part_id);
                if(Common::userwisepermission(Auth::user()->id, "Parts Update")){
                    $EditBtn = "<a onclick=editmaintenancerequest('".$actionUrl."','update') class='custom-btn-action custom-btn-view  bgcolr-orange'>Update</a>";
                }
                else{
                    $EditBtn = "";
                }
                if(Common::userwisepermission(Auth::user()->id, "Parts Cancel")){
                    $DeleteBtn = "<a onclick=editmaintenancerequest('".$actionUrlDel."','delete') class='custom-btn-action custom-btn-view bgcolr-aqua'>Cancel</a>";
                }
                else{
                    $DeleteBtn ="";
                }
                
                
                $data[] = array(
                    'action'                          =>  $EditBtn. $DeleteBtn,
                    'id'                              =>  $part->part_id,
                    'name'                            =>  $part->part_name,
                    'manufacturers_name'              =>  $part->manufacturers_name,
                    'created_at'                      =>  $part->parts_created_at,
                    'updated_at'                      =>  $part->parts_updated_at,
                    'created_by'                      =>  $part->created_by,
                    'updated_by'                      =>  $part->updated_by,

                );
                $sno++;
            }
        }

        return $data;
    }
}
