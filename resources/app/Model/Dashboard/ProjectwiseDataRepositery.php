<?php
namespace App\Model\Dashboard;
use Illuminate\Database\Eloquent\Model;
use Mgallegos\LaravelJqgrid\Repositories\EloquentRepositoryAbstract;
use App\Model\Project\Project;
use Auth;
use DB;
use App\Helper\Common;

class ProjectwiseDataRepositery extends EloquentRepositoryAbstract {

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
        $maintenancerequest_info =Project::leftjoin('machineparts','project.id','=','machineparts.projectid')
            ->leftjoin('otherexpences','project.id','=','otherexpences.project_id')
            ->select('project.id','project.description',DB::raw('SUM(IFNULL(machineparts.`partamount`,0)) AS parttotal'),
                DB::raw('SUM(IFNULL(otherexpences.`amount`,0)) AS otheramount_total'),DB::raw('SUM(IFNULL(machineparts.`partamount`,0)) + SUM(IFNULL(otherexpences.`amount`,0)) AS grand_total'),
                'project.startdate','project.enddate');

        if(!empty($filters)){
            foreach($filters as $filtersRow){

                if($filtersRow['field'] == "deptname"){
                    $field 	= "department.description";
                }else if($filtersRow['field'] == "requesttypename"){
                    $field 	= "requesttype.description";
                }else
                {
                    $field 	= $filtersRow['field'];
                }
                $op 	= $filtersRow['op'];
                $data 	= $filtersRow['data'];



                $maintenancerequest_info->where($field, $op,$data);

            }
        }

        return $maintenancerequest_info->count();

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


        $maintenancerequest_infos = Project::leftjoin('machineparts','project.id','=','machineparts.projectid')
        ->leftjoin('otherexpences','project.id','=','otherexpences.project_id')
        ->select('project.id','project.description',DB::raw('SUM(IFNULL(machineparts.`partamount`,0)) AS parttotal'),
            DB::raw('SUM(IFNULL(otherexpences.`amount`,0)) AS otheramount_total'),DB::raw('SUM(IFNULL(machineparts.`partamount`,0)) + SUM(IFNULL(otherexpences.`amount`,0)) AS grand_total'),
            'project.startdate','project.enddate')
        ->groupBy('project.id', 'project.startdate', 'project.enddate', 'project.description' );
        if(!empty($filters)){
            foreach($filters as $filtersRow){

            if($filtersRow['field'] == "deptname"){
                $field 	= "department.description";
            }else if($filtersRow['field'] == "requesttypename"){
                $field 	= "requesttype.description";
            }else
            {
                $field 	= $filtersRow['field'];
            }


                $op 		= $filtersRow['op'];
                $data 	= $filtersRow['data'];

                $maintenancerequest_infos->where($field, $op,$data);
            }
        }

        if(!empty($orderBy) && !empty($sord)){
            $maintenancerequest_infos->orderBy($orderBy, $sord);
        }

        $maintenancerequest_infos->offset($offset);

        $maintenancerequest_infos->limit($limit);
        $maintenancerequestData = $maintenancerequest_infos->get();

        $data = array();
        if(!empty($maintenancerequestData)){
            $update = Common::userwisepermission(Auth::user()->id, "Maintenance Request Update");
            $view = Common::userwisepermission(Auth::user()->id, "Maintenance Request View");
            foreach($maintenancerequestData as $maintenancerequest_infosRow){
                if($update)
                {
                    $editButton= "<a href='".url('/maintenancerequest/edit/'.$maintenancerequest_infosRow->id)."' class='custom-btn-view bgcolr-aqua viewproduct' rel=''>Update</a>";
                }else
                {
                    $editButton= "";
                }
                if($view)
                {
                    $viewButton= "<a onclick=editmaintenancerequest('".url('/maintenancerequest/view/'.$maintenancerequest_infosRow->id)."') class='custom-btn-view bgcolr-aqua viewproduct' product-id=''>view</a>";
                }
                else
                {
                    $viewButton="";
                }
                $closedate = date_create($maintenancerequest_infosRow->dateclosed = null ? date("Y-m-d") : $maintenancerequest_infosRow->dateclosed);
                $requestdate = date_create($maintenancerequest_infosRow->requestdate);
                $diff= date_diff($requestdate,$closedate);
                $data[] = array(
                    'id'					=>	$maintenancerequest_infosRow->id,
                    'description'		    =>	$maintenancerequest_infosRow->description,
                    'parttotal'		    =>	$maintenancerequest_infosRow->parttotal,
                    'otheramount_total'			=>	$maintenancerequest_infosRow->otheramount_total,
                    'grand_total'			    =>	$maintenancerequest_infosRow->grand_total,
                    'startdate'          =>  $maintenancerequest_infosRow->startdate,
                    'enddate'           =>  $maintenancerequest_infosRow->enddate,
                    'action'			    =>	$editButton.$viewButton,
                );

            }
        }

        return $data;


    }
}
