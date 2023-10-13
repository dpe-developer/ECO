<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Wildside\Userstamps\Userstamps;
use Spatie\Permission\Traits\HasRoles;

class UserSetting extends Model
{

    use Userstamps;
	use HasRoles;

    protected $table = 'user_settings';

    protected $fillable = [
        'setting_id',
        'user_id',
        'value',
        'created_by',
        'updated_by',
        'deleted_by',
    ];

    public function setting()
    {
        return $this->belongsTo('App\Models\Setting', 'setting_id');
    }
}
