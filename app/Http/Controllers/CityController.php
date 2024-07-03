<?php

namespace App\Http\Controllers;

use App\Model\Countries\Countries;
use Illuminate\Http\Request;
use App\Model\Machines\MaintenanceRequest;
use Mgallegos\LaravelJqgrid\Facades\GridEncoder;
use App\Model\Dashboard\MaintenancerequestDataRepositery;
use App\Model\Dashboard\ProjectwiseDataRepositery;
use App\Model\Dashboard\SchedulewiseDataRepositery;
use App\Model\CityManagment\CityDataRepository;
use Illuminate\Support\Facades\Input;
use DB;
use App\Model\CityManagment\City;

class CityController extends Controller
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
        return view('cities.index');
    }    

    public function create()
    {
        $countries = Countries::all();
        return view('cities.create', compact('countries'));
    }   
    public function CityGridData()
    {   
     GridEncoder::encodeRequestedData(new CityDataRepository(), Input::all());
    }

    public function store(Request $request)
    {

        $city = new City();
        $city->country_id  = $request->country_id;
        $city->name = $request->name;
        $city->save();

        return redirect('setup/city');
    
    }


public function edit($id)
{
    $countries = Countries::all();
    $city = City::select('id','name','country_id')->where('id', $id)->first();
    return view('cities.edit', compact('city', 'countries'));
}   


public function update(Request $request, $id)
{   

        if(empty($request->name)){
      
            return redirect('setup/city/edit/'.$id);
        }else{
   
        $city = City::findOrfail($id);
        $city->country_id  = $request->country_id;
        $city->name = $request->name;

        $city->save();

        return redirect('setup/city');

        }
}   


 public function destroyview($id)
{
    $countries = Countries::all();
        $city =  City::select('id','name','country_id')->where('id', $id)->first();
        return view('cities.delete', compact('city','countries'));
}

 public function destroy($id)
{
        $city = City::findOrfail($id);

        $city->delete();

        return redirect('setup/city');

}
}
