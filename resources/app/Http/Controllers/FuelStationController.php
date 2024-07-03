<?php

namespace App\Http\Controllers;

use App\Model\FuelStationManagment\FuelStation;
use App\Model\FuelStationManagment\FuelStationDataRepository;
use Illuminate\Http\Request;
use Mgallegos\LaravelJqgrid\Facades\GridEncoder;
use Illuminate\Support\Facades\Input;
use DB;
use App\Model\CostCenterManagment\CostCenter;

class FuelStationController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    // public function __construct()
    // {
    //     $this->middleware('auth');
    // }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
public function index()
    {
        return view('fuelstation.index');
    }    

public function create()
    {
        return view('fuelstation.create');
    }   
public function CustomerGridData()
    {   
     GridEncoder::encodeRequestedData(new FuelStationDataRepository(), Input::all());
    }

public function store(Request $request)
    {
        $fuelstation = new FuelStation();
        $fuelstation->name = $request->name;
        $fuelstation->phone_no = $request->phone_no;
        $fuelstation->address = $request->address;
        $fuelstation->save();

        return redirect('General-Setup/fuelstationinfo');
    
    }


public function edit($id)
{
    $fuelstation = FuelStation::where('id', $id)->first();
    return view('fuelstation.edit', compact('fuelstation'));
}   


public function update(Request $request, $id)
{
    $fuelstation = FuelStation::findOrfail($id);

    $fuelstation->name = $request->name;
    $fuelstation->phone_no = $request->phone_no;
    $fuelstation->address = $request->address;

    $fuelstation->save();

        return redirect('General-Setup/fuelstationinfo');


}   


 public function destroyview($id)
    {
        $customer =  FuelStation::where('id', $id)->first();
        return view('fuelstation.delete', compact('customer'));

        

    }

 public function destroy(Request $request, $id)
    {
        $alert = FuelStation::findOrfail($id);

        $alert->delete();

        return redirect('General-Setup/fuelstationinfo');

        }

}
