<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\FileAttachment;
use App\Models\Setting;
use App\Models\UserSetting;
use App\Models\RolePermission\Role;
use App\Models\RolePermission\UserRole;
use Spatie\Permission\Models\Role as SpatieRole;
use Spatie\Permission\Models\Permission as SpatiePermission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Crypt;
use Carbon\Carbon;
use DB;
use Auth;

class UserController extends Controller
{
    public function __construct()
	{
		$this->middleware('auth');
		$this->middleware('permission:users.index', ['only' => ['index']]);
		$this->middleware('permission:users.create', ['only' => ['create','store']]);
		$this->middleware('permission:users.show', ['only' => ['show']]);
		$this->middleware('permission:users.edit', ['only' => ['edit','update']]);
		$this->middleware('permission:users.destroy', ['only' => ['destroy']]);
	}

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        /* $users = User::select('*');
		if(Auth::user()->hasrole('System Administrator')){
			$users->withTrashed();
		}else{
			$users->where('id', '!=', '1');
		}
		if(($query = $request->get('q'))){
			$users->with('employee')
				->where('name', 'LIKE', '%'.$query.'%')
				->orwhere('email', 'LIKE', '%'.$query.'%');
			$employees = Employee::where('employee_id', 'LIKE', '%'.$query.'%')
						->orwhere('last_name', 'LIKE', '%'.$query.'%')
						->orwhere('middle_name', 'LIKE', '%'.$query.'%')
						->orwhere('first_name', 'LIKE', '%'.$query.'%');
			if(Auth::user()->hasrole('System Administrator')){
				$employees->withTrashed();
			}
			if($employees->get()->count() > 0){
				$users->orWhereIn('employee_id', $employees->get('id'));
			}
			$users->orWhere('email', 'LIKE', '%'.$query.'%');

		} */
        $users = User::select('*');
		if(Auth::user()->hasrole('System Administrator')){
			$users->withTrashed();
		}else{
			$users->where('id', '!=', '1');
		}
		$data = [
			'users' => $users->get()
		];
		return view('users.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles = Role::select('*');
		if(Auth::user()->hasrole('System Administrator')){
			$roles = $roles;
		}elseif(Auth::user()->hasrole('Administrator')){
			$roles->where('id', '!=', 1)->get();
		}else{
			$roles->whereNotIn('id', [1,2]);
		}

		$data = [
			// 'employees' => Employee::doesntHave('users')->get(),
			'roles' => $roles->get(),
			// 'printers' => Printer::get()
		];

		if(request()->ajax()){
			return response()->json([
				'modal_content' => view('users.create', $data)->render()
			]);
		}
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
			'role' => ['required'],
			'avatar' => 'nullable|dimensions:ratio=1/1|image|mimes:jpeg,png,jpg',
			'username' => ['required', 'string', 'max:255', 'unique:users,username'],
			'first_name' => ['required', 'string', 'max:255'],
			'last_name' => ['required', 'string', 'max:255'],
			'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
			'password' => ['required', 'string', 'min:6', 'confirmed'],
		]);
		$user = User::create([
			'avatar' => $request->get('avatar'),
			'username' => $request->get('username'),
			'first_name' => $request->get('first_name'),
			'last_name' => $request->get('last_name'),
			'email' => $request->get('email'),
			'password' => Hash::make($request->get('password')),
		]);
		$attachment_id = null;
		if($request->file('avatar') != null){
			$file = $request->file('avatar');
			$data = file_get_contents($file);
			$base64 = 'data:image/' . $file->extension() . ';base64,' . base64_encode($data);
			$file_name = time().'.'.$file->extension();
			// $path = $file->path();
			$path = 'File Attachments/User/Image';
			$attachment = FileAttachment::create([
				'file_path' => $path,
				'file_type' => $file->extension(),
				'file_name' => $file_name,
				'data' => $base64,
			]);
			Storage::disk('upload')->putFileAs($path, $file, $file_name);
			$user->update([
				'avatar_file_attachment_id' => $attachment->id
			]);
		}
		$user->assignRole($request->get('role'));
		foreach (Setting::where('type', '!=', 'system')->where('type', '!=', 'company')->get() as $setting) {
			UserSetting::create([
				'setting_id' => $setting->id,
				'user_id' => $user->id,
				'value' => $setting->default,
			]);
		}
		return redirect()->route('users.index')->with('alert-success', 'Successfully Registered');
		// return back()->with('alert-success', 'Saved');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show($user)
    {
		$uiSettings = [];
		$usersHasUISettingsData = true;

		if(Auth::user()->hasrole('System Administrator')){
            $user = User::withTrashed()->find($user);
			foreach(UserSetting::where('user_id', $user->id)->get() as $userUI) {
				$uiSettings[$userUI->setting->name] = $userUI->value;
			}
			foreach (Setting::where('type', '!=', 'system')->where('type', '!=', 'company')->get() as $setting) {
				if(UserSetting::where([
					['setting_id', $setting->id],
					['user_id', $user->id],
				])->doesntExist()){
					$usersHasUISettingsData = false;
				}
			}
		}else{
            $user = User::find($user);
			if($user->id == 1){
				return abort(404);
			}
			if(Setting::system('users_can_customize_ui') == 1){
				foreach (Setting::where('type', '!=', 'system')->where('type', '!=', 'company')->get() as $setting) {
					if(UserSetting::where([
						['setting_id', $setting->id],
						['user_id', $user->id],
					])->doesntExist()){
						$usersHasUISettingsData = false;
					}
				}
				foreach(UserSetting::where('user_id', $user->id)->get() as $userUI) {
					$uiSettings[$userUI->setting->name] = $userUI->value;
				}
			}
		}
		
		$data = [
			'user' => $user,
			'userInterfaceSetting' => $uiSettings,
			'usersHasUISettingsData' => $usersHasUISettingsData
		];
        return view('users.show', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit($user)
    {
        
		$roles = Role::select('*');
		
		if(Auth::user()->hasrole('System Administrator')){
			$roles = $roles;
            $user = User::withTrashed()->find($user);
		}elseif(Auth::user()->hasrole('Administrator')){
            $user = User::find($user);
			$roles->where('id', '!=', 1)->get();
		}else{
            $user = User::find($user);
			$roles->whereNotIn('id', [1,2]);
		}

		$data = [
			'user' => $user,
			// 'employees' => $employees->get(),
			'roles' => $roles->get(),
			// 'printers' => Printer::get()
		];

		return response()->json([
			'modal_content' => view('users.edit', $data)->render()
		]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $user)
    {
        $user = User::find($user);
		if(Auth::user()->hasrole('System Administrator')){
			$user->withTrashed();
		}

		$request->validate([
			'role' => ['required'],
			'avatar' => 'nullable|dimensions:ratio=1/1|image|mimes:jpeg,png,jpg',
			'username' => ['required', 'string', 'max:255', 'unique:users,username,'.$user->id],
			'first_name' => ['required', 'string', 'max:255'],
			'last_name' => ['required', 'string', 'max:255'],
			'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,'.$user->id],
		]);
		if($request->filled('password')){
			$request->validate([
				'password' => [/*'required',*/ 'string', 'min:6', 'confirmed']
			]);
			$data = ([
				'username' => $request->get('username'),
				'first_name' => $request->get('first_name'),
				'last_name' => $request->get('last_name'),
				'email' => $request->get('email'),
				'password' => Hash::make($request->get('password')),
			]);
		}else{
			$data = ([
				'username' => $request->get('username'),
				'first_name' => $request->get('first_name'),
				'last_name' => $request->get('last_name'),
				'email' => $request->get('email'),
			]);
		}
		$user->update($data);
		$attachment_id = null;
		if($request->file('avatar') != null){
			$file = $request->file('avatar');
			$data = file_get_contents($file);
			$base64 = 'data:image/' . $file->extension() . ';base64,' . base64_encode($data);
			$file_name = time().'.'.$file->extension();
			$path = 'File Attachments/User/Image';
			$old_image = isset($user->avatar->data) ? $user->avatar->data : null;
			if($base64 != $old_image){
				$attachment = FileAttachment::create([
					'file_path' => $path,
					'file_type' => $file->extension(),
					'file_extension' => $file->extension(),
					'file_name' => $file_name,
					'data' => $base64,
				]);
				Storage::disk('upload')->putFileAs($path, $file, $file_name);
				$user->update([
					'avatar_file_attachment_id' => $attachment->id
				]);
			}
		}
		UserRole::where('model_id', $user->id)->delete();
		$user->assignRole($request->get('role'));
		// $user->assignRole($request->role);
		// return redirect()->route('users.index')->with('alert-success', 'Saved');
		return back()->with('alert-success', 'Saved');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy($userID)
	{
		$user = User::find($userID);
		if(Auth::user()->hasrole('System Administrator')){
			$user = User::withTrashed()->find($userID);
		}
		if($user->id != 1){
			if (request()->get('permanent')) {
				$user->forceDelete();
			}else{
				$user->delete();
			}
			return redirect()->route('users.index')->with('alert-warning', $user->username.' Successfully Deleted');
		}
		
		return redirect()->route('users.index')->with('alert-error', 'System Administrator cannot be delete.');
		
		// return redirect()->route('users.index')->with('alert-danger','User successfully deleted');
	}

	public function restore($user)
	{
		$user = User::withTrashed()->find($user);
		$user->restore();
		return back()->with('alert-success', $user->username.' Successfully Restored');
		// return redirect()->route('users.index')->with('alert-success','User successfully restored');
	}

	public function profile($username)
	{
		if(User::where('username', $username)->exists()){
			$user = User::where('username', $username)->first();
			if(Auth::user()->id == $user->id){
				$uiSettings = [];
				$usersHasUISettingsData = true;
				if(Setting::system('users_can_customize_ui') == 1 || Auth::user()->hasrole('System Administrator')){
					foreach(UserSetting::where('user_id', Auth::user()->id)->get() as $userUI) {
						$uiSettings[$userUI->setting->name] = $userUI->value;
					}
				}
				foreach (Setting::where('type', '!=', 'system')->where('type', '!=', 'company')->get() as $setting) {
					if(UserSetting::where([
						['setting_id', $setting->id],
						['user_id', $user->id],
					])->doesntExist()){
						$usersHasUISettingsData = false;
					}
				}
				$data = [
					'user' => $user,
					'userInterfaceSetting' => $uiSettings,
					'usersHasUISettingsData' => $usersHasUISettingsData
				];
				return view('users.profile', $data);
			}else{
				return abort(401);
			}
		}else{
			return abort(404);
		}
	}

	public function editProfile($username)
	{
		if(User::where('username', $username)->exists()){
			$user = User::where('username', $username)->first();
			if(Auth::user()->id == $user->id){
				$data = [
					'user' => $user,
				];
				return response()->json([
					'modal_content' => view('users.edit_profile', $data)->render()
				]);
			}else{
				return abort(401);
			}
		}else{
			return abort(404);
		}
	}

	public function updateProfile(Request $request, $username)
	{
		if(User::where('username', $username)->exists()){
			$user = User::where('username', $username)->first();
			if(Auth::user()->id == $user->id){
				$request->validate([
					'avatar' => 'nullable|dimensions:ratio=1/1|image|mimes:jpeg,png,jpg',
					// 'username' => ['required', 'string', 'max:255', 'unique:users,username,'.$user->id],
					// 'first_name' => ['required', 'string', 'max:255'],
					// 'last_name' => ['required', 'string', 'max:255'],
					// 'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,'.$user->id],
				]);
				if($request->filled('password')){
					$request->validate([
						'password' => [/*'required',*/ 'string', 'min:6', 'confirmed']
					]);
					$user->update([
						'password' => Hash::make($request->get('password')),
					]);
				}
				
				$attachment_id = null;
				if($request->file('avatar') != null){
					$file = $request->file('avatar');
					$data = file_get_contents($file);
					$base64 = 'data:image/' . $file->extension() . ';base64,' . base64_encode($data);
					$file_name = time().'.'.$file->extension();
					$path = 'File Attachments/User/Image';
					$old_image = isset($user->avatar->data) ? $user->avatar->data : null;
					if($base64 != $old_image){
						$attachment = FileAttachment::create([
							'file_path' => $path,
							'file_type' => $file->extension(),
							'file_extension' => $file->extension(),
							'file_name' => $file_name,
							'data' => $base64,
						]);
						Storage::disk('upload')->putFileAs($path, $file, $file_name);
						$user->update([
							'avatar_file_attachment_id' => $attachment->id
						]);
					}
				}
				return redirect()->route('users.profile', [Auth::user()->username])->with('alert-success', 'Profile saved');
			}else{
				return abort(401);
			}
		}else{
			return abort(404);
		}
	}

	public function editUserInterface(Request $request) {
		foreach($request->all() as $name => $value){
			$setting = Setting::where([
				['type', '=', 'ui'],
				['name', '=', $name],
			])->first();
			if(isset($setting->id)){
				UserSetting::where([
					['setting_id', $setting->id],
					['user_id', Auth::user()->id]
				])->update([
					'value' => $value
				]);
			}
		}
		return redirect()->route('users.profile', [Auth::user()->username,'#customize-ui'])->with('alert-success', 'User Interface Settings saved');
	}

	public function resetUserInterface()
    {
        $uiSettings = Setting::where('type', 'ui')->get();
		foreach($uiSettings as $setting)
		{
			UserSetting::where([
				['setting_id', $setting->id],
				['user_id', Auth::user()->id]
			])->update([
				'value' => $setting->default
			]);
		}

        return redirect()->route('users.profile', [Auth::user()->username,'#customize-ui'])->with('alert-success', 'User Interface Settings reset to default');
    }
}
