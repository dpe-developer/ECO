/**
 *  Change UI script
 */
/* $(function(){
    $('#darkmode').on('change', function(){
        $('body').addClass('dark-mode')
        console.log('darkmode')
    })
}) */

$(function(){
    // darkmode
    $('#darkmode').on('switchChange.bootstrapSwitch', function (event, state) {
        if(state){
            $('body').addClass('dark-mode')
        }else{
            $('body').removeClass('dark-mode')
        }
    });
    // header options - fixed
    $('#headerFixed').on('switchChange.bootstrapSwitch', function (event, state) {
        if(state){
            $('body').addClass('layout-navbar-fixed')
        }else{
            $('body').removeClass('layout-navbar-fixed')
        }
    }); 
    // header options - dropdown legacy
    $('#headerDropdownLegacy').on('switchChange.bootstrapSwitch', function (event, state) {
        if(state){
            $('.main-header').addClass('dropdown-legacy')
        }else{
            $('.main-header').removeClass('dropdown-legacy')
        }
    }); 
    // header options - no border
    $('#headerNoBorder').on('switchChange.bootstrapSwitch', function (event, state) {
        if(state){
            $('.navbar').addClass('border-botom-0')
        }else{
            $('.navbar').removeClass('border-botom-0')
        }
    }); 
    // sidebar options - collapse
    $('#sidebarCollapse').on('switchChange.bootstrapSwitch', function (event, state) {
        if(state){
            $('body').addClass('sidebar-collapse')
        }else{
            $('body').removeClass('sidebar-collapse')
        }
    }); 
    // sidebar options - fixed
    $('#sidebarFixed').on('switchChange.bootstrapSwitch', function (event, state) {
        if(state){
            $('body').addClass('layout-fixed')
        }else{
            $('body').removeClass('layout-fixed')
        }
    });
    // sidebar options - sidebar mini
    $('#sidebarMini').on('switchChange.bootstrapSwitch', function (event, state) {
        if(state){
            $('body').addClass('sidebar-mini')
        }else{
            $('body').removeClass('sidebar-mini')
        }
    });
    // sidebar options - sidebar mini md
    $('#sidebarMiniMd').on('switchChange.bootstrapSwitch', function (event, state) {
        if(state){
            $('body').addClass('sidebar-mini-md')
        }else{
            $('body').removeClass('sidebar-mini-md')
        }
    });
    // sidebar options - sidebar mini xs
    $('#sidebarMiniXs').on('switchChange.bootstrapSwitch', function (event, state) {
        if(state){
            $('body').addClass('sidebar-mini-xs')
        }else{
            $('body').removeClass('sidebar-mini-xs')
        }
    });
    // sidebar options - nav flat style
    $('#sidebarNavFlatStyle').on('switchChange.bootstrapSwitch', function (event, state) {
        if(state){
            $('.nav-sidebar').addClass('nav-flat')
        }else{
            $('.nav-sidebar').removeClass('nav-flat')
        }
    });
    // sidebar options - nav legacy style
    $('#sidebarNavLegacyStyle').on('switchChange.bootstrapSwitch', function (event, state) {
        if(state){
            $('.nav-sidebar').addClass('nav-legacy')
        }else{
            $('.nav-sidebar').removeClass('nav-legacy')
        }
    });
    // sidebar options - nav child indent
    $('#sidebarNavChildIndent').on('switchChange.bootstrapSwitch', function (event, state) {
        if(state){
            $('.nav-sidebar').addClass('nav-child-indent')
        }else{
            $('.nav-sidebar').removeClass('nav-child-indent')
        }
    });
    // sidebar options - nav child hide on collapse
    $('#sidebarNavCollapseChildHide').on('switchChange.bootstrapSwitch', function (event, state) {
        if(state){
            $('.nav-sidebar').addClass('nav-collapse-hide-child')
        }else{
            $('.nav-sidebar').removeClass('nav-collapse-hide-child')
        }
    });
    // sidebar options - nav child hide on collapse
    $('#sidebarNoExpand').on('switchChange.bootstrapSwitch', function (event, state) {
        if(state){
            $('.main-sidebar').addClass('sidebar-no-expand')
        }else{
            $('.main-sidebar').removeClass('sidebar-no-expand')
        }
    });
    // footer options - fixed
    $('#footerFixed').on('switchChange.bootstrapSwitch', function (event, state) {
        if(state){
            $('body').addClass('layout-footer-fixed')
        }else{
            $('body').removeClass('layout-footer-fixed')
        }
    });
    // Small Text Options - Body
    $('#smallTextBody').on('switchChange.bootstrapSwitch', function (event, state) {
        if(state){
            $('body').addClass('text-sm')
        }else{
            $('body').removeClass('text-sm')
        }
    });
    // Small Text Options - Navbar
    $('#smallTextNavbar').on('switchChange.bootstrapSwitch', function (event, state) {
        if(state){
            $('.main-header').addClass('text-sm')
        }else{
            $('.main-header').removeClass('text-sm')
        }
    });
    // Small Text Options - Brand
    $('#smallTextBrand').on('switchChange.bootstrapSwitch', function (event, state) {
        if(state){
            $('.brand-link').addClass('text-sm')
        }else{
            $('.brand-link').removeClass('text-sm')
        }
    });
    // Small Text Options - Sidebar Nav
    $('#smallTextSidebarNav').on('switchChange.bootstrapSwitch', function (event, state) {
        if(state){
            $('.nav-sidebar').addClass('text-sm')
        }else{
            $('.nav-sidebar').removeClass('text-sm')
        }
    });
    // Small Text Options - Footer
    $('#smallTextFooter').on('switchChange.bootstrapSwitch', function (event, state) {
        if(state){
            $('.main-footer').addClass('text-sm')
        }else{
            $('.main-footer').removeClass('text-sm')
        }
    });

    var $uiOptionsContainer = $('.ui-options')
    var $container = $('<div />')

    $uiOptionsContainer.append($container)

    // Color Arrays
    var navbar_dark_skins = [
        'navbar-primary',
        'navbar-secondary',
        'navbar-info',
        'navbar-success',
        'navbar-danger',
        'navbar-indigo',
        'navbar-purple',
        'navbar-pink',
        'navbar-navy',
        'navbar-lightblue',
        'navbar-teal',
        'navbar-cyan',
        'navbar-dark',
        'navbar-gray-dark',
        'navbar-gray'
    ]

    var navbar_light_skins = [
        'navbar-light',
        'navbar-warning',
        'navbar-white',
        'navbar-orange'
    ]

    var sidebar_colors = [
        'bg-primary',
        'bg-warning',
        'bg-info',
        'bg-danger',
        'bg-success',
        'bg-indigo',
        'bg-lightblue',
        'bg-navy',
        'bg-purple',
        'bg-fuchsia',
        'bg-pink',
        'bg-maroon',
        'bg-orange',
        'bg-lime',
        'bg-teal',
        'bg-olive'
    ]

    var accent_colors = [
        'accent-primary',
        'accent-warning',
        'accent-info',
        'accent-danger',
        'accent-success',
        'accent-indigo',
        'accent-lightblue',
        'accent-navy',
        'accent-purple',
        'accent-fuchsia',
        'accent-pink',
        'accent-maroon',
        'accent-orange',
        'accent-lime',
        'accent-teal',
        'accent-olive'
    ]

    var sidebar_skins = [
        'sidebar-dark-primary',
        'sidebar-dark-warning',
        'sidebar-dark-info',
        'sidebar-dark-danger',
        'sidebar-dark-success',
        'sidebar-dark-indigo',
        'sidebar-dark-lightblue',
        'sidebar-dark-navy',
        'sidebar-dark-purple',
        'sidebar-dark-fuchsia',
        'sidebar-dark-pink',
        'sidebar-dark-maroon',
        'sidebar-dark-orange',
        'sidebar-dark-lime',
        'sidebar-dark-teal',
        'sidebar-dark-olive',
        'sidebar-light-primary',
        'sidebar-light-warning',
        'sidebar-light-info',
        'sidebar-light-danger',
        'sidebar-light-success',
        'sidebar-light-indigo',
        'sidebar-light-lightblue',
        'sidebar-light-navy',
        'sidebar-light-purple',
        'sidebar-light-fuchsia',
        'sidebar-light-pink',
        'sidebar-light-maroon',
        'sidebar-light-orange',
        'sidebar-light-lime',
        'sidebar-light-teal',
        'sidebar-light-olive'
    ]

    function capitalizeFirstLetter(string) {
        return string.charAt(0).toUpperCase() + string.slice(1)
    }

    function createSkinBlock(customClass, colors, callback, noneSelected) {
        var $block = $('<select />', {
            class: noneSelected ? customClass + ' custom-select mb-3 border-0' : customClass + ' custom-select mb-3 text-light border-0 ' + colors[0].replace(/accent-|navbar-/, 'bg-')
        })

        if (noneSelected) {
            var $default = $('<option />', {
                text: 'None Selected'
            })

            $block.append($default)
        }

        colors.forEach(function (color) {
            var $color = $('<option />', {
                class: (typeof color === 'object' ? color.join(' ') : color).replace('navbar-', 'bg-').replace('accent-', 'bg-'),
                text: capitalizeFirstLetter((typeof color === 'object' ? color.join(' ') : color).replace(/navbar-|accent-|bg-/, '').replace('-', ' '))
            })

            $block.append($color)
        })
        if (callback) {
            $block.on('change', callback)
        }

        return $block
    }

    // Navbar Variants
    $container.append('<legend>Navbar Variants</legend>')

    var $navbar_variants = $('<div />', {
        class: 'form-group ml-3'
    })
    var navbar_all_colors = navbar_dark_skins.concat(navbar_light_skins)
    var oldNavbarVariant = '';
    var $navbar_variants_colors = createSkinBlock('navbar-variants-select', navbar_all_colors, function () {
        var color = $(this).find('option:selected').attr('class')
        var $main_header = $('.main-header')
        $main_header.removeClass('navbar-dark').removeClass('navbar-light')
        $main_header.removeClass(oldNavbarVariant)

        $(this).removeClass().addClass('custom-select mb-3 text-light border-0 ')

        var colorArrayName = color.replace('bg-', 'navbar-').toLowerCase()

        if (navbar_dark_skins.indexOf(colorArrayName) > -1) {
            $main_header.addClass('navbar-dark')
            $(this).addClass(color).addClass('text-light')
            $('input[name="adminlte_navbar_variant"]').val('navbar-dark '+ color)
        } else {
            $main_header.addClass('navbar-light')
            $(this).addClass(color)
            $('input[name="adminlte_navbar_variant"]').val('navbar-light '+ color)
        }
        
        oldNavbarVariant = color
        $main_header.addClass(color)
    })

    var active_navbar_color = null
    $('.main-header')[0].classList.forEach(function (className) {
        className = className.replace('bg-', 'navbar-')
        if (navbar_all_colors.indexOf(className) > -1) {
            active_navbar_color = className.replace('navbar-', 'bg-')
        }
    })

    $navbar_variants_colors.find('option.' + active_navbar_color).prop('selected', true)
    $navbar_variants_colors.removeClass().addClass('custom-select mb-3 text-light border-0 ').addClass(active_navbar_color)

    $navbar_variants.append($navbar_variants_colors)

    $container.append($navbar_variants)
    // End of Navbar Variants

    // Accent Color Variants
    $container.append("<legend>Accent Color Variants</legend>");
    var $accent_variants = $("<div />", {
        class: "form-group ml-3",
    });
    var $accent_variants_colors = createSkinBlock('accent-color-variants--select', accent_colors, function () {
        var color = $(this).find("option:selected").attr("class")
        var $body = $("body")
        accent_colors.forEach(function (skin) {
            $body.removeClass(skin);
        })

        $(this).removeClass().addClass('custom-select mb-3 border-0 ')
        if(color != undefined){

            var accent_color_class = color.replace("bg-", "accent-")
            var text_color_class = color.replace("bg-", "text-")

            $body.addClass(accent_color_class)
            $(this).addClass(text_color_class)
            
            $('input[name="adminlte_accent_color_variant"]').val(accent_color_class)
        }else{
            $('input[name="adminlte_accent_color_variant"]').val('')
        }
    }, true)

    if($('input[name="adminlte_accent_color_variant"]').val() != ''){
        var active_accent_color = null;
        $("body")[0].classList.forEach(function (className) {
            if (accent_colors.indexOf(className) > -1) {
                active_accent_color = className.replace("accent-", "bg-");
            }
        });

        $accent_variants_colors.find('option.' + active_accent_color).prop('selected', true)
        $accent_variants_colors.removeClass().addClass('custom-select mb-3 border-0 ').addClass(active_accent_color.replace("bg-", "text-"))
    }

    $accent_variants.append($accent_variants_colors)

    $container.append($accent_variants)
    // End of Accent Color Variants
    
    // Dark Sidebar Variants
    $container.append("<legend>Sidebar Variants</legend>");
    $sidebarVariantsFormGroup = $("<div />", {
        class: "form-group ml-3",
    })
    $sidebarVariantsFormGroup.append("<label class='mb-0'>Dark Sidebar Variants</label>");

    var $sidebar_dark_variants = createSkinBlock('select-dark-sidebar-variants', sidebar_colors, function () {
            var color = $(this).find("option:selected").attr("class");
            var sidebar_class = "sidebar-dark-" + color.replace("bg-", "");
            var $sidebar = $(".main-sidebar");
            sidebar_skins.forEach(function (skin) {
                $sidebar.removeClass(skin);
                $sidebar_light_variants.removeClass(skin.replace("sidebar-dark-", "bg-")).removeClass("text-light");
            });

            $(this).removeClass().addClass("select-dark-sidebar-variants custom-select mb-3 text-light border-0").addClass(color);

            $('.select-dark-sidebar-variants option').filter(function () { return $(this).html() == "None Selected"; }).addClass('d-none');
            $('.select-light-sidebar-variants option').filter(function () { return $(this).html() == "None Selected"; }).removeClass('d-none');
            $sidebar_light_variants.find("option").prop("selected", false);
            $sidebar.addClass(sidebar_class);
            $(".sidebar").removeClass("os-theme-dark").addClass("os-theme-light");
            $('input[name="adminlte_sidebar_variant"]').val(sidebar_class)
        },
        true
    );
    $sidebarVariantsFormGroup.append($sidebar_dark_variants)
    $container.append($sidebarVariantsFormGroup);
    
    var active_sidebar_dark_color = null;
    $(".main-sidebar")[0].classList.forEach(function (className) {
        var color = className.replace("sidebar-dark-", "bg-");
        if (sidebar_colors.indexOf(color) > -1 && active_sidebar_dark_color === null) {
            active_sidebar_dark_color = color;
            
        }
    });

    if (active_sidebar_dark_color !== null) {
        $sidebar_dark_variants.find("option." + active_sidebar_dark_color).prop("selected", true);
        $sidebar_dark_variants.removeClass().addClass("select-dark-sidebar-variants custom-select mb-3 text-light border-0 ").addClass(active_sidebar_dark_color);
        $('.select-dark-sidebar-variants option').filter(function () { return $(this).html() == "None Selected"; }).addClass('d-none');
    }
    // $sidebar_dark_variants.find("option." + active_sidebar_dark_color).prop("selected", true);
    // $sidebar_dark_variants.removeClass().addClass("custom-select mb-3 text-light border-0 ").addClass(active_sidebar_dark_color);
    // End of Dark Sidebar Variants

    // Light Sidebar Variants
    $sidebarVariantsFormGroup.append("<label>Light Sidebar Variants</label>");
    var $sidebar_light_variants = createSkinBlock('select-light-sidebar-variants', sidebar_colors, function () {
            var color = $(this).find("option:selected").attr("class");
            var sidebar_class = "sidebar-light-" + color.replace("bg-", "");
            var $sidebar = $(".main-sidebar");
            sidebar_skins.forEach(function (skin) {
                $sidebar.removeClass(skin);
                $sidebar_dark_variants.removeClass(skin.replace("sidebar-light-", "bg-")).removeClass("text-light");
            });

            $(this).removeClass().addClass("select-light-sidebar-variants custom-select mb-3 text-light border-0").addClass(color);

            $('.select-light-sidebar-variants option').filter(function () { return $(this).html() == "None Selected"; }).addClass('d-none');
            $('.select-dark-sidebar-variants option').filter(function () { return $(this).html() == "None Selected"; }).removeClass('d-none');
            $sidebar_dark_variants.find("option").prop("selected", false);
            $sidebar.addClass(sidebar_class);
            $(".sidebar").removeClass("os-theme-light").addClass("os-theme-dark");
            $('input[name="adminlte_sidebar_variant"]').val(sidebar_class)
        },
        true
    );
    $sidebarVariantsFormGroup.append($sidebar_light_variants);
    $container.append($sidebarVariantsFormGroup);

    var active_sidebar_light_color = null;
    $(".main-sidebar")[0].classList.forEach(function (className) {
        var color = className.replace("sidebar-light-", "bg-");
        if (sidebar_colors.indexOf(color) > -1 && active_sidebar_light_color === null) {
            active_sidebar_light_color = color;
        }
    });

    if (active_sidebar_light_color !== null) {
        $sidebar_light_variants.find("option." + active_sidebar_light_color).prop("selected", true);
        $sidebar_light_variants.removeClass().addClass("select-light-sidebar-variants custom-select mb-3 text-light border-0 ").addClass(active_sidebar_light_color);
        $('.select-light-sidebar-variants option').filter(function () { return $(this).html() == "None Selected"; }).addClass('d-none');
    }
    // End of Light Sidebar Variants

    // Brand Logo Variants
    var logo_skins = navbar_all_colors;
    $container.append("<legend>Brand Logo Variants</legend>");
    var $logo_variants = $("<div />", {
        class: "form-group ml-3",
    });
    
    var $clear_btn = $("<a />", {
        href: "#",
    })
        .text("clear")
        .on("click", function (e) {
            e.preventDefault();
            var $logo = $(".brand-link");
            logo_skins.forEach(function (skin) {
                $logo.removeClass(skin);
            });
        });
    
    var oldBrandVariant = $('input[name="adminlte_brand_logo_variant"]').val();
    var $brand_variants = createSkinBlock('', logo_skins, function () {
            var color = $(this).find("option:selected").attr("class");
            var $logo = $(".brand-link");
            $logo.removeClass(oldBrandVariant);
            if (color === "navbar-light" || color === "navbar-white") {
                $logo.addClass("text-black");
            } else {
                $logo.removeClass("text-black");
            }

            logo_skins.forEach(function (skin) {
                $logo.removeClass(skin);
            });

            

            if (color) {
                $(this)
                    .removeClass()
                    .addClass("custom-select mb-3 border-0")
                    .addClass(color)
                    .addClass(color !== "navbar-light" && color !== "navbar-white" ? "text-light" : "");
            } else {
                $(this).removeClass().addClass("custom-select mb-3 border-0");
            }
            oldBrandVariant = color
            $logo.addClass(color);
            $('input[name="adminlte_brand_logo_variant"]').val(color)
        },
        true
    ).append($clear_btn);
    $logo_variants.append($brand_variants);
    $container.append($logo_variants);

    var active_brand_color = null;
    $(".brand-link")[0].classList.forEach(function (className) {
        if (logo_skins.indexOf(className.replace("bg-", "navbar-")) > -1) {
            active_brand_color = className.replace("navbar-", "bg-");
        }
    });

    if (active_brand_color) {
        $brand_variants.find("option." + active_brand_color).prop("selected", true);
        $brand_variants.removeClass().addClass("custom-select mb-3 text-light border-0 ").addClass(active_brand_color);
    }
    // End of Brand Logo Variants

}) // end