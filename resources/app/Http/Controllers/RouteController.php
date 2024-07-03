<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\Machines\MaintenanceRequest;
use Mgallegos\LaravelJqgrid\Facades\GridEncoder;
use App\Model\Dashboard\MaintenancerequestDataRepositery;
use App\Model\Dashboard\ProjectwiseDataRepositery;
use App\Model\Dashboard\SchedulewiseDataRepositery;
use App\Model\RouteManagment\RouteDataRepository;
use Illuminate\Support\Facades\Input;
use DB;
use App\Model\RouteManagment\Route;

class RouteController extends Controller
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
        return view('routes.index');
    }    

    public function create()
    {
        return view('routes.create');
    }   
    public function RouteGridData()
    {   
     GridEncoder::encodeRequestedData(new RouteDataRepository(), Input::all());
    }

    public function store(Request $request)
    {

        $route = new Route();
        $route->name = $request->name;
        $route->save();

        return redirect('General-Setup/routeinfo');
    
    }


public function edit($id)
{
    $route = Route::select('id','name')->where('id', $id)->first();
    return view('routes.edit', compact('route'));
}   


public function update(Request $request, $id)
{   

        if(empty($request->name)){
      
            return redirect('route/edit/'.$id);
        }else{
   
        $route = Route::findOrfail($id);

        $route->name = $request->name;

        $route->save();

        return redirect('General-Setup/routeinfo');

        }
}   


 public function destroyview($id)
{
        $route =  Route::select('id','name')->where('id', $id)->first();
        return view('routes.delete', compact('route'));
}

 public function destroy($id)
{
        $route = Route::findOrfail($id);

        $route->delete();

        return redirect('General-Setup/routeinfo');
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
