// ---------------------------------------------
//
// Custom scripts
// for this theme
//
// ---------------------------------------------

jQuery(document).ready(function ($) {

    // "responsive" rules and actions
    var responsive_viewport = $(window).innerWidth() + 15;

    $(window).smartresize(function () {
        responsive_viewport = $(window).width() + 15;
    });


    // ---------------------------------------------
    //
    // Advertise scripts
    // for this theme
    //
    //
    // Available ad zones:
    //
    // .ad-small-one
    // .ad-small-two
    // .ad-small-three
    // .ad-small-four   -> all Zone 2
    //
    // .ad-medium-one   -> Google Ad
    // .ad-medium-two   -> Zone 1
    //
    // .ad-leaderboard  -> Google Ad
    //
    // ---------------------------------------------

    // Synchronous fix
    // http://stackoverflow.com/questions/28322636/synchronous-xmlhttprequest-warning-and-script
    // -------------------------------------------------------
    $.ajaxPrefilter(function (options) {
        options.async = true;
    });

    // Get base url
    // See functions.php
    // -------------------------------------------------------
    var baseURL = URLData.siteurl;

    // Function to display static ads
    // -------------------------------------------------------
    function setAds() {

        $('.ad-small-two:not(.medium-up)').each(function () {
            var trigger = Math.random();
            $(this).html('');
            $('<script>').attr('type', 'text/javascript').attr('async', 'async').attr('src', baseURL + '/wp-content/plugins/oiopub-direct/js.php?lazy=true&rand=' + trigger + '#type=banner&align=center&zone=2&rows=1&cols=2&markup_allow_style=false&repeats=false&empty=0').appendTo($(this));
        });

        $('.ad-medium-two').each(function () {
            var trigger = Math.random();
            $(this).html('');
            $('<script>').attr('type', 'text/javascript').attr('async', 'async').attr('src', baseURL + '/wp-content/plugins/oiopub-direct/js.php?lazy=true&rand=' + trigger + '#type=banner&align=center&zone=1&rows=1&cols=2&markup_allow_style=false&repeats=false&empty=0').appendTo($(this));
        });


        if (responsive_viewport > 240) {

            // ad-small-two.medium-up von 0 auf 2
            $('.ad-small-two.medium-up').each(function () {
                var trigger = Math.random();
                $(this).html('');
                $('<script>').attr('type', 'text/javascript').attr('async', 'async').attr('src', baseURL + '/wp-content/plugins/oiopub-direct/js.php?lazy=true&rand=' + trigger + '#type=banner&align=center&zone=2&rows=1&cols=2&markup_allow_style=false&repeats=false&empty=0').appendTo($(this));
            });

            // ad-small-three von 1 auf 3
            $('.ad-small-three').each(function () {
                if ($(this).find('li.oio-slot').length < 3 || $(this).find('li.oio-slot').length === 0) {
                    var trigger = Math.random();
                    $(this).html('');
                    $('<script>').attr('type', 'text/javascript').attr('async', 'async').attr('src', baseURL + '/wp-content/plugins/oiopub-direct/js.php?lazy=true&rand=' + trigger + '#type=banner&align=center&zone=2&rows=1&cols=3&markup_allow_style=false&repeats=false&empty=0').appendTo($(this));
                }
            });

            // ad-small-four von 1 auf 4
            $('.ad-small-four').each(function () {
                var trigger = Math.random();
                $(this).html('');
                $('<script>').attr('type', 'text/javascript').attr('async', 'async').attr('src', baseURL + '/wp-content/plugins/oiopub-direct/js.php?lazy=true&rand=' + trigger + '#type=banner&align=center&zone=2&rows=1&cols=4&markup_allow_style=false&repeats=false&empty=0').appendTo($(this));
            });

            // ad-medium-one von 0 auf 1
            $('.ad-medium-one.medium-up').each(function () {
                var trigger = Math.random();
                $(this).html('');
                $('<script>').attr('type', 'text/javascript').attr('async', 'async').attr('src', baseURL + '/wp-content/plugins/oiopub-direct/js.php?lazy=true&rand=' + trigger + '#type=banner&align=center&zone=1&rows=1&cols=1&markup_allow_style=false&repeats=false&empty=0').appendTo($(this));
            });
        }

        if (responsive_viewport > 1023) {
            // ad-small-one von 0 auf 1
            $('.ad-small-one.large-only').each(function () {
                var trigger = Math.random();
                $(this).html('');
                $('<script>').attr('type', 'text/javascript').attr('async', 'async').attr('src', baseURL + '/wp-content/plugins/oiopub-direct/js.php?lazy=true&rand=' + trigger + '#type=banner&align=center&zone=2&rows=1&cols=1&markup_allow_style=false&repeats=false&empty=0').appendTo($(this));
            });
        }
    }
    setAds();


    // -------------------------------------------------------
    //
    // UI scriptst
    //
    // -------------------------------------------------------

    // Nav - Off Canvas Nav Open+Close
    // ---------------------------------------------
    $('.off-canvas-toggle').on('click', function (e) {
        e.preventDefault();
        $('html').toggleClass('off-canvas-active');
    });

    $('.off-canvas-deactivate, .off-canvas-wrapper .off-canvas-close').on('click', function (e) {
        e.preventDefault();
        $('html').removeClass('off-canvas-active');
    });


    // Nav - Off Canvas Toggle Submenus
    // ---------------------------------------------
    $('.off-canvas-menu .menu-item-has-children').each(function () {
        var $this = $(this);
        $this.children('a').after('<span class="icon-expand-more toggle-submenu"></span>');
    });

    $('.off-canvas-menu .menu-item-has-children > a').on('click', function (e) {
        e.preventDefault();
        $('.off-canvas-menu .menu-item-has-children').not($(this).parent('li')).removeClass('submenu-active');
        $(this).parent('li').toggleClass('submenu-active');
    });

    // Close on body click
    $('body').on('click', function (e) {
        if ($(e.target).parent('li').is('.menu-item-has-children')) {
            return false;
        } else {
            $('#menu-hauptmenue').find('li.submenu-active').removeClass('submenu-active');
        }
    });


    // Nav - Off Canvas Toggle Search
    // ---------------------------------------------
    $('.searchform-toggle').on('click', function (e) {
        e.preventDefault();
        $('.searchform-content').toggleClass('active');
    });

    // Close on body click
    $('body').on('click', function (e) {
        if ($('.searchform-content').hasClass('active')) {
            if ($(e.target).parents('form').is('#searchform') || $(e.target).parent('a').is('.searchform-toggle')) {
                //return false;
            } else {
                $('.searchform-content').removeClass('active');
            }
        }
    });


    // Nav - On Canvas Nav Submenus Width
    // ---------------------------------------------
    $(window).smartresize(function () {
        if (responsive_viewport >= 1024) {
            $('.off-canvas-menu .sub-menu').removeAttr('style');
            onCanvas();
        }
    });

    function onCanvas() {
        var mainNavWidth = $('.off-canvas-menu').width();
        $('.off-canvas-menu .sub-menu').each(function () {
            $(this).css('width', mainNavWidth + 'px');
        });
    } onCanvas();


    // Nav - On Canvas Sticky
    // ---------------------------------------------
    $(window).on('scroll', function () {
        if ($(window).scrollTop() > 450) {
            $('nav.main-navigation ').addClass('sticky');
        } else {
            $('nav.main-navigation ').removeClass('sticky');
        }
    });


    // Home/Archive - Module Heights
    // ---------------------------------------------
    $(window).smartresize(function () {
        setHeight();
    });

    function setHeight() {
        imagesLoaded($('main.site-main'), function () {
            $('.module-a-layout').each(function () {
                var postHeight = $(this).children('article.post').outerHeight();
                $(this).find('.module-a-aside-post').css('height', postHeight + 'px');
            });
        });
    } setHeight();


    // Home/Archive - Sub Category Nav
    // ---------------------------------------------
    if ($('.sub-category-nav').length > 0 && $('.sub-category-nav.lookbook-filter').length === 0) {
        $('.sub-category-nav > ul > li').on('click', function () {
            $('.sub-category-nav > ul > li > ul').not($(this).children('ul')).removeClass('active');
            $(this).children('ul').toggleClass('active');
        });

        $('body').on('click', function (e) {
            if ($(e.target).is('span') || $(e.target).is('li')) {
                return false;
            } else {
                $('.sub-category-nav > ul > li > ul').removeClass('active');
            }
        });
    }

    if ($('.sub-category-nav').length > 0) {
        // Check on init if LI has active filters
        $('.sub-category-nav > ul ul').each(function () {
            if ($(this).find('li.active').length > 0) {
                $(this).parent().addClass('active-filters');
            }
        });

        // Set filters on active
        $('.sub-category-nav .children li').on('click', function () {
            $(this).toggleClass('active');

            // Check on change if parent LI still has active filters
            if ($(this).closest('li.filter-title').find('li.active').length > 0) {
                $(this).closest('li.filter-title').addClass('active-filters');
            } else {
                $(this).closest('li.filter-title').removeClass('active-filters');
            }
        });
    }


    // Fave Modal
    // ---------------------------------------------
    function faveModal() {
        $('.sharing-options .essb_link_fave a, .button.link-fave').each(function () {
            var modalID = $(this).closest('.sharing-options').data('modal-id');
            if (typeof (modalID) !== 'undefined') {
                $(this).attr('data-remodal-target', 'modal-' + modalID);
                $(this).removeAttr('onclick');
            }
        });
    } faveModal();

    imagesLoaded($('main.site-main'), function () {
        $('.fav-modal-window').each(function () {
            $(this).find('.userpro-bm').addClass('is-visible');
        });
    });


    // Site - Lazyload
    // ---------------------------------------------
    if ('undefined' !== typeof fw_lazy_load) {
        var pageNum = parseInt(fw_lazy_load.startPage) + 1,
            max = parseInt(fw_lazy_load.maxPages),
            nextLink = fw_lazy_load.nextLink;
    }

    $('.load-more-button').on('click', function (e) {
        e.preventDefault();
        lazyLoadPosts($(this));
    });

    function lazyLoadPosts(elem) {
        if (pageNum <= max) {
            elem.addClass('loading');

            $.get(nextLink, function (data) {
                var pageContent = $(data).find('main.site-main').get();
                elem.before(pageContent);
                $(pageContent).find('.sub-category-nav').addClass('hidden');
            }).done(function () {
                elem.removeClass('loading');

                //Re-init functions
                $('.remodal ').remodal();
                picturefill();
                faveModal();
                setHeight();
                setAds();

                // Remove load more on last page
                if (pageNum > max) {
                    elem.addClass('all-done');
                }
            });
            pageNum++;
            nextLink = nextLink.replace(/\/page\/[0-9]+[0-9]?/, '/page/' + pageNum);
        }
        return false;
    }


    // Single - Credits Collpase
    // ---------------------------------------------
    $('.details-trigger').on('click', function () {
        $('.entry-details .entry-details-credits').toggleClass('active');
    });


    // Single - Masonry Init first time
    // ---------------------------------------------
    var $container = $('.single-post .entry-gallery.number1');

    if ($container !== '') {

        $container.hide();

        imagesLoaded($container, function () {
            $container.masonry({
                columnWidth: '.entry-gallery.number1 > li.masonry-helper',
                itemSelector: '.entry-gallery.number1 > li',
                gutter: 0
            }).show().masonry('layout');

            $('.single-post .gallery-loader.number1').hide();
        });
    }

   // 2. time
    var $container = $('.single-post .entry-gallery.number2');

    if ($container !== '') {

        $container.hide();

        imagesLoaded($container, function () {
            $container.masonry({
                columnWidth: '.entry-gallery.number2 > li.masonry-helper',
                itemSelector: '.entry-gallery.number2 > li',
                gutter: 0
            }).show().masonry('layout');

            $('.single-post .gallery-loader.number2').hide();
        });
    }

   // 3 time
       var $container = $('.single-post .entry-gallery.number3');

    if ($container !== '') {

        $container.hide();

        imagesLoaded($container, function () {
            $container.masonry({
                columnWidth: '.entry-gallery.number3 > li.masonry-helper',
                itemSelector: '.entry-gallery.number3 > li',
                gutter: 0
            }).show().masonry('layout');

            $('.single-post .gallery-loader.number3').hide();
        });
    }

   // 4 time
       var $container = $('.single-post .entry-gallery.number4');

    if ($container !== '') {

        $container.hide();

        imagesLoaded($container, function () {
            $container.masonry({
                columnWidth: '.entry-gallery.number4 > li.masonry-helper',
                itemSelector: '.entry-gallery.number4 > li',
                gutter: 0
            }).show().masonry('layout');

            $('.single-post .gallery-loader.number4').hide();
        });
    }

   // 5 time
       var $container = $('.single-post .entry-gallery.number5');

    if ($container !== '') {

        $container.hide();

        imagesLoaded($container, function () {
            $container.masonry({
                columnWidth: '.entry-gallery.number5 > li.masonry-helper',
                itemSelector: '.entry-gallery.number5 > li',
                gutter: 0
            }).show().masonry('layout');

            $('.single-post .gallery-loader.number5').hide();
        });
    }

   // 6 time
       var $container = $('.single-post .entry-gallery.number6');

    if ($container !== '') {

        $container.hide();

        imagesLoaded($container, function () {
            $container.masonry({
                columnWidth: '.entry-gallery.number6 > li.masonry-helper',
                itemSelector: '.entry-gallery.number6 > li',
                gutter: 0
            }).show().masonry('layout');

            $('.single-post .gallery-loader.number6').hide();
        });
    }

   // 7 time
       var $container = $('.single-post .entry-gallery.number7');

    if ($container !== '') {

        $container.hide();

        imagesLoaded($container, function () {
            $container.masonry({
                columnWidth: '.entry-gallery.number7 > li.masonry-helper',
                itemSelector: '.entry-gallery.number7 > li',
                gutter: 0
            }).show().masonry('layout');

            $('.single-post .gallery-loader.number7').hide();
        });
    }

   // 8 time
       var $container = $('.single-post .entry-gallery.number8');

    if ($container !== '') {

        $container.hide();

        imagesLoaded($container, function () {
            $container.masonry({
                columnWidth: '.entry-gallery.number8 > li.masonry-helper',
                itemSelector: '.entry-gallery.number8 > li',
                gutter: 0
            }).show().masonry('layout');

            $('.single-post .gallery-loader.number8').hide();
        });
    }

   // 9 time
       var $container = $('.single-post .entry-gallery.number9');

    if ($container !== '') {

        $container.hide();

        imagesLoaded($container, function () {
            $container.masonry({
                columnWidth: '.entry-gallery.number9 > li.masonry-helper',
                itemSelector: '.entry-gallery.number9 > li',
                gutter: 0
            }).show().masonry('layout');

            $('.single-post .gallery-loader.number9').hide();
        });
    }


   // 10 time
       var $container = $('.single-post .entry-gallery.number10');

    if ($container !== '') {

        $container.hide();

        imagesLoaded($container, function () {
            $container.masonry({
                columnWidth: '.entry-gallery.number10 > li.masonry-helper',
                itemSelector: '.entry-gallery.number10 > li',
                gutter: 0
            }).show().masonry('layout');

            $('.single-post .gallery-loader.number10').hide();
        });
    }


    // Single - Slick init
    // ---------------------------------------------
    if ($('.dl-slider-wrapper').length > 0) {

        $('.dl-slider-wrapper').slick({
            infinite: false,
            prevArrow: '<button class="slick-prev" aria-label="Prev"> <span class="icon-links"></span> </button>',
            nextArrow: '<button class="slick-next" aria-label="Next"> <span class="icon-rechts"></span> </button>',
            speed: 300,
            slidesToShow: 4,
            slidesToScroll: 1,
            responsive: [
                {
                    breakpoint: 1280,
                    settings: {
                        slidesToShow: 3,
                        slidesToScroll: 3,
                        infinite: true,
                        dots: true
                    }
                },
                {
                    breakpoint: 940,
                    settings: {
                        slidesToShow: 2,
                        slidesToScroll: 2
                    }
                },
                {
                    breakpoint: 520,
                    settings: {
                        slidesToShow: 1,
                        slidesToScroll: 1
                    }
                }
            ]
        });
    }


    // Wahnbuch - Slick init
    // ---------------------------------------------
    if ($('.entry-slider-wrapper').length > 0) {

        $('.entry-slider-wrapper-slider ').slick({
            infinite: false,
            slidesToShow: 1,
            slidesToScroll: 1,
            arrows: true,
            adaptiveHeight: true,
            prevArrow: '<button class="slick-prev" aria-label="Prev"> <span class="icon-links"></span> </button>',
            nextArrow: '<button class="slick-next" aria-label="Next"> <span class="icon-rechts"></span> </button>',
            fade: true,
            asNavFor: '.entry-slider-nav'
        });

        $('.entry-slider-nav').slick({
            slidesToShow: 4,
            slidesToScroll: 4,
            asNavFor: '.entry-slider-wrapper-slider',
            prevArrow: '<button class="slick-prev" aria-label="Prev"> <span class="icon-links"></span> </button>',
            nextArrow: '<button class="slick-next" aria-label="Next"> <span class="icon-rechts"></span> </button>',
            dots: false,
            infinite: false,
            focusOnSelect: true
        });
    }

    if ($('.single-hw_wahnbuechlein .dienstleister-section-selection').length > 0 || $('.single-hw_lookbook .dienstleister-section-selection').length > 0) {

        $('.dienstleister-section-selection').slick({
            infinite: true,
            prevArrow: '<button class="slick-prev" aria-label="Prev"> <span class="icon-links"></span> </button>',
            nextArrow: '<button class="slick-next" aria-label="Next"> <span class="icon-rechts"></span> </button>',
            speed: 300,
            slidesToShow: 4,
            slidesToScroll: 1,
            responsive: [
                {
                    breakpoint: 1280,
                    settings: {
                        slidesToShow: 3,
                        slidesToScroll: 3,
                        infinite: true
                    }
                },
                {
                    breakpoint: 940,
                    settings: {
                        slidesToShow: 2,
                        slidesToScroll: 2,
                        infinite: true
                    }
                },
                {
                    breakpoint: 520,
                    settings: {
                        slidesToShow: 1,
                        slidesToScroll: 1,
                        infinite: true
                    }
                }
            ]
        });
    }


    // Gallery - Masonry Init
    // ---------------------------------------------
    var $g_container = $('.page-template-template-gallery .entry-gallery');

    if ($g_container !== '') {

        $g_container.hide();

        imagesLoaded($('.page-template-template-gallery'), function () {
            $g_container.masonry({
                columnWidth: 'li.sizer',
                itemSelector: '.entry-gallery > li',
                gutter: 0
            }).show().masonry('layout');

            $('.page-template-template-gallery .gallery-loader').hide();
        });
    }


    // Gallery - Overview Hover
    // ---------------------------------------------
    if ($('.page-template-template-gallery .entry-gallery').length > 0) {
        $('.open-hover').on('click', function () {
            $('.img-hover').not($(this).parent('.img-hover')).removeClass('active');
            $(this).parent('.img-hover').toggleClass('active');
        });

        $('.entry-gallery .img-hover').on('mouseenter', function () {
            $('.img-hover').not($(this).parent('.img-hover')).removeClass('active');
        });
    }


    // Gallery - Single Hover rescue
    // ---------------------------------------------
    $('.single-attachment .entry-content-img').on('click', function () {
        $(this).toggleClass('hovered');
    });


    // Gallery - Ajax Loading
    // ---------------------------------------------
    //if( $('.page-template-template-gallery .entry-gallery').length > 0) {
    //
    //  $('.hfeed.site').append('<div class="modal"></div>');
    //
    //  $('.entry-gallery a').on('click', function(e) {
    //
    //    //e.preventDefault();
    //    //
    //    //loadImageDetails($(this));
    //
    //  });
    //
    //
    //  $('body').not('.modal').on('click', function(){
    //
    //    if( $('body').hasClass('modal-active')) {
    //
    //      $('.modal').removeClass('active');
    //        $('body').removeClass('modal-active');
    //
    //    }
    //
    //  });
    //
    //}
    //
    //function loadImageDetails(elem) {
    //
    //  var imgLink = elem.attr('href');
    //
    //  $('.modal').empty();
    //
    //  $.get(imgLink, function(data) {
    //
    //  var pageContent = $(data).find('main.site-main').get();
    //
    //  $('.modal').prepend(pageContent);
    //
    //  }).done(function() {
    //
    //    $('.modal').addClass('active');
    //      $('body').addClass('modal-active');
    //
    //  });
    //
    //  return false;
    //}
    //

    // Lookbook - Overview
    // ---------------------------------------------
    // var $l_container = $('.lookbook-listing > ul');
    //
    // if($l_container !== '') {
    //   $l_container.masonry({
    //     columnWidth: 'li.sizer',
    //     itemSelector: '.lookbook-listing > ul > li',
    //     gutter: 0
    //   });
    // }


    // Lookbook - Filter
    // ---------------------------------------------
    if ($('.sub-category-nav.lookbook-filter').length > 0) {

        // Open/Close Filters
        $('.sub-category-nav > ul > li').on('click', function (e) {
            $('.sub-category-nav > ul > li > ul').not($(this).children('ul')).removeClass('active');
            if ($(e.target).data('filter')) {
                return false;
            } else {
                $(this).children('ul').toggleClass('active');
            }
        });

        // Close filters on body click
        $('body').on('click', function (e) {
            if ($(e.target).hasClass('filter-title') || $(e.target).hasClass('children') || $(e.target).data('filter')) {
                return false;
            } else {
                $('.sub-category-nav > ul > li > ul').removeClass('active');
            }
        });

        // Submit filters using button click
        $('.sub-category-nav .button.submit').on('click', function (e) {
            e.preventDefault();
            var selectedFilters = '',
                len = $('.sub-category-nav > ul').find('li.active').length;

            $('.sub-category-nav > ul').find('li.active').each(function (i) {
                if (i === len - 1) {
                    selectedFilters = selectedFilters + $(this).data('filter');
                } else {
                    selectedFilters = selectedFilters + $(this).data('filter') + ',';
                }
            });

            if (selectedFilters.length > 0) {
                var newURL = $(this).attr('href') + '?look_filter=' + selectedFilters;
                window.location.href = newURL;
            } else {
                //...error
            }
        });
    }


    // Lookbook - Product Slider
    // ---------------------------------------------
    if ($('.entry-slider-lookbook').length > 0) {

        $('.lookbook-slider').slick({
            slidesToShow: 1,
            slidesToScroll: 1,
            arrows: true,
            prevArrow: '<button class="slick-prev" aria-label="Prev"> <span class="icon-links"></span> </button>',
            nextArrow: '<button class="slick-next" aria-label="Next"> <span class="icon-rechts"></span> </button>',
            fade: true,
            asNavFor: '.lookbook-slider-nav'
        });

        $('.lookbook-slider-nav').slick({
            slidesToShow: 4,
            slidesToScroll: 4,
            asNavFor: '.lookbook-slider',
            prevArrow: '<button class="slick-prev" aria-label="Prev"> <span class="icon-links"></span> </button>',
            nextArrow: '<button class="slick-next" aria-label="Next"> <span class="icon-rechts"></span> </button>',
            dots: false,
            infinite: false,
            focusOnSelect: true
        });
    }


    // Lookbook/Gallery - Mobile Filter Toggle
    // ---------------------------------------------
    if ($('.sub-category-nav.lookbook-filter').length > 0) {
        if (responsive_viewport < 739) {
            $('.sub-category-nav > ul').prepend('<li class="filter-toggle">Filtern</li>');
            $('.sub-category-nav .filter-toggle').on('click', function () {
                $(this).parent('ul').toggleClass('active');
            });
        }
    }
    if ($('.page-template-template-gallery .sub-category-nav').length > 0) {
        if (responsive_viewport < 739) {
            $('.sub-category-nav ').prepend('<span class="filter-toggle">Filtern</span>');
            $('.sub-category-nav .filter-toggle').on('click', function () {
                $(this).parent('nav').toggleClass('active');
            });
        }
    }


    // Footer - Load instagram
    // ---------------------------------------------
    $(window).smartresize(function () {
        loadInstragram();
    });

    function loadInstragram() {
        if ($('.footer-instagram').length === 1) {
            var ajaxUrl = URLData.ajaxurl;
            if (responsive_viewport >= 1024) {
                $.post(
                    ajaxUrl, {
                        action: 'fw_ajax_instagram'
                    },
                    function (response) {
                        $('.footer-instagram').html(response);
                    }
                );
            }
        }
    } loadInstragram();


    //    // Footer - Dynamic To Top
    //    // ---------------------------------------------
    //    $(window).on('scroll', function(){
    //        if( $(window).scrollTop() > 990 ) {
    //            $('.to-top-btn').addClass('active');
    //        } else {
    //            $('.to-top-btn').removeClass('active');
    //        }
    //        if ( ($('.site-footer').offset().top - $(window).scrollTop()) < 900 ) {
    //            $('.to-top-btn').addClass('sticky');
    //        } else {
    //            $('.to-top-btn').removeClass('sticky');
    //        }
    //    });
});
