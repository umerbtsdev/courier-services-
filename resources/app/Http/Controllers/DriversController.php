<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\Machines\MaintenanceRequest;
use Mgallegos\LaravelJqgrid\Facades\GridEncoder;
use App\Model\Dashboard\MaintenancerequestDataRepositery;
use App\Model\Dashboard\ProjectwiseDataRepositery;
use App\Model\Dashboard\SchedulewiseDataRepositery;
use App\Model\DriversManagment\DriversDataRepository;
use Illuminate\Support\Facades\Input;
use DB;
use App\Model\DriversManagment\Driver;
use App\Model\CityManagment\City;

class DriversController extends Controller
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
        return view('drivers.index');
    }    

    public function create()
    {

       $this->data['cities'] = City::all();

        return view('drivers.create', $this->data);
    }   
    public function DriversGridData()
    {   
     GridEncoder::encodeRequestedData(new DriversDataRepository(), Input::all());
    }

    public function store(Request $request)
    {


        $drivers = new Driver();
        $drivers->name = $request->name;
        $drivers->emp_code = $request->empcode;
        $drivers->designation = $request->designation;
        $drivers->hiring_date = $request->hiringdate;
        $drivers->date_of_brith = $request->dob;
        $drivers->license = $request->licenseno;
        $drivers->expriy_on = $request->licenseexpiry;
        $drivers->city = $request->city;
        $drivers->phone_no = $request->phone;  
        $drivers->cell_no = $request->cell;
        $drivers->ntn_no = $request->ntn;
        $drivers->salary_package = $request->salary;
        $drivers->address = $request->address;
      

        $drivers->save();

        return redirect('General-Setup/driversinfo');
    
    }

public function edit($id)
{   $this->data['cities'] = City::all()->pluck('name', 'id');

    $this->data['Driver'] = Driver::where('id', $id)->first();
    return view('drivers.edit', $this->data);
}   

public function update(Request $request, $id)
{   

        // $dob = $request->dob;
        // $dob = explode("/", $dob);
        //  //  print_r($dob); die;

        // $DoB = $dob[2].'-'.$dob[1].'-'.$dob[0];

    
        //echo $DoB; die;


        if(empty($request->name)){
      
            return redirect('driver/edit/'.$id);
        }else{
   
        $drivers = Driver::findOrfail($id);

        $drivers->name = $request->name;
        $drivers->emp_code = $request->empcode;
        $drivers->designation = $request->designation;
        $drivers->hiring_date = $request->hiringdate;
        $drivers->date_of_brith = $request->dob;
        $drivers->license = $request->licenseno;
        $drivers->expriy_on = $request->licenseexpiry;
        $drivers->city = $request->city;
        $drivers->phone_no = $request->phone;  
        $drivers->cell_no = $request->cell;
        $drivers->ntn_no = $request->ntn;
        $drivers->salary_package = $request->salary;
        $drivers->address = $request->address;

        $drivers->save();

        return redirect('General-Setup/driversinfo');

        }
}   


 public function destroyview($id)
{
       // $Driver =  Driver::all()->where('id', $id)->first();
        $cities = City::all()->pluck('name', 'id');

        $Driver = Driver::select(
        'drivers.id as driverID',
        'drivers.Name as name',
        'city.name as CityName',
        'drivers.emp_code', 'address', 
        'hiring_date',
        'date_of_brith', 
        'license', 
        'expriy_on', 
        'phone_no', 
        'cell_no',
        'ntn_no', 
        'designation', 
        'salary_package'
    )
    ->leftjoin('city', 'city.id', '=', 'drivers.city')
    ->where('drivers.id', $id)->first();

    return view('drivers.delete', compact('Driver', 'cities'));
}


 public function destroy($id)
{
        $driver = Driver::findOrfail($id);

        $driver->delete();

        return redirect('General-Setup/driversinfo');
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
