<?php

namespace App\Model\DepreciationsPaid;

use Illuminate\Database\Eloquent\Model; 
use Mgallegos\LaravelJqgrid\Repositories\EloquentRepositoryAbstract;
use DB,Auth;
use App\Helper\Common;
use App\Model\DepreciationsPaid\DepreciationsPaid;

class DepreciationsPaidDataRepository extends EloquentRepositoryAbstract
{
    public function getTotalNumberOfRows(array $filters = array())
    {
        $DepreciationsPaid = DepreciationsPaid::join('vehicles','depreciations_paid.vehicle_id','=','vehicles.id')
        ->leftjoin('users','depreciations_paid.created_by','=','users.id')
        ->leftjoin('users as user_updated','depreciations_paid.updated_by','=','user_updated.id')
        ->select(
           'vehicles.vehicle_no',
           'depreciations_paid.id',
           'depreciations_paid.amount',
           'depreciations_paid.paid_date',
           'depreciations_paid.created_at',
           'depreciations_paid.updated_at',
           'users.name as lease_created_by',
           'user_updated.name as lease_updated_by'
        );

        if(!empty($filters)){
            foreach($filters as $filtersRow){

                $field 	= $filtersRow['field'];
                if($filtersRow['field'] == 'vehicle_no'){
                    $field 	= 'vehicles.vehicle_no';
                }
                
                $op 		= $filtersRow['op'];
                $data 	= $filtersRow['data'];

                $DepreciationsPaid->where($field, $op,$data);
            }
        }

        return $DepreciationsPaid->count();

    }
    public function getRows($limit, $offset, $orderBy = null, $sord = null, array $filters = array(),$nodeId = null, $nodeLevel = null,$exporting)
    {

        $DepreciationsPaid = DepreciationsPaid::join('vehicles','depreciations_paid.vehicle_id','=','vehicles.id')
        ->leftjoin('users','depreciations_paid.created_by','=','users.id')
        ->leftjoin('users as user_updated','depreciations_paid.updated_by','=','user_updated.id')
        ->select(
           'vehicles.vehicle_no',
           'depreciations_paid.id',
           'depreciations_paid.amount',
           'depreciations_paid.paid_date',
           'depreciations_paid.created_at',
           'depreciations_paid.updated_at',
           'users.name as DepreciationPaid_created_by',
           'user_updated.name as DepreciationPaid_updated_by'
        );

        if(!empty($filters)){
            foreach($filters as $filtersRow){

                $field 	= $filtersRow['field'];

                if($filtersRow['field'] == 'vehicle_no'){
                    $field 	= 'vehicles.vehicle_no';
                }
                
                $op 		= $filtersRow['op'];
                $data 	= $filtersRow['data'];

                $DepreciationsPaid->where($field, $op,$data);
            }
        }

        if(!empty($orderBy) && !empty($sord)){
            $DepreciationsPaid->orderBy($orderBy, $sord);
        }

        $DepreciationsPaid->offset($offset);

        $DepreciationsPaid->limit($limit);
        $DepreciationsPaid = $DepreciationsPaid->get();

        $data = array();
        if(!empty($DepreciationsPaid)){
            $sno = 1;

            foreach($DepreciationsPaid as $DepreciationPaid) {
                $rolesColumn    = '';
                $actionColumn   = "";
                $EditUrl    = url("/Finance/Depreciations-Paid/edit/".$DepreciationPaid->id);
                $DelUrl = url("/Finance/Depreciations-Paid/delete/".$DepreciationPaid->id);
                if(Common::userwisepermission(Auth::user()->id, "Depreciations Paid Update")) {
                
                    $EditBtn = "<a onclick=editmaintenancerequest('".$EditUrl."','edit') class='custom-btn-action custom-btn-view  bgcolr-aqua'>Update</a>";
                }                                                     
                else{
                    $EditBtn = "";
                }
                if (Common::userwisepermission(Auth::user()->id, "Depreciations Paid Cancel")) {
                    $deleteBtn = "<a onclick=editmaintenancerequest('".$DelUrl."','cancel') class='custom-btn-action custom-btn-view bgcolr-orange'>Cancel</a>";
                }
                else{
                    $deleteBtn = '';
                }
                $data[] = array(
                    'id'					    =>	$DepreciationPaid->id,
                    'action'					=>	$EditBtn.$deleteBtn,
                    'vehicle_no'                =>  $DepreciationPaid->vehicle_no,
                    'paid_amount'               =>  $DepreciationPaid->amount,
                    'paid_date'                 =>  $DepreciationPaid->paid_date,
                    'created_at'                =>  $DepreciationPaid->created_at,
                    'updated_at'                =>  $DepreciationPaid->updated_at,
                    'lease_created_by'          =>  $DepreciationPaid->DepreciationPaid_created_by,
                    'lease_updated_by'          =>  $DepreciationPaid->DepreciationPaid_updated_by,


                );
                $sno++;
            }
        }

        return $data;
    }
}
