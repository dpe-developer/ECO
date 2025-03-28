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
        Hello {{ $patient->fullname() }}. You successfully registered on <a href="{{ config('app.url') }}" target="_blank">Dizon Vision Clinic</a>. Your can now use your Username/Email to login in our website.
    </p>
    <p>
        <b>Username: </b> {{ $patient->username }}
    </p>
    <p>
        <strong><i>To protect you account, please do not share your login credentials.</i></strong>
    </p>
</body>
</html>