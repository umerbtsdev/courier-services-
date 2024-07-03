<?php
namespace App\Model\DriversManagment;

use App\Model\DriversManagment\Driver;
use Illuminate\Database\Eloquent\Model;
use Mgallegos\LaravelJqgrid\Repositories\EloquentRepositoryAbstract;
use DB,Auth;
use App\Helper\Common;

class DriversDataRepository extends EloquentRepositoryAbstract {

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

       // $Drivers = Driver::select('id','name', 'emp_code', 'address', 'hiring_date','date_of_brith', 'license', 'expriy_on', 'city', 'phone_no', 'cell_no','ntn_no', 'designation', 'salary_package');



    $Drivers = Driver::select(
        'drivers.Id as driverID',
        'drivers.Name as name',
        'city.name as CityName',
        'drivers.emp_code', 'address', 
        'hiring_date',
        'date_of_brith', 
        'license', 
        'expriy_on', 
        'phone_no', 
        'cell_no',
        'ntn_no', 
        'designation', 
        'salary_package'
    )
    ->leftjoin('city', 'city.id', '=', 'drivers.city');
    
    


    

        if(!empty($filters)){
            foreach($filters as $filtersRow){

                $field 	= $filtersRow['field'];
                $op 		= $filtersRow['op'];
                $data 	= $filtersRow['data'];

                $Drivers->where($field, $op,$data);
            }
        }

        return $Drivers->count();


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
         
         // $Drivers = Driver::select('id','name', 'emp_code', 'address', 'hiring_date','date_of_brith', 'license', 'expriy_on', 'city', 'phone_no', 'cell_no','ntn_no', 'designation', 'salary_package');
    
         $Drivers = Driver::select(
        'drivers.Id as driverID',
        'drivers.Name as name',
        'city.name as CityName',
        'drivers.emp_code', 'address', 
        'hiring_date',
        'date_of_brith', 
        'license', 
        'expriy_on', 
        'phone_no', 
        'cell_no',
        'ntn_no', 
        'designation', 
        'salary_package'
    )
    ->leftjoin('city', 'city.id', '=', 'drivers.city');


        if(!empty($filters)){
            foreach($filters as $filtersRow){

                $field 	= $filtersRow['field'];
                $op 		= $filtersRow['op'];
                $data 	= $filtersRow['data'];

                $Drivers->where($field, $op,$data);
            }
        }
            
        if(!empty($orderBy) && !empty($sord)){
            $orderBy="driverID";
            $sord = "ASC";
            $Drivers->orderBy($orderBy, $sord);
        }

        $Drivers->offset($offset);

        $Drivers->limit($limit);
        $Drivers = $Drivers->get();

        $data = array();
        if(!empty($Drivers)){
            $sno = 1;

      
            foreach($Drivers as $driver) {
                $rolesColumn    = '';
                $actionColumn   = "";
                $actionUrl = url("driver/edit/".$driver->driverID);
                $actionUrlDel = url("driver/delete/".$driver->driverID);
               
                if(Common::userwisepermission(Auth::user()->id, "Drivers Update")){
                    $editBtn = "<a onclick=editmaintenancerequest('".$actionUrl."') class='custom-btn-action custom-btn-view  bgcolr-aqua'>Update</a>";
                }
                else{
                    $editBtn = "";
                }
                if(Common::userwisepermission(Auth::user()->id, "Drivers Cancel")){
                    $DeleteBtn = "<a onclick=editmaintenancerequest('".$actionUrlDel."') class='custom-btn-action custom-btn-view bgcolr-orange'>Cancel</a>";       
                }
                else{
                    $DeleteBtn = "";
                }
                $data[] = array(
                    'action'                  =>  $editBtn.$DeleteBtn,
                    'id'                      =>  $driver->driverID,
                    'name'                    =>  $driver->name,
                    'empcode'                 =>  $driver->emp_code,
                    'address'                 =>  $driver->address,
                    'hiring_date'             =>  $driver->hiring_date,
                    'date_of_brith'           =>  $driver->date_of_brith,
                    'license'                 =>  $driver->license,
                    'expriy_on'               =>  $driver->expriy_on,
                    'city'                    =>  $driver->CityName,
                    'phone_no'                =>  $driver->phone_no,
                    'cell_no'                 =>  $driver->cell_no,
                    'ntn_no'                  =>  $driver->ntn_no,
                    'designation'             =>  $driver->designation,
                    'salary_package'          =>  $driver->salary_package
    );
                $sno++;
            }
        }

        return $data;
    }
}