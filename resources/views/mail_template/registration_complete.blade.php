<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ config('app.client_name') }}</title>
</head>
<body>
    <h3>Registration Complete</h3>
    <p>
        Hello {{ $patient->fullname('f-m-l') }}. You successfully registered on <a href="{{ config('app.url') }}" target="_blank">Dizon Vision Clinic</a>. Your can now use your Username or Email to login to our system.
    </p>
    <p>
        <b>Username/Patient ID: </b> {{ $patient->username }}
    </p>
</body>
</html>