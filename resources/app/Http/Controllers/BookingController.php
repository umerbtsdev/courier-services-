<?php

namespace App\Http\Controllers;

use App\Model\Booking\BookingDataRepository;
use App\Model\Booking\LoadsheetData;
use App\Model\Booking\LoadsheetDataRepository;
use App\Model\Booking\LoadsheetPickupDataRepository;
use App\Model\Booking\OrderBooking;
use App\Model\Booking\SecurityScanDataRepository;
use App\Model\CityManagment\City;
use App\Model\CostCenterManagment\CostCenter;
use App\Model\Countries\Countries;
use App\Model\CustomerManagment\Customer;
use App\Model\DeliveryType\DeliveryType;
use App\Model\Services\services;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Mgallegos\LaravelJqgrid\Facades\GridEncoder;
use Illuminate\Support\Facades\Input;
use Validator,DB;

class BookingController extends Controller
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
    //
    public function SingleOrderBooking()
    {
        $costcenters = CostCenter::all();
        $cities = City::all();
        $countries = Countries::all();
        $services = services::all();
        $deliverytypes =  DeliveryType::all();
        $customer =Customer::where('user_id','=',Auth::User()->id)->first();

        return view('booking.singlebooking.index', compact('costcenters','cities','countries','services','deliverytypes','customer'));
    }
    public function BulkOrderBooking()
    {
        $isEnable = 1;
        $responce  = array();
        return view('booking.bulkbooking.index', compact('isEnable','responce'));
    }
    public function boobkingorderlist(){
        return view('booking.bookinglist.index');
    }
    public function BookingSingleStore(Request $request)
    {
        $allfeild = $request->all();
        $orderbooking = new OrderBooking();
            $orderbooking->cn_no = mt_rand();
            $orderbooking->cost_center = $allfeild["cost_center"];
            $orderbooking->customer_ref  = $allfeild["customer_ref"];
            $orderbooking->consignee_id  = $allfeild["consignee_id"];
            $orderbooking->delivery_type  = $allfeild["delivery_type"];
            $orderbooking->customer_name  = $allfeild["customer_name"];
            $orderbooking->customer_address  = $allfeild["address"];
            $orderbooking->customer_Contact_number  = $allfeild["customer_contact_number"];
            $orderbooking->customer_email  = $allfeild["customer_email"];
            if(isset($allfeild["customer_contact_person"]))
            {
                $orderbooking->customer_contact_person  = $allfeild["customer_contact_person"];
            }

            $orderbooking->pieces  = $allfeild["pieces"];
            $orderbooking->weight  = $allfeild["weight"];
            $orderbooking->fragile  = $allfeild["fragile"];
            $orderbooking->origin  = $allfeild["origin"];
            $orderbooking->destination_country  = $allfeild["destination_country"];
            $orderbooking->destination_city  = $allfeild["destination_city"];
            $orderbooking->cod_amount  = $allfeild["cod_amount"];
            $orderbooking->product_detail  = $allfeild["product_detail"];
            $orderbooking->insurance_declared_value  = $allfeild["insurance"];
            $orderbooking->service  = $allfeild["service"];
            $orderbooking->remarks  = $allfeild["remarks"];
            $orderbooking->save();

            $this->createcn($orderbooking->id);

        return redirect('/transaction/singlebookingedit/'.$orderbooking->id);

       // print_r($allfeild);
        //echo mt_rand();
    }

    public function SingleOrderBookingedit($id)
    {
        $orderbooking = OrderBooking::where('id','=',$id)->first();
        $costcenters = CostCenter::all();
        $cities = City::all();
        $countries = Countries::all();
        $services = services::all();
        $deliverytypes =  DeliveryType::all();
        $customer =Customer::where('id','=',$orderbooking->consignee_id)->first();

        return view('booking.singlebooking.edit', compact('costcenters','cities','countries','services','deliverytypes','customer','orderbooking'));
    }
    public function BookingGridData()
    {
        GridEncoder::encodeRequestedData(new BookingDataRepository(), Input::all());
    }

    public function orderbookingprint($id)
    {
        $printdata = OrderBooking::leftjoin('customer', 'customer.id','=','order_booking.consignee_id')
            ->leftjoin('services','order_booking.service','=', 'services.id')
            ->leftjoin('city','order_booking.destination_city','=', 'city.id')
            ->leftjoin('city as cus_city','customer.city_id','=', 'cus_city.id')
            ->select('order_booking.id','order_booking.cn_no','customer.business_name','customer.owner_name','customer.address as cus_name','customer.address as cus_name',
                'customer.email as cus_email','cus_city.name as cus_city_name','customer.contact_no as cus_contact_no', 'customer.id as cus_id','order_booking.customer_name','order_booking.customer_address','order_booking.customer_Contact_number', 'order_booking.customer_email',
                'order_booking.customer_contact_person','order_booking.pieces','order_booking.weight','order_booking.fragile',
                'order_booking.origin','order_booking.destination_country','order_booking.destination_city','order_booking.destination_city','order_booking.cod_amount',
                'order_booking.product_detail','order_booking.insurance_declared_value','order_booking.service','order_booking.remarks','services.service_name',
                'city.name as city_name','order_booking.created_at')
            ->where('order_booking.id','=',$id)->first();

        return view('booking.orderprint.printsingle', compact('printdata'));
    }

    public function sampleCSVDownload()
    {
//        Consignee Name ( Max. 90 characters)
//        Consignee Address ( Max. 450 characters)
//        Consignee Mobile Number ( Max. 50 characters)
//        Consignee Email ( Max. 90 characters)
//        Destination City ( Max. 90 characters)
//        Pieces
//        Weight
//        COD Amount ( Max. 18 digits)
//        Customer Reference Number ( Max. 50 characters)
//        Special Handling (Yes/No)
//        Service Type (Provide service code which is O)
//        Product Details ( Max. 999 characters)
//        Remarks ( Max. 450 characters)
//        Insurance/Declared Value (Min. 10 & Max. 300000)

        $csv = "Consignee Name,Consignee Address,Consignee Mobile,Consignee Email,Destination City,Pieces,Weight,COD Amount,Customer Reference Number,Special Handling,Service Type,Product Details,Remarks,Insurance/Declared Value";
        header('Content-Disposition: attachment; filename="orderbooking.csv"');
        header("Cache-control: private");
        header("Content-type: application/force-download");
        header("Content-transfer-encoding: binary\n");

        echo $csv;

        exit;
    }
    public function bulkorderBookingSubmit(Request $request)
    {
        $input		=	$request->all();
        $csvData	=	array();
        $responseMsg	=	"";
        $responce = array();
        if($request->file('product_csv') != "")
        {
            $file	= $request->file('product_csv');
            $extension = $file->getClientOriginalExtension();
            $fileSize	=	$file->getClientSize()/1024;
            $filePath	= $file->getPathName();
        }

        //Validate CSV file format
        if(strtolower($extension) != 'csv')
        {
            $responseMsg = "Only CSV file is allowed";
            Session::flash('alert-danger',$responseMsg);
            return Redirect::back();
        }

        //Validate uploaded CSV data and convert to array on Success
        $response	=	$this->csvToArray($filePath);

        //If validation failed
        if(!$response['success'])
        {
            $responseMsg = $response['error'];
            Session::flash('alert-danger',$responseMsg);
            return Redirect::back();
        }

        //If validated successfully
        if($response['success'])
        {
            //Get CSV data as an Array
            $csvData	=	$response['data'];
        }

        //Get total uploaded rows
        $totalRows	=	count($csvData);

        if(!$totalRows > 0)
        {
            $responseMsg = "No data to process";
            Session::flash('alert-danger',$responseMsg);
            return Redirect::back();
        }

        $rowNumber	=	1;

        $customer =Customer::where('user_id','=',Auth::User()->id)->first();
        if($customer == null)
        {
            $responce[] ="<br><span style='color: red' >Row # $rowNumber. Error: "."Please login with customer Account than upload the csv." ."</span>";
            $isEnable = 1;
            return view('booking.bulkbooking.index', compact('isEnable','responce'));
        }


        foreach($csvData as $row)
        {
            //Row number
            $rowNumber++;
            $errors	=	"";
            $validator = Validator::make($row,
                [
                    "Consignee Name" 					=> ["required","string","max:90"],
                    'Consignee Address' 				=> ['required','string','max:450'],
                    'Consignee Mobile' 			        => ['required','string','max:50'],
                    'Consignee Email' 					=> ['string','max:90'],
                    'Destination City' 					=> ['required','string','max:100'],
                    'Pieces' 					        => ['required','numeric','digits_between:1,10'],
                    'Weight' 					        => ['required','numeric'],
                    'COD Amount' 		                => ['required','numeric'],
                    'Customer Reference Number' 		=> ['string','max:50'],
                    'Special Handling' 				    => ['string','max:3'],
                    'Service Type' 	                    => ['required','string','max:50'],
                    'Product Details' 		            => ['string','alpha_dash', 'max:999'],
                    'Remarks' 		                    => ['string','max:450'],
                    'Insurance/DeclaredValue' 		    => ['string', 'max:300000'],
                ]);
            $responce  = array();

            //If validation fails
            if ($validator->errors()->count() > 0)
            {
                $errors .= " " . $validator->errors();
            }
            $city_name =  City::where('name', '=',$row["Destination City"])->first();
            if($city_name == null)
            {
                $errors .= "City not exist Please add correct one . ";
            }
            else
            {
                $row["Destination City"] = $city_name->id;
                $row["destination_country"] = $city_name->country_id;
            }

            $servies =  services::where('service_name', '=',$row["Service Type"])->first();
            if($servies == null)
            {
                $errors .= "Service not exist Please add correct one . ";
            }
            else
            {
                $row["Service Type"] = $servies->id;

            }
            if(strtolower($row["Special Handling"]) == "yes" || strtolower($row["Special Handling"]) == "no")
            {
                $row["Special Handling"] =  $row["Special Handling"] == "yes" ? 1 :0;
            }
            else{
                $errors .= "Special Handling value should be in yes or no. ";
            }
            if($errors != "")
            {
                $responce[] ="<br><span style='color: red' >Row # $rowNumber. Error: ".$errors ."</span>";
                continue;
            }
        }
        foreach($csvData as $row) {
            if (sizeof($responce) == 0) {

                if ($this->addOrderBooking($row, $customer->id) > 0) ;
                {
                    $responce[] = "<br><span style='color: green' >Row # $rowNumber.  " . " Record Has been Successfully added" . "</span>";
                }
            }
        }

        $isEnable = 1;
        //print_r($responce);
        return view('booking.bulkbooking.index', compact('isEnable','responce'));
    }

    public function addOrderBooking($row, $id){

        $city_name =  City::where('name', '=',$row["Destination City"])->first();
        if($city_name != null)
        {
            $row["Destination City"] = $city_name->id;
            $row["destination_country"] = $city_name->country_id;
        }
        $servies =  services::where('service_name', '=',$row["Service Type"])->first();
        if($servies != null)
        {
            $row["Service Type"] = $servies->id;

        }

        $row["Special Handling"] =  $row["Special Handling"] == "yes" ? 1 :0;

        $orderbooking = new OrderBooking();
        $orderbooking->cn_no = mt_rand();
        $orderbooking->cost_center = 1;
        //$orderbooking->customer_ref  = $row["customer_ref"];
        $orderbooking->consignee_id  = $id;
        $orderbooking->delivery_type  = 1;
        $orderbooking->customer_name  = $row["Consignee Name"];
        $orderbooking->customer_address  = $row["Consignee Address"];
        $orderbooking->customer_Contact_number  = $row["Consignee Mobile"];
        $orderbooking->customer_email  = $row["Consignee Email"];
        $orderbooking->customer_contact_person  = $row["Customer Reference Number"];
        $orderbooking->pieces  = $row["Pieces"];
        $orderbooking->weight  = $row["Weight"];
        $orderbooking->fragile  = 0;
        //$orderbooking->origin  = $row["origin"];
        $orderbooking->destination_country  = $row["destination_country"];
        $orderbooking->destination_city  = $row["Destination City"];
        $orderbooking->cod_amount  = $row["COD Amount"];
        $orderbooking->product_detail  = $row["Product Details"];
        $orderbooking->insurance_declared_value  = $row["Insurance/Declared Value"];
        $orderbooking->service  = $row["Service Type"];
        $orderbooking->remarks  = $row["Remarks"];
        $orderbooking->special_handling = $row["Special Handling"];
        $orderbooking->created_at = date("Y/m/d H:s:i");
        $orderbooking->save();

        $this->createcn($orderbooking->id);

        return $orderbooking->id;
    }
    public function createcn($id)
    {
        $orderno = OrderBooking::where('id','=', $id)->first();
        $orderno->cn_no = str_pad($id, 11, '1000000000', STR_PAD_LEFT);
        $orderno->save();
    }
    //Convert CSV data to array
    function csvToArray($filename = '', $delimiter = ',')
    {
        if (!file_exists($filename) || !is_readable($filename))
        {
            $response['success']	=	false;
            $response['error']		=	"File not found !";
            return $response;
        }

        $header = null;
        $data 	= array();

        if (($handle = fopen($filename, 'r')) !== false)
        {
            while (($row = fgetcsv($handle, 4096, $delimiter)) !== false)
            {
                if (!$header)
                {
                    $header = $row;

                    //Required CSV columns
                    $requiredColumns	=	['Consignee Name','Consignee Address','Consignee Address','Consignee Mobile','Consignee Email','Destination City','Pieces','Weight','COD Amount','Customer Reference Number','Special Handling','Service Type','Product Details','Remarks','Insurance/Declared Value'];

                    //Columns for update
                    $validColumns		=	['Consignee Name','Consignee Address','Consignee Address','Consignee Mobile','Consignee Email','Destination City','Pieces','Weight','COD Amount','Customer Reference Number','Special Handling','Service Type','Product Details','Remarks','Insurance/Declared Value'];

                    //Validate required columns
                    $validate = array_intersect($requiredColumns,$header);

                    //Validate columns
                    $existColumns = array_intersect($validColumns,$header);

                    //Validate attributes required for product update
                    if(!(count($existColumns) > 0))
                    {
                        $response['success']	=	false;
                        $response['error']		=	"Please specify mention attribute for updated.";
                        return $response;
                    }

                    //Validate required attributes
                    if($validate != $requiredColumns)
                    {
                        $response['success']	=	false;
                        $response['error']		=	"Required attribute is missing. Please review CSV";
                        return $response;
                    }

                    //Validate columns
                    if(in_array('',$header) || in_array(NULL,$header))
                    {
                        $response['success']	=	false;
                        $response['error']		=	"Invalid CSV column. Please review CSV";
                        return $response;
                    }
                }
                else
                {
                    $data[] = array_combine($header, $row);
                }
            }
            fclose($handle);
        }

        $response['success']	=	true;
        $response['data']		=	$data;
        return $response;
    }

    public function loadsheetViewlist(){
        return view('booking.loadsheet.index');
    }

    public function loadsheetGridData()
    {
        GridEncoder::encodeRequestedData(new LoadsheetDataRepository(), Input::all());
    }

    public function grenerateloadsheetdata(Request $request)
    {
        $error = "";
        $order_booking = array();
        $customer = Customer::where('user_id','=',Auth::user()->id)->first();
        if($customer == null)
        {
            $error = "Only customer can generate the Loadsheet";
        }
        else
        {
            $itemIDs = $request->get('itemIds');
            if (sizeof($itemIDs) > 0) {
                $order_booking = OrderBooking::leftjoin('city', 'city.id','=','order_booking.destination_city')
                    ->select('city.name as destination_city_name', 'order_booking.id', 'order_booking.cn_no', 'order_booking.weight', 'order_booking.pieces', 'order_booking.cod_amount')
                    ->whereIn('order_booking.id',$itemIDs)->get();

            }
        }
        return view('booking.loadsheet.loadsheetdata', compact('order_booking','error'));
    }

    public function greneratepickupdata(Request $request)
    {
        $items = Input::get('itemArray');
        if(sizeof($items)>0) {
            $customer = Customer::where('user_id','=',Auth::user()->id)->first();
            $loadsheet = new LoadsheetData();
            $loadsheet->consignee_id = $customer->id;
            $loadsheet->loadsheet_no = str_pad(mt_rand(), 13, '0', STR_PAD_LEFT);
            $loadsheet->created_at = date('Y/m/d H:s:i');
            $loadsheet->save();
            $loadsheet_no = $loadsheet->id;
            foreach($items as $item_id){
                $order = OrderBooking::where('id','=',$item_id )->first();
                if($order != null)
                {
                    $order->loadsheet_no = $loadsheet_no;
                    $order->save();
                }
            }
        }
        return redirect('/transaction/loadsheetlist');

    }

    public function Loadsheetlist(){
        return view('booking.loadsheet.loadsheetlist');
    }
    public function LoadsheetListGridData()
    {
        GridEncoder::encodeRequestedData(new LoadsheetPickupDataRepository(), Input::all());
    }

    public function loadsheetpickuplist($id){
        $loadsheetprint = LoadsheetData::join('order_booking','order_booking.loadsheet_no','=','loadsheet_data.id')
            ->leftjoin('city', 'city.id','=','order_booking.destination_city')
            ->leftjoin('customer','customer.id', '=','order_booking.consignee_id')
            ->select('customer.id as cus_id','customer.business_name','customer.owner_name','loadsheet_data.loadsheet_no','city.name as destination_city_name', 'order_booking.id', 'order_booking.cn_no', 'order_booking.weight', 'order_booking.pieces', 'order_booking.cod_amount')
                ->where('loadsheet_data.id','=',$id)->get();

        return view('booking.loadsheet.loadsheetprint', compact('loadsheetprint'));

    }
    public function SecurityScan(){

        return view('booking.securityscan.securityscan');
    }
    public function getsecurityscandata(Request $request){
        $data = $request->input();
        $itemdata = OrderBooking::leftjoin('customer','order_booking.consignee_id','=','customer.id')
            ->leftjoin('city','order_booking.destination_city','=','city.id')
            ->leftjoin('city as city_cus','customer.city_id','=','city_cus.id')
        ->select('customer.business_name as cus_first_name','customer.owner_name as cus_last_name','customer.contact_no as cus_contact_no','city_cus.name as cus_city_name',
            'order_booking.cn_no','order_booking.customer_name','order_booking.customer_address','order_booking.customer_Contact_number','order_booking.customer_email',
            'order_booking.customer_contact_person','order_booking.pieces','order_booking.weight','order_booking.cod_amount','order_booking.loadsheet_no')
            ->where('order_booking.cn_no','=',$data["cn_no"])
            ->where('order_booking.is_security_scan','=',DB::raw('0'))->first();
        if($itemdata != null)
        {
            return json_encode($itemdata);
        }else{
            return json_encode("This Consigment # not Available");
        }
    }

    public function SecurityScanDataSave(Request $request){
        $data = $request->input();
        if(sizeof($data["cn_no"]) > 0)
        {
            foreach ($data["cn_no"] as $item) {
                if($item != "")
                {
                    $scurityscan =  OrderBooking::where('cn_no','=',$item)->first();
                    if($scurityscan != null)
                    {
                        $scurityscan->is_security_scan = 1;
                        $scurityscan->save();
                    }
                }
            }
        }
        else
        {
            echo "no Consigment No found";
        }
        return redirect('/transaction/securityscandatalist');
    }

    public function SecurityScanList(){
        return view('booking.securityscan.index');
    }

    public function SecurityScanListGridData()
    {
        GridEncoder::encodeRequestedData(new SecurityScanDataRepository(), Input::all());
    }
}
