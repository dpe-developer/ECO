<div class="modal fade" id="showNewsFeedModal" data-backdrop="static" data-keyboard="false" {{-- tabindex="-1" --}} role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <b>Date Posted: </b>{{ Carbon::parse($newsFeed->created_at)->format('M d,Y h:ia') }}
                    <br>
                    {{ $newsFeed->getAnnouncementDuration() }}
                </h5>
            </div>
            <div class="modal-body">
                {!! $newsFeed->content !!}
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
            <div class="modal-footer">
                <button type="button" class="btn bg-gradient-secondary" data-dismiss="modal-ajax"><i class="fa fa-times"></i> Close</button>
            </div>
        </div>
    </div>
</div>