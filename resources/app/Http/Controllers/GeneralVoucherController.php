<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\GeneralVoucher\general_voucher;
use App\Model\GeneralVoucher\general_voucher_details;
use App\Model\GeneralVoucher\generalVoucherDataRepository;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use Mgallegos\LaravelJqgrid\Facades\GridEncoder;
use Response;
use Redirect;
use Session;
use DB,Log,Auth;
use App\Model\ChartofAccount\chartofaccount;
class GeneralVoucherController extends Controller
{
    public function GeneralVoucherHome()
    {
        return view('finance.generalVoucher.index');
    }
     
    public function GeneralVoucherGridData()
    {
        GridEncoder::encodeRequestedData(new generalVoucherDataRepository(), Input::all());
    }

    public function GeneralVoucherAdd()
    {
        $chartofaccounts = chartofaccount::get();
        return view('finance.generalVoucher.create',compact('chartofaccounts'));
    }

    public function GeneralVoucherStore(Request $request)
    {
        $transaction_date = $request->input('transaction_date');
        $due_date = $request->input('due_date');
        $remarks = $request->input('m_remarks');
        $debit_total = $request->input('debitTotal');
        $credit_total = $request->input('creditTotal');

        $general_voucher = new general_voucher();
        $general_voucher->transaction_date = $transaction_date;
        $general_voucher->due_date = $due_date;
        $general_voucher->remarks = $remarks;
        $general_voucher->debit_total = $debit_total;
        $general_voucher->credit_total = $credit_total;
        $general_voucher->created_by = Auth::User()->id;
        $general_voucher->created_at = date("Y-m-d H:i:s");
        $general_voucher->save();
        
        $masterID = $general_voucher->id;

        $accountID = $request->input('account');
        $loop=0;
        foreach($accountID as $row){
            $general_voucher_details = new general_voucher_details();
                $general_voucher_details->master_id  = $masterID;
                $general_voucher_details->account_id = $request->input('account')[$loop];
                $general_voucher_details->debit      = $request->input('debit')[$loop];
                $general_voucher_details->credit     = $request->input('credit')[$loop];
                $general_voucher_details->remarks    = $request->input('remarks')[$loop];
                $general_voucher_details->save();
            $loop++;
        }

        return redirect('/Finance/General-Voucher');

    }

    public function GeneralVoucherEdit($id)
    {
        $chartofaccounts = chartofaccount::get();
        $generalVoucher = general_voucher::where('id','=',$id)->first();
        $generalVoucherDetails = general_voucher_details::where('master_id','=',$id)->get();
        return view('finance.generalVoucher.edit',compact('chartofaccounts','generalVoucher','generalVoucherDetails'));
    }

    public function GeneralVoucherUpdate(Request $request)
    {
        $generalVoucherID = $request->input('generalVoucherID');

        $transaction_date = $request->input('transaction_date');
        $due_date = $request->input('due_date');
        $remarks = $request->input('m_remarks');
        $debit_total = $request->input('debitTotal');
        $credit_total = $request->input('creditTotal');

        $general_voucher = general_voucher::where('id','=',$generalVoucherID)->first();
        $general_voucher->transaction_date = $transaction_date;
        $general_voucher->due_date = $due_date;
        $general_voucher->remarks = $remarks;
        $general_voucher->debit_total = $debit_total;
        $general_voucher->credit_total = $credit_total;
        $general_voucher->updated_by = Auth::User()->id;
        $general_voucher->updated_at = date("Y-m-d H:i:s");
        $general_voucher->save();
        
        $detail_id = $request->input('detail_id');
        $loop=0;
        
        
        foreach($detail_id as $row){
            $general_voucher_details = general_voucher_details::where("id",'=',$detail_id[$loop])
            ->where("master_id",'=',$generalVoucherID)->first();
                $general_voucher_details->account_id = $request->input('account')[$loop];
                $general_voucher_details->debit      = $request->input('debit')[$loop];
                $general_voucher_details->credit     = $request->input('credit')[$loop];
                $general_voucher_details->remarks    = $request->input('remarks')[$loop];
                $general_voucher_details->save();
            $loop++;
        }

        $removeRow = $request->input('RemoveRow');
        foreach($removeRow as $removeRowID){
            
            general_voucher_details::where("id",'=',$removeRowID)->delete();
        }

      return redirect('/Finance/General-Voucher');
    }
    public function GeneralVoucherView($id)
    {
        $chartofaccounts = chartofaccount::get();
        $generalVoucher = general_voucher::where('id','=',$id)->first();
        $generalVoucherDetails = general_voucher_details::where('master_id','=',$id)->get();
        return view('finance.generalVoucher.view',compact('chartofaccounts','generalVoucher','generalVoucherDetails'));
    }

    public function GeneralVoucherDelete($id)
    {
        return view('finance.generalVoucher.delete', compact('id'));
    }
    public function GeneralVoucherDeleted(Request $request)
    {
        //voucher_id

        $id = $request->input('voucher_id');
        $general_voucher = general_voucher::find($id);

        $general_voucher->delete();

        general_voucher_details::where("master_id",'=',$id)->delete();

        return redirect('/Finance/General-Voucher');
    }
}
