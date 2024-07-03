<?php

namespace App\Http\Controllers;


use App\Model\Account\Account;
use App\Model\CostCenterManagment\CostCenter;
use App\Model\CustomerManagment\Customer;
use App\Model\GeneralAccount\Generalaccount;
use App\Model\Projects\projects;
use App\Model\RoadReceiptManagement\RoadReceipt;
use App\Model\RouteManagment\Route;
use App\Model\TripManagement\Tripdata;
use App\Model\TripManagement\TripExpense;
use App\Model\TripManagement\TripFuel;
use App\Model\RoadReceiptManagement\RoadReceiptIncome;
use App\Model\TripManagement\TripRoute;
use Illuminate\Http\Request;
use Mgallegos\LaravelJqgrid\Facades\GridEncoder;
use Illuminate\Support\Facades\Input;
use DB, Auth;
use App\Model\DriversManagment\Driver;
use App\Model\CityManagment\City;
use \App\Model\VehiclesManagment\Vehicles;
use App\Model\RoadReceiptManagement\RoadReceiptDataRepository;

class RoadreceiptController extends Controller
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
        return view('roadreceipt.index');
    }    

    public function create()
    {
        $Accounts =Generalaccount::all();
        $Customers = Customer::all();
        $projects = projects::get();
        $Vehicles = Vehicles::join('drivers' ,'drivers.id','=','vehicles.driver')
            ->join('brands','brands.id','=', 'vehicles.brand')
            ->select('vehicles.id','vehicles.vehicle_no', 'vehicles.driver','vehicles.brand','brands.name as brand_name','drivers.name as driver_name')
            ->get();
        $Routs = Route::all();
        $cost_centers = CostCenter::all();
        return view('roadreceipt.create', compact('projects','cost_centers','Vehicles','Accounts', 'Routs','Customers','max_reading'));
    }   
    public function RoadReceiptGridData()
    {   
        GridEncoder::encodeRequestedData(new RoadReceiptDataRepository(), Input::all());
    }

    public function RoadReceiptSave(Request $request)
    {
        //print_r($request->all());
        //exit();
        $user_id = Auth::User()->id;
        $roadreceipt = new RoadReceipt();
        $roadreceipt->vehicle_id = $request->vehicle_id;
        $roadreceipt->rr_date = $request->rr_date;
        $roadreceipt->cost_center =$request->cost_center;
        $roadreceipt->client =$request->client;
        $roadreceipt->rr_type =$request->rr_type;
        $roadreceipt->project_id =$request->project;
        $roadreceipt->created_by = $user_id;
        $roadreceipt->created_at = date('Y-m-d H:s:i');
        $roadreceipt->save();
        $rr_id = $roadreceipt->id;

        if($request->trip_id != "")
        {
            $trip = Tripdata::where('id', '=', $request->trip_id)->first();
            $trip->roadreceipt_id = $rr_id;
            $trip->save();
        }
        //add the Income
        $count = 0;
        foreach ($request->income_account_id as $income_account_id)
        {
            $trip_income = new RoadReceiptIncome();
            $trip_income->roadreceipt_id = $rr_id;
            $trip_income->income_ac_id = $income_account_id;
            $trip_income->description = $request->income_description[$count];
            $trip_income->amount = $request->income_amount[$count];
            $trip_income->created_by = $user_id;
            $trip_income->created_at = date('Y-m-d H:s:i');
            $trip_income->save();
            $count++;
        }


        return redirect('Transactions/roadreceiptinfo');
    
    }

    public function RoadReceiptUpdateSave(Request $request,$id)
    {
        //print_r($request->all());
        //exit();
        $user_id = Auth::User()->id;
        $roadreceipt = RoadReceipt::where("id", "=" , $id)->first();
        $roadreceipt->vehicle_id = $request->vehicle_id;
        $roadreceipt->rr_date = $request->rr_date;
        $roadreceipt->cost_center =$request->cost_center;
        $roadreceipt->client =$request->client;
        $roadreceipt->rr_type =$request->rr_type;
        $roadreceipt->created_by = $user_id;
        $roadreceipt->created_at = date('Y-m-d H:s:i');
        $roadreceipt->save();


        $rr_id = $id;
        if($request->trip_id != "")
        {
            $trip = Tripdata::where('id', '=', $request->trip_id)->first();
            $trip->roadreceipt_id = $rr_id;
            $trip->save();
        }
        //add the Income
        $count = 0;
        foreach ($request->income_account_id as $income_account_id)
        {
            if($request->income_id[$count] == ""){
                $trip_income = new RoadReceiptIncome();
            }else{
                $trip_income = RoadReceiptIncome::where('roadreceipt_id','=',$id)->where('id','=', $request->income_id[$count])->first();
            }

            $trip_income->roadreceipt_id = $rr_id;
            $trip_income->income_ac_id = $income_account_id;
            $trip_income->description = $request->income_description[$count];
            $trip_income->amount = $request->income_amount[$count];
            $trip_income->created_by = $user_id;
            $trip_income->created_at = date('Y-m-d H:s:i');
            $trip_income->save();
            $count++;
        }


        return redirect('Transactions/roadreceiptinfo');

    }

    public function get_vehicles()
    {
        $Vahicles = Vehicles::select(
        'vehicles.id as VehiclesID',
        'drivers.name as DriverName',
        'brands.name as BrandName'
        )
        ->leftjoin('drivers', 'drivers.id', '=', 'vehicles.driver')
        ->leftjoin('brands', 'brands.id', '=', 'vehicles.brand')
        ->where('vehicles.id', Input::get('VehicleID'))->first();
         echo json_encode(['driver' => $Vahicles->DriverName , 'brand' => $Vahicles->BrandName]);
    }

    public function edit($id)
    {    $Accounts =Generalaccount::all();
        $Customers = Customer::all();
        $projects = projects::get();
        $cost_centers = CostCenter::all();
        $Vehicles = Vehicles::join('drivers' ,'drivers.id','=','vehicles.driver')
            ->join('brands','brands.id','=', 'vehicles.brand')
            ->select('vehicles.id','vehicles.vehicle_no', 'vehicles.driver','vehicles.brand','brands.name as brand_name','drivers.name as driver_name')
            ->get();
        $Routs = Route::all();

        $RoadreceiptData= RoadReceipt::leftjoin('trip', 'trip.roadreceipt_id', '=','road_receipt_data.id')
            ->where('road_receipt_data.id','=',$id)
            ->select('road_receipt_data.id', 'road_receipt_data.vehicle_id','road_receipt_data.rr_date','road_receipt_data.cost_center',
            'road_receipt_data.client','road_receipt_data.rr_id','road_receipt_data.rr_type','road_receipt_data.created_by',
                'road_receipt_data.created_at', 'road_receipt_data.project_id', 'trip.id as trip_id')->first();
        $Roadreceiptincome= RoadReceiptIncome::where('roadreceipt_id','=',$id)->get();

        return view('roadreceipt.edit', compact('projects','Vehicles','cost_centers','Accounts', 'Customers','Routs','RoadreceiptData','Roadreceiptincome'));
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
    public function roadreceipt_trip(Request $request){
        $vehicles = $request->vehicles;
        $customer= $request->customer;
        $cost_center= $request->cost_center;

        $roadreceipts = Tripdata::join('vehicles','vehicles.id', '=','trip.vehicle_id')
            ->join('cost_center','cost_center.id','=','trip.cost_center' )
            ->join('customer','customer.id', '=','trip.client')
            ->select('trip.roadreceipt_id','trip.id','vehicles.vehicle_no', 'cost_center.name as cost_center_name', 'customer.name as customer_name')
            ->where('trip.vehicle_id','=', $vehicles)
            ->where('trip.client','=', $customer)
            ->where('trip.cost_center','=', $cost_center)
            ->get();
        return $roadreceipts->toJson();
    }



}
