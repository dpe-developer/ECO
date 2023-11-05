@extends('layouts.app')

@section('content')
<div
    class="p-5 text-center bg-image"
    style="
        margin-top: -4px;
        background-image: url('{{ asset('website/banner/our-story.jpg') }}');
        height: 280px;
    "
>
    <div class="mask" style="background-color: rgba(0, 0, 0, 0.6);">
        <div class="d-flex justify-content-center align-items-center h-100">
            <div class="text-white">
                <h1 class="mb-3">Services Offered</h1>
                <h5 class="mb-3">Dedicated to delivering exeptional service.</h5>
                {{-- <a class="btn btn-outline-light btn-lg" href="#!" role="button">Call to action</a> --}}
            </div>
        </div>
    </div>
</div>
<div class="container mt-5 mb-5">
    <h1 class="heading">&nbsp;&nbsp;Services</h1>
    <div class="row">
        @foreach ($services as $service)
            <div class="col-md-4">
                <div class="card mb-3">
                    {{-- <div class="card-header">
                        <h5 class="card-title">{{ $announcement->title }}</h5>
                    </div> --}}
                    <div class="card-body">
                        <h5 class="card-title">{{ $service->name }}</h5>
                        <p class="card-text">{{ $service->description }}</p>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection