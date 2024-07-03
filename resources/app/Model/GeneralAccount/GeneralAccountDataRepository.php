<?php
namespace App\Model\GeneralAccount;

use App\Model\GeneralAccount\Genernalaccount;
use Illuminate\Database\Eloquent\Model;
use Mgallegos\LaravelJqgrid\Repositories\EloquentRepositoryAbstract;
use DB,Auth;
use App\Helper\Common;

class GeneralAccountDataRepository extends EloquentRepositoryAbstract {



    /**
     * Calculate the number of rows. It's used for paging the result.
     *
     * @param    array $filters
     *  An array of filters, example: array(array('field'=>'column index/name 1','op'=>'operator','data'=>'searched string column 1'), array('field'=>'column index/name 2','op'=>'operator','data'=>'searched string column 2'))
     *  The 'field' key will contain the 'index' column property if is set, otherwise the 'name' column property.
     *  The 'op' key will contain one of the following operators: '=', '<', '>', '<=', '>=', '<>', '!=','like', 'not like', 'is in', 'is not in'.
     *  when the 'operator' is 'like' the 'data' already contains the '%' character in the appropiate position.
     *  The 'data' key will contain the string searched by the user.
     * @return  integer
     *  Total number of rows
     */

    public function getTotalNumberOfRows(array $filters = array())
    {
        $Alert = Generalaccount::select('id','name','type');

        if(!empty($filters)){
            foreach($filters as $filtersRow){

                $field 	= $filtersRow['field'];
                $op 		= $filtersRow['op'];
                $data 	= $filtersRow['data'];

                $Alert->where($field, $op,$data);
            }
        }

        return $Alert->count();

    }

    /**
     * Get the rows data to be shown in the grid.
     *
     * @param    integer $limit
     *  Number of rows to be shown into the grid
     * @param    integer $offset
     *  Start position
     * @param    string $orderBy
     *  Column name to order by.
     * @param    array $sord
     *  Sorting order
     * @param    array $filters
     *  An array of filters, example: array(array('field'=>'column index/name 1','op'=>'operator','data'=>'searched string column 1'), array('field'=>'column index/name 2','op'=>'operator','data'=>'searched string column 2'))
     *  The 'field' key will contain the 'index' column property if is set, otherwise the 'name' column property.
     *  The 'op' key will contain one of the following operators: '=', '<', '>', '<=', '>=', '<>', '!=','like', 'not like', 'is in', 'is not in'.
     *  when the 'operator' is 'like' the 'data' already contains the '%' character in the appropiate position.
     *  The 'data' key will contain the string searched by the user.
     * @return  array
     *  An array of array, each array will have the data of a row.
     *  Example: array(array("column1" => "1-1", "column2" => "1-2"), array("column1" => "2-1", "column2" => "2-2"))
     */
    public function getRows($limit, $offset, $orderBy = null, $sord = null, array $filters = array(),$nodeId = null, $nodeLevel = null,$exporting)
    {
        $Alert = Generalaccount::select('id','name','type');


        if(!empty($filters)){
            foreach($filters as $filtersRow){

                $field 	= $filtersRow['field'];
                $op 		= $filtersRow['op'];
                $data 	= $filtersRow['data'];

                $Alert->where($field, $op,$data);
            }
        }

        if(!empty($orderBy) && !empty($sord)){
            $Alert->orderBy($orderBy, $sord);
        }

        $Alert->offset($offset);

        $Alert->limit($limit);
        $Alert = $Alert->get();

        $data = array();
        if(!empty($Alert)){
            $sno = 1;

            foreach($Alert as $user) {
                $rolesColumn    = '';
                $actionColumn   = "";
                $actionUrl = url("generalaccount/edit/".$user->id);
                $actionUrlDel = url("generalaccount/delete/".$user->id);
               
                if(Common::userwisepermission(Auth::user()->id, "Account Update")){
                    $updateBtn = "<a onclick=editmaintenancerequest('".$actionUrl."') class='custom-btn-action custom-btn-view  bgcolr-aqua'>Update</a>";
                }
                else{
                    $updateBtn = "";
                }


                if(Common::userwisepermission(Auth::user()->id, "Account Cancel")){
                    $deleteBtn = "<a onclick=editmaintenancerequest('".$actionUrlDel."') class='custom-btn-action custom-btn-view bgcolr-orange'>Cancel</a>";
                }
                else{
                    $deleteBtn = "";
                }
     
                $data[] = array(
                    'id'					=>	$user->id,
                    'name'					=>	$user->name,
                    'type'                  =>  $user->type,
                    'action'                =>  $updateBtn.$deleteBtn
                );
                $sno++;
            }
        }

        return $data;
    }
}