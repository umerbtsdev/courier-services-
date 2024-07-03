<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\Accounts\accounts;
use App\Model\Accounts\accountsDataRepository;
use App\Model\Banks\Banks;
use App\Model\Cities\cities;
use App\Model\BankBranches\BankBranches;
use Mgallegos\LaravelJqgrid\Facades\GridEncoder;
use Illuminate\Support\Facades\Input;
use Auth,Illuminate\Support\Facades\DB, Illuminate\Support\Facades\Redirect;
use App\Model\ChartofAccount\chartofaccount;
class BankAccountsController extends Controller
{
     
    public function AccountsHome()
    {
        return view('accounts.index');
    }
    public function AccountsGridData()
    {
        GridEncoder::encodeRequestedData(new accountsDataRepository(), Input::all());
    }
    public function AccountsAdd()
    {
        $banks = Banks::all();
        
        return view('accounts.create',compact('banks'));
    }
    public function AccountsSave(Request $request)
    {
        
        $chartofaccountBank = chartofaccount::where('name','=','Bank')->first();
        if($chartofaccountBank == null){
            $request->session()->flash('alert-danger',"Please Create Bank Head");
            return Redirect::to('General-Setup/Accounts');
        }
        $chartofaccountBankID = $chartofaccountBank->id;
        
        $chartofaccountNew = new chartofaccount();
            $chartofaccountNew->name = $request->input("bank_name")." - ".$request->input("account_num");
            $chartofaccountNew->level = 3;
            $chartofaccountNew->parent_id = $chartofaccountBankID;
            $chartofaccountNew->created_at = date('Y-m-d H:i:s');
        $chartofaccountNew->save();

        $coa_code = $chartofaccountNew->id;
        $data = [
            "bank_id" => $request->input('bank_id'),
            "acc_number" => $request->input('account_num'),
            "acc_title" => $request->input('account_title'),
            "iban" => $request->input('account_iban'),
            "branch_id" => $request->input('bank_branch'),
            "created_by" => Auth::user()->id,
            "created_at" => date('Y-m-d H:i:s'),
            "coa_code"  => $coa_code
            
        ];
        accounts::insert($data);
        return redirect('General-Setup/Accounts');

    }
    public function AccountsEdit($id)
    {
        $banks = Banks::all();
        $account = accounts::find($id);
        $BankBranches = BankBranches::where("bank_id","=",$account->bank_id)->get();
        return view('accounts.edit',compact('banks','account','BankBranches'));
    }
    public function AccountsUpdate(Request $request)
    {
        $coa = $request->input('coa_code');
        $chartofaccount = chartofaccount::find($coa);
            $chartofaccount->name = $request->input("bank_name")." - ".$request->input("account_num");
        $chartofaccount->save();

        $id = $request->input("account_id");
        $account = accounts::find($id);
            $account->bank_id = $request->input('bank_id');
            $account->acc_number = $request->input('account_num');
            $account->acc_title = $request->input('account_title');
            $account->iban = $request->input('account_iban');
            $account->branch_id = $request->input('bank_branch');
            $account->updated_by = Auth::user()->id;
            $account->updated_at = date('Y-m-d H:i:s');
        $account->save();
        return redirect('General-Setup/Accounts');
    }
    public function AccountsDelete($id)
    {
        return view('accounts.delete',compact('id'));
    }
    public function AccountsDeleted(Request $request)
    {
        $id = $request->input('account_id');
        $BankBranches = accounts::where('id','=',$id)->first();
        chartofaccount::find($BankBranches->coa_code)->delete();
        $BankBranches->delete();
        return redirect('General-Setup/Accounts');
    }


    public function MakeAccountPrimary($id)
    {
        $accounts = accounts::join("fi_banks",'fi_accounts.bank_id','=','fi_banks.bank_id')
        ->join("fi_bank_branches",'fi_accounts.branch_id','=','fi_bank_branches.id')
        ->where('fi_accounts.id','=',$id)
        ->select('fi_accounts.*','fi_banks.bank_name','fi_bank_branches.branch_name')
        ->first();
        return view('accounts.makePrimary', compact('accounts'));
    }

    public function MakePrimaryAccount(Request $request)
    {
        $account_id = $request->input('account_id');
        $account_title = $request->input('account_title');
        $bank_name = $request->input('bank_name');
        $branch_name = $request->input('branch_name');

        $OldPrimaryAccounts = accounts::where('is_primary','=','1')->get();
        foreach ($OldPrimaryAccounts as $PrimaryAccount) {
            $OldPrimaryAccount = accounts::find($PrimaryAccount->id);
            $OldPrimaryAccount->is_primary = 0;
            $OldPrimaryAccount->save();
        }
            

        $NewPrimaryAccount = accounts::find($account_id);
            $NewPrimaryAccount->is_primary = 1;
        if ($NewPrimaryAccount->save()) {
            $request->session()->flash('alert-success', "<b>".$account_title."&quot;s</b> Account at <b>".$bank_name."</b>-<b>".$branch_name."</b> has been made Primary");
        }
            return Redirect::to('General-Setup/Accounts');
    }



 //#region for ajax

    public function GetBranchFromBank($id)
    {
         $user_company = BankBranches::join('fi_banks','fi_bank_branches.bank_id','=','fi_banks.bank_id')
             ->where('fi_banks.bank_id','=', $id)
             ->get()->toArray();
             echo json_encode($user_company);
    }

 //#endregion
}
