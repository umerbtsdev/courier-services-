<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Mgallegos\LaravelJqgrid\Facades\GridEncoder;
use App\Model\ChartofAccount\chartofaccount;
use Auth,DB;
use Illuminate\Support\Facades\Input;
use App\Model\ExpensePayments\ExpensePayment;
use App\Model\ExpensePayments\ExpensePaymentDataRepository;
use App\Model\Invoices\invoices;
use App\Helper\Common;
class ExpensePaymentController extends Controller
{
    public function ExpensePaymentHome()
    {
        return view('ExpensePayment.index');
    }

    public function ExpensePaymentGridData()
    {
        GridEncoder::encodeRequestedData(new ExpensePaymentDataRepository(), Input::all());
    }
    
    public function ExpensePaymentCreate()
    {
        $coa = chartofaccount::where('name','like',"%bank%")->orWhere('name','like',"%cash")->get();
        
        $invoices = invoices::all();
        
        return view('ExpensePayment.create', compact('coa','invoices'));
    }

    public function ExpensePaymentSave(Request $request)
    {
        $invoiceID = $request->input('invoice');
        $invoice = invoices::find($invoiceID);
        $invoiceExpense = $invoice->total_expenses;
        $date_paid = $request->input('date_paid');
        $coa_id = $request->input('coa_list');
 
        $invoices = invoices::join('invoices_detail_trips','invoices_master.id','=','invoices_detail_trips.invoice_id')
        ->leftjoin('trip_expense','invoices_detail_trips.trip_id','=','trip_expense.trip_id')
        ->leftjoin('trip_fuel','invoices_detail_trips.trip_id','=','trip_fuel.trip_id')
        ->leftjoin('accounts','trip_expense.expense_ac_id','=','accounts.id')
        ->leftjoin('accounts as accounts_fuel','trip_expense.expense_ac_id','=','accounts_fuel.id')
        ->where('invoices_master.id','=',$invoiceID)
        ->select('accounts.id' ,'accounts.coa_id','accounts.name', 
            DB::raw('SUM(trip_expense.amount) AS ammount'),'accounts_fuel.coa_id', 'accounts_fuel.name', 
            DB::raw('SUM(trip_fuel.amount) AS fuel_amount'), 
            'trip_fuel.account_id')

        ->groupBy('accounts.id' ,'accounts.coa_id','accounts.name','trip_expense.amount','accounts_fuel.coa_id',
        'accounts_fuel.name','trip_fuel.amount','trip_fuel.account_id')
        ->get();

        
        $type = "expense";
        $Total_coa_amount = 0;
        $transactionDate = $date_paid;
        $referenceID = $invoiceID;
        $fuel_accountID = 0; $fuel_amount = 0;  $fuel_account_id= 0;
        $i = 0;
        foreach ($invoices as $invoice) {          
            $accountID = $invoice->coa_id;
            $amount = $invoice->ammount;
            Common::makeTransaction($accountID,$type,$referenceID,$amount,$transactionDate,"debit");
            $Total_coa_amount += $amount;
            $fuel_accountID = $invoice->account_id; 
            $fuel_amount = $invoice->fuel_amount;
            
            if($i == (count($invoices) - 1)){
                $Total_coa_amount += $fuel_amount;
                Common::makeTransaction($fuel_accountID,$type,$referenceID,$fuel_amount,$transactionDate,"debit");
            }
            $i++;

        }

        Common::makeTransaction($coa_id,$type,$referenceID,$Total_coa_amount,$transactionDate,"credit");

        $ExpensePayment = new ExpensePayment();
            $ExpensePayment->invoice_id = $invoiceID;
            $ExpensePayment->total_expense = $invoiceExpense;
            $ExpensePayment->paid_date = $date_paid;
            $ExpensePayment->coa_id = $coa_id;
            $ExpensePayment->created_by = Auth::User()->id;
            $ExpensePayment->created_at = date('Y-m-d H:i:s');
        $ExpensePayment->save();
        
        return redirect('/Finance/Expense-Payment');


    }
}
