<?php

namespace App\Http\Controllers;

use App\Models\Appointment; 
use App\Models\User; 
use App\Models\Service; 
use Illuminate\Http\Request;
use Auth;
use Carbon;

class PatientAppointmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $appointments = Appointment::where('patient_id', Auth::user()->id)->get();
        $data = [
            'appointments' => $appointments
        ];
        return view('patient_appointments.index', $data);
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
            'appointmentDate' => Carbon::parse($request->get('appointment_date'))->format('Y-m-d'),
        ];
        return response()->json([
            'modal_content' => view('patient_appointments.create', $data)->render()
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
        $appointmentDate = Carbon::parse($request->get('appointment_date').' '.$request->get('appointment_time'));
        Appointment::create([
            'patient_id' => Auth::user()->id,
            'doctor_id' => $request->get('doctor'),
            'service_id' => $request->get('service'),
            'appointment_date' => $appointmentDate,
            'description' => $request->get('description'),
        ]);
        return back()->with('alert-success', 'Appointment successfully created');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Appointment  $appointment
     * @return \Illuminate\Http\Response
     */
    public function show(Appointment $appointment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Appointment  $appointment
     * @return \Illuminate\Http\Response
     */
    public function edit(Appointment $appointment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Appointment  $appointment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Appointment $appointment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Appointment  $appointment
     * @return \Illuminate\Http\Response
     */
    public function destroy(Appointment $appointment)
    {
        //
    }
}