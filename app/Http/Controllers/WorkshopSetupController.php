<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Mgallegos\LaravelJqgrid\Facades\GridEncoder;
use Illuminate\Support\Facades\Input;
use DB,Auth;
use App\Model\Workshop\workshops;
use App\Model\Workshop\workshopsDataRepository;


class WorkshopSetupController extends Controller
{
    public function WorkshopHome(){
        return view('workshop.index');
    }
    public function WorkshopAdd()
    {
        return view('workshop.create');
    }
    public function WorkshopGridData()
    {
        GridEncoder::encodeRequestedData(new workshopsDataRepository(), Input::all());
    }

    public function WorkshopSave(Request $request)
    {
        $workshop_name = $request->input('workshop_name');
        $workshop_location = $request->input('workshop_location');
        
        $data = [
            'workshop_name'=> $workshop_name,
            'workshop_location' => $workshop_location,
            'created_by' => Auth::User()->id,
            'created_at' => date('Y-m-d H:i:s')
        ];
        if(workshops::insert($data)){
            return redirect('setup/workshops');
        }
    }
    public function WorkshopEdit($id)
    {
        $workshop = workshops::where('workshop_id','=',$id)->first();

        return view('workshop.edit', compact('workshop'));

    }

    public function WorkshopUpdate(Request $request)
    {
        $id =  $request->input('workshop_id');

        $data=[
            'workshop_name' => $request->input('workshop_name'),
            'workshop_location' => $request->input('workshop_location'),
            'updated_by' => Auth::User()->id,
            'updated_at' => date('Y-m-d H:i:s')

        ];
        
        if(workshops::where('workshop_id','=',$id)->update($data)){
            return redirect('General-Setup/workshops');
        }

    }
    public function WorkshopDelete($id)
    {
        return view('workshop.delete', compact('id'));
    }
    public function WorkshopDeleted(Request $request)
    {
        $id = $request->input('workshop_id');
        workshops::where('workshop_id','=',$id)->delete();
        return redirect('General-Setup/workshops');
    }

}
