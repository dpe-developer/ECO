@extends('layouts.app')

@section('content')
<div
    class="p-5 text-center bg-image"
    style="
        margin-top: -4px;
        background-image: url('{{ asset('website/banner/our-story.jpg') }}');
        height: 300px;
    "
>
    <div class="mask" style="background-color: rgba(0, 0, 0, 0.6);">
        <div class="d-flex justify-content-center align-items-center h-100">
            <div class="text-white">
                {{-- <h1 class="mb-3" style="color: #0098da; text-shadow: 1px 1px 3px #0098da">Discover the story behind our health legacy</h1> --}}
                <h1 class="mb-3">Discover the story behind our health legacy</h1>
                <h5 class="mb-3">A healthier Yesterday for a Better Tommorow.</h5>
                {{-- <a class="btn btn-outline-light btn-lg" href="#!" role="button">Call to action</a> --}}
            </div>
        </div>
    </div>
</div>
<div class="container mt-3">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <h1 class="heading">&nbsp;&nbsp;Our Story</h1>
            <p class="lead" style="text-indent: 50px">
                Dizon Vision Clinic is an eye clinic started in the year 2009 by Dr. Junn C. Dizon as a sole proprietorship.
                He trained for Sports Vision which became his foundation for optometry in 2008. From there, he became innovative and worked on visual therapy and color vision therapy.
                Dr. Dizon started the clinic as a commercial optometrist before leveling up to a professional practice.
                The clinic services include Preventive and Rehabilitative Optometry, Sports Vision Optometry, Low Vision Optometry, Vision Therapy, and Color Vision Phototherapy. 
            </p>
            <p class="lead" style="text-indent: 50px">
                Dizon Vision Clinic's Mission is to provide the best vision care services to all patients and people who are in need and shall receive treatment in all equality.
                It envisions to be a nationally  recognized eye healthcare clinic accommodating more patients ad promoting its affordable services to most people by 2035. 
            </p>
            <p class="lead" style="text-indent: 50px">
                Back in 2013, Dizon Vision Clinic was awarded as the Baguio Outstanding Citizen Award in the Field of Community Services.
            </p>
        </div>
    </div>
</div>
@endsection