<?php

namespace App\Models\PatientProfile\Complaint;

use Illuminate\Database\Eloquent\Model;

class ComplaintData extends Model
{
    protected $table = 'complaint_data';

	protected $fillable = [
		'complaint_id',
		'parent_id',
		'child_id',
		'type',
		'name',
		'description',
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
        return $this->hasMany('App\Models\PatientProfile\Complaint\ComplaintData', 'parent_id')->whereNotNull('result');
	}

	public function child_not_null()
	{
        return $this->hasMany('App\Models\PatientProfile\Complaint\ComplaintData', 'child_id')->whereNotNull('result');
	}

	public function children()
	{
        return $this->hasMany('App\Models\PatientProfile\Complaint\ComplaintData', 'parent_id');
	}

	public function child()
	{
        return $this->hasMany('App\Models\PatientProfile\Complaint\ComplaintData', 'child_id');
	}
}
