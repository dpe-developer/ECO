@extends('layouts.app')
@section('style')
<style>
    .service-container {
        max-height: 25vh;
        min-height: 25vh;
    }

    .service-description-container {
        max-height: 10vh;
        min-height: 10vh;
        overflow: hidden;
    }
</style>
@endsection
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
                    <div class="card-body service-container">
                        <h5 class="card-title">{{ $service->name }}</h5>
                        <p class="card-text service-description-container mb-2">
                            {{ $service->description }}
                        </p>
                        <a class="show-more d-none mt-0" href="#" data-mdb-toggle="modal" data-mdb-target="#modalService-{{ $service->id }}">
                            ... show more
                        </a>
                    </div>
                </div>
                <div class="modal fade" id="modalService-{{ $service->id }}" tabindex="-1" aria-labelledby="modalService-{{ $service->id }}" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">{{ $service->name }}</h5>
                                <button type="button" class="btn-close" data-mdb-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                {{ $service->description }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection
@section('scripts')
<script>
    $(function(){
        $('.service-description-container').each(function(){
            if(this.offsetHeight < this.scrollHeight){
                $(this).parents('.card-body').find('.show-more').removeClass('d-none')
            }else{
                $(this).parents('.card-body').find('.show-more').addClass('d-none')
            }
        });
    })
</script>
@endsection