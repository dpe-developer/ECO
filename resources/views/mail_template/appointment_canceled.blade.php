<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ config('app.client_name') }}</title>
</head>
<body>
    <h3>Appointment Canceled</h3>
    <p>
        Your appointment on {{ Carbon::parse($appointment->appointment_date)->format('M d,Y h:ia') }} has been canceled.
    </p>
    <p>
        Appointment Details:
        <ul>
            <li>
                <b>Date and Time: </b>
                {{ Carbon::parse($appointment->appointment_date)->format('M d,Y h:ia') }}
            </li>
            <li>
                <b>Reference Code: </b>
                {{ Carbon::parse($appointment->created_at)->timestamp }}
            </li>
            <li>
                <b>Service: </b>
                {{ $appointment->service->name ?? "N/A" }}
            </li>
            <li>
                <b>Reason: </b> {{ $appointment->reason_of_cancel }}
            </li>
        </ul>
    </p>
</body>
</html>