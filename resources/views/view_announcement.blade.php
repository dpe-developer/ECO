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
                <h1 class="mb-3">Discover the latest updates and news</h1>
                <h5 class="mb-3">Stay informed, stay ahead.</h5>
                {{-- <a class="btn btn-outline-light btn-lg" href="#!" role="button">Call to action</a> --}}
            </div>
        </div>
    </div>
</div>
<div class="container mt-5">
    <div class="row">
        <div class="col-md-12">
            {{-- <h1 class="heading">&nbsp;&nbsp;{{ $announcement->title }}</h1>
            {!! $announcement->content !!} --}}
            <div class="card mb-5">
                <div class="card-header">
                    <h5 class="card-title">{{ $announcement->title }}</h5>
                    <h6 class="card-subtitle mb-2 text-muted">Date Published: {{ Carbon::parse($announcement->created_at)->format('M d,Y') }}</h6>
                </div>
                <div class="card-body">
                    {!! $announcement->content !!}
                </div>
                <div class="card-footer">
                    <div class="row">
                        <div class="col">
                            {{ $announcement->getAnnouncementDuration() }}
                        </div>
                        <div class="col">
                            <a class="btn btn-primary float-end" class="show-more d-none" href="{{ url('clinic-announcements') }}">
                                Back
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection