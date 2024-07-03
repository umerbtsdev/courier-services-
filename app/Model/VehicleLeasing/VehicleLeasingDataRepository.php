<?php

namespace App\Model\VehicleLeasing;

use Illuminate\Database\Eloquent\Model;
use Mgallegos\LaravelJqgrid\Repositories\EloquentRepositoryAbstract;
use DB,Auth;
use App\Helper\Common;
use App\Model\VehiclesManagment\Vehicles;
use App\Model\VehicleLeasing\VehicleLeasing;
class VehicleLeasingDataRepository extends EloquentRepositoryAbstract
{
    public function getTotalNumberOfRows(array $filters = array())
    {
        $VehicleLeases = VehicleLeasing::join('vehicles','vehicle_leasing.vehicle_id','=','vehicles.id')
        ->leftjoin('users','vehicle_leasing.created_by','=','users.id')
        ->leftjoin('users as user_updated','vehicle_leasing.updated_by','=','user_updated.id')
        ->select(
           'vehicles.vehicle_no',
           'vehicle_leasing.id',
           'vehicle_leasing.amount',
           'vehicle_leasing.paid_date',
           'vehicle_leasing.created_at',
           'vehicle_leasing.updated_at',
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

                $VehicleLeases->where($field, $op,$data);
            }
        }

        return $VehicleLeases->count();

    }
    public function getRows($limit, $offset, $orderBy = null, $sord = null, array $filters = array(),$nodeId = null, $nodeLevel = null,$exporting)
    {

        $VehicleLeases = VehicleLeasing::join('vehicles','vehicle_leasing.vehicle_id','=','vehicles.id')
        ->leftjoin('users','vehicle_leasing.created_by','=','users.id')
        ->leftjoin('users as user_updated','vehicle_leasing.updated_by','=','user_updated.id')
        ->select(
           'vehicles.vehicle_no',
           'vehicle_leasing.id',
           'vehicle_leasing.amount',
           'vehicle_leasing.paid_date',
           'vehicle_leasing.created_at',
           'vehicle_leasing.updated_at',
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

                $VehicleLeases->where($field, $op,$data);
            }
        }

        if(!empty($orderBy) && !empty($sord)){
            $VehicleLeases->orderBy($orderBy, $sord);
        }

        $VehicleLeases->offset($offset);

        $VehicleLeases->limit($limit);
        $VehicleLeases = $VehicleLeases->get();

        $data = array();
        if(!empty($VehicleLeases)){
            $sno = 1;

            foreach($VehicleLeases as $VehicleLease) {
                $rolesColumn    = '';
                $actionColumn   = "";
                $EditUrl    = url("/Finance/Vehicle-Leasing/edit/".$VehicleLease->id);
                $DelUrl = url("/Finance/Vehicle-Leasing/delete/".$VehicleLease->id);
                if(Common::userwisepermission(Auth::user()->id, "Vehicle Leasing Update")) {
                
                    $EditBtn = "<a onclick=editmaintenancerequest('".$EditUrl."','edit') class='custom-btn-action custom-btn-view  bgcolr-aqua'>Update</a>";
                }                                                     
                else{
                    $EditBtn = "";
                }
                if (Common::userwisepermission(Auth::user()->id, "Vehicle Leasing Cancel")) {
                    $deleteBtn = "<a onclick=editmaintenancerequest('".$DelUrl."','cancel') class='custom-btn-action custom-btn-view bgcolr-orange'>Cancel</a>";
                }
                else{
                    $deleteBtn = '';
                }
                $data[] = array(
                    'id'					    =>	$VehicleLease->id,
                    'action'					=>	$EditBtn.$deleteBtn,
                    'vehicle_no'                =>  $VehicleLease->vehicle_no,
                    'paid_amount'               =>  $VehicleLease->amount,
                    'paid_date'                 =>  $VehicleLease->paid_date,
                    'created_at'                =>  $VehicleLease->created_at,
                    'updated_at'                =>  $VehicleLease->updated_at,
                    'lease_created_by'          =>  $VehicleLease->lease_created_by,
                    'lease_updated_by'          =>  $VehicleLease->lease_updated_by,


                );
                $sno++;
            }
        }

        return $data;
    }
}
