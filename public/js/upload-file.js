$(function () {
    $('#upload-button').on('click', function () {
        var formData = new FormData($('#video-upload-form')[0]);

        $.ajax({
            url: '/upload',
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            xhr: function () {
                var xhr = new XMLHttpRequest();

                // Update progress bar
                xhr.upload.addEventListener('progress', function (event) {
                    if (event.lengthComputable) {
                        var percent = (event.loaded / event.total) * 100;
                        $('#progress-bar').val(percent);
                        $('#progress-text').text(percent.toFixed(2) + '%');
                    }
                });

                return xhr;
            },
            success: function (data) {
                // Handle success
                console.log(data);
            },
            error: function (xhr, status, error) {
                // Handle error
                console.error(xhr.responseText);
            }
        });
    });
});