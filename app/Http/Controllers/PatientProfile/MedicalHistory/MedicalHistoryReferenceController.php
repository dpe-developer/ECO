<?php

namespace App\Http\Controllers\PatientProfile\MedicalHistory;

use App\Http\Controllers\Controller;
use App\Models\PatientProfile\MedicalHistory\MedicalHistoryReference;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Auth;

class MedicalHistoryReferenceController extends Controller
{
    public function __construct()
	{
		$this->middleware('auth');
		$this->middleware('permission:medical_history_references.index', ['only' => ['index']]);
		$this->middleware('permission:medical_history_references.create', ['only' => ['create','store']]);
		$this->middleware('permission:medical_history_references.show', ['only' => ['show']]);
		$this->middleware('permission:medical_history_references.edit', ['only' => ['edit','update']]);
		$this->middleware('permission:medical_history_references.destroy', ['only' => ['destroy']]);
		$this->middleware('permission:medical_history_references.restore', ['only' => ['restore']]);
	}

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $MedicalHistoryReferences = MedicalHistoryReference::select('*');
		if(($query = $request->get('q'))){
			$MedicalHistoryReferences->where('name', 'LIKE', '%'.$query.'%');
		}
		$data = ([
			'references' => $MedicalHistoryReferences->whereNull('parent_id')->paginate(10),
		]);
		return view('patients.patient_profile.medical_histories.references', $data); 
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data = [
			'baseUrl' => 'medical_history_references',
			'modalTitle' => 'Medical History',
			'parent_references' => MedicalHistoryReference::where('type', 'parent')->get(),
			'child_references' => MedicalHistoryReference::where('type', 'child_parent')->whereNull('child_id')->get(),
		];
		return response()->json([
			'modal_content' => view('patients..patient_profile.create_reference', $data)->render()
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
			'type' => 'required',
			'name' => 'required',
		]);

		MedicalHistoryReference::create([
			'parent_id' => $request->get('parent_id'),
			'child_id' => $request->get('child_id'),
			'type' => $request->get('type'),
			'name' => $request->get('name'),
			'description' => $request->get('description'),
		]);

		return redirect()->route('medical_history_references.index')->with('alert-success','Medical History reference added');	
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\PatientProfile\MedicalHistory\MedicalHistoryReference  $medicalHistoryReference
     * @return \Illuminate\Http\Response
     */
    public function show(MedicalHistoryReference $medicalHistoryReference)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\PatientProfile\MedicalHistory\MedicalHistoryReference  $medicalHistoryReference
     * @return \Illuminate\Http\Response
     */
    public function edit(MedicalHistoryReference $medicalHistoryReference)
    {
        $data = [
			'baseUrl' => 'medical_history_references',
			'modalTitle' => 'Medical History',
			'patientProfileReference_edit' => $medicalHistoryReference,
			'parent_references' => MedicalHistoryReference::whereNull('parent_id')->get(),
			'child_references' => MedicalHistoryReference::whereNotNull('parent_id')->whereNull('child_id')->get(),
		];
		return response()->json([
			'modal_content' => view('patients.patient_profile.edit_reference', $data)->render()
		]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\PatientProfile\MedicalHistory\MedicalHistoryReference  $medicalHistoryReference
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, MedicalHistoryReference $medicalHistoryReference)
    {
        $request->validate([
			'type' => 'required',
			'name' => 'required',
		]);

		$data = ([
			'parent_id' => $request->get('parent_id'),
			'child_id' => $request->get('child_id'),
			'type' => $request->get('type'),
			'name' => $request->get('name'),
			'description' => $request->get('description'),
		]);
		$medicalHistoryReference->update($data);

		return redirect()->route('medical_history_references.index');  
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\PatientProfile\MedicalHistory\MedicalHistoryReference  $medicalHistoryReference
     * @return \Illuminate\Http\Response
     */
    public function destroy(MedicalHistoryReference $medicalHistoryReference)
	{
		if (request()->get('permanent')) {
			$medicalHistoryReference->forceDelete();
		}else{
			$medicalHistoryReference->delete();
		}
		return redirect()->route('medical_history_references.index')->with('alert-danger','Deleted');
	}

	public function restore($medicalHistoryReference)
	{
		$medicalHistoryReference = MedicalHistoryReference::withTrashed()->find($medicalHistoryReference);
		$medicalHistoryReference->restore();
		return redirect()->route('medical_history_references.index')->with('alert-success','Retrieved');
	}
}
