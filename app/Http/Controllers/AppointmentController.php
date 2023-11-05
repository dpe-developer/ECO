<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\User;
use App\Models\PatientVisit;
use App\Models\UserNotification;
use App\Mail\AppointmentDeclinedMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;
use Auth;
use Carbon;

class AppointmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if(Auth::user()->role_id != 4){
            $appointments = Appointment::select('*');
            if($request->get('filter_patient')){
                $appointments->whereIn('patient_id', $request->get('filter_patient'));
            }
            if($request->get('filter_doctor')){
                $appointments->whereIn('doctor_id', $request->get('filter_doctor'));
            }
            if($request->get('filter_date_option')){
                switch ($request->get('filter_date_option')) {
                    case 'today':
                        $date = Carbon::today();
                        $appointments->whereDate('appointment_date', $date);
                        break;
                    case 'yesterday':
                        $date = Carbon::yesterday();
                        $appointments->whereDate('appointment_date', $date);
                        break;
                    case 'this week':
                        $dayOfWeek = Carbon::today()->dayOfWeek;
                        $dateFrom = Carbon::parse(today()->subDays($dayOfWeek-1));
                        $dateTo = Carbon::parse(today()->addDays(7-$dayOfWeek));
                        $appointments->whereBetween('appointment_date', [$dateFrom, $dateTo]);
                        break;
                    case 'last week':
                        $dayOfWeek = Carbon::today()->dayOfWeek;
                        $dateFrom = Carbon::parse(today()->subDays($dayOfWeek+6));
                        $dateTo = Carbon::parse(today()->subDays($dayOfWeek));
                        $appointments->whereBetween('appointment_date', [$dateFrom, $dateTo]);
                        break;
                    case 'this month':
                        $daysInMonth = Carbon::today()->daysInMonth;
                        $dateFrom = date('Y-m-').'1';
                        $dateTo = date('Y-m-').$daysInMonth;
                        $appointments->whereBetween('appointment_date', [$dateFrom, $dateTo]);
                        break;
                    case 'last month':
                        $dayNow = date('d')+0;
                        $dateTo = Carbon::parse(today()->subDays($dayNow));
                        $dateFrom = Carbon::parse(today()->subDays($dayNow+(date('d', strtotime($dateTo)-1))));
                        $appointments->whereBetween('appointment_date', [$dateFrom, $dateTo]);
                        break;
                    case 'range':
                        if(Appointment::get()->count() > 0){
                            $dateFrom = Carbon::parse(is_null($request->get('filter_appointment_date_from')) ? Appointment::orderBy('appointment_date', 'DESC')->first()->value('appointment_date') : $request->get('filter_appointment_date_from'));
                            $dateTo = Carbon::parse(is_null($request->get('filter_appointment_date_to')) ? Appointment::orderBy('appointment_date', 'DESC')->latest()->value('appointment_date') : $request->get('filter_appointment_date_to'));
                            $appointments->whereBetween('appointment_date', [$dateFrom, $dateTo]);
                        }
                        break;
                    default:
                        # code...
                        break;
                }
            }
    
            if($request->get('filter_appointment_status')){
                $appointments->whereIn('status', $request->get('filter_appointment_status'));
            }
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

    public function confirmAppointment(Request $request, Appointment $appointment)
    {
        $appointment->update([
            'status' => 'confirmed',
        ]);
        // Send Mail
        if($appointment->patient->email != ($appointment->patient->username.'@temp.com')){
            // Mail::to($appointment->patient->email)->send(new AppointmentDeclinedMail($appointment));
        }
        return back()->with('alert-success', 'Appointment Confirmed');
    }

    public function acceptPatient(Request $request, Appointment $appointment)
    {
        if(PatientVisit::where('appointment_id', $appointment->id)->doesntExist()){
            PatientVisit::create([
                'appointment_id' => $appointment->id,
                'patient_id' => $appointment->patient_id,
                'doctor_id' => $appointment->doctor_id,
                'service_id' => $appointment->service_id,
                'status' => 'active',
                'visit_date' => Carbon::now(),
                'session_start' => Carbon::now(),
            ]);
            return redirect()->route('patients.show', $appointment->patient_id)->with('alert-success', 'Patient Session Start');
        }else{
            return redirect()->route('patients.show', $appointment->patient_id)->with('alert-success', 'Patient Already Accepted');
        }
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

    public function cancelAppointment(Request $request, Appointment $appointment)
    {
        $appointment->update([
            'status' => 'canceled',
            'reason_of_cancel' => $request->get('reason')
        ]);
        // Send Mail
        if($appointment->patient->email != ($appointment->patient->username.'@temp.com')){
            // Mail::to($appointment->patient->email)->send(new AppointmentDeclinedMail($appointment));
        }
        return back()->with('alert-warning', 'Appointment canceled');
    }

    public function getAvailableAppointmentTime(Request $request)
    {
        return response()->json([
            'data' => $data
        ]);
    }
}
