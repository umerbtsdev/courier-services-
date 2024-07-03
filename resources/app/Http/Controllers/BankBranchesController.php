<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\Banks\Banks;
use App\Model\Cities\cities;
use App\Model\BankBranches\BankBranches;
use App\Model\BankBranches\BankBranchesDataRepository;
use Mgallegos\LaravelJqgrid\Facades\GridEncoder;
use Illuminate\Support\Facades\Input;
use Auth;
class BankBranchesController extends Controller
{
    public function BankBranchesHome()
    {
        return view('bankBranches.index');
    }
    public function BankBranchesGridData()
    {
        GridEncoder::encodeRequestedData(new BankBranchesDataRepository(), Input::all());
    }
    public function BankBranchesAdd()
    {
        $banks = Banks::all();
        $cities = cities::all();
        return view('bankBranches.create',compact('banks','cities'));
    }
    public function BankBranchesSave(Request $request)
    {
        
        $data = [
            "bank_id" => $request->input('bank_id'),
            "city_id" => $request->input('city_id'),
            "branch_name" => $request->input('branch_name')

        ];

        BankBranches::insert($data);
        return redirect('General-Setup/Banks/Branches');

    }
    public function BankBranchesEdit($id)
    {
        $bankbranches = BankBranches::where('id','=',$id)->get()->first();
        $banks = Banks::all();
        $cities = cities::all();
        return view('bankBranches.edit',compact('banks','cities','bankbranches'));
    }
    public function BankBranchesUpdate(Request $request)
    {
        $id = $request->input("branch_id");
        $BankBranches = BankBranches::where('bank_id','=',$id)->first();
            $BankBranches->bank_id  = $request->input('bank_id');
            $BankBranches->city_id = $request->input('city_id');
            $BankBranches->branch_name = $request->input('branch_name');
        $BankBranches->save();
        return redirect('General-Setup/Banks/Branches');
    }
    public function BankBranchesDelete($id)
    {
        return view('bankBranches.delete',compact('id'));
    }
    public function BankBranchesDeleted(Request $request)
    {
        $id = $request->input('bank_branch_id');
        $BankBranches = BankBranches::where('id','=',$id);
        $BankBranches->delete();
        return redirect('General-Setup/Banks/Branches');
    }
}
