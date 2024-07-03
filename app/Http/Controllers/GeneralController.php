<?php

namespace App\Http\Controllers;

use App\Model\Department\Department;
use App\Model\Employee\Employee;
use App\Model\Machines\Machineparts;
use App\Model\OtherExpense\OtherExpense;
use App\Model\Requesttype\Requesttype;
use App\Model\Project\Project;
use Mgallegos\LaravelJqgrid\Facades\GridEncoder;
use Illuminate\Http\Request;
use App\Model\Department\DepartmentDataRepositery;
use App\Model\Employee\EmployeeDataRepositery;
use App\Model\Requesttype\RequesttypeDataRepositery;
use App\Model\Project\ProjectDataRepositery;
use Illuminate\Support\Facades\Input;
use Redirect,DB;

class GeneralController extends Controller
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

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('home');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function departmentindex()
    {
        return view('department.index');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function departmentgriddata()
    {
        GridEncoder::encodeRequestedData(new DepartmentDataRepositery(), Input::all());
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function departmentCreate()
    {
        return view('department.create');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function departmentupdate($id)
    {
        $dept = $this->DepartmentView($id);
        return view('department.edit',compact('dept'));
    }
    public function DepartmentView($id)
    {
        return Department::where('id','=',$id)->first();
    }
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function departmentViewData($id)
    {
        $dept = $this->DepartmentView($id);
        return view('department.view',compact('dept'));
    }
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function departmentSave(Request $request)
    {
        $data = $request->input();
        $deptid = $this->DepartmentInfoStore($data);
        return Redirect::to('deptindex');
    }

    public function DepartmentInfoStore($data)
    {
        $dept = new Employee();
        $dept->description =$data["name"];
        $dept->save();

        return $dept->id;
    }
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function departmentupdateSave(Request $request,$id)
    {
        $data = $request->input();
        $deptid = $this->DepartmentInfoStoreUpdate($data,$id);
        return Redirect::to('deptindex');
    }

    public function DepartmentInfoStoreUpdate($data,$id)
    {
        $dept = Department::where('id','=',$id)->first();
        $dept->description =$data["name"];
        $dept->save();

        return $dept->id;
    }
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function projectIndex()
    {
        return view('project.index');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function projectgriddata()
    {
        GridEncoder::encodeRequestedData(new ProjectDataRepositery(), Input::all());
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function projectCreate()
    {
        return view('project.create');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function projectupdate($id)
    {
        $project = $this->ProjectView($id);

        $parttotal = Machineparts::select(DB::raw('SUM(IFNULL(partamount,0)) as parttotal'))->where('projectid','=',$id)->first();
        $othertotal = OtherExpense::select(DB::raw('SUM(IFNULL(amount,0)) as othertotal'))->where('project_id','=',$id)->first();

        return view('project.edit',compact('project','parttotal','othertotal'));
    }
    public function ProjectView($id)
    {
        return Project::where('id','=',$id)->first();
    }
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function projectViewData($id)
    {
        $project = $this->ProjectView($id);
        return view('project.view',compact('project'));
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function projectSave(Request $request)
    {
        $data = $request->input();
        $projectid = $this->ProjectInfoStore($data);
        return Redirect::to('projectindex');
    }
    public function ProjectInfoStore($data)
    {
        $project = new Project();
        $project->description =$data["name"];
        $project->startdate =$data["startdate"];
        $project->enddate =$data["enddate"];
        $project->budget =$data["budget"];
        $project->save();

        return $project->id;
    }
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function projectupdateSave(Request $request,$id)
    {
        $data = $request->input();
        $deptid = $this->ProjectInfoStoreUpdate($data,$id);
        return Redirect::to('projectindex');
    }

    public function ProjectInfoStoreUpdate($data,$id)
    {
        $project = Project::where('id','=',$id)->first();
        $project->description =$data["name"];
        $project->startdate =$data["startdate"];
        $project->enddate =$data["enddate"];
        $project->budget =$data["budget"];
        $project->save();

        return $project->id;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function requesttypeIndex()
    {
        return view('requesttype.index');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function requesttypegriddata()
    {
        GridEncoder::encodeRequestedData(new RequesttypeDataRepositery(), Input::all());
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function requesttypeCreate()
    {
        return view('requesttype.create');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function requesttypeupdate($id)
    {
        $requesttype = $this->requesttypeView($id);
        return view('requesttype.edit',compact('requesttype'));
    }
    public function requesttypeView($id)
    {
        return Requesttype::where('id','=',$id)->first();
    }
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function requesttypeViewData($id)
    {
        $requesttype = $this->requesttypeView($id);
        return view('requesttype.view',compact('requesttype'));
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function requesttypeSave(Request $request)
    {
        $data = $request->input();
        $requesttype = $this->requesttypeInfoStore($data);
        return Redirect::to('requesttypeindex');
    }
    public function requesttypeInfoStore($data)
    {
        $requesttype = new Requesttype();
        $requesttype->description =$data["name"];
        $requesttype->save();

        return $requesttype->id;
    }
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function requesttypeupdateSave(Request $request,$id)
    {
        $data = $request->input();
        $requesttype = $this->requesttypeInfoStoreUpdate($data,$id);
        return Redirect::to('requesttypeindex');
    }

    public function requesttypeInfoStoreUpdate($data,$id)
    {
        $requesttype = Requesttype::where('id','=',$id)->first();
        $requesttype->description =$data["name"];
        $requesttype->save();

        return $requesttype->id;
    }
    //account
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function AccountIndex()
    {
        return view('account.index');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function AccountGridData()
    {
        GridEncoder::encodeRequestedData(new EmployeeDataRepositery(), Input::all());
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function AccountCreate()
    {
        return view('account.create');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function AccountUpdate($id)
    {
        $dept = $this->AccountView($id);
        return view('account.edit',compact('dept'));
    }
    public function AccountView($id)
    {
        return Employee::where('id','=',$id)->first();
    }
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function AccountViewData($id)
    {
        $dept = $this->AccountView($id);
        return view('account.view',compact('dept'));
    }
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function AccountSave(Request $request)
    {
        $data = $request->input();
        $deptid = $this->AccountInfoStore($data);
        return Redirect::to('accountindex');
    }

    public function AccountInfoStore($data)
    {
        $dept = new Employee();
        $dept->description =$data["name"];
        $dept->save();

        return $dept->id;
    }
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function AccountupdateSave(Request $request,$id)
    {
        $data = $request->input();
        $deptid = $this->AccountInfoStoreUpdate($data,$id);
        return Redirect::to('accountindex');
    }

    public function AccountInfoStoreUpdate($data,$id)
    {
        $dept = Employee::where('id','=',$id)->first();
        $dept->description =$data["name"];
        $dept->save();

        return $dept->id;
    }
}
