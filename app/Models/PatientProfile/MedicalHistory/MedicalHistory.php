<?php

namespace App\Models\PatientProfile\MedicalHistory;

use Illuminate\Database\Eloquent\Model;

class MedicalHistory extends Model
{
    protected $table = 'medical_history';

    protected $fillable = [
		'patient_id',
		'visit_id',
		'doctor_id',
		'remarks',
	];

	public function result()
	{
		return $this->hasMany('App\Models\PatientProfile\MedicalHistory\MedicalHistoryData', 'medical_history_id');
	}

	public function doctor()
	{
		return $this->belongsTo('App\Models\User', 'doctor_id');
	}

	public function patient()
	{
		return $this->belongsTo('App\Models\User', 'patient_id');
	}

	public function visit()
	{
		return $this->belongsTo('App\Models\PatientVisit', 'visit_id');
	}
}
