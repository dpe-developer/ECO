<?php

namespace App\Models\PatientProfile\EyePrescription;

use Illuminate\Database\Eloquent\Model;

class EyePrescription extends Model
{
    protected $table = 'eye_prescription';

    protected $fillable = [
		'patient_id',
		'visit_id',
		'doctor_id',
		'remarks',
		'created_at',
		'updated_at',
	];

	public function result()
	{
		return $this->hasMany('App\Models\PatientProfile\EyePrescription\EyePrescriptionData', 'eye_prescription_id');
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
