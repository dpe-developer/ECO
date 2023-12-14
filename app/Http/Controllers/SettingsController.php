<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use App\Models\User;
use App\Models\UserSetting;
use App\Models\FileAttachment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Auth;
use DB;

class SettingsController extends Controller
{
    public function __construct()
	{
		$this->middleware('auth');
		$this->middleware('permission:settings.index', ['only' => ['index']]);
		$this->middleware('permission:settings.edit_company', ['only' => ['updateCompany']]);
		$this->middleware('permission:settings.edit_user_interface', ['only' => ['updateUserInterface']]);
		$this->middleware('permission:settings.edit_system', ['only' => ['updateSystem']]);
	}

    public function index()
    {
        $companySettings = [];
        $uiSettings = [];
        $systemSettings = [];
        $usersHasUISettingsData = true;

        foreach(Setting::where('type', 'company')->get() as $company) {
            $companySettings[$company->name] = $company->value;
        }
        foreach(Setting::where('type', 'system')->get() as $system) {
            $systemSettings[$system->name] = $system->value;
        }
        if(Setting::system('users_can_customize_ui') == 1){
            // foreach(Auth::user()->user_settings as $userUI) {
            foreach(UserSetting::where('user_id', Auth::user()->id)->get() as $userUI) {
                $uiSettings[$userUI->setting->name] = $userUI->value;
            }
        }else{
            foreach(Setting::where('type', 'ui')->get() as $ui) {
                $uiSettings[$ui->name] = $ui->value;
            }
        }

        // check if users has UI settings data
        foreach (User::get() as $user) {
            foreach (Setting::where('type', 'ui')->get() as $setting) {
                if(UserSetting::where([
                    ['setting_id', $setting->id],
                    ['user_id', $user->id],
                ])->doesntExist()){
                    $usersHasUISettingsData = false;
                }
            }
        }

        $data = [
            'companySetting' => $companySettings,
            'userInterfaceSetting' => $uiSettings,
            'systemSetting' => $systemSettings,
            'usersHasUISettingsData' => $usersHasUISettingsData,
        ];
        return view('settings.index', $data);
    }

    public function updateCompany(Request $request)
    {
        $request->validate([
            // 'company_logo' => 'nullable|dimensions:ratio=1/1|image|mimes:jpeg,png,jpg',
            'company_logo' => 'nullable|image|mimes:jpeg,png,jpg',
            'company_name' => 'required',
            'company_telephone' => 'required',
            'company_email' => 'required',
            'company_address' => 'required',
        ]);
        Setting::where('name', 'company_name')->update([
            'value' => $request->get('company_name')
        ]);
        Setting::where('name', 'company_slogan')->update([
            'value' => $request->get('company_slogan')
        ]);
        Setting::where('name', 'company_website')->update([
            'value' => $request->get('company_website')
        ]);
        Setting::where('name', 'company_telephone')->update([
            'value' => $request->get('company_telephone')
        ]);
        Setting::where('name', 'company_fax')->update([
            'value' => $request->get('company_fax')
        ]);
        Setting::where('name', 'company_email')->update([
            'value' => $request->get('company_email')
        ]);
        Setting::where('name', 'company_address_1')->update([
            'value' => $request->get('address_1')['company-address']
        ]);
        Setting::where('name', 'company_address_2')->update([
            'value' => $request->get('address_2')['company-address']
        ]);
        Setting::where('name', 'company_city')->update([
            'value' => $request->get('city')['company-address']
        ]);
        Setting::where('name', 'company_state')->update([
            'value' => $request->get('state')['company-address']
        ]);
        Setting::where('name', 'company_country')->update([
            'value' => $request->get('country')['company-address']
        ]);
        Setting::where('name', 'company_postal_code')->update([
            'value' => $request->get('postal_code')['company-address']
        ]);
        Setting::where('name', 'company_address_type')->update([
            'value' => $request->get('address_type')['company-address']
        ]);
        Setting::where('name', 'company_address_remarks')->update([
            'value' => $request->get('address_remarks')['company-address']
        ]);
        Setting::where('name', 'company_about')->update([
            'value' => $request->get('company_about')
        ]);
        if($request->file('company_logo') != null){
			$file = $request->file('company_logo');
			$data = file_get_contents($file);
			// $base64 = 'data:image/' . $file->extension() . ';base64,' . base64_encode($data);
			$file_name = time().'.'.$file->extension();
			$attachment = FileAttachment::create([
				'file_path' => $file->path(),
				'file_type' => $file->extension(),
				'file_name' => $file_name,
				// 'data' => $base64,
			]);
			Storage::disk('public')->putFileAs('File Attachments/Company/Image', $file, $file_name);
			Setting::where('name', 'company_logo')->update([
                'value' => 'File Attachments/Company/Image/'.$file_name
            ]);
		}
        // echo $request->get('1')['company-address'];
        return redirect()->route('settings.index', ['#settings-tabs-company'])->with('alert-success', 'Company Settings saved');
    }

    public function updateUserInterface(Request $request)
    {   
        foreach($request->all() as $name => $value){
            if(Setting::system('users_can_customize_ui') == 1){
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
            }else{
                Setting::where([
                    ['type', 'ui'],
                    ['name', $name],
                ])->update([
                    'value' => $value
                ]);
                
                /* if(Auth::user()->hasrole('System Administrator')){
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
                } */
                
            }
        }

        return redirect()->route('settings.index', ['#settings-tabs-user-interface'])->with('alert-success', 'User Interface Settings saved');
    }

    public function updateSystem(Request $request)
    {
        foreach($request->all() as $name => $value){
            Setting::where([
                ['type', 'system'],
                ['name', $name],
            ])->update([
                'value' => $value
            ]);
        }
        return redirect()->route('settings.index', ['#settings-tabs-system'])->with('alert-success', 'System Settings saved');
    }

    public function resetCompany()
    {
        $companySettings = Setting::where('type', 'company')->get();
        foreach($companySettings as $setting)
        {
            Setting::where('name', $setting->name)->update([
                'value' => $setting->default
            ]);
        }
        return redirect()->route('settings.index', ['#settings-tabs-company'])->with('alert-success', 'Company Settings reset to default');
    }

    public function resetUserInterface()
    {
        $uiSettings = Setting::where('type', 'ui')->get();
        if(Setting::system('users_can_customize_ui') == 1){
            foreach($uiSettings as $setting)
            {
                UserSetting::where([
                    ['setting_id', $setting->id],
                    ['user_id', Auth::user()->id]
                ])->update([
                    'value' => $setting->default
                ]);
            }
            
        }else{
            foreach($uiSettings as $setting)
            {
                Setting::where('name', $setting->name)->update([
                    'value' => $setting->default
                ]);
            }
        }
        return redirect()->route('settings.index', ['#settings-tabs-user-interface'])->with('alert-success', 'User Interface Settings reset to default');
    }

    public function resetSystem()
    {
        $systemSettings = Setting::where('type', 'system')->get();
        foreach($systemSettings as $setting)
        {
            Setting::where('name', $setting->name)->update([
                'value' => $setting->default
            ]);
        }
        return redirect()->route('settings.index', ['#settings-tabs-system'])->with('alert-success', 'System Settings reset to default');
    }

    /**
     * Migrate UI Settings for users who doesn't have UI settings data
     */
    public function migrateUsersUISettings()
    {
        foreach (User::get() as $user) {
            foreach (Setting::where('type', '!=', 'system')->where('type', '!=', 'company')->get() as $setting) {
                if(UserSetting::where([
                    ['setting_id', $setting->id],
                    ['user_id', $user->id],
                ])->doesntExist()){
                    UserSetting::create([
                        'setting_id' => $setting->id,
                        'user_id' => $user->id,
                        'value' => $setting->default,
                    ]);
                }
            }
        }

        return back()->with('alert-success', 'Users UI settings data migrate successfully');
    }
}
