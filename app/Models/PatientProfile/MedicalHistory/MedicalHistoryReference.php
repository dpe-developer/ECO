<?php

namespace App\Models\PatientProfile\MedicalHistory;

use Illuminate\Database\Eloquent\Model;

class MedicalHistoryReference extends Model
{
    protected $table = 'medical_history_references';

	protected $fillable = [
		'type',
		'name',
		'description',
		'parent_id',
		'child_id',
	];

	public function parent()
	{
		return $this->belongsTo('App\Models\PatientProfile\MedicalHistory\MedicalHistoryReference', 'parent_id');
	}

	public function children()
	{
        return $this->hasMany('App\Models\PatientProfile\MedicalHistory\MedicalHistoryReference', 'parent_id');
	}

	public function child()
	{
        return $this->hasMany('App\Models\PatientProfile\MedicalHistory\MedicalHistoryReference', 'child_id');
	}

	public function type($type)
	{
		if($type == 'text') {
			return "Text Input";
		}
		elseif($type == 'checkbox') {
			return "Check Box";
		}
		elseif($type == 'checkbox_selection') {
			return "Check Box with selection";
		}
		elseif($type == 'textarea'){
			return "Paragraph";
		}
		elseif($type == 'check_textbox'){
			return "Check Box with Text Input";
		}
		elseif($type == 'parent'){
			return "Parent";
		}
		elseif($type == 'child_parent'){
			return "Child Parent";
		}
		else{
			return "--";
		}
	}
}
