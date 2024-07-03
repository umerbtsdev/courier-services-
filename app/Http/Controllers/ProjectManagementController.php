<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Mgallegos\LaravelJqgrid\Facades\GridEncoder;
use Illuminate\Support\Facades\Input;
use DB,Auth;
use App\Model\Projects\projects;
use App\Model\Projects\ProjectsDataRepository;
use App\Model\RouteManagment\Route;

class ProjectManagementController extends Controller
{
    public function ProjectsHome()
    {
        return view('projects.index');
    }

    public function ProjectsHomeGridData()
    {
        GridEncoder::encodeRequestedData(new ProjectsDataRepository(), Input::all());
    }

    public function ProjectsAdd()
    {
        $routes = Route::get();
        return view('projects.create', compact('routes'));
    }

    public function ProjectSave(Request $request)
    {
        $project_name = $request->input('project_name');
        $route_from = $request->input('route_from');
        $route_to = $request->input('route_to');
        $status = $request->input('status');

        $data=[
            'name' => $project_name,
            'route_from_id' => $route_from,
            'route_to_id' => $route_to,
            'status' => $status,
            'created_at' => date('Y-m-d H:i:s'),
            'created_by' => Auth::User()->id,
        ];
        if(projects::insert($data)){
            return redirect('project-management/projects');
        }
    }

    public function ProjectEdit($id)
    {
        $project = projects::find($id);
        $routes = Route::get();
        return view('projects.update', compact('project','routes'));
    }

    public function ProjectUpdate(Request $request)
    {
        $project_id = $request->input('project_id');
        $project_name = $request->input('project_name');
        $route_from = $request->input('route_from');
        $route_to = $request->input('route_to');
        $status = $request->input('status');

        $project = projects::where('id','=',$project_id)->first();
        $project->name = $project_name;
        $project->route_from_id = $route_from;
        $project->route_to_id = $route_to;
        $project->status = $status;
        $project->updated_at = date('Y-m-d H:i:s');
        $project->updated_by = Auth::User()->id;
        $project->save();
        
        return redirect('project-management/projects');
    }

    public function ProjectView($id)
    {
        $project = projects::join('routes','projects.route_from_id','=','routes.id')
        ->join('routes as routeTo','projects.route_to_id','=','routeTo.id')
        ->select(
            'projects.id as p_id',
             'projects.name as project_name',
             'projects.status',
             'routes.name as route_from_name',
             'routeTo.name as route_to_name'
        )
        ->where('projects.id','=',$id)->first();
        return view('projects.view', compact('project'));
    }

    public function ProjectDelete($id)
    {
        return  view('projects.delete',compact('id'));
    }

    public function ProjectDeleted(Request $request)
    {
        $id = $request->input('project_id');
        $project = projects::find($id);

        $project->delete();

        return redirect('project-management/projects');
    }
}
