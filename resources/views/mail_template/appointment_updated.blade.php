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
</body>
</html>