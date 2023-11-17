@extends('layouts.app')

@section('style')
<link rel="stylesheet" href="{{ asset('plugins/fancybox-3.5.7/jquery.fancybox.min.css') }}" />
<style>
    .row.grid > .grid-item{
        padding: 3px !important;
        margin: 0px !important;
    }
    
    .grid > .grid-item .img-fluid{
        width: 100%;
    }
    .grid > .grid-item a{
        min-height: 150px !important;
    }

    .play-overlay {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
    }

    .play-button {
        width: 50px;
        height: 50px;
        background-color: rgba(0, 0, 0, 0.7);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #fff;
        font-size: 24px;
    }
</style>
@endsection

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-10">
            {{-- <h1 class="heading">&nbsp;&nbsp;{{ $newsFeed->title }}</h1>
            {!! $newsFeed->content !!} --}}
            <div class="card mb-5">
                <div class="card-header">
                    <div class="row">
                        <div class="col-md-6">
                            <b>Date Posted: </b>{{ Carbon::parse($newsFeed->created_at)->format('M d,Y h:ia') }}
                            <br>
                            {{ $newsFeed->getAnnouncementDuration() }}
                        </div>
                        <div class="col-md-6">
                            <a class="btn btn-primary float-end" class="show-more d-none" href="{{ url('news-feed') }}">
                                Back
                            </a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    {!! $newsFeed->content !!}
                </div>
                <div class="card-footer">
                    <div class="row grid">
                        @foreach ($newsFeed->newsFeedFiles as $newsFeedFile)
                        <div class="col-md-3 grid-item">
                            @if(in_array($newsFeedFile->fileAttachment->file_type, ['jpg', 'png', 'jpeg']))
                                <a href="{{ asset('storage/'.$newsFeedFile->fileAttachment->getFile()) }}" data-fancybox="gallery" data-caption="">
                                    <img class="img-fluid" data-toggle="view-file-attachment" data-href="{{ route('file_attachments.show', $newsFeedFile->fileAttachment->id) }}" src="{{ asset('storage/'.$newsFeedFile->fileAttachment->getFile()) }}" alt="">
                                </a>
                            @elseif(in_array($newsFeedFile->fileAttachment->file_type, ['mp4', 'mov']))
                                <a href="{{ asset('storage/'.$newsFeedFile->fileAttachment->getFile()) }}" data-fancybox="gallery" data-caption="">
                                    <div class="play-overlay">
                                        <div class="play-button">&#9654;</div>
                                    </div>
                                    <video muted {{-- autoplay loop --}} class="img-fluid" data-toggle="view-file-attachment" data-href="{{ route('file_attachments.show', $newsFeedFile->fileAttachment->id) }}">
                                        <source src="{{ asset('storage/'.$newsFeedFile->fileAttachment->getFile()) }}" type="video/mp4">
                                        Your browser does not support the video tag.
                                    </video>
                                </a>
                            @endif
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="{{ asset('plugins/fancybox-3.5.7/jquery.fancybox.min.js') }}"></script>
<script type="application/javascript" src="{{ asset('plugins/masonry.pkgd.min.js') }}"></script>
<script type="application/javascript">
    $(function(){

        $(window).on('load', function(){
            $('.grid').masonry({
                itemSelector: '.grid-item',
                // columnWidth: 400,
                // gutter: 20,
            });
        })

        $('[data-fancybox="gallery"]').fancybox({
            // Fancybox options go here
        });
    })
</script>
@endsection