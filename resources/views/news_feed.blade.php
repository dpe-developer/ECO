@extends('layouts.app')

@section('style')
<link rel="stylesheet" href="{{ asset('plugins/fancybox-3.5.7/jquery.fancybox.min.css') }}" />
<style>
    .row.grid > .grid-item{
        padding: 3px !important;
        cursor: pointer;
    }

    .grid > .grid-item .img-fluid{
        width: 100%;
        max-height: 200px !important;
        /* min-height: 150px !important; */
    }

    .play-overlay {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        cursor: pointer;
    }

    .play-button {
        width: 40px;
        height: 40px;
        background-color: rgba(0, 0, 0, 0.7);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #fff;
        font-size: 20px;
    }
</style>
@endsection

@section('content')
{{-- <div
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
                <h1 class="mb-3">Newsfeed</h1>
            </div>
        </div>
    </div>
</div> --}}
<div class="container mt-5 mb-5">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <h1 class="heading mb-5">&nbsp;&nbsp;Newsfeed</h1>
        </div>
    </div>
    <div class="row justify-content-center">
        @forelse ($newsFeeds as $newsFeed)
            <div class="col-md-6 mb-4">
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-md-6">
                                <b>Date Posted: </b>{{ Carbon::parse($newsFeed->created_at)->format('M d,Y h:ia') }}
                                <br>
                                {{ $newsFeed->getAnnouncementDuration() }}
                            </div>
                            <div class="col-md-6">
                                <a class="btn btn-primary float-end" class="show-more d-none" href="{{ url('news-feed/view', $newsFeed->id) }}">
                                    View
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body post-card-body">
                        <div class="post-container mb-3">
                            {!! $newsFeed->content !!}
                        </div>
                        <a class="show-more d-none" href="{{ url('news-feed/view', $newsFeed->id) }}">
                            ... show more
                        </a>
                    </div>
                    <div class="card-footer post-files-container">
                        <div class="row grid">
                            @foreach ($newsFeed->newsFeedFiles as $newsFeedFile)
                            <div class="col-md-3 grid-item">
                                @if(in_array($newsFeedFile->fileAttachment->file_type, ['jpg', 'png', 'jpeg']))
                                    <a href="{{ asset('storage/'.$newsFeedFile->fileAttachment->getFile()) }}" data-fancybox="gallery" data-caption="">
                                        <img class="img-fluid" data-toggle="view-file-attachment" data-href="{{ route('file_attachments.show', $newsFeedFile->fileAttachment->id) }}" src="{{ asset('storage/'.$newsFeedFile->fileAttachment->getFile()) }}" alt="">
                                    </a>
                                @elseif(in_array($newsFeedFile->fileAttachment->file_type, ['mp4', 'mov']))
                                    <div class="video-container">
                                        <a href="{{ asset('storage/'.$newsFeedFile->fileAttachment->getFile()) }}" data-fancybox="gallery" data-caption="" poster="{{ asset('storage/'.$newsFeedFile->fileAttachment->getFile()) }}">
                                            <div class="play-overlay">
                                                <div class="play-button">&#9654;</div>
                                            </div>
                                            <video muted {{-- autoplay loop --}} class="img-fluid" data-toggle="view-file-attachment" data-href="{{ route('file_attachments.show', $newsFeedFile->fileAttachment->id) }}">
                                                <source src="{{ asset('storage/'.$newsFeedFile->fileAttachment->getFile()) }}" type="video/mp4">
                                                Your browser does not support the video tag.
                                            </video>
                                        </a>
                                    </div>
                                @endif
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        @empty
        <div class="col-md-10">
            <div class="alert alert-warning text-center m-5 p-5">
                <h1>No post yet</h1>
            </div>
        </div>
        @endforelse
    </div>
</div>
@endsection

@section('scripts')
<script src="{{ asset('plugins/fancybox-3.5.7/jquery.fancybox.min.js') }}"></script>
<script type="application/javascript" src="{{ asset('plugins/masonry.pkgd.min.js') }}"></script>
<script>
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
        $('.post-container').each(function(){
            if(this.offsetHeight < this.scrollHeight){
                $(this).parent().find('.show-more').removeClass('d-none')
            }
        })
    })
</script>
@endsection