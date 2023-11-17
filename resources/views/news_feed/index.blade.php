@extends('adminlte.app')
@section('style')
<link rel="stylesheet" href="{{ asset('plugins/fancybox-3.5.7/jquery.fancybox.min.css') }}" />
    <style>
        .grid > .grid-item{
            padding: 3px !important;
            margin: 0px !important;
            cursor: pointer;
        }
        .grid > .grid-item .img-fluid{
            width: 100%;
        }

        .grid > .grid-item a{
            max-height: 200px !important;
        }

        .play-overlay {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            cursor: pointer;
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

        .post-container {
            max-height: 50vh;
            min-height: 50vh;
            overflow-y: scroll;
        }
    </style>
@endsection
@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">News Feed</h1>
                </div>
                <div class="col-sm-6 text-right">
                    @can('news_feeds.create')
                        <a class="btn bg-gradient-primary" href="{{ route('news_feeds.create') }}"><i class="fa fa-plus"></i> Add</a>
                    @endcan
                </div>
            </div>
        </div>
    </div>
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                @forelse ($newsFeeds as $newsFeed)
                <div class="col-md-6">
                    <div class="card card-primary card-outline">
                        <div class="card-header">
                            <h4 class="card-title">
                                {{ Carbon::parse($newsFeed->created_at)->format('M-d-Y h:ia') }}
                            </h4>
                            <div class="card-tools">
                                @can('news_feeds.destroy')
                                    <a class="btn btn-tool bg-gradient-danger" href="javascript:void(0)" onclick="deleteFromTable(this)" data-href="{{ route('news_feeds.destroy', $newsFeed->id) }}"><i class="fad fa-trash-alt"></i></a>
                                @endcan
                                @can('news_feeds.edit')
                                    <a class="btn btn-tool bg-gradient-info" href="{{ route('news_feeds.edit', $newsFeed->id) }}"><i class="fad fa-edit"></i></a>
                                @endcan
                                @can('news_feeds.show')
                                    <a class="btn btn-tool bg-gradient-primary" href="{{ route('news_feeds.show', $newsFeed->id) }}"><i class="fad fa-eye"></i></a>
                                @endcan
                            </div>
                        </div>
                        <div class="card-body post-container">
                            {!! $newsFeed->content !!}
                            <div class="row grid">
                                @foreach ($newsFeed->newsFeedFiles as $newsFeedFile)
                                <div class="col-sm-4 grid-item">
                                    @if(in_array($newsFeedFile->fileAttachment->file_type, ['jpg', 'png', 'jpeg']))
                                        <a href="{{ asset('storage/'.$newsFeedFile->fileAttachment->getFile()) }}" data-fancybox="gallery" data-caption="">
                                            <img class="img-fluid" data-toggle="view-file-attachment" data-href="{{ route('file_attachments.show', $newsFeedFile->fileAttachment->id) }}" src="{{ asset('storage/'.$newsFeedFile->fileAttachment->getFile()) }}" alt="">
                                        </a>
                                    @elseif(in_array($newsFeedFile->fileAttachment->file_type, ['mp4', 'mov']))
                                        <a href="{{ asset('storage/'.$newsFeedFile->fileAttachment->getFile()) }}" data-fancybox="gallery" data-caption="" poster="{{ asset('storage/'.$newsFeedFile->fileAttachment->getFile()) }}">
                                            <video muted {{-- autoplay loop --}} class="img-fluid" data-toggle="view-file-attachment" data-href="{{ route('file_attachments.show', $newsFeedFile->fileAttachment->id) }}">
                                                <source src="{{ asset('storage/'.$newsFeedFile->fileAttachment->getFile()) }}" type="video/mp4">
                                                Your browser does not support the video tag.
                                            </video>
                                            <div class="play-overlay">
                                                <div class="play-button">&#9654;</div>
                                            </div>
                                        </a>
                                    @endif
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
                @empty
                <div class="col">
                    <div class="alert alert-warning text-center">
                        *** EMPTY ***
                    </div>
                </div>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection
@section('script')
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