<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Auth,Config,DB;
use App\RoleHasPermissions;

class RoleController extends Controller
{
	
	public function __construct()
	 {
         $this->middleware('auth');
//		 $this->middleware(function ($request, $next) {
//
//			if(Auth::check()){
//				//GET USER ROLE INFO
//				$userRole = \App\User::findOrfail(Auth::user()->id);
//
//				$superadminRole			=	Config::get('constants.superadminRole');
//				//IF USER  SUPER ADMIN
//				if($userRole->hasRole($superadminRole)){
//					 return $next($request);
//				}else{
//					 return redirect('/');
//				}
//			}
//
//		});
		
	 }
	 
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $roles = Role::all();

        return view('roles.index', compact('roles'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('roles.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Role::create(['name' => $request->name]);

        return redirect('roles');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $role = Role::findOrFail($id);
        //$permissions = Permission::all()->pluck('name');
        $permissions = Permission::leftjoin("role_has_permissions", function($join) use ($id) {
            $join->on("permissions.id",'=',"role_has_permissions.permission_id");
            $join->on("role_has_permissions.role_id",'=',DB::raw($id));})
            ->select('id','name')->whereNull("role_has_permissions.permission_id")->get();
        $userPermissions = isset($role->permissions)?$role->permissions:array();
        return view('roles.edit', compact('role','permissions','userPermissions'));
    }

    /**
     * Assign Permission to a user.
     *
     * @param \Illuminate\Http\Request
     *
     * @return \Illuminate\Http\Response
     */
    public function addPermission(Request $request)
    {
        $role = Role::findorfail($request->role_id);

        //IF PERMISSION NOT ASSIGN ALREADY
        if(!$role->hasPermissionTo($request->permission_name)){
            $role->givePermissionTo($request->permission_name);
        }

        return redirect('roles/edit/'.$request->role_id);
    }

    /**
     * revoke Permission to a user.
     *
     * @param \Illuminate\Http\Request
     *
     * @return \Illuminate\Http\Response
     */
    public function revokePermission($permission, $role_id)
    {
        //$role = Role::findorfail($role_id);
        $permission =Permission::join('role_has_permissions', 'role_has_permissions.permission_id', '=', 'permissions.id')
            ->where('permissions.name', str_slug($permission, ' '))
            ->where('role_has_permissions.role_id', $role_id)->first();
        //$role = Role::findorfail($role_id);
        $removeperrole = RoleHasPermissions::where('role_id','=',$role_id)->where('permission_id','=',$permission->permission_id)->delete();


        //$role->revokePermissionTo(str_slug($permission, ' '));

        return redirect('roles/edit/'.$role_id);
    }
    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $role = Role::findOrFail($request->role_id);

        $role->name = $request->name;

        $role->update();

        return redirect('roles');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $role = Role::findOrFail($id);

        $role->delete();

        return redirect('roles');
    }
}
