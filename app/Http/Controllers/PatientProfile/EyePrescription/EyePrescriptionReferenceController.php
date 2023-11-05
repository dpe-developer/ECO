<?php

namespace App\Http\Controllers\PatientProfile\EyePrescription;

use App\Http\Controllers\Controller;
use App\Models\PatientProfile\EyePrescription\EyePrescriptionReference;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Auth;

class EyePrescriptionReferenceController extends Controller
{

	public function __construct()
	{
		$this->middleware('auth');
		$this->middleware('permission:eye_prescription_references.index', ['only' => ['index']]);
		$this->middleware('permission:eye_prescription_references.create', ['only' => ['create','store']]);
		$this->middleware('permission:eye_prescription_references.show', ['only' => ['show']]);
		$this->middleware('permission:eye_prescription_references.edit', ['only' => ['edit','update']]);
		$this->middleware('permission:eye_prescription_references.destroy', ['only' => ['destroy']]);
		$this->middleware('permission:eye_prescription_references.restore', ['only' => ['restore']]);
	}
	
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index(Request $request)
	{
		$EyePrescriptionReferences = EyePrescriptionReference::select('*');
		if(($query = $request->get('q'))){
			$EyePrescriptionReferences->where('name', 'LIKE', '%'.$query.'%');
		}
		$data = ([
			'references' => $EyePrescriptionReferences->whereNull('parent_id')->paginate(10),
		]);
		return view('patients.patient_profile.eye_prescriptions.references', $data); 
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create(Request $request)
	{
		$data = [
			'baseUrl' => 'eye_prescription_references',
			'modalTitle' => 'Eye Prescription',
			'parent_references' => EyePrescriptionReference::where('type', 'parent')->get(),
			'child_references' => EyePrescriptionReference::where('type', 'child_parent')->whereNull('child_id')->get(),
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

		EyePrescriptionReference::create([
			'parent_id' => $request->get('parent_id'),
			'child_id' => $request->get('child_id'),
			'type' => $request->get('type'),
			'name' => $request->get('name'),
			'description' => $request->get('description'),
		]);

		return redirect()->route('eye_prescription_references.index')->with('alert-success','Eye Prescription reference added');	
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  \App\Models\EyePrescriptionReference  $EyePrescriptionReference
	 * @return \Illuminate\Http\Response
	 */
	public function show(EyePrescriptionReference $EyePrescriptionReference)
	{
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  \App\Models\EyePrescriptionReference  $EyePrescriptionReference
	 * @return \Illuminate\Http\Response
	 */
	public function edit(EyePrescriptionReference $EyePrescriptionReference)
	{
		$data = [
			'baseUrl' => 'eye_prescription_references',
			'modalTitle' => 'Eye Prescription',
			'patientProfileReference_edit' => $EyePrescriptionReference,
			'parent_references' => EyePrescriptionReference::whereNull('parent_id')->get(),
			'child_references' => EyePrescriptionReference::whereNotNull('parent_id')->whereNull('child_id')->get(),
		];
		return response()->json([
			'modal_content' => view('patients.patient_profile.edit_reference', $data)->render()
		]);
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \App\Models\EyePrescriptionReference  $EyePrescriptionReference
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request, EyePrescriptionReference $EyePrescriptionReference)
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
		$EyePrescriptionReference->update($data);

		return redirect()->route('eye_prescription_references.index');  
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  \App\Models\EyePrescriptionReference  $EyePrescriptionReference
	 * @return \Illuminate\Http\Response
	 */
	public function destroy(EyePrescriptionReference $EyePrescriptionReference)
	{
		if (request()->get('permanent')) {
			$EyePrescriptionReference->forceDelete();
		}else{
			$EyePrescriptionReference->delete();
		}
		return redirect()->route('eye_prescription_references.index')->with('alert-danger','Deleted');
	}

	public function restore($EyePrescriptionReference)
	{
		$EyePrescriptionReference = EyePrescriptionReference::withTrashed()->find($EyePrescriptionReference);
		$EyePrescriptionReference->restore();
		return redirect()->route('eye_prescription_references.index')->with('alert-success','Retrieved');
	}
}
