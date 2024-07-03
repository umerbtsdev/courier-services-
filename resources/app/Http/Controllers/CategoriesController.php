<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\Machines\MaintenanceRequest;
use Mgallegos\LaravelJqgrid\Facades\GridEncoder;
use App\Model\Dashboard\MaintenancerequestDataRepositery;
use App\Model\Dashboard\ProjectwiseDataRepositery;
use App\Model\Dashboard\SchedulewiseDataRepositery;
use App\Model\CategoriesManagment\CategoriesDataRepository;
use Illuminate\Support\Facades\Input;
use DB;
use App\Model\CategoriesManagment\Categories;

class CategoriesController extends Controller
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
        return view('categories.index');
    }    

    public function create()
    {
        return view('categories.create');
    }   
    public function CatGridData()
    {   
     GridEncoder::encodeRequestedData(new CategoriesDataRepository(), Input::all());
    }

    public function store(Request $request)
    {

        $cat = new Categories();
        $cat->name = $request->name;
        $cat->description = $request->discrp;
        $cat->save();

        return redirect('General-Setup/categoriesinfo');
    
    }


public function edit($cat_id)
{
    $cat = Categories::select('id','name', 'description')->where('id', $cat_id)->first();
    return view('categories.edit', compact('cat'));
}   


public function update(Request $request, $cat_id)
{   

        if(empty($request->name || $request->description)){
      
            return redirect('categories/update/'.$cat_id);
        }else{
   
        $cat = Categories::findOrfail($cat_id);

        $cat->name = $request->name;
        $cat->description = $request->descrp;

        $cat->save();

        return redirect('General-Setup/categoriesinfo');

        }
}   

public function destroyview($cat_id)
{
        $cat =  Categories::select('id','name', 'description')->where('id', $cat_id)->first();
        return view('categories.delete', compact('cat'));
}


 public function destroy($cat_id)
{
        $cat = Categories::findOrfail($cat_id);

        $cat->delete();

        return redirect('General-Setup/categoriesinfo');

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
