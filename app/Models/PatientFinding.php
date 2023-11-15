<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PatientFinding extends Model
{
    protected $table = 'patient_findings';

    protected $fillable = [
        'patient_id',
        'visit_id',
        'doctor_id',
        'findings',
    ];
    
    /**
     * Relations
     */
    public function patient()
    {
        return $this->belongsTo('App\Models\User', 'patient_id');
    }

    public function patientVisit()
    {
        return $this->belongsTo('App\Models\User', 'visit_id');
    }

    public function doctor()
    {
        return $this->belongsTo('App\Models\User', 'doctor_id');
    }
    /**
     * END OF Relations
     */
}
