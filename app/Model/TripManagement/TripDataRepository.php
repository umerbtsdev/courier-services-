<?php
namespace App\Model\TripManagement;

use App\Model\DriversManagment\Driver;
use Illuminate\Database\Eloquent\Model;
use Mgallegos\LaravelJqgrid\Repositories\EloquentRepositoryAbstract;
use DB,Auth;
use App\Helper\Common;
class TripDataRepository extends EloquentRepositoryAbstract {

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



    $trips = Tripdata::select(
        'trip.Id',
        'trip.vehicle_id',
        'trip.trip_date',
        'trip.created_at',
        'trip.updated_at'
    );
        if(!empty($filters)){
            foreach($filters as $filtersRow){

                $field 	= $filtersRow['field'];
                $op 		= $filtersRow['op'];
                $data 	= $filtersRow['data'];

                $trips->where($field, $op,$data);
            }
        }

        return $trips->count();


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

        $trips = Tripdata::leftjoin('vehicles','trip.vehicle_id', '=', 'vehicles.id')
            ->leftjoin('customer', 'trip.client', '=', 'customer.id')
            ->leftjoin('cost_center', 'trip.cost_center', '=', 'cost_center.id')
            ->select('trip.id','trip.vehicle_id','vehicles.vehicle_no','cost_center.name as cost_center_name', 'trip.trip_date','trip.cost_center', 'vehicles.owner',
                'customer.name as customer_name', 'trip.reading_start','trip.created_by','trip.created_at','trip.is_locked'  );

        if(!empty($filters)){
            foreach($filters as $filtersRow){

                $field 	= $filtersRow['field'];
                $op 		= $filtersRow['op'];
                $data 	= $filtersRow['data'];

                $trips->where($field, $op,$data);
            }
        }
            
        if(!empty($orderBy) && !empty($sord)){
            $trips->orderBy($orderBy, $sord);
        }

        $trips->offset($offset);

        $trips->limit($limit);
        $tripsdata = $trips->get();

        $data = array();
        if(!empty($tripsdata)){
            $sno = 1;

            foreach($tripsdata as $tripsheet) {
                $rolesColumn    = '';
                $actionColumn   = "";
                $actionUrl = url("trip/edit/".$tripsheet->id);
                $actionUrlDel = url("trip/delete/".$tripsheet->id);
                if(Common::userwisepermission(Auth::user()->id, "Trips Update")){
                    if ($tripsheet->is_locked == 0) {
                        $EditBtn = "<a onclick=editmaintenancerequest('".$actionUrl."') class='custom-btn-action custom-btn-view  bgcolr-aqua'>Update</a>";
                    }
                    else{
                        $EditBtn="<a  class='custom-btn-action custom-btn-view btn-danger ' disabled style='color:white'>Locked</a>";
                    }
                }
                else{
                    $EditBtn="";
                }

                if(Common::userwisepermission(Auth::user()->id, "Trips Cancel")){
                    if ($tripsheet->is_locked != 1) {
                        $DeleteBtn = "<a onclick=editmaintenancerequest('".$actionUrlDel."') class='custom-btn-action custom-btn-view bgcolr-orange'>Cancel</a>";
                    }
                    else{
                        $DeleteBtn = "";
                    }
                }
                else{
                    $DeleteBtn = "";
                }
     
                $data[] = array(
                    'id'                    =>  $tripsheet->id,
                    'action'                =>  $EditBtn.$DeleteBtn,
                    'vehicle_id'            =>  $tripsheet->vehicle_id,
                    'vehicle_no'            =>  $tripsheet->vehicle_no,
                    'trip_date'             =>  $tripsheet->trip_date,
                    'name'                  =>  $tripsheet->cost_center_name,
                    'reading_start'         =>  $tripsheet->reading_start,
                    'created_at'            =>  $tripsheet->created_at
    );
                $sno++;
            }
        }

        return $data;
    }
}