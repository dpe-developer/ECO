<?php

namespace App\Http\Controllers\PatientProfile\Complaint;

use App\Http\Controllers\Controller;
use App\Models\PatientProfile\Complaint\ComplaintReference;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Auth;

class ComplaintReferenceController extends Controller
{

	public function __construct()
	{
		$this->middleware('auth');
		$this->middleware('permission:complaint_references.index', ['only' => ['index']]);
		$this->middleware('permission:complaint_references.create', ['only' => ['create','store']]);
		$this->middleware('permission:complaint_references.show', ['only' => ['show']]);
		$this->middleware('permission:complaint_references.edit', ['only' => ['edit','update']]);
		$this->middleware('permission:complaint_references.destroy', ['only' => ['destroy']]);
		$this->middleware('permission:complaint_references.restore', ['only' => ['restore']]);
	}
	
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index(Request $request)
	{
		$ComplaintReferences = ComplaintReference::select('*');
		if(($query = $request->get('q'))){
			$ComplaintReferences->where('name', 'LIKE', '%'.$query.'%');
		}
		$data = ([
			'references' => $ComplaintReferences->whereNull('parent_id')->paginate(10),
		]);
		return view('patients.patient_profile.complaints.references', $data); 
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create(Request $request)
	{
		$data = [
			'baseUrl' => 'complaint_references',
			'modalTitle' => trans('terminologies.complaint'),
			'parent_references' => ComplaintReference::where('type', 'parent')->get(),
			'child_references' => ComplaintReference::where('type', 'child_parent')->whereNull('child_id')->get(),
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

		ComplaintReference::create([
			'parent_id' => $request->get('parent_id'),
			'child_id' => $request->get('child_id'),
			'type' => $request->get('type'),
			'name' => $request->get('name'),
			'description' => $request->get('description'),
		]);

		return redirect()->route('complaint_references.index')->with('alert-success','Eye Prescription reference added');	
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  \App\Models\ComplaintReference  $ComplaintReference
	 * @return \Illuminate\Http\Response
	 */
	public function show(ComplaintReference $ComplaintReference)
	{
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  \App\Models\ComplaintReference  $ComplaintReference
	 * @return \Illuminate\Http\Response
	 */
	public function edit(ComplaintReference $ComplaintReference)
	{
		$data = [
			'baseUrl' => 'complaint_references',
			'modalTitle' => 'Eye Prescription',
			'patientProfileReference_edit' => $ComplaintReference,
			'parent_references' => ComplaintReference::whereNull('parent_id')->get(),
			'child_references' => ComplaintReference::whereNotNull('parent_id')->whereNull('child_id')->get(),
		];
		return response()->json([
			'modal_content' => view('patients.patient_profile.edit_reference', $data)->render()
		]);
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \App\Models\ComplaintReference  $ComplaintReference
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request, ComplaintReference $ComplaintReference)
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
		$ComplaintReference->update($data);

		return redirect()->route('complaint_references.index');  
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  \App\Models\ComplaintReference  $ComplaintReference
	 * @return \Illuminate\Http\Response
	 */
	public function destroy(ComplaintReference $ComplaintReference)
	{
		if (request()->get('permanent')) {
			$ComplaintReference->forceDelete();
		}else{
			$ComplaintReference->delete();
		}
		return redirect()->route('complaint_references.index')->with('alert-danger','Deleted');
	}

	public function restore($ComplaintReference)
	{
		$ComplaintReference = ComplaintReference::withTrashed()->find($ComplaintReference);
		$ComplaintReference->restore();
		return redirect()->route('complaint_references.index')->with('alert-success','Retrieved');
	}
}
