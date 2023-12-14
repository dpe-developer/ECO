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
{{-- <script src="{{ asset('AdminLTE-3.2.0/plugins/chart.js/Chart.min.js') }}"></script> --}}

{{-- My Scripts --}}
<script type="application/javascript" src="{{ asset('AdminLTE-3.2.0/plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script type="application/javascript" src="{{ asset('AdminLTE-3.2.0/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
<script type="application/javascript" src="{{ asset('AdminLTE-3.2.0/plugins/select2/js/select2.full.min.js') }}"></script>
<script type="application/javascript" src="{{ asset('AdminLTE-3.2.0/plugins/moment/moment-with-locales.min.js') }}"></script>
<script type="application/javascript" src="{{ asset('AdminLTE-3.2.0/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js') }}"></script>
<script type="application/javascript" src="{{ asset('AdminLTE-3.2.0/plugins/sweetalert2/sweetalert2.all.min.js') }}"></script>
<script type="application/javascript" src="{{ asset('js/my-script.js') }}"></script>


{{-- Initialize tempusdominus-bootstrap --}}
<script type="application/javascript">
    // Set default options
    $(function(){

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
                showToday: false,
                showClose: false,
                showClear: false
            }
        });
    })
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