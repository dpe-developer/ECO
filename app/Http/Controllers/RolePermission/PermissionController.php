<?php

namespace App\Http\Controllers\RolePermission;

use App\Http\Controllers\Controller;
use App\Models\RolePermission\Permission;
use App\Models\RolePermission\Role;
use App\Models\RolePermission\RolePermission;
use Spatie\Permission\Models\Permission as SpatiePermission;
use Spatie\Permission\Models\Role as SpatieRole;
use Illuminate\Http\Request;
use Auth;
use Artisan;

class PermissionController extends Controller
{
	function __construct()
	{
		// $this->middleware('permission:permissions.index|permissions.create|permissions.edit|permissions.destroy', ['only' => ['index','store']]);
		$this->middleware('permission:permissions.index', ['only' => ['index']]);
		$this->middleware('permission:permissions.create', ['only' => ['create','store']]);
		$this->middleware('permission:permissions.show', ['only' => ['show']]);
		$this->middleware('permission:permissions.edit', ['only' => ['edit','update']]);
		$this->middleware('permission:permissions.destroy', ['only' => ['destroy']]);
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{
		$permissions = Permission::orderBy('group', 'asc')->select('*');
		if(request()->ajax()){
			if(Auth::user()->hasrole('System Administrator')){
				$permissions = Permission::orderBy('group', 'asc')->select('*')->withTrashed();
			}
			return datatables()->of($permissions)
			->addColumn('action', function($row){
				$action = '';
				if($row->trashed()){
					$action .= '<a class="text-success" href="javascript:void(0)" onclick="restoreFromTable(this)" data-href="'.route('permissions.restore', $row->id).'"><i class="fad fa-download fa-lg"></i></a>';
				}else{
					$action .= '<a class="text-danger" href="javascript:void(0)" onclick="deleteFromTable(this)" data-href="'.route('permissions.destroy', $row->id).'"><i class="fad fa-trash-alt fa-lg"></i></a>';
				}
				return $action;
			})
			->rawColumns(['action'])
			->addIndexColumn()
			->make(true);
		}else{
			$data = [
				'permissions' => $permissions->get()
			];
			return view('role_permission.permissions.index', $data);

		}
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create()
	{
		$data = ['permissions_name' => Permission::get()->pluck('name')->toArray() ];
		return response()->json(['modal_content' => view('role_permission.permissions.create', $data)->render()]);
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request)
	{
		/* $request->validate([
			'name' => ['required', 'unique:permissions,name']
		]); */
		ini_set('memory_limit','1G');
		$role = SpatieRole::find(1);
		foreach ($request->get('name') as $key => $name) {
			SpatiePermission::create([
				'group' => str_replace("_", " ", explode('.', $name)[0]),
				'name' => $name,
			]);
			$role->givePermissionTo($name);
		}
		return back();
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  \App\Models\Configuration\RolePermission\Permission  $permission
	 * @return \Illuminate\Http\Response
	 */
	public function show(Permission $permission)
	{
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  \App\Models\Configuration\RolePermission\Permission  $permission
	 * @return \Illuminate\Http\Response
	 */
	public function edit(Permission $permission)
	{
		//
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \App\Models\Configuration\RolePermission\Permission  $permission
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request, Permission $permission)
	{
		//
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  \App\Models\Configuration\RolePermission\Permission  $permission
	 * @return \Illuminate\Http\Response
	 */
	public function destroy(Permission $permission)
	{
		$permission->forceDelete();
		/* if (request()->get('permanent')) {
			$permission->forceDelete();
		}else{
			RolePermission::where('permission_id', $permission->id)->delete();
			$permission->delete();
		} */
		Artisan::call('permission:cache-reset');
		// return redirect()->route('roles.index')->with('alert-danger','Permission successfully deleted');
		return back()->with('alert-danger','Permission successfully deleted');
	}

	public function restore($permission)
	{
		$permission = Permission::withTrashed()->find($permission);
		$permission->restore();
		// RolePermission::where('permission_id', $permission->id)->restore();
		Artisan::call('permission:cache-reset');
		// return redirect()->route('roles.index')->with('alert-success','Permission successfully restored');
		return back()->with('alert-success','Permission successfully restored');
	}

	public function get_data()
	{
		return datatables()->of(Permission::select('*'))
			->addColumn('action', function($row){
				$action = '';
				if(auth()->user()->can('permissions.edit')){
					$action .= '<a class="edit-charge text-lg table-action" href="javascript:void(0)" data-action="edit" data-href="'.route('permissions.edit', $row->id).'" style="margin-right: 10px"><i class="fa fa-edit"></i></a>';
				}
				if(auth()->user()->can('permissions.destroy')){
					$action .= '<a class="destroy-charge text-danger text-lg table-action" href="javascript:void(0);" data-action="destroy" data-href="'.route('permissions.destroy', $row->id).'"><i class="fa fa-trash"></i></a>';
				}
				return $action;
			})
			->rawColumns(['action'])
			->addIndexColumn()
			->make(true);
	}
}
