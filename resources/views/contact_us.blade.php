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
                <h1 class="mb-3">We're here to listed and help</h1>
                <h5 class="mb-3">Your Inquiries Answered, Your Voice Heard. Connecting You to the Information You Need.</h5>
                {{-- <a class="btn btn-outline-light btn-lg" href="#!" role="button">Call to action</a> --}}
            </div>
        </div>
    </div>
</div>
<div class="container mt-3">
    <div class="row">
        <div class="col-md-6">
            <h1 class="heading">&nbsp;Contact Us</h1>
            <iframe style="width: 100%; height: 450px" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d676.5696473865363!2d120.59795817862779!3d16.41182566554818!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3391a15d4b3fffff%3A0x8ce5231caa19892c!2sPorta%20Vaga%20Mall!5e0!3m2!1sen!2sph!4v1679909383723!5m2!1sen!2sph" allowfullscreen="" loading="lazy"></iframe>
        </div>
        <div class="col-md-6">
            <h1 class="heading">&nbsp;Inquiry</h1>
            <p>Get in Touch. We're Listening</p>
            <form action="submit-contact-us" method="POST" autocomplete="off">
                @csrf
                <div class="row mb-4">
                    <div class="col-md-6">
                        <div class="form-outline">
                            <input type="text" id="inputYourName" class="form-control" required/>
                            <label class="form-label" for="inputYourName">Your Name</label>
                          </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-outline">
                            <input type="text" id="inputYourEmailAddress" class="form-control" required/>
                            <label class="form-label" for="inputYourEmailAddress">Your Email Address</label>
                        </div>
                    </div>
                </div>
                <div class="form-outline mb-4">
                    <input type="text" id="inputSubject" class="form-control" required/>
                    <label class="form-label" for="inputSubject">Subject</label>
                </div>
                <div class="form-outline mb-4">
                    <textarea class="form-control" id="textareaMessage" rows="4" required></textarea>
                    <label class="form-label" for="textareaMessage">Message</label>
                </div>
                <button type="submit" class="btn btn-primary mb-4 text-right" style="">Send</button>
            </form>
        </div>
    </div>
</div>
@endsection