<?php

namespace App\Model\Banks;

use Illuminate\Database\Eloquent\Model;
use App\Model\Banks\Banks;
use App\Helper\Common;
use Auth;
use DB;
use Mgallegos\LaravelJqgrid\Repositories\EloquentRepositoryAbstract;


class BanksDataRepository extends EloquentRepositoryAbstract
{
    public function getTotalNumberOfRows(array $filters = array())
    {
        $Banks = Banks::leftjoin('users','fi_banks.created_by','=','users.id')
        ->leftjoin('users as user_updated','fi_banks.updated_by','=','user_updated.id')
        ->select(
            'fi_banks.bank_id',
            'fi_banks.bank_name',
            "users.name as created_by",
            "fi_banks.created_at",
            "user_updated.name as updated_by",
            "fi_banks.updated_at"
        );
            
            
            if(!empty($filters)){
            foreach($filters as $filtersRow){

                if($filtersRow['field'] ==  "bank_name")
                {
                    $field 	= "fi_banks.bank_name";
                }
                $op 	= $filtersRow['op'];
                $data 	= $filtersRow['data'];
                $Banks->where($field, $op,$data);

            }
        }

        return $Banks->count();

    }

    public function getRows($limit, $offset, $orderBy = null, $sord = null, array $filters = array(),$nodeId = null, $nodeLevel = null,$exporting)
    {

        $Banks = Banks::leftjoin('users','fi_banks.created_by','=','users.id')
        ->leftjoin('users as user_updated','fi_banks.updated_by','=','user_updated.id')
        ->select(
            'fi_banks.bank_id',
            'fi_banks.bank_name',
            "users.name as created_by",
            "fi_banks.created_at",
            "user_updated.name as updated_by",
            "fi_banks.updated_at"
        );

      
        

        if(!empty($filters)){
            foreach($filters as $filtersRow){

                if($filtersRow['field'] ==  "bank_name")
                {
                    $field 	= "fi_banks.bank_name";
                }
                

                $op 	= $filtersRow['op'];
                $data 	= $filtersRow['data'];

                $Banks->where($field, $op,$data);
            }
        }

        if(!empty($orderBy) && !empty($sord)){
            $orderBy = "bank_id";
            $sord = "DESC";
            $Banks->orderBy($orderBy, $sord);
       }
       
        $Banks->offset($offset);

        $Banks->limit($limit);
        
        $Banks = $Banks->get();

        $data = array();
        if(!empty($Banks)){
            $update = Common::userwisepermission(Auth::user()->id, "Banks Update");
            $view = Common::userwisepermission(Auth::user()->id, "Banks Cancel");

            foreach($Banks as $bank){
               
                if($update){   
                    $editButton= "<a onclick=editmaintenancerequest('".url('/General-Setup/banks/edit/'.$bank->bank_id)."','update') class='custom-btn-view bgcolr-aqua viewproduct' product-id=''>Update</a>";
                }
                else{
                    $editButton= "";
                }
                if($view){
                    $deleteButton= "<a onclick=editmaintenancerequest('".url('/General-Setup/banks/delete/'.$bank->bank_id)."','delete') class='custom-btn-view bgcolr-orange viewproduct' product-id=''>Cancel</a>";
                }
                else{
                    $deleteButton="";
                }
                //'accountscanwell.id','name_of_business','owner_name','address_of_business','phone_number','mobile_number','email_address','date_of_establishment','introducer_person','is_updateable'
                $data[] = array(
                    'bank_id'				   =>  $bank->bank_id,
                    'bank_name'                =>  $bank->bank_name,
                    'bank_created_by'          =>  $bank->created_by,
                    'bank_created_at'          =>  $bank->created_at,
                    'bank_updated_by'          =>  $bank->updated_by,
                    'bank_updated_at'          =>  $bank->updated_at,
                    'action'			       =>  $editButton.$deleteButton,
                );

            }
        }

        return $data;


    }
}
