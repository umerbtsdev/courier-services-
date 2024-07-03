<?php
namespace App\Model\Account;
use App\Model\Account\Account;
use Illuminate\Database\Eloquent\Model;
use Mgallegos\LaravelJqgrid\Repositories\EloquentRepositoryAbstract;
use App\Model\Department\Requesttype;
use App\Helper\Common;
use Auth;
use DB;

class AccountDataRepositery extends EloquentRepositoryAbstract {

    /*
       public function __construct()
       {
           $this->Database = new Vendor_info();

           $this->visibleColumns = array('firstname','lastname','vendor_email','action_column');

           $this->orderBy = array(array('id', 'asc'));
       }*/


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
        $department_info = new Account();

        if(!empty($filters)){
            foreach($filters as $filtersRow){

                $field 	= $filtersRow['field'];
                $op 	= $filtersRow['op'];
                $data 	= $filtersRow['data'];



                $department_info->where($field, $op,$data);

            }
        }

        return $department_info->count();

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


        $department_info = Account::leftjoin('form_approve_reject', 'form_approve_reject.form_id', '=', 'account.id')
            ->select('account.id','name_of_business','owner_name','qualification_patient_load','cnic_no','ntn_no','phone_number','email_address',
                'credit_limit_requested','credit_days_requested','form_approve_reject.is_closed','is_updateable');

        $department_info =$department_info->where('form_approve_reject.is_closed','=', DB::RAW('0'));

        if (Common::userwisepermission(Auth::user()->id, "Account Opening Form Creator") == 1) {
            $department_info = $department_info->where('created_by', '=', Auth::User()->id);
        }
        $current_user = Auth::user()->id;
        $Gynaecology = Common::userwisepermission($current_user, "Gynaecology");
        $Oncology = Common::userwisepermission($current_user, "Oncology");
        $Thalassaemia = Common::userwisepermission($current_user, "Thalassaemia");
        $Gastro_Nephrology = Common::userwisepermission($current_user, "Gastro Nephrology");
        $Institution = Common::userwisepermission($current_user, "Institution");

        $department_info->where(function($q) use($current_user, $Gynaecology, $Oncology, $Thalassaemia, $Gastro_Nephrology, $Institution){
            if ($Gynaecology == 1) {
                $q->orWhere('gynaecology', '=', DB::RAW('1'));
            }

            if ($Oncology == 1) {
                $q->orWhere('oncology', '=', DB::RAW('1'));
            }
            if ($Thalassaemia == 1) {
                $q->orWhere('thalassaemia', '=', DB::RAW('1'));
            }
            if ($Gastro_Nephrology == 1) {
                $q->orWhere('gastro_nephrology', '=', DB::RAW('1'));
            }
            if ($Institution == 1) {
                $q->orWhere('hiv_aids', '=', DB::RAW('1'));
            }
        });

	$department_info->where(function($q) use($current_user) {
	    if (Common::userwisepermission($current_user, "Account opening from level 1") == 1) {

                $q->orWhere('from_level_enable_1', '=', DB::RAW('1'));
            }
            if (Common::userwisepermission($current_user, "Account opening from level 2") == 1) {

                $q->orWhere('from_level_enable_2', '=', DB::RAW('1'));
            }
            if (Common::userwisepermission($current_user, "Account opening from level 3") == 1) {
                $q->orWhere('from_level_enable_3', '=', DB::RAW('1'));
            }
            if (Common::userwisepermission($current_user, "Account opening from level 4") == 1) {
                $q->orWhere('from_level_enable_4', '=', DB::RAW('1'));
            }
            if (Common::userwisepermission($current_user, "Account opening from level 5") == 1) {
                $q->orWhere('from_level_enable_5', '=', DB::RAW('1'));
            }
            if (Common::userwisepermission($current_user, "Account opening from level 6") == 1) {
                $q->orWhere('from_level_enable_6', '=', DB::RAW('1'));
            }
            if (Common::userwisepermission($current_user, "Account opening from level 7") == 1) {
                $q->orWhere('from_level_enable_7', '=', DB::RAW('1'));
            }
            if (Common::userwisepermission($current_user, "Account opening from level 8") == 1) {
                $q->orWhere('from_level_enable_8', '=', DB::RAW('1'));
            }
            if (Common::userwisepermission($current_user, "Account opening from level 9") == 1) {
                $q->orWhere('from_level_enable_9', '=', DB::RAW('1'));
            }
            if (Common::userwisepermission($current_user, "Account opening from level 10") == 1) {
                $q->orWhere('from_level_enable_10', '=', DB::RAW('1'));
            }

	});

        

        if(!empty($filters)){
            foreach($filters as $filtersRow){

                if($filtersRow['field'] ==  "name")
                {
                    $field 	= "description";
                }else
                {
                    $field 	= $filtersRow['field'];
                }

                $op 	= $filtersRow['op'];
                $data 	= $filtersRow['data'];

                $department_info->where($field, $op,$data);
            }
        }

        if(!empty($orderBy) && !empty($sord)){
            $department_info->orderBy($orderBy, $sord);
       }

        $department_info->offset($offset);

        $department_info->limit($limit);
        $departmentData = $department_info->get();

        $data = array();
        if(!empty($departmentData)){
            $update = Common::userwisepermission(Auth::user()->id, "Acoount Opening Update");
            $view = Common::userwisepermission(Auth::user()->id, "Acoount Opening View");
            foreach($departmentData as $department_infosRow){
                if($update && $department_infosRow->is_updateable == 1)
                {
                    $editButton= "<a onclick=editmaintenancerequest('".url('/account/edit/'.$department_infosRow->id)."') class='custom-btn-view bgcolr-aqua viewproduct' product-id=''>Update</a>";
                }else
                {
                    $editButton= "";
                }
                if($view)
                {
                    $viewButton= "<a onclick=editmaintenancerequest('".url('/account/view/'.$department_infosRow->id)."') class='custom-btn-view bgcolr-aqua viewproduct' product-id=''>View</a>";
                }
                else
                {
                    $viewButton="";
                }

                $data[] = array(
                    'id'					        =>	$department_infosRow->id,
                    'name_of_business'				=>	$department_infosRow->name_of_business,
                    'owner_name'				    =>	$department_infosRow->owner_name,
                    'qualification_patient_load'	=>	$department_infosRow->qualification_patient_load,
                    'cnic_no'				        =>	$department_infosRow->cnic_no,
                    'ntn_no'				        =>	$department_infosRow->ntn_no,
                    'phone_number'				    =>	$department_infosRow->phone_number,
                    'email_address'				    =>	$department_infosRow->email_address,
                    'credit_limit_requested'		=>	$department_infosRow->credit_limit_requested,
                    'credit_days_requested'			=>	$department_infosRow->credit_days_requested,
                    'action'			            =>	$editButton. $viewButton,
                );

            }
        }

        return $data;


    }
}
