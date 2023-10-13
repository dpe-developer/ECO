@extends('layouts.app')

@section('content')
<div
    class="p-5 text-center bg-image"
    style="
        margin-top: -5px;
        background-image: url('{{ asset('website/banner/our-story.jpg') }}');
        height: 350px;
    "
>
    <div class="mask" style="background-color: rgba(0, 0, 0, 0.6);">
        <div class="d-flex justify-content-center align-items-center h-100">
            <div class="text-white">
                <h1 class="mb-3">Stay track with your Health Appointments</h1>
                <h5 class="mb-3">Never miss a beat with our Appointment Tracker.</h5>
                {{-- <a class="btn btn-outline-light btn-lg" href="#!" role="button">Call to action</a> --}}
            </div>
        </div>
    </div>
</div>
<div class="container mt-3">
    <div class="row">
        <div class="col-md-6">
            <h1 class="heading">&nbsp;My Appointment</h1>
            <p class="lead">Check the status of your Appointment now!</p>
            <form action="appointment-status" method="POST">
                @csrf
                <div class="form-outline mb-4">
                    <input type="text" id="inputRefferenceCode" class="form-control form-control-lg" required />
                    <label class="form-label" for="inputRefferenceCode">Refference Code</label>
                </div>
                <button type="submit" class="btn btn-primary me-auto mb-4 text-right" style="">Track Appointment</button>
            </form>
        </div>
        <div class="col-md-6">
            <h1 class="heading">&nbsp;Contact Us</h1>
            <p class="lead">
                If you have any concerns you may contact us
            </p>
            <p>
                <a href="https://www.facebook.com/dizonopticalvisiontherapyclinic" target="_blank">
                    <i class="fa-brands fa-facebook fa-lg me-3 text-secondary"></i> Dizon Vision Clinic</p>
                </a>
            <p>
                <i class="fas fa-envelope fa-lg me-3 text-secondary"></i>
                drjunncdizon@yahoo.com
            </p>
            <p><i class="fas fa-phone fa-lg me-3 text-secondary"></i> (+63) 917 6721 925</p>
            <iframe style="width: 100%; height: 450px" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d676.5696473865363!2d120.59795817862779!3d16.41182566554818!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3391a15d4b3fffff%3A0x8ce5231caa19892c!2sPorta%20Vaga%20Mall!5e0!3m2!1sen!2sph!4v1679909383723!5m2!1sen!2sph" allowfullscreen="" loading="lazy"></iframe>
        </div>
    </div>
</div>
@endsection