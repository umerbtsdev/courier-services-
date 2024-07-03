<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Mgallegos\LaravelJqgrid\Facades\GridEncoder;
use App\Model\ChartofAccount\chartofaccount;
use Auth,DB,Redirect,Session;
use App\Model\Invoices\invoices;
use Illuminate\Support\Facades\Input;
use App\Model\InvoiceReceivables\InvoiceReceivables;
use App\Model\InvoiceReceivables\InvoiceReceivablesDataRepository;
use App\Helper\Common;
use App\Model\Accounts\Accounts;
class InvoiceAmountReceivableController extends Controller
{
    public function InvoiceAmountReceivableHome()
    {
        return view('InvoiceAmountReceivable.index');
    }

    public function InvoiceAmountReceivableGridData()
    {
        GridEncoder::encodeRequestedData(new InvoiceReceivablesDataRepository(), Input::all());
    }

    public function InvoiceAmountReceivableCreate()
    {
        $coa = chartofaccount::where('name','like',"%bank%")->orWhere('name','like',"%cash")->get();
        
        $invoices = invoices::all();
        
        return view('InvoiceAmountReceivable.create', compact('coa','invoices'));

    }

    public function InvoiceAmountReceivableSave(Request $request)
    {
        $msg= ""; $type="invoice";
        $invoiceID = $request->input('invoice');
        $invoice = invoices::find($invoiceID);
        $total_billed = $invoice->total_billed;
        $date_paid = $request->input('date_paid');
        $coa_id = $request->input('coa_list');
        
        
        try {
            $ExpensePayment = new InvoiceReceivables();
                $ExpensePayment->invoice_id = $invoice->id;
                $ExpensePayment->total_paid = $total_billed;
                $ExpensePayment->paid_date = $date_paid;
                $ExpensePayment->coa_id = $coa_id;
                $ExpensePayment->created_by = Auth::User()->id;
                $ExpensePayment->created_at = date('Y-m-d H:i:s');
            $ExpensePayment->save();


            $accounts = Accounts::where('is_primary','=',1)->first();
            Common::makeTransaction($accounts->coa_code,$type,$invoice->id,$total_billed,$date_paid,"debit");
            Common::makeTransaction($accounts->coa_code,$type,$invoice->id,$total_billed,$date_paid,"credit");

            $msg = "Payment Created";
            $type = "success";
        } catch (\Throwable $th) {
          
           $msgs = explode("'",$th->errorInfo[2]);
           
           if($msgs[0] == "Duplicate entry " && $msgs[3] == "unique"){
               $data = explode("-",$msgs[1]);
              
               $invoiceID = $data[0];
               $date = $data[3]."-".$data[2]."-".$data[1];

            $msg = "Payment for Invoice # ".$invoiceID." on Date ".$date." has already been made!";
           }
           $type = "danger";
        }

        Session::flash('msg', $msg);
        Session::flash('msgtype', $type);
        
        return redirect('/Finance/Invoice-Amount-Receivable');
        //return Redirect::back()->withErrors(['msg', $msg]);
       
    }
}
