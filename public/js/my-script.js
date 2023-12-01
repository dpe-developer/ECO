const getUrl = window.location;
const baseUrl = getUrl .protocol + "//" + getUrl.host;

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

// Disable Submit Button
$(document).on('submit', 'form', function(){
    $(this).find('button[type="submit"]').prop('disabled', true).append(' <i class="fa fa-spinner fa-spin fa-pulse"></i>')
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
    });

    $('.toast').toast('show')
    $('[data-toggle="popover"').popover()
    $('[data-toggle="popover-sanitize"]').popover({
        html: true,
        sanitize: false,
        container: 'body',
    });
});

// Set current nav-tabs active link
$(function(){
    var hash = window.location.hash;
    hash && $('ul.nav a[href="' + hash + '"]').tab('show');
    $(document).on('click', '.nav-tabs a', function (e) {
        // $(this).tab('show');
        window.location.hash = this.hash;
    });
    $(document).on('click', '.profile-customize-ui a', function (e) {
        // $(this).tab('show');
        window.location.hash = this.hash;
    });
});

// Sidebar menu active item
$(function(){
    const url = $('meta[name="parent-url"]').attr('content');
    
    // for sidebar menu but not for treeview submenu
    $('ul.nav-sidebar li a').filter(function() {
        if(url == $(this).attr('href')){
            $(this).addClass('active');
        }
    });
    $('ul.nav-treeview li a').filter(function() {
        if(url == $(this).attr('href')){
            $(this).parent().parent().parent().addClass('menu-open');
        }
    });
    $('ul.nav-sidebar li.menu-open').filter(function() {
        $(this).find('a[href="#"]').addClass('active');
    });
})

// Make table row as link
$(function(){
    $(document).on('click', '.tr-link', function() {
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
})

// Backdrop for double modal
$(document).on('show.bs.modal', '.modal', function () {
    var zIndex = 1040 + (10 * $('.modal:visible').length);
    $(this).css('z-index', zIndex);
    setTimeout(function() {
        $('.modal-backdrop').not('.modal-stack').css('z-index', zIndex - 1).addClass('modal-stack');
    }, 0);
});


$(document).on('click', '.modal-delete-close', function(){
    $('#deleteLink').attr('action', '');
    $('#deleteFromTableModal').modal('hide');
});


$(document).on('click', '.modal-restore-close', function(){
    $('#restoreLink').attr('action', '');
    $('#restoreFromTableModal').modal('hide');
});

// Modal Ajax
$(document).on('click', '[data-toggle="modal-ajax"]', function(){
    $('#loader').show();
    let modalAjaxBtn = $(this);
    var href = modalAjaxBtn.data('href');
    var target = modalAjaxBtn.data('target');
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
            if(modalAjaxBtn.hasClass('tr-with-badge')){
                modalAjaxBtn.find('.new-badge').remove();
                var countBadge = $('ul.nav-sidebar').find('a.active .new-badge-count');
                var totalCount = countBadge.attr('badge-count');
                console.log(totalCount);
                var newCount = totalCount-1;
                countBadge.attr('badge-count', newCount);
                if(newCount == 0){
                    countBadge.remove();
                }else{
                    countBadge.text(newCount);
                }
            }
            if(modalAjaxBtn.hasClass('card-with-badge')){
                modalAjaxBtn.parents('.card').find('.new-badge').remove();
                var countBadge = $('ul.nav-sidebar').find('a.active .new-badge-count');
                var totalCount = countBadge.attr('badge-count');
                console.log(totalCount);
                var newCount = totalCount-1;
                countBadge.attr('badge-count', newCount);
                if(newCount == 0){
                    countBadge.remove();
                }else{
                    countBadge.text(newCount);
                }
            }
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
            $('.datetimepicker-no-time').datetimepicker({
                buttons: {
                    time: false,
                }
            });
            $(target).modal('show');
            $('#loader').hide();
        },
        error: function(xhr, ajaxOptions, thrownError){
            ajax_error(xhr, ajaxOptions, thrownError)
            // removeLocationHash()
            $('#loader').hide();
        }
    })
});

// Card Accordion AJAX
$(document).on('click', '#accordion[data-toggle="card-accordion-ajax"] [data-toggle="collapse"]', function(){
    const button = $(this);
    let href = button.data('href');
    let target = button.data('target');
    if(button.attr('aria-expanded') == 'true'){
        console.log("AJAX CALL");
        $.ajax({
            type: 'GET',
            url: href,
            data: {},
            beforeSend: function(){
                $('#loader').fadeIn();
            },
            success: function(response){
                if(button.hasClass('accordion-with-badge')){
                    button.find('.new-badge').remove();
                    let countBadge = $('ul.nav-sidebar').find('a.active .new-badge-count');
                    let totalCount = countBadge.attr('badge-count');
                    let newCount = totalCount-1;
                    countBadge.attr('badge-count', newCount);
                    if(newCount == 0){
                        countBadge.remove();
                    }else{
                        countBadge.text(newCount);
                    }
                }
                $(target).find('.card-body').html(response.accordion_content);
                $('#loader').hide();
            },
            error: function(xhr, ajaxOptions, thrownError){
                ajax_error(xhr, ajaxOptions, thrownError)
                // removeLocationHash()
                $('#loader').hide();
            }
        })
    }

});

$(document).on('click', '[data-dismiss="modal-ajax"]', function() {
    // closeAllModals()
    $('.modal').modal('hide')
    $('.modal-backdrop').fadeOut(250, function() {
        $('.modal-backdrop').remove()
    })
    $('body').removeClass('modal-open').css('padding-right', '0px');
    $('#oldInput').html('');
    $('#modalAjax').html('');
    removeLocationHash();
});

// Alert before proceed to route/link/url
$(document).on('click', 'a[data-toggle="confirm-link"]', function(){
    Swal.fire({
        title: ($(this).data('title') != null ? $(this).data('title') : 'Are you sure?'),
        // message: $(this).data('message'),
        html: $(this).data('message'),
        // success, info, question, warning, error 
        icon: ($(this).data('icon') != null ? $(this).data('icon') : 'question'),
        // icon: $(this).data('icon'),
        showCancelButton: true,
        confirmButtonColor: '#007bff',
        // cancelButtonColor: '#d33',
        confirmButtonText: 'Proceed',
        reverseButtons: true
    }).then((result) => {
        if (result.isConfirmed) {
            if($(this).attr('target') == '_blank'){
                window.open($(this).data("href"));
            }else{
                window.location = $(this).data("href");
            }
            
        }
    })
});

/**
 * FUNCTIONS
 */
disableInputGroup();
function deleteFromTable(button){
    var href = $(button).data('href');
    $('#deleteLink').attr('action', href);
    $('#deleteFromTableModal').modal('show');
}

function restoreFromTable(button){
    var href = $(button).data('href');
    $('#restoreLink').attr('action', href);
    $('#restoreFromTableModal').modal('show');
}

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