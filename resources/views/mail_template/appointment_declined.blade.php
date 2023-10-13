<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ config('app.client_name') }}</title>
</head>
<body>
    <h3>Appointment Declined</h3>
    <p>
        Your appointment on {{ Carbon::parse($appointment->appointment_date)->format('M d,Y h:ia') }} has been declined.
    </p>
    <p>
        <b>Reason: </b> {{ $appointment->reason_of_decline }}
    </p>
</body>
</html>