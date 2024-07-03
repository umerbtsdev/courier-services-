<?php

namespace App\Http\Controllers;

use App\Model\Countries\Countries;
use App\Model\Countries\CountriesDataRepository;
use Illuminate\Http\Request;
use Mgallegos\LaravelJqgrid\Facades\GridEncoder;
use Illuminate\Support\Facades\Input;
use DB;
use App\Model\CityManagment\City;

class CountriesController extends Controller
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
        return view('countries.index');
    }    

    public function create()
    {
        return view('countries.create');
    }   
    public function CountriesGridData()
    {   
     GridEncoder::encodeRequestedData(new CountriesDataRepository(), Input::all());
    }

    public function store(Request $request)
    {

        $countries = new Countries();
        $countries->name = $request->name;
        $countries->save();

        return redirect('Setup/Countries');
    
    }


public function edit($id)
{
    $countries = Countries::select('id','name')->where('id', $id)->first();
    return view('countries.edit', compact('countries'));
}   


public function update(Request $request, $id)
{   

        if(empty($request->name)){
      
            return redirect('city/edit/'.$id);
        }else{
   
        $countries = Countries::findOrfail($id);

        $countries->name = $request->name;

        $countries->save();

        return redirect('setup/countries');

        }
}   


 public function destroyview($id)
{
        $countries =  Countries::select('id','name')->where('id', $id)->first();
        return view('countries.delete', compact('countries'));
}

 public function destroy($id)
{
        $countries = Countries::findOrfail($id);

        $countries->delete();

        return redirect('setup/countries');

}


}
