<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Wildside\Userstamps\Userstamps;
use Spatie\Permission\Traits\HasRoles;
use Auth;

class Setting extends Model
{
    protected $table = 'settings';

    use SoftDeletes;
	use Userstamps;
	use HasRoles;

    protected $fillable = [
        'type',
        'name',
        'value',
        'default',
        'created_by',
        'updated_by',
        'deleted_by'
    ];

    public static function company($data)
    {
        $setting = Setting::where([
            ['type', 'company'],
            ['name', $data]
        ])->first();
        $value = $setting->value;
        if($setting->value == null || $setting->value == ''){
            $value = $setting->default;
        }
        return $value;
    }

    public static function system($data)
    {
        $setting = Setting::where([
            ['type', 'system'],
            ['name', $data]
        ])->first();
        $value = $setting->value;
        if($setting->value == null || $setting->value == ''){
            $value = $setting->default;
        }
        return $value;
    }

    public static function ui($data)
    {
        $value = null;
        if(Setting::where([['type', 'ui'],['name', $data]])->exists()){
            $setting = Setting::where([
                ['type', 'ui'],
                ['name', $data]
            ])->first();
            if(Setting::system('users_can_customize_ui') == 1 || Auth::user()->hasrole('System Administrator')){
                $setting = UserSetting::where([
                    ['setting_id', $setting->id],
                    ['user_id', Auth::user()->id]
                ])->first();
            }
            $value = $setting->value;
            if($setting->value == null || $setting->value == ''){
                $value = $setting->default;
                if($setting->default == null || $setting->default == ''){
                    $value = null;
                }
            }

            
        }
        return $value;
    }
}
