<?php
namespace App\Model\UserManagment;

use App\User;
use Illuminate\Database\Eloquent\Model;
use Mgallegos\LaravelJqgrid\Repositories\EloquentRepositoryAbstract;
use DB,Auth;

class UserDataRepository extends EloquentRepositoryAbstract {



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
        $User = User::select('name','email');

        if(!empty($filters)){
            foreach($filters as $filtersRow){

                $field 	= $filtersRow['field'];
                $op 		= $filtersRow['op'];
                $data 	= $filtersRow['data'];

                $User->where($field, $op,$data);
            }
        }

        return $User->count();

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
        $Users = User::select('*');


        if(!empty($filters)){
            foreach($filters as $filtersRow){

                $field 	= $filtersRow['field'];
                $op 		= $filtersRow['op'];
                $data 	= $filtersRow['data'];

                $Users->where($field, $op,$data);
            }
        }

        if(!empty($orderBy) && !empty($sord)){
            $Users->orderBy($orderBy, $sord);
        }

        $Users->offset($offset);

        $Users->limit($limit);
        $Users = $Users->get();

        $data = array();
        if(!empty($Users)){
            $sno = 1;

            foreach($Users as $user) {
                $rolesColumn    = '';
                $actionColumn   = '';
                foreach ($user->roles as $key => $role) {
                        $rolesColumn    = $rolesColumn.'<span class="user-roles bgcolr-aqua"><i class="fa fa-edit"></i>'.$role->name.'</span>';
                }


                $actionColumn = '<a href="users/edit/'.$user->id.'" class="btn-cus-dessign btn btn-primary waves-effect waves-light">Edit </a> <a href="users/delete/'.$user->id.'" class="btn-cus-dessign btn btn-primary waves-effect waves-light">Delete </a>';
                                if($user->email == "mshoaibbadlae@gmail.com")
                                {
                                    continue;
                                }
                $data[] = array(
                    'name'					=>	$user->name,
                    'email'                 =>  $user->email,
                    'roles'                 =>  $rolesColumn,
                    'action'                =>  $actionColumn
                );

                $sno++;
            }
        }

        return $data;
    }
}
