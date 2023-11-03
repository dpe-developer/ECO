<?php

namespace App\Http\Controllers;

use App\Models\PatientVisit;
use App\Models\Service;
use App\Models\User;
use Illuminate\Http\Request;
use Carbon;

class PatientVisitController extends Controller
{
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
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\PatientVisit  $patientVisit
     * @return \Illuminate\Http\Response
     */
    public function destroy(PatientVisit $patientVisit)
    {
        //
    }
}
