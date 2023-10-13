<?php

namespace App\Models\RolePermission;

use Illuminate\Database\Eloquent\Model;
// use Illuminate\Database\Eloquent\SoftDeletes;
use Wildside\Userstamps\Userstamps;

class UserRole extends Model
{
	// use SoftDeletes;
	use Userstamps;
	public $timestamps = false;
	protected $table = 'model_has_roles';

	protected $fillable = [
		'role_id',
		'model_type',
		'model_id',
	];

	public function role()
	{
		return $this->belongsTo('App\Models\RolePermission\Role', 'role_id');
	}
}
