<?php

namespace App\Http\Controllers;

use App\Models\Appointment; 
use App\Models\User; 
use App\Models\Service; 
use App\Models\Setting; 
use App\Mail\AppointmentConfirmationMail;
use App\Mail\AppointmentConfirmedMail;
use App\Mail\AppointmentDeclinedMail;
use App\Mail\AppointmentCancelledMail;
use App\Mail\AppointmentUpdateMail;
use Illuminate\Support\Facades\Mail;
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
        $appointments = Appointment::where('patient_id', Auth::user()->id)->orderBy('appointment_date', 'DESC')->get();
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
        $appointmentDate = Carbon::parse($request->get('appointment_date'))->format('Y-m-d');
        $timeTaken = [];
        foreach(Appointment::whereDate('appointment_date', $appointmentDate)->whereIn('status', ['confirmed'])->get() as $appointment){
            $timeTaken[] = Carbon::parse($appointment->appointment_date)->format('H:i');
        }
        $data = [
            'doctors' => User::where('role_id', 3)->get(),
            'services' => Service::get(),
            'appointmentDate' => $appointmentDate,
            'timeTaken' => $timeTaken,
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
        $appointment = Appointment::create([
            'patient_id' => Auth::user()->id,
            'doctor_id' => $request->get('doctor'),
            'service_id' => $request->get('service'),
            'appointment_date' => $appointmentDate,
            'description' => $request->get('description'),
        ]);
        // Send Mail
        if(Setting::system('send_email_notification')){
            if($appointment->patient->email != ($appointment->patient->username.'@temp.com')){
                try{
                    Mail::to($appointment->patient->email)->send(new AppointmentConfirmationMail($appointment));
                }catch(\Exception $e){
                    report($e);
                    return back()->with('alert-success', 'Appointment successfully created');
                }
            }
        }
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
        if(Auth::user()->id != $appointment->patient_id){
            return abort(404);
        }
        $data = ([
			'appointment' => $appointment,
		]);
        
		return response()->json([
			'modal_content' => view('patient_appointments.show', $data)->render()
		]);
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

    public function cancelAppointment(Request $request, Appointment $appointment)
    {
        $appointment->update([
            'status' => 'canceled',
            'reason_of_cancel' => $request->get('reason')
        ]);
        // Send Mail
        if(Setting::system('send_email_notification')){
            if($appointment->patient->email != ($appointment->patient->username.'@temp.com')){
                try{
                    Mail::to($appointment->patient->email)->send(new AppointmentCancelledMail($appointment));
                }catch(\Exception $e){
                    report($e);
                    return back()->with('alert-warning', 'Appointment canceled');
                }
            }
        }
        return back()->with('alert-warning', 'Appointment canceled');
    }
}
