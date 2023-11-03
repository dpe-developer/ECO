{{-- My Scripts --}}
<script src="{{ asset('plugins/js/bootstrap-datepicker.js') }}"></script>
<script src="{{ asset('plugins/select2/js/select2.full.min.js') }}"></script>
<script src="{{ asset('plugins/sweetalert2/sweetalert2.all.min.js') }}"></script>
{{-- Disable Submit Button --}}
<script type="application/javascript">
    $(function() {
        /*$(document).on('click', '.btn-submit-out', function() {
            $(this).prop('disabled', true).append(' <i class="fa fa-spinner fa-pulse"></i>');
            $($(this).data('submit')).submit();
        });*/

        $(document).on('submit', 'form', function(){
            $(this).find('button[type=submit]').prop('disabled', true).append(' <i class="fa fa-spinner fa-spin fa-pulse"></i>')
        })
    });
</script>
<script>
    $('#datepicker').datepicker({
        iconsLibrary: 'fontawesome',
        icons: {
         rightIcon: '<span class="fa fa-caret-down"></span>'
     }
    });
    $('#datepicker2').datepicker({
        iconsLibrary: 'fontawesome',
        icons: {
        rightIcon: '<span class="fa fa-caret-down"></span>'
     }

    });
</script>
<script>
    $(function() {
        // for select2 inside the modal
        $.fn.modal.Constructor.prototype._enforceFocus = function() {};
        
        $.fn.select2.defaults.set('theme', 'bootstrap4');
        $.fn.select2.defaults.set('placeholder', 'Select');

        $('.select2').select2({
            theme: "bootstrap4",
            placeholder: "Select",
        });
        
        $('.select2-allow-clear').select2({
            theme: "bootstrap4",
            placeholder: "Select",
            allowClear: true
        });

        $('.select2-no-search').select2({
            theme: "bootstrap4",
            placeholder: "Select",
            allowClear: true,
            minimumResultsForSearch: Infinity
        });

        $('.select2-tag').select2({
            theme: "bootstrap4",
            placeholder: "Select",
            allowClear: true,
            tags: true,
        });
        
    });
</script>
<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    
    // $(function(){
        $(".tr-link").click(function() {
            window.location = $(this).data("href");
        });
        $(document).on('click', 'tr[data-toggle="tr-link"]', function(){
            window.location = $(this).data("href");
        })
        
        // Permission Denied
        function ajax_error(xhr, ajaxOptions, thrownError){
            // console.log(xhr.responseJSON)
            if(xhr.responseJSON.exception == "Spatie\\Permission\\Exceptions\\UnauthorizedException"){
                ajax_permission_denied();
            }else{
                $('#ajaxOptions').html(ajaxOptions);
                $('#thrownError').html(thrownError);
                $('#xhr').html(xhr.responseJSON.message);
                $('#modalAjaxError').modal('show');
            }
            /*Swal.fire({
                // position: 'top-end',
                type: 'error',
                title: ajaxOptions+":\n"+thrownError+".\n"+xhr.responseJSON.message,
                // showConfirmButton: false,
                // timer: 3000,
                // toast: true
            })*/
        }

        function ajax_permission_denied(){
            Swal.fire({
                // position: 'top-end',
                type: 'error',
                title: "Access Denied",
                text: "User does not have the right permissions.",
                // showConfirmButton: false,
                // timer: 3000,
                // toast: true
            })
        }

        function removeLocationHash(){
            var noHashURL = window.location.href.replace(/#.*$/, '');
            window.history.replaceState('', document.title, noHashURL)
        }

        // Modal Ajax
        $(document).on('click', '[data-toggle="modal-ajax"]', function(){
            $('#loader').show();
            var href = $(this).data('href');
            var target = $(this).data('target');
            var data = {};
            if($(this).data('form') != null){
                var form = $(this).data('form').split(';');
                for (var i = 0; i < form.length; i++) {
                    var form_data = form[i].split(':');
                    for(var j = 1; j < form_data.length; j++){
                        data[form_data[j-1]] = form_data[j];
                    }
                }
            }
            $.ajax({
                type: 'GET',
                url: href,
                data: data,
                success: function(data){
                    $('.modal-backdrop').remove()
                    $('#modalAjax').html(data.modal_content)
                    $('.select2').select2({
                        theme: "bootstrap4",
                        placeholder: "Select",
                        allowClear: true
                    });
                    // $('.datetimepicker').datetimepicker();
                    $('#oldInput').find('input').each(function(){
                        var name = $(this).attr('name').replace('old_', '');
                        if(name != '_token'){
                            var value = $(this).val();
                            $('#modalAjax [name="'+name+'"]').parent('.form-group').find('.invalid-feedback').html('<strong class="text-danger">'+$(this).data('error-message')+'</strong>')
                            $('#modalAjax').find('input[type="text"][name="'+name+'"]').val(value).addClass($(this).data('error'));
                            $('#modalAjax').find('input[type="checkbox"][name="'+name+'"][value="'+value+'"]').prop('checked', true);
                            $('#modalAjax').find('input[type="radio"][name="'+name+'"][value="'+value+'"]').prop('checked', true);
                            $('#modalAjax').find('select[name="'+name+'"]').val(value).trigger('change').addClass($(this).data('error'));
                        }
                    })
                    
                    $(target).modal('show')
                    $('#loader').hide();
                },
                error: function(xhr, ajaxOptions, thrownError){
                    ajax_error(xhr, ajaxOptions, thrownError)
                    // removeLocationHash()
                    $('#loader').hide();
                }
            })
        })

        $(document).on('click', '[data-dismiss="modal-ajax"]', function() {
            // closeAllModals()
            $('.modal').modal('hide')
            $('.modal-backdrop').fadeOut(250, function() {
                $('.modal-backdrop').remove()
            })
            $('body').removeClass('modal-open').css('padding-right', '0px');
            $('#oldInput').html('');
            $('#modalAjax').html('')
            removeLocationHash()
        })

        // form validation info
        // $('#formValidationError').modal('show')
    // })
</script>

 {{--  Action Alert --}}
<script type="application/javascript">
    @if($message = Session::get('alert-success'))
        Swal.fire({
            // position: 'top-end',
            type: 'success',
            title: '{{ $message }}',
            showConfirmButton: false,
            timer: 2000,
            toast: true
        })
    @elseif($message = Session::get('alert-warning'))
        Swal.fire({
            // position: 'top-end',
            type: 'warning',
            title: '{{ $message }}',
            showConfirmButton: false,
            timer: 2000,
            toast: true
        })
    @elseif($message = Session::get('alert-danger'))
        Swal.fire({
            // position: 'top-end',
            type: 'success',
            title: '{{ $message }}',
            showConfirmButton: false,
            timer: 2000,
            toast: true
        })
    @endif

    // Close action alert
    $(document).ready(function() {
        // show the alert
        setTimeout(function() {
            $(".action-alert").alert('close');
        }, 2000);
    });

    function ajaxActionAlert(type, message) {
        switch (type) {
            case 'success':
                Swal.fire({
                    // position: 'top-end',
                    type: 'success',
                    title: message,
                    showConfirmButton: false,
                    timer: 2000,
                    toast: true
                })
                break;
            case 'warning':
                Swal.fire({
                    // position: 'top-end',
                    type: 'warning',
                    title: message,
                    showConfirmButton: false,
                    timer: 2000,
                    toast: true
                })
                break;
            case 'danger':
                Swal.fire({
                    // position: 'top-end',
                    type: 'danger',
                    title: message,
                    showConfirmButton: false,
                    timer: 2000,
                    toast: true
                })
                break;
            default:
                break;
        }

    }

    function reloadStylesheets()
    {
        // Reload stylesheets
        $(".reloadable[rel='stylesheet']").each(function() {
            // Get the current href attribute
            let currentHref = $(this).attr('href');
            
            // Create a new href with a timestamp or random query parameter to force a reload
            let newHref = currentHref + "?v=" + new Date().getTime();
            console.log(newHref)
            // Set the new href attribute to trigger a reload
            $(this).attr('href', newHref);
        });
    }

    function reloadScripts()
    {
        // Reload stylesheets
        $("script.reloadable").each(function() {
            // Get the current href attribute
            let currentSrc = $(this).attr('src');
            
            // Create a new Src with a timestamp or random query parameter to force a reload
            let newSrc = currentSrc + "?v=" + new Date().getTime();
            console.log(newSrc)
            // Set the new Src attribute to trigger a reload
            $(this).attr('src', newSrc);
        });
    }
</script>