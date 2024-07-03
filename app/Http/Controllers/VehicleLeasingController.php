<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\VehicleLeasing\VehicleLeasingDataRepository;
use Mgallegos\LaravelJqgrid\Facades\GridEncoder;
use Illuminate\Support\Facades\Input;
use DB, Auth;
use App\Helper\Common;

use App\Model\VehicleLeasing\VehicleLeasing;
use App\Model\VehiclesManagment\Vehicles;
use App\Model\ChartofAccount\chartofaccount;


class VehicleLeasingController extends Controller
{
    public function VehicleLeasingHome()
    {
        return view('VehicleLeasing.index');
    }
    public function VehicleLeasingGridData()
    {
        GridEncoder::encodeRequestedData(new VehicleLeasingDataRepository(), Input::all());
    }

    public function VehicleLeasingCreate()
    {
        $vehicles = Vehicles::select('id','vehicle_no','lease_amount')->get();
        $coa = chartofaccount::all();
        return view('VehicleLeasing.create', compact('vehicles','coa'));
    }

    public function VehicleLeasingSave(Request $request)
    {
        $date_paid = $request->input('date_paid');
        $vehicle = $request->input('vehicle');
        $vehicle_lease_amount = Vehicles::find($vehicle)->lease_amount;
        
        $coa = $request->input('coa_list');
        $VehicleLeasing = new VehicleLeasing();
            $VehicleLeasing->vehicle_id = $vehicle;
            $VehicleLeasing->amount = $vehicle_lease_amount;
            $VehicleLeasing->coa_id = $coa;
            $VehicleLeasing->paid_date = $date_paid;
            $VehicleLeasing->created_at = date('Y-m-d H:i:s');
            $VehicleLeasing->created_by = Auth::User()->id;
        $VehicleLeasing->save();
        return redirect('/Finance/Vehicle-Leasing');

    }

    public function VehicleLeasingEdit($id)
    {
        $VehicleLeasing = VehicleLeasing::find($id);
        $vehicles = Vehicles::select('id','vehicle_no','lease_total')->get();
        $coa = chartofaccount::all();
        return view('VehicleLeasing.edit', compact('vehicles','coa','VehicleLeasing'));
    }

    public function VehicleLeasingUpdate(Request $request)
    {
        $lease_id = $request->input('lease_id');
        $date_paid = $request->input('date_paid');
        $vehicle = $request->input('vehicle');
        $vehicle_lease_amount = $request->input('vehicle_lease_amount');
        $coa = $request->input('coa_list');

        $VehicleLeasing = VehicleLeasing::find($lease_id);

            $VehicleLeasing->paid_date = $date_paid;
            $VehicleLeasing->updated_at = date('Y-m-d H:i:s');
            $VehicleLeasing->updated_by = Auth::User()->id;
        $VehicleLeasing->save();
        return redirect('/Finance/Vehicle-Leasing');
    }
    
    public function VehicleLeasingDelete($id)
    {
        return view('VehicleLeasing.delete', compact('id'));
    }
    
    public function VehicleLeasingDeleted(Request $request)
    { 

        VehicleLeasing::find($request->input('lease_id'))->delete();
        return redirect('/Finance/Vehicle-Leasing');
    }

    
}
