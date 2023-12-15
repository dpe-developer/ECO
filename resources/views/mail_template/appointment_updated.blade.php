<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ config('app.client_name') }}</title>
</head>
<body>
    <h3>Appointment Updated</h3>
    <p>
        Your appointment has been updated from <b>{{ Carbon::parse($oldAppointmentDate)->format('M d,Y h:ia') }}</b>
        to <b>{{ Carbon::parse($appointment->appointment_date)->format('M d,Y h:ia') }}</b>
    </p>
    <p>
        Appointment Details:
        <ul>
            <li>
                <b>Date and Time: </b>
                {{ Carbon::parse($appointment->appointment_date)->format('M d,Y h:ia') }}
            </li>
            <li>
                <b>Status: </b>
                {{ $appointment->status ?? "N/A" }}
            </li>
            <li>
                <b>Reference Code: </b>
                {{ Carbon::parse($appointment->created_at)->timestamp }}
            </li>
            <li>
                <b>Service: </b>
                {{ $appointment->service->name ?? "N/A" }}
            </li>
        </ul>
    </p>
    <p>
        You can check the status of your email using this link: <a href="{{ route('track-appointment', ['reference_code' => Carbon::parse($appointment->created_at)->timestamp]) }}" target="_blank">{{ route('track-appointment', ['reference_code' => Carbon::parse($appointment->created_at)->timestamp]) }}</a>
    </p>
</body>
</html>