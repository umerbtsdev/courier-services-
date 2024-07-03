<?php
namespace App\Model\Manufacturers;

use Illuminate\Database\Eloquent\Model;
use App\Model\Manufacturers\manufacturers;
use Mgallegos\LaravelJqgrid\Repositories\EloquentRepositoryAbstract;
use DB,Auth;
use App\Helper\Common;
class manufacturersDataRepository extends EloquentRepositoryAbstract {

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



       $manufacturers = manufacturers::leftjoin('users','manufacturers.created_by','=','users.id')
       ->leftjoin('users as user_updated','manufacturers.updated_by','=','user_updated.id')
       ->select(
           'manufacturers.id as manufacturers_id',
           'manufacturers.name as manufacturers_name',
           'manufacturers.created_at as manufacturers_created_at',
           'manufacturers.updated_at as manufacturers_updated_at',
           'users.name as created_by',
           'user_updated.name as updated_by'

       );
    
    


    

        if(!empty($filters)){
            foreach($filters as $filtersRow){

                $field 	= $filtersRow['field'];
                $op 		= $filtersRow['op'];
                $data 	= $filtersRow['data'];

                $manufacturers->where($field, $op,$data);
            }
        }

        return $manufacturers->count();


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
    
         $manufacturers = manufacturers::leftjoin('users','manufacturers.created_by','=','users.id')
        ->leftjoin('users as user_updated','manufacturers.updated_by','=','user_updated.id')
        ->select(
            'manufacturers.id as manufacturers_id',
            'manufacturers.name as manufacturers_name',
            'manufacturers.created_at as manufacturers_created_at',
            'manufacturers.updated_at as manufacturers_updated_at',
            'users.name as created_by',
            'user_updated.name as updated_by'

        );


        if(!empty($filters)){
            foreach($filters as $filtersRow){

                $field 	= $filtersRow['field'];
                $op 		= $filtersRow['op'];
                $data 	= $filtersRow['data'];

                $manufacturers->where($field, $op,$data);
            }
        }
            
        if(!empty($orderBy) && !empty($sord)){
            $orderBy="manufacturers_id";
            $sord = "ASC";
            $manufacturers->orderBy($orderBy, $sord);
        }

        $manufacturers->offset($offset);

        $manufacturers->limit($limit);
        $manufacturers = $manufacturers->get();

        $data = array();
        if(!empty($manufacturers)){
            $sno = 1;

      
            foreach($manufacturers as $manufacturer) {
                $rolesColumn    = '';
                $actionColumn   = "";
                $actionUrl = url("workshops/Manufacturers/update/".$manufacturer->manufacturers_id);
                $actionUrlDel = url("workshops/Manufacturers/delete/".$manufacturer->manufacturers_id);
               
                if(Common::userwisepermission(Auth::user()->id, "Manufacturers Update")){
                    $EditBtn = "<a onclick=editmaintenancerequest('".$actionUrl."','update') class='custom-btn-action custom-btn-view  bgcolr-orange'>Update</a>";
                }
                else{
                    $EditBtn ="";
                }
                if(Common::userwisepermission(Auth::user()->id, "Manufacturers Cancel")){
                    $DeleteBtn = "<a onclick=editmaintenancerequest('".$actionUrlDel."','delete') class='custom-btn-action custom-btn-view bgcolr-aqua'>Cancel</a>";
                }
                else{
                    $DeleteBtn = "";
                }
                     
                
                $data[] = array(
                    'action'                          =>  $EditBtn. $DeleteBtn,
                    'id'                              =>  $manufacturer->manufacturers_id,
                    'name'                            =>  $manufacturer->manufacturers_name,
                    'created_at'                      =>  $manufacturer->manufacturers_created_at,
                    'updated_at'                      =>  $manufacturer->manufacturers_updated_at,
                    'created_by'                      =>  $manufacturer->created_by,
                    'updated_by'                      =>  $manufacturer->updated_by,

                );
                $sno++;
            }
        }

        return $data;
    }
}