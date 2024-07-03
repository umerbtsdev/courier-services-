<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\Machines\MaintenanceRequest;
use Mgallegos\LaravelJqgrid\Facades\GridEncoder;
use App\Model\Dashboard\MaintenancerequestDataRepositery;
use App\Model\Dashboard\ProjectwiseDataRepositery;
use App\Model\Dashboard\SchedulewiseDataRepositery;
use App\Model\VehiclesManagment\VehiclesDataRepository;
use Illuminate\Support\Facades\Input;
use DB;
use App\Model\VehiclesManagment\Vehicles;
use App\Model\DriversManagment\Driver;
use App\Model\BrandManagment\Brand;
use App\Model\CategoriesManagment\Categories;

class VehiclesController extends Controller
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
        return view('vehicles.index');
    }    

    public function create()
    {   
       $this->data['drivers'] = Driver::all();
       $this->data['brands'] = Brand::all();
       $this->data['categories'] = Categories::all();

        return view('vehicles.create', $this->data);
    }   
    public function VachGridData()
    {   
     GridEncoder::encodeRequestedData(new VehiclesDataRepository(), Input::all());
    }

    public function store(Request $request)
    {
        $vehicles = new Vehicles();
        $vehicles->vehicle_no = $request->vcname;
        $vehicles->start_date = $request->start_date;
        $vehicles->end_date = $request->end_date;
        $vehicles->description = $request->discrp;
        $vehicles->driver = $request->drivers;
        $vehicles->warranty = $request->warranty;
        $vehicles->owner = $request->owner;
        $vehicles->brand = $request->brand;
        $vehicles->category_id = $request->category;
        $vehicles->life = $request->life;
        $vehicles->deperciation = $request->deperciation;
        $vehicles->purchase_amount = $request->purchase_amount;
        $vehicles->lease_amount = $request->lease_amount;
        $vehicles->lease_duration = $request->lease_duration;
        $vehicles->lease_total = $request->lease_total;
        $vehicles->save();

        return redirect('General-Setup/vehiclesinfo');
    }


public function edit($vech_id)
{
       $this->data['drivers'] = Driver::all()->pluck('name', 'id');
       $this->data['brands'] = Brand::all()->pluck('name', 'id');
       $this->data['categories'] = Categories::all()->pluck('name', 'id');
       $this->data['Vehicles'] = Vehicles::where('id', $vech_id)->first();
     
       return view('vehicles.edit', $this->data);
}   
public function update(Request $request, $id)
{       

        if(empty($request->vcnum || $request->owner)){
      
            return redirect('vehicles/edit/'.$id);
        }
        else{
   
            $vehicles = Vehicles::findOrfail($id);

            $vehicles->vehicle_no = $request->vcnum;
            $vehicles->start_date = $request->start_date;
            $vehicles->end_date = $request->end_date;
            $vehicles->description = $request->dscrp;
            $vehicles->driver = $request->drivers;
            $vehicles->warranty = $request->warranty;
            $vehicles->owner = $request->owner;
            $vehicles->brand = $request->brand;
            $vehicles->category_id = $request->cetagory;
            $vehicles->life = $request->life;
            $vehicles->deperciation = $request->deperciation;
            $vehicles->purchase_amount = $request->purchase_amount;
            $vehicles->lease_amount = $request->lease_amount;
            $vehicles->lease_duration = $request->lease_duration;
            $vehicles->lease_total = $request->lease_total;
            $vehicles->save();

            return redirect('General-Setup/vehiclesinfo');

        }
}   


 public function destroyview($id)
{   
       $this->data['drivers'] = Driver::all()->pluck('name', 'id');
       $this->data['brands'] = Brand::all()->pluck('name', 'id');
       $this->data['categories'] = Categories::all()->pluck('name', 'id');
       $this->data['Vehicles'] = Vehicles::where('id', $id)->first();

        return view('vehicles.delete', $this->data);
}


 public function destroy($id)
{
        $vehicles = Vehicles::findOrfail($id);

        $vehicles->delete();

        return redirect('General-Setup/vehiclesinfo');
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
