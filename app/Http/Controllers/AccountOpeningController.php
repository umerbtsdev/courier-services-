<?php

namespace App\Http\Controllers;

use App\Model\Account\ApprovalCommitHistory;
use App\Model\Designation\Designation;
use App\Model\Form\FormImgData;
use App\Model\PaymentTerms\PaymentTerms;
use App\Permission\Models\Permission;
use App\User;
use App\Model\Email\EmailRecords;
use Faker\Provider\DateTime;
use Illuminate\Http\Request;
use App\Model\Account\FormApproveReject;
use App\Model\Employee\EmployeeDataRepositery;
use App\Model\businesstype\BusinessType;
use Mgallegos\LaravelJqgrid\Facades\GridEncoder;
use App\Model\Account\Account;
use App\Model\Account\AccountDataRepositery;
use App\Helper\Common;
use Mockery\Exception;
use Redirect,Auth,DB;

class AccountOpeningController extends Controller
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
        return view('accountopening.index');
    }

    public function Create()
    {
        $payment =PaymentTerms::get();

        $businesstype = BusinessType::get();
        return view('accountopening.create', compact('businesstype', 'payment'));
    }
    public function storeaccountdata($data, $account, $request, $status = null){
        if(isset($data["gynaecology"]))
        {
            $account->gynaecology =$data["gynaecology"]== "on" ? 1 : 0;
        }
        if(isset($data["oncology"]))
        {
            $account->oncology =$data["oncology"]== "on" ? 1 : 0;
        }
        if(isset($data["thalassaemia"]))
        {
            $account->thalassaemia =$data["thalassaemia"]== "on" ? 1 : 0;
        }
        if(isset($data["gastro_nephrology"]))
        {
            $account->gastro_nephrology =$data["gastro_nephrology"]== "on" ? 1 : 0;
        }
        if(isset($data["hiv_aids"]))
        {
            $account->hiv_aids =$data["hiv_aids"] == "on" ? 1 : 0;
        }
        $account->name_of_business =$data["name_of_business"];
        $account->owner_name =$data["owner_name"];
        $account->qualification_patient_load =$data["qualification_patient_load"];
        $account->contact_person =$data["contact_person"];
        $account->designation_id =$data["designation_id"];
        $account->cnic_no =$data["cnic_no"];
        $account->ntn_no =$data["ntn_no"];
        $account->address_of_business =$data["address_of_business"];
        $account->type_of_business =$data["type_of_business"];
        $account->phone_number =$data["phone_number"];
        $account->mobile_number =$data["mobile_number"];
        $account->fax_number =$data["fax_number"];
        $account->email_address =$data["email_address"];
        if(isset($data["credit_limit_requested"]))
        {
            $account->credit_limit_requested =$data["credit_limit_requested"];
        }
        if(isset($data["credit_days_requested"])) {
            $account->credit_days_requested = $data["credit_days_requested"];
        }
        if(isset($data["annual_anticipated_business"])) {
            $account->annual_anticipated_business = $data["annual_anticipated_business"];
        }
        if(isset($data["credit_validity_period"]))
        {
            $account->credit_validity_period =$data["credit_validity_period"];
        }
        $account->remarks =$data["remarks"];
        $account->payment_terms_id =$data["payment_terms_id"];

        $account->is_updateable = 0;
        $account->is_closed = 0;
        if ($status == 1)
        {
            $account->created_by = Auth::User()->id;
            $account->created_datetime = date('Y-m-d H:s:i');
        }
        else{
            $account->updated_by = Auth::User()->id;
            $account->updated_datetime = date('Y-m-d H:s:i');
        }
        $account->save();
        $formid = $account->id;
       // print_r($request->file('image'));
       // exit();
        if ($request->hasFile('image')) {
            $this->saveProductImages($request->file('image'),$formid);
        }
    }
    public function saveProductImages($files, $formid)
    {
        foreach ($files as $file)
        {
            $filename = Common::storeFile($file, 'accountopening');
            $formimg = new FormImgData();
            $formimg->form_id = $formid;
            $formimg->type_id = "1";
            $formimg->src = $filename;
            $formimg->save();
        }
    }

    public function AccountSave(Request $request)
    {
        try{
            $data = $request->input();
            $account = new Account();

            $this->storeaccountdata($data, $account, $request, 1);

            $formapprove = new FormApproveReject();
            $formapprove->form_id =$account->id;
            $formapprove->create_date =date("Y-m-d H:i:s");
            $formapprove->type_id = 1;
            $formapprove->from_level_enable_1 =1;
            $formapprove->save();
            //$this->MachineScheduleStore($data, $machineid);
            $senddata =  $this->Emailsend('Account opening from level 1',"Created");
            $request->session()->flash('alert-success', "Your Form Sccessfully Added");
        }catch (Exception $e){
            $request->session()->flash('alert-danger', $e->getMessage());
        }


        return Redirect::to('account-openning');
    }

    public function Accountgriddata($id = null)
    {
        GridEncoder::encodeRequestedData(new AccountDataRepositery(),null);
    }

    public function AccountopenningEdit($id)
    {
        $account_openning_data = Account::leftjoin('form_approve_reject',function($join){
            $join->on('form_approve_reject.form_id','=','account.id');
            $join->on('form_approve_reject.type_id','=',DB::Raw('1'));
        })->select('account.id','account.gynaecology','account.oncology','account.thalassaemia','account.gastro_nephrology','account.hiv_aids','account.name_of_business',
            'account.owner_name','account.qualification_patient_load','account.contact_person','account.designation_id','account.cnic_no','account.ntn_no',
            'account.address_of_business','account.type_of_business','account.phone_number','account.mobile_number','account.fax_number','account.email_address',
            'account.credit_limit_requested','account.credit_days_requested','account.annual_anticipated_business','account.credit_validity_period','account.remarks',
            'account.is_updateable','account.payment_terms_id','form_approve_reject.from_level_enable_1','form_approve_reject.from_level_1','form_approve_reject.from_level_1_comment','form_approve_reject.from_level_1_approve_by','form_approve_reject.from_level_1_datetime',
            'form_approve_reject.from_level_enable_2','form_approve_reject.from_level_2','form_approve_reject.from_level_2_comment','form_approve_reject.from_level_2_approve_by','form_approve_reject.from_level_2_datetime',
            'form_approve_reject.from_level_enable_3','form_approve_reject.from_level_3','form_approve_reject.from_level_3_comment','form_approve_reject.from_level_3_approve_by','form_approve_reject.from_level_3_datetime',
            'form_approve_reject.from_level_enable_4','form_approve_reject.from_level_4','form_approve_reject.from_level_4_comment','form_approve_reject.from_level_4_approve_by','form_approve_reject.from_level_4_datetime',
            'form_approve_reject.from_level_enable_5','form_approve_reject.from_level_5','form_approve_reject.from_level_5_comment','form_approve_reject.from_level_5_approve_by','form_approve_reject.from_level_5_datetime',
            'form_approve_reject.from_level_enable_6','form_approve_reject.from_level_6','form_approve_reject.from_level_6_comment','form_approve_reject.from_level_6_approve_by','form_approve_reject.from_level_6_datetime',
            'form_approve_reject.from_level_enable_7','form_approve_reject.from_level_7','form_approve_reject.from_level_7_comment','form_approve_reject.from_level_7_approve_by','form_approve_reject.from_level_7_datetime',
            'form_approve_reject.from_level_enable_8','form_approve_reject.from_level_8','form_approve_reject.from_level_8_comment','form_approve_reject.from_level_8_approve_by','form_approve_reject.from_level_8_datetime',
            'form_approve_reject.from_level_enable_9','form_approve_reject.from_level_9','form_approve_reject.from_level_9_comment','form_approve_reject.from_level_9_approve_by','form_approve_reject.from_level_9_datetime',
            'form_approve_reject.from_level_enable_10','form_approve_reject.from_level_10','form_approve_reject.from_level_10_comment','form_approve_reject.from_level_10_approve_by','form_approve_reject.from_level_10_datetime',
            'form_approve_reject.is_closed')->where('account.id','=',$id)->first();
        $payment =PaymentTerms::get();
        $businesstype = BusinessType::get();
        $user_data = User::whereIn('id', [$account_openning_data->from_level_1_approve_by, $account_openning_data->from_level_2_approve_by,
            $account_openning_data->from_level_3_approve_by,$account_openning_data->from_level_4_approve_by,$account_openning_data->from_level_5_approve_by,
            $account_openning_data->from_level_6_approve_by,$account_openning_data->from_level_7_approve_by,$account_openning_data->from_level_8_approve_by,
            $account_openning_data->from_level_9_approve_by, $account_openning_data->from_level_10_approve_by])->get();
        $form_images = FormImgData::where('form_id', '=',$id)->get();

        if ($account_openning_data->is_updateable == 0 )
        {
            $updatelock = 0;
        }else{
            $updatelock = 1;
        }


        return view('accountopening.edit', compact('businesstype','payment','account_openning_data','updatelock','user_data','form_images'));
    }
    public function AccountSaveUpdate(Request $request,$id)
    {
        try{
            $data = $request->input();
            $account = Account::where('id','=', $id)->first();

            $this->storeaccountdata($data, $account, $request,2);

            $formapprove = FormApproveReject::where('type_id', '=', DB::raw('1') )
                ->where('form_id','=', $account->id)->first();
            $formapprove->from_level_enable_1 =1;
            $formapprove->from_level_1 = null;
            $formapprove->from_level_1_comment = null;
            $formapprove->from_level_1_approve_by = null;
            $formapprove->from_level_1_datetime = null;

            $formapprove->from_level_enable_2 =null;
            $formapprove->from_level_2 = null;
            $formapprove->from_level_2_comment = null;
            $formapprove->from_level_2_approve_by = null;
            $formapprove->from_level_2_datetime = null;

            $formapprove->from_level_enable_3 =null;
            $formapprove->from_level_3 = null;
            $formapprove->from_level_3_comment = null;
            $formapprove->from_level_3_approve_by = null;
            $formapprove->from_level_3_datetime = null;

            $formapprove->from_level_enable_4 =null;
            $formapprove->from_level_4 = null;
            $formapprove->from_level_4_comment = null;
            $formapprove->from_level_4_approve_by = null;
            $formapprove->from_level_4_datetime = null;

            $formapprove->from_level_enable_5 =null;
            $formapprove->from_level_5 = null;
            $formapprove->from_level_5_comment = null;
            $formapprove->from_level_5_approve_by = null;
            $formapprove->from_level_5_datetime = null;

            $formapprove->from_level_enable_6 =null;
            $formapprove->from_level_6 = null;
            $formapprove->from_level_6_comment = null;
            $formapprove->from_level_6_approve_by = null;
            $formapprove->from_level_6_datetime = null;

            $formapprove->from_level_enable_7 =null;
            $formapprove->from_level_7 = null;
            $formapprove->from_level_7_comment = null;
            $formapprove->from_level_7_approve_by = null;
            $formapprove->from_level_7_datetime = null;

            $formapprove->from_level_enable_8 =null;
            $formapprove->from_level_8 = null;
            $formapprove->from_level_8_comment = null;
            $formapprove->from_level_8_approve_by = null;
            $formapprove->from_level_8_datetime = null;

            $formapprove->from_level_enable_9 =null;
            $formapprove->from_level_9 = null;
            $formapprove->from_level_9_comment = null;
            $formapprove->from_level_9_approve_by = null;
            $formapprove->from_level_9_datetime = null;

            $formapprove->from_level_enable_10 =null;
            $formapprove->from_level_10 = null;
            $formapprove->from_level_10_comment = null;
            $formapprove->from_level_10_approve_by = null;
            $formapprove->from_level_10_datetime = null;

            $formapprove->save();
            //$this->MachineScheduleStore($data, $machineid);
            $senddata =  $this->Emailsend('Account opening from level 1',"Updated");
            $request->session()->flash('alert-success', "Your Form Sccessfully Updated");
        }catch (Exception $e){
            $request->session()->flash('alert-danger', $e->getMessage());
        }


        return Redirect::to('account-openning');
    }

    public function AccountopenningView($id)
    {
        $payment =PaymentTerms::get();
        $businesstype = BusinessType::get();
        $account_openning_data = Account::leftjoin('form_approve_reject',function($join){
            $join->on('form_approve_reject.form_id','=','account.id');
            $join->on('form_approve_reject.type_id','=',DB::Raw('1'));
        })->select('account.id','account.gynaecology','account.oncology','account.thalassaemia','account.gastro_nephrology','account.hiv_aids','account.name_of_business',
            'account.owner_name','account.qualification_patient_load','account.contact_person','account.designation_id','account.cnic_no','account.ntn_no',
            'account.address_of_business','account.type_of_business','account.phone_number','account.mobile_number','account.fax_number','account.email_address',
            'account.credit_limit_requested','account.payment_terms_id','account.credit_days_requested','account.annual_anticipated_business','account.credit_validity_period','account.remarks',
            'form_approve_reject.from_level_enable_1','form_approve_reject.from_level_1','form_approve_reject.from_level_1_comment','form_approve_reject.from_level_1_approve_by','form_approve_reject.from_level_1_datetime',
            'form_approve_reject.from_level_enable_2','form_approve_reject.from_level_2','form_approve_reject.from_level_2_comment','form_approve_reject.from_level_2_approve_by','form_approve_reject.from_level_2_datetime',
            'form_approve_reject.from_level_enable_3','form_approve_reject.from_level_3','form_approve_reject.from_level_3_comment','form_approve_reject.from_level_3_approve_by','form_approve_reject.from_level_3_datetime',
            'form_approve_reject.from_level_enable_4','form_approve_reject.from_level_4','form_approve_reject.from_level_4_comment','form_approve_reject.from_level_4_approve_by','form_approve_reject.from_level_4_datetime',
            'form_approve_reject.from_level_enable_5','form_approve_reject.from_level_5','form_approve_reject.from_level_5_comment','form_approve_reject.from_level_5_approve_by','form_approve_reject.from_level_5_datetime',
            'form_approve_reject.from_level_enable_6','form_approve_reject.from_level_6','form_approve_reject.from_level_6_comment','form_approve_reject.from_level_6_approve_by','form_approve_reject.from_level_6_datetime',
            'form_approve_reject.from_level_enable_7','form_approve_reject.from_level_7','form_approve_reject.from_level_7_comment','form_approve_reject.from_level_7_approve_by','form_approve_reject.from_level_7_datetime',
            'form_approve_reject.from_level_enable_8','form_approve_reject.from_level_8','form_approve_reject.from_level_8_comment','form_approve_reject.from_level_8_approve_by','form_approve_reject.from_level_8_datetime',
            'form_approve_reject.from_level_enable_9','form_approve_reject.from_level_9','form_approve_reject.from_level_9_comment','form_approve_reject.from_level_9_approve_by','form_approve_reject.from_level_9_datetime',
            'form_approve_reject.from_level_enable_10','form_approve_reject.from_level_10','form_approve_reject.from_level_10_comment','form_approve_reject.from_level_10_approve_by','form_approve_reject.from_level_10_datetime',
            'form_approve_reject.is_closed')
            ->where('account.id','=',$id)->first();
        $user_data = User::whereIn('id', [$account_openning_data->from_level_1_approve_by, $account_openning_data->from_level_2_approve_by,
            $account_openning_data->from_level_3_approve_by,$account_openning_data->from_level_4_approve_by,$account_openning_data->from_level_5_approve_by,
            $account_openning_data->from_level_6_approve_by,$account_openning_data->from_level_7_approve_by,$account_openning_data->from_level_8_approve_by,
            $account_openning_data->from_level_9_approve_by, $account_openning_data->from_level_10_approve_by])->get();
        $form_images = FormImgData::where('form_id', '=',$id)->get();
        $approval = Common::userwisepermission(Auth::user()->id, "Account openning Approval");
        return view('accountopening.view', compact('businesstype','payment','account_openning_data','approval','user_data', 'form_images'));
    }
    public function AccountopenningViewonly($id)
    {
        $payment =PaymentTerms::get();
        $businesstype = BusinessType::get();
        $account_openning_data = Account::leftjoin('form_approve_reject',function($join){
            $join->on('form_approve_reject.form_id','=','account.id');
            $join->on('form_approve_reject.type_id','=',DB::Raw('1'));
        })->select('account.id','account.gynaecology','account.oncology','account.thalassaemia','account.gastro_nephrology','account.hiv_aids','account.name_of_business',
            'account.owner_name','account.qualification_patient_load','account.contact_person','account.designation_id','account.cnic_no','account.ntn_no',
            'account.address_of_business','account.type_of_business','account.phone_number','account.mobile_number','account.fax_number','account.email_address',
            'account.credit_limit_requested','account.payment_terms_id','account.credit_days_requested','account.annual_anticipated_business','account.credit_validity_period','account.remarks',
            'form_approve_reject.from_level_enable_1','form_approve_reject.from_level_1','form_approve_reject.from_level_1_comment','form_approve_reject.from_level_1_approve_by','form_approve_reject.from_level_1_datetime',
            'form_approve_reject.from_level_enable_2','form_approve_reject.from_level_2','form_approve_reject.from_level_2_comment','form_approve_reject.from_level_2_approve_by','form_approve_reject.from_level_2_datetime',
            'form_approve_reject.from_level_enable_3','form_approve_reject.from_level_3','form_approve_reject.from_level_3_comment','form_approve_reject.from_level_3_approve_by','form_approve_reject.from_level_3_datetime',
            'form_approve_reject.from_level_enable_4','form_approve_reject.from_level_4','form_approve_reject.from_level_4_comment','form_approve_reject.from_level_4_approve_by','form_approve_reject.from_level_4_datetime',
            'form_approve_reject.from_level_enable_5','form_approve_reject.from_level_5','form_approve_reject.from_level_5_comment','form_approve_reject.from_level_5_approve_by','form_approve_reject.from_level_5_datetime',
            'form_approve_reject.from_level_enable_6','form_approve_reject.from_level_6','form_approve_reject.from_level_6_comment','form_approve_reject.from_level_6_approve_by','form_approve_reject.from_level_6_datetime',
            'form_approve_reject.from_level_enable_7','form_approve_reject.from_level_7','form_approve_reject.from_level_7_comment','form_approve_reject.from_level_7_approve_by','form_approve_reject.from_level_7_datetime',
            'form_approve_reject.from_level_enable_8','form_approve_reject.from_level_8','form_approve_reject.from_level_8_comment','form_approve_reject.from_level_8_approve_by','form_approve_reject.from_level_8_datetime',
            'form_approve_reject.from_level_enable_9','form_approve_reject.from_level_9','form_approve_reject.from_level_9_comment','form_approve_reject.from_level_9_approve_by','form_approve_reject.from_level_9_datetime',
            'form_approve_reject.from_level_enable_10','form_approve_reject.from_level_10','form_approve_reject.from_level_10_comment','form_approve_reject.from_level_10_approve_by','form_approve_reject.from_level_10_datetime',
            'form_approve_reject.is_closed')
            ->where('account.id','=',$id)->first();
        $user_data = User::whereIn('id', [$account_openning_data->from_level_1_approve_by, $account_openning_data->from_level_2_approve_by,
            $account_openning_data->from_level_3_approve_by,$account_openning_data->from_level_4_approve_by,$account_openning_data->from_level_5_approve_by,
            $account_openning_data->from_level_6_approve_by,$account_openning_data->from_level_7_approve_by,$account_openning_data->from_level_8_approve_by,
            $account_openning_data->from_level_9_approve_by, $account_openning_data->from_level_10_approve_by])->get();
        $form_images = FormImgData::where('form_id', '=',$id)->get();
        $approval = Common::userwisepermission(Auth::user()->id, "Account openning Approval");
        return view('accountopening.viewonly', compact('businesstype','payment','account_openning_data','approval','user_data', 'form_images'));
    }
    public function approvalcommenthistory($data , $id){

        $commithistory = new ApprovalCommitHistory();
        $commithistory->approval_name ="Account opening form Approval";
        $commithistory->approve_by_id = Auth::User()->id;
        $commithistory->form_id =$id;
        $commithistory->comment_type =$data["submit"] == "reject" ? 0 : 1;
        $commithistory->approve_by_comment = $data["comment_remarks"];
        $commithistory->approve_datetime =  date("Y-m-d H:i:s");
        $commithistory->save();
    }
    public function approvalmasseage($request){
        $request->session()->flash('alert-danger', "You Don't have the permission to Approve or Reject the Form");
        return Redirect::to('account-openning');
    }
    public function Emailsend($permissionname, $status)
    {
        $rejectuserdatas =Permission::join('role_has_permissions', 'permissions.id', '=', 'role_has_permissions.permission_id')
        ->join('model_has_roles', 'model_has_roles.role_id', '=', 'role_has_permissions.role_id')
        ->join('users' ,'users.id' ,'=', 'model_has_roles.model_id')
        ->where('permissions.name','=' ,$permissionname)
        ->select('users.email','users.name')->get();
        foreach($rejectuserdatas as $rejectuserdata){
            $data = array("status"=>$status,"sendername"=>Auth::User()->name,"type"=>"Account Opening Form", "senddate"=>date('d-M-Y H:i:s'));
            $results = Common::sendmail($data, $rejectuserdata->email, $rejectuserdata->name, "new account openning");
            $emailrecords = new EmailRecords();
            $emailrecords->mailto = $rejectuserdata->email;
            $emailrecords->mailto = $rejectuserdata->name;
            $emailrecords->mailto = $results;
            $emailrecords->save();
        }
    }
    public function AccountApprovalUpdate(Request $request,$id)
    {
        $doc_close_check = Account::where('id','=',$id)->first();
        if ($doc_close_check->is_closed == 1){
            $request->session()->flash('alert-danger', "This Document alredy closed");
            return Redirect::to('account-openning');
        }
        $data = $request->input();
        $formapprove = FormApproveReject::where('type_id', '=', DB::raw('1') )
            ->where('form_id','=', $id)->first();

        if($formapprove != null){
            if($data["submit"] == "reject")
            {
                if(Common::userwisepermission(Auth::user()->id, "Account opening from level 1") || Common::userwisepermission(Auth::user()->id, "Account opening from level 2") || Common::userwisepermission(Auth::user()->id, "Account opening from level 3") || Common::userwisepermission(Auth::user()->id, "Account opening from level 4") || Common::userwisepermission(Auth::user()->id, "Account opening from level 5") || Common::userwisepermission(Auth::user()->id, "Account opening from level 6") || Common::userwisepermission(Auth::user()->id, "Account opening from level 7") || Common::userwisepermission(Auth::user()->id, "Account opening from level 8") || Common::userwisepermission(Auth::user()->id, "Account opening from level 9") || Common::userwisepermission(Auth::user()->id, "Account opening from level 10"))
                {
                    $this->approvalcommenthistory($data,$id);
                    $account_openning_data = Account::where('id','=',$id)->first();
                    if($formapprove->from_level_enable_1 == 1)
                    {
                        $formapprove->from_level_1 = 0;
                        $formapprove->from_level_1_comment = $data["comment_remarks"];
                        $formapprove->from_level_1_approve_by = Auth::User()->id;
                        $formapprove->from_level_1_datetime = date("Y-m-d H:i:s");

                    }
                    else if($formapprove->from_level_enable_2 == 1)
                    {
                        $formapprove->from_level_2 = 0;
                        $formapprove->from_level_2_comment = $data["comment_remarks"];
                        $formapprove->from_level_2_approve_by = Auth::User()->id;
                        $formapprove->from_level_2_datetime = date("Y-m-d H:i:s");

                    }
                    else if($formapprove->from_level_enable_3 == 1)
                    {
                        $formapprove->from_level_3 = 0;
                        $formapprove->from_level_3_comment = $data["comment_remarks"];
                        $formapprove->from_level_3_approve_by = Auth::User()->id;
                        $formapprove->from_level_3_datetime = date("Y-m-d H:i:s");

                    }else if($formapprove->from_level_enable_4 == 1)
                    {
                        $formapprove->from_level_4 = 0;
                        $formapprove->from_level_4_comment = $data["comment_remarks"];
                        $formapprove->from_level_4_approve_by = Auth::User()->id;
                        $formapprove->from_level_4_datetime = date("Y-m-d H:i:s");

                    }
                    else if($formapprove->from_level_enable_5 == 1)
                    {
                        $formapprove->from_level_5 = 0;
                        $formapprove->from_level_5_comment = $data["comment_remarks"];
                        $formapprove->from_level_5_approve_by = Auth::User()->id;
                        $formapprove->from_level_5_datetime = date("Y-m-d H:i:s");
                    }
                    else if($formapprove->from_level_enable_6 == 1)
                    {
                        $formapprove->from_level_6 = 0;
                        $formapprove->from_level_6_comment = $data["comment_remarks"];
                        $formapprove->from_level_6_approve_by = Auth::User()->id;
                        $formapprove->from_level_6_datetime = date("Y-m-d H:i:s");
                    }
                    else if($formapprove->from_level_enable_7 == 1)
                    {
                        $formapprove->from_level_7 = 0;
                        $formapprove->from_level_7_comment = $data["comment_remarks"];
                        $formapprove->from_level_7_approve_by = Auth::User()->id;
                        $formapprove->from_level_7_datetime = date("Y-m-d H:i:s");

                    }
                    else if($formapprove->from_level_enable_8 == 1)
                    {
                        $formapprove->from_level_8 = 0;
                        $formapprove->from_level_8_comment = $data["comment_remarks"];
                        $formapprove->from_level_8_approve_by = Auth::User()->id;
                        $formapprove->from_level_8_datetime = date("Y-m-d H:i:s");
                    }
                    else if($formapprove->from_level_enable_9 == 1)
                    {
                        $formapprove->from_level_9 = 0;
                        $formapprove->from_level_9_comment = $data["comment_remarks"];
                        $formapprove->from_level_9_approve_by = Auth::User()->id;
                        $formapprove->from_level_9_datetime = date("Y-m-d H:i:s");
                    }
                    else if($formapprove->from_level_enable_10 == 1)
                    {
                        $formapprove->from_level_10 = 0;
                        $formapprove->from_level_10_comment = $data["comment_remarks"];
                        $formapprove->from_level_10_approve_by = Auth::User()->id;
                        $formapprove->from_level_10_datetime = date("Y-m-d H:i:s");

                    }

                    $formapprove->from_level_enable_1 = 0;
                    $formapprove->from_level_enable_2 = 0;
                    $formapprove->from_level_enable_3 = 0;
                    $formapprove->from_level_enable_4 = 0;
                    $formapprove->from_level_enable_5 = 0;
                    $formapprove->from_level_enable_6 = 0;
                    $formapprove->from_level_enable_7 = 0;
                    $formapprove->from_level_enable_8 = 0;
                    $formapprove->from_level_enable_9 = 0;
                    $formapprove->from_level_enable_10 = 0;
                    $formapprove->save();

                    $account_openning_data->is_updateable = 1;
                    $account_openning_data->save();
                    $senddata =  $this->Emailsend('Create Account Opening form',"Approved");

                }else{
                    $this->approvalmasseage($request);
                }

            }
            else if($data["submit"] == "approve"){

                if($formapprove->from_level_enable_1 == 1)
                {
                    if(Common::userwisepermission(Auth::user()->id, "Account opening from level 1"))
                    {

                        $formapprove->from_level_1 = 1;
                        $formapprove->from_level_enable_1 = 0;
                        $formapprove->from_level_1_comment = $data["comment_remarks"];
                        $formapprove->from_level_1_approve_by = Auth::User()->id;
                        $formapprove->from_level_1_datetime = date("Y-m-d H:i:s");
                        $formapprove->from_level_enable_2 = 1;

                        $senddata =  $this->Emailsend('Account opening from level 2',"Approved");
                    }
                    else{
                        return $this->approvalmasseage($request);
                    }
                }
                else if($formapprove->from_level_enable_2 == 1)
                {
                    if(Common::userwisepermission(Auth::user()->id, "Account opening from level 2"))
                    {
                        $formapprove->from_level_enable_2 = 0;
                        $formapprove->from_level_enable_3 = 1;
                        $formapprove->from_level_2_comment = $data["comment_remarks"];
                        $formapprove->from_level_2_approve_by = Auth::User()->id;
                        $formapprove->from_level_2_datetime = date("Y-m-d H:i:s");
                        $formapprove->from_level_2 = 1;


                        $senddata =  $this->Emailsend('Account opening from level 3',"Approved");
                    }
                    else{
                        return $this->approvalmasseage($request);
                    }
                }
                else if($formapprove->from_level_enable_3 == 1)
                {
                    if(Common::userwisepermission(Auth::user()->id, "Account opening from level 3"))
                    {
                        $formapprove->from_level_enable_3 = 0;
                        $formapprove->from_level_enable_4 = 1;
                        $formapprove->from_level_3_comment = $data["comment_remarks"];
                        $formapprove->from_level_3_approve_by = Auth::User()->id;
                        $formapprove->from_level_3_datetime = date("Y-m-d H:i:s");
                        $formapprove->from_level_3 = 1;


                        $senddata =  $this->Emailsend('Account opening from level 4',"Approved");
                    }else{
                        return $this->approvalmasseage($request);
                    }
                }
                else if($formapprove->from_level_enable_4 == 1)
                {
                    if(Common::userwisepermission(Auth::user()->id, "Account opening from level 4"))
                    {
                        $formapprove->from_level_enable_4 = 0;
                        $formapprove->from_level_enable_5 = 1;
                        $formapprove->from_level_4_comment = $data["comment_remarks"];
                        $formapprove->from_level_4_approve_by = Auth::User()->id;
                        $formapprove->from_level_4_datetime = date("Y-m-d H:i:s");
                        $formapprove->from_level_4 = 1;


                        $senddata =  $this->Emailsend('Account opening from level 4',"Approved");
                    }else{
                        return $this->approvalmasseage($request);
                    }
                }
                else if($formapprove->from_level_enable_5 == 1)
                {
                    if(Common::userwisepermission(Auth::user()->id, "Account opening from level 5"))
                    {
                        $formapprove->from_level_enable_5 = 0;
                        $formapprove->from_level_enable_6 = 1;
                        $formapprove->from_level_5_comment = $data["comment_remarks"];
                        $formapprove->from_level_5_approve_by = Auth::User()->id;
                        $formapprove->from_level_5_datetime = date("Y-m-d H:i:s");
                        $formapprove->from_level_5 = 1;


                        $senddata =  $this->Emailsend('Account opening from level 6',"Approved");
                    }else{
                        return $this->approvalmasseage($request);
                    }
                }
                else if($formapprove->from_level_enable_6 == 1)
                {
                    if(Common::userwisepermission(Auth::user()->id, "Account opening from level 6"))
                    {
                        $formapprove->from_level_enable_6 = 0;
                        $formapprove->from_level_enable_7 = 1;
                        $formapprove->from_level_6_comment = $data["comment_remarks"];
                        $formapprove->from_level_6_approve_by = Auth::User()->id;
                        $formapprove->from_level_6_datetime = date("Y-m-d H:i:s");
                        $formapprove->from_level_6 = 1;


                        $senddata =  $this->Emailsend('Account opening from level 7',"Approved");
                    }else{
                        return $this->approvalmasseage($request);
                    }
                }
                else if($formapprove->from_level_enable_7 == 1)
                {
                    if(Common::userwisepermission(Auth::user()->id, "Account opening from level 7"))
                    {
                        $formapprove->from_level_enable_7 = 0;
                        $formapprove->from_level_enable_8 = 1;
                        $formapprove->from_level_7_comment = $data["comment_remarks"];
                        $formapprove->from_level_7_approve_by = Auth::User()->id;
                        $formapprove->from_level_7_datetime = date("Y-m-d H:i:s");
                        $formapprove->from_level_7 = 1;


                        $senddata =  $this->Emailsend('Account opening from level 8',"Approved");
                    }else{
                        return $this->approvalmasseage($request);
                    }
                }
                else if($formapprove->from_level_enable_8 == 1)
                {
                    if(Common::userwisepermission(Auth::user()->id, "Account opening from level 8"))
                    {
                        $formapprove->from_level_enable_8 = 0;
                        $formapprove->from_level_enable_9 = 1;
                        $formapprove->from_level_8_comment = $data["comment_remarks"];
                        $formapprove->from_level_8_approve_by = Auth::User()->id;
                        $formapprove->from_level_8_datetime = date("Y-m-d H:i:s");
                        $formapprove->from_level_8 = 1;


                        $senddata =  $this->Emailsend('Account opening from level 9',"Approved");
                    }else{
                        return $this->approvalmasseage($request);
                    }
                }
                else if($formapprove->from_level_enable_9 == 1)
                {
                    if(Common::userwisepermission(Auth::user()->id, "Account opening from level 9"))
                    {
                        $formapprove->from_level_enable_9 = 0;
                        $formapprove->from_level_enable_10 = 1;
                        $formapprove->from_level_9_comment = $data["comment_remarks"];
                        $formapprove->from_level_9_approve_by = Auth::User()->id;
                        $formapprove->from_level_9_datetime = date("Y-m-d H:i:s");
                        $formapprove->from_level_9 = 1;


                        $senddata =  $this->Emailsend('Account opening from level 10',"Approved");
                    }else{
                        return $this->approvalmasseage($request);
                    }
                }
                else if($formapprove->from_level_enable_10 == 1)
                {
                    if(Common::userwisepermission(Auth::user()->id, "Account opening from level 9"))
                    {
                        $formapprove->from_level_10 = 0;
                        $formapprove->from_level_enable_10 = 0;
                        $formapprove->from_level_10_comment = $data["comment_remarks"];
                        $formapprove->from_level_10_approve_by = Auth::User()->id;
                        $formapprove->from_level_10_datetime = date("Y-m-d H:i:s");
                        $formapprove->from_level_10 = 1;

                    }else{
                        return $this->approvalmasseage($request);
                    }
                }
                $this->approvalcommenthistory($data,$id);

                if(Common::userwisepermission(Auth::user()->id, "Close Approval")) {
                    $account_close = Account::where('id','=',$id)->first();
                    $account_close->is_updateable = 1;
                    $account_close->is_closed = 1;
                    $account_close->save();

                    $formapprove->is_closed = 1;
                }
                $formapprove->save();
            }

        }else{
            $request->session()->flash('alert-danger', "Approval Not Found");
        }


        return Redirect::to('account-openning');
    }

}
