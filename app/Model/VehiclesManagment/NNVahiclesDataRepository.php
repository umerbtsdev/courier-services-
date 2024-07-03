<?php
namespace App\Model\VahiclesManagment;

use App\Vahicles;
use Illuminate\Database\Eloquent\Model;
use Mgallegos\LaravelJqgrid\Repositories\EloquentRepositoryAbstract;
use DB,Auth;

class VahiclesDataRepository extends EloquentRepositoryAbstract {

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
     $vehicles = Vehicles::select(
    'vehicles.driver as DriverName',
    'vehicles.brand as BrandName',
    'vehicles.category_id as Category',
    'vehicle_no', 
    'start_date',
    'end_date',
    'warranty',
    'vehicles.description',
    'owner'
    )
    ->leftjoin('drivers', 'drivers.id', '=', 'vehicles.driver')
    ->leftjoin('brands', 'brands.id', '=', 'vehicles.brand')
    ->leftjoin('categories', 'categories.id', '=', 'vehicles.category_id');



        if(!empty($filters)){
            foreach($filters as $filtersRow){

                $field 	= $filtersRow['field'];
                $op 		= $filtersRow['op'];
                $data 	= $filtersRow['data'];

                $vehicles->where($field, $op,$data);
            }
        }

        return $vehicles->count();

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
       
 $Vehicles = Vehicles::select(
    'vehicles.driver as DriverName',
    'vehicles.brand as BrandName',
    'vehicles.category_id as Category',
    'vehicle_no', 
    'start_date',
    'end_date',
    'warranty',
    'vehicles.description',
    'owner'
    )
    ->leftjoin('drivers', 'drivers.id', '=', 'vehicles.driver')
    ->leftjoin('brands', 'brands.id', '=', 'vehicles.brand')
    ->leftjoin('categories', 'categories.id', '=', 'vehicles.category_id')
    ->get();





        if(!empty($filters)){
            foreach($filters as $filtersRow){

                $field 	= $filtersRow['field'];
                $op 		= $filtersRow['op'];
                $data 	= $filtersRow['data'];

                $Vehicles->where($field, $op,$data);
            }
        }

        if(!empty($orderBy) && !empty($sord)){
            $Vehicles->orderBy($orderBy, $sord);
        }

        $Vehicles->offset($offset);

        $Vehicles->limit($limit);
        $Vehicles = $Vehicles->get();

        $data = array();
        if(!empty($Vehicles)){
            $sno = 1;

            foreach($Vehicles as $vch) {
                $rolesColumn    = '';
                $actionColumn   = "";
                $actionUrl = url("vehicles/edit/".$vch->id);
                $actionUrlDel = url("vehicles/delete/".$vch->id);
               
     $actionColumn = "<a onclick=editmaintenancerequest('".$actionUrl."') class='custom-btn-action custom-btn-view  bgcolr-aqua'>Update</a><a onclick=editmaintenancerequest('".$actionUrlDel."') class='custom-btn-action custom-btn-view bgcolr-orange'>Cancel</a>";
                $data[] = array(

                    'action'                  =>  $actionColumn,
                    'id'                      =>  $vch->id,
                    'vehicle_no'              =>  $vch->vehicle_no,
                    'start_date'              =>  $vch->start_date,
                    'end_date'                 =>  $vch->end_date,
                    'warranty'                 =>  $vch->warranty,
                    'description'               =>  $vch->description,
                    'DriverName'                 =>  $vch->DriverName,
                    'owner'                        => $vch->owner,
                    'BrandName'                  =>  $vch->BrandName,
                    'Category'                    =>  $vch->Category

                );
                $sno++;
            }
        }

        return $data;
    }
}