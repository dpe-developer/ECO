@extends('adminlte.app')
@section('style')
    <link rel="stylesheet" href="{{ asset('AdminLTE-3.2.0/plugins/dropzone/min/dropzone.min.css') }}">
    <link rel="stylesheet" href="{{ asset('AdminLTE-3.2.0/plugins/summernote/summernote-bs4.min.css') }}">
    <style>
        .dropzone-filename{
            max-width: 70% !important;
            overflow: hidden;
            white-space: nowrap;
            text-overflow: ellipsis;
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
            <form id="newsFeedForm" action="{{ route('news_feeds.store') }}" method="POST" autocomplete="off" enctype="multipart/form-data">
                @csrf
                <div class="card card-outline card-primary">
                    <div class="card-header">
                        <h3 class="card-title">
                            Create
                        </h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-xl-4">
                                <div class="form-group">
                                    <textarea id="summernote" name="content" required></textarea>
                                </div>
                            </div>
                            <div class="col" id="dropzoneContainer">
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
<script src="{{ asset('AdminLTE-3.2.0/plugins/dropzone/min/dropzone.min.js') }}"></script>
<script src="{{ asset('AdminLTE-3.2.0/plugins/summernote/summernote-bs4.min.js') }}"></script>
<script>
    $(function () {
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
				// ['insert', ['link', 'picture']],
				['insert', ['link']],
				['view', ['fullscreen'/*, 'codeview', 'help'*/]],
			]
        })
    });

    $(function(){

        Dropzone.autoDiscover = false

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
            acceptedFiles: ".jpeg,.jpg,.png,.mov,.mp4",
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
        });



        myDropzone.on("addedfile", function(file) {
            // Hookup the start button
            file.previewElement.querySelector(".start").onclick = function() {
                myDropzone.enqueueFile(file);
            }
        });

        // Update the total progress bar
        myDropzone.on("totaluploadprogress", function(progress) {
            document.querySelector("#total-progress .progress-bar").style.width = progress + "%"
        });

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
