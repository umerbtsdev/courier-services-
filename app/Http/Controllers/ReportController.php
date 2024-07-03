<?php

namespace App\Http\Controllers;

use App\Model\Designation\Designation;
use App\Model\Form\FormImgData;
use App\Model\PaymentTerms\PaymentTerms;
use App\Model\TripManagement\Tripdata;
use App\Model\VehiclesManagment\Vehicles;
use function foo\func;
use Request;
use App\Model\Account\FormApproveReject;
use App\Model\Employee\EmployeeDataRepositery;
use App\Model\businesstype\BusinessType;
use Redirect,Auth,DB;

class ReportController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function Index()
    {
        $vehicles =  Vehicles::all();
        return view('report.monthlytransport', compact('vehicles'));
    }


    public function monthWiseTransport($id = null)
    {
        $vehicles =  Vehicles::all();
        $data = Request::all();

        if(sizeof($data) > 0 && isset($data["date_from"]) && isset($data["date_to"]))
        {
            $monthwisereport = Tripdata::leftjoin('trip_expense',function($join){
                $join->on('trip.id','=','trip_expense.trip_id');
                $join->on('trip_expense.expense_ac_id', '=',DB::Raw('7'));
            })
                ->join('road_receipt_data','road_receipt_data.id', '=','trip.roadreceipt_id')

                ->leftjoin('trip_expense as tem',function($join){
                    $join->on('trip.id','=','tem.trip_id');
                    $join->on('tem.expense_ac_id','=',DB::Raw('8'));
                })
                ->leftjoin('trip_fuel', function($join){
                    $join->on('trip.id', '=', 'trip_fuel.trip_id');
                    $join->on('trip_fuel.account_id', '=', DB::Raw('6') );
                })
                ->leftjoin('roadreceipt_income as tii', function($join){
                    $join->on('road_receipt_data.id' ,'=', 'tii.roadreceipt_id');
                    $join->on('tii.income_ac_id', '=', DB::Raw('4'));
                })
                ->leftjoin('roadreceipt_income as tid', function($join){
                    $join->on('road_receipt_data.id', '=', 'tid.roadreceipt_id');
                    $join->on('tid.income_ac_id', '=',  DB::Raw('5'));
                })
                ->leftjoin('trip_route','trip.id','=','trip_route.trip_id')
                ->select('trip.id', 'trip.trip_date',DB::Raw('SUM(tii.amount) AS Billed'), DB::Raw('SUM(tid.amount) AS Detention'), DB::Raw('SUM(trip_fuel.`amount`) AS Diesel'),
                    DB::Raw("SUM(trip_expense.`amount`) AS driver_allowance"), DB::Raw("SUM(tem.`amount`) AS misc"),
                    'trip.reading_start', 'trip.reading_end',DB::Raw('GROUP_CONCAT(trip_route.remarks) AS remarks'))
                ->where('road_receipt_data.vehicle_id','=',$data["vehicle_id"])
                ->where(DB::Raw('CONVERT(road_receipt_data.rr_date,DATE)'),'>=',$data["date_from"])
                ->where(DB::Raw('CONVERT(road_receipt_data.rr_date,DATE)'),'<=',$data["date_to"])
                ->groupBy('trip.id','trip.reading_start','trip.reading_end','trip.trip_date','trip.vehicle_id')
                    ->get();
        }
        return view('report.monthlytransport',compact('monthwisereport','data', 'vehicles'));

    }

    public function vehiclemonthwise(Request $request)
    {
        $vehicle_id = $request->vehicle_id;
        $date_from = $request->date_from;
        $date_to = $request->date_to;

        $monthwisereport = Tripdata::leftjoin('trip_expense',function($join){
            $join->on('trip.id','=','trip_expense.trip_id');
            $join->on('trip_expense.expense_ac_id', '=',DB::Raw('7'));
        })
            ->join('road_receipt_data','road_receipt_data.id', '=','trip.roadreceipt_id')
            ->join('vehicles','vehicles.id', '=','road_receipt_data.vehicle_id')
            ->join('drivers','drivers.id', '=','vehicles.driver')
            ->leftjoin('trip_expense as tem',function($join){
                $join->on('trip.id','=','tem.trip_id');
                $join->on('tem.expense_ac_id','=',DB::Raw('8'));
            })
            ->leftjoin('trip_fuel', function($join){
                $join->on('trip.id', '=', 'trip_fuel.trip_id');
                $join->on('trip_fuel.account_id', '=', DB::Raw('6') );
            })
            ->leftjoin('roadreceipt_income as tii', function($join){
                $join->on('road_receipt_data.id' ,'=', 'tii.roadreceipt_id');
                $join->on('tii.income_ac_id', '=', DB::Raw('4'));
            })
            ->leftjoin('roadreceipt_income as tid', function($join){
                $join->on('road_receipt_data.id', '=', 'tid.roadreceipt_id');
                $join->on('tid.income_ac_id', '=',  DB::Raw('5'));
            })
            ->leftjoin('trip_route','trip.id','=','trip_route.trip_id')
            ->select(DB::Raw('COUNT(trip.id) trips'),  DB::Raw('COUNT(tid.amount) AS Detentions'),
                DB::Raw('(IFNULL(vehicles.purchase_amount,0) / IFNULL(vehicles.life,0)) AS deperciation'),
                DB::Raw('drivers.salary_package'),DB::Raw('SUM(IFNULL(tii.amount,0)) AS Billed'),
                DB::Raw('SUM(IFNULL(tid.amount,0)) AS Detention'),
                DB::Raw('(SUM(IFNULL(tii.amount,0)) + SUM(IFNULL(tid.amount,0))) AS total_billed'),
                DB::Raw('SUM(IFNULL(trip_fuel.`amount`,0)) AS Diesel'),
                DB::Raw('SUM(trip_expense.`amount`) AS driver_allowance'),
                DB::Raw('SUM(tem.`amount`) AS misc'),
                DB::Raw('(SUM(IFNULL(trip_fuel.`amount`,0)) + SUM(trip_expense.`amount`) + SUM(tem.`amount`)) AS total_expense'),
                DB::Raw('(SUM(IFNULL(tii.amount,0)) + SUM(IFNULL(tid.amount,0))) - (SUM(IFNULL(trip_fuel.`amount`,0)) + SUM(trip_expense.`amount`) + SUM(tem.`amount`)) AS total_gain'))
            ->where('road_receipt_data.vehicle_id','=',$vehicle_id)
            ->where(DB::Raw('CONVERT(road_receipt_data.rr_date,DATE)'),'>=',$date_from)
            ->where(DB::Raw('CONVERT(road_receipt_data.rr_date,DATE)'),'<=',$date_to)
            ->groupBy('trip.vehicle_id')
            ->get();
            
        return view('report.monthlytransport',compact('monthwisereport','data', 'vehicles'));
    }




}
