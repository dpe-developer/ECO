<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Wildside\Userstamps\Userstamps;
use Spatie\Permission\Traits\HasRoles;
use App\Models\LoginInfos;
use App\Models\Appointments;
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

    /**
     * Relation
     */
    public function role()
	{
		return $this->belongsTo('App\Models\RolePermission\UserRole', 'id', 'model_id');
	}

    public function appointments()
    {
        return $this->hasMany('App\Models\Appointment', 'patient_id');
    }
    /**
     * END OF Relation
     */

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

    public function isDoctor()
    {
        if($this->role_id == 3){
            return true;
        }
        return false;
    }

    /**
     * format
     * f = first name
     * m = middle initial
     * M = middle name 
     * l= last name 
     */
    public function fullname($format = null)
	{
        $name = "";
        $trashedBadge = "";
        if($format != null){
            $format = explode('-', $format);
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
        }else{
            $name = $this->first_name.' '.
                ((is_null($this->middle_name) || $this->middle_name=='')  ? '' : $this->middle_name[0].'. ').
                $this->last_name;
        }

        if($this->trashed()){
            $trashedBadge .= ' <span class="badge badge-danger">Deleted</span>';
        }
		
		return $name.$trashedBadge;
    }

    public function age()
    {
        $bdate = $this->birthdate;
		if($bdate != null){
			$bdate = Carbon::parse($bdate);
			$now = Carbon::now();
			$age = $bdate->diffInYears($now);
			/*// date now
			$d_now = date("d");
			$m_now = date("m");
			$y_now = date("Y");
			// birth date
			$d_bd = date("d", strtotime($bdate));
			$m_bd = date("m", strtotime($bdate));
			$y_bd = date("Y", strtotime($bdate));

			if ($m_bd > $m_now || $d_bd > $d_now & $m_bd >= $m_now){
				$compute = $y_now - $y_bd;
				$age = $compute - 1;
			}
			else {
				$age = $y_now - $y_bd;
			}*/
			return $age;
		}else{
			return '';
		}
	}

    /**
     * Functions for Patients
     */
    public function visits()
    {
        return $this->hasMany('App\Models\PatientVisit', 'patient_id');
    }
    public function activeVisit()
	{
		return $this->hasMany('App\Models\PatientVisit', 'patient_id')->where('status', 'active')->latest()->first();
	}

    public function hasActiveVisit()
    {
        if(isset($this->activeVisit()->id)){
            return true;
        }
        return false;
    }

    public function findings()
    {
        return $this->hasMany('App\Models\PatientFindings', 'patient_id');
    }

    public function medicalHistories()
    {
        return $this->hasMany('App\Models\PatientProfile\MedicalHistory\MedicalHistory', 'patient_id');
    }

    public function complaints()
    {
        return $this->hasMany('App\Models\PatientProfile\Complaint\Complaint', 'patient_id');
    }

    public function eyePrescriptions()
    {
        return $this->hasMany('App\Models\PatientProfile\EyePrescription\EyePrescription', 'patient_id');
    }
    /**
     * END OF Functions for Patients
     */

    /**
     * User notification badges
     */
    public function seenAppointments()
    {
        return $this->hasMany('App\Models\UserNotification', 'user_id')->where('notification_type', 'appointment');
    }

    public function newAppointments()
    {
        $seenAppointments = $this->seenAppointments()->get('entity_id');
        return Appointment::whereNotIn('id', $seenAppointments);
    }

    /**
     * Static Functions
     */
    public static function getName($userID, $format = null)
    {
        $user = self::find($userID);
        $name = "";
        $trashedBadge = "";
        if($format != null){
            $format = explode('-', $format);
            for ($i=0; $i < count($format); $i++) { 
                switch ($format[$i]) {
                    case 'f':
                        if($i == 0)
                            $name .= $user->first_name;
                        elseif($i == 1)
                            $name .= $user->first_name;
                        break;
                    case 'm':
                        if(!is_null($user->middle_name)){
                            if($i == 1){
                                $name .= ' '.$user->middle_name[0].'. ';
                            }else{
                                $name .= ' '.$user->middle_name[0].'. ';
                            }
                        }
                        break;
                    case 'M':
                        if(!is_null($user->middle_name) || $user->middle_name==''){
                            if($i == 1){
                                $name .= ' '.$user->middle_name[0].'. ';
                            }else{
                                $name .= ' '.$user->middle_name[0].'. ';
                            }
                        }
                        break;
                    case 'l':
                        if($i == 0){
                            $name .= $user->last_name.', ';
                        }elseif($i == 2){
                            $name .= ' '.$user->last_name;
                        }
                        break;
                    /* case 's':
                        // if($i == 3){
                            $name .= $user->suffix;
                        // }
                        break; */
                    
                    default:
                    $name = $user->first_name.' '.
                    ((is_null($user->middle_name) || $user->middle_name=='')  ? '' : $user->middle_name[0].'. ').
                        $user->last_name;
                        // ' '.$user->suffix;
                        break;
                }
            }
        }else{
            $name = $user->first_name.' '.
                ((is_null($user->middle_name) || $user->middle_name=='')  ? '' : $user->middle_name[0].'. ').
                $user->last_name;
        }

        if($user->trashed()){
            $trashedBadge .= ' <span class="badge badge-danger">Deleted</span>';
        }
		
		return $name.$trashedBadge;
    }

}
