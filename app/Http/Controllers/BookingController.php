<?php

namespace App\Http\Controllers;

use App\Model\Booking\OrderBooking;
use App\Model\CityManagment\City;
use App\Model\CostCenterManagment\CostCenter;
use App\Model\Countries\Countries;
use App\Model\CustomerManagment\Customer;
use App\Model\DeliveryType\DeliveryType;
use App\Model\Services\services;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookingController extends Controller
{
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
            $orderbooking->customer_contact_person  = $allfeild["customer_contact_person"];
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
        return redirect('/transaction/bookinglist');

       // print_r($allfeild);
        //echo mt_rand();
    }

    public function delete_Order($id){

    //     dd($id);
    //     if(!empty($id)){    

    //         echo "ID Exits:";


    //     }else() {
    //             foreach ($variable as $key => $value) {

    //         $orderbooking->id  = $allfeild["pieces"];
    //         $orderbooking->origin  = $allfeild["weight"];
    //         $orderbooking->fragile  = $allfeild["fragile"];
    //         $orderbooking->origin  = $allfeild["origin"];
    //         $orderbooking->destination_country  = $allfeild["destination_country"];
    //         $orderbooking->destination_city  = $allfeild["destination_city"];
    //         $orderbooking->cod_amount  = $allfeild["cod_amount"];
        
    //        }


    //     }

    // }



    public function BookingGridData()
    {
        GridEncoder::encodeRequestedData(new BookingsDataRepository(), Input::all());
    }
}
