<?php

namespace App\Http\Controllers\RolePermission;

use App\Http\Controllers\Controller;
use App\Models\RolePermission\Role;
use App\Models\RolePermission\Permission;
use Spatie\Permission\Models\Role as SpatieRole;
use Spatie\Permission\Models\Permission as SpatiePermission;
use App\Models\User;
use Illuminate\Http\Request;
use DB;
use Auth;

class RoleController extends Controller
{
	function __construct()
	{
		$this->middleware('permission:roles.index', ['only' => ['index']]);
		$this->middleware('permission:roles.show', ['only' => ['show']]);
		$this->middleware('permission:roles.create', ['only' => ['create','store']]);
		$this->middleware('permission:roles.edit', ['only' => ['edit','update']]);
		$this->middleware('permission:roles.destroy', ['only' => ['destroy']]);
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{
		/*$user = User::find(1);
		$user->assignRole(1);*/
		$roles = Role::select('*')->where('id', '!=', 1);
		if(Auth::user()->hasrole('System Administrator')){
			$roles->withTrashed();
		}
		if(request()->ajax()){
			return datatables()->of($roles)
			->addColumn('action', function($row){
				$action = '';
				$action .= '<a class="text-primary" href="javascript:void(0)" data-toggle="modal-ajax" data-href="'.route('roles.edit', $row->id).'" data-target="#editRole"><i class="fad fa-edit fa-lg"></i></a>';
				if($row->id > 2){
					if($row->trashed()){
						$action .= '<a class="text-success" href="javascript:void(0)" onclick="restoreFromTable(this)" data-href="'.route('roles.restore', $row->id).'"><i class="fad fa-download fa-lg"></i></a>';
					}else{
						$action .= '<a class="text-danger" href="javascript:void(0)" onclick="deleteFromTable(this)" data-href="'.route('roles.destroy', $row->id).'"><i class="fad fa-trash-alt fa-lg"></i></a>';
					}
				}
				return $action;
			})
			->rawColumns(['action'])
			// ->addIndexColumn()
			// ->make(true);
			->toJson();
		}else{
			$data = [
				'roles' => $roles->get()
			];
			return view('role_permission.roles.index', $data);
		}
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create()
	{
		$permissions = SpatiePermission::get()->groupBy('group');
		return response()->json([ 'modal_content' => view('role_permission.roles.create',compact('permissions'))->render() ]);
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request)
	{
		$request->validate([
			'name' => 'required|unique:roles,name',
			'permission' => 'required',
		]);


		// $role = SpatieRole::create(['name' => $request->input('name')]);
		$role = Role::create(['name' => $request->input('name')]);
		$role->syncPermissions($request->input('permission'));


		return redirect()->route('roles.index')
						->with('success','Role created successfully');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  \App\Models\Configuration\RolPermission\Role  $role
	 * @return \Illuminate\Http\Response
	 */
	public function show(Role $role)
	{
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  \App\Models\Configuration\RolPermission\Role  $role
	 * @return \Illuminate\Http\Response
	 */
	public function edit(Role $role)
	{
		$role = SpatieRole::find($role->id);
		$data = [
			'role_edit' => $role, 
			'permissions' => SpatiePermission::orderBy('group')->get()->groupBy('group'),
			'role_permissions_id' => $role->permissions->pluck('id')->toArray(),
		];


		return response()->json(['modal_content' => view('role_permission.roles.edit', $data)->render()]);
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \App\Models\Configuration\RolPermission\Role  $role
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request, Role $role)
	{
		$role = SpatieRole::find($role->id);
		$request->validate([
			'name' => 'required|unique:roles,name,'.$role->id,
			'permission' => 'required',
		]);
		$role->update(['name'=>$request->name]);
		$role->syncPermissions($request->input('permission'));
		return redirect()->route('roles.index')
						->with('success','Role updated successfully');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  \App\Models\Configuration\RolPermission\Role  $role
	 * @return \Illuminate\Http\Response
	 */
	public function destroy(Role $role)
	{
		if (request()->get('permanent')) {
			$role->forceDelete();
		}else{
			$role->delete();
		}
		return redirect()->route('roles.index')
						->with('alert-danger','Role successfully deleted');
	}

	public function restore($role)
	{
		$role = Role::withTrashed()->find($role);
		$role->restore();
		return redirect()->route('roles.index')
						->with('alert-success','Role successfully restored');
	}

	public function get_data()
	{
		if(Auth::user()->hasrole('System Administrator')){
			$roles = Role::withTrashed()->select('*');
		}else{
			$roles = Role::where('id', '!=', 1)->select('*');
		}
		return datatables()->of($roles)
			->addColumn('action', function($row){
				$action = '';
				if(auth()->user()->can('roles.edit')){
					$action .= '<a class="edit-charge text-lg modal-open-link" href="javascript:void(0)" data-href="'.route('roles.edit', $row->id).'" data-target="#editRole" style="margin-right: 10px"><i class="fa fa-edit"></i></a>';
				}
				if(auth()->user()->can('roles.destroy')){
					$action .= '<a class="destroy-charge text-danger text-lg" href="javascript:void(0);" data-href="'.route('roles.destroy', $row->id).'"><i class="fa fa-trash"></i></a>';
				}
				return $action;
			})
			->rawColumns(['action'])
			// ->addIndexColumn()
			// ->make(true);
			->toJson();
	}
}
