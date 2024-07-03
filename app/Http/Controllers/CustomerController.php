<?php

namespace App\Http\Controllers;

use App\Model\CityManagment\City;
use App\Model\Countries\Countries;
use App\Model\CustomerManagment\CustomerApproveDataRepository;
use App\User;
use Illuminate\Http\Request;
use Mgallegos\LaravelJqgrid\Facades\GridEncoder;
use App\Model\Dashboard\MaintenancerequestDataRepositery;
use App\Model\Dashboard\ProjectwiseDataRepositery;
use App\Model\Dashboard\SchedulewiseDataRepositery;
use App\Model\CustomerManagment\CustomerDataRepository;
use Illuminate\Support\Facades\Input;
use DB;
use App\Model\CustomerManagment\Customer;

class CustomerController extends Controller
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
        return view('customer.index');
    }    

public function create()
    {
        $cities = City::all();
        $countries = Countries::all();
        return view('customer.create', compact('cities','countries'));
    }   
public function CustomerGridData()
    {   
     GridEncoder::encodeRequestedData(new CustomerDataRepository(), Input::all());
    }

public function store(Request $request)
    {
        try{
            $users = new User();
            $users->name = $request->first_name." ".$request->last_name;
            $users->email = $request->email;
            $users->password  = bcrypt($request->password);
            $users->save();
            $user_id = $users->id;

            $customer = new Customer();
            $customer->first_name = $request->first_name;
            $customer->last_name = $request->last_name;
            $customer->email = $request->email;
            $customer->country_id = $request->country_id;
            $customer->contact_no = $request->contact_no;
            $customer->alernate_no = $request->alernate_no;
            $customer->country_id = $request->country_id;
            $customer->city_id = $request->city_id;
            $customer->address = $request->address;
            $customer->cnic = $request->cnic;
            $customer->bank_name = $request->bank_name;
            $customer->branch_name = $request->branch_name;
            $customer->account_no = $request->account_no;
            $customer->account_title = $request->account_title;
            $customer->brith_date = $request->brith_date;
            $customer->anniversary_date = $request->anniversary_date;
            $customer->user_id = $user_id;
            $customer->save();

        }catch(\Exception $e){

        }

        return redirect('customer');
    
    }
    public function CustomerApprove()
    {
        return view('customer.customerapprove');
    }
    public function CustomerApproveGridData()
    {
        GridEncoder::encodeRequestedData(new CustomerApproveDataRepository(), Input::all());
    }
public function CustomerApproval($id)
{
    $customer = Customer::where('id','=',$id)->first();
    $cities = City::all();
    $countries = Countries::all();
    return view('customer.approve', compact('customer','cities','countries'));
}
    public function CustomerDisable($id)
    {
        $customer = Customer::where('id','=',$id)->first();
        $cities = City::all();
        $countries = Countries::all();
        return view('customer.disable', compact('customer','cities','countries'));
    }
    public function ApproveDataCustomer(Request $request, $id){
          $customer =   Customer::where('id','=', $id)->first();
          if($customer != null)
          {
              $user = User::where('id','=', $customer->user_id)->first();
              $user->status = 1;
              $user->save();
          }
        return redirect('customer/customeapprovals');
    }
    public function DisableDataCustomer(Request $request, $id){
        $customer =   Customer::where('id','=', $id)->first();
        if($customer != null)
        {
            $user = User::where('id','=', $customer->user_id)->first();
            $user->status = 0;
            $user->save();
        }
        return redirect('customer/customeapprovals');
    }
public function edit($id)
{
    $customer = Customer::where('id', $id)->first();
    return view('customer.edit', compact('customer'));
}   


public function update(Request $request, $id)
{
        $customer = Customer::findOrfail($id);

        $customer->name = $request->name;
        $customer->phone_no = $request->phone_no;
        $customer->address = $request->address;

        $customer->save();

        return redirect('General-Setup/customerinfo');


}   


 public function destroyview($id)
    {
        $customer =  Customer::where('id', $id)->first();
        return view('customer.delete', compact('customer'));

        

    }

 public function destroy(Request $request, $id)
    {
        $alert = Customer::findOrfail($id);

        $alert->delete();

        return redirect('General-Setup/customerinfo');

        }

}
