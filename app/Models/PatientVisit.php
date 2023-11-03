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

    public function patient()
    {
        return $this->belongsTo('App\Models\User', 'patient_id');
    }

    public function doctor()
    {
        return $this->belongsTo('App\Models\User', 'doctor_id');
    }

    public function service()
    {
        return $this->belongsTo('App\Models\Service', 'service_id');
    }

    public function eyePrescriptions()
    {
        return $this->hasMany('App\Models\PatientProfile\EyePrescription\EyePrescription', 'visit_id');
    }
}
