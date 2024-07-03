<?php

namespace App\Model\InvoiceReceivables;

use Illuminate\Database\Eloquent\Model;
use Mgallegos\LaravelJqgrid\Repositories\EloquentRepositoryAbstract;
use DB,Auth;
use App\Helper\Common;
use App\Model\InvoiceReceivables\InvoiceReceivables;
class InvoiceReceivablesDataRepository extends EloquentRepositoryAbstract
{
    public function getTotalNumberOfRows(array $filters = array())
    {
        $InvoiceReceivables = InvoiceReceivables::join('invoices_master','invoice_receivables.invoice_id','=','invoices_master.id')
        ->join('vehicles','invoices_master.vehicle_id','=','vehicles.id')
        ->leftjoin('users','invoice_receivables.created_by','=','users.id')
        ->leftjoin('users as user_updated','invoice_receivables.updated_by','=','user_updated.id')
        ->select(
           'vehicles.vehicle_no',
           'invoice_receivables.id',
           'invoice_receivables.invoice_id',
           'invoice_receivables.total_paid',
           'invoice_receivables.paid_date',
           'invoice_receivables.created_at',
           'invoice_receivables.updated_at',
           'users.name as invoice_receivable_by',
           'user_updated.name as invoice_receivable_by'
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

                $InvoiceReceivables->where($field, $op,$data);
            }
        }

        return $InvoiceReceivables->count();

    }
    public function getRows($limit, $offset, $orderBy = null, $sord = null, array $filters = array(),$nodeId = null, $nodeLevel = null,$exporting)
    {

        $InvoiceReceivables = InvoiceReceivables::join('invoices_master','invoice_receivables.invoice_id','=','invoices_master.id')
        ->join('vehicles','invoices_master.vehicle_id','=','vehicles.id')
        ->leftjoin('users','invoice_receivables.created_by','=','users.id')
        ->leftjoin('users as user_updated','invoice_receivables.updated_by','=','user_updated.id')
        ->select(
           'vehicles.vehicle_no',
           'invoice_receivables.id',
           'invoice_receivables.invoice_id',
           'invoice_receivables.total_paid',
           'invoice_receivables.paid_date',
           'invoice_receivables.created_at',
           'invoice_receivables.updated_at',
           'users.name as invoice_receivable_created_by',
           'user_updated.name as invoice_receivable_updated_by'
        );

        if(!empty($filters)){
            foreach($filters as $filtersRow){

                $field 	= $filtersRow['field'];

                if($filtersRow['field'] == 'vehicle_no'){
                    $field 	= 'vehicles.vehicle_no';
                }
                
                $op 		= $filtersRow['op'];
                $data 	= $filtersRow['data'];

                $InvoiceReceivables->where($field, $op,$data);
            }
        }

        if(!empty($orderBy) && !empty($sord)){
            $InvoiceReceivables->orderBy($orderBy, $sord);
        }

        $InvoiceReceivables->offset($offset);

        $InvoiceReceivables->limit($limit);
        $InvoiceReceivables = $InvoiceReceivables->get();

        $data = array();
        if(!empty($InvoiceReceivables)){
            $sno = 1;

            foreach($InvoiceReceivables as $InvoiceReceivable) {
                $rolesColumn    = '';
                $actionColumn   = "";
                $EditUrl    = url("/Finance/Expense-Payment/edit/".$InvoiceReceivable->id);
                $DelUrl = url("/Finance/Expense-Payment/delete/".$InvoiceReceivable->id);
                if(Common::userwisepermission(Auth::user()->id, "Invoice Amount Receivable Update")) {
                
                    $EditBtn = "<a onclick=editmaintenancerequest('".$EditUrl."','edit') class='custom-btn-action custom-btn-view  bgcolr-aqua'>Update</a>";
                }                                                     
                else{
                    $EditBtn = "";
                }
                if (Common::userwisepermission(Auth::user()->id, "Invoice Amount Receivable Cancel")) {
                    $deleteBtn = "<a onclick=editmaintenancerequest('".$DelUrl."','cancel') class='custom-btn-action custom-btn-view bgcolr-orange'>Cancel</a>";
                }
                else{
                    $deleteBtn = '';
                }
                $data[] = array(
                    'id'					            =>	$InvoiceReceivable->id,
                    'action'					        =>	$EditBtn.$deleteBtn,
                    'invoice_id'                        =>  $InvoiceReceivable->invoice_id,
                    'total_paid'                        =>  $InvoiceReceivable->total_paid,
                    'paid_date'                         =>  $InvoiceReceivable->paid_date,
                    'created_at'                        =>  $InvoiceReceivable->created_at,
                    'updated_at'                        =>  $InvoiceReceivable->updated_at,
                    'invoice_receivable_created_by'     =>  $InvoiceReceivable->invoice_receivable_created_by,
                    'invoice_receivable_updated_by'     =>  $InvoiceReceivable->invoice_receivable_updated_by,


                );
                $sno++;
            }
        }

        return $data;
    }
}
