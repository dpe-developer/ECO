@extends('layouts.app')

@section('content')

<div class="container my-5">
    <div class="alert alert-success text-center my-5">
        <h1 class="text-center">Registration Complete</h1>
        <h3 class="text-center">Here is your Username: <b>{{ $patient->username }}</b></h3>
        <p>Please take note of your username. You can also check your SMS/Email to view your login credentials.</p>
        <p>Click <a href="{{ route('my-profile', Auth::user()->username) }}">here</a> to view your profile</p>
    </div>
    <div class="alert alert-warning text-center my-5">
        <h3>You can now set your appointment. Click <a href="{{ route('patient_appointments.index') }}">here</a> to set an appointment.</h3>
    </div>
</div>
@endsection