<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\ChartofAccount\chartofaccount;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use Response;
use Redirect;
use Session;
use DB,Log;
class ChartOfAccountController extends Controller
{
    public function chartofaccountHome(){

        $charts = chartofaccount::where('level', '<=', 5)->get();
        return view('finance.chartOfAccount.index',compact('charts'));
    }
    public function saveChild(Request $request)
    {
        try {
            if ($request->input('level') <=5) {

                $validator = Validator::make(Input::all(), [
                    'child' => 'required|max:250',
                    'level' => 'required',
                    'masterID' => 'required',
                    'op_dr' => 'nullable',
                    'op_cr' => 'nullable',

        
                ], [
                    'required' => 'Please Enter :attribute',
                    'max' => 'The :attribute must not exceed limit :max.'
                ]);

                if ($validator->fails()) {
                    Session::flash('alert-danger', $validator);
                   // return Redirect::back();
        
                }
                else{
                    $data = [
                        "name" =>$request->input('child'),
                        "level" => $request->input('level') + 1,
                        "parent_id" => $request->input('masterID'),
                        "created_at" => date("Y-m-d H:i:s"),
                        "op_dr" => $request->input('op_dr'),
                        "op_cr" => $request->input('op_cr')
                    ];
                   // dd($data);
                    $chartofaccount = chartofaccount::insert($data);
                }
            }
            else{
                //max lvl is 5
                Session::flash('alert-danger', 'Child add limit reached!');
               return Redirect::back();
            }
            
        } catch (\Throwable $th) {
            Log::error($th->getMessage());
        }
        return redirect('/Finance/Chart-of-Account');
       
    }
}
