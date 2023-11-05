<?php

namespace App\Http\Controllers;

use App\Models\PatientVisit;
use App\Models\Service;
use App\Models\User;
use Illuminate\Http\Request;
use Carbon;

class PatientVisitController extends Controller
{
    public function __construct()
	{
		$this->middleware('auth');
		$this->middleware('permission:patient_visits.index', ['only' => ['index']]);
		$this->middleware('permission:patient_visits.create', ['only' => ['create','store']]);
		$this->middleware('permission:patient_visits.show', ['only' => ['show']]);
		$this->middleware('permission:patient_visits.edit', ['only' => ['edit','update']]);
		$this->middleware('permission:patient_visits.destroy', ['only' => ['destroy']]);
		$this->middleware('permission:patient_visits.restore', ['only' => ['restore']]);
		$this->middleware('permission:patient_visits.end_visit', ['only' => ['endVisit']]);
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
            'doctors' => User::where('role_id', 3)->get(),
            'services' => Service::get(),
            'patient' => User::find($request->get('patient_id'))
        ];
        return response()->json([
            'modal_content' => view('patients.patient_profile.patient_visits.create', $data)->render()
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
        PatientVisit::create([
            'appointment_id' => $request->get('appointment_id'),
            'patient_id' => $request->get('patient'),
            'doctor_id' => $request->get('doctor'),
            'service_id' => $request->get('service'),
            'complaints' => $request->get('complaints'),
            'findings' => $request->get('findings'),
            'recommendation' => $request->get('recommendation'),
            'status' => 'active',
            'visit_date' => Carbon::now(),
            'session_start' => Carbon::now(),
        ]);
        return redirect()->route('patients.show', $request->get('patient'))->with('alert-success', 'Patient Visit added successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\PatientVisit  $patientVisit
     * @return \Illuminate\Http\Response
     */
    public function show(PatientVisit $patientVisit)
    {
        $data = [
            'patientVisit' => $patientVisit,
            'patient' => $patientVisit->patient
        ];
        return view('patients.patient_profile.patient_visits.show', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\PatientVisit  $patientVisit
     * @return \Illuminate\Http\Response
     */
    public function edit(PatientVisit $patientVisit)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\PatientVisit  $patientVisit
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, PatientVisit $patientVisit)
    {
        $patientVisit->update([
            'service_id' => $request->get('service'),
            'complaints' => $request->get('complaints'),
            'findings' => $request->get('findings'),
            'recommendations' => $request->get('recommendations'),
            'session_start' => Carbon::now(),
        ]);
        return redirect()->route('patients.show', $patientVisit->patient_id)->with('alert-success', 'Saved');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\PatientVisit  $patientVisit
     * @return \Illuminate\Http\Response
     */
    public function destroy(PatientVisit $patientVisit)
    {
        $patientVisit->delete();
        return back()->with('alert-warning', 'Patient Visit Successfully DELETED');
    }

    public function endVisit(Request $request, PatientVisit $patientVisit)
    {
        $patientVisit->update([
            'status' => 'done',
            'session_end' => Carbon::now(),
        ]);
        if($patientVisit->appointment_id != null){
            $patientVisit->appointment->update([
                'status' => 'done'
            ]);
        }
        return redirect()->route('patients.show', $patientVisit->patient_id)->with('alert-success', 'SESSION END');
    }
}
