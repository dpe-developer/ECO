<?php

namespace App\Models\PatientProfile\Complaint;

use Illuminate\Database\Eloquent\Model;

class Complaint extends Model
{
    protected $table = 'complaint';

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
		return $this->hasMany('App\Models\PatientProfile\Complaint\ComplaintData', 'complaint_id');
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
