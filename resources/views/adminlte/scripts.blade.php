{{-- Bootstrap --}}
<script src="{{ asset('AdminLTE-3.2.0/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
{{-- overlayScrollbars --}}
<script src="{{ asset('AdminLTE-3.2.0/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js') }}"></script>
{{-- AdminLTE App --}}
<script src="{{ asset('AdminLTE-3.2.0/dist/js/adminlte.js') }}"></script>
{{-- Material Design Bootstrap --}}
{{-- <script type="text/javascript" src="{{ asset('plugins/MDB5-STANDARD-UI-KIT-Free-6.4.2/js/mdb.min.js') }}"></script> --}}
{{-- PAGE PLUGINS --}}
{{-- jQuery Mapael --}}
<script src="{{ asset('AdminLTE-3.2.0/plugins/jquery-mousewheel/jquery.mousewheel.js') }}"></script>
<script src="{{ asset('AdminLTE-3.2.0/plugins/raphael/raphael.min.js') }}"></script>
<script src="{{ asset('AdminLTE-3.2.0/plugins/jquery-mapael/jquery.mapael.min.js') }}"></script>
<script src="{{ asset('AdminLTE-3.2.0/plugins/jquery-mapael/maps/usa_states.min.js') }}"></script>
{{-- ChartJS --}}
<script src="{{ asset('AdminLTE-3.2.0/plugins/chart.js/Chart.min.js') }}"></script>

{{-- My Scripts --}}
<script type="application/javascript" src="{{ asset('AdminLTE-3.2.0/plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script type="application/javascript" src="{{ asset('AdminLTE-3.2.0/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
<script type="application/javascript" src="{{ asset('AdminLTE-3.2.0/plugins/select2/js/select2.full.min.js') }}"></script>
<script type="application/javascript" src="{{ asset('AdminLTE-3.2.0/plugins/moment/moment-with-locales.min.js') }}"></script>
<script type="application/javascript" src="{{ asset('AdminLTE-3.2.0/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js') }}"></script>
<script type="application/javascript" src="{{ asset('AdminLTE-3.2.0/plugins/sweetalert2/sweetalert2.all.min.js') }}"></script>

<script type="text/javascript">

    /*const app = new Vue({
        el: '#app',
    });*/

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $(window).on('beforeunload', function(){
       $('#loader').fadeIn();
    });

    $(window).on('load', function(){
       $('#loader').fadeOut();
    });

	$(function(){
		$(document).on('focus', '.input-group-compact', function() {
			$(this).addClass('input-group-compact-focus');
		})
		$(document).on('focusout', '.input-group-compact', function() {
			$(this).removeClass('input-group-compact-focus');
		})
		$('body').on('click', function(){
			disableInputGroup();
		})
	})
	disableInputGroup();
	function disableInputGroup(){
		$('.input-group-compact input').each(function(){
			if($(this).prop('disabled') || $(this).prop('readonly')){
				$(this).parent().find('.input-group-append .input-group-text').css({
					'background-color': '#e9ecef'
				})
				$(this).parent().find('.input-group-prepend .input-group-text').css({
					'background-color': '#e9ecef'
				})
			}
		})
	}

    $(function() {
        $(".tr-link").click(function() {
            window.location = $(this).data("href");
        });
        $(document).on('click', 'tr[data-toggle="tr-link"]', function(){
            window.location = $(this).data("href");
        });

        /* $(document).on('click', 'td.td-action > a', function(e){
            // e.preventDefault();
            e.stopPropagation();
            if($(this).data('toggle') == 'modal-ajax'){
                modalAjax($(this))
            }
        });

        $(document).on('click', 'tr[data-toggle="tr-link"]', function(event){
            var href = $(this).data("href");
            if (event.ctrlKey){
                window.open(href);
            }else{
                window.location = href;
            }
        }); */
    });

    /*$(document).ready(function() {
        $('.ajax-tr-link').on('click', function() {
            $.ajax({
                type: 'GET',
                url: $(this).data('href'),
                success: function (data){
                    $('#asd').html(data.html);
                },
                error:function (xhr, ajaxOptions, thrownError){
                    Swal.fire({
                        type: 'error',
                        title: 'Error',
                    })
                }
            });
        });
    });*/

    function deleteFromTable(button){
        var href = $(button).data('href');
        $('#deleteLink').attr('action', href);
        $('#deleteFromTableModal').modal('show');
    }

    $(document).on('click', '.modal-delete-close', function(){
        $('#deleteLink').attr('action', '');
        $('#deleteFromTableModal').modal('hide');
    })

    function restoreFromTable(button){
        var href = $(button).data('href');
        $('#restoreLink').attr('action', href);
        $('#restoreFromTableModal').modal('show');
    }

    $(document).on('click', '.modal-restore-close', function(){
        $('#restoreLink').attr('action', '');
        $('#restoreFromTableModal').modal('hide');
    })

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

    // Ajax Print
    /* $(document).on('click', '[data-toggle="ajax-print"]', function(){
        $('#loader').show();
        var href = $(this).data('href');
        var printerIP = $(this).data('printer-ip');
        
        $.ajax({
            type: 'GET',
            data: {
                printer_ip_address: printerIP
            },
            url: href,
            success: function(){
                $('#loader').hide();
                ajaxActionAlert('success', 'Print Successfully')
            },
            error: function(xhr, ajaxOptions, thrownError){
                $('#loader').hide();
                ajax_error(xhr, ajaxOptions, thrownError)
                removeLocationHash()
            }
        })
    })
    $(document).on('click', '[data-toggle="ajax-print-select"]', function(){
        $('#loader').show();
        var href = $(this).data('href');
        var printerIP = $(this).data('print-url');
        
        $.ajax({
            type: 'GET',
            data: {
                print_url: printerIP
            },
            url: href,
            success: function(data){
                $('.modal-backdrop').remove()
                $('#modalAjax').html(data.modal_content)
                $('#modalSelectReceiptPrinter').modal('show')
                $('#loader').hide();
            },
            error: function(xhr, ajaxOptions, thrownError){
                $('#loader').hide();
                ajax_error(xhr, ajaxOptions, thrownError)
                removeLocationHash()
            }
        })
    }) */
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
                    // dropdownParent: $('a[data-dismiss="modal-ajax"]').parent('.modal-header').parent('.modal-content').parent('.modal-dialog').parent('.modal'),
                    theme: "bootstrap4",
                    placeholder: "Select",
                    allowClear: true
                });
                /* $('.select2').select2({
                    theme: "bootstrap4",
                    placeholder: "Select",
                    allowClear: true
                }); */
                $('.datetimepicker').datetimepicker();
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

    /*$(document).on('click', '.modal-ajax-close', function() {
        // closeAllModals()
        $('.modal').modal('hide')
        $('.modal-backdrop').fadeOut(250, function() {
            $('.modal-backdrop').remove()
        })
        $('body').removeClass('modal-open').css('padding-right', '0px');
        $('#modalAjax').html('')
        removeLocationHash()
    })

    $(document).on('click', '.modal-open-link', function() {
        var href = $(this).data('href');
        var target = $(this).data('target');
        $.ajax({
            type: 'GET',
            url: href,
            success: function(data){
                if(data.permission_denied){
                    ajax_permission_denied()
                    removeLocationHash()
                }else{
                    $('.modal-backdrop').remove()
                    $('#modalOpenData').html(data.html)
                    $(target).modal('show')
                }
            },
            error: function(xhr, ajaxOptions, thrownError){
                ajax_error(xhr, ajaxOptions, thrownError)
                removeLocationHash()
            }
        })
    })

    $(document).on('click', '.modal-close', function() {
        // closeAllModals()
        $('.modal').modal('hide')
        $('.modal-backdrop').fadeOut(250, function() {
            $('.modal-backdrop').remove()
        })
        $('#modalOpenData').html('')
        removeLocationHash()
    })*/


    $(function(){
        $('.toast').toast('show')

        $('[data-toggle="popover"').popover()
        $('[data-toggle="popover-sanitize"]').popover({
            html: true,
            sanitize: false,
            container: 'body',
        })
	})

	// Get Screen Size
	/* $(function() {
		// window.onresize = displayWindowSize;
		// window.onload = displayWindowSize;

		$(window).on('resize', function(){
			displayWindowSize();
		})

		$(window).on('load', function(){
			displayWindowSize();
		})

		$(window).on('click', function(){
			displayWindowSize();
		})

		function displayWindowSize() {
			var size = "";
			var windowInnerWidth = window.innerWidth;
			var windowInnerHeight = window.innerHeight;
			var bodyWidth = $('body').innerWidth();
			var bodyHeight = $('body').innerHeight();
			var navbarWidth = $('.main-header').innerWidth();
			var navbarHeight = $('.main-header').innerHeight();
			var width = $('.content .container-fluid').innerWidth();
			var width = $('.content-header').innerWidth();
			var height = $('.content-header').innerHeight();
			// your size calculation code here
			size += "<li>Window Inner Size: " + windowInnerWidth + " x " + windowInnerHeight+"</li>";
			size += "<li>body: " + bodyWidth + " x " + bodyHeight + "</li>";
			// size += "<li>.content-header: " + width + " x " + height + "</li>";
			// size += "<li>.main-header: " + navbarWidth + " x " + navbarHeight + "</li>";
			$("#screenSize").html(size);
			// $('.dynamic-height').css('height', height+'px');
		};

	}); */
</script>
{{-- Session Timeout --}}
{{-- <script type="application/javascript">
    var count = (parseInt({{config('session.lifetime')}}) * 60) - 2;
    function timer() {
        if(count  > 60){
            window.onclick = resetTimer;     // catches mouse clicks
            window.onscroll = resetTimer;    // catches scrolling
            window.onkeypress = resetTimer;  //catches keyboard actions
        }else{
            window.onclick = eventDisabled;     // catches mouse clicks
            window.onscroll = eventDisabled;    // catches scrolling
            window.onkeypress = eventDisabled;
            $('#sessionTimeoutModal').modal('show');
            if (count <= 0){
                logout();
            }
        }
        $('#sessionCountdown').text(parseFloat(count));
        count--;
    }
    timer();
    setInterval(timer, 1000);
    function resetTimer() {
        count = parseInt({{config('session.lifetime')}}) * 60 - 2;
        $('#sessionCountdown').load('{{url("/reload_session")}}');
    }
    function logout() {
        $('#logout-form').submit();
    }
    function confirmSession() {
        count = parseInt({{config('session.lifetime')}}) * 60 - 2;
        $('#sessionCountdown').load('{{url("/reload_session")}}');
        console.log('Session Confirm');
        $('#sessionTimeoutModal').modal('hide');
    }
    function eventDisabled() {
        console.log('Event disabled. please click confirm button to continue');
    }
</script> --}}

{{-- Set current nav-tabs active link --}}
<script type="application/javascript">
    $(function(){
        var hash = window.location.hash;
        hash && $('ul.nav a[href="' + hash + '"]').tab('show');
        $('.nav-tabs a').click(function (e) {
            // $(this).tab('show');
            window.location.hash = this.hash;
        });
        $('.profile-customize-ui a').click(function (e) {
            // $(this).tab('show');
            window.location.hash = this.hash;
        });
    });
</script>

{{-- Sidebar menu active item --}}
<script type="application/javascript">
    $(function(){
        @php
            $url = explode('/', url()->current());
            $base_url = $url[0].'//'.$url[2].'/'.$url[3];
        @endphp
        var url = '{{ $base_url }}';
        // for sidebar menu but not for treeview submenu
        $('ul.nav-sidebar li a').filter(function() {
            if(url == $(this).attr('href')){
                $(this).addClass('active')
            }
        })
        $('ul.nav-treeview li a').filter(function() {
            if(url == $(this).attr('href')){
                $(this).parent().parent().parent().addClass('menu-open')
            }
        })
        $('ul.nav-sidebar li.menu-open').filter(function() {
            $(this).find('a[href="#"]').addClass('active')
        })
    })
</script>

{{-- Backdrop for double modal --}}
<script type="application/javascript">
    $(document).on('show.bs.modal', '.modal', function () {
        var zIndex = 1040 + (10 * $('.modal:visible').length);
        $(this).css('z-index', zIndex);
        setTimeout(function() {
            $('.modal-backdrop').not('.modal-stack').css('z-index', zIndex - 1).addClass('modal-stack');
        }, 0);
    });
</script>

{{-- Initialize tempusdominus-bootstrap --}}
<script type="application/javascript">
    // Set default options
    $.extend(true, $.fn.datetimepicker.Constructor.Default, {
        icons: {
            /* time: 'far fa-clock',
            date: 'far fa-calendar',
            up: 'fas fa-arrow-up',
            down: 'fas fa-arrow-down',
            previous: 'fas fa-chevron-left',
            next: 'fas fa-chevron-right',
            today: 'fas fa-calendar-check',
            clear: 'far fa-trash-alt',
            close: 'far fa-times-circle' */
            time: 'far fa-clock',
            date: 'far fa-calendar-alt',
            up: 'fas fa-arrow-up',
            down: 'fas fa-arrow-down',
            previous: 'fas fa-chevron-left',
            next: 'fas fa-chevron-right',
            today: 'far fa-calendar-check',
            clear: 'far fa-trash-alt',
            close: 'fas fa-times'
        },
        buttons: {
            showToday: true,
            showClose: true,
            showClear: true
        }
    });

    // Initialize
    $('.datetimepicker').datetimepicker();
    $('.datetimepicker-no-time').datetimepicker({
        buttons: {
            time: false,
        }
    });
</script>

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

{{-- Initialize DataTable --}}
<script type="application/javascript">
    $(document).ready( function () {
        $('#datatable').DataTable();
    });
</script>

{{-- Initilize select2 --}}
<script type="application/javascript">
    // Search bar autofocus
    $(document).on('select2:open', () => {
        document.querySelector('.select2-search__field').focus();
    });

    // Initialize
    $(function() {
        $.fn.select2.defaults.set('theme', 'bootstrap4');
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

{{-- Initialize tooltip --}}
<script type="application/javascript">
    $(function () {
        $('[data-tooltip="true"]').tooltip({
            // placement: "left",
            html: true
        });
        $('[data-toggle="tooltip"]').tooltip();
    })
</script>

 {{--  Action Alert --}}
<script type="application/javascript">
    $(function() {
        var Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000
        });
        @if($message = Session::get('alert-success'))
        Toast.fire({
            icon: 'success',
            title: '{{ $message }}'
        })
        @elseif($message = Session::get('alert-info'))
        Toast.fire({
            icon: 'info',
            title: '{{ $message }}'
        })
        @elseif($message = Session::get('alert-warning'))
        Toast.fire({
            icon: 'warning',
            title: '{{ $message }}'
        })
        @elseif($message = Session::get('alert-error'))
        Toast.fire({
            icon: 'error',
            title: '{{ $message }}'
        })
        @endif
    })

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
</script>

@if (count($errors) > 0)
@if (old('from_modal_ajax_href'))
<script>
    $(function(){
        var getUrl = window.location;
        var baseUrl = getUrl .protocol + "//" + getUrl.host;
        var route = "{{ old('from_modal_ajax_href') }}"
        var target = "{{ old('modal_ajax_target') }}"
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
            // url: baseUrl + '/' + modalAjaxData + '/' + id,
            url: route,
            data: data,
            success: function(data){
                $('.modal-backdrop').remove()
                $('#modalAjax').html(data.modal_content)
                $('.select2').select2({
                    dropdownParent: $('a[data-dismiss="modal-ajax"]').parent('.modal-header').parent('.modal-content').parent('.modal-dialog').parent('.modal'),
                    theme: "bootstrap4",
                    placeholder: "Select",
                    allowClear: true
                });
                $('.datetimepicker').datetimepicker();
                $('#oldInput').find('input').each(function(){
                    var name = $(this).attr('name').replace('old_', '');
                    if(name != '_token'){
                        var value = $(this).val();
                        $('#modalAjax [name="'+name+'"]').parent('.form-group').find('.invalid-feedback').html('<strong class="text-danger">'+$(this).data('error-message')+'</strong>')
                        $('#modalAjax').find('input[type="email"][name="'+name+'"]').val(value).addClass($(this).data('error'));
                        $('#modalAjax').find('input[type="password"][name="'+name+'"]').val(value).addClass($(this).data('error'));
                        $('#modalAjax').find('input[type="number"][name="'+name+'"]').val(value).addClass($(this).data('error'));
                        $('#modalAjax').find('input[type="date"][name="'+name+'"]').val(value).addClass($(this).data('error'));
                        $('#modalAjax').find('input[type="text"][name="'+name+'"]').val(value).addClass($(this).data('error'));
                        $('#modalAjax').find('input[type="checkbox"][name="'+name+'"][value="'+value+'"]').prop('checked', true);
                        $('#modalAjax').find('input[type="radio"][name="'+name+'"][value="'+value+'"]').prop('checked', true);
                        // $('#modalAjax').find('input[type="radio"][name="'+name+'"][value="'+value+'"]').prop('checked', true);
                        $('#modalAjax').find('select[name="'+name+'"]').val(value).trigger('change').addClass($(this).data('error'));
                    }
                })
                /* $(function () {
                    bsCustomFileInput.init();
                }); */
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
</script>
@endif
@endif