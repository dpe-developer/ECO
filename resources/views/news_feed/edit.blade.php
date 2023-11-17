@extends('adminlte.app')
@section('style')
<link rel="stylesheet" href="{{ asset('plugins/fancybox-3.5.7/jquery.fancybox.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('AdminLTE-3.2.0/plugins/dropzone/min/dropzone.min.css') }}">
    <link rel="stylesheet" href="{{ asset('AdminLTE-3.2.0/plugins/summernote/summernote-bs4.min.css') }}">
    <style>
        .dropzone-filename{
            max-width: 70% !important;
            overflow: hidden;
            white-space: nowrap;
            text-overflow: ellipsis;
        }

        .old-newsfeed-file-data .preview,
        .old-newsfeed-file-data .preview {
            max-height: 100px;
            min-height: 100px;
            max-width: 100px;
            min-width: 100px;
            overflow: hidden;
        }
        .old-newsfeed-file-data .img-fluid {
            object-fit: cover;
            width: auto;
            height: 100%;
            display: block;
        }

        .old-newsfeed-file-data .video-container {
            position: relative;
        }

        .old-newsfeed-file-data .play-overlay {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            cursor: pointer;
        }

        .old-newsfeed-file-data .play-button {
            width: 30px;
            height: 30px;
            background-color: rgba(0, 0, 0, 0.7);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            font-size: 15px;
        }
    </style>
@endsection
@section('content')
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">News Feed</h1>
                </div>
            </div>
            <!-- /.row -->
        </div>
    </div>
    <div class="content">
        <div class="container-fluid">
            <form id="newsFeedForm" action="{{ route('news_feeds.update', $newsFeed->id) }}" method="POST" autocomplete="off" enctype="multipart/form-data">
                @method('PUT')
                @csrf
                <div class="card card-outline card-primary">
                    <div class="card-header">
                        <h3 class="card-title">
                            Edit
                        </h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-xl-4">
                                <div class="form-group">
                                    <textarea id="summernote" name="content" required>{!! $newsFeed->content !!}</textarea>
                                </div>
                            </div>
                            <div class="col">
                                <div id="dropzoneContainer">
                                    <div id="actions" class="row">
                                        <div class="col-lg-6">
                                            <div class="btn-group w-100">
                                                <span class="btn btn-success col fileinput-button">
                                                    <i class="fas fa-file-plus"></i>
                                                    File
                                                </span>
                                                <button type="button" class="btn btn-primary col start">
                                                    <i class="fas fa-upload"></i>
                                                    Upload
                                                </button>
                                                <button type="button" class="btn btn-danger col cancel">
                                                    <i class="fas fa-trash"></i>
                                                    Remove All
                                                </button>
                                            </div>
                                        </div>
                                        <div class="col-lg-6 d-flex align-items-center">
                                            <div class="fileupload-process w-100">
                                                <div id="total-progress" class="progress progress-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100" aria-valuenow="0">
                                                <div class="progress-bar progress-bar-success" style="width:0%;" data-dz-uploadprogress></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="table table-striped files" id="previews">
                                        <div id="template" class="row mt-2">
                                            <div class="col-auto">
                                                <span class="preview">
                                                    <img src="data:," alt="" data-dz-thumbnail style="min-width: 100px;min-height: 100px;"/>
                                                </span>
                                                <input type="hidden" name="file_attachment_id[]" data-file-attachment-id>
                                            </div>
                                            <div class="col-4 d-flex align-items-center">
                                                <p class="mb-0">
                                                    <div class="lead dropzone-filename" data-dz-name></div>
                                                    (<span data-dz-size></span>)
                                                </p>
                                                <strong class="error text-danger" data-dz-errormessage></strong>
                                            </div>
                                            <div class="col-2 d-flex align-items-center">
                                                <div class="progress progress-striped active w-100" role="progressbar" aria-valuemin="0" aria-valuemax="100" aria-valuenow="0">
                                                    <div class="progress-bar progress-bar-success" style="width:0%;" data-dz-uploadprogress></div>
                                                </div>
                                            </div>
                                            <div class="col d-flex align-items-center">
                                                <div class="btn-group">
                                                    <button class="btn btn-sm btn-primary start" type="button">
                                                        <i class="fas fa-upload"></i>
                                                    </button>
                                                    <button data-dz-remove class="btn btn-sm btn-warning cancel" type="button">
                                                        <i class="fas fa-times"></i>
                                                    </button>
                                                    <button data-dz-remove class="btn btn-sm btn-danger delete" type="button">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <hr>
                                <div class="table table-striped files">
                                    @foreach ($newsFeed->newsFeedFiles as $newsFeedFile)
                                    <div class="row mt-2 old-newsfeed-file-data">
                                        <div class="col-auto">
                                            <div class="preview">
                                                @if(in_array($newsFeedFile->fileAttachment->file_type, ['jpg', 'png', 'jpeg', 'gif']))
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
                                            <input type="hidden" name="file_attachment_id[]" value="{{ $newsFeedFile->file_attachment_id }}">
                                        </div>
                                        <div class="col-4 d-flex align-items-center">
                                            <p class="mb-0">
                                                <div class="lead dropzone-filename">{{ $newsFeedFile->fileAttachment->file_name }}</div>
                                            </p>
                                            <strong class="error text-danger"></strong>
                                        </div>
                                        <div class="col-2 d-flex align-items-center">
                                            <div class="progress progress-striped active w-100" role="progressbar" aria-valuemin="0" aria-valuemax="100" aria-valuenow="0">
                                                <div class="progress-bar progress-bar-success" style="width:100%;"></div>
                                            </div>
                                        </div>
                                        <div class="col d-flex align-items-center">
                                            <div class="btn-group">
                                                <button class="btn btn-sm btn-danger delete-existing" type="button">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer text-right">
                        <a href="{{ route('news_feeds.index') }}" class="btn bg-gradient-secondary"><i class="fad fa-times"></i> Cancel</a>
                        <button type="submit" class="btn bg-gradient-success" id="submitNewsFeed"><i class="fad fa-save"></i> Save</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
@section('script')
<script src="{{ asset('plugins/fancybox-3.5.7/jquery.fancybox.min.js') }}"></script>
<script src="{{ asset('AdminLTE-3.2.0/plugins/dropzone/min/dropzone.min.js') }}"></script>
<script src="{{ asset('AdminLTE-3.2.0/plugins/summernote/summernote-bs4.min.js') }}"></script>
<script>
    $(function () {
        $(document).on('click', '.delete-existing', function(){
            $(this).parents('.old-newsfeed-file-data').remove()
        });

        $('[data-fancybox="gallery"]').fancybox({
            // Fancybox options go here
        });

        // Summernote
        $('#summernote').summernote({
            fontSizes: ['8', '9', '10', '11', '12', '14', '16', '18','24', '36', '48' , '64', '82', '150'],
			height: '320px',
			minHeight: null,             // set minimum height of editor
  			maxHeight: null, 
			dialogsInBody: true,
			dialogsFade: true,
			disableDragAndDrop: true,
			spellCheck: true,
			toolbar: [
				['style', ['style']],
				['font', ['bold', 'underline', 'clear']],
				['fontname', ['fontname']],
				['fontsize', ['fontsize']],
				['color', ['color']],
				['para', ['ul', 'ol', 'paragraph']],
				['table', ['table']],
				['insert', ['link', 'picture']],
				['view', ['fullscreen'/*, 'codeview', 'help'*/]],
			]
        })
    });

    $(function(){
        Dropzone.autoDiscover = false;

        // Get the template HTML and remove it from the doumenthe template HTML and remove it from the doument
        var previewNode = document.querySelector("#template")
        previewNode.id = ""
        var previewTemplate = previewNode.parentNode.innerHTML
        previewNode.parentNode.removeChild(previewNode)
        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
        var myDropzone = new Dropzone(document.querySelector('#dropzoneContainer'), {
            headers: {
                'x-csrf-token': CSRF_TOKEN,
            },
            url: baseUrl + '/file_attachment/upload-files', // Set the url
            acceptedFiles: ".jpeg,.jpg,.png,.mov,.mp4,.pdf",
            maxFilesize: 3072,
            thumbnailWidth: 80,
            thumbnailHeight: 80,
            parallelUploads: 1,
            previewTemplate: previewTemplate,
            autoQueue: true, // Make sure the files aren't queued until manually added
            previewsContainer: "#previews", // Define the container to display the previews
            clickable: ".fileinput-button", // Define the element that should be used as click trigger to select files.
            init: function () {
                this.on('addedfile', function (file) {
                    console.log('File added:', file.name);
                    // Display a thumbnail for video files
                    if (file.type.includes('video')) {
                        var reader = new FileReader();
                        reader.onload = function (e) {
                            var thumbnail = document.createElement('img');
                            thumbnail.src = e.target.result;
                            thumbnail.style.width = '100%';
                            file.previewElement.appendChild(thumbnail);
                        };
                        reader.readAsDataURL(file);
                    }
                });

                this.on('sending', function (file, xhr, formData) {
                    // Perform actions before upload
                    console.log('Before Upload:', file.name);

                    // Example: Add custom data to the formData
                    $('#submitNewsFeed').prop('disabled', true)
                });
                this.on('success', function (file, response) {
                    // Handle successful upload
                    var previewElement = file.previewElement;
                    previewElement.querySelector('input[data-file-attachment-id]').setAttribute('value', response.file_attachment_id);
                    $('#submitNewsFeed').prop('disabled', false)
                });
                this.on('error', function (file, response) {
                    // Handle upload error
                    console.error('Error uploading file:', response);
                });
                this.on('complete', function () {
                    // Check if all files have been uploaded
                    if (myDropzone.getQueuedFiles().length === 0 && myDropzone.getUploadingFiles().length === 0) {
                        $('#submitNewsFeed').prop('disabled', false)
                    }
                });
            }
        })



        myDropzone.on("addedfile", function(file) {
            // Hookup the start button
            file.previewElement.querySelector(".start").onclick = function() {
                myDropzone.enqueueFile(file)
            }
        })

        // Update the total progress bar
        myDropzone.on("totaluploadprogress", function(progress) {
            document.querySelector("#total-progress .progress-bar").style.width = progress + "%"
        })

        myDropzone.on("sending", function(file) {
            // Show the total progress bar when upload starts
            document.querySelector("#total-progress").style.opacity = "1"
            // And disable the start button
            file.previewElement.querySelector(".start").setAttribute("disabled", "disabled")
        })

        // Hide the total progress bar when nothing's uploading anymore
        myDropzone.on("queuecomplete", function(progress) {
            document.querySelector("#total-progress").style.opacity = "0"
        })

        // Setup the buttons for all transfers
        // The "add files" button doesn't need to be setup because the config
        // `clickable` has already been specified.
        document.querySelector("#actions .start").onclick = function() {
            myDropzone.enqueueFiles(myDropzone.getFilesWithStatus(Dropzone.ADDED))
        }

        document.querySelector("#actions .cancel").onclick = function() {
            myDropzone.removeAllFiles(true)
        }
    })
</script>
@endsection
