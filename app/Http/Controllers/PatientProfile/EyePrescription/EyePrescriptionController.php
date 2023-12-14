<?php

namespace App\Http\Controllers\PatientProfile\EyePrescription;

use App\Http\Controllers\Controller;
use App\Models\PatientProfile\EyePrescription\EyePrescription;
use App\Models\PatientProfile\EyePrescription\EyePrescriptionReference;
use App\Models\PatientProfile\EyePrescription\EyePrescriptionData;
use App\Models\User;
use App\Models\PatientVisit;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Auth;

class EyePrescriptionController extends Controller
{
    public function __construct()
	{
		$this->middleware('auth');
		$this->middleware('permission:eye_prescriptions.index', ['only' => ['index']]);
		$this->middleware('permission:eye_prescriptions.create', ['only' => ['create','store']]);
		$this->middleware('permission:eye_prescriptions.show', ['only' => ['show']]);
		$this->middleware('permission:eye_prescriptions.edit', ['only' => ['edit','update']]);
		$this->middleware('permission:eye_prescriptions.destroy', ['only' => ['destroy']]);
		$this->middleware('permission:eye_prescriptions.restore', ['only' => ['restore']]);
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
    public function create(Request $request)
    {
        $data = [
			'patientVisit' => PatientVisit::find($request->get('visit_id')),
			'patient' => User::find(request()->get('patient_id')),
			'doctors' => User::where('role_id', 3)->get(),
			'eye_prescription_references' => EyePrescriptionReference::get(),
		];
		return response()->json([
			'modal_content' => view('patients.patient_profile.eye_prescriptions.create', $data)->render()
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
		$eyePrescription = EyePrescription::create([
			'patient_id' => $request->get('patient'),
			'visit_id' => $request->get('visit'),
			'doctor_id' => $request->get('doctor'),
		]);
		$references = EyePrescriptionReference::get();

		foreach ($references as $reference) {
			if($reference->children->count()){
				$parent_reference = EyePrescriptionData::create([
					'eye_prescription_id' => $eyePrescription->id,
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
						$children_reference = EyePrescriptionData::create([
							'eye_prescription_id' => $eyePrescription->id,
							'parent_id' => $parent_reference->id,
							'child_id' => null,
							'type' => $children->type,
							'name' => $children->name,
							'description' => $children->description,
							'value' => $request->get($children->id),
							'sub_value' => $request->get('input_'.$children->id),
						]);
						foreach ($children->child as $child) {
							EyePrescriptionData::create([
								'eye_prescription_id' => $eyePrescription->id,
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
						EyePrescriptionData::create([
							'eye_prescription_id' => $eyePrescription->id,
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
				EyePrescriptionData::create([
					'eye_prescription_id' => $eyePrescription->id,
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

		return back()->with('alert-success', trans('terminologies.eye_prescription').' successfully ADDED');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\PatientProfile\EyePrescription\EyePrescription  $eyePrescription
     * @return \Illuminate\Http\Response
     */
    public function show(EyePrescription $eyePrescription)
    {
        $eyePrescription_show = $eyePrescription;
		return response()->json([
			'modal_content' => view('patients.patient_profile.eye_prescriptions.show', compact('eyePrescription_show'))->render()
		]);

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\PatientProfile\EyePrescription\EyePrescription  $eyePrescription
     * @return \Illuminate\Http\Response
     */
    public function edit(EyePrescription $eyePrescription)
    {
        $data = [
			'eyePrescription_edit' => $eyePrescription,
			'patient' => $eyePrescription->patient,
			'doctors' => User::where('role_id', 3)->get()
		];
		return response()->json([
			'modal_content' => view('patients.patient_profile.eye_prescriptions.edit', $data)->render()
		]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\PatientProfile\EyePrescription\EyePrescription  $eyePrescription
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, EyePrescription $eyePrescription)
    {
        $request->validate([
			'doctor' => ['required'],
		]);
		
		$isUpdated = false;

		$eyePrescription->update([
			'doctor_id' => $request->get('doctor'),
		]);

		if($eyePrescription->doctor_id != $request->get('doctor')){
			$isUpdated = true;
		}

		foreach ($eyePrescription->result as $result) {
			$eyePrescriptionData = EyePrescriptionData::find($result->id);
			if(isset($eyePrescriptionData->id)){
				if($eyePrescriptionData->value != $request->get($result->id) || $eyePrescriptionData->sub_value != $request->get('input_'.$result->id)){
					$isUpdated = true;
					$eyePrescriptionData->update([
						'value' => $request->get($result->id),
						'sub_value' => $request->get('input_'.$result->id),
					]);
				}
			}
		}

		if($isUpdated){
			$eyePrescription->update([
				'updated_at' => Carbon::now(),
			]);
		}

		return back()->with('alert-success', trans('terminologies.eye_prescription').' UPDATED');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\PatientProfile\EyePrescription\EyePrescription  $eyePrescription
     * @return \Illuminate\Http\Response
     */
    public function destroy(EyePrescription $eyePrescription)
    {
        $eyePrescription->delete();
		return back()->with('alert-warning', trans('terminologies.eye_prescription').' DELETED');
    }
}
