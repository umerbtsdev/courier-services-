<?php

namespace App\Model\Invoices;

use App\Model\Invoices\invoices;;
use Illuminate\Database\Eloquent\Model;
use Mgallegos\LaravelJqgrid\Repositories\EloquentRepositoryAbstract;
use DB,Auth;
use App\Helper\Common;

class invoicesDataRepository extends EloquentRepositoryAbstract
{
    public function getTotalNumberOfRows(array $filters = array())
    {
        $Invoices = invoices::join('cost_center','invoices_master.cost_center_id','=','cost_center.id')
        ->join('customer','invoices_master.client_id','=','customer.id')
        ->join('vehicles','invoices_master.vehicle_id','=','vehicles.id')
        ->leftjoin('users','invoices_master.created_by','=','users.id')
        ->leftjoin('users as user_updated','invoices_master.updated_by','=','user_updated.id')
        ->select(
            'invoices_master.id',
            'cost_center.name as cost_center_name',
            'customer.name as client_name',
            'vehicles.vehicle_no',
            'invoices_master.date_from',
            'invoices_master.grand_total',
            'invoices_master.total_reading',
            'invoices_master.total_working_days',
            'invoices_master.days_worked',
            'invoices_master.created_by',
            'invoices_master.created_at',
            'invoices_master.created_at as invoices_created_at',
            'invoices_master.updated_at as invoices_updated_at',
            'users.name as created_by',
            'user_updated.name as updated_by'
    );

        if(!empty($filters)){
            foreach($filters as $filtersRow){

                $field 	= $filtersRow['field'];
                if($filtersRow['field'] == 'cost_center_name'){
                    $field 	= 'cost_center.name';
                }
                else if($filtersRow['field'] == 'client_name'){
                    $field 	= 'customer.name';
                }
                else if($filtersRow['field'] == 'vehicle_no'){
                    $field 	= 'vehicles.vehicle_no';
                }
                else if($filtersRow['field'] == 'date_from'){
                    $field 	= 'invoices_master.date_from';
                }
                else if($filtersRow['field'] == 'date_to'){
                    $field 	= 'invoices_master.date_to';
                }
                $op 		= $filtersRow['op'];
                $data 	= $filtersRow['data'];

                $Invoices->where($field, $op,$data);
            }
        }

        return $Invoices->count();

    }

    public function getRows($limit, $offset, $orderBy = null, $sord = null, array $filters = array(),$nodeId = null, $nodeLevel = null,$exporting)
    {
        $Invoices = invoices::join('cost_center','invoices_master.cost_center_id','=','cost_center.id')
        ->join('customer','invoices_master.client_id','=','customer.id')
        ->join('vehicles','invoices_master.vehicle_id','=','vehicles.id')
        ->leftjoin('users','invoices_master.created_by','=','users.id')
        ->leftjoin('users as user_updated','invoices_master.updated_by','=','user_updated.id')
        ->select(
            'invoices_master.id',
            'cost_center.name as cost_center_name',
            'customer.name as client_name',
            'vehicles.vehicle_no',
            'invoices_master.date_from',
            'invoices_master.date_to',
            'invoices_master.created_at as invoices_created_at',
            'invoices_master.updated_at as invoices_updated_at',
            'users.name as created_by',
            'user_updated.name as updated_by',
            'invoices_master.grand_total',
            'invoices_master.total_reading',
            'invoices_master.total_working_days',
            'invoices_master.days_worked'
    );


        if(!empty($filters)){
            foreach($filters as $filtersRow){

                $field 	= $filtersRow['field'];

                if($filtersRow['field'] == 'cost_center_name'){
                    $field 	= 'cost_center.name';
                }
                else if($filtersRow['field'] == 'client_name'){
                    $field 	= 'customer.name';
                }
                else if($filtersRow['field'] == 'vehicle_no'){
                    $field 	= 'vehicles.vehicle_no';
                }
                else if($filtersRow['field'] == 'date_from'){
                    $field 	= 'invoices_master.date_from';
                }
                else if($filtersRow['field'] == 'date_to'){
                    $field 	= 'invoices_master.date_to';
                }
                $op 		= $filtersRow['op'];
                $data 	= $filtersRow['data'];

                $Invoices->where($field, $op,$data);
            }
        }

        if(!empty($orderBy) && !empty($sord)){
            $Invoices->orderBy($orderBy, $sord);
        }

        $Invoices->offset($offset);

        $Invoices->limit($limit);
        $Invoices = $Invoices->get();

        $data = array();
        if(!empty($Invoices)){
            $sno = 1;

            foreach($Invoices as $invoice) {
                $rolesColumn    = '';
                $actionColumn   = "";
                $actionUrl    = url("/Transactions/Customer-Inovices/view/".$invoice->id);
                $actionUrlDel = url("/Transactions/Customer-Inovices/delete/".$invoice->id);
                if (Common::userwisepermission(Auth::user()->id, "Customer Invoices View")) {
                    $EditBtn = "<a onclick=editmaintenancerequest('".$actionUrl."','view') class='custom-btn-action custom-btn-view  bgcolr-aqua'>View</a>";
            }                                                     
                else{
                    $EditBtn = "";
                }
                if (Common::userwisepermission(Auth::user()->id, "Customer Invoices Cancel")) {
                    $deleteBtn = "<a onclick=editmaintenancerequest('".$actionUrlDel."', 'cancel') class='custom-btn-action custom-btn-view bgcolr-orange'>Cancel</a>";
                }
                else{
                    $deleteBtn = '';
                }
                $data[] = array(
                    'id'					    =>	$invoice->id,
                    'cost_center_name'          =>  $invoice->cost_center_name,
                    'client_name'               =>  $invoice->client_name,
                    'vehicle_no'                =>  $invoice->vehicle_no,
                    'date_from'                 =>  $invoice->date_from,
                    'date_to'                   =>  $invoice->date_to,
                    'invoices_created_at'       =>  $invoice->invoices_created_at,
                    'created_by'                =>  $invoice->created_by,
                    'invoices_updated_at'       =>  $invoice->invoices_updated_at,
                    'updated_by'                =>  $invoice->updated_by,
                    'action'                    =>  $EditBtn.$deleteBtn,

                    'grand_total'               => $invoice->grand_total,
                    'total_reading'             => $invoice->total_reading,
                    'total_working_days'        => $invoice->total_working_days,
                    'days_worked'               => $invoice->days_worked,
                );
                $sno++;
            }
        }

        return $data;
    }
}
