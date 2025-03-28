<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PatientVisit extends Model
{
    protected $table = 'patient_visits';

    protected $fillable = [
        'appointment_id',
        'patient_id',
        'doctor_id',
        'service_id',
        'status',
        'findings',
        'complaints',
        'recommendations',
        'medical_history',
        'final_diagnosis',
        'remarks',
        'visit_date',
        'session_start',
        'session_end',
    ];

    /**
	 * The attributes that should be mutated to dates.
	 *
	 * @var array
	 */
	protected $dates = [
        'visit_date',
        'session_start',
        'session_end',
    ];

    /**
     * Relations
     */
    public function patient()
    {
        return $this->belongsTo('App\Models\User', 'patient_id')->withTrashed();
    }

    public function doctor()
    {
        return $this->belongsTo('App\Models\User', 'doctor_id')->withTrashed();
    }

    public function service()
    {
        return $this->belongsTo('App\Models\Service', 'service_id');
    }

    public function appointment()
    {
        return $this->belongsTo('App\Models\Appointment', 'appointment_id');
    }

    public function findings()
    {
        return $this->hasMany('App\Models\PatientFindings', 'visit_id');
    }
    
    public function medicalHistories()
    {
        return $this->hasMany('App\Models\PatientProfile\MedicalHistory\MedicalHistory', 'visit_id');
    }

    public function complaints()
    {
        return $this->hasMany('App\Models\PatientProfile\Complaint\Complaint', 'visit_id');
    }

    public function eyePrescriptions()
    {
        return $this->hasMany('App\Models\PatientProfile\EyePrescription\EyePrescription', 'visit_id');
    }
    /**
     * END OF Relations
     */

    
}
