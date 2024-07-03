<?php

namespace App\Http\Controllers;

use App\Model\CostCenterManagment\CostCenterDataRepository;
use Illuminate\Http\Request;
use Mgallegos\LaravelJqgrid\Facades\GridEncoder;
use App\Model\Dashboard\MaintenancerequestDataRepositery;
use App\Model\Dashboard\ProjectwiseDataRepositery;
use App\Model\Dashboard\SchedulewiseDataRepositery;
use Illuminate\Support\Facades\Input;
use DB;
use App\Model\CostCenterManagment\CostCenter;

class CostCenterController extends Controller
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
        return view('costcenter.index');
    }    

public function create()
    {
        return view('costcenter.create');
    }   
public function CustomerGridData()
    {   
     GridEncoder::encodeRequestedData(new CostCenterDataRepository(), Input::all());
    }

public function store(Request $request)
    {
        $costcenter = new CostCenter();
        $costcenter->name = $request->name;
        $costcenter->phone_no = $request->phone_no;
        $costcenter->address = $request->address;
        $costcenter->save();

        return redirect('setup/costcenter');
    
    }


public function edit($id)
{
    $customer = CostCenter::where('id', $id)->first();
    return view('costcenter.edit', compact('customer'));
}   


public function update(Request $request, $id)
{
        $customer = CostCenter::findOrfail($id);

        $customer->name = $request->name;
        $customer->phone_no = $request->phone_no;
        $customer->address = $request->address;

        $customer->save();

        return redirect('setup/costcenter');


}   


 public function destroyview($id)
    {
        $customer =  CostCenter::where('id', $id)->first();
        return view('costcenter.delete', compact('customer'));

        

    }

 public function destroy(Request $request, $id)
    {
        $alert = CostCenter::findOrfail($id);

        $alert->delete();

        return redirect('setup/costcenter');

        }

}
