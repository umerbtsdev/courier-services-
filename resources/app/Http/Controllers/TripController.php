<?php

namespace App\Http\Controllers;


use App\Model\Account\Account;
use App\Model\CostCenterManagment\CostCenter;
use App\Model\CustomerManagment\Customer;
use App\Model\FuelStationManagment\FuelStation;
use App\Model\GeneralAccount\Generalaccount;
use App\Model\RoadReceiptManagement\RoadReceipt;
use App\Model\RouteManagment\Route;
use App\Model\TripManagement\Tripdata;
use App\Model\TripManagement\TripDataRepository;
use App\Model\TripManagement\TripExpense;
use App\Model\TripManagement\TripFuel;
use App\Model\RoadReceiptManagement\RoadReceiptIncome;
use App\Model\TripManagement\TripRoute;
use Illuminate\Http\Request;
use Mgallegos\LaravelJqgrid\Facades\GridEncoder;
use App\Model\Dashboard\MaintenancerequestDataRepositery;
use App\Model\Dashboard\ProjectwiseDataRepositery;
use App\Model\Dashboard\SchedulewiseDataRepositery;
use App\Model\DriversManagment\DriversDataRepository;
use Illuminate\Support\Facades\Input;
use DB, Auth,Session;
use App\Helper\Common;
use App\Model\DriversManagment\Driver;
use App\Model\CityManagment\City;
use \App\Model\VehiclesManagment\Vehicles;
use App\Model\RoadReceiptManagement\RoadReceiptDataRepository;
use App\Model\Projects\projects;
use \Carbon\Carbon;
use App\Model\Invoices\invoices;
use App\Model\Invoices\invoicesDataRepository;
use App\Model\Invoices\invoices_detail_trips;
use App\Model\Invoices\invoices_detail_maintenance;
use App\Model\Invoices\invoices_approve_reject;
use App\Model\Job\job_data;
use App\Model\Job\job_details;
use App\Model\ChartofAccount\chartofaccount;
use App\Model\Invoices\invoicePrintDetails;

class TripController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('trips.index');
    }    

    public function create()
    {
        $Accounts =Generalaccount::all();
        $Customers = Customer::all();
        $Vehicles = Vehicles::join('drivers' ,'drivers.id','=','vehicles.driver')
            ->join('brands','brands.id','=', 'vehicles.brand')
            ->leftjoin('trip','trip.vehicle_id','=', 'vehicles.id')
            ->select('vehicles.id',DB::Raw('MAX(reading_end) AS reading_end'),'vehicles.vehicle_no', 'vehicles.driver','vehicles.brand','brands.name as brand_name','drivers.name as driver_name')
            ->groupBy('vehicles.id','vehicles.vehicle_no', 'vehicles.driver','vehicles.brand','brands.name','drivers.name')
            ->get();
        $Routs = Route::all();
        $fuelstations = FuelStation::all();
        $costcenters = CostCenter::all();
        $projects = projects::get();
        return view('trips.create', compact('roadreceipts','projects','Vehicles','Accounts', 'Routs','Customers','max_reading','fuelstations','costcenters'));
    }
    public function roadreceipt_trip(Request $request){
        $vehicles = $request->vehicles;
        $customer= $request->customer;
        $cost_center= $request->cost_center;
        $rr_id = 0;

        $roadreceipts = RoadReceipt::join('roadreceipt_income','roadreceipt_income.roadreceipt_id','=', 'road_receipt_data.id')
            ->leftjoin('trip','trip.roadreceipt_id','=','road_receipt_data.id')
            ->join('vehicles','vehicles.id', '=','road_receipt_data.vehicle_id')
            ->join('cost_center','cost_center.id','=','road_receipt_data.cost_center' )
            ->join('customer','customer.id', '=','road_receipt_data.client')
            ->select(DB::RAW('sum(roadreceipt_income.amount) as rr_amount'),'trip.roadreceipt_id','road_receipt_data.id','vehicles.vehicle_no', 'cost_center.name as cost_center_name', 'customer.name as customer_name')
            ->where('road_receipt_data.vehicle_id','=', $vehicles)
            ->where('road_receipt_data.client','=', $customer)
            ->where('road_receipt_data.cost_center','=', $cost_center)
            ->groupBy('trip.roadreceipt_id','road_receipt_data.id','vehicles.vehicle_no', 'cost_center.name', 'customer.name', 'trip.roadreceipt_id')->get();
        return $roadreceipts->toJson();
    }
    public function TripGridData()
    {   
        GridEncoder::encodeRequestedData(new TripDataRepository(), Input::all());
    }

    public function TripSave(Request $request)
    {
        //print_r($request->all());
        //exit();

        $user_id = Auth::User()->id;
        $trip = new Tripdata();
        $trip->project_id = $request->input('project');
        $trip->vehicle_id = $request->vehicle_id;
        $trip->trip_date = date('Y-m-d H:s:i');
        $trip->cost_center =$request->cost_center;
        $trip->gate_pass_no =$request->gate_pass_no;
        $trip->status =$request->status_trip;
        $trip->client =$request->client;
        $trip->meter_status =$request->meter_status;
        $trip->reading_start =$request->reading_start;
        $trip->reading_end =$request->reading_end;
        $trip->remarks =$request->trip_remarks;
        $trip->paid_amount =$request->paid_amount;
        $trip->start_datetime =$request->start_datetime;
        $trip->exp_return_datetime =$request->exp_return_datetime;
        $trip->end_datetime =$request->end_datetime;
        $trip->roadreceipt_id =$request->roadreceipt_id;
        $trip->created_by = $user_id;
        $trip->created_at = date('Y-m-d H:s:i');
        $trip->save();

        $trip_id = $trip->id;
        $count = 0;
        //add the routes
        foreach ($request->route_from as $route_data)
        {
            $trip_route = new TripRoute();
            $trip_route->trip_id = $trip_id;
            $trip_route->route_from = $route_data;
            $trip_route->route_from_datetime = $request->route_from_datetime[$count];
            $trip_route->route_from_reading = $request->route_from_reading[$count];
            $trip_route->route_to = $request->route_to[$count];
            $trip_route->route_to_datetime = $request->route_to_datetime[$count];
            $trip_route->route_to_reading = $request->route_to_reading[$count];
            $trip_route->route_km = $request->route_km[$count];
            $trip_route->remarks = $request->remarks[$count];
            $trip_route->status = $request->status[$count];
            $trip_route->created_by = $user_id;
            $trip_route->created_at = date('Y-m-d H:s:i');
            $trip_route->save();
            $count++;
        }
        //add the expense
        $count = 0;
        foreach ($request->expense_ac_id as $expense_account_id)
        {
            $trip_expense = new TripExpense();
            $trip_expense->trip_id = $trip_id;
            $trip_expense->expense_ac_id = $expense_account_id;
            $trip_expense->amount = $request->expense_amount[$count];
            $trip_expense->created_by = $user_id;
            $trip_expense->created_at = date('Y-m-d H:s:i');
            $trip_expense->save();
            $count++;
        }
        //add the Fuel
        $count = 0;
        foreach ($request->fuel_account_id as $fuel_account_id)
        {
            $trip_fuel = new TripFuel();
            $trip_fuel->trip_id = $trip_id;
            $trip_fuel->account_id = $fuel_account_id;
            $trip_fuel->fuel_station_id = $request->fuel_station_id[$count];
            $trip_fuel->decription = $request->fuel_description[$count];
            $trip_fuel->liter = $request->fuel_liter[$count];
            $trip_fuel->rate = $request->fuel_rate[$count];
            $trip_fuel->amount = $request->fuel_amount[$count];
            $trip_fuel->fuel_meter_reading = $request->fuel_meter_reading[$count];

            $trip_fuel->created_by = $user_id;
            $trip_fuel->created_at = date('Y-m-d H:s:i');
            $trip_fuel->save();
            $count++;
        }

        return redirect('Transactions/tripinfo');
    
    }

    public function TripUpdateSave(Request $request,$id)
    {
        //print_r($request->all());
        //exit();
        $user_id = Auth::User()->id;

        $trip = Tripdata::where("id", "=" , $id)->first();
        $trip->project_id = $request->input('project');
        $trip->vehicle_id = $request->vehicle_id;
        $trip->trip_date = date('Y-m-d H:s:i');
        $trip->cost_center =$request->cost_center;
        $trip->gate_pass_no =$request->gate_pass_no;
        $trip->status =$request->status_trip;
        $trip->client =$request->client;
        $trip->meter_status =$request->meter_status;
        $trip->reading_start =$request->reading_start;
        $trip->reading_end =$request->reading_end;
        $trip->remarks =$request->trip_remarks;
        $trip->paid_amount =$request->paid_amount;
        $trip->start_datetime =$request->start_datetime;
        $trip->exp_return_datetime =$request->exp_return_datetime;
        $trip->end_datetime =$request->end_datetime;
        $trip->roadreceipt_id =$request->roadreceipt_id;
        $trip->created_by = $user_id;
        $trip->created_at = date('Y-m-d H:s:i');
        $trip->save();

        $trip_id = $trip->id;
        $count = 0;
        //add the routes
        foreach ($request->route_from as $route_data)
        {
            if($request->route_id[$count] == ""){
                $trip_route =new TripRoute();
            }
            else
            {
                $trip_route = TripRoute::where('trip_id','=',$id)->where('id','=', $request->route_id[$count])->first();
            }

            $trip_route->trip_id = $trip_id;
            $trip_route->route_from = $route_data;
            $trip_route->route_from_datetime = $request->route_from_datetime[$count];
            $trip_route->route_from_reading = $request->route_from_reading[$count];
            $trip_route->route_to = $request->route_to[$count];
            $trip_route->route_to_datetime = $request->route_to_datetime[$count];
            $trip_route->route_to_reading = $request->route_to_reading[$count];
            $trip_route->route_km = $request->route_km[$count];
            $trip_route->remarks = $request->remarks[$count];
            $trip_route->status = $request->status[$count];
            $trip_route->created_by = $user_id;
            $trip_route->created_at = date('Y-m-d H:s:i');
            $trip_route->save();
            $count++;
        }
        //add the expense
        $count = 0;
        foreach ($request->expense_ac_id as $expense_account_id)
        {
            if($request->exp_id[$count] == ""){
                $trip_expense = new TripExpense();
            }
            else
            {
                $trip_expense = TripExpense::where('trip_id','=',$id)->where('id','=', $request->exp_id[$count])->first();
            }

            $trip_expense->trip_id = $trip_id;
            $trip_expense->expense_ac_id = $expense_account_id;
            $trip_expense->amount = $request->expense_amount[$count];
            $trip_expense->created_by = $user_id;
            $trip_expense->created_at = date('Y-m-d H:s:i');
            $trip_expense->save();
            $count++;
        }
        //add the Fuel
        $count = 0;
        foreach ($request->fuel_account_id as $fuel_account_id)
        {
            if($request->fuel_id[$count] == ""){
                $trip_fuel = new TripFuel();
            }else{
                $trip_fuel = TripFuel::where('trip_id','=',$id)->where('id','=', $request->fuel_id[$count])->first();
            }

            $trip_fuel->trip_id = $trip_id;
            $trip_fuel->account_id = $fuel_account_id;
            $trip_fuel->fuel_station_id = $request->fuel_station_id[$count];
            $trip_fuel->decription = $request->fuel_description[$count];
            $trip_fuel->liter = $request->fuel_liter[$count];
            $trip_fuel->rate = $request->fuel_rate[$count];
            $trip_fuel->amount = $request->fuel_amount[$count];
            $trip_fuel->fuel_meter_reading = $request->fuel_meter_reading[$count];

            $trip_fuel->created_by = $user_id;
            $trip_fuel->created_at = date('Y-m-d H:s:i');
            $trip_fuel->save();
            $count++;
        }



        return redirect('Transactions/tripinfo');

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

        $Vehicles = Vehicles::join('drivers' ,'drivers.id','=','vehicles.driver')
            ->join('brands','brands.id','=', 'vehicles.brand')
            ->leftjoin('trip','trip.vehicle_id','=', 'vehicles.id')
            ->select('vehicles.id',DB::Raw('MAX(reading_start) AS reading_start'),'vehicles.vehicle_no', 'vehicles.driver','vehicles.brand','brands.name as brand_name','drivers.name as driver_name')
            ->groupBy('vehicles.id','vehicles.vehicle_no', 'vehicles.driver','vehicles.brand','brands.name','drivers.name')
            ->get();
        $Routs = Route::all();
        $fuelstations = FuelStation::all();
        $costcenters = CostCenter::all();

        $tripdata= Tripdata::where('id','=',$id)->first();
        $triproute= TripRoute::where('trip_id','=',$id)->get();
        $tripexpense= TripExpense::where('trip_id','=',$id)->get();
        $tripfuel= TripFuel::where('trip_id','=',$id)->get();

        $roadreceipts = RoadReceipt::join('roadreceipt_income','roadreceipt_income.roadreceipt_id','=', 'road_receipt_data.id')
            ->join('vehicles','vehicles.id', '=','road_receipt_data.vehicle_id')
            ->join('cost_center','cost_center.id','=','road_receipt_data.cost_center' )
            ->join('customer','customer.id', '=','road_receipt_data.client')
            ->select(DB::RAW('sum(roadreceipt_income.amount) as rr_amount'),'road_receipt_data.id','vehicles.vehicle_no', 'cost_center.name as cost_center_name', 'customer.name as customer_name')
            ->where('road_receipt_data.vehicle_id','=', $tripdata->vehicle_id)
            ->where('road_receipt_data.client','=', $tripdata->client)
            ->where('road_receipt_data.cost_center','=', $tripdata->cost_center)
            ->groupBy('road_receipt_data.id','vehicles.vehicle_no', 'cost_center.name', 'customer.name')
            ->get();
        $projects = projects::get();
        if ($tripdata->is_locked != 1) {
              return view('trips.edit', compact('projects', 'Vehicles', 'Accounts', 'Customers', 'fuelstations', 'costcenters', 'Routs', 'tripdata', 'triproute', 'tripfuel', 'tripincome', 'tripexpense', 'roadreceipts'));
        }
        else {
            return redirect('/');
        }
    }

    public function update(Request $request, $id)
    {   
        if(empty($request->name)){
      
            return redirect('driver/edit/'.$id);
        }
        else{
   
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

    public function CustomerInvoicesIndex()
    {
        return view('CustomerInvoices.index');
    }

    public function CustomerInvoicesGridData()
    {
        GridEncoder::encodeRequestedData(new invoicesDataRepository(), Input::all());
    }

    public function CustomerInvoicesCreate()
    {
        $costcenters = CostCenter::all();
        $customers = Customer::all();
        $vehicles = Vehicles::all();
        return view('CustomerInvoices.create', compact('costcenters','customers','vehicles'));
    }

    public function CustomerInvoicesSave(Request $request) 
    {
        $msg = "";
        $type = "";
        $JobCount = $request->input('JobCount');
        $TripCount = $request->input('TripCount');

        if($TripCount > 0 || $JobCount > 0){

            $invoices = new invoices();
                $invoices->cost_center_id = $request->input('costCenter_id');
                $invoices->client_id = $request->input('client_id');
                $invoices->vehicle_id = $request->input('vehicle_id');
                $invoices->date_from = $request->input('date_from');
                $invoices->date_to = $request->input('date_to');
                $invoices->total_billed = $request->input('totalBilled');
                $invoices->total_expenses = $request->input('totalExpense');
                $invoices->grand_total = $request->input('grandTotal');
                $invoices->maintenance_total = $request->input('MaintenanceTotal');
                $invoices->depreciation = $request->input('Depreciation');
                $invoices->driver_id = $request->input('driver_id');
                $invoices->profitLoss = $request->input('profitLoss');
                $invoices->total_reading = $request->input('totalReading');
                $invoices->total_working_days = $request->input('totalworkingdays');
                $invoices->days_worked = $request->input('daysworked');
                $invoices->created_by =  Auth::User()->id;
                $invoices->created_at = date('Y-m-d H:i:s');
                $invoices->total_detentions = $request->input('TotalDetentions');
                $invoices->detention_count = $request->input('DetentionCount');
            $invoices->save();

            $invoice_id = $invoices->id;

            $loop=0;
            if($request->input('rr_id') != null) {
                foreach ($request->input('rr_id') as $rr_id) {
                    $invoices_detail_trips = new invoices_detail_trips();
                    $invoices_detail_trips->invoice_id = $invoice_id;
                    $invoices_detail_trips->road_recipt_id = $rr_id;
                    $invoices_detail_trips->trip_id = $request->input('trip_id')[$loop];
                    $invoices_detail_trips->save();

                    $Tripdata = Tripdata::find($request->input('trip_id')[$loop]);
                    $Tripdata->is_locked = 1;
                    $Tripdata->invoice_id = $invoice_id;
                    $Tripdata->save();

                    $RoadReceipt = RoadReceipt::find($rr_id);
                    $RoadReceipt->is_locked = 1;
                    $RoadReceipt->invoice_id = $invoice_id;
                    $RoadReceipt->save();
                    $loop++;
                }
            }
            if($request->input('JobID') != null) {
                foreach ($request->input('JobID') as $job) {
                    $invoices_detail_maintenance = new invoices_detail_maintenance();
                    $invoices_detail_maintenance->invoice_id = $invoice_id;
                    $invoices_detail_maintenance->job_id = $job;
                    $invoices_detail_maintenance->save();

                    $job_data = job_data::find($job);
                    $job_data->is_locked = 1;
                    $job_data->save();
                }
            }
            $msg = "Invoice Created";
            $type = "success";
        }
        else{
            $msg = "Invoice cannot be created as there are no Trips /Jobs on selected dates";
            $type = "danger";
        }
        Session::flash('msg', $msg);
        Session::flash('msgtype', $type);

        return redirect('/Transactions/Customer-Inovices');
    }
    
    public function CustomerInvoicesView($id)
    {
        $costcenters = CostCenter::all();
        $customers = Customer::all();
        $vehicles = Vehicles::all();
        $invoice = invoices::leftjoin('drivers','invoices_master.driver_id','=','drivers.id')
        ->leftjoin('invoices_approve_reject','invoices_master.id','=','invoices_approve_reject.invoice_id')
        ->where('invoices_master.id','=',$id)
        ->select(
            'invoices_master.*',
            'drivers.salary_package as driver_salary',
            'drivers.name as driver_name',
            'invoices_approve_reject.is_approved'
            )
        ->first();;
        $approvalPermissionCheck = 0;
        if(Common::userwisepermission(Auth::user()->id, "Customer Invoices Approve Reject")){
            $approvalPermissionCheck = 1;
        }


        return view('CustomerInvoices.view', compact('invoice','costcenters','customers','vehicles','approvalPermissionCheck'));
    }


    public function CustomerInvoicesApproveReject(Request $request)
    {
        $type = "invoice";
        $invoice_id = $request->input('invoice_id');
        $status = $request->input('status');
        $remarks = $request->input('remarks');
        $totalBilled = $request->input('totalBilled');
        $transactionDate = date('Y-m-d');
        $coa = chartofaccount::where('name','=',"Premium Tax")->first();

        Common::makeTransaction($coa->id,$type,$invoice_id,$totalBilled,$transactionDate,"debit");
        
        $invoices_approve_reject = new invoices_approve_reject();
            $invoices_approve_reject->invoice_id =$invoice_id ;
                if($status=="approve"){
                    $invoices_approve_reject->is_approved = 1;
                }
                else{
                    $invoices_approve_reject->is_rejected = 1;
                }
                $invoices_approve_reject->remarks = $remarks;
                $invoices_approve_reject->created_by  = Auth::user()->id;
                $invoices_approve_reject->created_at  = date('Y-m-d H:i:s');
            $invoices_approve_reject->save();    
            

       return redirect('/Transactions/Customer-Inovices');
    }


    //#region Printing

        public function PrintCustomerInvoice($id)
        {
            $invoiceID = $id;
            $invoice = invoices::join('invoices_approve_reject','invoices_master.id','=','invoices_approve_reject.invoice_id')
            ->join('customer','invoices_master.client_id','=','customer.id')
            ->join('vehicles','invoices_master.vehicle_id','=','vehicles.id')
            ->select(
                'invoices_master.*','customer.name as client_name','customer.address_line_1','customer.address_line_2','customer.city as client_city',
                'vehicles.vehicle_no'
            )
            ->where('invoices_approve_reject.is_approved','=',DB::raw('1'))
            ->where('invoices_master.id','=',$id)
            ->first();
            if($invoice){

                $tableDatum = invoices::leftjoin('road_receipt_data','invoices_master.id','=','road_receipt_data.invoice_id')
                ->leftjoin('roadreceipt_income','road_receipt_data.id','=','roadreceipt_income.roadreceipt_id')
                
                ->leftjoin('accounts','roadreceipt_income.income_ac_id','=','accounts.id')
                ->leftjoin('invoice_print_details','accounts.id','=','invoice_print_details.account_id')
                
                ->where('invoices_master.id','=',$id)
                ->select(
                    'accounts.id',
                    'accounts.alias_name'
                    ,DB::raw('SUM(roadreceipt_income.amount) AS amount'),
                    'invoice_print_details.description',
                    'invoice_print_details.receipt_no',
                    'invoice_print_details.amount_fc'
                )

                ->groupBy('accounts.id','accounts.alias_name','roadreceipt_income.amount',
                          'invoice_print_details.description','invoice_print_details.receipt_no','invoice_print_details.amount_fc')
                ->get();

                

                return view('CustomerInvoices.printable_layouts.invoice_table', compact('invoiceID','invoice','tableDatum'));
            }
            else {
                return redirect('/Transactions/Customer-Inovices');
            }
           // return view('CustomerInvoices.printable_layouts.customerInvoice', compact('invoiceID','invoice'));
        }
    //#endregion
    //#region AJAX 
        //#region for create
            public function monthWiseTransport(Request $request){
                
        
                $vehicle_id = $request->input('vehicle_id');
                $date_from = $request->input('date_from');
                $date_to = $request->input('date_to');
                $data["date_from"] = $date_from;
                $data["date_to"] = $date_to;

                $monthwisereport = Tripdata::leftjoin('trip_expense',function($join){
                    $join->on('trip.id','=','trip_expense.trip_id');
                    $join->on('trip_expense.expense_ac_id', '=',DB::Raw('7'));
                })
                    ->leftjoin('road_receipt_data','road_receipt_data.id', '=','trip.roadreceipt_id')
                    ->leftjoin('vehicles','vehicles.id', '=','road_receipt_data.vehicle_id')
                    ->leftjoin('drivers','drivers.id', '=','vehicles.driver')
                    ->leftjoin('trip_expense as tem',function($join){
                        $join->on('trip.id','=','tem.trip_id');
                        $join->on('tem.expense_ac_id','=',DB::Raw('8'));
                    })
                    ->leftjoin('trip_fuel', function($join){
                        $join->on('trip.id', '=', 'trip_fuel.trip_id');
                        $join->on('trip_fuel.account_id', '=', DB::Raw('6') );
                    })
                    ->leftjoin('roadreceipt_income as tii', function($join){
                        $join->on('road_receipt_data.id' ,'=', 'tii.roadreceipt_id');
                        $join->on('tii.income_ac_id', '=', DB::Raw('4'));
                    })
                    ->leftjoin('roadreceipt_income as tid', function($join){
                        $join->on('road_receipt_data.id', '=', 'tid.roadreceipt_id');
                        $join->on('tid.income_ac_id', '=',  DB::Raw('5'));
                    })
                    ->leftjoin('trip_route','trip.id','=','trip_route.trip_id')
                    ->select(
                            'trip.id', 
                            'trip.trip_date',
                            DB::Raw('SUM(tii.amount) AS Billed'), 
                            DB::Raw('SUM(tid.amount) AS Detention'), 
                            DB::Raw('SUM(trip_fuel.`amount`) AS Diesel'),
                            DB::Raw("SUM(trip_expense.`amount`) AS driver_allowance"), 
                            DB::Raw("SUM(tem.`amount`) AS misc"),
                            'trip.reading_start', 'trip.reading_end',
                            DB::Raw('GROUP_CONCAT(trip_route.remarks) AS remarks'),
                            'road_receipt_data.id as rr_id'
                    )
                ->where('road_receipt_data.vehicle_id','=',$vehicle_id)
                ->where(DB::Raw('CONVERT(road_receipt_data.rr_date,DATE)'),'>=',$date_from)
                ->where(DB::Raw('CONVERT(road_receipt_data.rr_date,DATE)'),'<=',$date_to)
                ->where('road_receipt_data.is_locked','!=',DB::raw('1'))
                ->where('trip.is_locked','!=',DB::raw('1'))

                ->groupBy(
                    'trip.id',
                    'trip.reading_start',
                    'trip.reading_end',
                    'trip.trip_date',
                    'trip.vehicle_id',
                    'road_receipt_data.id'
                )
                ->get();


                return view('CustomerInvoices.TripReport',compact('monthwisereport', 'vehicles','data'));
            }
            public function monthWiseJobTransport(Request $request){
                $vehicle_id = $request->vehicle_id;
                $date_from = $request->date_from;
                $date_to = $request->date_to;


                $job_data = job_data::leftjoin('vehicles','job_data.vehicle_id','=','vehicles.id')
                ->leftjoin('workshops','job_data.workshop_id','=','workshops.workshop_id')
                ->leftjoin('job_details','job_data.id','=','job_details.job_id')
                ->leftjoin('services','job_details.service_id','=','services.id')
                ->leftjoin('parts','job_details.part_id','=','parts.part_id')
                ->select(
                    'job_data.id as JobID',
                    'job_data.grand_total',
                    'job_data.job_date',
                    'vehicles.vehicle_no',
                    'workshops.workshop_name',
                    'services.service_name','parts.part_name'
                    )
                ->distinct('job_data.id')
                ->where('job_data.job_date','>=',$date_from )
                ->where('job_data.job_date','<=',$date_to )
                ->where('job_data.vehicle_id','=',$vehicle_id)
                ->get();
            
                $JobIDs = [];
                $prevID=0;$firstCheck = 1;

                    foreach($job_data as $job){

                        if($firstCheck ==1){
                            $firstCheck = 0;
                            $prevID = $job->JobID;
                            array_push($JobIDs,$job->JobID);
                        }

                        
                        if($prevID != $job->JobID){
                            $prevID = $job->JobID;
                            array_push($JobIDs,$job->JobID);
                        }
                        
                    }
                
                    $job_details = job_details::leftjoin('parts','job_details.part_id','=','parts.part_id')
                    ->leftjoin('services','job_details.service_id','=','services.id')
                    ->whereIn('job_details.job_id',$JobIDs)
                    ->distinct('job_details.job_id')
                    ->select('job_details.job_id','services.service_name','parts.part_name')
                    ->get();

                    
                    return view('CustomerInvoices.JobReport',compact('job_data','job_details'));

            }
        //#endregion
        //#region for view
            public function monthWiseTransportView(Request $request){
                
        
                $vehicle_id = $request->input('vehicle_id');
                $date_from = $request->input('date_from');
                $date_to = $request->input('date_to');
                $data["date_from"] = $date_from;
                $data["date_to"] = $date_to;
                
                $monthwisereport = Tripdata::leftjoin('trip_expense',function($join){
                    $join->on('trip.id','=','trip_expense.trip_id');
                    $join->on('trip_expense.expense_ac_id', '=',DB::Raw('7'));
                })
                    ->leftjoin('road_receipt_data','road_receipt_data.id', '=','trip.roadreceipt_id')
                    ->leftjoin('vehicles','vehicles.id', '=','road_receipt_data.vehicle_id')
                    ->leftjoin('drivers','drivers.id', '=','vehicles.driver')
                    ->leftjoin('trip_expense as tem',function($join){
                        $join->on('trip.id','=','tem.trip_id');
                        $join->on('tem.expense_ac_id','=',DB::Raw('8'));
                    })
                    ->leftjoin('trip_fuel', function($join){
                        $join->on('trip.id', '=', 'trip_fuel.trip_id');
                        $join->on('trip_fuel.account_id', '=', DB::Raw('6') );
                    })
                    ->leftjoin('roadreceipt_income as tii', function($join){
                        $join->on('road_receipt_data.id' ,'=', 'tii.roadreceipt_id');
                        $join->on('tii.income_ac_id', '=', DB::Raw('4'));
                    })
                    ->leftjoin('roadreceipt_income as tid', function($join){
                        $join->on('road_receipt_data.id', '=', 'tid.roadreceipt_id');
                        $join->on('tid.income_ac_id', '=',  DB::Raw('5'));
                    })
                    ->leftjoin('trip_route','trip.id','=','trip_route.trip_id')
                    ->select(
                            'trip.id', 
                            'trip.trip_date',
                            DB::Raw('SUM(tii.amount) AS Billed'), 
                            DB::Raw('SUM(tid.amount) AS Detention'), 
                            DB::Raw('SUM(trip_fuel.`amount`) AS Diesel'),
                            DB::Raw("SUM(trip_expense.`amount`) AS driver_allowance"), 
                            DB::Raw("SUM(tem.`amount`) AS misc"),
                            'trip.reading_start', 'trip.reading_end',
                            DB::Raw('GROUP_CONCAT(trip_route.remarks) AS remarks'),
                            'road_receipt_data.id as rr_id'
                    )
                ->where('road_receipt_data.vehicle_id','=',$vehicle_id)
                ->where(DB::Raw('CONVERT(road_receipt_data.rr_date,DATE)'),'>=',$date_from)
                ->where(DB::Raw('CONVERT(road_receipt_data.rr_date,DATE)'),'<=',$date_to)
                ->groupBy(
                    'trip.id',
                    'trip.reading_start',
                    'trip.reading_end',
                    'trip.trip_date',
                    'trip.vehicle_id',
                    'road_receipt_data.id'
                )
                ->get();

        
                return view('CustomerInvoices.TripReport',compact('monthwisereport', 'vehicles','data'));
            }
            
        //#endregion
        
        //#region HGet Vehicle Inf0
            public function getVehicleInfo(Request $request)
            {
                $vehicle_id = $request->vehicle_id;
                $Vehicles = Vehicles::leftjoin('drivers','vehicles.driver','=','drivers.id')
                ->select('vehicles.*','drivers.name as driverName','drivers.salary_package','drivers.id as driver_id')
                ->where('vehicles.id','=',$vehicle_id)->first();;
                $Depreciation = intval($Vehicles->purchase_amount) / intval($Vehicles->life);
                $DriverName = $Vehicles->driverName;
                $Salary = $Vehicles->salary_package;
                $driver_id = $Vehicles->driver_id;
                echo json_encode(['Depreciation' => $Depreciation,'DriverName' => $DriverName,'DriverSalary'=> $Salary,'driver_id'=> $driver_id]);
            }
        //#endregion
        //#region 

            public function SaveCustomerInvoiceData(Request $request)
            {
                $invoice_id = $request->input('invoice_id');
                $comodity = $request->input("comodity");
                $no_of_packages = $request->input("no_of_packages");
                $shipper_invoice_value = $request->input("shipper_invoice_value");
                $job_no = $request->input("job_no");
                $file_job_no = $request->input("file_job_no");
                $shipper_invoice_number = $request->input("shipper_invoice_number");
                $port_of_discharge = $request->input("port_of_discharge");
                $assessed_value = $request->input("assessed_value");
                $exchange_rate = $request->input("exchange_rate");
                
                $accounts =  $request->input("accounts");
                $other_infos =  $request->input("other_infos");
                $receipt_nos =  $request->input("receipt_nos");
                $amounts_fc  =  $request->input("amounts_fc");
                
                

                $invoice = invoices::find($invoice_id);
                    $invoice->commodity = $comodity;
                    $invoice->no_of_packages = $no_of_packages;
                    $invoice->shipper_invoice_value = $shipper_invoice_value;
                    $invoice->job_no = $job_no;
                    $invoice->file_job_no = $file_job_no;
                    $invoice->shipper_invoice_number = $shipper_invoice_number;
                    $invoice->port_of_discharge = $port_of_discharge;
                    $invoice->assessed_value = $assessed_value;
                    $invoice->exchange_rate = $exchange_rate;
                $invoice->save();

               
                $invoicePrintDetails = invoicePrintDetails::where('invoice_id', '=',$invoice_id)->get();

                if(count($invoicePrintDetails) >0){
                    //update
                    foreach($invoicePrintDetails as $invoicePrintDetail){
                        foreach ($accounts as $key => $value) {
                                $invoicePrintDetail->description = $other_infos[$key] ; 
                                $invoicePrintDetail->receipt_no  = $receipt_nos[$key]; 
                                $invoicePrintDetail->amount_fc  = $amounts_fc[$key]; 
                                $invoicePrintDetail->updated_at  = date("Y-m-d H:i:s"); 
                                $invoicePrintDetail->updated_by = Auth::user()->id;
                            $invoicePrintDetail->save();
                        }
                    }
                }
                else{ // create
                    foreach ($accounts as $key => $value) {
                        $invoiceDetails = new invoicePrintDetails();
                            $invoiceDetails->invoice_id  = $invoice_id;
                            $invoiceDetails->account_id  = $value;
                            $invoiceDetails->description = $other_infos[$key] ; 
                            $invoiceDetails->receipt_no  = $receipt_nos[$key]; 
                            $invoiceDetails->amount_fc  = $amounts_fc[$key]; 
                            $invoiceDetails->created_at  = date("Y-m-d H:i:s"); 
                            $invoiceDetails->created_by = Auth::user()->id;
                        $invoiceDetails->save();  
                    }
                    
                        
                }
            }

        //#endregion
    //#endgrion
}
