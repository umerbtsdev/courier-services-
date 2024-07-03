<?php

namespace App\Model\BankBranches;

use Illuminate\Database\Eloquent\Model;
use App\Model\BankBranches\BankBranches;
use App\Helper\Common;
use Auth;
use DB;
use Mgallegos\LaravelJqgrid\Repositories\EloquentRepositoryAbstract;

class BankBranchesDataRepository extends EloquentRepositoryAbstract
{
    public function getTotalNumberOfRows(array $filters = array())
    {
        $BankBranches = BankBranches::leftjoin('fi_banks','fi_bank_branches.bank_id','=','fi_banks.bank_id')
        ->leftjoin('cities','fi_bank_branches.city_id','=','cities.id')
        ->select(
            'fi_bank_branches.id',
            'fi_bank_branches.branch_name',
            'fi_banks.bank_name',
            'cities.name as city_name'
        );
            
            
            if(!empty($filters)){
            foreach($filters as $filtersRow){

                if($filtersRow['field'] ==  "bank_name")
                {
                    $field 	= "fi_banks.bank_name";
                }
                $op 	= $filtersRow['op'];
                $data 	= $filtersRow['data'];
                $BankBranches->where($field, $op,$data);

            }
        }

        return $BankBranches->count();

    }

    public function getRows($limit, $offset, $orderBy = null, $sord = null, array $filters = array(),$nodeId = null, $nodeLevel = null,$exporting)
    {

        $BankBranches = BankBranches::leftjoin('fi_banks','fi_bank_branches.bank_id','=','fi_banks.bank_id')
        ->leftjoin('cities','fi_bank_branches.city_id','=','cities.id')
        ->select(
            'fi_bank_branches.id',
            'fi_bank_branches.branch_name',
            'fi_banks.bank_name',
            'cities.name as city_name'
        );

      
        

        if(!empty($filters)){
            foreach($filters as $filtersRow){

                if($filtersRow['field'] ==  "bank_name")
                {
                    $field 	= "fi_banks.bank_name";
                }
                

                $op 	= $filtersRow['op'];
                $data 	= $filtersRow['data'];

                $BankBranches->where($field, $op,$data);
            }
        }

        if(!empty($orderBy) && !empty($sord)){
            $orderBy = "fi_banks.bank_name";
            $sord = "ASC";
            $BankBranches->orderBy($orderBy, $sord);
       }
       
        $BankBranches->offset($offset);

        $BankBranches->limit($limit);
        
        $BankBranches = $BankBranches->get();

        $data = array();
        if(!empty($BankBranches)){
            $update = Common::userwisepermission(Auth::user()->id, "Bank Branch Update");
            $view = Common::userwisepermission(Auth::user()->id, "Bank Branch Cancel");

            foreach($BankBranches as $BankBranch){
               
                if($update){   
                    $editButton= "<a onclick=editmaintenancerequest('".url('/General-Setup/bankbranches/edit/'.$BankBranch->id)."','update') class='custom-btn-view bgcolr-aqua viewproduct' product-id=''>Update</a>";
                }
                else{
                    $editButton= "";
                }
                if($view){
                    $deleteButton= "<a onclick=editmaintenancerequest('".url('/General-Setup/bankbranches/delete/'.$BankBranch->id)."','delete') class='custom-btn-view bgcolr-orange viewproduct' product-id=''>Cancel</a>";
                }
                else{
                    $deleteButton="";
                }
                //'accountscanwell.id','name_of_business','owner_name','address_of_business','phone_number','mobile_number','email_address','date_of_establishment','introducer_person','is_updateable'
                $data[] = array(
                    'bank_id'				   =>  $BankBranch->id,
                    'bank_name'                =>  $BankBranch->bank_name,
                    'city_name'                =>  $BankBranch->city_name,
                    'branch_name'              =>  $BankBranch->branch_name,
                    'action'			       =>  $editButton.$deleteButton,
                );

            }
        }

        return $data;


    }
}
