<?php

namespace App\Models\PatientProfile\EyePrescription;

use Illuminate\Database\Eloquent\Model;

class EyePrescriptionData extends Model
{
    protected $table = 'eye_prescription_data';

	protected $fillable = [
		'eye_prescription_id',
		'reference_id',
		'parent_id',
		'child_id',
		'value',
		'sub_value',
	];

	public function empty_children($id){
		$parent = self::find($id);
		if($parent->children_not_null->count() == 0){
			return 'collapse';
		}else{
			return '';
		}
	}

	public function empty_child($id){
		$parent = self::find($id);
		if($parent->child_not_null->count() == 0){
			return 'collapse';
		}else{
			return '';
		}
	}

	public function children_not_null()
	{
        return $this->hasMany('App\Models\PatientProfile\EyePrescription\EyePrescriptionData', 'parent_id')->whereNotNull('result');
	}

	public function child_not_null()
	{
        return $this->hasMany('App\Models\PatientProfile\EyePrescription\EyePrescriptionData', 'child_id')->whereNotNull('result');
	}

	public function reference()
	{
		return $this->belongsTo('App\Models\PatientProfile\EyePrescription\EyePrescriptionReference', 'reference_id');
	}

	public function children()
	{
        return $this->hasMany('App\Models\PatientProfile\EyePrescription\EyePrescriptionData', 'parent_id');
	}

	public function child()
	{
        return $this->hasMany('App\Models\PatientProfile\EyePrescription\EyePrescriptionData', 'child_id');
	}
}
