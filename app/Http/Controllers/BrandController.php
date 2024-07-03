<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Mgallegos\LaravelJqgrid\Facades\GridEncoder;
use App\Model\Dashboard\MaintenancerequestDataRepositery;
use App\Model\Dashboard\ProjectwiseDataRepositery;
use App\Model\Dashboard\SchedulewiseDataRepositery;
use App\Model\BrandManagment\BrandDataRepository;
use Illuminate\Support\Facades\Input;
use DB;
use App\Model\BrandManagment\Brand;

class BrandController extends Controller
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
        return view('brand.index');
    }    

    public function create()
    {
        return view('brand.create');
    }   
    public function BrandGridData()
    {   
     GridEncoder::encodeRequestedData(new BrandDataRepository(), Input::all());
    }

    public function store(Request $request)
    {

        $brand = new brand();
        $brand->name = $request->name;
        $brand->save();

        return redirect('General-Setup/brandinfo');
    
    }


public function edit($brand_id)
{
    $brand = Brand::select('id','name')->where('id', $brand_id)->first();
    return view('brand.edit', compact('brand'));
}   


public function update(Request $request, $brand_id)
{   

        if(empty($request->name)){
      
            return redirect('brand/edit/'.$brand_id);
        }else{
   
        $brand = Brand::findOrfail($brand_id);

        $brand->name = $request->name;

        $brand->save();

        return redirect('General-Setup/brandinfo');

        }
}   


 public function destroyview($brand_id)
{
        $brand =  Brand::select('id','name')->where('id', $brand_id)->first();
        return view('brand.delete', compact('brand'));
}


 public function destroy($brand_id)
{
        $brand = Brand::findOrfail($brand_id);

        $brand->delete();

        return redirect('General-Setup/brandinfo');

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
