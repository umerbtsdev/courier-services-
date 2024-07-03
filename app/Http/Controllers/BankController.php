<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\Banks\Banks;
use App\Model\Banks\BanksDataRepository;
use Mgallegos\LaravelJqgrid\Facades\GridEncoder;
use Illuminate\Support\Facades\Input;
use Auth;
class BankController extends Controller
{
    public function BanksHome()
        {
            return view('banks.index');
        }
        public function BankGridData()
        {
            GridEncoder::encodeRequestedData(new BanksDataRepository(), Input::all());
        }
        public function BankAdd()
        {
            return view('banks.create');
        }
        public function BankSave(Request $request)
        {
            
            $data = [
                "bank_name" => $request->bankName,
                "created_at" => date('Y-m-d H:i:s'),
                "created_by" => Auth::user()->id
            ];

            Banks::insert($data);
            return redirect('/General-Setup/Banks');

        }
        public function BankEdit($id)
        {
            $bank = Banks::where('bank_id','=',$id)->get()->first();
            return view('banks.edit',compact('bank'));
        }
        public function BankUpdate(Request $request)
        {
            $id = $request->input("bankID");
            $bank = banks::where('bank_id','=',$id)->first();
                $bank->bank_name  = $request->bank_name;
                $bank->updated_at = date('Y-m-d H:i:s');
                $bank->updated_by = Auth::user()->id;
            $bank->save();
            return redirect('/General-Setup/Banks');
        }
        public function BankDelete($id)
        {
            return view('banks.delete',compact('id'));
        }
        public function BankDeleted(Request $request)
        {
            $id = $request->input('bank_id');
            $Bank = Banks::where('bank_id','=',$id);
            $Bank->delete();
            return redirect('/General-Setup/Banks');
        }
}
