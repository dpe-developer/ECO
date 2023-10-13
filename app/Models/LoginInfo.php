<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Wildside\Userstamps\Userstamps;

class LoginInfo extends Model
{
    use Userstamps;
	protected $table = 'login_info';

	protected $fillable = [
		'username',
		'password',
		'status',
		'ip_address',
		'device',
		'platform',
		'browser',
	];
}
