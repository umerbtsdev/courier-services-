<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Mgallegos\LaravelJqgrid\Facades\GridEncoder;
use App\Model\Dashboard\MaintenancerequestDataRepositery;
use App\Model\Dashboard\ProjectwiseDataRepositery;
use App\Model\Dashboard\SchedulewiseDataRepositery;
use App\Model\AlertManagment\AlertDataRepository;
use Illuminate\Support\Facades\Input;
use DB;
use App\Model\AlertManagment\Alert;

class AlertController extends Controller
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
        return view('alert.index');
    }     

       public function create()
    {
        return view('alert.create');
    }   
    public function AlertGridData()
    {   
     GridEncoder::encodeRequestedData(new AlertDataRepository(), Input::all());
    }

    public function store(Request $request)
    {

        $alert = new Alert();
        $alert->name = $request->name;
        $alert->description = $request->discrp;
        $alert->save();

        return redirect('General-Setup/alertinfo');
    
    }


public function edit($alert_id)
{
    $alert = Alert::select('id','name', 'description')->where('id', $alert_id)->first();
    return view('alert.edit', compact('alert'));
}   


public function update(Request $request, $alert_id)
{   

        if(empty($request->name) || empty($request->descrp)){
      
            return redirect('alert/edit/'.$alert_id);
        }else{
   
        $alert = Alert::findOrfail($alert_id);

        $alert->name = $request->name;
        $alert->description = $request->descrp;

        $alert->save();

        return redirect('General-Setup/alertinfo');

        }
}   


 public function destroyview($alert_id)
    {
        $alert =  Alert::select('id','name', 'description')->where('id', $alert_id)->first();
        return view('alert.delete', compact('alert'));

        

    }


 public function destroy(Request $request, $alert_id)
    {
        $alert = Alert::findOrfail($alert_id);

        $alert->delete();

        return redirect('General-Setup/alertinfo');

        }

  
//render the product grid data
    public function Maintenancereqpendinggriddata()
    {
        GridEncoder::encodeRequestedData(new MaintenancerequestDataRepositery(), Input::all());
    }

    //render the product grid data
    public function Projectwisegriddata()
    {
        GridEncoder::encodeRequestedData(new ProjectwiseDataRepositery(), Input::all());
    }

    //render the product grid data
    public function Schedulewisegriddata()
    {
        GridEncoder::encodeRequestedData(new SchedulewiseDataRepositery(), Input::all());
    }

}
