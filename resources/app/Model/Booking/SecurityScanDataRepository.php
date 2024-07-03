<?php
namespace App\Model\Booking;

use App\Model\Countries\Countries;
use App\Model\CustomerManagment\Customer;
use Illuminate\Database\Eloquent\Model;
use Mgallegos\LaravelJqgrid\Repositories\EloquentRepositoryAbstract;
use DB,Auth;
use App\Helper\Common;

class SecurityScanDataRepository extends EloquentRepositoryAbstract {


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


        $countries = OrderBooking::leftjoin('customer', 'customer.id','=','order_booking.consignee_id')
            ->leftjoin('services','order_booking.service','=', 'services.id')
            ->select('order_booking.id','order_booking.cn_no');
            $countries->where('order_booking.is_security_scan','=', DB::raw('1'));
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


        $countries = OrderBooking::leftjoin('customer', 'customer.id','=','order_booking.consignee_id')
            ->leftjoin('services','order_booking.service','=', 'services.id')
            ->leftjoin('city','order_booking.destination_city','=', 'city.id')
            ->select('order_booking.id','order_booking.cn_no','customer.business_name','customer.owner_name',
                'order_booking.customer_name','order_booking.customer_address','order_booking.customer_Contact_number', 'order_booking.customer_email',
                'order_booking.customer_contact_person','order_booking.pieces','order_booking.weight','order_booking.fragile',
                'order_booking.origin','order_booking.destination_country','order_booking.destination_city','order_booking.destination_city','order_booking.cod_amount',
                'order_booking.product_detail','order_booking.insurance_declared_value','order_booking.service','order_booking.remarks','services.service_name', 'city.name as city_name');
        $countries->where('order_booking.is_security_scan','=', DB::raw('1'));


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
                $actionUrl = url("transaction/orderbookingprint/".$country->id);
                $actionUrlDel = url("setup/countries/delete/".$country->id);
//                if(Common::userwisepermission(Auth::user()->id, "Cities Update")){
                    $editBtn = "<a onclick=editmaintenancerequest('".$actionUrl."') class=' btn-cus-dessign btn btn-primary waves-effect waves-light'>Print</a> ";
//                }
//                else{
//                    $editBtn = "";
//                }
//                if (Common::userwisepermission(Auth::user()->id, "Cities Cancel")) {
                    $deleteBtn = "<a onclick=editmaintenancerequest('".$actionUrlDel."') class=' btn-cus-dessign btn btn-primary waves-effect waves-light'>View</a>";
//                }
//                else{
//                    $deleteBtn = "";
//                }
                $data[] = array(
                    'id'					=>$country->id,
                    'cn_no'					=>$country->cn_no,
                    'consignee_name'        =>$country->business_name,
                    'customer_name'         =>$country->customer_name,
                    'contact_number'        =>$country->customer_Contact_number,
                    'pieces'                =>$country->pieces,
                    'weight'                =>$country->weight,
                    'service'               =>$country->service_name,
                    'destination_City'      =>$country->city_name,
                    'cod_amount'            =>$country->cod_amount,
                    'action'                => ""
                );
                $sno++;
            }
        }

        return $data;
    }
}