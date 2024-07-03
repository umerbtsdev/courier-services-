<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use App\Permission\Models\Permission;
use App\Permission\Models\Role;
use Mgallegos\LaravelJqgrid\Facades\GridEncoder;
use App\Model\UserManagment\UserDataRepository;
use Auth,Config,Hash;

class UserController extends Controller
{

	
	public function __construct()
	 {
         $this->middleware('auth');
		 
		 //$this->middleware(function ($request, $next) {

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
			
		//});
		
	 }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      //  $users = \App\User::all();
        return view('users.index');
    }

    public function userGridData(){

        GridEncoder::encodeRequestedData(new UserDataRepository(), Input::all());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('users.create');
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

        if(empty($request->email) || empty($request->name) || empty($request->password)){
            $request->session()->flash('user_create_status', 'error');
            $request->session()->flash('user_create_message', 'requried!');
            return redirect('users/create');

        }else{

            $user = new \App\User();

            $user->email = $request->email;
            $user->name = $request->name;
            $user->password = Hash::make($request->password);

            $user->save();
            $request->session()->flash('user_create_status', 'success');
            $request->session()->flash('user_create_message', 'User Created successfully.');
        }
        
        return redirect('users');
        
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
        $user = \App\User::findOrfail($id);
        $roles = Role::all()->pluck('name');
        $permissions = Permission::all()->pluck('name');
        $userRoles = isset($user->roles)?$user->roles:array();
        $userPermissions = isset($user->permissions)?$user->permissions:array();

        return view('users.edit', compact('user', 'roles', 'permissions', 'userRoles', 'userPermissions'));
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
        $user = \App\User::findOrfail($request->user_id);

        $user->email = $request->email;
        $user->name = $request->name;
        $user->password = Hash::make($request->password);

        $user->save();

        return redirect('users');
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
        $user = \App\User::findOrfail($id);

        $user->delete();

        return redirect('users');
    }

    /**
     * Assign Role to user.
     *
     * @param \Illuminate\Http\Request
     *
     * @return \Illuminate\Http\Response
     */
    public function addRole(Request $request)
    {
        $user = \App\User::findOrfail($request->user_id);
		
		//IF ROLE NOT ASSIGN ALREADY
		if(!$user->hasRole($request->role_name)){
	        $user->assignRole($request->role_name);
		}

        return redirect('users/edit/'.$request->user_id);
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
        $user = \App\User::findorfail($request->user_id);
		
		//IF PERMISSION NOT ASSIGN ALREADY
		if(!$user->hasPermissionTo($request->permission_name)){
	        $user->givePermissionTo($request->permission_name);
		}

        return redirect('users/edit/'.$request->user_id);
    }



    /**
     * revoke Role to a a user.
     *
     * @param \Illuminate\Http\Request
     *
     * @return \Illuminate\Http\Response
     */
    public function revokeRole($role, $user_id)
    {
        $user = \App\User::findorfail($user_id);

        $user->removeRole(str_slug($role, ' '));

        return redirect('users/edit/'.$user_id);
    }
}
