<?php
namespace App\Model\Booking;

use App\Model\Countries\Countries;
use App\Model\CustomerManagment\Customer;
use Illuminate\Database\Eloquent\Model;
use Mgallegos\LaravelJqgrid\Repositories\EloquentRepositoryAbstract;
use DB,Auth;
use App\Helper\Common;

class LoadsheetPickupDataRepository extends EloquentRepositoryAbstract {


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
        $customer =Customer::where('user_id','=', \Illuminate\Support\Facades\Auth::User()->id)->first();

        $countries = LoadsheetData::select('id','loadsheet_no','created_at');
        if($customer != null)
        {
            $countries->where('consignee_id','=',$customer->id);
        }


        if(!empty($filters)){
            foreach($filters as $filtersRow){

                $field 	= $filtersRow['field'];
                $op 		= $filtersRow['op'];
                $data 	= $filtersRow['data'];

                $countries->where($field, $op,$data);
            }
        }

        return $countries->count();

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
        $customer =Customer::where('user_id','=', \Illuminate\Support\Facades\Auth::User()->id)->first();

        $countries = LoadsheetData::select('id','loadsheet_no','created_at');

        if($customer != null)
        {
            $countries->where('consignee_id','=',$customer->id);
        }

        if(!empty($filters)){
            foreach($filters as $filtersRow){

                $field 	= $filtersRow['field'];
                $op 		= $filtersRow['op'];
                $data 	= $filtersRow['data'];

                $countries->where($field, $op,$data);
            }
        }

        if(!empty($orderBy) && !empty($sord)){
            $countries->orderBy($orderBy, $sord);
        }

        $countries->offset($offset);

        $countries->limit($limit);
        $countries = $countries->get();

        $data = array();
        if(!empty($countries)){
            $sno = 1;

            foreach($countries as $country) {
                $rolesColumn    = '';
                $actionColumn   = "";
                $actionUrl = url("transaction/loadsheetprint/".$country->id);
                $actionUrlDel = url("setup/countries/delete/".$country->id);
                //if(Common::userwisepermission(Auth::user()->id, "Cities Update")){
                    $editBtn = "<a onclick=editmaintenancerequest('".$actionUrl."') class=' btn-cus-dessign btn btn-primary waves-effect waves-light'>Print</a> ";
                //}
                //else{
                //    $editBtn = "";
                //}
                //if (Common::userwisepermission(Auth::user()->id, "Cities Cancel")) {
                    $deleteBtn = "<a onclick=editmaintenancerequest('".$actionUrlDel."') class=' btn-cus-dessign btn btn-primary waves-effect waves-light'>View</a>";
                //}
                //else{
                //    $deleteBtn = "";
                //}
                $data[] = array(
                    'id'					=>$country->id,
                    'loadsheet_no'			=>$country->loadsheet_no,
                    'created_at'            =>$country->created_at,
                    'action'                => $editBtn
                );
                $sno++;
            }
        }

        return $data;
    }
}