<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\User;
use App\Models\UserNotification;
use App\Mail\AppointmentDeclinedMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;
use Auth;

class AppointmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(Auth::user()->role_id != 3){
            $appointments = Appointment::select('*');
            $doctors = User::where('role_id', 3)->get();
            $patients = User::where('role_id', 4)->get();
            $data = [
                'appointments' => $appointments->orderBy('created_at', 'DESC')->get(),
                'patients' => $patients,
                'doctors' => $doctors,
            ];
            return view('appointments.index', $data);
        }else{
            $appointments = Appointment::where('patient_id', Auth::user()->id)->get();
            $data = [
                'appointments' => $appointments
            ];
            return view('patient_appointments.index', $data);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Appointment  $appointment
     * @return \Illuminate\Http\Response
     */
    public function show(Appointment $appointment)
    {
        UserNotification::create([
            'user_id' => Auth::user()->id,
            'entity_id' => $appointment->id,
            'notification_type' => 'appointment',
            'is_seen' => true,
        ]);
        $data = ([
			'appointment' => $appointment,
		]);
		/* if(!Auth::user()->hasrole('System Administrator')){
			$data = ([
				'appointment' => $appointment,
			]);
		} */

		return response()->json([
			'modal_content' => view('appointments.show', $data)->render()
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
    
    public function declineAppointment(Request $request, Appointment $appointment)
    {
        $reason = $request->get('reason_of_decline');
        if($request->get('reason_of_decline') == 'other'){
            $reason = $request->get('other_reason');
        }
        $appointment->update([
            'status' => 'declined',
            'reason_of_decline' => $reason
        ]);
        // Send Mail
        if($appointment->patient->email != ($appointment->patient->username.'@temp.com')){
            // Mail::to($appointment->patient->email)->send(new AppointmentDeclinedMail($appointment));
        }
        return back()->with('alert-warning', 'Appointment declined');
    }

    public function getAvailableAppointmentTime(Request $request)
    {
        return response()->json([
            'data' => $data
        ]);
    }
}
