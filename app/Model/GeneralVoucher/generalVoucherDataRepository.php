<?php

namespace App\Model\GeneralVoucher;

use Illuminate\Database\Eloquent\Model;
use App\Model\GeneralVoucher\general_voucher;
use App\Model\GeneralVoucher\general_voucher_details;
use Mgallegos\LaravelJqgrid\Repositories\EloquentRepositoryAbstract;
use Auth, App\Helper\Common;;
class generalVoucherDataRepository extends EloquentRepositoryAbstract
{
    public function getTotalNumberOfRows(array $filters = array())
    {
        
        $generalVouchers = general_voucher::select('id','transaction_date','due_date','remarks','debit_total','credit_total');
        
        if(!empty($filters)){
            foreach($filters as $filtersRow){
                if($filtersRow['field'] == 'id')
                {
                    $field 	= "fi_general_voucher_master.id";
                }
                if($filtersRow['field'] == 'transaction_date')
                {
                    $field 	= "fi_general_voucher_master.transaction_date";
                }
                elseif($filtersRow['field'] == 'due_date')
                {
                    $field 	= "fi_general_voucher_master.due_date";
                }
                elseif($filtersRow['field'] == 'debit_total')
                {
                    $field 	= "fi_general_voucher_master.debit_total";
                }
                elseif($filtersRow['field'] == 'credit_total')
                {
                    $field 	= "fi_general_voucher_master.credit_total";
                }
                elseif($filtersRow['field'] == 'remarks')
                {
                    $field 	= "fi_general_voucher_master.remarks";
                }

                $op 	= $filtersRow['op'];
              /*  if($filtersRow['field'] == 'transaction_date'){
                     $data= date("Y-m-d", strtotime($filtersRow['data']));
               }
                else{*/
                    $data 	= $filtersRow['data'];
              //  }
                
                $generalVouchers->where($field, $op,$data);

            }
        }

        return $generalVouchers->count();

    }
    public function getRows($limit, $offset, $orderBy = null, $sord = null, array $filters = array(),$nodeId = null, $nodeLevel = null,$exporting)
    {


        $generalVouchers = general_voucher::select('id','transaction_date','due_date','remarks','debit_total','credit_total');

            
        if(!empty($filters)){
            foreach($filters as $filtersRow){

                if($filtersRow['field'] == 'id')
                {
                    $field 	= "fi_general_voucher_master.id";
                }
                if($filtersRow['field'] == 'transaction_date')
                {
                    $field 	= "fi_general_voucher_master.transaction_date";
                }
                elseif($filtersRow['field'] == 'due_date')
                {
                    $field 	= "fi_general_voucher_master.due_date";
                }
                elseif($filtersRow['field'] == 'debit_total')
                {
                    $field 	= "fi_general_voucher_master.debit_total";
                }
                elseif($filtersRow['field'] == 'credit_total')
                {
                    $field 	= "fi_general_voucher_master.credit_total";
                }
                elseif($filtersRow['field'] == 'remarks')
                {
                    $field 	= "fi_general_voucher_master.remarks";
                }

                //$field 	= $filtersRow['field'];
                $op 	= $filtersRow['op'];
             /*   if($filtersRow['field'] == 'transaction_date'){
                    $data= date("Y-m-d", strtotime($filtersRow['data']));
                }
               else{*/
                   $data 	= $filtersRow['data'];
               //}



                $generalVouchers->where($field, $op,$data);
            }
        }
        if(!empty($orderBy) && !empty($sord)){
            $generalVouchers->orderBy($orderBy, $sord);
        }

        $generalVouchers->offset($offset);

        $generalVouchers->limit($limit);
        $generalVouchers = $generalVouchers->get();

        $data = array();
        if(!empty($generalVouchers)){
            $sno = 1;

            foreach($generalVouchers as $generalVoucher){

                $updateUrl = url("finance/General-Voucher/edit/".$generalVoucher->id);
                $viewUrl = url("finance/General-Voucher/view/".$generalVoucher->id);
                $deleteUrl = url("finance/General-Voucher/delete/".$generalVoucher->id);

                $ViewBtn = "<a onclick=editmaintenancerequest('".$viewUrl."','view') class='viewproduct custom-btn-view bgcolr-aqua'style='cursor: pointer;display: inline-block;margin-right: 5px;margin-left: 2px;' >View</a> ";

                if (Common::userwisepermission(Auth::user()->id, "General Voucher Update")) {
                    $EditBtn = "<a onclick=editmaintenancerequest('".$updateUrl."','update') class='viewproduct custom-btn-view bgcolr-orange'style='cursor: pointer;display: inline-block;margin-right: 4px;margin-left: 0px;' >Update</a> ";
                }
                else{
                    $EditBtn = "";
                }
                if (Common::userwisepermission(Auth::user()->id, "General Voucher Cancel")) {
                    $DeleteBtn = "<a onclick=editmaintenancerequest('".$deleteUrl."','cancel') class='viewproduct custom-btn-view bgcolr-aqua'style='cursor: pointer;display: inline-block;margin-right: 2px;margin-left: 0px;' >Delete </a> ";
                }
                else{
                    $DeleteBtn = "";
                }
                
                $action = $ViewBtn.$EditBtn.$DeleteBtn;


                $data[] = array(
                    "id"                  =>    $generalVoucher->id,
                    "transaction_date"    =>    $generalVoucher->transaction_date,
                    "due_date"            =>    $generalVoucher->due_date,
                    "debit_total"         =>    $generalVoucher->debit_total,
                    "credit_total"        =>    $generalVoucher->credit_total,
                    "remarks"             =>    $generalVoucher->remarks,
                    'action_column'		  =>	$action
                );

                $sno++;
            }
        }

        return $data;


    }
}
