<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\DepreciationsPaid\DepreciationsPaid;
use App\Model\DepreciationsPaid\DepreciationsPaidDataRepository;
use Mgallegos\LaravelJqgrid\Facades\GridEncoder;
use App\Model\VehiclesManagment\Vehicles;
use App\Model\ChartofAccount\chartofaccount;
use Auth,DB, Session;
use Illuminate\Support\Facades\Input;
use App\Helper\Common;

class DepreciationsPaidController extends Controller
{
    public function DepreciationsPaidHome()
    {
        
        return view('DepriciationsPaid.index');
    }
    public function DepreciationsPaidGridData()
    {
        GridEncoder::encodeRequestedData(new DepreciationsPaidDataRepository(), Input::all());
    }
     
    public function DepreciationsPaidCreate()
    {
        $vehicles = Vehicles::select('id','vehicle_no','purchase_amount','life','coa_id')
        //->where('deperciation_total','<=','purchase_amount')
        ->where(DB::raw('IFNULL(vehicles.purchase_amount,0)'),'>',DB::raw('IFNULL(vehicles.deperciation_total,0)'))
        ->get();
        $coa = chartofaccount::all();
        
        
        return view('DepriciationsPaid.create', compact('vehicles','coa'));
    }
    public function DepreciationsPaidSave(Request $request)
    {
        $date_paid = $request->input('date_paid');
        $vehicle = $request->input('vehicle');
        $vehicleData = Vehicles::find($vehicle);
        $purchase_amount = $vehicleData->purchase_amount;
        $life = $vehicleData->life;
        $vehicle_depriciation_amount = $purchase_amount / $life;
            $vehicle_coa = $request->input('vehicle_coa');
        $oldDeprication = $vehicleData->deperciation_total;
        
        $newDepriciation = $oldDeprication + $vehicle_depriciation_amount;
        if($newDepriciation <= $purchase_amount){

            $coa = $request->input('coa_list');
            $DepreciationsPaid = new DepreciationsPaid();
                $DepreciationsPaid->vehicle_id = $vehicle;
                $DepreciationsPaid->amount = $vehicle_depriciation_amount;
                $DepreciationsPaid->coa_id = $coa;
                $DepreciationsPaid->paid_date = $date_paid;
                $DepreciationsPaid->created_at = date('Y-m-d H:i:s');
                $DepreciationsPaid->created_by = Auth::User()->id;
            $DepreciationsPaid->save();

            
            $vehicleData->deperciation_total = $newDepriciation;
            $vehicleData->save();


            //Debit first
            Common::makeTransaction($vehicle_coa,"depreciation",$DepreciationsPaid->id,$newDepriciation,$date_paid,"debit");


            Common::makeTransaction($coa,"depreciation",$DepreciationsPaid->id,$newDepriciation,$date_paid,'credit');
            
            $msg = "Depreciation Payment Added";
            $type= "success";
        }
        else{
            $msg = "All Depreciations have been paid";
            $type= "danger";
           
        }
        Session::flash('msg', $msg);
        Session::flash('msgtype', $type);
        return redirect('/Finance/Depreciations-Paid');
    }

    public function DepreciationsPaidEdit($id)
    {
        $DepreciationsPaid = DepreciationsPaid::join('vehicles','depreciations_paid.vehicle_id','=','vehicles.id')
        ->join('fi_chartofaccount','depreciations_paid.coa_id','=','fi_chartofaccount.id')
        ->select(
            'depreciations_paid.amount',
            'depreciations_paid.paid_date',
            'vehicles.vehicle_no',
            'fi_chartofaccount.name'
        )
        ->where('depreciations_paid.id','=',$id)
        ->first();

        return view('DepriciationsPaid.edit', compact('DepreciationsPaid','id'));
    }

    public function DepreciationsPaidUpdate(Request $request)
    {
        $DepreciationsPaidID = $request->input('DepreciationsPaidID');
        $date_paid = $request->input('date_paid');
        $vehicle = $request->input('car');
        $DepreciationsPaid = DepreciationsPaid::find($DepreciationsPaidID);
            $DepreciationsPaid->paid_date = $date_paid;
            $DepreciationsPaid->updated_at = date('Y-m-d H:i:s');
            $DepreciationsPaid->updated_by = Auth::User()->id;
        $DepreciationsPaid->save();

        Common::updateTransaction($DepreciationsPaid->id,$date_paid,"debit");
        Common::updateTransaction($DepreciationsPaid->id,$date_paid,"credit");


        Session::flash('msg', "Transaction date of Depreciation on ".$vehicle." has been Updated");
        Session::flash('msgtype', "success");
        return redirect('/Finance/Depreciations-Paid');
    }

    public function DepreciationsPaidDelete($id)
    {
        return view('DepriciationsPaid.delete', compact('id'));
    }


    public function DepreciationsPaidDeleted(Request $request)
    {
        $depreciation_id = $request->input('depreciation_id');

        $DepreciationsPaid = DepreciationsPaid::find($depreciation_id);
        
        $Vehicles = Vehicles::find($DepreciationsPaid->vehicle_id);
                $oldDeperciation = $Vehicles->deperciation_total;
                $newDeperciation = intval($oldDeperciation) - intval($DepreciationsPaid->amount);
            $Vehicles->deperciation_total = $newDeperciation;
        $Vehicles->save();

        Common::deleteTransaction($depreciation_id);

        $DepreciationsPaid->delete();

        return redirect('/Finance/Depreciations-Paid');

    }
}
