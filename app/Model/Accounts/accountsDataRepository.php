<?php

namespace App\Model\Accounts;

use Illuminate\Database\Eloquent\Model;
use App\Model\BankBranches\BankBranches;
use App\Model\Banks\Banks;
use App\Model\Accounts\accounts;
use App\Helper\Common;
use Auth;
use DB;
use Mgallegos\LaravelJqgrid\Repositories\EloquentRepositoryAbstract;

class accountsDataRepository extends EloquentRepositoryAbstract
{
    public function getTotalNumberOfRows(array $filters = array())
    {
        $accounts = accounts::join('users','fi_accounts.created_by','=','users.id')
        ->leftjoin('users as user_updated','fi_accounts.updated_by','=','user_updated.id')
        ->join("fi_banks",'fi_accounts.bank_id','=','fi_banks.bank_id')
        ->join("fi_bank_branches",'fi_accounts.branch_id','=','fi_bank_branches.id')
        ->select(
            'fi_accounts.id',
            'fi_banks.bank_name',
            'fi_bank_branches.branch_name',
            'fi_accounts.acc_number',
            'fi_accounts.acc_title',
            'fi_accounts.iban',
            "users.name as created_by",
            "fi_accounts.created_at",
            "user_updated.name as updated_by",
            "fi_accounts.updated_at"
        );
            
            
            if(!empty($filters)){
            foreach($filters as $filtersRow){

                if($filtersRow['field'] ==  "bank_name")
                {
                    $field 	= "fi_banks.bank_name";
                }
                else if($filtersRow['field'] ==  "branch_name")
                {
                    $field 	= "fi_bank_branches.branch_name";
                }
                else if($filtersRow['field'] ==  "acc_number")
                {
                    $field 	= 'fi_accounts.acc_number';
                }
                else if($filtersRow['field'] ==  "acc_title")
                {
                    $field 	= 'fi_accounts.acc_title';
                }
                else if($filtersRow['field'] ==  "iban")
                {
                    $field 	= 'fi_accounts.iban';
                }
                $op 	= $filtersRow['op'];
                $data 	= $filtersRow['data'];
                $accounts->where($field, $op,$data);

            }
        }

        return $accounts->count();

    }

    public function getRows($limit, $offset, $orderBy = null, $sord = null, array $filters = array(),$nodeId = null, $nodeLevel = null,$exporting)
    {

        $accounts = accounts::join('users','fi_accounts.created_by','=','users.id')
        ->leftjoin('users as user_updated','fi_accounts.updated_by','=','user_updated.id')
        ->join("fi_banks",'fi_accounts.bank_id','=','fi_banks.bank_id')
        ->join("fi_bank_branches",'fi_accounts.branch_id','=','fi_bank_branches.id')
        ->select(
            'fi_accounts.id',
            'fi_banks.bank_name',
            'fi_bank_branches.branch_name',
            'fi_accounts.acc_number',
            'fi_accounts.acc_title',
            'fi_accounts.iban',
            "users.name as created_by",
            "fi_accounts.created_at",
            "user_updated.name as updated_by",
            "fi_accounts.updated_at",
            "fi_accounts.is_primary"
        );
      
        

        if(!empty($filters)){
            foreach($filters as $filtersRow){

                if($filtersRow['field'] ==  "bank_name")
                {
                    $field 	= "fi_banks.bank_name";
                }
                else if($filtersRow['field'] ==  "branch_name")
                {
                    $field 	= "fi_bank_branches.branch_name";
                }
                else if($filtersRow['field'] ==  "acc_number")
                {
                    $field 	= 'fi_accounts.acc_number';
                }
                else if($filtersRow['field'] ==  "acc_title")
                {
                    $field 	= 'fi_accounts.acc_title';
                }
                else if($filtersRow['field'] ==  "iban")
                {
                    $field 	= 'fi_accounts.iban';
                }
                $op 	= $filtersRow['op'];
                $data 	= $filtersRow['data'];

                $accounts->where($field, $op,$data);
            }
        }

        if(!empty($orderBy) && !empty($sord)){
            $orderBy = "fi_accounts.created_at";
            $sord = "DESC";
            $accounts->orderBy($orderBy, $sord);
       }
       
        $accounts->offset($offset);

        $accounts->limit($limit);
        
        $accounts = $accounts->get();

        $data = array();
        if(!empty($accounts)){
            $update = Common::userwisepermission(Auth::user()->id, "Bank Accounts Update");
            $view = Common::userwisepermission(Auth::user()->id, "Bank Accounts Cancel");
            $makePrimary = Common::userwisepermission(Auth::user()->id, "Bank Accounts Make Primary");

            foreach($accounts as $account){
               
                if($update){   
                    $editButton= "<a onclick=editmaintenancerequest('".url('/General-Setup/accounts/edit/'.$account->id)."','update') class='custom-btn-view bgcolr-aqua viewproduct' product-id=''>Update</a>";
                }
                else{
                    $editButton= "";
                }
                if($view){
                    $deleteButton= "<a onclick=editmaintenancerequest('".url('/General-Setup/accounts/delete/'.$account->id)."','delete') class='custom-btn-view bgcolr-orange viewproduct' product-id=''>Cancel</a>";
                }
                else{
                    $deleteButton="";
                }

                if ($account->is_primary != 1) {
                    if ($makePrimary) {
                        $MakePrimaryButton= "<a onclick=editmaintenancerequest('".url('/General-Setup/accounts/makePrimary/'.$account->id)."','MakePrimary') class='custom-btn-view bg-purple-active viewproduct' product-id=''>Make Primary</a>";
                    } else {
                        $MakePrimaryButton="";
                    }
                }
                else{
                    $MakePrimaryButton="";
                }
                
                //'accountscanwell.id','name_of_business','owner_name','address_of_business','phone_number','mobile_number','email_address','date_of_establishment','introducer_person','is_updateable'
                $data[] = array(
                    'account_id'			   =>  $account->id,
                    'bank_name'                =>  $account->bank_name,
                    'branch_name'              =>  $account->branch_name,
                    'acc_number'               =>  $account->acc_number,
                    'acc_title'                =>  $account->acc_title ,
                    'iban'                     =>  $account->iban,
                    'created_at'               =>  $account->created_at,
                    'created_by'               =>  $account->created_by,
                    'updated_at'               =>  $account->updated_at,
                    'updated_by'               =>  $account->updated_by,
                    'action'			       =>  $editButton.$deleteButton.$MakePrimaryButton,
                );

            }
        }

        return $data;


    }
}
