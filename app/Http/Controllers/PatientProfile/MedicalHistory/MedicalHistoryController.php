<?php

namespace App\Http\Controllers\PatientProfile\MedicalHistory;

use App\Http\Controllers\Controller;
use App\Models\PatientProfile\MedicalHistory\MedicalHistory;
use App\Models\PatientProfile\MedicalHistory\MedicalHistoryReference;
use App\Models\PatientProfile\MedicalHistory\MedicalHistoryData;
use App\Models\User;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Auth;

class MedicalHistoryController extends Controller
{
    public function __construct()
	{
		$this->middleware('auth');
		$this->middleware('permission:medical_histories.index', ['only' => ['index']]);
		$this->middleware('permission:medical_histories.create', ['only' => ['create','store']]);
		$this->middleware('permission:medical_histories.show', ['only' => ['show']]);
		$this->middleware('permission:medical_histories.edit', ['only' => ['edit','update']]);
		$this->middleware('permission:medical_histories.destroy', ['only' => ['destroy']]);
		$this->middleware('permission:medical_histories.restore', ['only' => ['restore']]);
	}
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data = [
			'patient' => User::find(request()->get('patient_id')),
			'doctors' => User::where('role_id', 3)->get(),
			'medical_history_references' => MedicalHistoryReference::get(),
		];
		return response()->json([
			'modal_content' => view('patients.patient_profile.medical_histories.create', $data)->render()
		]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
			'doctor' => ['required'],
			'patient' => ['required'],
		]);
		$medicalHistory = MedicalHistory::create([
			'patient_id' => $request->get('patient'),
			'visit_id' => $request->get('visit'),
			'doctor_id' => $request->get('doctor'),
		]);
		$references = MedicalHistoryReference::get();

		foreach ($references as $reference) {
			if($reference->children->count()){
				$parent_reference = MedicalHistoryData::create([
					'medical_history_id' => $medicalHistory->id,
					'parent_id' => null,
					'child_id' => null,
					'type' => $reference->type,
					'name' => $reference->name,
					'description' => $reference->description,
					'value' => $request->get($reference->id),
					'sub_value' => $request->get('input_'.$reference->id),
				]);
				foreach ($reference->children as $children) {
					if($children->child->count()){
						$children_reference = MedicalHistoryData::create([
							'medical_history_id' => $medicalHistory->id,
							'parent_id' => $parent_reference->id,
							'child_id' => null,
							'type' => $children->type,
							'name' => $children->name,
							'description' => $children->description,
							'value' => $request->get($children->id),
							'sub_value' => $request->get('input_'.$children->id),
						]);
						foreach ($children->child as $child) {
							MedicalHistoryData::create([
								'medical_history_id' => $medicalHistory->id,
								'parent_id' => $parent_reference->id,
								'child_id' => $children_reference->id,
								'type' => $child->type,
								'name' => $child->name,
								'description' => $child->description,
								'value' => $request->get($child->id),
								'sub_value' => $request->get('input_'.$child->id),
							]);
						}
					}elseif($children->child->count() == 0 && $children->child_id == null){
						MedicalHistoryData::create([
							'medical_history_id' => $medicalHistory->id,
							'parent_id' => $parent_reference->id,
							'child_id' => null,
							'type' => $children->type,
							'name' => $children->name,
							'description' => $children->description,
							'value' => $request->get($children->id),
							'sub_value' => $request->get('input_'.$children->id),
						]);
					}
				}
			}elseif($reference->parent_id == null && $reference->child_id == null){
				MedicalHistoryData::create([
					'medical_history_id' => $medicalHistory->id,
					'parent_id' => null,
					'child_id' => null,
					'type' => $reference->type,
					'name' => $reference->name,
					'description' => $reference->description,
					'value' => $request->get($reference->id),
					'sub_value' => $request->get('input_'.$reference->id),
				]);
			}
		}

		return redirect()->route('patients.show', $request->patient)
					->with('alert-success', 'Vital Information successfully added');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\PatientProfile\MedicalHistory\MedicalHistory  $medicalHistory
     * @return \Illuminate\Http\Response
     */
    public function show(MedicalHistory $medicalHistory)
    {
        $medicalHistory_show = $medicalHistory;
		return response()->json([
			'modal_content' => view('patients.patient_profile.medical_histories.show', compact('medicalHistory_show'))->render()
		]);

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\PatientProfile\MedicalHistory\MedicalHistory  $medicalHistory
     * @return \Illuminate\Http\Response
     */
    public function edit(MedicalHistory $medicalHistory)
    {
        $data = [
			'medicalHistory_edit' => $medicalHistory,
			'patient' => $medicalHistory->patient,
			'doctors' => User::where('role_id', 3)->get(),
		];
		return response()->json([
			'modal_content' => view('patients.patient_profile.medical_histories.edit', $data)->render()
		]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\PatientProfile\MedicalHistory\MedicalHistory  $medicalHistory
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, MedicalHistory $medicalHistory)
    {
        $request->validate([
			'doctor' => ['required'],
		]);

		$isUpdated = false;

		$medicalHistory->update([
			'doctor_id' => $request->get('doctor'),
		]);

		if($medicalHistory->doctor_id != $request->get('doctor')){
			$isUpdated = true;
		}

		foreach ($medicalHistory->result as $result) {
			$medicalHistoryData = MedicalHistoryData::find($result->id);
			if(isset($medicalHistoryData->id)){
				if($medicalHistoryData->value != $request->get($result->id) || $medicalHistoryData->sub_value != $request->get('input_'.$result->id)){
					$isUpdated = true;
					$medicalHistoryData->update([
						'value' => $request->get($result->id),
						'sub_value' => $request->get('input_'.$result->id),
					]);
				}
			}
		}

		if($isUpdated){
			$medicalHistory->update([
				'updated_at' => Carbon::now(),
			]);
		}

		return redirect()->route('patients.show', $medicalHistory->patient_id)->with('alert-sucess', 'Medical History UPDATED');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\PatientProfile\MedicalHistory\MedicalHistory  $medicalHistory
     * @return \Illuminate\Http\Response
     */
    public function destroy(MedicalHistory $medicalHistory)
    {
        $medicalHistory->delete();
		return back()->with('alert-warning', trans('terminologies.medical_history').' DELETED');
    }
}
