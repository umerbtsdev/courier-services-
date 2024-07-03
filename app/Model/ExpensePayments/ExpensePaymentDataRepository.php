<?php

namespace App\Model\ExpensePayments;

use Illuminate\Database\Eloquent\Model;
use Mgallegos\LaravelJqgrid\Repositories\EloquentRepositoryAbstract;
use DB,Auth;
use App\Helper\Common;
use App\Model\ExpensePayments\ExpensePayment;

class ExpensePaymentDataRepository extends EloquentRepositoryAbstract
{
    public function getTotalNumberOfRows(array $filters = array())
    {
        $ExpensePayment = ExpensePayment::leftjoin('invoices_master','expense_payment.invoice_id','=','invoices_master.id')
        ->leftjoin('vehicles','invoices_master.vehicle_id','=','vehicles.id')
        ->leftjoin('users','expense_payment.created_by','=','users.id')
        ->leftjoin('users as user_updated','expense_payment.updated_by','=','user_updated.id')
        ->select(
           'vehicles.vehicle_no',
           'expense_payment.id',
           'expense_payment.invoice_id',
           'expense_payment.total_expense',
           'expense_payment.paid_date',
           'expense_payment.created_at',
           'expense_payment.updated_at',
           'users.name as expense_payment_by',
           'user_updated.name as expense_payment_by'
        );

        if(!empty($filters)){
            foreach($filters as $filtersRow){

                $field 	= $filtersRow['field'];
                if($filtersRow['field'] == 'vehicle_no'){
                    $field 	= 'vehicles.vehicle_no';
                }
                else if($filtersRow['field'] == 'invoice_id'){
                    $field 	= 'expense_payment.invoice_id';
                }
                
                $op 	= $filtersRow['op'];
                $data 	= $filtersRow['data'];

                $ExpensePayment->where($field, $op,$data);
            }
        }

        return $ExpensePayment->count();

    }
    public function getRows($limit, $offset, $orderBy = null, $sord = null, array $filters = array(),$nodeId = null, $nodeLevel = null,$exporting)
    {

        $ExpensePayment = ExpensePayment::leftjoin('invoices_master','expense_payment.invoice_id','=','invoices_master.id')
        ->leftjoin('vehicles','invoices_master.vehicle_id','=','vehicles.id')
        ->leftjoin('users','expense_payment.created_by','=','users.id')
        ->leftjoin('users as user_updated','expense_payment.updated_by','=','user_updated.id')
        ->select(
           'vehicles.vehicle_no',
           'expense_payment.id',
           'expense_payment.invoice_id',
           'expense_payment.total_expense',
           'expense_payment.paid_date',
           'expense_payment.created_at',
           'expense_payment.updated_at',
           'users.name as ExpensePayment_created_by',
           'user_updated.name as ExpensePayment_updated_by'
        );

        if(!empty($filters)){
            foreach($filters as $filtersRow){

                $field 	= $filtersRow['field'];

                if($filtersRow['field'] == 'vehicle_no'){
                    $field 	= 'vehicles.vehicle_no';
                }
                
                $op 		= $filtersRow['op'];
                $data 	= $filtersRow['data'];

                $ExpensePayment->where($field, $op,$data);
            }
        }

        if(!empty($orderBy) && !empty($sord)){
            $ExpensePayment->orderBy($orderBy, $sord);
        }

        $ExpensePayment->offset($offset);

        $ExpensePayment->limit($limit);
        $ExpensesPayment = $ExpensePayment->get();

        $data = array();
        if(!empty($ExpensesPayment)){
            $sno = 1;

            foreach($ExpensesPayment as $ExpensePayment) {
                $rolesColumn    = '';
                $actionColumn   = "";
                $EditUrl    = url("/Finance/Expense-Payment/edit/".$ExpensePayment->id);
                $DelUrl = url("/Finance/Expense-Payment/delete/".$ExpensePayment->id);
                if(Common::userwisepermission(Auth::user()->id, "Expense Payment Update")) {
                
                    $EditBtn = "<a onclick=editmaintenancerequest('".$EditUrl."','edit') class='custom-btn-action custom-btn-view  bgcolr-aqua'>Update</a>";
                }                                                     
                else{
                    $EditBtn = "";
                }
                if (Common::userwisepermission(Auth::user()->id, "Expense Payment Cancel")) {
                    $deleteBtn = "<a onclick=editmaintenancerequest('".$DelUrl."','cancel') class='custom-btn-action custom-btn-view bgcolr-orange'>Cancel</a>";
                }
                else{
                    $deleteBtn = '';
                }
                $data[] = array(
                    'id'					    =>	$ExpensePayment->id,
                    'action'					=>	$EditBtn.$deleteBtn,
                    'invoice_id'                =>  $ExpensePayment->invoice_id,
                    'total_expense'             =>  $ExpensePayment->total_expense,
                    'paid_date'                 =>  $ExpensePayment->paid_date,
                    'created_at'                =>  $ExpensePayment->created_at,
                    'updated_at'                =>  $ExpensePayment->updated_at,
                    'ExpensePayment_created_by'          =>  $ExpensePayment->ExpensePayment_created_by,
                    'ExpensePayment_updated_by'          =>  $ExpensePayment->ExpensePayment_updated_by,


                );
                $sno++;
            }
        }

        return $data;
    }
}
