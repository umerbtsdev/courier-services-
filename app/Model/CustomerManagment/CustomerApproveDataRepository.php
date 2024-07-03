<?php
namespace App\Model\CustomerManagment;

use App\Model\CustomerManagment\Customer;
use Illuminate\Database\Eloquent\Model;
use Mgallegos\LaravelJqgrid\Repositories\EloquentRepositoryAbstract;
use DB,Auth;
use App\Helper\Common;
class CustomerApproveDataRepository extends EloquentRepositoryAbstract {



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
        $customer = Customer::select('customer.id','first_name', 'last_name','customer.email', 'contact_no','alernate_no','country_id','city_id','address','user_id', 'cnic', 'bank_name','branch_name','account_no','account_title','brith_date','anniversary_date');

        if(!empty($filters)){
            foreach($filters as $filtersRow){

                $field 	= $filtersRow['field'];
                $op 		= $filtersRow['op'];
                $data 	= $filtersRow['data'];

                $customer->where($field, $op,$data);
            }
        }

        return $customer->count();

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
        $customer = Customer::join('users','users.id', '=', 'user_id')
        ->select('customer.id','first_name','users.status',  'last_name','customer.email', 'contact_no','alernate_no','country_id','city_id','address','user_id', 'cnic', 'bank_name','branch_name','account_no','account_title','brith_date','anniversary_date');


        if(!empty($filters)){
            foreach($filters as $filtersRow){

                $field 	= $filtersRow['field'];
                $op 		= $filtersRow['op'];
                $data 	= $filtersRow['data'];

                $customer->where($field, $op,$data);
            }
        }

        if(!empty($orderBy) && !empty($sord)){
            $customer->orderBy($orderBy, $sord);
        }

        $customer->offset($offset);

        $customer->limit($limit);
        $customer = $customer->get();

        $data = array();
        if(!empty($customer)){
            $sno = 1;

            foreach($customer as $cus) {
                $rolesColumn    = '';
                $actionColumn   = "";
                $actionUrl = url("customer/approve/".$cus->id);
                $actionUrldisable = url("customer/disable/".$cus->id);

               
                if($cus->status == 0){
                    $EditBtn = "<a onclick=editmaintenancerequest('".$actionUrl."') class='btn-cus-dessign btn btn-primary waves-effect waves-light'>Approve</a> ";
                }
                else{
                    $EditBtn = "<a onclick=editmaintenancerequest('".$actionUrldisable."') class='btn-cus-dessign btn btn-primary waves-effect waves-light'>Disable</a> ";

                }

                $data[] = array(
                    'id'			=>	$cus->id,
                    'first_name'			=>	$cus->first_name,
                    'last_name'			=>	$cus->last_name,
                    'email'			=>	$cus->email,
                    'contact_no'			=>	$cus->contact_no,
                    'alernate_no'			=>	$cus->alernate_no,
                    'action'        =>  $EditBtn
                );
                $sno++;
            }
        }

        return $data;
    }
}