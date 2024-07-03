<?php
namespace App\Model\CostCenterManagment;

use App\Model\CostCenterManagment\CostCenter;
use Illuminate\Database\Eloquent\Model;
use Mgallegos\LaravelJqgrid\Repositories\EloquentRepositoryAbstract;
use DB,Auth;
use App\Helper\Common;

class CostCenterDataRepository extends EloquentRepositoryAbstract {



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
        $costcenter = CostCenter::select('name');

        if(!empty($filters)){
            foreach($filters as $filtersRow){

                $field 	= $filtersRow['field'];
                $op 		= $filtersRow['op'];
                $data 	= $filtersRow['data'];

                $costcenter->where($field, $op,$data);
            }
        }

        return $costcenter->count();

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
        $costcenter = CostCenter::select('id','name','address');


        if(!empty($filters)){
            foreach($filters as $filtersRow){

                $field 	= $filtersRow['field'];
                $op 		= $filtersRow['op'];
                $data 	= $filtersRow['data'];

                $costcenter->where($field, $op,$data);
            }
        }

        if(!empty($orderBy) && !empty($sord)){
            $costcenter->orderBy($orderBy, $sord);
        }

        $costcenter->offset($offset);

        $costcenter->limit($limit);
        $customer = $costcenter->get();

        $data = array();
        if(!empty($customer)){
            $sno = 1;

            foreach($customer as $cus) {
                $rolesColumn    = '';
                $actionColumn   = "";
                $actionUrl = url("setup/costcenter/edit/".$cus->id);
                $actionUrlDel = url("setup/costcenter/delete/".$cus->id);
               
                if(Common::userwisepermission(Auth::user()->id, "Cost Center Update")){
                    $EditBtn = "<a onclick=editmaintenancerequest('".$actionUrl."') class='btn-cus-dessign btn btn-primary waves-effect waves-light'>Update</a> ";
                }
                else{
                    $EditBtn = "";
                }
                if(Common::userwisepermission(Auth::user()->id, "Cost Center Cancel")){
                    $DeleteBtn = "<a onclick=editmaintenancerequest('".$actionUrlDel."') class='btn-cus-dessign btn btn-primary waves-effect waves-light'>Cancel</a>";
                }
                else{
                    $DeleteBtn = "";
                }
     
                $data[] = array(
                    'id'		    =>	$cus->id,
                    'name'			=>	$cus->name,
                    'address'		=>	$cus->address,
                    'action'        =>  $EditBtn.$DeleteBtn
                );
                $sno++;
            }
        }

        return $data;
    }
}