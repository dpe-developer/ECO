<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Wildside\Userstamps\Userstamps;
use Spatie\Permission\Traits\HasRoles;
use App\Models\LoginInfos;
use DB;
use Carbon\Carbon;

class User extends Authenticatable
{
    use Notifiable;
	use SoftDeletes;
	use Userstamps;
	use HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'role_id',
        'avatar_file_attachment_id',
        'username',
        'first_name',
        'last_name',
        'sex',
        'birthdate',
        'address',
        'occupation',
        'contact_number',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
	 * The attributes that should be mutated to dates.
	 *
	 * @var array
	 */
	protected $dates = ['deleted_at'];

    public function role()
	{
		return $this->belongsTo('App\Models\RolePermission\UserRole', 'id', 'model_id');
	}

    public function avatar()
	{
		return $this->belongsTo('App\Models\FileAttachment', 'avatar_file_attachment_id');
	}

    public function loginInfos()
	{
		// return $this->hasMany('App\Models\LoginInfo', 'created_by');
        return LoginInfo::where('username', $this->username)
            ->orderBy('created_at', 'DESC')
            ->get()
            ->groupBy(function ($val) {
                return Carbon::parse($val->created_at)->format('F d, Y');
            });
	}

    public function getAvatar()
    {
        $avatar = "images/avatar.png";
        if(isset($this->avatar->id)){
            $avatar = $this->avatar->file_path.'/'.$this->avatar->file_name;
        }
        return $avatar;
    }

    /**
     * format
     * f = first name
     * m = middle initial
     * M = middle name 
     * l= last name 
     */
    public function fullname($format)
	{
        $format = explode('-', $format);
        $name = "";
        $trashedBadge = "";
        for ($i=0; $i < count($format); $i++) { 
            switch ($format[$i]) {
                case 'f':
                    if($i == 0)
                        $name .= $this->first_name;
                    elseif($i == 1)
                        $name .= $this->first_name;
                    break;
                case 'm':
                    if(!is_null($this->middle_name)){
                        if($i == 1){
                            $name .= ' '.$this->middle_name[0].'. ';
                        }else{
                            $name .= ' '.$this->middle_name[0].'. ';
                        }
                    }
                    break;
                case 'M':
                    if(!is_null($this->middle_name) || $this->middle_name==''){
                        if($i == 1){
                            $name .= ' '.$this->middle_name[0].'. ';
                        }else{
                            $name .= ' '.$this->middle_name[0].'. ';
                        }
                    }
                    break;
                case 'l':
                    if($i == 0){
                        $name .= $this->last_name.', ';
                    }elseif($i == 2){
                        $name .= ' '.$this->last_name;
                    }
                    break;
                /* case 's':
                    // if($i == 3){
                        $name .= $this->suffix;
                    // }
                    break; */
                
                default:
                $name = $this->first_name.' '.
                ((is_null($this->middle_name) || $this->middle_name=='')  ? '' : $this->middle_name[0].'. ').
                    $this->last_name;
				    // ' '.$this->suffix;
                    break;
            }
        }

        if($this->trashed()){
            $trashedBadge .= ' <span class="badge badge-danger">Deleted</span>';
        }
		
		return $name.$trashedBadge;
    }
}
