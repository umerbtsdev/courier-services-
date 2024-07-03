<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Permission\Models\Permission;
use Auth,Config;

class PermissionController extends Controller
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
        $permissions = Permission::all();

        return view('permissions.index', compact('permissions'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('permissions.create');
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
        Permission::create(['name' => $request->name]);

        return redirect('permissions');
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
        $permission = Permission::findOrFail($id);

        return view('permissions.edit', compact('permission'));
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
        $permission = Permission::findOrFail($request->permission_id);

        $permission->name = $request->name;

        $permission->update();

        return redirect('permissions');
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
        $permission = Permission::findOrFail($id);

        $permission->delete();

        return redirect('permissions');
    }
}
