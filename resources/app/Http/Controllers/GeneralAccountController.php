<?php

namespace App\Http\Controllers;

use App\Model\GeneralAccount\Generalaccount;
use App\Model\GeneralAccount\GeneralAccountDataRepository;
use Illuminate\Http\Request;
use Mgallegos\LaravelJqgrid\Facades\GridEncoder;
use App\Model\Dashboard\ProjectwiseDataRepositery;
use App\Model\Dashboard\SchedulewiseDataRepositery;
use Illuminate\Support\Facades\Input;
use App\Model\ChartofAccount\chartofaccount;
use Auth,DB, Session;
// use App\Model\AlertManagment\Customer;

class GeneralAccountController extends Controller
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
        return view('generalaccount.index');
    }    

       public function create()
    {
        return view('generalaccount.create');
    }   
    public function AlertGridData()
    {   
        GridEncoder::encodeRequestedData(new GeneralAccountDataRepository(), Input::all());
    }

    public function store(Request $request)
    {
        $msg= "";
        $type="";
        $chartofaccount = chartofaccount::where('name','=',$request->name)->first();

        if ($chartofaccount != null) {
            $generalaccount = new Generalaccount();
            $generalaccount->name = $request->name;
            $generalaccount->type = $request->type;
            $generalaccount->coa_id = $chartofaccount->id;
            $generalaccount->save();
        }
        else{
           $msg = "Please make an account with name &#8216;".$request->name."&#8217; in <strong><u>chart of accounts</u></strong>";
           $type = "danger";
        }
        Session::flash('msg', $msg);
        Session::flash('msgtype', $type);
        return redirect('General-Setup/generalaccountinfo');
    
    }


public function edit($alert_id)
{
    $generalaccount = Generalaccount::select('id','name', 'type')->where('id', $alert_id)->first();
    return view('generalaccount.edit', compact('generalaccount'));
}   


public function update(Request $request, $alert_id)
{
    $msg= "";
    $type="";

    $chartofaccount = chartofaccount::where('name','=',$request->name)->first();
    if ($chartofaccount != null) {
        $generalaccount = Generalaccount::findOrfail($alert_id);
        $generalaccount->name = $request->name;
        $generalaccount->type = $request->type;
        $generalaccount->coa_id = $chartofaccount->id;
        $generalaccount->save();
    }
    else{
        $msg = "Please make an account with name &#8216;".$request->name."&#8217; in <strong><u>chart of accounts</u></strong>";
        $type = "danger";
    }
    Session::flash('msg', $msg);
    Session::flash('msgtype', $type);

    return redirect('General-Setup/generalaccountinfo');
}   


    public function destroyview($alert_id)
    {
        $alert =  Generalaccount::where('id', $alert_id)->first();
        return view('generalaccount.delete', compact('alert'));

    }


 public function destroy(Request $request, $alert_id)
    {
        $alert = Generalaccount::findOrfail($alert_id);

        $alert->delete();

        return redirect('General-Setup/generalaccountinfo');

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
