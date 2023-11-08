<?php

namespace App\Http\Controllers\PatientProfile\Complaint;

use App\Http\Controllers\Controller;
use App\Models\PatientProfile\Complaint\Complaint;
use App\Models\PatientProfile\Complaint\ComplaintReference;
use App\Models\PatientProfile\Complaint\ComplaintData;
use App\Models\User;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Auth;

class ComplaintController extends Controller
{
    public function __construct()
	{
		$this->middleware('auth');
		$this->middleware('permission:complaints.index', ['only' => ['index']]);
		$this->middleware('permission:complaints.create', ['only' => ['create','store']]);
		$this->middleware('permission:complaints.show', ['only' => ['show']]);
		$this->middleware('permission:complaints.edit', ['only' => ['edit','update']]);
		$this->middleware('permission:complaints.destroy', ['only' => ['destroy']]);
		$this->middleware('permission:complaints.restore', ['only' => ['restore']]);
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
			'complaint_references' => ComplaintReference::get(),
		];
		return response()->json([
			'modal_content' => view('patients.patient_profile.complaints.create', $data)->render()
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
		$complaint = Complaint::create([
			'patient_id' => $request->get('patient'),
			'visit_id' => $request->get('visit'),
			'doctor_id' => $request->get('doctor'),
		]);
		$references = ComplaintReference::get();

		foreach ($references as $reference) {
			if($reference->children->count()){
				$parent_reference = ComplaintData::create([
					'complaint_id' => $complaint->id,
					'parent_id' => null,
					'child_id' => null,
					'type' => $reference->type,
					'name' => $reference->name,
					'description' => $reference->description,
					'value' => $request->get($reference->id),
					'sub_value' => $request->get('input_'.$reference->id),
				]);
				echo '<h3>'.$parent_reference->id.' - '.$reference->name.':</h3>';
				foreach ($reference->children as $children) {
					if($children->child->count()){
						$children_reference = ComplaintData::create([
							'complaint_id' => $complaint->id,
							'parent_id' => $parent_reference->id,
							'child_id' => null,
							'type' => $children->type,
							'name' => $children->name,
							'description' => $children->description,
							'value' => $request->get($children->id),
							'sub_value' => $request->get('input_'.$children->id),
						]);
						foreach ($children->child as $child) {
							ComplaintData::create([
								'complaint_id' => $complaint->id,
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
						ComplaintData::create([
							'complaint_id' => $complaint->id,
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
				ComplaintData::create([
					'complaint_id' => $complaint->id,
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
					->with('alert-success', 'Eye Prescription successfully added');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\PatientProfile\Complaint\Complaint  $complaint
     * @return \Illuminate\Http\Response
     */
    public function show(Complaint $complaint)
    {
        $complaint_show = $complaint;
		return response()->json([
			'modal_content' => view('patients.patient_profile.complaints.show', compact('complaint_show'))->render()
		]);

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\PatientProfile\Complaint\Complaint  $complaint
     * @return \Illuminate\Http\Response
     */
    public function edit(Complaint $complaint)
    {
        $data = [
			'complaint_edit' => $complaint,
			'patient' => $complaint->patient,
			'doctors' => User::where('role_id', 3)->get()
		];
		return response()->json([
			'modal_content' => view('patients.patient_profile.complaints.edit', $data)->render()
		]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\PatientProfile\Complaint\Complaint  $complaint
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Complaint $complaint)
    {
        $request->validate([
			'doctor' => ['required'],
		]);
		
		$isUpdated = false;

		$complaint->update([
			'doctor_id' => $request->get('doctor'),
		]);

		if($complaint->doctor_id != $request->get('doctor')){
			$isUpdated = true;
		}

		foreach ($complaint->result as $result) {
			$complaintData = ComplaintData::find($result->id);
			if(isset($complaintData->id)){
				if($complaintData->value != $request->get($result->id) || $complaintData->sub_value != $request->get('input_'.$result->id)){
					$isUpdated = true;
					$complaintData->update([
						'value' => $request->get($result->id),
						'sub_value' => $request->get('input_'.$result->id),
					]);
				}
			}
		}

		if($isUpdated){
			$complaint->update([
				'updated_at' => Carbon::now(),
			]);
		}

		return redirect()->route('patients.show', $complaint->patient_id)->with('alert-success', trans('terminologies.complaint').' UPDATED');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\PatientProfile\Complaint\Complaint  $complaint
     * @return \Illuminate\Http\Response
     */
    public function destroy(Complaint $complaint)
    {
        $complaint->delete();
		return back()->with('alert-warning', trans('terminologies.complaint').' DELETED');
    }
}
